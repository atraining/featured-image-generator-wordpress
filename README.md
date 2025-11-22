# SEO optimized Image Generator WordPress Plugin | ZERO AI

A powerful WordPress plugin for generating professional 1280×720 WebP featured images with customizable text, logos, and multiple design templates. **SEO-optimized and production-ready!**

Read more: How to [generate good SEO-images](https://wise-relations.com/wordpress-plug-in-featured-images-automatisch-erstellen/)

## Installation

[Download ZIP and upload as normal WordPress Plugin](https://github.com/atraining/featured-image-generator-wordpress/archive/refs/heads/main.zip)

[YouTube Tutorial](https://www.youtube.com/watch?v=n4zQWi2sEg0)

## Look and feel after installation

<img width="1728" height="1590" alt="HFAEEL5mXs" src="https://github.com/user-attachments/assets/06ccddb1-f40e-45af-9db5-bc2ead672691" />

![msedge_FjJXfe8IgD](https://github.com/user-attachments/assets/2e9dea46-f35b-4e91-867e-ab61233acd26)


## Features

- **4 Professional Templates**: Modern Tech, Corporate Professional, Clean Minimal, and Editorial Document styles
- **Client-Side Image Generation**: Uses html2canvas to generate high-quality WebP images (~50-80KB)
- **SEO-Optimized**: Descriptive filenames, proper alt text, and optimized file sizes for fast loading
- **Flexible Customization**: Custom titles, categories, descriptions, logos, patterns, and 9 font options
- **Media Library Integration**: Automatically saves generated banners to WordPress media library
- **Smart Layout**: Content area expands when no logo is present
- **Pattern Library**: 8 background patterns (grid, dots, diagonal, zigzag, circuit, hexagon, waves, none)
- **Glass Morphism Effects**: Modern semi-transparent content boxes with backdrop blur
- **No Server Dependencies**: Works on any hosting without GD library or ImageMagick

## Example Banners

### Modern Tech Style
![Modern Tech Banner](https://christopher-helm.com/wp-content/uploads/2025/11/ki-halluzinationen-2025-11-22-0009.webp)
*Dark gradient with neon cyan/magenta accents and glass morphism effects*

### Corporate Professional Style
![Corporate Banner](https://christopher-helm.com/wp-content/uploads/2025/11/schulung-von-mitarbeitern-mit-ki-2025-11-22-0004.webp)
*Navy blue with gold accents, structured and authoritative*

### Clean Minimal Style
![Minimal Banner](https://christopher-helm.com/wp-content/uploads/2025/11/vibe-coding-2025-11-22-0015-1024x576.webp)
*Pure white with black text and bold red accents, Swiss/Bauhaus inspired*

### Editorial Document Style
![Document Banner](https://christopher-helm.com/wp-content/uploads/2025/11/vibe-coding-2025-11-22-0018.webp)
*Warm cream tones with professional editorial layout*

## Installation

1. Upload the `banner-generator` folder to your `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Access the plugin via 'Banner Generator' in the admin menu

## Usage

### Admin Interface

1. Go to **Banner Generator** in your WordPress admin menu
2. Fill in the fields:
   - **Title** (required): Main headline text
   - **Category** (optional): Subtitle/category label
   - **Description** (optional): Supporting text with corner bracket decoration
   - **Logo URL** (optional): URL to logo image (WordPress media library or external)
   - **Style**: Choose from 4 templates (Tech, Corporate, Minimal, Document)
   - **Pattern**: Select background pattern (8 options + none)
   - **Font Family**: Choose from 9 fonts including monospace options
3. Click "Generate Banner" to preview
4. Click "Save to Media Library" to save as WebP file
5. View saved banner in WordPress Media Library

## SEO Features & Specialties

### Optimized File Format
- **WebP format** with 88% quality (~50-80KB file size)
- Fast loading times improve page speed and SEO rankings
- High-quality output suitable for featured images and social sharing

### SEO-Friendly Filenames
Banners are saved with descriptive, readable filenames:
```
banner-your-article-title-2024-01-15-123456.webp
```
- Uses actual title text (not random hashes)
- Includes timestamp for uniqueness
- Lowercase with hyphens (SEO best practice)
- No special characters or spaces

### Proper Alt Text
Each banner includes:
- Alt text derived from title for accessibility
- Proper metadata for WordPress media library
- Descriptive file information for search engines

### Performance Optimization
- **Small file sizes** (50-80KB) don't slow down page load
- **2x scale rendering** (2560×1440) downscaled to 1280×720 for crisp quality
- **Client-side generation** doesn't burden server resources
- **No external API calls** - everything happens locally

### Social Media Ready
- **1280×720 dimensions** perfect for:
  - Facebook featured images
  - Twitter cards
  - LinkedIn posts
  - Blog post headers
  - Open Graph images

### Customization for Keyword Optimization
- **Title field**: Include target keywords in main headline
- **Category field**: Add niche/industry terms
- **Description field**: Supporting text with secondary keywords
- Multiple font options to match brand identity

## Technical Details

### Image Generation Process

1. **HTML Rendering**: Template loads with user data in hidden container
2. **Font Loading**: Google Fonts preloaded with 1.5-3 second wait
3. **Canvas Capture**: html2canvas renders at 2x scale (2560×1440)
4. **WebP Conversion**: Canvas exported as WebP with 88% quality
5. **Media Upload**: Image data sent to server via AJAX
6. **File Storage**: Saved to WordPress uploads directory with proper metadata

### Template Architecture

Each template is a standalone PHP file in `/templates/`:
- `banner-tech.php` - Modern Tech (Cyberpunk/Neon)
- `banner-corporate.php` - Corporate Professional (Enterprise)
- `banner-minimal.php` - Clean Minimal (Swiss/Bauhaus)
- `banner-document.php` - Editorial Document (Publication)

Templates include:
- Complete HTML structure with DOCTYPE
- Embedded CSS with scoped selectors (`.banner` namespace)
- Google Fonts integration
- Pattern definitions using CSS gradients
- Conditional rendering for optional elements

### Smart Content Layout

**With Logo:**
- Content max-width: 700px (left-aligned)
- Logo positioned on right (z-index: 1, behind content)

**Without Logo:**
- Content max-width: 1000px (centered)
- Uses `.banner.no-logo` class automatically

### Pattern System

8 CSS-based patterns using `::after` pseudo-elements:
- **Grid**: Linear gradient grid lines
- **Dots**: Radial gradient dots with offset
- **Diagonal**: 45° diagonal stripes
- **Zigzag**: Chevron pattern
- **Circuit**: Tech circuit board style
- **Hexagon**: Honeycomb pattern
- **Waves**: Horizontal wave lines
- **None**: Clean background only

### Font Options

9 Google Fonts included:
- **Sans-serif**: Inter (default), Poppins, Montserrat, Roboto, Open Sans, Work Sans
- **Serif**: Playfair Display
- **Monospace**: JetBrains Mono, Roboto Mono (for code/tech aesthetic)

### Z-Index Layering

Proper stacking order for visual hierarchy:
```
0: Background patterns (::after)
1: Overlay gradient (::before) + Logo
2: Content box with text
```

Logo stays behind text to ensure readability even with large logos.

### Glass Morphism Implementation

Modern frosted glass effect on content boxes:
- Semi-transparent background (rgba with 0.75-0.95 opacity)
- `backdrop-filter: blur(15px)` for blur effect
- Subtle shadow and border glow
- Color-matched to each template theme

### Security Features

- **Nonce verification** for all AJAX requests
- **Input sanitization** (esc_html, esc_url, esc_attr)
- **Capability checks** for admin functions
- **SQL injection protection** through WordPress $wpdb methods
- **CORS handling** removed from images to prevent loading failures

## File Structure

```
banner-generator/
├── banner-generator.php          # Main plugin file
├── templates/
│   ├── admin-page.php           # Admin interface
│   ├── banner-tech.php          # Modern Tech template
│   ├── banner-corporate.php     # Corporate template
│   ├── banner-minimal.php       # Minimal template
│   └── banner-document.php      # Document template
├── assets/
│   ├── js/
│   │   ├── admin.js            # Admin JavaScript + html2canvas logic
│   │   └── html2canvas.min.js  # Canvas rendering library
│   ├── css/
│   │   └── admin.css           # Admin styles
│   ├── banner-tech-example.png
│   ├── banner-corporate-example.png
│   ├── banner-minimal-example.png
│   ├── banner-document-example.png
│   └── admin-interface.png
└── README.md                    # This file
```

## Customization

### Modifying Templates

Each template can be customized independently:

1. Edit CSS in `/templates/banner-[style].php`
2. Adjust colors, fonts, spacing, shadows
3. Modify pattern styles in the `::after` pseudo-elements
4. Change content box styling (background, blur, padding)

### Adding Custom Fonts

Add new fonts to the admin interface:

1. Edit `/templates/admin-page.php`
2. Add new `<option>` to the Font Family dropdown
3. Font will be loaded automatically via Google Fonts API

### Creating New Templates

1. Duplicate an existing template file
2. Modify styles and colors
3. Add new option to style mapping in `banner-generator.php`:
```php
$template_map = array(
    'tech' => 'banner-tech.php',
    'corporate' => 'banner-corporate.php',
    'minimal' => 'banner-minimal.php',
    'document' => 'banner-document.php',
    'yournew' => 'banner-yournew.php'  // Add here
);
```
4. Add style option to admin dropdown

### Adjusting Image Quality/Size

In `/assets/js/admin.js`, modify line 95:
```javascript
const imageData = canvas.toDataURL('image/webp', 0.88);
// Change 0.88 (88% quality) to desired value (0.1-1.0)
```

Lower values = smaller files, lower quality
Higher values = larger files, higher quality

## Troubleshooting

### Common Issues

**Logo not loading:**
- Check image URL is accessible
- Verify CORS headers if external image
- Use WordPress media library images (same-origin) for best results

**Description not visible:**
- Ensure text is entered in Description field
- Check browser cache (Ctrl+F5 to hard refresh)
- Verify `.banner .description` CSS has `display: block`

**Pattern not showing:**
- Patterns are subtle on some backgrounds
- Try different pattern options
- Increase pattern opacity in template CSS

**Text overlapping with logo:**
- Logo is now behind text (z-index: 1)
- Content box has semi-transparent background for contrast
- Adjust logo size or position in template CSS

**Fonts not loading:**
- Wait for generation to complete (3 second delay for fonts)
- Check internet connection (Google Fonts require internet)
- Try different font option

### Debug Mode

Enable WordPress debug mode:

```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Check `/wp-content/debug.log` for errors.

## Advantages Over Traditional Image Generators

### No Server Dependencies
- Works on any hosting without GD library or ImageMagick
- No PHP extensions required
- No server memory limits to worry about

### Superior Quality
- CSS gradients and effects > GD rendering
- Web fonts render beautifully
- Glass morphism and backdrop filters impossible with GD
- Crisp text at any size

### Easy Customization
- Edit CSS instead of PHP image code
- Live preview in browser
- No compilation or server restarts
- Template-based architecture

### Better Performance
- Client-side generation doesn't burden server
- No server CPU usage for image processing
- Smaller file sizes with WebP format
- Faster page loads improve SEO

### Modern Design
- 2025 design trends (glass morphism, gradients)
- Professional templates
- Flexible pattern system
- Typography excellence with Google Fonts

## Best Practices

### For SEO
1. **Use descriptive titles** with target keywords
2. **Keep filenames meaningful** (auto-generated from title)
3. **Add relevant category/description** text
4. **Optimize file size** (~50-80KB is ideal)
5. **Use consistent branding** (logo, colors, fonts)

### For Performance
1. **Use WebP format** (already default)
2. **Serve from WordPress media library** (CDN-ready)
3. **Don't regenerate** existing banners unnecessarily
4. **Use same-origin logos** to avoid CORS issues

### For Design
1. **Keep text concise** (long titles may overflow)
2. **Test without logo** (layout adjusts automatically)
3. **Choose appropriate template** for content tone
4. **Try different patterns** for variety
5. **Use monospace fonts** for tech/code content

## Changelog

### Version 2.0.0 (Current)
- ✨ Added 4 professional templates (Tech, Corporate, Minimal, Document)
- ✨ Template-based architecture for easy customization
- ✨ Smart layout: content expands when no logo present
- ✨ 8 background pattern options
- ✨ 9 font options including monospace
- ✨ Glass morphism effects with backdrop blur
- ✨ SEO-optimized filenames and metadata
- ✨ WebP output format (50-80KB files)
- ✨ Proper z-index layering (logo behind text)
- ✨ Corner bracket decoration on descriptions
- 🐛 Fixed CORS issues by removing crossorigin attribute
- 🐛 Fixed CSS scoping to prevent WordPress admin conflicts
- 🐛 Fixed Modern Tech template (lighter, more modern)
- 📝 Refactored "tagline" to "description" throughout

### Version 1.0.0
- Initial release
- Single Modern Tech style
- Basic HTML-based banner generation
- Admin interface
- Usage tracking
- Media library integration

## Support

For issues, feature requests, or contributions, please contact the plugin developer.

## License

This plugin is licensed under the GPL v2 or later.

---

**Banner Generator**: Professional SEO-optimized featured image creation without server dependencies.
