<?php
/**
 * Validates the Turnstile token supplied automatically by the widget.
 * Define SEDGEMORE_TURNSTILE_SECRET_KEY in wp-config.php or the server environment.
 */
function sedgemore_turnstile_is_valid() {
	$token = sanitize_text_field( wp_unslash( $_POST['cf-turnstile-response'] ?? '' ) );

	if ( empty( $token ) ) {
		error_log( 'Sedgemore Turnstile diagnostic: ' . wp_json_encode( array(
			'success'     => false,
			'error-codes' => array( 'missing-input-response' ),
			'hostname'    => null,
			'action'      => null,
			'http-status' => null,
		) ) );
		return false;
	}

	$secret_key = defined( 'SEDGEMORE_TURNSTILE_SECRET_KEY' ) ? SEDGEMORE_TURNSTILE_SECRET_KEY : getenv( 'SEDGEMORE_TURNSTILE_SECRET_KEY' );

	if ( empty( $secret_key ) ) {
		error_log( 'Sedgemore Turnstile diagnostic: ' . wp_json_encode( array(
			'success'     => false,
			'error-codes' => array( 'missing-secret-configuration' ),
			'hostname'    => null,
			'action'      => null,
			'http-status' => null,
		) ) );
		return false;
	}

	$response = wp_remote_post( 'https://challenges.cloudflare.com/turnstile/v0/siteverify', array(
		'timeout' => 10,
		'body'    => array(
			'secret'   => $secret_key,
			'response' => $token,
			'remoteip' => sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) ),
		),
    ) );

	if ( is_wp_error( $response ) ) {
		error_log( 'Sedgemore Turnstile diagnostic: ' . wp_json_encode( array(
			'success'     => false,
			'error-codes' => array( 'siteverify-transport-error' ),
			'hostname'    => null,
			'action'      => null,
			'http-status' => null,
		) ) );
		return false;
	}

	$http_status = wp_remote_retrieve_response_code( $response );
	$body        = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! is_array( $body ) ) {
		error_log( 'Sedgemore Turnstile diagnostic: ' . wp_json_encode( array(
			'success'     => false,
			'error-codes' => array( 'invalid-siteverify-json' ),
			'hostname'    => null,
			'action'      => null,
			'http-status' => $http_status,
		) ) );
		return false;
	}

	$diagnostic = array(
		'success'     => ! empty( $body['success'] ),
		'error-codes' => isset( $body['error-codes'] ) && is_array( $body['error-codes'] )
			? array_map( 'sanitize_key', $body['error-codes'] )
			: array(),
		'hostname'    => isset( $body['hostname'] ) ? sanitize_text_field( $body['hostname'] ) : null,
		'action'      => isset( $body['action'] ) ? sanitize_text_field( $body['action'] ) : null,
		'http-status' => $http_status,
	);

	error_log( 'Sedgemore Turnstile diagnostic: ' . wp_json_encode( $diagnostic ) );

	return $diagnostic['success'];
}

function sedgemore_turnstile_error() {
    wp_send_json_error( array( 'message' => 'Security verification failed. Please complete the Turnstile check and try again.' ) );
    wp_die();
}

