<?php
/**
 * Plugin Name: Banner Generator
 * Description: Generate professional banners with HTML/CSS and html2canvas (client-side)
 * Version: 2.0.0
 * Author: Christopher Helm
 * License: GPL v2 or later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class BannerGenerator {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_generate_banner', array($this, 'generate_banner_ajax'));
        add_action('wp_ajax_get_banner_html', array($this, 'get_banner_html_ajax'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'Banner Generator',
            'Banner Generator',
            'manage_options',
            'banner-generator',
            array($this, 'admin_page'),
            'dashicons-format-image',
            30
        );
    }

    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_banner-generator') {
            return;
        }

        wp_enqueue_script('banner-generator-admin', plugin_dir_url(__FILE__) . 'assets/js/admin.js', array('jquery'), '2.0.0', true);
        wp_enqueue_script('html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', array(), '1.4.1', true);
        wp_enqueue_style('banner-generator-admin', plugin_dir_url(__FILE__) . 'assets/css/admin.css', array(), '2.0.0');
        wp_localize_script('banner-generator-admin', 'bannerGeneratorAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('banner_generator_nonce')
        ));
    }

    public function generate_banner_ajax() {
        check_ajax_referer('banner_generator_nonce', 'nonce');

        $title = sanitize_text_field($_POST['title'] ?? '');
        $keyword = sanitize_text_field($_POST['keyword'] ?? '');
        $category = sanitize_text_field($_POST['category'] ?? '');
        $description = sanitize_textarea_field($_POST['description'] ?? '');
        $style = sanitize_text_field($_POST['style'] ?? 'tech');
        $image_data = $_POST['image_data'] ?? '';

        if (empty($title) || empty($keyword)) {
            wp_send_json_error('Missing required fields');
        }

        if (empty($image_data)) {
            wp_send_json_error('Missing image data');
        }

        try {
            // Decode base64 image data from client
            $image_data = preg_replace('/^data:image\/\w+;base64,/', '', $image_data);
            $image_data = base64_decode($image_data);

            if (!$image_data) {
                wp_send_json_error('Invalid image data');
            }

            // Create SEO-friendly filename from keyword with readable date
            $slug = sanitize_title($keyword);
            $date_suffix = date('Y-m-d-Hi'); // Format: 2025-01-21-1430
            $filename = $slug . '-' . $date_suffix . '.webp';

            // Save image to uploads directory
            $upload_dir = wp_upload_dir();
            $file_path = $upload_dir['path'] . '/' . $filename;
            $file_url = $upload_dir['url'] . '/' . $filename;

            if (file_put_contents($file_path, $image_data)) {
                // Build description from available fields
                $description_parts = array_filter(array($category, $description));
                $description = implode(' - ', $description_parts);

                // Build alt text
                $alt_text_parts = array_filter(array($title, $description));
                $alt_text = implode(': ', $alt_text_parts);

                // Create attachment
                $attachment = array(
                    'post_mime_type' => 'image/webp',
                    'post_title' => $title,
                    'post_content' => $description,
                    'post_excerpt' => $description,
                    'post_status' => 'inherit',
                    'guid' => $file_url
                );

                $attachment_id = wp_insert_attachment($attachment, $file_path);

                if ($attachment_id && !is_wp_error($attachment_id)) {
                    // Generate attachment metadata
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata($attachment_id, $file_path);
                    wp_update_attachment_metadata($attachment_id, $attach_data);

                    // Set alt text
                    update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);

                    wp_send_json_success(array(
                        'attachment_id' => $attachment_id,
                        'url' => $file_url,
                        'filename' => $filename,
                        'alt_text' => $alt_text
                    ));
                } else {
                    wp_send_json_error('Failed to create attachment');
                }
            } else {
                wp_send_json_error('Failed to save banner file');
            }
        } catch (Exception $e) {
            error_log('Banner Generator Error: ' . $e->getMessage());
            wp_send_json_error('Error saving banner: ' . $e->getMessage());
        }
    }

    public function get_banner_html_ajax() {
        check_ajax_referer('banner_generator_nonce', 'nonce');

        $title = sanitize_text_field($_POST['title'] ?? '');
        $category = sanitize_text_field($_POST['category'] ?? '');
        $description = sanitize_textarea_field($_POST['description'] ?? '');
        $logo_url = esc_url($_POST['logo_url'] ?? '');
        $style = sanitize_text_field($_POST['style'] ?? 'tech');
        $pattern = sanitize_text_field($_POST['pattern'] ?? 'grid');
        $font_family = sanitize_text_field($_POST['font_family'] ?? 'Inter');

        if (empty($title)) {
            wp_send_json_error('Missing required fields');
        }

        $html = $this->get_banner_html($title, $category, $description, $logo_url, $style, $pattern, $font_family);
        wp_send_json_success(array('html' => $html));
    }

    private function get_banner_html($title, $category, $description, $logo_url, $style, $pattern, $font_family = 'Inter') {
        // Map style to template file
        $template_map = array(
            'tech' => 'banner-tech.php',
            'corporate' => 'banner-corporate.php',
            'minimal' => 'banner-minimal.php',
            'document' => 'banner-document.php'
        );

        // Default to tech if invalid style
        $template_file = isset($template_map[$style]) ? $template_map[$style] : 'banner-tech.php';
        $template_path = plugin_dir_path(__FILE__) . 'templates/' . $template_file;

        // Check if template exists
        if (!file_exists($template_path)) {
            return '<div>Error: Template not found</div>';
        }

        // Start output buffering
        ob_start();

        // Include template (variables are available in template scope)
        include $template_path;

        // Get buffered content
        $html = ob_get_clean();

        return $html;
    }

    public function admin_page() {
        include plugin_dir_path(__FILE__) . 'templates/admin-page.php';
    }
}

// Initialize the plugin
new BannerGenerator();
