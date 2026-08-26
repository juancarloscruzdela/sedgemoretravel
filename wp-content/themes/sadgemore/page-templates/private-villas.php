<?php
/**
 * Template Name: Private Villas
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

$hero_image      = $image_url( $get_field_value( 'private_villas_hero_image' ), $upload_base . 'Hero-Banner-Villa-Sola-Cabiati.jpg' );
$hero_eyebrow    = $get_field_value( 'private_villas_hero_eyebrow', 'Private Villas' );
$hero_title      = $get_field_value( 'private_villas_hero_title', 'A place that feels<br><em>entirely</em> your own' );
$hero_subtitle   = $get_field_value( 'private_villas_hero_subtitle', 'No shared spaces. No schedules to follow. Only the quiet pleasure of a home that has been chosen with you in mind.' );
$hero_button     = $get_field_value( 'private_villas_hero_button_label', 'Begin Your Stay' );
$hero_button_url = $get_field_value( 'private_villas_hero_button_url', '#enquiry' );

$intro_label         = $get_field_value( 'private_villas_intro_label', 'The Sedgemore Approach' );
$intro_title         = $get_field_value( 'private_villas_intro_title', 'Not just a property.<br>A <em>sanctuary</em>.' );
$intro_body          = $get_field_value( 'private_villas_intro_body', '<p>There is a particular kind of rest that a private villa makes possible. The kind that comes from having the right kitchen, the right view, the right silence. No strangers at breakfast. No lobby to navigate. Simply the feeling of arriving somewhere that was waiting for you.</p><p>Sedgemore identifies villas the way we approach everything: slowly, selectively, and with your specific notion of comfort as the guiding question. We have stayed in many of these homes ourselves, or know the people who have.</p>' );
$intro_image         = $image_url( $get_field_value( 'private_villas_intro_image' ), $upload_base . '26-Villa-©-Giacomo-Albo.jpg' );
$intro_image_caption = $get_field_value( 'private_villas_intro_image_caption', 'Passalacqua, Italy' );

$pillars_label = $get_field_value( 'private_villas_pillars_label', 'Why a Private Villa' );
$pillars_title = $get_field_value( 'private_villas_pillars_title', 'Three things a <em>great</em> villa gives you' );
$pillars_text  = $get_field_value( 'private_villas_pillars_text', 'Each villa we place a client in has been assessed for the qualities that make the difference between a comfortable stay and a genuinely restorative one.' );
$pillars       = $get_field_value(
	'private_villas_pillars',
	array(
		array( 'number' => '01', 'title' => '<em>Privacy</em> without compromise', 'text' => 'Your villa is your home for the duration. There are no crowds, no shared amenities, no unexpected intrusions. You move through it on your terms, at your pace, with your people.' ),
		array( 'number' => '02', 'title' => 'Chosen for <em>character</em>', 'text' => 'We do not work from catalogues. Every villa reaches us through a recommendation, a trusted contact, or direct knowledge. Architecture, light, setting, and service are all considered.' ),
		array( 'number' => '03', 'title' => 'Fitted to <em>your</em> vision', 'text' => 'Seven guests or two. A cliffside in Greece or a farmhouse in Umbria. A pool that faces west or a library that gets the morning light. We begin with what matters to you.' ),
	)
);

$strip_images = $get_field_value(
	'private_villas_image_strip',
	array(
		array( 'image' => $upload_base . 'Andronis-Concept-Greece-Infinity-Pool.jpg', 'caption' => 'Andronis Concept, Santorini' ),
		array( 'image' => $upload_base . 'Living-terrace-Amalfi.jpg', 'caption' => 'Amalfi Coast' ),
		array( 'image' => $upload_base . 'La-Mamounia-Baldaquin-Suite.jpg', 'caption' => 'Baldaquin Suite, La Mamounia Marrakech' ),
	)
);

$experience_label = $get_field_value( 'private_villas_experience_label', 'The Experience' );
$experience_title = $get_field_value( 'private_villas_experience_title', 'The days are <em>yours</em> to design' );
$experience_text  = $get_field_value( 'private_villas_experience_text', 'Awake at your own rhythm. A private chef. A car waiting when you want one. Or nothing scheduled at all. The measure of a good villa stay is that you stop counting the days.' );
$experience_items = $get_field_value(
	'private_villas_experience_items',
	array(
		array( 'marker' => 'i.', 'title' => 'Private Chef & Housekeeping', 'text' => 'Meals prepared in the home’s own kitchen, tailored to every preference and dietary requirement, without the theatre of a restaurant.' ),
		array( 'marker' => 'ii.', 'title' => 'Dedicated Concierge', 'text' => 'Local knowledge made useful: reservations, excursions, transfers, and the small requests that make a stay feel effortless.' ),
		array( 'marker' => 'iii.', 'title' => 'Pre-Arrival Curation', 'text' => 'Provisions stocked, staff briefed, and every detail confirmed before you arrive. The first impression should require nothing from you.' ),
		array( 'marker' => 'iv.', 'title' => 'In-Villa Wellness', 'text' => 'Private yoga instruction, massage, and spa treatments arranged within the property, on your schedule.' ),
	)
);

$process_label = $get_field_value( 'private_villas_process_label', 'The Process' );
$process_title = $get_field_value( 'private_villas_process_title', 'How we find<br>the <em>right</em> villa' );
$process_text  = $get_field_value( 'private_villas_process_text', 'Villa selection begins with a conversation, not a search engine. We narrow from hundreds of possibilities to the one that fits your particular group, timing, and idea of a good stay.' );
$process_items = $get_field_value(
	'private_villas_process_items',
	array(
		array( 'number' => '01', 'title' => 'A first conversation', 'text' => 'You tell us about the trip: who is coming, how you like to spend your time, what has worked before and what has not. This is where we listen.' ),
		array( 'number' => '02', 'title' => 'A curated shortlist', 'text' => 'We compile a small selection of villas that genuinely match your brief. No padding. Each one comes with our assessment of why it is right for you specifically.' ),
		array( 'number' => '03', 'title' => 'Arrangement and detail', 'text' => 'Once you choose, we handle contracting, staff briefings, provisioning, travel logistics, and any additions: a boat, a chef, an excursion, a welcome gift.' ),
		array( 'number' => '04', 'title' => 'Support throughout', 'text' => 'We remain in reach for the duration of your stay. If something is not right, we address it quietly. The aim is that you never have to manage anything yourself.' ),
	)
);

$testimonial_text = $get_field_value( 'private_villas_testimonial_text', '“We had stayed in hotels all our lives. The villa felt like something else entirely. Like travelling properly for the first time.”' );
$testimonial_cite = $get_field_value( 'private_villas_testimonial_cite', 'Private client' );

$enquiry_label = $get_field_value( 'private_villas_enquiry_label', 'Begin Your Stay' );
$enquiry_title = $get_field_value( 'private_villas_enquiry_title', 'Tell us about<br>your <em>ideal</em> villa' );
$enquiry_text  = $get_field_value( 'private_villas_enquiry_text', 'Share a few details and we will come back to you with a considered response: not an automated reply, but a thoughtful starting point from one of our consultants.' );
$form_note     = $get_field_value( 'private_villas_form_note', 'Your details are held in confidence and shared only with the Sedgemore team.' );
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

<style type="text/css">
.header_bright{display:block}.header_dark{display:none}.header_nav_fixed{background:#f1eeea}.divider_sharp_bright{display:none!important}.divider_sharp_dark{display:inline-block!important}
.private-villas-page,.private-villas-page *,.private-villas-page *::before,.private-villas-page *::after{box-sizing:border-box;margin:0;padding:0}.private-villas-page{--warm-white:#FAFAF7;--cream:#F5F2ED;--charcoal:#2A2A27;--dark:#1C1A18;--text:#3A3835;--text-light:#7A7672;background:var(--warm-white);color:var(--text);font-family:'Montserrat',sans-serif;font-size:15px;line-height:1.75;-webkit-font-smoothing:antialiased;overflow-x:hidden}.private-villas-page a{text-decoration:none;color:inherit}.private-villas-page section{padding:100px 40px}.private-villas-page .hero{position:relative;height:100vh;min-height:620px;display:flex;align-items:center;justify-content:center;overflow:hidden}.private-villas-page .hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}.private-villas-page .hero-bg::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(20,18,15,.32) 0%,rgba(20,18,15,.52) 100%)}.private-villas-page .hero-content{position:relative;z-index:2;text-align:center;color:#fff;padding:0 24px;max-width:680px}.private-villas-page .hero-eyebrow,.private-villas-page .section-label{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.35em;text-transform:uppercase;color:var(--text-light);margin-bottom:20px}.private-villas-page .hero-eyebrow{color:rgba(255,255,255,.65);margin-bottom:28px}.private-villas-page .hero-title{font-family:'Cormorant Garamond',serif;font-size:clamp(52px,8vw,88px);font-weight:300;line-height:1.05;letter-spacing:.02em;margin-bottom:24px}.private-villas-page em{font-style:italic}.private-villas-page .hero-subtitle{font-size:13px;font-weight:300;letter-spacing:.12em;color:rgba(255,255,255,.78);margin:0 auto 48px;line-height:1.7;max-width:420px}.private-villas-page .btn-primary{display:inline-block;background:var(--dark);color:#fff;font-size:11px;font-weight:500;letter-spacing:.3em;text-transform:uppercase;padding:16px 40px;border:1px solid var(--dark);cursor:pointer;transition:background .25s,color .25s}.private-villas-page .btn-primary:hover{background:#fff;color:var(--dark)}.private-villas-page .section-inner{max-width:1120px;margin:0 auto}.private-villas-page .section-heading{font-family:'Cormorant Garamond',serif;font-size:clamp(36px,5vw,56px);font-weight:300;line-height:1.1;color:var(--charcoal);margin-bottom:24px}.private-villas-page .section-body{font-size:15px;color:var(--text-light);line-height:1.85;max-width:580px}.private-villas-page .section-body p{margin-bottom:24px}.private-villas-page .section-body p:last-child{margin-bottom:0}.private-villas-page .intro{background:var(--warm-white)}.private-villas-page .intro-layout{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}.private-villas-page .intro-image{aspect-ratio:4/5;background-size:cover;background-position:center;position:relative;overflow:hidden}.private-villas-page .intro-image-caption,.private-villas-page .strip-cell-caption{position:absolute;font-family:'Montserrat',sans-serif;font-size:10px;letter-spacing:.25em;text-transform:uppercase;color:rgba(255,255,255,.7)}.private-villas-page .intro-image-caption{bottom:24px;left:24px;right:24px}.private-villas-page .pillars,.private-villas-page .process,.private-villas-page .testimonial-band{background:var(--cream)}.private-villas-page .pillars-header{max-width:1120px;margin:0 auto 64px;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:end}.private-villas-page .pillars-grid{max-width:1120px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:2px}.private-villas-page .pillar-card,.private-villas-page .process-card{background:var(--warm-white);padding:48px 36px}.private-villas-page .pillar-number,.private-villas-page .process-num{font-family:'Cormorant Garamond',serif;font-size:72px;font-weight:300;color:rgba(42,42,39,.08);line-height:1;margin-bottom:24px}.private-villas-page .pillar-title,.private-villas-page .process-title{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:400;color:var(--charcoal);margin-bottom:14px;letter-spacing:.02em}.private-villas-page .pillar-body,.private-villas-page .process-body{font-size:14px;color:var(--text-light);line-height:1.85}.private-villas-page .image-strip{display:grid;grid-template-columns:1.4fr 1fr 1fr;height:520px;gap:2px}.private-villas-page .strip-cell{overflow:hidden;position:relative;background-size:cover;background-position:center}.private-villas-page .strip-cell:nth-child(3){background-position:center top}.private-villas-page .strip-cell-caption{bottom:20px;left:20px;color:rgba(255,255,255,.6)}.private-villas-page .experience{background:var(--warm-white)}.private-villas-page .experience-list{list-style:none;margin-top:40px}.private-villas-page .experience-list li{display:flex;gap:20px;padding:22px 0;border-bottom:1px solid rgba(42,42,39,.08);font-size:14px;color:var(--text);line-height:1.7}.private-villas-page .experience-list li:first-child{border-top:1px solid rgba(42,42,39,.08)}.private-villas-page .list-marker{font-family:'Cormorant Garamond',serif;font-size:13px;font-style:italic;color:var(--text-light);min-width:20px;padding-top:2px}.private-villas-page .experience-list strong{font-size:11px;letter-spacing:.15em;text-transform:uppercase;color:var(--charcoal);display:block;margin-bottom:4px}.private-villas-page .process-header{max-width:1120px;margin:0 auto 64px;display:flex;align-items:end;justify-content:space-between;gap:40px}.private-villas-page .process-header .section-body{max-width:400px}.private-villas-page .process-grid{max-width:1120px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:2px}.private-villas-page .process-card{padding:48px 32px}.private-villas-page .process-num{font-size:80px;color:rgba(42,42,39,.07);margin-bottom:20px}.private-villas-page .process-title{font-size:20px;margin-bottom:12px}.private-villas-page .process-body{font-size:13px}.private-villas-page .testimonial-band{text-align:center}.private-villas-page .testimonial-band blockquote{max-width:740px;margin:0 auto}.private-villas-page .testimonial-rule{width:40px;height:1px;background:var(--text-light);margin:0 auto 48px;opacity:.4}.private-villas-page .testimonial-band p{font-family:'Cormorant Garamond',serif;font-size:clamp(26px,3.5vw,40px);font-style:italic;font-weight:300;color:var(--charcoal);line-height:1.45;margin-bottom:32px}.private-villas-page .testimonial-band cite{font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:var(--text-light);font-style:normal}.private-villas-page .enquiry{background:var(--cream)}.private-villas-page .enquiry-layout{max-width:1120px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:100px;align-items:start}.private-villas-page .enquiry-left .section-body{max-width:100%;margin-bottom:40px}.private-villas-page .enquiry-form{display:flex;flex-direction:column;gap:0}.private-villas-page .form-row{display:grid;grid-template-columns:1fr 1fr;gap:32px}.private-villas-page .form-field{padding:20px 0 12px;border-bottom:1px solid rgba(42,42,39,.2);position:relative;margin-bottom:8px}.private-villas-page .form-field input,.private-villas-page .form-field textarea{width:100%;background:transparent;border:none;outline:none;font-family:'Montserrat',sans-serif;font-size:14px;color:var(--charcoal);resize:none;appearance:none}.private-villas-page .form-field textarea{min-height:80px}.private-villas-page .form-field label{display:block;font-size:10px;letter-spacing:.25em;text-transform:uppercase;color:var(--text-light);margin-bottom:6px}.private-villas-page .form-field input::placeholder,.private-villas-page .form-field textarea::placeholder{color:rgba(42,42,39,.3)}.private-villas-page .error-message{font-size:11px;color:#8b3a2f;margin-top:6px}.private-villas-page .form-submit{margin-top:40px}.private-villas-page .btn-submit{background:var(--dark);color:#fff;border:1px solid var(--dark);font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.3em;text-transform:uppercase;padding:18px 48px;cursor:pointer;transition:background .25s,color .25s;width:100%}.private-villas-page .btn-submit:hover{background:#fff;color:var(--dark)}.private-villas-page .btn-submit:disabled{cursor:wait;opacity:.7}.private-villas-page .form-note{margin-top:16px;font-size:11px;color:var(--text-light);line-height:1.7;opacity:.7}.private-villas-page #sedgemore__form-message{font-size:12px;color:var(--text-light);margin-top:16px;min-height:18px}
@media (max-width:900px){.private-villas-page section{padding:72px 24px}.private-villas-page .intro-layout,.private-villas-page .enquiry-layout{grid-template-columns:1fr;gap:48px}.private-villas-page .intro-image{aspect-ratio:16/9}.private-villas-page .pillars-header{grid-template-columns:1fr;gap:24px}.private-villas-page .pillars-grid{grid-template-columns:1fr}.private-villas-page .process-grid{grid-template-columns:1fr 1fr}.private-villas-page .image-strip{grid-template-columns:1fr;height:auto}.private-villas-page .strip-cell{height:260px}.private-villas-page .form-row{grid-template-columns:1fr;gap:0}.private-villas-page .process-header{flex-direction:column;align-items:start}}
@media (max-width:600px){.private-villas-page .hero{min-height:560px}.private-villas-page .hero-title{font-size:48px}.private-villas-page .process-grid{grid-template-columns:1fr}.private-villas-page .btn-primary,.private-villas-page .btn-submit{width:100%;text-align:center;padding-left:20px;padding-right:20px}}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="private-villas-page" id="primary">
	<section class="hero">
		<div class="hero-bg" style="background-image:url('<?php echo esc_url( $hero_image ); ?>');"></div>
		<div class="hero-content">
			<p class="hero-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
			<h1 class="hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
			<?php if ( $hero_button && $hero_button_url ) : ?>
				<a href="<?php echo esc_url( $hero_button_url ); ?>" class="btn-primary"><?php echo esc_html( $hero_button ); ?></a>
			<?php endif; ?>
		</div>
	</section>

	<section class="intro">
		<div class="section-inner">
			<div class="intro-layout">
				<div>
					<p class="section-label"><?php echo esc_html( $intro_label ); ?></p>
					<h2 class="section-heading"><?php echo wp_kses_post( $intro_title ); ?></h2>
					<div class="section-body"><?php echo wp_kses_post( wpautop( $intro_body ) ); ?></div>
				</div>
				<div class="intro-image" style="background-image:url('<?php echo esc_url( $intro_image ); ?>');">
					<?php if ( $intro_image_caption ) : ?>
						<div class="intro-image-caption"><?php echo esc_html( $intro_image_caption ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<section class="pillars">
		<div class="pillars-header">
			<div>
				<p class="section-label"><?php echo esc_html( $pillars_label ); ?></p>
				<h2 class="section-heading"><?php echo wp_kses_post( $pillars_title ); ?></h2>
			</div>
			<p class="section-body"><?php echo esc_html( $pillars_text ); ?></p>
		</div>
		<div class="pillars-grid">
			<?php foreach ( $pillars as $pillar ) : ?>
				<div class="pillar-card">
					<div class="pillar-number"><?php echo esc_html( $pillar['number'] ?? '' ); ?></div>
					<h3 class="pillar-title"><?php echo wp_kses_post( $pillar['title'] ?? '' ); ?></h3>
					<p class="pillar-body"><?php echo esc_html( $pillar['text'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<div class="image-strip">
		<?php foreach ( $strip_images as $strip_image ) : ?>
			<?php $strip_src = $image_url( $strip_image['image'] ?? '', '' ); ?>
			<div class="strip-cell" style="background-image:url('<?php echo esc_url( $strip_src ); ?>');">
				<?php if ( ! empty( $strip_image['caption'] ) ) : ?>
					<span class="strip-cell-caption"><?php echo esc_html( $strip_image['caption'] ); ?></span>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>

	<section class="experience">
		<div class="section-inner">
			<p class="section-label"><?php echo esc_html( $experience_label ); ?></p>
			<h2 class="section-heading" style="max-width:600px;"><?php echo wp_kses_post( $experience_title ); ?></h2>
			<p class="section-body" style="margin-bottom:0;"><?php echo esc_html( $experience_text ); ?></p>
			<ul class="experience-list">
				<?php foreach ( $experience_items as $experience_item ) : ?>
					<li>
						<span class="list-marker"><?php echo esc_html( $experience_item['marker'] ?? '' ); ?></span>
						<span><strong><?php echo esc_html( $experience_item['title'] ?? '' ); ?></strong><?php echo esc_html( $experience_item['text'] ?? '' ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="enquiry" id="enquiry">
		<div class="enquiry-layout">
			<div class="enquiry-left">
				<p class="section-label"><?php echo esc_html( $enquiry_label ); ?></p>
				<h2 class="section-heading"><?php echo wp_kses_post( $enquiry_title ); ?></h2>
				<p class="section-body"><?php echo esc_html( $enquiry_text ); ?></p>
			</div>
			<form id="sedgemore__form" class="enquiry-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__first_name">First Name</label>
						<input id="sedgemore__first_name" type="text" name="first_name" placeholder="Your first name" required>
						<div class="error-message" data-field="sedgemore__first_name"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__last_name">Last Name</label>
						<input id="sedgemore__last_name" type="text" name="last_name" placeholder="Your last name" required>
						<div class="error-message" data-field="sedgemore__last_name"></div>
					</div>
				</div>
				<div class="form-field">
					<label for="sedgemore__email_address">Email Address</label>
					<input id="sedgemore__email_address" type="email" name="email_address" placeholder="your@email.com" required>
					<div class="error-message" data-field="sedgemore__email_address"></div>
				</div>
				<div class="form-field">
					<label for="sedgemore__phone">Phone</label>
					<input id="sedgemore__phone" type="tel" name="phone" placeholder="+44 ...">
					<div class="error-message" data-field="sedgemore__phone"></div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__destination">Preferred Destination</label>
						<input id="sedgemore__destination" type="text" name="destination" placeholder="Country or region" required>
						<div class="error-message" data-field="sedgemore__destination"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__dates">Travel Dates</label>
						<input id="sedgemore__dates" type="text" name="dates" placeholder="Approximate dates" required>
						<div class="error-message" data-field="sedgemore__dates"></div>
					</div>
				</div>
				<div class="form-field">
					<label for="sedgemore__no_of_guests">Number of Guests</label>
					<input id="sedgemore__no_of_guests" type="text" name="no_of_guests" placeholder="Adults / children" required>
					<div class="error-message" data-field="sedgemore__no_of_guests"></div>
				</div>
				<div class="form-field">
					<label for="sedgemore__message">Anything else we should know</label>
					<textarea id="sedgemore__message" name="message" placeholder="Special requirements, occasions, preferences..." required></textarea>
					<div class="error-message" data-field="sedgemore__message"></div>
				</div>
				<div class="form-submit">
					<button type="submit" class="btn-submit">Send Enquiry</button>
					<p class="form-note"><?php echo esc_html( $form_note ); ?></p>
				</div>
				<p id="sedgemore__form-message" aria-live="polite"></p>
				<input type="hidden" name="action" value="private_villa_contact_form">
				<?php wp_nonce_field( 'private_villa_contact_nonce_action', 'private_villa_contact_nonce' ); ?>
			</form>
		</div>
	</section>
</main>

<?php
get_footer();
