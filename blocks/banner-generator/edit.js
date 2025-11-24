/**
 * Banner Generator Block - Editor Component
 * Version: 3.0.0
 */

(function() {
    'use strict';

    console.log('[SEO Image Block] Script loading...');

    // Check if WordPress block editor is available
    if (!wp || !wp.blocks) {
        console.error('[SEO Image Block] WordPress blocks API not available');
        return;
    }

    console.log('[SEO Image Block] WordPress APIs detected');

    const { __ } = wp.i18n;
    const { createElement: el, useState } = wp.element;
    const { TextControl, TextareaControl, SelectControl, Button, Placeholder, Spinner, PanelBody } = wp.components;
    const { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
    const $ = window.jQuery;

    wp.blocks.registerBlockType('banner-generator/banner-block', {
        title: __('SEO Image', 'banner-generator'),
        description: __('Generate SEO-optimized images with customizable text, logos, and design templates', 'banner-generator'),
        icon: 'format-image',
        category: 'media',
        attributes: {
            attachmentId: {
                type: 'number',
                default: 0
            },
            imageUrl: {
                type: 'string',
                default: ''
            },
            previewUrl: {
                type: 'string',
                default: ''
            },
            title: {
                type: 'string',
                default: ''
            },
            keyword: {
                type: 'string',
                default: ''
            },
            category: {
                type: 'string',
                default: ''
            },
            description: {
                type: 'string',
                default: ''
            },
            logoUrl: {
                type: 'string',
                default: ''
            },
            logoId: {
                type: 'number',
                default: 0
            },
            style: {
                type: 'string',
                default: 'tech'
            },
            pattern: {
                type: 'string',
                default: 'none'
            },
            fontFamily: {
                type: 'string',
                default: 'Inter'
            },
            altText: {
                type: 'string',
                default: ''
            }
        },

        edit: function(props) {
            const { attributes, setAttributes } = props;
            const { imageUrl, previewUrl, title, keyword, category, description, logoUrl, logoId, style, pattern, fontFamily, altText } = attributes;

            const [isGenerating, setIsGenerating] = useState(false);
            const [isSaving, setIsSaving] = useState(false);
            const [error, setError] = useState('');

            const generatePreview = function() {
                if (!title || !keyword) {
                    setError(__('Title and Keyword are required', 'banner-generator'));
                    return;
                }

                setIsGenerating(true);
                setError('');

                // Step 1: Get HTML from server
                $.post(bannerGeneratorBlock.ajaxurl, {
                    action: 'get_banner_html',
                    nonce: bannerGeneratorBlock.nonce,
                    title: title,
                    category: category,
                    description: description,
                    logo_url: logoUrl,
                    style: style,
                    pattern: pattern,
                    font_family: fontFamily
                }, function(response) {
                    if (!response.success) {
                        setError(response.data || 'Failed to generate HTML');
                        setIsGenerating(false);
                        return;
                    }

                    const html = response.data.html;
                    const container = document.createElement('div');
                    container.style.position = 'absolute';
                    container.style.left = '-9999px';
                    container.style.top = '-9999px';
                    container.innerHTML = html;
                    document.body.appendChild(container);

                    const bannerElement = container.querySelector('.banner');
                    if (!bannerElement) {
                        setError('Banner element not found in HTML');
                        setIsGenerating(false);
                        document.body.removeChild(container);
                        return;
                    }

                    const waitTime = logoUrl ? 3000 : 1500;
                    setTimeout(function() {
                        if (typeof html2canvas === 'undefined') {
                            setError('html2canvas library not loaded');
                            setIsGenerating(false);
                            document.body.removeChild(container);
                            return;
                        }

                        html2canvas(bannerElement, {
                            scale: 2,
                            useCORS: true,
                            allowTaint: false,
                            backgroundColor: null,
                            logging: false
                        }).then(function(canvas) {
                            document.body.removeChild(container);
                            const imageData = canvas.toDataURL('image/webp', 0.88);

                            // Save preview (not to media library yet)
                            setAttributes({ previewUrl: imageData });
                            setIsGenerating(false);
                        }).catch(function(err) {
                            document.body.removeChild(container);
                            setError(err.message || 'Error capturing banner');
                            setIsGenerating(false);
                        });
                    }, waitTime);

                }).fail(function() {
                    setError('Network error occurred');
                    setIsGenerating(false);
                });
            };

            const saveToMediaLibrary = function() {
                if (!previewUrl) {
                    setError(__('Please generate a preview first', 'banner-generator'));
                    return;
                }

                setIsSaving(true);
                setError('');

                // Save to media library
                $.post(bannerGeneratorBlock.ajaxurl, {
                    action: 'generate_banner',
                    nonce: bannerGeneratorBlock.nonce,
                    title: title,
                    keyword: keyword,
                    category: category,
                    description: description,
                    style: style,
                    pattern: pattern,
                    font_family: fontFamily,
                    image_data: previewUrl
                }, function(response) {
                    if (!response.success) {
                        setError(response.data || 'Failed to save banner');
                        setIsSaving(false);
                        return;
                    }

                    setAttributes({
                        imageUrl: response.data.url,
                        attachmentId: response.data.attachment_id,
                        altText: response.data.alt_text,
                        previewUrl: '' // Clear preview after saving
                    });

                    setIsSaving(false);
                }).fail(function() {
                    setError('Network error occurred');
                    setIsSaving(false);
                });
            };

            const removeBanner = function() {
                setAttributes({
                    imageUrl: '',
                    attachmentId: 0,
                    altText: '',
                    previewUrl: ''
                });
            };

            const blockProps = useBlockProps({
                className: 'banner-generator-block-editor'
            });

            // If image is saved to media library, show final state
            if (imageUrl) {
                return el('div', blockProps, [
                    el(InspectorControls, { key: 'inspector' },
                        el('div', { style: { padding: '16px' } }, [
                            el('p', { key: 'msg' }, __('Image saved to Media Library!', 'banner-generator')),
                            el(Button, {
                                key: 'remove',
                                onClick: removeBanner,
                                isDestructive: true,
                                style: { marginTop: '12px' }
                            }, __('Remove & Start Over', 'banner-generator'))
                        ])
                    ),
                    el('img', {
                        key: 'image',
                        src: imageUrl,
                        alt: altText || title,
                        style: { maxWidth: '100%', height: 'auto', display: 'block', borderRadius: '2px', boxShadow: '0 2px 8px rgba(0,0,0,0.1)' }
                    })
                ]);
            }

            // Configuration & preview state
            return el('div', blockProps, [
                el(InspectorControls, { key: 'inspector' }, [
                    el(PanelBody, {
                        key: 'content',
                        title: __('Image Content', 'banner-generator'),
                        initialOpen: true
                    }, [
                        el(TextControl, {
                            key: 'category',
                            label: __('Label', 'banner-generator'),
                            value: category,
                            onChange: (value) => setAttributes({ category: value }),
                            help: __('Small text above headline', 'banner-generator')
                        }),
                        el(TextControl, {
                            key: 'title',
                            label: __('Title (Required)', 'banner-generator'),
                            value: title,
                            onChange: (value) => setAttributes({ title: value }),
                            placeholder: __('Enter image title', 'banner-generator')
                        }),
                        el(TextControl, {
                            key: 'keyword',
                            label: __('SEO Keyword (Required)', 'banner-generator'),
                            value: keyword,
                            onChange: (value) => setAttributes({ keyword: value }),
                            placeholder: __('seo-keyword', 'banner-generator'),
                            help: __('Used for filename generation', 'banner-generator')
                        }),
                        el(TextareaControl, {
                            key: 'description',
                            label: __('Description', 'banner-generator'),
                            value: description,
                            onChange: (value) => setAttributes({ description: value }),
                            rows: 3
                        })
                    ]),
                    el(PanelBody, {
                        key: 'logo',
                        title: __('Overlay Image', 'banner-generator'),
                        initialOpen: false
                    },
                        el(MediaUploadCheck, { key: 'media-check' },
                            el(MediaUpload, {
                                onSelect: (media) => setAttributes({ logoUrl: media.url, logoId: media.id }),
                                allowedTypes: ['image'],
                                value: logoId,
                                render: function({ open }) {
                                    if (logoUrl) {
                                        return el('div', {}, [
                                            el('img', {
                                                key: 'img',
                                                src: logoUrl,
                                                alt: 'Overlay Image',
                                                style: { maxWidth: '100%', maxHeight: '150px', marginBottom: '10px', display: 'block' }
                                            }),
                                            el('div', { key: 'buttons', style: { display: 'flex', gap: '8px' } }, [
                                                el(Button, {
                                                    key: 'change',
                                                    onClick: open,
                                                    variant: 'secondary'
                                                }, __('Change Image', 'banner-generator')),
                                                el(Button, {
                                                    key: 'remove',
                                                    onClick: () => setAttributes({ logoUrl: '', logoId: 0 }),
                                                    isDestructive: true
                                                }, __('Remove', 'banner-generator'))
                                            ])
                                        ]);
                                    }
                                    return el(Button, {
                                        onClick: open,
                                        variant: 'primary'
                                    }, __('Select Image', 'banner-generator'));
                                }
                            })
                        )
                    ),
                    el(PanelBody, {
                        key: 'design',
                        title: __('Design Style', 'banner-generator'),
                        initialOpen: false
                    }, [
                        el(SelectControl, {
                            key: 'style',
                            label: __('Image Style', 'banner-generator'),
                            value: style,
                            options: [
                                { label: __('Modern Tech', 'banner-generator'), value: 'tech' },
                                { label: __('Corporate Professional', 'banner-generator'), value: 'corporate' },
                                { label: __('Clean Minimal', 'banner-generator'), value: 'minimal' },
                                { label: __('Editorial Document', 'banner-generator'), value: 'document' }
                            ],
                            onChange: (value) => setAttributes({ style: value })
                        }),
                        el(SelectControl, {
                            key: 'pattern',
                            label: __('Background Pattern', 'banner-generator'),
                            value: pattern,
                            options: [
                                { label: __('None', 'banner-generator'), value: 'none' },
                                { label: __('Grid', 'banner-generator'), value: 'grid' },
                                { label: __('Dots', 'banner-generator'), value: 'dots' }
                            ],
                            onChange: (value) => setAttributes({ pattern: value })
                        }),
                        el(SelectControl, {
                            key: 'font',
                            label: __('Font Family', 'banner-generator'),
                            value: fontFamily,
                            options: [
                                { label: 'Inter', value: 'Inter' },
                                { label: 'Poppins', value: 'Poppins' },
                                { label: 'Roboto', value: 'Roboto' }
                            ],
                            onChange: (value) => setAttributes({ fontFamily: value })
                        })
                    ])
                ]),
                previewUrl ? el('div', { key: 'preview' }, [
                    error && el('div', {
                        key: 'error',
                        style: {
                            color: '#d63638',
                            marginBottom: '12px',
                            padding: '8px 12px',
                            backgroundColor: '#fcf0f1',
                            border: '1px solid #f0b8b8',
                            borderRadius: '2px'
                        }
                    }, error),
                    el('img', {
                        key: 'preview-img',
                        src: previewUrl,
                        alt: 'Preview',
                        style: {
                            maxWidth: '100%',
                            height: 'auto',
                            display: 'block',
                            borderRadius: '2px',
                            boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
                            marginBottom: '12px'
                        }
                    }),
                    el('div', {
                        key: 'actions',
                        style: { display: 'flex', gap: '8px', flexWrap: 'wrap' }
                    }, [
                        el(Button, {
                            key: 'save',
                            onClick: saveToMediaLibrary,
                            variant: 'primary',
                            isBusy: isSaving,
                            disabled: isSaving || isGenerating
                        }, isSaving ? __('Saving...', 'banner-generator') : __('Save to Media Library & Insert', 'banner-generator')),
                        el(Button, {
                            key: 'regenerate',
                            onClick: generatePreview,
                            variant: 'secondary',
                            disabled: isSaving || isGenerating
                        }, __('Regenerate', 'banner-generator')),
                        el(Button, {
                            key: 'cancel',
                            onClick: () => setAttributes({ previewUrl: '' }),
                            isDestructive: true,
                            disabled: isSaving || isGenerating
                        }, __('Cancel', 'banner-generator'))
                    ])
                ]) : el(Placeholder, {
                    key: 'placeholder',
                    icon: 'format-image',
                    label: __('SEO Image Generator', 'banner-generator'),
                    instructions: __('Configure settings and generate preview', 'banner-generator')
                }, [
                    el('div', {
                        key: 'hint',
                        style: {
                            padding: '12px',
                            marginBottom: '16px',
                            backgroundColor: '#f0f6fc',
                            border: '1px solid #0783be',
                            borderRadius: '2px',
                            fontSize: '13px',
                            lineHeight: '1.6'
                        }
                    }, [
                        el('strong', { key: 'title' }, '👉 ' + __('Open the sidebar', 'banner-generator')),
                        el('br', { key: 'br' }),
                        __('Configure your image settings in the right sidebar panel, then generate a preview here.', 'banner-generator')
                    ]),
                    error && el('div', {
                        key: 'error',
                        style: {
                            color: '#d63638',
                            marginBottom: '12px',
                            padding: '8px 12px',
                            backgroundColor: '#fcf0f1',
                            border: '1px solid #f0b8b8',
                            borderRadius: '2px'
                        }
                    }, error),
                    isGenerating ? el('div', {
                        key: 'generating',
                        style: { display: 'flex', alignItems: 'center', gap: '8px', justifyContent: 'center' }
                    }, [
                        el(Spinner, { key: 'spinner' }),
                        el('span', { key: 'text' }, __('Generating preview...', 'banner-generator'))
                    ]) : el(Button, {
                        key: 'button',
                        variant: 'primary',
                        onClick: generatePreview,
                        disabled: !title || !keyword
                    }, __('Generate Preview', 'banner-generator')),
                    (!title || !keyword) && el('div', {
                        key: 'warning',
                        style: { marginTop: '12px', fontSize: '13px', color: '#757575' }
                    }, __('⚠ Title and Keyword are required', 'banner-generator'))
                ])
            ]);
        },

        save: function(props) {
            const { attributes } = props;
            const { imageUrl, altText, title, attachmentId } = attributes;

            if (!imageUrl) {
                return null;
            }

            // Use WordPress standard image block classes for better theme compatibility
            return el('figure', {
                className: 'wp-block-image'
            },
                el('img', {
                    src: imageUrl,
                    alt: altText || title || 'Generated banner',
                    className: 'wp-image-' + attachmentId,
                    loading: 'lazy',
                    decoding: 'async'
                })
            );
        }
    });

    console.log('[SEO Image Block] Block registered successfully');
})();