function contact_us_form(){

    // nonce check for an extra layer of security, the function will exit if it fails
    if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], "contact_nonce")) {
        die("fail");
    }   
    if ( ! sedgemore_turnstile_is_valid() ) {
        die( 'turnstile_fail' );
    }

    $username = sanitize_text_field( $_POST['username'] );
    $surname = sanitize_text_field( $_POST['surname'] );
    $email = sanitize_text_field( $_POST['email'] );
    $phone = sanitize_text_field( $_POST['phone'] );
    $subject = sanitize_text_field( $_POST['subject'] );
    $message = sanitize_text_field( $_POST['message'] );

    
    $to = 'info@sedgemoretravel.com';// trim( get_field('admin_email_id','96') );
    $mail_subject = get_field('subject','96') . " : $email";
    $body = '<div>
        <p>
            <strong>See below client details</strong>
        </p>
        <table>
        <tbody>
            <tr>
                <td><strong>Name:</strong></td>
                <td>'.$username.'</td>
            </tr>
            <tr>
                <td><strong>Surname:</strong></td>
                <td>'.$surname.'</td>
            </tr>            
            <tr>
                <td><strong>Email:</strong></td>
                <td>'.$email.'</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>'.$phone.'</td>
            </tr>
            <tr>
                <td><strong>Enquiry:</strong></td>
                <td>'.$subject.'</td>
            </tr>
            <tr>
                <td><strong>Message:</strong></td>
                <td>'.$message.'</td>
            </tr>            
        </tbody>
    </table>
    </div>';
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Sedgemore <info@sedgemoretravel.com>',
        'Reply-To: '.$username.' <'.$email.'>'
    );

    error_log( 'home_form before wp_mail: ' . print_r( array(
        'to' => $to,
        'subject' => $mail_subject,
        'reply_to_email' => $email,
        'headers' => $headers,
    ), true ) );

    $result = wp_mail( $to, $mail_subject, $body, $headers );

    global $phpmailer;
    error_log( 'home_form after wp_mail: ' . print_r( array(
        'result' => $result ? 'success' : 'failed',
        'to' => $to,
        'subject' => $mail_subject,
        'reply_to_email' => $email,
        'phpmailer_error' => isset( $phpmailer ) && is_object( $phpmailer ) ? $phpmailer->ErrorInfo : '',
    ), true ) );
    if( $result ){
        echo "success";
    }else{
        echo "fail";
    }

    die();
}
add_action("wp_ajax_contact_us_form", "contact_us_form");
add_action("wp_ajax_nopriv_contact_us_form", "contact_us_form");

