<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-database.php';
SAM_Newsletter_Database::uninstall();