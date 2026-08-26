<?php
/**
 * Template Name: Membership
 *
 * @package sadgemore
 */

get_header();

$upload_dir  = wp_upload_dir();
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

$default_hero_slides = array(
	array( 'image' => $upload_base . '3-North-Island-The-Spa-Relaxation-Area-View.jpg' ),
	array( 'image' => $upload_base . '13-North-Island-Activities-Stand-Up-Paddle-Board.jpg' ),
	array( 'image' => $upload_base . 'Classique-Hivernage-Twin.jpg' ),
	array( 'image' => $upload_base . 'Reschio-Hotel-The-Swimming-Pool-2.jpg' ),
	array( 'image' => $upload_base . 'Singita-Kruger-National-Park_Three-Lions.jpg' ),
);

$hero_slides = $get_field_value( 'membership_hero_slides', $default_hero_slides );
if ( ! is_array( $hero_slides ) || empty( $hero_slides ) ) {
	$hero_slides = $default_hero_slides;
}
$hero_slides = array_values(
	array_filter(
		$hero_slides,
		function ( $slide ) use ( $image_url ) {
			return (bool) $image_url( $slide['image'] ?? $slide, '' );
		}
	)
);
if ( empty( $hero_slides ) ) {
	$hero_slides = $default_hero_slides;
}

$hero_eyebrow = $get_field_value( 'membership_hero_eyebrow', 'Sedgemore Privé &nbsp;&middot;&nbsp; By Invitation' );
$hero_title   = $get_field_value( 'membership_hero_title', 'A Circle of Those<br>Who Travel <em>Differently.</em>' );
$hero_intro   = $get_field_value( 'membership_hero_intro', 'Sedgemore Privé is a closed membership for those who believe travel is one of life\'s great arts. Not a transaction, but a crafted experience built entirely around you.' );
$hero_button  = $get_field_value( 'membership_hero_button', 'Request an Invitation' );

$intro_title = $get_field_value( 'membership_intro_title', 'Every detail,<br><em>considered.</em>' );
$intro_text  = $get_field_value( 'membership_intro_text', 'Sedgemore Privé is a membership for those who travel often and expect more. We offer a refined layer of continuity, access, and care across every journey. As a member, you are supported by a dedicated advisor who understands your preferences and anticipates your needs, offering a seamless experience from trip to trip.' );

$tiers_label = $get_field_value( 'membership_tiers_label', 'Membership' );
$tiers_title = $get_field_value( 'membership_tiers_title', 'Three tiers.<br><em>One standard of excellence.</em>' );
$tiers_text  = $get_field_value( 'membership_tiers_text', 'Each level of Privé membership is designed around a different pace of travel. Choose the one that fits how you move through the world.' );

$default_tiers = array(
	array( 'name' => 'Astra', 'tagline' => 'The Beginning of Something', 'body' => '<p>Two beautifully crafted journeys each year, with ten concierge bookings for dining, spa, and transfers.</p><p>Dedicated support during waking hours, with hotel upgrades and seamless arrivals as standard.</p>', 'featured' => false ),
	array( 'name' => 'Lumen', 'tagline' => 'For the Frequent Traveller', 'body' => '<p>Four bespoke journeys a year, with fifteen concierge bookings and priority access throughout.</p><p>Around-the-clock support via phone and WhatsApp, with a lifestyle manager who is personally familiar with how you travel.</p>', 'featured' => true ),
	array( 'name' => 'Celeste', 'tagline' => 'Boundless, By Definition', 'body' => '<p>Unlimited journeys and unlimited concierge access, 24 hours a day, with a dedicated lifestyle manager reachable by phone, email, and WhatsApp at any hour.</p><p>Access to sold-out events worldwide. No ceilings, no limits.</p>', 'featured' => false ),
);
$tiers = $get_field_value( 'membership_tiers', $default_tiers );
if ( ! is_array( $tiers ) || empty( $tiers ) ) {
	$tiers = $default_tiers;
}

$interest_label = $get_field_value( 'membership_interest_label', 'Not Yet a Member' );
$interest_title = $get_field_value( 'membership_interest_title', 'Register Your <em>Interest</em>' );
$interest_text  = $get_field_value( 'membership_interest_text', 'Sedgemore Privé membership is extended through personal invitation. Share a few details and our membership team will be in touch discreetly should an opening arise. Your details are held in complete confidence and will never be shared or used for marketing purposes.' );
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