function home_form() {
    // TEMP DEBUG: log incoming POST and headers to WP debug log to diagnose 400/nonce issues
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'home_form called -- POST keys: ' . implode( ',', array_keys( $_POST ) ) );
        error_log( 'home_form POST: ' . print_r( $_POST, true ) );
        if ( function_exists( 'getallheaders' ) ) {
            error_log( 'home_form HEADERS: ' . print_r( getallheaders(), true ) );
        }
    }

    // Debug helper: if the form includes debug_home=1, echo back the POST payload
    if ( isset( $_POST['debug_home'] ) ) {
        wp_send_json_success( array( 'received' => $_POST ) );
        wp_die();
    }
    if ( ! isset( $_POST['home_nonce'] ) || ! wp_verify_nonce( $_POST['home_nonce'], 'home_nonce_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
        wp_die();
    }
    if ( ! sedgemore_turnstile_is_valid() ) {
        sedgemore_turnstile_error();
    }

    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $email      = sanitize_email( $_POST['email'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    $message    = sanitize_textarea_field( $_POST['message'] ?? '' );
    $form_title = sanitize_text_field( $_POST['form_title'] ?? 'Home Request' );
    $form_heading = sanitize_text_field( $_POST['form_heading'] ?? 'home enquiry details' );

    $topic_values = isset( $_POST['topic'] ) ? (array) $_POST['topic'] : array();
    $topic_values = array_filter( array_map( 'sanitize_text_field', $topic_values ) );
    $topics = array_values( $topic_values );

    if ( empty( $first_name ) || empty( $last_name ) || ! is_email( $email ) || empty( $topics ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Please complete all required fields.' ) );
        wp_die();
    }

    $topic_label_list = array();
    foreach ( $topics as $topic_key ) {
        $topic_label_list[] = $topic_key;
    }

    $topic_label = implode( ', ', $topic_label_list );

    $to = get_option( 'sedgemore_submissions_email', 'info@sedgemoretravel.com' );
    $prefix = get_option( 'sedgemore_submissions_subject_prefix', 'Sedgemore' );
    $mail_subject = sanitize_text_field( $prefix ) . ' - ' . $form_title . ' - ' . $topic_label;
    $body = '<div>
        <p><strong>See below ' . esc_html( $form_heading ) . '</strong></p>
        <table>
        <tbody>
            <tr>
                <td><strong>First name:</strong></td>
                <td>' . $first_name . '</td>
            </tr>
            <tr>
                <td><strong>Last name:</strong></td>
                <td>' . $last_name . '</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>' . $email . '</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>' . $phone . '</td>
            </tr>
            <tr>
                <td><strong>Interests:</strong></td>
                <td>' . $topic_label . '</td>
            </tr>
            <tr>
                <td><strong>Message:</strong></td>
                <td>' . $message . '</td>
            </tr>
        </tbody>
    </table>
    </div>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Sedgemore <info@sedgemoretravel.com>',
        'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>',
    );

    // Optional CC configured in settings
    $cc = get_option( 'sedgemore_submissions_cc', '' );
    if ( is_email( $cc ) ) {
        $headers[] = 'Cc: ' . $cc;
    }

    // Store submission as a private CPT post so staff can review in WP-Admin
    $post_id = wp_insert_post( array(
        'post_type'   => 'sedgemore_submission',
        'post_status' => 'private',
        'post_title'  => wp_strip_all_tags( $first_name . ' ' . $last_name . ' — ' . $topic_label ),
        'post_content'=> $message,
    ) );

    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, 'first_name', $first_name );
        update_post_meta( $post_id, 'last_name', $last_name );
        update_post_meta( $post_id, 'email', $email );
        if ( $phone ) {
            update_post_meta( $post_id, 'phone', $phone );
        }
        update_post_meta( $post_id, 'topic', $topics );
        update_post_meta( $post_id, 'topic_label', $topic_label );
        update_post_meta( $post_id, 'message', $message );
        update_post_meta( $post_id, 'submitted_at', current_time( 'mysql' ) );
    }

    $result = wp_mail( $to, $mail_subject, $body, $headers );

    // store mail status
    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, 'mail_sent', $result ? 'yes' : 'no' );
    }

    if ( $result ) {
        wp_send_json_success( array( 'message' => 'Thank you, ' . $first_name . '! Your message has been sent.' ) );
    }

    error_log( 'home_form wp_send_json_error: Message received, but confirmation email failed to send. Please try again later.' );
    wp_send_json_error( array( 'message' => 'Message received, but confirmation email failed to send. Please try again later.' ) );
    wp_die();
}

add_action( 'wp_ajax_home_form', 'home_form' );
add_action( 'wp_ajax_nopriv_home_form', 'home_form' );

/**
 * Handle Sedgemore Collective enquiries.
 */
