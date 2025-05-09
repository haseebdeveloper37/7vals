<?php
class SAM_Newsletter_Database {
    public static function activate() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'sam_newsletter';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        // Add plugin version for future updates
        add_option('sam_newsletter_version', SAM_NEWSLETTER_VERSION);
    }

    public static function deactivate() {
        // For a SaaS environment, we might not want to drop the table on deactivation
        // as it would lose all subscription data. Instead, we'll just clean up options.
        delete_option('sam_newsletter_version');
    }

    public static function uninstall() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sam_newsletter';
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
        delete_option('sam_newsletter_version');
    }

    public function __construct() {
        // Register uninstall hook
        register_uninstall_hook(__FILE__, [__CLASS__, 'uninstall']);
    }
}