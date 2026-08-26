<?php
/**
 * Template Name: Our Work
 *
 * @package sadgemore
 */

get_header();

$upload_dir = wp_upload_dir();
$upload_base = trailingslashit( $upload_dir['baseurl'] ) . '2026/06/';

$get_field_value = function( $field_name, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $field_name );
		return ( null !== $value && '' !== $value && array() !== $value ) ? $value : $default;
	}

	return $default;
};

$image_url = function( $image, $default = '' ) {
	if ( is_array( $image ) ) {
		if ( ! empty( $image['url'] ) ) {
			return $image['url'];
		}

		if ( ! empty( $image['ID'] ) ) {
			return wp_get_attachment_image_url( $image['ID'], 'full' );
		}
	}

	if ( is_numeric( $image ) ) {
		return wp_get_attachment_image_url( (int) $image, 'full' );
	}

	if ( is_string( $image ) && '' !== $image ) {
		return $image;
	}

	return $default;
};

$hero_eyebrow = $get_field_value( 'our_work_hero_eyebrow', 'Our Work' );
$hero_title = $get_field_value( 'our_work_hero_title', 'A glimpse of what we <em>create</em>' );
$hero_intro = $get_field_value( 'our_work_hero_intro', 'A selection of past projects and collaborations that reflect our commitment to craft, considered detail, and extraordinary experience.' );

$default_gallery = array(
	array( 'title' => 'Van Cleef & Arpels', 'location' => 'London', 'image' => $upload_base . 'Van-Cleef-Arpels.svg', 'url' => '/our-work/van-cleef-arpels' ),
	array( 'title' => 'Hermès', 'location' => 'Paris', 'image' => $upload_base . 'HermSs.svg', 'url' => '/our-work/hermes' ),
	array( 'title' => 'Alexander McQueen', 'location' => 'London', 'image' => $upload_base . 'Alexander-McQueen.svg', 'url' => '/our-work/alexander-mcqueen' ),
	array( 'title' => 'Harrods', 'location' => 'United Kingdom', 'image' => $upload_base . 'Harrods.svg', 'url' => '/our-work/harrods' ),
	array( 'title' => 'Chopard', 'location' => 'London', 'image' => $upload_base . 'CHOPARD.svg', 'url' => '/our-work/chopard' ),
	array( 'title' => 'International Art Foundation', 'location' => 'Brazil', 'image' => $upload_base . 'International-Art-Foundation.svg', 'url' => '/our-work/international-art-foundation' ),
	array( 'title' => 'Salesforce', 'location' => 'Palau', 'image' => $upload_base . 'Salesforce.svg', 'url' => '/our-work/salesforce' ),
	array( 'title' => 'High End Corporate Client', 'location' => 'Sardinia', 'image' => $upload_base . 'High-End-Corporate-Client.svg', 'url' => '/our-work/high-end-corporate-client' ),
	array( 'title' => 'Investment Company', 'location' => 'St. Moritz, Swiss Alps', 'image' => $upload_base . 'Investment-Company.svg', 'url' => '/our-work/investment-company' ),
);

$gallery_items = $get_field_value( 'our_work_gallery', $default_gallery );
if ( empty( $gallery_items ) || ! is_array( $gallery_items ) ) {
	$gallery_items = $default_gallery;
}

$gallery_items = array_values( $gallery_items );
$gallery_links = array(
	'International Art Foundation' => '/our-work/international-art-foundation',
	'Investment Company' => '/our-work/investment-company',
	'Salesforce' => '/our-work/salesforce',
	'High End Corporate Client' => '/our-work/high-end-corporate-client',
	'Van Cleef & Arpels' => '/our-work/van-cleef-arpels',
	'Alexander McQueen' => '/our-work/alexander-mcqueen',
	'Harrods' => '/our-work/harrods',
	'Hermès' => '/our-work/hermes',
	'Hermes' => '/our-work/hermes',
	'Chopard' => '/our-work/chopard',
);
$gallery_rows = array_chunk( $gallery_items, 3 );

