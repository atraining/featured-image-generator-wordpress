<?php
/**
 * Banner Template: Clean Minimal (Swiss/Bauhaus Style)
 * Pure white with black text, asymmetric layout, bold red accent
 */

$title = isset($title) ? $title : '';
$category = isset($category) ? $category : '';
$description = isset($description) ? $description : '';
$logo_url = isset($logo_url) ? $logo_url : '';
$pattern = isset($pattern) ? $pattern : 'none';
$font_family = isset($font_family) ? $font_family : 'Inter';

$font_family_safe = esc_html($font_family);
$font_url_param = str_replace(' ', '+', $font_family_safe);
$google_fonts_url = "https://fonts.googleapis.com/css2?family={$font_url_param}:wght@300;400;600;700;800;900&display=swap";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?php echo $google_fonts_url; ?>" rel="stylesheet">
    <style>
        .banner {
            margin: 0;
            padding: 80px 120px;
            box-sizing: border-box;
            font-family: '<?php echo $font_family_safe; ?>', -apple-system, BlinkMacSystemFont, sans-serif;
            width: 1280px;
            height: 720px;
            background: #ffffff;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .banner * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Very subtle overlay for pattern area only */
        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 50%,
                rgba(255, 255, 255, 0.7) 75%,
                rgba(255, 255, 255, 0.4) 100%
            );
            z-index: 1;
        }

        /* Pattern styles - visible but elegant for minimal aesthetic */
        .banner.pattern-grid::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.12) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(0, 0, 0, 0.12) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 0;
        }

        .banner.pattern-dots::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle, rgba(0, 0, 0, 0.15) 1.5px, transparent 1.5px),
                radial-gradient(circle, rgba(0, 0, 0, 0.1) 1.5px, transparent 1.5px);
            background-size: 30px 30px, 30px 30px;
            background-position: 0 0, 15px 15px;
            z-index: 0;
        }

        .banner.pattern-diagonal::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,
                transparent 48%,
                rgba(0, 0, 0, 0.12) 49%,
                rgba(0, 0, 0, 0.12) 51%,
                transparent 52%
            );
            background-size: 40px 40px;
            z-index: 0;
        }

        .banner.pattern-zigzag::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.08) 25%, transparent 25%),
                        linear-gradient(225deg, rgba(0, 0, 0, 0.08) 25%, transparent 25%),
                        linear-gradient(45deg, rgba(0, 0, 0, 0.08) 25%, transparent 25%),
                        linear-gradient(315deg, rgba(0, 0, 0, 0.08) 25%, transparent 25%);
            background-size: 60px 60px;
            background-position: 0 0, 0 30px, 30px -30px, 30px 0;
            z-index: 0;
        }

        .banner.pattern-circuit::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(90deg, rgba(0, 0, 0, 0.12) 1px, transparent 1px),
                linear-gradient(rgba(0, 0, 0, 0.12) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.08) 2px, transparent 2px),
                linear-gradient(rgba(0, 0, 0, 0.08) 2px, transparent 2px);
            background-size: 20px 20px, 20px 20px, 100px 100px, 100px 100px;
            background-position: 0 0, 0 0, 10px 10px, 10px 10px;
            z-index: 0;
        }

        .banner.pattern-hexagon::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(30deg, rgba(0, 0, 0, 0.08) 12%, transparent 12.5%, transparent 87%, rgba(0, 0, 0, 0.08) 87.5%),
                linear-gradient(150deg, rgba(0, 0, 0, 0.08) 12%, transparent 12.5%, transparent 87%, rgba(0, 0, 0, 0.08) 87.5%),
                linear-gradient(30deg, rgba(0, 0, 0, 0.08) 12%, transparent 12.5%, transparent 87%, rgba(0, 0, 0, 0.08) 87.5%),
                linear-gradient(150deg, rgba(0, 0, 0, 0.08) 12%, transparent 12.5%, transparent 87%, rgba(0, 0, 0, 0.08) 87.5%);
            background-size: 80px 140px;
            background-position: 0 0, 0 0, 40px 70px, 40px 70px;
            z-index: 0;
        }

        .banner.pattern-waves::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 100% 20px;
            z-index: 0;
        }

        .banner .content {
            position: relative;
            z-index: 2;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .banner.no-logo .content {
            max-width: 1000px;
            margin: 0 auto;
        }

        .banner .category {
            color: #ff0000;
            font-size: 1.4rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 28px;
            padding: 8px 0;
        }

        .banner .title {
            font-size: 7.5rem;
            font-weight: 900;
            line-height: 0.9;
            margin-bottom: 60px;
            color: #000000;
            letter-spacing: -1px;
        }

        .banner .description {
            display: block;
            color: #333333;
            font-size: 2rem;
            font-weight: 300;
            line-height: 1.4;
            max-width: 600px;
            padding: 20px 24px;
            position: relative;
            background:
                linear-gradient(#ff0000, #ff0000) 0 0 / 2px 20px,
                linear-gradient(#ff0000, #ff0000) 0 0 / 20px 2px,
                linear-gradient(#ff0000, #ff0000) 100% 0 / 2px 20px,
                linear-gradient(#ff0000, #ff0000) 100% 0 / 20px 2px,
                linear-gradient(#ff0000, #ff0000) 0 100% / 2px 20px,
                linear-gradient(#ff0000, #ff0000) 0 100% / 20px 2px,
                linear-gradient(#ff0000, #ff0000) 100% 100% / 2px 20px,
                linear-gradient(#ff0000, #ff0000) 100% 100% / 20px 2px;
            background-repeat: no-repeat;
        }

        .banner .logo-container {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            max-width: 480px;
            max-height: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .banner .logo-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="banner pattern-<?php echo esc_attr($pattern); ?> <?php echo empty($logo_url) ? 'no-logo' : ''; ?>">
        <div class="content">
            <?php if (!empty($category)): ?>
                <div class="category"><?php echo esc_html($category); ?></div>
            <?php endif; ?>

            <h1 class="title"><?php echo esc_html($title); ?></h1>

            <?php if (!empty($description)): ?>
                <p class="description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($logo_url)): ?>
            <div class="logo-container">
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($title); ?>" class="logo-image">
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
