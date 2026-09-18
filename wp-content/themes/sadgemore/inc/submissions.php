<?php
/**
 * Submissions storage: register a private CPT to store contact submissions
 * and expose them in WP-Admin for non-technical staff to manage.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function sedgemore_register_submission_cpt() {
    $labels = array(
        'name'               => _x( 'Submissions', 'post type general name', 'sadgemore' ),
        'singular_name'      => _x( 'Submission', 'post type singular name', 'sadgemore' ),
        'menu_name'          => _x( 'Submissions', 'admin menu', 'sadgemore' ),
        'name_admin_bar'     => _x( 'Submission', 'add new on admin bar', 'sadgemore' ),
        'add_new'            => _x( 'Add New', 'submission', 'sadgemore' ),
        'add_new_item'       => __( 'Add New Submission', 'sadgemore' ),
        'new_item'           => __( 'New Submission', 'sadgemore' ),
        'edit_item'          => __( 'Edit Submission', 'sadgemore' ),
        'view_item'          => __( 'View Submission', 'sadgemore' ),
        'all_items'          => __( 'All Submissions', 'sadgemore' ),
        'search_items'       => __( 'Search Submissions', 'sadgemore' ),
        'not_found'          => __( 'No submissions found.', 'sadgemore' ),
        'not_found_in_trash' => __( 'No submissions found in Trash.', 'sadgemore' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-email-alt',
        'supports'           => array( 'title' ),
    );

    register_post_type( 'sedgemore_submission', $args );
}
add_action( 'init', 'sedgemore_register_submission_cpt' );

// Admin list columns
function sedgemore_submission_columns( $columns ) {
    $new = array();
    $new['cb'] = $columns['cb'];
    $new['title'] = __( 'Submitted By', 'sadgemore' );
    $new['first_name'] = __( 'First name', 'sadgemore' );
    $new['email'] = __( 'Email', 'sadgemore' );
    $new['topic'] = __( 'Topic', 'sadgemore' );
    $new['followup'] = __( 'Follow-up', 'sadgemore' );
    $new['date'] = $columns['date'];
    return $new;
}
add_filter( 'manage_sedgemore_submission_posts_columns', 'sedgemore_submission_columns' );

function sedgemore_submission_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'first_name':
            echo esc_html( get_post_meta( $post_id, 'first_name', true ) );
            break;
        case 'email':
            echo esc_html( get_post_meta( $post_id, 'email', true ) );
            break;
        case 'topic':
            echo esc_html( get_post_meta( $post_id, 'topic_label', true ) );
            break;
        case 'followup':
            $sent = get_post_meta( $post_id, 'followup_sent', true );
            $log = get_post_meta( $post_id, 'followup_log', true );
            if ( $sent === 'yes' ) {
                $last = '';
                if ( is_array( $log ) && ! empty( $log ) ) {
                    $entry = end( $log );
                    $last = isset( $entry['time'] ) ? ' (' . esc_html( $entry['time'] ) . ')' : '';
                }
                echo '<span style="color:green;">Yes</span>' . $last;
            } else {
                echo '<span style="color:#999;">No</span>';
            }
            break;
    }
}
add_action( 'manage_sedgemore_submission_posts_custom_column', 'sedgemore_submission_column_content', 10, 2 );

// Make title more useful in admin list
function sedgemore_submission_save_title( $post_id, $post, $update ) {
    if ( $post->post_type !== 'sedgemore_submission' ) {
        return;
    }

    $first = get_post_meta( $post_id, 'first_name', true );
    $last  = get_post_meta( $post_id, 'last_name', true );
    $topic = get_post_meta( $post_id, 'topic_label', true );

    $title = trim( $first . ' ' . $last );
    if ( $topic ) {
        $title .= ' — ' . $topic;
    }

    if ( $title && $title !== $post->post_title ) {
        // Unhook to avoid infinite loop
        remove_action( 'save_post', 'sedgemore_submission_save_title', 10 );
        wp_update_post( array( 'ID' => $post_id, 'post_title' => wp_strip_all_tags( $title ) ) );
        add_action( 'save_post', 'sedgemore_submission_save_title', 10, 3 );
    }
}
add_action( 'save_post', 'sedgemore_submission_save_title', 10, 3 );

/**
 * Meta box: display submission details on edit screen
 */
