<?php
class SAM_Newsletter_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'handle_export']);
    }

    public function add_admin_menu() {
        add_menu_page(
            __('SAM Newsletter', 'sam-newsletter'),
            __('SAM Newsletter', 'sam-newsletter'),
            'manage_options',
            'sam-newsletter',
            [$this, 'render_admin_page'],
            'dashicons-email-alt',
            30
        );
    }

    public function render_admin_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sam_newsletter';
        
        // Handle search
        $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
        $where = '';
        $query_args = [];
        
        if (!empty($search)) {
            $where = " WHERE name LIKE %s OR email LIKE %s";
            $query_args = ['%' . $wpdb->esc_like($search) . '%', '%' . $wpdb->esc_like($search) . '%'];
        }
        
        // Get total count
        $count_query = "SELECT COUNT(*) FROM $table_name" . $where;
        $total_items = $wpdb->get_var($wpdb->prepare($count_query, $query_args));
        
        // Setup pagination
        $per_page = 20;
        $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset = ($page - 1) * $per_page;
        
        // Get submissions
        $query = "SELECT * FROM $table_name" . $where . " ORDER BY created_at DESC LIMIT %d OFFSET %d";
        $query_args = array_merge($query_args, [$per_page, $offset]);
        $submissions = $wpdb->get_results($wpdb->prepare($query, $query_args));
        
        ?>
        <div class="wrap">
            <h1><?php _e('SAM Newsletter Submissions', 'sam-newsletter'); ?></h1>
            
            <div class="sam-newsletter-header">
                <form method="get" action="<?php echo admin_url('admin.php'); ?>">
                    <input type="hidden" name="page" value="sam-newsletter">
                    <p class="search-box">
                        <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="<?php esc_attr_e('Search by name or email...', 'sam-newsletter'); ?>">
                        <input type="submit" class="button" value="<?php esc_attr_e('Search', 'sam-newsletter'); ?>">
                    </p>
                </form>
                
                <form method="post" action="<?php echo admin_url('admin.php?page=sam-newsletter'); ?>" style="display: inline-block; margin-left: 10px;">
                    <input type="hidden" name="sam_newsletter_export" value="1">
                    <?php submit_button(__('Export CSV', 'sam-newsletter'), 'secondary', 'submit', false); ?>
                </form>
            </div>
            
            <div class="tablenav top">
                <div class="tablenav-pages">
                    <?php
                    $pagination_args = [
                        'base' => add_query_arg('paged', '%#%'),
                        'format' => '',
                        'total' => ceil($total_items / $per_page),
                        'current' => $page,
                    ];
                    echo paginate_links($pagination_args);
                    ?>
                </div>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('ID', 'sam-newsletter'); ?></th>
                        <th><?php _e('Name', 'sam-newsletter'); ?></th>
                        <th><?php _e('Email', 'sam-newsletter'); ?></th>
                        <th><?php _e('Date', 'sam-newsletter'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($submissions)) : ?>
                        <tr>
                            <td colspan="4"><?php _e('No submissions found.', 'sam-newsletter'); ?></td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($submissions as $submission) : ?>
                            <tr>
                                <td><?php echo esc_html($submission->id); ?></td>
                                <td><?php echo esc_html($submission->name); ?></td>
                                <td><?php echo esc_html($submission->email); ?></td>
                                <td><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($submission->created_at))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function handle_export() {
        if (!isset($_POST['sam_newsletter_export']) || !current_user_can('manage_options')) {
            return;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'sam_newsletter';
        $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sam-newsletter-subscriptions-' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Email', 'Date']);

        foreach ($submissions as $submission) {
            fputcsv($output, [
                $submission->id,
                $submission->name,
                $submission->email,
                $submission->created_at,
            ]);
        }

        fclose($output);
        exit;
    }
}