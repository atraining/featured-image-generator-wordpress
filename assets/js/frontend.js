jQuery(document).ready(function($) {
    
    // Track banner views when images are loaded
    $('img[src*="banner-generator"]').on('load', function() {
        const imageUrl = $(this).attr('src');
        if (imageUrl && imageUrl.includes('banner-generator')) {
            trackBannerView(imageUrl);
        }
    });
    
    // Track banner views for existing images
    $('img[src*="banner-generator"]').each(function() {
        const imageUrl = $(this).attr('src');
        if (imageUrl && imageUrl.includes('banner-generator')) {
            trackBannerView(imageUrl);
        }
    });
    
    // Function to track banner view
    function trackBannerView(imageUrl) {
        // Only track once per session per image
        const trackedKey = 'banner_tracked_' + btoa(imageUrl).replace(/[^a-zA-Z0-9]/g, '');
        if (sessionStorage.getItem(trackedKey)) {
            return;
        }
        
        // Mark as tracked
        sessionStorage.setItem(trackedKey, 'true');
        
        // Send tracking request
        $.post(bannerGeneratorAjax.ajaxurl, {
            action: 'track_banner_view',
            nonce: bannerGeneratorAjax.nonce,
            image_url: imageUrl
        }, function(response) {
            // Optional: Log tracking success
            console.log('Banner view tracked:', imageUrl);
        }).fail(function() {
            // Optional: Log tracking failure
            console.log('Failed to track banner view:', imageUrl);
        });
    }
    
    // Track banner views for dynamically loaded content
    $(document).on('load', 'img[src*="banner-generator"]', function() {
        const imageUrl = $(this).attr('src');
        if (imageUrl && imageUrl.includes('banner-generator')) {
            trackBannerView(imageUrl);
        }
    });
}); 