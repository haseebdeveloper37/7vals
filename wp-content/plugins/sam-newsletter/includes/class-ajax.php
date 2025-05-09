<?php
class SAM_Newsletter_Ajax {
    public function __construct() {
        add_action('wp_ajax_sam_newsletter_submit', [$this, 'handle_submission']);
        add_action('wp_ajax_nopriv_sam_newsletter_submit', [$this, 'handle_submission']);
    }

    public function handle_submission() {
        check_ajax_referer('sam_newsletter_nonce', 'nonce');

        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

        // Validate inputs
        if (empty($name) || empty($email)) {
            wp_send_json_error(['message' => __('Please fill in all fields.', 'sam-newsletter')]);
        }

        if (!is_email($email)) {
            wp_send_json_error(['message' => __('Please enter a valid email address.', 'sam-newsletter')]);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'sam_newsletter';

        // Check if email already exists
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE email = %s",
            $email
        ));

        if ($exists) {
            wp_send_json_error(['message' => __('This email is already subscribed.', 'sam-newsletter')]);
        }

        // Insert new subscription
        $result = $wpdb->insert(
            $table_name,
            [
                'name' => $name,
                'email' => $email,
                'created_at' => current_time('mysql'),
            ],
            ['%s', '%s', '%s']
        );

        if ($result === false) {
            wp_send_json_error(['message' => __('An error occurred. Please try again.', 'sam-newsletter')]);
        }

        wp_send_json_success(['message' => __('Thank you for subscribing!', 'sam-newsletter')]);
    }
}