function sedgemore_submission_add_meta_box() {
    add_meta_box(
        'sedgemore_submission_details',
        __( 'Submission details', 'sadgemore' ),
        'sedgemore_submission_meta_box_callback',
        'sedgemore_submission',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sedgemore_submission_add_meta_box' );

function sedgemore_submission_meta_box_callback( $post ) {
    $first = get_post_meta( $post->ID, 'first_name', true );
    $last  = get_post_meta( $post->ID, 'last_name', true );
    $email = get_post_meta( $post->ID, 'email', true );
	$background = get_post_meta( $post->ID, 'background', true );
    $topic = get_post_meta( $post->ID, 'topic_label', true );
    $message = get_post_meta( $post->ID, 'message', true );
    $submitted_at = get_post_meta( $post->ID, 'submitted_at', true );
    $mail_sent = get_post_meta( $post->ID, 'mail_sent', true );
    $followup = get_post_meta( $post->ID, 'follow_up', true );
    $followup_sent = get_post_meta( $post->ID, 'followup_sent', true );

    ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th><?php _e( 'First name', 'sadgemore' ); ?></th>
                <td><?php echo esc_html( $first ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Last name', 'sadgemore' ); ?></th>
                <td><?php echo esc_html( $last ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Email', 'sadgemore' ); ?></th>
                <td><?php echo esc_html( $email ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Topic', 'sadgemore' ); ?></th>
                <td><?php echo esc_html( $topic ); ?></td>
            </tr>
			<?php if ( $background ) : ?>
			<tr>
				<th><?php _e( 'Current role or background', 'sadgemore' ); ?></th>
				<td><?php echo esc_html( $background ); ?></td>
			</tr>
			<?php endif; ?>
            <tr>
                <th><?php _e( 'Submitted at', 'sadgemore' ); ?></th>
                <td><?php echo esc_html( $submitted_at ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Mail sent', 'sadgemore' ); ?></th>
                <td><?php echo esc_html( $mail_sent ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Message', 'sadgemore' ); ?></th>
                <td>
                    <div style="white-space:pre-wrap;" id="sedgemore_submission_message"><?php echo esc_html( $message ); ?></div>
                    <p style="margin-top:8px;"><button type="button" class="button" id="sedgemore_copy_message">Copy message</button></p>
                </td>
            </tr>
            <tr>
                <th><?php _e( 'Follow up', 'sadgemore' ); ?></th>
                <td>
                    <label><input type="checkbox" name="sedgemore_follow_up" value="1" <?php checked( $followup, '1' ); ?> /> <?php _e( 'Mark for follow-up (send follow-up email on save)', 'sadgemore' ); ?></label>
                    <p style="font-size:12px;color:#666;margin-top:6px;"><?php echo $followup_sent ? esc_html__( 'Follow-up sent', 'sadgemore' ) : esc_html__( 'Not sent', 'sadgemore' ); ?></p>

                    <p style="margin-top:12px;"><strong><?php _e( 'Manual actions', 'sadgemore' ); ?></strong></p>
                    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline-block;margin-right:8px;">
                        <?php wp_nonce_field( 'sedgemore_manual_send', 'sedgemore_manual_send_nonce' ); ?>
                        <input type="hidden" name="action" value="sedgemore_send_followup">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr( $post->ID ); ?>">
                        <button type="submit" class="button button-secondary"><?php _e( 'Send follow-up now', 'sadgemore' ); ?></button>
                    </form>

                    <?php $scheduled_ts = get_post_meta( $post->ID, 'scheduled_timestamp', true );
                    $scheduled_label = $scheduled_ts ? date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $scheduled_ts ) ) : ''; ?>
                    <div style="margin-top:12px;">
                        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:flex;gap:8px;align-items:center;">
                            <?php wp_nonce_field( 'sedgemore_schedule', 'sedgemore_schedule_nonce' ); ?>
                            <input type="hidden" name="action" value="sedgemore_schedule_followup">
                            <input type="hidden" name="post_id" value="<?php echo esc_attr( $post->ID ); ?>">
                            <input type="datetime-local" name="scheduled_datetime" value="<?php echo $scheduled_ts ? esc_attr( date( 'Y-m-d\TH:i', strtotime( $scheduled_ts ) ) ) : ''; ?>" />
                            <button type="submit" class="button button-primary"><?php _e( 'Schedule follow-up', 'sadgemore' ); ?></button>
                        </form>
                        <?php if ( $scheduled_label ) : ?>
                            <p style="margin-top:6px;"><?php printf( __( 'Scheduled for: %s', 'sadgemore' ), esc_html( $scheduled_label ) ); ?></p>
                            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:6px;">
                                <?php wp_nonce_field( 'sedgemore_unschedule', 'sedgemore_unschedule_nonce' ); ?>
                                <input type="hidden" name="action" value="sedgemore_unschedule_followup">
                                <input type="hidden" name="post_id" value="<?php echo esc_attr( $post->ID ); ?>">
                                <button type="submit" class="button"><?php _e( 'Unschedule follow-up', 'sadgemore' ); ?></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Admin submenu: Export and Settings for submissions
 */
function sedgemore_submissions_admin_menu() {
    $parent = 'edit.php?post_type=sedgemore_submission';
    add_submenu_page( $parent, __( 'Export Submissions', 'sadgemore' ), __( 'Export', 'sadgemore' ), 'manage_options', 'sedgemore_submissions_export', 'sedgemore_submissions_export_page' );
    add_submenu_page( $parent, __( 'Submissions Settings', 'sadgemore' ), __( 'Settings', 'sadgemore' ), 'manage_options', 'sedgemore_submissions_settings', 'sedgemore_submissions_settings_page' );
}
add_action( 'admin_menu', 'sedgemore_submissions_admin_menu' );

function sedgemore_submissions_export_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Insufficient permissions', 'sadgemore' ) );
    }

    // If export requested, output CSV
    if ( isset( $_GET['do_export'] ) && $_GET['do_export'] === '1' ) {
        $args = array(
            'post_type' => 'sedgemore_submission',
            'post_status' => 'private',
            'posts_per_page' => -1,
        );
        $subs = get_posts( $args );

        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=submissions-' . date( 'Y-m-d' ) . '.csv' );

        $output = fopen( 'php://output', 'w' );
        fputcsv( $output, array( 'First name', 'Last name', 'Email', 'Topic', 'Message', 'Submitted at', 'Mail sent' ) );

        foreach ( $subs as $s ) {
            $fn = get_post_meta( $s->ID, 'first_name', true );
            $ln = get_post_meta( $s->ID, 'last_name', true );
            $em = get_post_meta( $s->ID, 'email', true );
            $tp = get_post_meta( $s->ID, 'topic_label', true );
            $msg = get_post_meta( $s->ID, 'message', true );
            $sa = get_post_meta( $s->ID, 'submitted_at', true );
            $ms = get_post_meta( $s->ID, 'mail_sent', true );

            fputcsv( $output, array( $fn, $ln, $em, $tp, $msg, $sa, $ms ) );
        }

        fclose( $output );
        exit;
    }

    // Render export UI
    ?>
    <div class="wrap">
        <h1><?php _e( 'Export Submissions', 'sadgemore' ); ?></h1>
        <p><?php _e( 'Export all submissions as CSV. Click the button below to download.', 'sadgemore' ); ?></p>
        <p><a class="button button-primary" href="?post_type=sedgemore_submission&page=sedgemore_submissions_export&do_export=1"><?php _e( 'Download CSV', 'sadgemore' ); ?></a></p>
    </div>
    <?php
}

function sedgemore_submissions_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Insufficient permissions', 'sadgemore' ) );
    }

    if ( isset( $_POST['sedgemore_submissions_settings_nonce'] ) && wp_verify_nonce( $_POST['sedgemore_submissions_settings_nonce'], 'sedgemore_submissions_settings' ) ) {
        update_option( 'sedgemore_submissions_email', sanitize_email( $_POST['sedgemore_submissions_email'] ?? '' ) );
        update_option( 'sedgemore_submissions_subject_prefix', sanitize_text_field( $_POST['sedgemore_submissions_subject_prefix'] ?? '' ) );
        update_option( 'sedgemore_submissions_cc', sanitize_email( $_POST['sedgemore_submissions_cc'] ?? '' ) );
        update_option( 'sedgemore_submissions_follow_subject', sanitize_text_field( $_POST['sedgemore_submissions_follow_subject'] ?? '' ) );
        update_option( 'sedgemore_submissions_follow_body', wp_kses_post( $_POST['sedgemore_submissions_follow_body'] ?? '' ) );
        update_option( 'sedgemore_submissions_use_html', isset( $_POST['sedgemore_submissions_use_html'] ) ? '1' : '0' );
        update_option( 'sedgemore_submissions_html_template', wp_kses_post( $_POST['sedgemore_submissions_html_template'] ?? '' ) );
        echo '<div class="updated"><p>' . __( 'Settings saved.', 'sadgemore' ) . '</p></div>';
    }

    $email = get_option( 'sedgemore_submissions_email', 'info@sedgemoretravel.com' );
    $prefix = get_option( 'sedgemore_submissions_subject_prefix', 'Sedgemore' );
    $cc = get_option( 'sedgemore_submissions_cc', '' );
    $follow_subject = get_option( 'sedgemore_submissions_follow_subject', 'Thank you from Sedgemore' );
    $follow_body = get_option( 'sedgemore_submissions_follow_body', "Thank you for your enquiry. We will be in touch shortly." );
    $use_html = get_option( 'sedgemore_submissions_use_html', '0' );
    $html_template = get_option( 'sedgemore_submissions_html_template', '<html><body><h1>{site_name}</h1><p>Dear {first_name} {last_name},</p><p>{message}</p><p>Best regards,<br/>{site_name}</p></body></html>' );
    ?>
    <div class="wrap">
        <h1><?php _e( 'Submissions Settings', 'sadgemore' ); ?></h1>
        <form method="post">
            <?php wp_nonce_field( 'sedgemore_submissions_settings', 'sedgemore_submissions_settings_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th><label for="sedgemore_submissions_email"><?php _e( 'Notification email', 'sadgemore' ); ?></label></th>
                    <td><input name="sedgemore_submissions_email" id="sedgemore_submissions_email" type="email" value="<?php echo esc_attr( $email ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="sedgemore_submissions_subject_prefix"><?php _e( 'Subject prefix', 'sadgemore' ); ?></label></th>
                    <td><input name="sedgemore_submissions_subject_prefix" id="sedgemore_submissions_subject_prefix" type="text" value="<?php echo esc_attr( $prefix ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="sedgemore_submissions_cc"><?php _e( 'CC address (optional)', 'sadgemore' ); ?></label></th>
                    <td><input name="sedgemore_submissions_cc" id="sedgemore_submissions_cc" type="email" value="<?php echo esc_attr( $cc ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="sedgemore_submissions_follow_subject"><?php _e( 'Follow-up email subject', 'sadgemore' ); ?></label></th>
                    <td><input name="sedgemore_submissions_follow_subject" id="sedgemore_submissions_follow_subject" type="text" value="<?php echo esc_attr( $follow_subject ); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="sedgemore_submissions_follow_body"><?php _e( 'Follow-up email body', 'sadgemore' ); ?></label></th>
                    <td><textarea name="sedgemore_submissions_follow_body" id="sedgemore_submissions_follow_body" class="large-text" rows="6"><?php echo esc_textarea( $follow_body ); ?></textarea>
                    <p class="description">Use {first_name} and {last_name} placeholders in the body.</p></td>
                </tr>
                <tr>
                    <th><label for="sedgemore_submissions_use_html"><?php _e( 'Use HTML follow-up template', 'sadgemore' ); ?></label></th>
                    <td><label><input type="checkbox" name="sedgemore_submissions_use_html" id="sedgemore_submissions_use_html" value="1" <?php checked( $use_html, '1' ); ?> /> <?php _e( 'Send follow-up using HTML template', 'sadgemore' ); ?></label></td>
                </tr>
                <tr>
                    <th><label for="sedgemore_submissions_html_template"><?php _e( 'HTML template', 'sadgemore' ); ?></label></th>
                    <td><textarea name="sedgemore_submissions_html_template" id="sedgemore_submissions_html_template" class="large-text" rows="8"><?php echo esc_textarea( $html_template ); ?></textarea>
                    <p class="description">Use placeholders: {first_name}, {last_name}, {message}, {site_name}, {site_url}</p></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Save follow-up checkbox and optionally send follow-up email on save
 */
function sedgemore_submission_save_followup( $post_id, $post, $update ) {
    if ( $post->post_type !== 'sedgemore_submission' ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save follow_up meta from meta box
    $follow = isset( $_POST['sedgemore_follow_up'] ) && $_POST['sedgemore_follow_up'] == '1' ? '1' : '';
    update_post_meta( $post_id, 'follow_up', $follow );

    // If follow_up is checked and followup_sent not yet set, send follow-up email
    if ( $follow === '1' ) {
        // call central send function (will not resend if already sent)
        sedgemore_send_followup( $post_id );
    }
}
add_action( 'save_post', 'sedgemore_submission_save_followup', 20, 3 );

/**
 * Centralized follow-up sender that can be called manually, on save, or via cron.
 * Returns true on success, false otherwise.
 */
function sedgemore_send_followup( $post_id, $force = false ) {
    if ( ! $post_id ) {
        return false;
    }

    $followup_sent = get_post_meta( $post_id, 'followup_sent', true );
    if ( $followup_sent === 'yes' && ! $force ) {
        return false;
    }

    $first = get_post_meta( $post_id, 'first_name', true );
    $last  = get_post_meta( $post_id, 'last_name', true );
    $email = get_post_meta( $post_id, 'email', true );
    $message = get_post_meta( $post_id, 'message', true );

    if ( ! is_email( $email ) ) {
        return false;
    }

    $subject = get_option( 'sedgemore_submissions_follow_subject', 'Thank you from Sedgemore' );
    $body = get_option( 'sedgemore_submissions_follow_body', "Thank you for your enquiry. We will be in touch shortly." );
    $use_html = get_option( 'sedgemore_submissions_use_html', '0' );
    $html_template = get_option( 'sedgemore_submissions_html_template', '' );

    $replacements = array(
        '{first_name}' => $first,
        '{last_name}'  => $last,
        '{message}'    => $message,
        '{site_name}'  => get_bloginfo( 'name' ),
        '{site_url}'   => home_url(),
        '{site_logo_url}' => function_exists( 'get_custom_logo' ) ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '',
        '{admin_email}' => get_bloginfo( 'admin_email' ),
        '{topic}'       => get_post_meta( $post_id, 'topic_label', true ),
    );

    $sent = false;
    if ( $use_html === '1' && ! empty( $html_template ) ) {
        $html_body = strtr( $html_template, $replacements );
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        $sent = wp_mail( $email, $subject, $html_body, $headers );
    } else {
        $plain = strtr( $body, array( '{first_name}' => $first, '{last_name}' => $last ) );
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        $sent = wp_mail( $email, $subject, wpautop( $plain ), $headers );
    }

    // Log attempt
    $log = get_post_meta( $post_id, 'followup_log', true );
    if ( ! is_array( $log ) ) {
        $log = array();
    }
    $log[] = array(
        'time' => current_time( 'mysql' ),
        'user_id' => get_current_user_id() ?: 0,
        'result' => $sent ? 'sent' : 'failed',
        'forced' => $force ? 1 : 0,
    );
    update_post_meta( $post_id, 'followup_log', $log );

    if ( $sent ) {
        update_post_meta( $post_id, 'followup_sent', 'yes' );
    }

    return (bool) $sent;
}

/**
 * Cron callback for scheduled follow-ups
 */
function sedgemore_scheduled_send_followup_callback( $post_id ) {
    if ( ! $post_id ) {
        return;
    }
    sedgemore_send_followup( $post_id );
}
add_action( 'sedgemore_scheduled_send_followup', 'sedgemore_scheduled_send_followup_callback', 10, 1 );

/**
 * Admin POST handler: manual send
 */
function sedgemore_admin_send_followup() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( __( 'Insufficient permissions', 'sadgemore' ) );
    }
    if ( ! isset( $_POST['sedgemore_manual_send_nonce'] ) || ! wp_verify_nonce( $_POST['sedgemore_manual_send_nonce'], 'sedgemore_manual_send' ) ) {
        wp_die( __( 'Security check failed', 'sadgemore' ) );
    }
    $post_id = intval( $_POST['post_id'] ?? 0 );
    if ( $post_id ) {
        sedgemore_send_followup( $post_id, true );
    }
    wp_safe_redirect( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), admin_url( 'post.php' ) ) );
    exit;
}
add_action( 'admin_post_sedgemore_send_followup', 'sedgemore_admin_send_followup' );

/**
 * Admin POST handler: schedule follow-up
 */
function sedgemore_admin_schedule_followup() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( __( 'Insufficient permissions', 'sadgemore' ) );
    }
    if ( ! isset( $_POST['sedgemore_schedule_nonce'] ) || ! wp_verify_nonce( $_POST['sedgemore_schedule_nonce'], 'sedgemore_schedule' ) ) {
        wp_die( __( 'Security check failed', 'sadgemore' ) );
    }
    $post_id = intval( $_POST['post_id'] ?? 0 );
    $dt = sanitize_text_field( $_POST['scheduled_datetime'] ?? '' );
    if ( $post_id && $dt ) {
        $timestamp = strtotime( $dt );
        if ( $timestamp && $timestamp > time() ) {
            // unschedule previous
            $prev = wp_next_scheduled( 'sedgemore_scheduled_send_followup', array( $post_id ) );
            if ( $prev ) {
                wp_unschedule_event( $prev, 'sedgemore_scheduled_send_followup', array( $post_id ) );
            }
            wp_schedule_single_event( $timestamp, 'sedgemore_scheduled_send_followup', array( $post_id ) );
            update_post_meta( $post_id, 'scheduled_timestamp', date( 'Y-m-d H:i:s', $timestamp ) );
        }
    }
    wp_safe_redirect( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), admin_url( 'post.php' ) ) );
    exit;
}
add_action( 'admin_post_sedgemore_schedule_followup', 'sedgemore_admin_schedule_followup' );

