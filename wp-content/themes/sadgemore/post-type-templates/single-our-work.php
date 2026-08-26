<?php
/**
 * The template for displaying Our Work entries.
 *
 * @package sadgemore
 */

get_header();

while ( have_posts() ) :
	the_post();

	$overview      = get_field( 'overview' );
	$main_video    = get_field( 'main_video' );
	$main_image    = get_field( 'main_image' );
	$services_text = get_field( 'services_text' );
	$services_list = get_field( 'services_list' );
	$media_list    = get_field( 'media_list' );
	$media_items   = is_array( $media_list ) ? array_values(
		array_filter(
			$media_list,
			function ( $media_item ) {
				$image = isset( $media_item['image'] ) ? $media_item['image'] : '';
				$video = isset( $media_item['video'] ) ? $media_item['video'] : '';

				return $image || $video;
			}
		)
	) : array();
	$media_count   = count( $media_items );
	?>

	<style>
		@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap');
		.header_bright{display:none}.header_nav_fixed,.header_new{background:#f1eeea}.divider_sharp_bright{display:none!important}.divider_sharp_dark{display:inline-block!important}
		.sedgemore-work-single,.sedgemore-work-single *,.sedgemore-work-single *::before,.sedgemore-work-single *::after{box-sizing:border-box}
		.sedgemore-work-single{--warm-white:#fafaf7;--cream:#f5f2ed;--dark:#1c1a18;--text:#3a3835;--text-light:#7a7672;background:var(--warm-white);color:var(--text);font-family:'Montserrat',sans-serif;font-size:15px;font-weight:300;line-height:1.75;-webkit-font-smoothing:antialiased}
		.sedgemore-work-single .work-hero{background:var(--cream);padding:190px 40px 80px;text-align:center}
		.sedgemore-work-single .eyebrow{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.35em;text-transform:uppercase;color:var(--text-light);margin:0 0 24px}
		.sedgemore-work-single .work-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(38px,5vw,60px);font-weight:300;line-height:1.1;color:var(--dark);margin:0 0 12px;text-transform:none;letter-spacing:.12em}
		.sedgemore-work-single .hero-sub{font-size:12px;font-weight:400;letter-spacing:.2em;text-transform:uppercase;color:var(--text-light);margin:0}
		.sedgemore-work-single .about-section{max-width:1160px;margin:0 auto;padding:100px 40px;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start}
		.sedgemore-work-single .about-text p{font-size:15px;font-weight:300;line-height:1.9;color:var(--text);margin:0 0 20px}
		.sedgemore-work-single .about-text p:last-child{margin-bottom:0}
		.sedgemore-work-single .about-media img,.sedgemore-work-single .about-media video{display:block;width:100%}
		.sedgemore-work-single .about-media img{height:auto}
		.sedgemore-work-single .about-media video{height:clamp(420px,42vw,560px);object-fit:cover;background:#000}
		.sedgemore-work-single .services-section{max-width:1160px;margin:0 auto;padding:80px 40px 100px;display:grid;grid-template-columns:240px 1fr;gap:80px;align-items:start;background:var(--warm-white)!important;color:var(--text)!important}
		.sedgemore-work-single .about-text .services-section{display:block;max-width:none;margin:0;padding:56px 0 0;background:transparent!important}
		.sedgemore-work-single .about-text .services-section>.eyebrow{margin-bottom:24px}
		.sedgemore-work-single .services-copy{font-size:14px;line-height:1.8;color:var(--text-light);margin:-8px 0 28px;max-width:680px}
		.sedgemore-work-single .about-text .services-copy{margin-top:0}
		.sedgemore-work-single .services-list{display:grid;grid-template-columns:1fr 1fr;gap:16px 48px;margin:0;padding:0;list-style:none}
		.sedgemore-work-single .about-text .services-list{grid-template-columns:1fr;gap:14px}
		.sedgemore-work-single .service-item{display:flex;align-items:center;gap:14px}
		.sedgemore-work-single .check{flex:0 0 auto;width:18px;height:18px;border:1px solid var(--text-light);border-radius:50%;display:flex;align-items:center;justify-content:center}
		.sedgemore-work-single .service-item p{font-size:13px;font-weight:300;color:var(--text);line-height:1.5;letter-spacing:.02em;margin:0}
		.sedgemore-work-single .media-section{background:var(--cream);padding:80px 40px}
		.sedgemore-work-single .media-inner{max-width:1160px;margin:0 auto}
		.sedgemore-work-single .media-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
		.sedgemore-work-single .media-grid.media-count-1{grid-template-columns:minmax(0,900px);justify-content:center}
		.sedgemore-work-single .media-grid.media-count-2{grid-template-columns:repeat(2,minmax(0,1fr));max-width:1040px;margin:0 auto}
		.sedgemore-work-single .media-item img,.sedgemore-work-single .media-item video{display:block;width:100%;height:100%;object-fit:cover;background:#000}
		.sedgemore-work-single .media-item{min-height:300px;overflow:hidden}
		.sedgemore-work-single .media-grid.media-count-1 .media-item{min-height:520px}
		.sedgemore-work-single .media-grid.media-count-2 .media-item{min-height:430px}
		.sedgemore-work-single .enquiry-section{padding:100px 40px;max-width:1000px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:80px;align-items:start}
		.sedgemore-work-single .enquiry-left h2{font-family:'Cormorant Garamond',serif!important;font-size:clamp(30px,3vw,42px);font-weight:300!important;line-height:1.25;color:var(--dark);margin:0 0 20px;letter-spacing:0;font-synthesis-weight:none}
		.sedgemore-work-single .enquiry-left h2 em{font-weight:300!important;font-style:italic}
		.sedgemore-work-single .enquiry-left p:not(.eyebrow){font-size:14px;font-weight:300;color:var(--text-light);line-height:1.85;margin:0}
		.sedgemore-work-single .enquiry-form{display:flex;flex-direction:column;gap:20px}
		.sedgemore-work-single .form-row{display:grid;grid-template-columns:1fr 1fr;gap:20px}
		.sedgemore-work-single .form-field input,.sedgemore-work-single .form-field textarea{font-family:'Montserrat',sans-serif;font-size:13px;font-weight:300;color:var(--text);background:transparent;border:none;border-bottom:1px solid #c8c4be;padding:10px 0;outline:none;transition:border-color .2s;width:100%;resize:none;appearance:none}
		.sedgemore-work-single .form-field textarea{height:80px}
		.sedgemore-work-single .form-field input::placeholder,.sedgemore-work-single .form-field textarea::placeholder{color:var(--text-light);font-size:12px;letter-spacing:.05em}
		.sedgemore-work-single .form-field input:focus,.sedgemore-work-single .form-field textarea:focus{border-bottom-color:var(--dark)}
		.sedgemore-work-single .form-field label{display:none}
		.sedgemore-work-single .error-message{font-size:11px;color:#8b3a2f;margin-top:6px;min-height:14px}
		.sedgemore-work-single .form-submit{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.25em;text-transform:uppercase;background:var(--dark);color:#fff;border:1px solid var(--dark);padding:16px;cursor:pointer;width:100%;transition:background .25s,color .25s;margin-top:8px}
		.sedgemore-work-single .form-submit:hover{background:#fff;color:var(--dark)}
		.sedgemore-work-single #our-work-single-form-message{font-size:12px;color:var(--text-light);margin:0;min-height:0}
		.sedgemore-work-single #our-work-single-form-message.success{color:#3d6b45}
		.sedgemore-work-single #our-work-single-form-message.error{color:#8b3a2f}
		@media (max-width:900px){.sedgemore-work-single .work-hero{padding:150px 24px 72px}.sedgemore-work-single .about-section,.sedgemore-work-single .services-section,.sedgemore-work-single .enquiry-section{grid-template-columns:1fr;gap:40px}.sedgemore-work-single .about-media video{height:420px}.sedgemore-work-single .media-grid,.sedgemore-work-single .media-grid.media-count-2{grid-template-columns:1fr 1fr}.sedgemore-work-single .media-grid.media-count-1{grid-template-columns:1fr}.sedgemore-work-single .media-grid.media-count-1 .media-item{min-height:460px}.sedgemore-work-single .form-row{grid-template-columns:1fr}}
		@media (max-width:600px){.sedgemore-work-single .about-section,.sedgemore-work-single .services-section,.sedgemore-work-single .media-section,.sedgemore-work-single .enquiry-section{padding-left:24px;padding-right:24px}.sedgemore-work-single .about-media video{height:320px}.sedgemore-work-single .services-list,.sedgemore-work-single .media-grid,.sedgemore-work-single .media-grid.media-count-1,.sedgemore-work-single .media-grid.media-count-2{grid-template-columns:1fr}.sedgemore-work-single .media-item,.sedgemore-work-single .media-grid.media-count-1 .media-item,.sedgemore-work-single .media-grid.media-count-2 .media-item{min-height:240px}}
	</style>

	<div class="header_nav nav-menu">
		<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
		<div class="clear"></div>
	</div>

	<main class="sedgemore-work-single">
		<section class="work-hero">
			<p class="eyebrow">Our Work</p>
			<?php the_title( '<h1>', '</h1>' ); ?>
			<?php if ( $overview ) : ?>
				<p class="hero-sub"><?php echo wp_kses_post( $overview ); ?></p>
			<?php endif; ?>
		</section>

		<section class="about-section">
			<div class="about-text">
				<p class="eyebrow">About the Project</p>
				<?php the_content(); ?>
				<?php if ( $services_text || ! empty( $services_list ) ) : ?>
					<section class="services-section">
						<p class="eyebrow">Services Provided</p>
						<div>
							<?php if ( $services_text ) : ?>
								<div class="services-copy"><?php echo wp_kses_post( wpautop( $services_text ) ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $services_list ) ) : ?>
								<ul class="services-list">
									<?php foreach ( $services_list as $list ) : ?>
										<?php $service = isset( $list['service'] ) ? $list['service'] : ''; ?>
										<?php if ( $service ) : ?>
											<li class="service-item">
												<span class="check" aria-hidden="true">
													<svg viewBox="0 0 10 8" width="9" height="9" fill="none" xmlns="http://www.w3.org/2000/svg"><polyline points="1,4 4,7 9,1" stroke="#7A7672" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
												</span>
												<p><?php echo esc_html( $service ); ?></p>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>
			</div>
			<div class="about-media">
				<?php if ( $main_video ) : ?>
					<video autoplay muted loop playsinline preload="metadata">
						<source src="<?php echo esc_url( $main_video ); ?>" type="video/mp4">
					</video>
				<?php elseif ( $main_image ) : ?>
					<?php
					$main_image_id = attachment_url_to_postid( $main_image );
					if ( $main_image_id ) {
						echo wp_get_attachment_image( $main_image_id, 'large', false, array( 'loading' => 'eager' ) );
					}
					?>
				<?php elseif ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
				<?php endif; ?>
			</div>
		</section>

		<?php if ( $media_count ) : ?>
			<section class="media-section">
				<div class="media-inner">
					<p class="eyebrow">From the Event</p>
					<div class="media-grid media-count-<?php echo esc_attr( min( $media_count, 3 ) ); ?>">
						<?php foreach ( $media_items as $media_item ) : ?>
							<?php
							$video = isset( $media_item['video'] ) ? $media_item['video'] : '';
							$image = isset( $media_item['image'] ) ? $media_item['image'] : '';
							?>
							<div class="media-item">
								<?php if ( $image ) : ?>
									<?php
									$image_id = attachment_url_to_postid( $image );
									if ( $image_id ) {
										echo wp_get_attachment_image( $image_id, 'large', false, array( 'loading' => 'lazy' ) );
									}
									?>
								<?php elseif ( $video ) : ?>
									<video autoplay muted loop playsinline preload="metadata">
										<source src="<?php echo esc_url( $video ); ?>" type="video/mp4">
									</video>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<section id="contact__form" class="enquiry-section">
			<div class="enquiry-left">
				<p class="eyebrow">Work With Us</p>
				<h2>Begin your next <em>experience</em></h2>
				<p>Tell us about your event, your guests, and what you are hoping to create. We will be in touch to explore what is possible.</p>
			</div>
			<form id="our-work-single-form" class="enquiry-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<div class="form-row">
					<div class="form-field">
						<label for="event__first_name">First Name*</label>
						<input type="text" id="event__first_name" name="first_name" placeholder="First Name*" required>
						<div class="error-message" data-field="event__first_name"></div>
					</div>
					<div class="form-field">
						<label for="event__last_name">Last Name*</label>
						<input type="text" id="event__last_name" name="last_name" placeholder="Last Name*" required>
						<div class="error-message" data-field="event__last_name"></div>
					</div>
				</div>
				<div class="form-field">
					<label for="event__email_address">Email Address*</label>
					<input type="email" id="event__email_address" name="email_address" placeholder="Email Address*" required>
					<div class="error-message" data-field="event__email_address"></div>
				</div>
				<div class="form-field">
					<label for="event__phone">Phone</label>
					<input type="text" id="event__phone" name="phone" placeholder="Phone">
					<div class="error-message" data-field="event__phone"></div>
				</div>
				<div class="form-field">
					<label for="event__message">Message</label>
					<textarea id="event__message" name="message" placeholder="Message" required></textarea>
					<div class="error-message" data-field="event__message"></div>
				</div>
				<button type="submit" id="event__submit-btn" class="form-submit">Send Enquiry</button>
				<p id="our-work-single-form-message" aria-live="polite"></p>
				<input type="hidden" name="action" value="event_contact_form">
				<?php wp_nonce_field( 'event_contact_nonce_action', 'event_contact_nonce' ); ?>
			</form>
		</section>
	</main>

	<script>
	document.addEventListener('DOMContentLoaded', function () {
		var form = document.getElementById('our-work-single-form');
		var message = document.getElementById('our-work-single-form-message');
		var submitButton = document.getElementById('event__submit-btn');

		if (!form || !message || !submitButton) {
			return;
		}

		form.addEventListener('submit', function (event) {
			event.preventDefault();

			if (!form.checkValidity()) {
				message.textContent = 'Please complete all required fields.';
				message.classList.remove('success');
				message.classList.add('error');
				form.reportValidity();
				return;
			}

			message.textContent = '';
			message.classList.remove('success', 'error');

			var originalButtonText = submitButton.textContent;
			submitButton.disabled = true;
			submitButton.textContent = 'SENDING';
			submitButton.setAttribute('aria-busy', 'true');

			var ajaxUrl = (window.myAjaxEvent && window.myAjaxEvent.ajaxurl) || form.getAttribute('action');

			fetch(ajaxUrl, {
				method: 'POST',
				body: new FormData(form),
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
						message.textContent = (data.data && data.data.message) ? data.data.message : 'Thank you. Your message has been sent.';
						message.classList.add('success');
						form.reset();
						return;
					}

					message.textContent = (data && data.data && data.data.message) ? data.data.message : 'An error occurred during submission.';
					message.classList.add('error');
				})
				.catch(function () {
					message.textContent = 'Network error. Please try again.';
					message.classList.add('error');
				})
				.finally(function () {
					submitButton.disabled = false;
					submitButton.textContent = originalButtonText;
					submitButton.removeAttribute('aria-busy');
				});
		});
	});
	</script>

	<?php
endwhile;

get_footer();
