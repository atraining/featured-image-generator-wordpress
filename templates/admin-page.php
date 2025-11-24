<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1>Banner Generator</h1>
    
    <div class="banner-generator-container">
        <!-- Banner Generation Form -->
        <div class="banner-form-section">
            <h2>Generate New Banner</h2>
            <form id="banner-generator-form">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="category">Label</label>
                        </th>
                        <td>
                            <input type="text" id="category" name="category" class="regular-text" placeholder="e.g., Intelligent Document Processing">
                            <p class="description">Small text displayed above the headline (optional)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="title">Title *</label>
                        </th>
                        <td>
                            <input type="text" id="title" name="title" class="regular-text" required placeholder="e.g., ABBYY">
                            <p class="description">The main title displayed on the banner</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="keyword">Keyword (for filename) *</label>
                        </th>
                        <td>
                            <input type="text" id="keyword" name="keyword" class="regular-text" required placeholder="e.g., abbyy-document-processing">
                            <p class="description">Used to generate SEO-friendly filename (will be slugified)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="description">Tagline</label>
                        </th>
                        <td>
                            <textarea id="description" name="description" class="large-text" rows="3" placeholder="e.g., Industry-leading OCR and document AI"></textarea>
                            <p class="description">Optional description/description (used for alt text)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="logo_url">Overlay Image URL (optional)</label>
                        </th>
                        <td>
                            <input type="url" id="logo_url" name="logo_url" class="regular-text" placeholder="https://example.com/image.png">
                            <p class="description">Direct URL to an image (logo, icon, etc.) that will be displayed on the banner</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="style">Image Style</label>
                        </th>
                        <td>
                            <select id="style" name="style">
                                <option value="tech">Modern Tech</option>
                                <option value="corporate">Corporate Professional</option>
                                <option value="minimal">Clean Minimal</option>
                                <option value="document">Document-themed</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="pattern">Background Pattern</label>
                        </th>
                        <td>
                            <select id="pattern" name="pattern">
                                <option value="none">No Pattern</option>
                                <option value="grid">Grid</option>
                                <option value="dots">Dots</option>
                                <option value="diagonal">Diagonal Stripes</option>
                                <option value="zigzag">Chevron</option>
                                <option value="circuit">Tech Circuit</option>
                                <option value="hexagon">Hexagons</option>
                                <option value="waves">Horizontal Lines</option>
                            </select>
                            <p class="description">Decorative pattern for the right side background</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="font_family">Font</label>
                        </th>
                        <td>
                            <select id="font_family" name="font_family">
                                <option value="Inter">Inter (Default)</option>
                                <option value="Poppins">Poppins</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Roboto">Roboto</option>
                                <option value="Open Sans">Open Sans</option>
                                <option value="Work Sans">Work Sans</option>
                                <option value="Playfair Display">Playfair Display</option>
                                <option value="JetBrains Mono">JetBrains Mono (Code)</option>
                                <option value="Roboto Mono">Roboto Mono (Code)</option>
                            </select>
                            <p class="description">Choose font for banner text (monospace fonts work great for tech/code style)</p>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <button type="submit" class="button button-primary">Generate Banner</button>
                    <span class="spinner" style="float: none; margin-left: 10px;"></span>
                </p>
            </form>
        </div>
        
        <!-- Hidden HTML Container for html2canvas -->
        <div id="banner-html-container" style="position:absolute; left:-10000px; top:0; width:1280px; height:720px; pointer-events:none; overflow:hidden;"></div>

        <!-- Generated Banner Preview -->
        <div class="banner-preview-section" style="display: none;">
            <h2>Generated Banner Preview</h2>
            <div class="banner-preview">
                <div id="banner-preview-image"></div>
                <div class="banner-actions">
                    <button type="button" class="button button-primary" id="save-to-library" style="display: none;">
                        <span class="dashicons dashicons-download" style="margin-top: 3px;"></span> Save to Media Library
                    </button>
                    <button type="button" class="button button-primary" id="view-in-library" style="display: none;">
                        <span class="dashicons dashicons-admin-media" style="margin-top: 3px;"></span> View in Media Library
                    </button>
                    <button type="button" class="button" id="regenerate-banner">
                        <span class="dashicons dashicons-image-rotate" style="margin-top: 3px;"></span> Regenerate
                    </button>
                    <span class="spinner" style="float: none; margin-left: 10px;"></span>
                </div>
                <div class="banner-info" id="banner-info-saved" style="display: none; margin-top: 15px; text-align: left; background: #d4edda; padding: 15px; border-radius: 4px; border-left: 4px solid #28a745;">
                    <p style="margin: 0;"><strong>✓ Saved to Media Library</strong></p>
                    <p style="margin: 10px 0 0 0;"><strong>Filename:</strong> <span id="banner-filename"></span></p>
                    <p style="margin: 5px 0 0 0;"><strong>URL:</strong> <a href="#" id="banner-url-link" target="_blank"><span id="banner-url-display"></span></a></p>
                </div>
            </div>
        </div>
        
        <!-- How It Works -->
        <div class="api-docs-section">
            <h2>How It Works</h2>
            <p>The Banner Generator creates professional WebP featured images using html2canvas for pixel-perfect quality:</p>

            <h3>📋 Two-Step Workflow:</h3>
            <ol>
                <li><strong>Generate:</strong> Fill in the form and click "Generate Banner"
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <li>System renders HTML banner with professional CSS styling</li>
                        <li>html2canvas captures it as high-quality WebP image</li>
                        <li>Preview shown instantly - <em>not saved yet</em></li>
                    </ul>
                </li>
                <li><strong>Save:</strong> If happy with preview, click "Save to Media Library"
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <li>Saves to WordPress Media Library with SEO-optimized filename</li>
                        <li>Proper metadata: title, description, alt text</li>
                        <li>Can regenerate if not satisfied before saving</li>
                    </ul>
                </li>
            </ol>

            <h3>🎨 Available Styles:</h3>
            <ul>
                <li><strong>Modern Tech:</strong> Dark slate gradient with blue-green gradient text</li>
                <li><strong>Corporate Professional:</strong> Purple gradient with glassmorphism effects</li>
                <li><strong>Clean Minimal:</strong> Light background with Swiss design aesthetics</li>
                <li><strong>Document-themed:</strong> Professional white/green for business content</li>
            </ul>

            <h3>⚡ Technical Features:</h3>
            <ul>
                <li><strong>Format:</strong> WebP (94% browser support, 50% smaller than JPEG)</li>
                <li><strong>Quality:</strong> 88% compression = ~50-80KB file size</li>
                <li><strong>Resolution:</strong> 1280×720 @ 2x scale (retina ready)</li>
                <li><strong>Filename:</strong> SEO-friendly with readable dates (e.g., <code>keyword-2025-01-21-1430.webp</code>)</li>
                <li><strong>Metadata:</strong> Auto-populated title, description, and alt text from form</li>
            </ul>

            <h3>✨ Benefits:</h3>
            <ul>
                <li>✅ <strong>Perfect quality</strong> - Uses actual HTML/CSS rendering, not screenshots</li>
                <li>✅ <strong>Browser-based</strong> - No server processing, instant generation</li>
                <li>✅ <strong>Optimized files</strong> - WebP format for fast page loads (~50-80KB)</li>
                <li>✅ <strong>SEO-friendly</strong> - Descriptive filenames, proper alt text, fast loading</li>
                <li>✅ <strong>User control</strong> - Preview before saving, regenerate as needed</li>
                <li>✅ <strong>Professional designs</strong> - 4 curated styles optimized for blog posts</li>
            </ul>

            <h3>💡 Tips:</h3>
            <ul>
                <li>Use descriptive <strong>keywords</strong> for better SEO (e.g., "document-ai-platform")</li>
                <li>Keep <strong>titles short</strong> (1-3 words) for better visual impact</li>
                <li>Add a compelling <strong>description</strong> to increase engagement</li>
                <li>Choose a <strong>style</strong> that matches your brand/content tone</li>
            </ul>
        </div>
    </div>
</div>

<style>
.banner-generator-container {
    max-width: 1200px;
}

.banner-form-section,
.banner-preview-section,
.api-docs-section {
    background: white;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #ccd0d4;
    border-radius: 4px;
}

.banner-preview {
    text-align: center;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 4px;
}

.banner-actions {
    margin-top: 15px;
}

.banner-actions .button {
    margin: 0 5px;
}

.spinner {
    display: none;
}

.spinner.is-active {
    display: inline-block;
}
</style> 