function sedgemore_collective_enquiry_form() {
	if ( ! isset( $_POST['collective_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['collective_nonce'] ) ), 'collective_enquiry_action' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page and try again.' ) );
	}

	if ( ! sedgemore_turnstile_is_valid() ) {
		sedgemore_turnstile_error();
	}

	$first_name = sanitize_text_field( wp_unslash( $_POST['first_name'] ?? '' ) );
	$last_name  = sanitize_text_field( wp_unslash( $_POST['last_name'] ?? '' ) );
	$email      = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$background = sanitize_text_field( wp_unslash( $_POST['background'] ?? '' ) );
	$message    = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( empty( $first_name ) || empty( $last_name ) || ! is_email( $email ) || empty( $background ) || empty( $message ) ) {
		wp_send_json_error( array( 'message' => 'Please complete all required fields.' ) );
	}

	$topic_label = 'Sedgemore Collective';
	$post_id     = wp_insert_post(
		array(
			'post_type'    => 'sedgemore_submission',
			'post_status'  => 'private',
			'post_title'   => wp_strip_all_tags( $first_name . ' ' . $last_name . ' — ' . $topic_label ),
			'post_content' => $message,
		)
	);

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, 'first_name', $first_name );
		update_post_meta( $post_id, 'last_name', $last_name );
		update_post_meta( $post_id, 'email', $email );
		update_post_meta( $post_id, 'background', $background );
		update_post_meta( $post_id, 'topic', array( 'collective' ) );
		update_post_meta( $post_id, 'topic_label', $topic_label );
		update_post_meta( $post_id, 'message', $message );
		update_post_meta( $post_id, 'submitted_at', current_time( 'mysql' ) );
	}

	$to           = get_option( 'sedgemore_submissions_email', 'info@sedgemoretravel.com' );
	$prefix       = get_option( 'sedgemore_submissions_subject_prefix', 'Sedgemore' );
	$mail_subject = sanitize_text_field( $prefix ) . ' - Collective enquiry - ' . $first_name . ' ' . $last_name;
	$body         = '<p><strong>New Sedgemore Collective enquiry</strong></p><table><tbody>'
		. '<tr><td><strong>Name:</strong></td><td>' . esc_html( $first_name . ' ' . $last_name ) . '</td></tr>'
		. '<tr><td><strong>Email:</strong></td><td>' . esc_html( $email ) . '</td></tr>'
		. '<tr><td><strong>Current role or background:</strong></td><td>' . esc_html( $background ) . '</td></tr>'
		. '<tr><td><strong>Message:</strong></td><td>' . nl2br( esc_html( $message ) ) . '</td></tr>'
		. '</tbody></table>';
	$headers      = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: Sedgemore <info@sedgemoretravel.com>',
		'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>',
	);
	$cc           = get_option( 'sedgemore_submissions_cc', '' );

	if ( is_email( $cc ) ) {
		$headers[] = 'Cc: ' . $cc;
	}

	$result = wp_mail( $to, $mail_subject, $body, $headers );

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, 'mail_sent', $result ? 'yes' : 'no' );
	}

	if ( $result ) {
		wp_send_json_success( array( 'message' => 'Thank you. Your enquiry has been sent and our team will be in touch.' ) );
	}

	wp_send_json_error( array( 'message' => 'Your enquiry was saved, but the notification email could not be sent. Please try again later.' ) );
}
add_action( 'wp_ajax_collective_enquiry_form', 'sedgemore_collective_enquiry_form' );
add_action( 'wp_ajax_nopriv_collective_enquiry_form', 'sedgemore_collective_enquiry_form' );

/**
 * Temporary debug endpoint: echoes back POST and headers to help diagnose admin-ajax issues.
 * Remove this in production.
 */
function sedgemore_debug_echo() {
    // Do not perform any destructive action here — it's read-only debug info.
    $payload = array(
        'post' => $_POST,
        'files' => $_FILES,
    );
    if ( function_exists( 'getallheaders' ) ) {
        $payload['headers'] = getallheaders();
    }
    wp_send_json_success( $payload );
}
add_action( 'wp_ajax_sedgemore_debug_echo', 'sedgemore_debug_echo' );
add_action( 'wp_ajax_nopriv_sedgemore_debug_echo', 'sedgemore_debug_echo' );

// Search result fetch
function data_fetch(){

    if( $_POST['keyword'] == ""){
        exit();
    }

    $the_query = new WP_Query( 
        array( 
            'posts_per_page' => -1, 
            's' => esc_attr( $_POST['keyword'] ), 
            'post_type' => array('page','post','team','travel','events')
        ) 
    );
    
    if( $the_query->have_posts() ) :       
            
        echo '<ul>';
            while( $the_query->have_posts() ): $the_query->the_post();  
            
                echo '<li><a href=" '. esc_url( post_permalink() ). '"> '. get_the_title() .'</a></li>';                

            endwhile;
        echo '</ul>';

        wp_reset_postdata();  
    endif;

    die();
}
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');


