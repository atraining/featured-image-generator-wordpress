jQuery(document).ready(function($) {
    console.log('Banner Generator admin.js loaded');

    let currentBannerData = null;
    let currentFormData = null;

    // Banner generation form with html2canvas
    $('#banner-generator-form').on('submit', function(e) {
        console.log('Form submit intercepted');
        e.preventDefault();
        generateBanner();
    });

    // Generate banner (preview only)
    function generateBanner() {
        const form = $('#banner-generator-form');
        const submitBtn = form.find('button[type="submit"]');
        const spinner = form.find('.spinner');

        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.addClass('is-active');

        // Get form data
        currentFormData = {
            title: $('#title').val(),
            keyword: $('#keyword').val(),
            category: $('#category').val(),
            description: $('#description').val(),
            logo_url: $('#logo_url').val(),
            style: $('#style').val(),
            pattern: $('#pattern').val(),
            font_family: $('#font_family').val()
        };

        // Step 1: Get HTML from server
        $.post(bannerGeneratorAjax.ajaxurl, {
            action: 'get_banner_html',
            nonce: bannerGeneratorAjax.nonce,
            ...currentFormData
        }, function(response) {
            if (!response.success) {
                submitBtn.prop('disabled', false);
                spinner.removeClass('is-active');
                showNotice('Error generating HTML: ' + response.data, 'error');
                return;
            }

            // Step 2: Render HTML in hidden container
            const container = $('#banner-html-container');
            container.html(response.data.html);

            // Debug: Check if logo image exists
            const logoImgCheck = container.find('.logo-image');
            if (logoImgCheck.length > 0) {
                console.log('Logo image element found. URL:', logoImgCheck.attr('src'));
            } else {
                console.log('No logo image element found (emoji fallback will be used)');
            }

            // Function to capture banner
            function captureBanner() {
                const bannerElement = container.find('.banner')[0];
                console.log('Starting html2canvas capture...');

                // Check if html2canvas is available
                if (typeof html2canvas === 'undefined') {
                    submitBtn.prop('disabled', false);
                    spinner.removeClass('is-active');
                    showNotice('html2canvas library not loaded. Please refresh the page.', 'error');
                    return;
                }

                html2canvas(bannerElement, {
                    width: 1280,
                    height: 720,
                    scale: 2,
                    useCORS: true,
                    allowTaint: false,
                    backgroundColor: '#ffffff',
                    logging: false,
                    onclone: function(clonedDoc) {
                        // Check if logo exists in cloned document
                        const clonedLogo = clonedDoc.querySelector('.logo-image');
                        if (clonedLogo) {
                            console.log('Logo found in cloned document:', clonedLogo.src);
                            console.log('Logo dimensions:', clonedLogo.width, 'x', clonedLogo.height);
                            console.log('Logo complete:', clonedLogo.complete);
                        }
                    }
                }).then(function(canvas) {
                    console.log('html2canvas completed successfully');

                    // Step 4: Convert to WebP with compression (quality: 0.88 = ~50-80KB)
                    const imageData = canvas.toDataURL('image/webp', 0.88);

                    submitBtn.prop('disabled', false);
                    spinner.removeClass('is-active');

                    // Show preview without saving
                    showBannerPreview(imageData);

                }).catch(function(error) {
                    submitBtn.prop('disabled', false);
                    spinner.removeClass('is-active');
                    console.error('html2canvas error:', error);
                    showNotice('Error capturing banner: ' + error.message, 'error');
                });
            }

            // Wait for images to load before capturing
            const logoImg = container.find('.logo-image');
            if (logoImg.length > 0) {
                const imgElement = logoImg[0];

                // Add load/error handlers
                $(imgElement).on('load', function() {
                    console.log('Logo loaded successfully, dimensions:', this.naturalWidth, 'x', this.naturalHeight);
                }).on('error', function() {
                    console.error('Logo failed to load. URL:', this.src);
                });

                // Wait for image to load or timeout
                if (imgElement.complete && imgElement.naturalWidth > 0) {
                    console.log('Logo already loaded from cache');
                    setTimeout(captureBanner, 1500); // Wait for fonts
                } else {
                    console.log('Waiting for logo to load...');
                    setTimeout(captureBanner, 3000); // Wait longer for external image
                }
            } else {
                // No logo, just wait for fonts
                setTimeout(captureBanner, 1500);
            }

        }).fail(function() {
            submitBtn.prop('disabled', false);
            spinner.removeClass('is-active');
            showNotice('Network error occurred. Please try again.', 'error');
        });
    }

    // Show banner preview (before saving)
    function showBannerPreview(imageData) {
        const previewSection = $('.banner-preview-section');
        const previewImage = $('#banner-preview-image');

        // Store current banner data
        currentBannerData = imageData;

        // Create image element
        const img = $('<img>', {
            src: imageData,
            alt: 'Generated Banner Preview',
            style: 'max-width: 100%; height: auto; border-radius: 4px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);'
        });

        // Clear previous content and add image
        previewImage.empty().append(img);

        // Show "Save to Media Library" button, hide others
        $('#save-to-library').show();
        $('#view-in-library').hide();
        $('#banner-info-saved').hide();

        // Show preview section
        previewSection.show();

        // Scroll to preview
        $('html, body').animate({
            scrollTop: previewSection.offset().top - 50
        }, 500);
    }

    // Save to Media Library
    $('#save-to-library').on('click', function() {
        if (!currentBannerData || !currentFormData) {
            showNotice('Please generate a banner first.', 'error');
            return;
        }

        const btn = $(this);
        const spinner = $('.banner-actions .spinner');

        btn.prop('disabled', true);
        spinner.addClass('is-active');

        // Send to server to save
        $.post(bannerGeneratorAjax.ajaxurl, {
            action: 'generate_banner',
            nonce: bannerGeneratorAjax.nonce,
            ...currentFormData,
            image_data: currentBannerData
        }, function(response) {
            btn.prop('disabled', false);
            spinner.removeClass('is-active');

            if (response.success) {
                // Update display with saved info
                $('#banner-filename').text(response.data.filename);
                $('#banner-url-display').text(response.data.url);
                $('#banner-url-link').attr('href', response.data.url);

                // Show saved info, hide save button
                $('#save-to-library').hide();
                $('#view-in-library').show().data('attachment-id', response.data.attachment_id);
                $('#banner-info-saved').show();

                showNotice('✓ Banner saved to Media Library successfully!', 'success');
            } else {
                showNotice('Error saving banner: ' + response.data, 'error');
            }
        }).fail(function() {
            btn.prop('disabled', false);
            spinner.removeClass('is-active');
            showNotice('Network error occurred. Please try again.', 'error');
        });
    });

    // Regenerate banner
    $('#regenerate-banner').on('click', function() {
        generateBanner();
    });

    // View in media library
    $('#view-in-library').on('click', function() {
        const attachmentId = $(this).data('attachment-id');
        if (attachmentId) {
            window.open('/wp-admin/post.php?post=' + attachmentId + '&action=edit', '_blank');
        }
    });

    // Show notice
    function showNotice(message, type) {
        const noticeClass = type === 'success' ? 'notice-success' : 'notice-error';
        const notice = $('<div class="notice ' + noticeClass + ' is-dismissible"><p>' + message + '</p></div>');

        $('.wrap h1').after(notice);

        setTimeout(function() {
            notice.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }
});