/**
 * Admin POST handler: unschedule follow-up
 */
function sedgemore_admin_unschedule_followup() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( __( 'Insufficient permissions', 'sadgemore' ) );
    }
    if ( ! isset( $_POST['sedgemore_unschedule_nonce'] ) || ! wp_verify_nonce( $_POST['sedgemore_unschedule_nonce'], 'sedgemore_unschedule' ) ) {
        wp_die( __( 'Security check failed', 'sadgemore' ) );
    }
    $post_id = intval( $_POST['post_id'] ?? 0 );
    if ( $post_id ) {
        $prev = wp_next_scheduled( 'sedgemore_scheduled_send_followup', array( $post_id ) );
        if ( $prev ) {
            wp_unschedule_event( $prev, 'sedgemore_scheduled_send_followup', array( $post_id ) );
        }
        delete_post_meta( $post_id, 'scheduled_timestamp' );
    }
    wp_safe_redirect( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), admin_url( 'post.php' ) ) );
    exit;
}
add_action( 'admin_post_sedgemore_unschedule_followup', 'sedgemore_admin_unschedule_followup' );

/**
 * Bulk action: Export selected submissions as CSV
 */
function sedgemore_submissions_bulk_actions( $bulk_actions ) {
    $bulk_actions['sedgemore_export'] = __( 'Export selected as CSV', 'sadgemore' );
    return $bulk_actions;
}
add_filter( 'bulk_actions-edit-sedgemore_submission', 'sedgemore_submissions_bulk_actions' );