function handle_newsletter_subscribe() {
    // 1. Security Check: Verify Nonce
    if ( ! isset( $_POST['newsletter_nonce'] ) || ! wp_verify_nonce( $_POST['newsletter_nonce'], 'newsletter_nonce_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
        wp_die();
    }
    if ( ! sedgemore_turnstile_is_valid() ) {
        sedgemore_turnstile_error();
    }

    // 2. Data Validation and Sanitization
    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $email      = sanitize_email( $_POST['email_address'] ?? '' );

    if ( empty( $first_name ) || empty( $last_name ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid or missing data.' ) );
        wp_die();
    }

    // 3. Process the Data 
    $body = '<div>
        <p>
            <strong>See below newsletter request details</strong>
        </p>
        <table>
        <tbody>
            <tr>
                <td><strong>First name:</strong></td>
                <td>'.$first_name.'</td>
            </tr>
            <tr>
                <td><strong>Last name:</strong></td>
                <td>'.$last_name.'</td>
            </tr>            
            <tr>
                <td><strong>Email:</strong></td>
                <td>'.$email.'</td>
            </tr>   
        </tbody>
    </table>
    </div>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Sedgemore <info@sedgemoretravel.com>',
        'Reply-To: '.$first_name. ' '. $last_name .' <'.$email.'>'
    );

    $to =  'info@sedgemoretravel.com';//get_option('admin_email');
    $mail_subject = 'Newsletter signup request';

    $result =  wp_mail( $to, $mail_subject, $body, $headers );
    if( $result ){

        wp_send_json_success( array( 
            'message' => 'Thank you, ' . $first_name . '! Your subscription is confirmed.' 
        ) );
    }else {
        // Mail failed to send (e.g., bad 'From' address, mailer issue)
        wp_send_json_error( array( 
            'message' => 'Subscription successful, but confirmation email failed to send. Please try again later.' 
        ) );
    }

    wp_die(); // Always end with wp_die() in an AJAX handler
}
// For logged-in users
add_action( 'wp_ajax_newsletter_subscribe', 'handle_newsletter_subscribe' );
// For non-logged-in users (public form)
add_action( 'wp_ajax_nopriv_newsletter_subscribe', 'handle_newsletter_subscribe' );


function handle_event_contact_form() {
    // 1. Security Check: Verify Nonce
    if ( ! isset( $_POST['event_contact_nonce'] ) || ! wp_verify_nonce( $_POST['event_contact_nonce'], 'event_contact_nonce_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
        wp_die();
    }
    if ( ! sedgemore_turnstile_is_valid() ) {
        sedgemore_turnstile_error();
    }

    // 2. Data Validation and Sanitization
    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $email      = sanitize_email( $_POST['email_address'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    $message      = sanitize_text_field( $_POST['message'] ?? '' );

    if ( empty( $first_name ) || empty( $last_name ) || ! is_email( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'General form - Invalid or missing data.' ) );
        wp_die();
    }

    // 3. Process the Data 
    $body = '<div>
        <p>
            <strong>See below Sedgemore page general form</strong>
        </p>
        <table>
        <tbody>
            <tr>
                <td><strong>First name:</strong></td>
                <td>'.$first_name.'</td>
            </tr>
            <tr>
                <td><strong>Last name:</strong></td>
                <td>'.$last_name.'</td>
            </tr>            
            <tr>
                <td><strong>Email:</strong></td>
                <td>'.$email.'</td>
            </tr>   
            <tr>
                <td><strong>Phone:</strong></td>
                <td>'.$phone.'</td>
            </tr> 
            <tr>
                <td><strong>Message:</strong></td>
                <td>'.$message.'</td>
            </tr> 
        </tbody>
    </table>
    </div>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Sedgemore <info@sedgemoretravel.com>',
        'Reply-To: '.$first_name. ' '. $last_name .' <'.$email.'>'
    );

    $to =  'info@sedgemoretravel.com';
    $mail_subject = 'Sedgemore Page - General Request';

    $result =  wp_mail( $to, $mail_subject, $body, $headers );
    if( $result ){

        wp_send_json_success( array( 
            'message' => 'Thank you, ' . $first_name . '! Your message has been sent.' 
        ) );
    }else {
        // Mail failed to send (e.g., bad 'From' address, mailer issue)
        global $phpmailer;
        error_log( 'handle_private_villa_contact_form mail failed: ' . print_r( array(
            'to' => $to,
            'subject' => $mail_subject,
            'reply_to_email' => $email,
            'phpmailer_error' => isset( $phpmailer ) && is_object( $phpmailer ) ? $phpmailer->ErrorInfo : '',
        ), true ) );
        wp_send_json_error( array( 
            'message' => 'Contact information received, but confirmation email failed to send. Please try again later.' 
        ) );
    }

    wp_die(); // Always end with wp_die() in an AJAX handler
}
// For logged-in users
add_action( 'wp_ajax_event_contact_form', 'handle_event_contact_form' );
// For non-logged-in users (public form)
add_action( 'wp_ajax_nopriv_event_contact_form', 'handle_event_contact_form' );


function handle_travel_contact_form() {
    // 1. Security Check: Verify Nonce
    if ( ! isset( $_POST['travel_contact_nonce'] ) || ! wp_verify_nonce( $_POST['travel_contact_nonce'], 'travel_contact_nonce_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
        wp_die();
    }
    if ( ! sedgemore_turnstile_is_valid() ) {
        sedgemore_turnstile_error();
    }

    // 2. Data Validation and Sanitization
    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $travel_dates  = sanitize_text_field( $_POST['dates'] ?? '' );
    $preferences  = sanitize_text_field( $_POST['preferences'] ?? '' );
    $email      = sanitize_email( $_POST['email_address'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    $message      = sanitize_text_field( $_POST['message'] ?? '' );
    $form_origin = sanitize_text_field( $_POST['form_origin'] ?? '' );

    $origin_form_options = [
        'itineraries',
        'hotels_and_resorts'
    ];

    if ( empty( $first_name ) || 
            empty( $last_name ) || 
            ! is_email( $email ) || 
            empty( $travel_dates ) || 
            empty( $preferences ) ||
            !in_array( $form_origin, $origin_form_options )
            ) {
        wp_send_json_error( array( 'message' => 'Travel form - Invalid or missing data.' ) );
        wp_die();
    }

    $form_title = ucwords( str_replace('_',' ',$form_origin) );

    // 3. Process the Data 
    $body = '<div>
        <p>
            <strong>Sedgemore Travel - ' . $form_title . ' Form</strong>
        </p>
        <table>
        <tbody>
            <tr>
                <td><strong>First name:</strong></td>
                <td>'.$first_name.'</td>
            </tr>
            <tr>
                <td><strong>Last name:</strong></td>
                <td>'.$last_name.'</td>
            </tr>            
            <tr>
                <td><strong>Email:</strong></td>
                <td>'.$email.'</td>
            </tr>   
            <tr>
                <td><strong>Phone:</strong></td>
                <td>'.$phone.'</td>
            </tr> 
            <tr>
                <td><strong>Travel dates:</strong></td>
                <td>'.$travel_dates.'</td>
            </tr> 
            <tr>
                <td><strong>Accommodation & Dining Preferences or Hotel of Interest:</strong></td>
                <td>'.$preferences.'</td>
            </tr> 
            <tr>
                <td><strong>Special requests / notes:</strong></td>
                <td>'.$message.'</td>
            </tr> 
        </tbody>
    </table>
    </div>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Sedgemore <info@sedgemoretravel.com>',
        'Reply-To: '.$first_name. ' '. $last_name .' <'.$email.'>'
    );

    $to =  'info@sedgemoretravel.com';
    $mail_subject = 'Sedgemore Travel - ' . $form_title . ' Page Request';

    $result =  wp_mail( $to, $mail_subject, $body, $headers );
    if( $result ){

        wp_send_json_success( array( 
            'message' => 'Thank you, ' . $first_name . '! Your message has been sent.' 
        ) );
    }else {
        // Mail failed to send (e.g., bad 'From' address, mailer issue)
        wp_send_json_error( array( 
            'message' => 'Contact information received, but confirmation email failed to send. Please try again later.' 
        ) );
    }

    wp_die(); // Always end with wp_die() in an AJAX handler
}
// For logged-in users
add_action( 'wp_ajax_travel_contact_form', 'handle_travel_contact_form' );
// For non-logged-in users (public form)
add_action( 'wp_ajax_nopriv_travel_contact_form', 'handle_travel_contact_form' );


function handle_yacht_contact_form() {
    // 1. Security Check: Verify Nonce
    if ( ! isset( $_POST['yacht_contact_nonce'] ) || ! wp_verify_nonce( $_POST['yacht_contact_nonce'], 'yacht_contact_nonce_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
        wp_die();
    }
    if ( ! sedgemore_turnstile_is_valid() ) {
        sedgemore_turnstile_error();
    }

    // 2. Data Validation and Sanitization
    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $travel_dates  = sanitize_text_field( $_POST['dates'] ?? '' );
    $destination  = sanitize_text_field( $_POST['destination'] ?? '' );
    $preferences  = sanitize_text_field( $_POST['preferences'] ?? '' );
    $email      = sanitize_email( $_POST['email_address'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    $message      = sanitize_text_field( $_POST['message'] ?? '' );

    if ( empty( $first_name ) || 
            empty( $last_name ) || 
            ! is_email( $email ) || 
            empty( $travel_dates ) || 
            empty ( $destination ) || 
            empty( $preferences ) ||
            empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Yacht Experience form - Invalid or missing data.' ) );
        wp_die();
    }

    // 3. Process the Data 
    $body = '<div>
        <p>
            <strong>Sedgemore Travel - Yacht Experience Form</strong>
        </p>
        <table>
        <tbody>
            <tr>
                <td><strong>First name:</strong></td>
                <td>'.$first_name.'</td>
            </tr>
            <tr>
                <td><strong>Last name:</strong></td>
                <td>'.$last_name.'</td>
            </tr>            
            <tr>
                <td><strong>Email:</strong></td>
                <td>'.$email.'</td>
            </tr>   
            <tr>
                <td><strong>Phone:</strong></td>
                <td>'.$phone.'</td>
            </tr> 
            <tr>
                <td><strong>Travel dates:</strong></td>
                <td>'.$travel_dates.'</td>
            </tr> 
             <tr>
                <td><strong>Destination:</strong></td>
                <td>'.$destination.'</td>
            </tr> 
            <tr>
                <td><strong>Preferred yacht style:</strong></td>
                <td>'.$preferences.'</td>
            </tr> 
            <tr>
                <td><strong>Special requests / notes:</strong></td>
                <td>'.$message.'</td>
            </tr> 
        </tbody>
    </table>
    </div>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Sedgemore <info@sedgemoretravel.com>',
        'Reply-To: '.$first_name. ' '. $last_name .' <'.$email.'>'
    );

    $to =  'info@sedgemoretravel.com';
    $mail_subject = 'Sedgemore Travel - Yacht Experience Page Request';

    $result =  wp_mail( $to, $mail_subject, $body, $headers );
    if( $result ){

        wp_send_json_success( array( 
            'message' => 'Thank you, ' . $first_name . '! Your message has been sent.' 
        ) );
    }else {
        // Mail failed to send (e.g., bad 'From' address, mailer issue)
        wp_send_json_error( array( 
            'message' => 'Contact information received, but confirmation email failed to send. Please try again later.' 
        ) );
    }

    wp_die(); // Always end with wp_die() in an AJAX handler
}
// For logged-in users
add_action( 'wp_ajax_yacht_contact_form', 'handle_yacht_contact_form' );
// For non-logged-in users (public form)
add_action( 'wp_ajax_nopriv_yacht_contact_form', 'handle_yacht_contact_form' );


function handle_private_villa_contact_form() {
    // 1. Security Check: Verify Nonce
    if ( ! isset( $_POST['private_villa_contact_nonce'] ) || ! wp_verify_nonce( $_POST['private_villa_contact_nonce'], 'private_villa_contact_nonce_action' ) ) {
        wp_send_json_error( array( 'message' => 'Private Villa Security check failed.' ) );
        wp_die();
    }
    if ( ! sedgemore_turnstile_is_valid() ) {
        sedgemore_turnstile_error();
    }

    // 2. Data Validation and Sanitization
    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $email      = sanitize_email( $_POST['email_address'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );
    
    $travel_dates  = sanitize_text_field( $_POST['dates'] ?? '' );    
    $no_of_guests  = sanitize_text_field( $_POST['no_of_guests'] ?? '' );    
    $destination  = sanitize_text_field( $_POST['destination'] ?? '' );    
    $message      = sanitize_text_field( $_POST['message'] ?? '' );

    if ( empty( $first_name ) || 
            empty( $last_name ) || 
            ! is_email( $email ) || 
            empty( $travel_dates ) || 
            empty ( $destination ) || 
            empty( $no_of_guests ) ||
            empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Private Villa Experience form - Invalid or missing data.' ) );
        wp_die();
    }

    // 3. Process the Data 
    $body = '<div>
        <p>
            <strong>Sedgemore Travel - Private Villa Travel Form</strong>
        </p>
        <table>
        <tbody>
            <tr>
                <td><strong>First name:</strong></td>
                <td>'.$first_name.'</td>
            </tr>
            <tr>
                <td><strong>Last name:</strong></td>
                <td>'.$last_name.'</td>
            </tr>            
            <tr>
                <td><strong>Email:</strong></td>
                <td>'.$email.'</td>
            </tr>   
            <tr>
                <td><strong>Phone:</strong></td>
                <td>'.$phone.'</td>
            </tr> 
            <tr>
                <td><strong>Travel dates:</strong></td>
                <td>'.$travel_dates.'</td>
            </tr> 
            <tr>
                <td><strong>Number of guests / group size:</strong></td>
                <td>'.$no_of_guests.'</td>
            </tr> 
             <tr>
                <td><strong>Preferred Destination / Region:</strong></td>
                <td>'.$destination.'</td>
            </tr>             
            <tr>
                <td><strong>Special requirements:</strong></td>
                <td>'.$message.'</td>
            </tr> 
        </tbody>
    </table>
    </div>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Sedgemore <info@sedgemoretravel.com>',
        'Reply-To: '.$first_name. ' '. $last_name .' <'.$email.'>'
    );

    $to =  'info@sedgemoretravel.com';
    $mail_subject = 'Sedgemore Travel - Private Villa Page Request';

    $result =  wp_mail( $to, $mail_subject, $body, $headers );
    if( $result ){

        wp_send_json_success( array( 
            'message' => 'Thank you, ' . $first_name . '! Your message has been sent.' 
        ) );
    }else {
        // Mail failed to send (e.g., bad 'From' address, mailer issue)
        var_dump( $result );
        wp_send_json_error( array( 
            'message' => 'Contact information received, but confirmation email failed to send. Please try again later.' 
        ) );
    }

    wp_die(); // Always end with wp_die() in an AJAX handler
}
// For logged-in users
add_action( 'wp_ajax_yacht_private_villa_form', 'handle_private_villa_contact_form' );
add_action( 'wp_ajax_private_villa_contact_form', 'handle_private_villa_contact_form' );
// For non-logged-in users (public form)
add_action( 'wp_ajax_nopriv_private_villa_contact_form', 'handle_private_villa_contact_form' );
