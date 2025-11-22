<?php
/**
 * Banner Template: Modern Tech (Cyberpunk/Neon Style)
 * Dark background with neon cyan and magenta accents
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
            background: linear-gradient(135deg, #0f1419 0%, #1e2936 50%, #2d3e5f 100%);
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

        /* Dark overlay for pattern area */
        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                rgba(15, 20, 30, 0.7) 0%,
                rgba(15, 20, 30, 0.5) 35%,
                rgba(15, 20, 30, 0.2) 65%,
                rgba(15, 20, 30, 0) 100%
            );
            z-index: 1;
        }

        /* Pattern styles */
        .banner.pattern-grid::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(rgba(0, 255, 249, 0.2) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(0, 255, 249, 0.2) 1px, transparent 1px);
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
                radial-gradient(circle, rgba(0, 255, 249, 0.25) 1.5px, transparent 1.5px),
                radial-gradient(circle, rgba(255, 0, 255, 0.2) 1.5px, transparent 1.5px);
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
                rgba(0, 255, 249, 0.15) 49%,
                rgba(0, 255, 249, 0.15) 51%,
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
            background: linear-gradient(135deg, rgba(0, 255, 249, 0.1) 25%, transparent 25%),
                        linear-gradient(225deg, rgba(0, 255, 249, 0.1) 25%, transparent 25%),
                        linear-gradient(45deg, rgba(255, 0, 255, 0.1) 25%, transparent 25%),
                        linear-gradient(315deg, rgba(255, 0, 255, 0.1) 25%, transparent 25%);
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
                linear-gradient(90deg, rgba(0, 255, 249, 0.15) 1px, transparent 1px),
                linear-gradient(rgba(0, 255, 249, 0.15) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 0, 255, 0.1) 2px, transparent 2px),
                linear-gradient(rgba(255, 0, 255, 0.1) 2px, transparent 2px);
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
                linear-gradient(30deg, rgba(0, 255, 249, 0.1) 12%, transparent 12.5%, transparent 87%, rgba(0, 255, 249, 0.1) 87.5%),
                linear-gradient(150deg, rgba(0, 255, 249, 0.1) 12%, transparent 12.5%, transparent 87%, rgba(0, 255, 249, 0.1) 87.5%),
                linear-gradient(30deg, rgba(0, 255, 249, 0.1) 12%, transparent 12.5%, transparent 87%, rgba(0, 255, 249, 0.1) 87.5%),
                linear-gradient(150deg, rgba(0, 255, 249, 0.1) 12%, transparent 12.5%, transparent 87%, rgba(0, 255, 249, 0.1) 87.5%);
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
            background-image: linear-gradient(rgba(0, 255, 249, 0.1) 1px, transparent 1px);
            background-size: 100% 20px;
            z-index: 0;
        }

        .banner .content {
            position: relative;
            z-index: 2;
            max-width: 700px;
            background: rgba(25, 30, 45, 0.75);
            padding: 40px;
            border-radius: 12px;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(0, 255, 249, 0.1);
        }

        .banner.no-logo .content {
            max-width: 1000px;
            margin: 0 auto;
        }

        .banner .category {
            color: #00fff9;
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 26px;
            padding: 10px 0 10px 18px;
            text-shadow: 0 0 20px rgba(0, 255, 249, 0.5);
        }

        .banner .title {
            font-size: 6.5rem;
            font-weight: 900;
            line-height: 0.95;
            margin-bottom: 55px;
            padding-left: 18px;
            background: linear-gradient(135deg, #00fff9 0%, #ff00ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            letter-spacing: -0.5px;
        }

        .banner .description {
            display: block;
            color: #b8c5d6;
            font-size: 2rem;
            font-weight: 400;
            line-height: 1.4;
            max-width: 600px;
            padding: 20px 24px;
            position: relative;
            background:
                linear-gradient(#00fff9, #00fff9) 0 0 / 2px 20px,
                linear-gradient(#00fff9, #00fff9) 0 0 / 20px 2px,
                linear-gradient(#00fff9, #00fff9) 100% 0 / 2px 20px,
                linear-gradient(#00fff9, #00fff9) 100% 0 / 20px 2px,
                linear-gradient(#00fff9, #00fff9) 0 100% / 2px 20px,
                linear-gradient(#00fff9, #00fff9) 0 100% / 20px 2px,
                linear-gradient(#00fff9, #00fff9) 100% 100% / 2px 20px,
                linear-gradient(#00fff9, #00fff9) 100% 100% / 20px 2px;
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
            filter: drop-shadow(0 0 30px rgba(0, 255, 249, 0.3));
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
