# Changelog

All notable changes to the Banner Generator WordPress Plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.0.0] - 2025-11-24

### Added
- **Gutenberg Block Support**: Generate banners directly in the block editor while writing posts
- Block registration with `banner-generator/banner-block` namespace
- React-based block editor component with WordPress components (TextControl, SelectControl, etc.)
- InspectorControls for sidebar parameter configuration
- BlockControls toolbar with Regenerate and Remove actions
- MediaUpload integration for logo selection from Media Library
- Real-time preview in the block editor
- Placeholder state with "Create Banner" button
- Preview state showing generated banner with settings info
- Block editor assets enqueuing (edit.js, editor.css)
- Frontend block assets enqueuing (style.css)
- Loading states with Spinner component during generation
- Error handling and validation messages in block UI
- Two workflow options: Admin page OR Gutenberg block

### Changed
- Updated plugin version from 2.0.0 to 3.0.0
- Added text domain 'banner-generator' to plugin header
- Enhanced plugin description to mention Gutenberg block support
- Updated README.md with comprehensive Gutenberg block usage instructions
- Updated file structure documentation to include blocks directory
- Reorganized usage section into "Two Ways to Use"
- Added benefits comparison between admin page and block workflows

### Technical Details
- Block uses client-side registration via `wp.blocks.registerBlockType()`
- Server-side registration via `register_block_type()` in PHP
- html2canvas integration for image capture in block editor
- Reuses existing AJAX endpoints: `get_banner_html` and `generate_banner`
- Block attributes store all configuration and generated image data
- Save function outputs simple `<figure><img></figure>` markup
- Lazy loading attribute for frontend performance
- WordPress 5.0+ compatible (requires Gutenberg)

### Compatibility
- Backward compatible with admin page interface (both workflows coexist)
- No breaking changes to existing functionality
- All 4 templates (Tech, Corporate, Minimal, Document) available in block
- All 8 patterns and 9 fonts accessible from block settings
- Generated images identical to admin page output

---

## [2.0.0] - 2024-11-22

### Added
- 4 professional design templates:
  - Modern Tech (cyberpunk/neon aesthetic)
  - Corporate Professional (enterprise/authoritative)
  - Clean Minimal (Swiss/Bauhaus inspired)
  - Editorial Document (publication-focused)
- Template-based architecture for easy customization
- 8 background pattern options (grid, dots, diagonal, zigzag, circuit, hexagon, waves, none)
- 9 Google Fonts options including monospace fonts
- Glass morphism effects with backdrop blur
- Smart layout system (content expands when no logo present)
- SEO-optimized filenames based on keyword field
- Corner bracket decoration on descriptions
- Proper z-index layering (logo behind text)
- WebP output format with 88% quality

### Changed
- Refactored from single template to multi-template system
- Renamed "tagline" field to "description" throughout codebase
- Improved CSS scoping to prevent WordPress admin conflicts
- Enhanced Modern Tech template (lighter, more modern colors)

### Fixed
- CORS issues by removing crossorigin attribute from images
- Logo positioning and text readability
- Pattern rendering on various background colors
- Font loading timing issues

---

## [1.0.0] - 2024-11-15

### Added
- Initial release
- Single Modern Tech banner style
- Admin page interface for banner generation
- HTML/CSS-based template rendering
- Client-side image capture with html2canvas
- WordPress Media Library integration
- AJAX-based generation workflow
- Title, category, description, and logo support
- Automatic alt text generation
- Usage tracking functionality
- SEO-friendly filename generation
- WebP output format
- Security features (nonce verification, input sanitization)

### Technical Foundation
- PHP class-based architecture
- Two AJAX endpoints: `get_banner_html` and `generate_banner`
- Template system with output buffering
- Google Fonts integration
- 1280×720 output at 2x rendering scale
- No server-side image processing dependencies

---

## Upgrade Notes

### From 2.x to 3.0.0
- **No migration required** - plugin updates seamlessly
- Admin page continues to work as before
- New Gutenberg block becomes available automatically
- No changes to existing generated banners
- No database schema changes
- Simply update and activate

### From 1.x to 2.0.0
- Templates reorganized into separate files
- Admin page UI updated with new style/pattern selectors
- Existing banners remain functional
- No breaking changes to public API

---

## Future Roadmap

Potential features for future versions:
- [ ] Block variations for quick template selection
- [ ] Custom color picker for templates
- [ ] Preset library for common banner configurations
- [ ] Export/import banner settings
- [ ] Bulk banner generation
- [ ] Featured image auto-set option
- [ ] Custom dimension support
- [ ] Additional export formats (PNG, JPG)
- [ ] Integration with popular page builders

---

## Support & Contributing

- **GitHub Repository**: https://github.com/atraining/featured-image-generator-wordpress
- **Issues**: Report bugs via GitHub Issues
- **Documentation**: See README.md for usage instructions
- **WordPress Plugin Directory**: Coming soon

---

**Banner Generator** - Professional SEO-optimized featured image creation for WordPress.