<style type="text/css">
.header_bright{display:block}.header_dark{display:none}.header_nav_fixed{background:#f1eeea}.divider_sharp_bright{display:none!important}.divider_sharp_dark{display:inline-block!important}
.membership-page,.membership-page *,.membership-page *::before,.membership-page *::after{box-sizing:border-box;margin:0;padding:0}.membership-page{--warm-white:#FAFAF7;--cream:#F5F2ED;--charcoal:#2A2A27;--dark:#1C1A18;--text:#3A3835;--text-light:#7A7672;background:var(--warm-white);color:var(--text);font-family:'Montserrat',sans-serif;font-size:15px;line-height:1.7;-webkit-font-smoothing:antialiased;overflow-x:hidden}.membership-page a{text-decoration:none;color:inherit}.membership-page em{font-style:italic}
.membership-page .hero{position:relative;width:100%;height:92vh;min-height:600px;overflow:hidden;display:flex;align-items:flex-end;background:#1c1a18}.membership-page .hero-slides,.membership-page .hero-slide{position:absolute;inset:0}.membership-page .hero-slide{background-size:100% auto;background-position:center;background-repeat:no-repeat;opacity:0;transition:opacity 1.2s ease-in-out}.membership-page .hero-slide.active{opacity:1}.membership-page .hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(14,12,10,.78) 0%,rgba(14,12,10,.3) 50%,rgba(14,12,10,.08) 100%);z-index:1}.membership-page .hero-content{position:relative;z-index:2;padding:0 72px 80px;max-width:780px}.membership-page .hero-eyebrow,.membership-page .section-label{font-family:'Montserrat',sans-serif;font-size:10px;letter-spacing:.35em;text-transform:uppercase;color:var(--text-light);margin-bottom:28px;display:block}.membership-page .hero-eyebrow{color:rgba(255,255,255,.55)}.membership-page .hero h1{font-family:'Cormorant Garamond',serif;font-weight:300;font-size:clamp(52px,7vw,88px);line-height:1;color:#fff;margin-bottom:28px}.membership-page .hero-sub{font-size:14px;color:rgba(255,255,255,.65);font-weight:300;max-width:420px;line-height:1.85;margin-bottom:48px}.membership-page .hero-dots{position:absolute;bottom:36px;right:72px;z-index:3;display:flex;gap:8px;align-items:center}.membership-page .hero-dot{width:20px;height:1px;background:rgba(255,255,255,.3);border:0;padding:0;cursor:pointer;transition:background .3s,width .3s}.membership-page .hero-dot.active{background:rgba(255,255,255,.85);width:36px}.membership-page .btn-primary{background:#fff;color:var(--dark);font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.2em;text-transform:uppercase;padding:15px 36px;border:1px solid #fff;cursor:pointer;text-decoration:none;display:inline-block;transition:background .25s,color .25s}.membership-page .btn-primary:hover{background:transparent;color:#fff}.membership-page .btn-primary.dark{background:var(--dark);color:#fff;border-color:var(--dark)}.membership-page .btn-primary.dark:hover{background:#fff;color:var(--dark)}
.membership-page .intro-band{background:var(--warm-white);display:grid;grid-template-columns:1fr 1fr;align-items:center;border-bottom:1px solid rgba(58,56,53,.1)}.membership-page .intro-left{padding:80px 72px;border-right:1px solid rgba(58,56,53,.1)}.membership-page .intro-left h2{font-family:'Cormorant Garamond',serif;font-size:clamp(38px,4.5vw,56px);font-weight:300;color:var(--dark);line-height:1.1}.membership-page .intro-right{padding:80px 72px}.membership-page .intro-right p{font-size:14px;color:var(--text-light);font-weight:300;line-height:1.9;max-width:440px}
.membership-page .tiers-section{background:var(--warm-white);padding:100px 72px}.membership-page .tiers-header{margin-bottom:56px;max-width:600px}.membership-page .tiers-header h2{font-family:'Cormorant Garamond',serif;font-size:clamp(38px,4.5vw,54px);font-weight:300;color:var(--dark);line-height:1.1;margin:16px 0 20px}.membership-page .tiers-sub{font-size:14px;color:var(--text-light);font-weight:300;line-height:1.85}.membership-page .tiers-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px}.membership-page .tier{background:var(--cream);padding:52px 44px}.membership-page .tier.featured{background:var(--dark)}.membership-page .tier-name{font-family:'Cormorant Garamond',serif;font-size:42px;font-weight:300;color:var(--dark);margin-bottom:6px}.membership-page .tier.featured .tier-name{color:#fff}.membership-page .tier-tagline{font-family:'Montserrat',sans-serif;font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:var(--text-light);margin-bottom:36px;display:block}.membership-page .tier.featured .tier-tagline{color:rgba(255,255,255,.4)}.membership-page .tier-divider{width:28px;height:1px;background:rgba(58,56,53,.2);margin-bottom:32px}.membership-page .tier.featured .tier-divider{background:rgba(255,255,255,.18)}.membership-page .tier-body{font-size:14px;color:var(--text-light);font-weight:300;line-height:1.85}.membership-page .tier.featured .tier-body{color:rgba(255,255,255,.55)}.membership-page .tier-body p{margin-bottom:14px}.membership-page .tier-body p:last-child{margin-bottom:0}
.membership-page .interest-section{background:var(--cream);padding:100px 72px;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;border-top:1px solid rgba(58,56,53,.1)}.membership-page .interest-left h2{font-family:'Cormorant Garamond',serif;font-size:clamp(38px,4vw,52px);font-weight:300;color:var(--dark);line-height:1.1;margin-top:16px;margin-bottom:20px}.membership-page .interest-left p{font-size:14px;color:var(--text-light);font-weight:300;line-height:1.9}.membership-page .interest-form-wrap{padding-top:8px}.membership-page .form-row{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px}.membership-page .form-group{display:flex;flex-direction:column;gap:8px}.membership-page .form-group.full{grid-column:1 / -1}.membership-page .form-group label{font-family:'Montserrat',sans-serif;font-size:10px;letter-spacing:.25em;text-transform:uppercase;color:var(--text-light)}.membership-page .form-group input{background:none;border:none;border-bottom:1px solid rgba(58,56,53,.2);padding:10px 0;font-family:'Montserrat',sans-serif;font-size:14px;color:var(--dark);outline:none;transition:border-color .2s;width:100%;border-radius:0}.membership-page .form-group input:focus{border-bottom-color:var(--dark)}.membership-page .form-group input::placeholder{color:rgba(58,56,53,.3)}.membership-page .error-message{font-size:11px;color:#8b3a2f;margin-top:4px}.membership-page .form-message{font-size:12px;color:var(--text-light);margin:16px 0 0;min-height:18px}.membership-page .form-message.success{color:#3d6b45}.membership-page .form-message.error{color:#8b3a2f}.membership-page .form-submit{margin-top:16px}.membership-page .form-submit:disabled{cursor:wait;opacity:.7}
@media (max-width:900px){.membership-page .hero-content{padding:0 32px 56px}.membership-page .hero-slide{background-size:cover}.membership-page .hero-dots{right:32px}.membership-page .intro-band{grid-template-columns:1fr}.membership-page .intro-left{border-right:none;border-bottom:1px solid rgba(58,56,53,.1);padding:60px 32px}.membership-page .intro-right{padding:60px 32px}.membership-page .tiers-section{padding:72px 32px}.membership-page .tiers-grid{grid-template-columns:1fr}.membership-page .interest-section{grid-template-columns:1fr;padding:72px 32px;gap:48px}.membership-page .form-row{grid-template-columns:1fr}}@media (max-width:600px){.membership-page .hero{height:100svh;min-height:720px}.membership-page .hero-content{padding:0 24px 64px}.membership-page .hero-dots{left:24px;right:auto;bottom:28px}.membership-page .btn-primary,.membership-page .form-submit{width:100%;text-align:center}.membership-page .intro-left,.membership-page .intro-right,.membership-page .tiers-section,.membership-page .interest-section{padding-left:24px;padding-right:24px}}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="membership-page" id="primary">
	<section class="hero">
		<div class="hero-slides">
			<?php foreach ( array_values( $hero_slides ) as $index => $slide ) : ?>
				<?php
				$slide_image = $image_url( $slide['image'] ?? $slide, '' );
				if ( ! $slide_image ) {
					continue;
				}
				?>
				<div class="hero-slide<?php echo 0 === $index ? ' active' : ''; ?>" style="background-image:url('<?php echo esc_url( $slide_image ); ?>');"></div>
			<?php endforeach; ?>
		</div>
		<div class="hero-overlay"></div>
		<div class="hero-content">
			<span class="hero-eyebrow"><?php echo wp_kses_post( $hero_eyebrow ); ?></span>
			<h1><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="hero-sub"><?php echo esc_html( $hero_intro ); ?></p>
			<a href="#interest" class="btn-primary"><?php echo esc_html( $hero_button ); ?></a>
		</div>
		<div class="hero-dots">
			<?php foreach ( array_values( $hero_slides ) as $index => $slide ) : ?>
				<?php if ( ! $image_url( $slide['image'] ?? $slide, '' ) ) { continue; } ?>
				<button class="hero-dot<?php echo 0 === $index ? ' active' : ''; ?>" type="button" data-index="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Show slide %d', $index + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="intro-band">
		<div class="intro-left">
			<h2><?php echo wp_kses_post( $intro_title ); ?></h2>
		</div>
		<div class="intro-right">
			<p><?php echo esc_html( $intro_text ); ?></p>
		</div>
	</section>

	<section class="tiers-section">
		<div class="tiers-header">
			<span class="section-label"><?php echo esc_html( $tiers_label ); ?></span>
			<h2><?php echo wp_kses_post( $tiers_title ); ?></h2>
			<p class="tiers-sub"><?php echo esc_html( $tiers_text ); ?></p>
		</div>
		<div class="tiers-grid">
			<?php foreach ( $tiers as $tier ) : ?>
				<?php if ( ! is_array( $tier ) ) { continue; } ?>
				<?php $is_featured = ! empty( $tier['featured'] ); ?>
				<div class="tier<?php echo $is_featured ? ' featured' : ''; ?>">
					<div class="tier-name"><?php echo esc_html( $tier['name'] ?? '' ); ?></div>
					<span class="tier-tagline"><?php echo esc_html( $tier['tagline'] ?? '' ); ?></span>
					<div class="tier-divider"></div>
					<div class="tier-body"><?php echo wp_kses_post( wpautop( $tier['body'] ?? '', false ) ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="interest-section" id="interest">
		<div class="interest-left">
			<span class="section-label"><?php echo esc_html( $interest_label ); ?></span>
			<h2><?php echo wp_kses_post( $interest_title ); ?></h2>
			<p><?php echo esc_html( $interest_text ); ?></p>
		</div>
		<form id="event__form" class="interest-form-wrap" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
			<div class="form-row">
				<div class="form-group">
					<label for="event__first_name">First Name</label>
					<input type="text" id="event__first_name" name="first_name" placeholder="First name" required>
					<div class="error-message" data-field="event__first_name"></div>
				</div>
				<div class="form-group">
					<label for="event__last_name">Last Name</label>
					<input type="text" id="event__last_name" name="last_name" placeholder="Last name" required>
					<div class="error-message" data-field="event__last_name"></div>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group full">
					<label for="event__email_address">Email Address</label>
					<input type="email" id="event__email_address" name="email_address" placeholder="name@example.com" required>
					<div class="error-message" data-field="event__email_address"></div>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group full">
					<label for="event__phone">Phone Number</label>
					<input type="tel" id="event__phone" name="phone" placeholder="+44">
					<div class="error-message" data-field="event__phone"></div>
				</div>
			</div>
			<input type="hidden" id="event__message" name="message" value="Sedgemore Privé membership enquiry">
			<button type="submit" id="event__submit-btn" class="btn-primary dark form-submit">Submit Enquiry</button>
			<p id="event__form-message" class="form-message" aria-live="polite"></p>
			<input type="hidden" name="action" value="event_contact_form">
			<?php wp_nonce_field( 'event_contact_nonce_action', 'event_contact_nonce' ); ?>
		</form>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var form = document.getElementById('event__form');
	var submitButton = document.getElementById('event__submit-btn');
	var message = document.getElementById('event__form-message');

	if (form && submitButton) {
		form.addEventListener('submit', function () {
			if (!form.checkValidity()) {
				return;
			}

			submitButton.textContent = 'Submitting...';
			submitButton.disabled = true;

			if (message) {
				setTimeout(function () {
					if (message.textContent === 'Submitting...') {
						message.textContent = '';
					}
				}, 0);
			}
		});
	}

	if (message && submitButton) {
		new MutationObserver(function () {
			if (message.textContent && message.textContent !== 'Submitting...') {
				submitButton.textContent = 'Submit Enquiry';
				submitButton.disabled = false;
			}
		}).observe(message, { childList: true, characterData: true, subtree: true });
	}

	document.querySelectorAll('.membership-page a[href^="#"]').forEach(function (anchor) {
		anchor.addEventListener('click', function (event) {
			var target = document.querySelector(anchor.getAttribute('href'));

			if (target) {
				event.preventDefault();
				target.scrollIntoView({ behavior: 'smooth' });
			}
		});
	});

	var slides = document.querySelectorAll('.membership-page .hero-slide');
	var dots = document.querySelectorAll('.membership-page .hero-dot');
	var current = 0;
	var timer;

	function goTo(index) {
		if (!slides.length || !dots.length || !slides[current] || !dots[current] || !slides[index] || !dots[index]) {
			return;
		}

		slides[current].classList.remove('active');
		dots[current].classList.remove('active');
		current = index;
		slides[current].classList.add('active');
		dots[current].classList.add('active');
	}

	function startTimer() {
		if (slides.length < 2) {
			return;
		}

		clearInterval(timer);
		timer = setInterval(function () {
			goTo((current + 1) % slides.length);
		}, 5000);
	}

	dots.forEach(function (dot) {
		dot.addEventListener('click', function () {
			goTo(parseInt(dot.dataset.index, 10));
			startTimer();
		});
	});

	startTimer();
});
</script>

<?php
get_footer();