function sedgemore_submissions_handle_bulk( $redirect_to, $doaction, $post_ids ) {
    if ( $doaction !== 'sedgemore_export' ) {
        return $redirect_to;
    }

    if ( empty( $post_ids ) || ! is_array( $post_ids ) ) {
        return $redirect_to;
    }

    $output = fopen( 'php://output', 'w' );
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=submissions-selected-' . date( 'Y-m-d' ) . '.csv' );
    fputcsv( $output, array( 'First name', 'Last name', 'Email', 'Topic', 'Message', 'Submitted at', 'Mail sent' ) );

    foreach ( $post_ids as $pid ) {
        $fn = get_post_meta( $pid, 'first_name', true );
        $ln = get_post_meta( $pid, 'last_name', true );
        $em = get_post_meta( $pid, 'email', true );
        $tp = get_post_meta( $pid, 'topic_label', true );
        $msg = get_post_meta( $pid, 'message', true );
        $sa = get_post_meta( $pid, 'submitted_at', true );
        $ms = get_post_meta( $pid, 'mail_sent', true );
        fputcsv( $output, array( $fn, $ln, $em, $tp, $msg, $sa, $ms ) );
    }

    fclose( $output );
    exit;
}
add_filter( 'handle_bulk_actions-edit-sedgemore_submission', 'sedgemore_submissions_handle_bulk', 10, 3 );

// Add small JS for copy button
function sedgemore_submissions_admin_js( $hook ) {
    global $typenow;
    if ( $typenow !== 'sedgemore_submission' ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        var btn = document.getElementById('sedgemore_copy_message');
        if (!btn) return;
        btn.addEventListener('click', function(){
            var el = document.getElementById('sedgemore_submission_message');
            if (!el) return;
            var range = document.createRange();
            range.selectNodeContents(el);
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
            try {
                document.execCommand('copy');
            } catch (e) {}
            sel.removeAllRanges();
            btn.textContent = 'Copied';
            setTimeout(function(){ btn.textContent = 'Copy message'; }, 2000);
        });
    });
        // no-op if manual send forms exist
    </script>
    <?php
}
add_action( 'admin_footer-post.php', 'sedgemore_submissions_admin_js' );
add_action( 'admin_footer-post-new.php', 'sedgemore_submissions_admin_js' );