$statement_eyebrow = $get_field_value( 'our_work_statement_eyebrow', 'Work With Us' );
$statement_title = $get_field_value( 'our_work_statement_title', 'Every project begins with a <em>conversation</em>' );
$statement_text = $get_field_value( 'our_work_statement_text', 'We work with clients and partners who value thoughtful design and exceptional execution. Each brief is taken on selectively, and given our full attention.' );
$statement_button = $get_field_value( 'our_work_statement_button', 'Begin a Conversation' );

$enquiry_eyebrow = $get_field_value( 'our_work_enquiry_eyebrow', 'Connect' );
$enquiry_title = $get_field_value( 'our_work_enquiry_title', 'Shape your next <em>experience</em>' );
$enquiry_text = $get_field_value( 'our_work_enquiry_text', 'Tell us about your project, your vision, or simply what you are hoping to feel. We will be in touch to explore what is possible.' );
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

<style type="text/css">
.header_bright{display:block}.header_dark{display:none}.header_nav_fixed{background:#f1eeea}.divider_sharp_bright{display:none!important}.divider_sharp_dark{display:inline-block!important}
.our-work-page,.our-work-page *,.our-work-page *::before,.our-work-page *::after{box-sizing:border-box;margin:0;padding:0}.our-work-page{--warm-white:#FAFAF7;--cream:#F5F2ED;--charcoal:#2A2A27;--dark:#1C1A18;--text:#3A3835;--text-light:#7A7672;background:var(--warm-white);color:var(--text);font-family:'Montserrat',sans-serif;font-size:15px;font-weight:300;-webkit-font-smoothing:antialiased;overflow-x:hidden}.our-work-page a{text-decoration:none;color:inherit}
.our-work-page .hero{background-color:var(--cream);padding:100px 40px 80px;text-align:center}.our-work-page .hero-eyebrow,.our-work-page .eyebrow{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.35em;text-transform:uppercase;color:var(--text-light);margin-bottom:24px}.our-work-page .hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(42px,5vw,64px);font-weight:300;line-height:1.15;color:var(--dark);margin:0 auto 24px;max-width:700px}.our-work-page em{font-style:italic}.our-work-page .hero-intro{font-size:15px;font-weight:300;color:var(--text-light);max-width:520px;margin:0 auto;line-height:1.8}
.our-work-page .gallery-section{padding:60px 40px 100px;max-width:1240px;margin:0 auto}.our-work-page .gallery-grid,.our-work-page .gallery-row{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;align-items:start}.our-work-page .gallery-row{margin-top:28px}.our-work-page .gallery-item{display:block}.our-work-page .gallery-img-wrap{overflow:hidden;background-color:var(--cream);aspect-ratio:4/3}.our-work-page .gallery-img-wrap img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s ease}.our-work-page .gallery-item:hover .gallery-img-wrap img{transform:scale(1.04)}.our-work-page .gallery-caption{padding:18px 0 0}.our-work-page .gallery-caption-title{font-family:'Cormorant Garamond',serif;font-size:19px;font-weight:400;color:var(--dark);margin-bottom:4px}.our-work-page .gallery-caption-location{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:400;letter-spacing:.2em;text-transform:uppercase;color:var(--text-light)}
.our-work-page .section-divider{border:none;border-top:1px solid #E0DDD8;max-width:1160px;margin:0 auto}.our-work-page .statement-band{background-color:var(--cream);padding:80px 40px;text-align:center}.our-work-page .statement-band .eyebrow{margin-bottom:28px}.our-work-page .statement-band h2{font-family:'Cormorant Garamond',serif;font-size:clamp(32px,3.5vw,50px);font-weight:300;line-height:1.25;color:var(--dark);max-width:680px;margin:0 auto 36px}.our-work-page .statement-band p:not(.eyebrow){font-size:15px;font-weight:300;color:var(--text-light);max-width:520px;margin:0 auto 40px;line-height:1.85}.our-work-page .btn-primary{display:inline-block;font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.25em;text-transform:uppercase;background-color:var(--dark);color:#fff;padding:16px 36px;text-decoration:none;transition:background-color .25s,color .25s;border:1px solid var(--dark)}.our-work-page .btn-primary:hover{background-color:#fff;color:var(--dark)}
.our-work-page .enquiry-section{padding:100px 40px;max-width:1000px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:80px;align-items:start}.our-work-page .enquiry-left .eyebrow{margin-bottom:24px}.our-work-page .enquiry-left h2{font-family:'Cormorant Garamond',serif;font-size:clamp(30px,3vw,42px);font-weight:300;line-height:1.25;color:var(--dark);margin-bottom:20px}.our-work-page .enquiry-left p:not(.eyebrow){font-size:14px;font-weight:300;color:var(--text-light);line-height:1.85}.our-work-page .enquiry-form{display:flex;flex-direction:column;gap:20px}.our-work-page .form-row{display:grid;grid-template-columns:1fr 1fr;gap:20px}.our-work-page .form-field label,.our-work-page .screen-reader-text{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.our-work-page .form-field input,.our-work-page .form-field textarea,.our-work-page .form-field select{font-family:'Montserrat',sans-serif;font-size:13px;font-weight:300;color:var(--text);background:transparent;border:none;border-bottom:1px solid #C8C4BE;padding:10px 0;outline:none;transition:border-color .2s;width:100%;border-radius:0}.our-work-page .form-field input::placeholder,.our-work-page .form-field textarea::placeholder{color:var(--text-light);font-size:12px;letter-spacing:.05em}.our-work-page .form-field input:focus,.our-work-page .form-field textarea:focus,.our-work-page .form-field select:focus{border-bottom-color:var(--dark)}.our-work-page .form-field textarea{resize:none;height:80px}.our-work-page .form-message{font-size:12px;color:var(--text-light);min-height:18px}.our-work-page .form-message.success{color:#3d6b45}.our-work-page .form-message.error{color:#8b3a2f}.our-work-page .form-submit{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.25em;text-transform:uppercase;background-color:var(--dark);color:#fff;border:1px solid var(--dark);padding:16px;cursor:pointer;width:100%;transition:background-color .25s,color .25s;margin-top:8px}.our-work-page .form-submit:hover{background-color:#fff;color:var(--dark)}.our-work-page .form-submit:disabled{cursor:wait;opacity:.7}
@media (max-width:900px){.our-work-page .gallery-grid,.our-work-page .gallery-row{grid-template-columns:1fr 1fr}.our-work-page .enquiry-section{grid-template-columns:1fr;gap:40px}.our-work-page .form-row{grid-template-columns:1fr}}
@media (max-width:600px){.our-work-page .gallery-grid,.our-work-page .gallery-row{grid-template-columns:1fr}.our-work-page .hero,.our-work-page .gallery-section,.our-work-page .statement-band,.our-work-page .enquiry-section{padding-left:24px;padding-right:24px}}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="our-work-page" id="primary">
	<section class="hero">
		<p class="hero-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
		<h1><?php echo wp_kses_post( $hero_title ); ?></h1>
		<p class="hero-intro"><?php echo esc_html( $hero_intro ); ?></p>
	</section>

	<section class="gallery-section">
		<?php foreach ( $gallery_rows as $row_index => $row_items ) : ?>
			<div class="<?php echo 0 === $row_index ? 'gallery-grid' : 'gallery-row'; ?>">
				<?php foreach ( $row_items as $item ) : ?>
					<?php
					$title = $item['title'] ?? '';
					$location = $item['location'] ?? '';
					$src = $image_url( $item['image'] ?? '', '' );
					$url = $item['url'] ?? ( $gallery_links[ $title ] ?? '' );
					?>
					<?php if ( $url ) : ?>
						<a class="gallery-item" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( sprintf( 'View %s', wp_strip_all_tags( $title ) ) ); ?>">
					<?php else : ?>
						<div class="gallery-item">
					<?php endif; ?>
						<?php if ( $src ) : ?>
							<div class="gallery-img-wrap">
								<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>">
							</div>
						<?php endif; ?>
						<div class="gallery-caption">
							<?php if ( $title ) : ?>
								<p class="gallery-caption-title"><?php echo esc_html( $title ); ?></p>
							<?php endif; ?>
							<?php if ( $location ) : ?>
								<p class="gallery-caption-location"><?php echo esc_html( $location ); ?></p>
							<?php endif; ?>
						</div>
					<?php if ( $url ) : ?>
						</a>
					<?php else : ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
	</section>

	<hr class="section-divider">

	<section class="statement-band">
		<p class="eyebrow"><?php echo esc_html( $statement_eyebrow ); ?></p>
		<h2><?php echo wp_kses_post( $statement_title ); ?></h2>
		<p><?php echo esc_html( $statement_text ); ?></p>
		<a href="#enquiry" class="btn-primary"><?php echo esc_html( $statement_button ); ?></a>
	</section>

	<section class="enquiry-section" id="enquiry">
		<div class="enquiry-left">
			<p class="eyebrow"><?php echo esc_html( $enquiry_eyebrow ); ?></p>
			<h2><?php echo wp_kses_post( $enquiry_title ); ?></h2>
			<p><?php echo esc_html( $enquiry_text ); ?></p>
		</div>
		<form id="our-work-enquiry-form" class="enquiry-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
			<input type="hidden" name="action" value="home_form">
			<input type="hidden" name="form_title" value="Our Work Enquiry">
			<input type="hidden" name="form_heading" value="our work enquiry details">
			<input type="hidden" name="topic[]" value="Our Work Enquiry">
			<?php wp_nonce_field( 'home_nonce_action', 'home_nonce' ); ?>

			<div class="form-row">
				<div class="form-field">
					<label for="our_work_first_name">First Name *</label>
					<input id="our_work_first_name" type="text" name="first_name" placeholder="First Name*" required>
				</div>
				<div class="form-field">
					<label for="our_work_last_name">Last Name *</label>
					<input id="our_work_last_name" type="text" name="last_name" placeholder="Last Name*" required>
				</div>
			</div>

			<div class="form-field">
				<label for="our_work_email">Email Address *</label>
				<input id="our_work_email" type="email" name="email" placeholder="Email Address*" required>
			</div>
			<div class="form-field">
				<label for="our_work_phone">Phone</label>
				<input id="our_work_phone" type="tel" name="phone" placeholder="Phone">
			</div>
			<div class="form-field">
				<label for="our_work_message">Message *</label>
				<textarea id="our_work_message" name="message" placeholder="Message" required></textarea>
			</div>
			<div id="our-work-form-message" class="form-message" aria-live="polite"></div>
			<button class="form-submit" type="submit">Send Enquiry</button>
		</form>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var enquiryForm = document.getElementById('our-work-enquiry-form');
	var enquiryMessage = document.getElementById('our-work-form-message');

	if (!enquiryForm || !enquiryMessage || typeof myAjaxObject === 'undefined') {
		return;
	}

	enquiryForm.addEventListener('submit', function (e) {
		e.preventDefault();

		if (!enquiryForm.checkValidity()) {
			enquiryMessage.textContent = 'Please complete all required fields.';
			enquiryMessage.classList.remove('success');
			enquiryMessage.classList.add('error');
			enquiryForm.reportValidity();
			return;
		}

		enquiryMessage.textContent = '';
		enquiryMessage.classList.remove('success', 'error');

		var submitButton = enquiryForm.querySelector('.form-submit');
		var originalButtonText = submitButton ? submitButton.textContent : '';

		if (submitButton) {
			submitButton.disabled = true;
			submitButton.textContent = 'Sending...';
			submitButton.setAttribute('aria-busy', 'true');
		}

		fetch(myAjaxObject.ajaxurl, {
			method: 'POST',
			body: new FormData(enquiryForm),
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			credentials: 'same-origin'
		})
			.then(function (response) {
				if (response.ok) {
					return response.json();
				}

				return response.text().then(function (text) {
					throw new Error(text || 'Server error.');
				});
			})
			.then(function (data) {
				if (data && data.success) {
					enquiryMessage.textContent = (data.data && data.data.message) ? data.data.message : 'Thank you. Your message has been sent.';
					enquiryMessage.classList.add('success');
					enquiryForm.reset();
					return;
				}

				enquiryMessage.textContent = (data && data.data && data.data.message) ? data.data.message : 'An error occurred during submission.';
				enquiryMessage.classList.add('error');
			})
			.catch(function () {
				enquiryMessage.textContent = 'Network error. Please try again.';
				enquiryMessage.classList.add('error');
			})
			.finally(function () {
				if (submitButton) {
					submitButton.disabled = false;
					submitButton.textContent = originalButtonText;
					submitButton.removeAttribute('aria-busy');
				}
			});
	});
});
</script>

<?php
get_footer();
