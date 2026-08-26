<?php
/**
 * Template Name: Private Yachts
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

$hero_image      = $image_url( $get_field_value( 'private_yachts_hero_image' ), $upload_base . 'hero-banner.webp' );
$hero_label      = $get_field_value( 'private_yachts_hero_label', 'Travel &middot; Private Charters' );
$hero_title      = $get_field_value( 'private_yachts_hero_title', 'Private Yacht<br><em>Experiences</em>' );
$hero_button     = $get_field_value( 'private_yachts_hero_button_label', 'Enquire Now' );
$hero_button_url = $get_field_value( 'private_yachts_hero_button_url', '#enquiry' );

$intro_label = $get_field_value( 'private_yachts_intro_label', 'The Open Sea' );
$intro_title = $get_field_value( 'private_yachts_intro_title', 'The world looks <em>different</em> from the water' );
$intro_body  = $get_field_value( 'private_yachts_intro_body', 'A private yacht charter removes the fixed itinerary, the shared dining room, the arrival schedule. What remains is water, light, and an entirely personal way of moving through the world. We arrange charters shaped entirely around how you want to travel: the pace, the ports, the people on board, and the moments in between.' );

$split_image = $image_url( $get_field_value( 'private_yachts_split_image' ), $upload_base . 'V2VZaEMIR2-w8bt-b5lZg-YCT_012_original.webp' );
$split_label = $get_field_value( 'private_yachts_split_label', 'Exclusive Journeys' );
$split_title = $get_field_value( 'private_yachts_split_title', '<em>Seamless</em> from departure to return' );
$split_body  = $get_field_value( 'private_yachts_split_body', '<p>From a weekend in the Aegean to a month along the Norwegian fjords, every detail is managed with discretion. Yacht selection, crew briefing, provisioning, shore excursions, private mooring arrangements: all handled so that your time on board remains entirely your own.</p><p>We work with a curated set of vessels and captains across the Mediterranean, Atlantic, and beyond. Each recommendation is made with your group in mind, not availability.</p>' );

$arrange_label = $get_field_value( 'private_yachts_arrange_label', 'What We Arrange' );
$arrange_title = $get_field_value( 'private_yachts_arrange_title', 'Every aspect of your <em>charter</em>, considered' );
$arrange_items_default = array(
	array( 'number' => '01', 'title' => 'Vessel Selection', 'text' => 'Motor yachts, sailing vessels, catamarans, and expedition-class ships. We match the right yacht to your group size, itinerary, and preferred style of travel.' ),
	array( 'number' => '02', 'title' => 'Itinerary Planning', 'text' => 'Whether you have a destination in mind or simply a feeling, we build itineraries around anchorages, private coves, and shore experiences worth the journey.' ),
	array( 'number' => '03', 'title' => 'Crew and Provisioning', 'text' => 'Experienced crews, private chefs, and on-board provisioning arranged to your exact preferences. Diet, drink, dietary notes: all communicated before you board.' ),
	array( 'number' => '04', 'title' => 'Shore Arrangements', 'text' => 'Private transfers, marina reservations, restaurant access, and cultural access along your route. The experience extends beyond the vessel.' ),
	array( 'number' => '05', 'title' => 'Water Activities', 'text' => 'Diving equipment, jet skis, paddleboards, and guided water excursions arranged in advance or on request. The sea is yours to explore.' ),
	array( 'number' => '06', 'title' => 'Full Concierge', 'text' => 'From pre-departure flights and transfers to on-board celebrations and private events: one point of contact throughout, available when you need us.' ),
);
$arrange_items = $get_field_value(
	'private_yachts_arrange_items',
	$arrange_items_default
);
if ( ! is_array( $arrange_items ) || empty( $arrange_items ) ) {
	$arrange_items = $arrange_items_default;
}

$testimonial_text = $get_field_value( 'private_yachts_testimonial_text', '"We told Sedgemore we wanted to feel truly off the map. They delivered a route we never would have found ourselves -- every anchorage was extraordinary."' );
$testimonial_cite = $get_field_value( 'private_yachts_testimonial_cite', 'Private client' );

$destinations_label = $get_field_value( 'private_yachts_destinations_label', 'Where We Charter' );
$destinations_title = $get_field_value( 'private_yachts_destinations_title', 'Waters worth <em>exploring</em>' );
$destinations_text  = $get_field_value( 'private_yachts_destinations_text', 'We arrange charters across the world\'s most remarkable sailing regions, tailored to season, preference, and the pace you want to keep.' );
$destinations_default = array(
	array( 'image' => $upload_base . 'The-Mediterranean.jpg', 'region' => 'Southern Europe', 'name' => 'The Mediterranean' ),
	array( 'image' => $upload_base . 'Scandinavian-Fjords.jpg', 'region' => 'Northern Europe', 'name' => 'Scandinavian Fjords' ),
	array( 'image' => $upload_base . 'Maldives-and-Seychelles.jpg', 'region' => 'Indian Ocean', 'name' => 'Maldives and Seychelles' ),
	array( 'image' => $upload_base . 'The-British-Virgin-Islands.jpg', 'region' => 'Caribbean', 'name' => 'The British Virgin Islands' ),
);
$destinations       = $get_field_value(
	'private_yachts_destinations',
	$destinations_default
);
if ( ! is_array( $destinations ) || empty( $destinations ) ) {
	$destinations = $destinations_default;
}

$enquiry_label = $get_field_value( 'private_yachts_enquiry_label', 'Plan Your Charter' );
$enquiry_title = $get_field_value( 'private_yachts_enquiry_title', 'Tell us how you want to <em>travel</em>' );
$enquiry_text  = $get_field_value( 'private_yachts_enquiry_text', 'Share your plans and we will identify private yacht options suited to your itinerary, group, and preferences.' );
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

<style type="text/css">
.header_bright{display:block}.header_dark{display:none}.header_nav_fixed{background:#f1eeea}.divider_sharp_bright{display:none!important}.divider_sharp_dark{display:inline-block!important}
.private-yachts-page,.private-yachts-page *,.private-yachts-page *::before,.private-yachts-page *::after{box-sizing:border-box;margin:0;padding:0}.private-yachts-page{--warm-white:#FAFAF7;--cream:#F5F2ED;--charcoal:#2A2A27;--dark:#1C1A18;--text:#3A3835;--text-light:#7A7672;background:var(--warm-white);color:var(--text);font-family:'Montserrat',sans-serif;font-size:15px;line-height:1.75;-webkit-font-smoothing:antialiased;overflow-x:hidden}.private-yachts-page a{text-decoration:none;color:inherit}.private-yachts-page .hero{position:relative;height:92vh;min-height:600px;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden;background:#1a2a35}.private-yachts-page .hero-bg{position:absolute;inset:0;background-size:cover;background-position:center}.private-yachts-page .hero-bg::after{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 120% 60% at 60% 55%,rgba(255,255,255,.03) 0%,transparent 70%),radial-gradient(ellipse 80% 40% at 30% 40%,rgba(255,255,255,.02) 0%,transparent 60%)}.private-yachts-page .hero-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(12,20,27,.3) 0%,rgba(12,20,27,.55) 100%)}.private-yachts-page .hero-content{position:relative;z-index:2;color:#fff;max-width:700px;padding:0 24px}.private-yachts-page .hero-label,.private-yachts-page .section-label{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.35em;text-transform:uppercase}.private-yachts-page .hero-label{color:rgba(255,255,255,.6);margin-bottom:28px}.private-yachts-page .section-label{color:var(--text-light);margin-bottom:32px}.private-yachts-page .hero-title{font-family:'Cormorant Garamond',serif;font-size:clamp(48px,7vw,80px);font-weight:300;line-height:1.08;letter-spacing:.02em;margin-bottom:36px;color:#fff}.private-yachts-page em{font-style:italic}.private-yachts-page .hero-cta{display:inline-block;font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.25em;text-transform:uppercase;color:#fff;border:1px solid rgba(255,255,255,.55);padding:14px 34px;text-decoration:none;transition:background .25s,color .25s,border-color .25s}.private-yachts-page .hero-cta:hover{background:#fff;color:var(--dark);border-color:#fff}.private-yachts-page .intro{background:var(--cream);padding:108px 40px;text-align:center}.private-yachts-page .intro-inner{max-width:680px;margin:0 auto}.private-yachts-page .intro-heading,.private-yachts-page .wwa-heading,.private-yachts-page .dest-heading{font-family:'Cormorant Garamond',serif;font-size:clamp(34px,4vw,48px);font-weight:300;line-height:1.18;color:var(--charcoal)}.private-yachts-page .intro-heading{margin-bottom:28px}.private-yachts-page .intro-body{font-size:15px;font-weight:300;line-height:1.85;color:var(--text);max-width:560px;margin:0 auto}.private-yachts-page .split{display:grid;grid-template-columns:1fr 1fr;min-height:580px}.private-yachts-page .split-image{background:#1a2a35;overflow:hidden;position:relative}.private-yachts-page .split-image-placeholder{position:absolute;inset:0;background-size:cover;background-position:center}.private-yachts-page .split-text{background:var(--warm-white);display:flex;align-items:center;padding:80px 72px 80px 80px}.private-yachts-page .split-text-inner{max-width:440px}.private-yachts-page .split-heading{font-family:'Cormorant Garamond',serif;font-size:clamp(30px,3vw,42px);font-weight:300;line-height:1.2;color:var(--charcoal);margin-bottom:24px}.private-yachts-page .split-body{font-size:15px;font-weight:300;line-height:1.85;color:var(--text);margin-bottom:36px}.private-yachts-page .split-body:last-child{margin-bottom:0}.private-yachts-page .what-we-arrange{background:var(--cream);padding:108px 40px}.private-yachts-page .what-we-arrange-inner{max-width:1080px;margin:0 auto}.private-yachts-page .wwa-header{margin-bottom:64px}.private-yachts-page .wwa-header .section-label{margin-bottom:24px}.private-yachts-page .wwa-heading{max-width:560px}.private-yachts-page .wwa-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:0}.private-yachts-page .wwa-item{padding:48px 40px 48px 0}.private-yachts-page .wwa-numeral{font-family:'Cormorant Garamond',serif;font-size:72px;font-weight:300;color:rgba(42,42,39,.08);line-height:1;margin-bottom:20px}.private-yachts-page .wwa-item-title{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:400;color:var(--charcoal);margin-bottom:14px}.private-yachts-page .wwa-item-body{font-size:14px;font-weight:300;line-height:1.8;color:var(--text-light)}.private-yachts-page .testimonial{background:var(--warm-white);padding:108px 40px;text-align:center}.private-yachts-page .testimonial-inner{max-width:620px;margin:0 auto}.private-yachts-page .testimonial-quote{font-family:'Cormorant Garamond',serif;font-size:clamp(22px,3vw,30px);font-weight:300;font-style:italic;line-height:1.55;color:var(--charcoal);margin-bottom:32px}.private-yachts-page .testimonial-attr{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.35em;text-transform:uppercase;color:var(--text-light)}.private-yachts-page .destinations{background:var(--warm-white);padding:108px 40px}.private-yachts-page .destinations-inner{max-width:1080px;margin:0 auto}.private-yachts-page .dest-header{text-align:center;margin-bottom:64px}.private-yachts-page .dest-heading{margin-bottom:16px}.private-yachts-page .dest-subtext{font-size:15px;font-weight:300;line-height:1.8;color:var(--text-light);max-width:520px;margin:0 auto}.private-yachts-page .dest-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2px}.private-yachts-page .dest-card{position:relative;height:340px;overflow:hidden;cursor:default}.private-yachts-page .dest-card-bg{position:absolute;inset:0;background-size:cover;background-position:center;transition:transform .6s ease}.private-yachts-page .dest-card:hover .dest-card-bg{transform:scale(1.05)}.private-yachts-page .dest-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(12,20,27,.72) 0%,rgba(12,20,27,.1) 60%)}.private-yachts-page .dest-card-content{position:absolute;bottom:28px;left:24px;right:24px;color:#fff}.private-yachts-page .dest-card-region{font-family:'Montserrat',sans-serif;font-size:10px;font-weight:500;letter-spacing:.3em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:6px}.private-yachts-page .dest-card-name{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:300;color:#fff;line-height:1.2}.private-yachts-page .enquiry{background:var(--cream);padding:108px 40px}.private-yachts-page .enquiry-inner{max-width:1080px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start}.private-yachts-page .enquiry-left .section-label{margin-bottom:24px}.private-yachts-page .enquiry-heading{font-family:'Cormorant Garamond',serif;font-size:clamp(30px,3.5vw,44px);font-weight:300;line-height:1.18;color:var(--charcoal);margin-bottom:20px}.private-yachts-page .enquiry-body{font-size:15px;font-weight:300;line-height:1.8;color:var(--text-light)}.private-yachts-page .enquiry-form{display:flex;flex-direction:column}.private-yachts-page .form-row{display:grid;grid-template-columns:1fr 1fr;gap:0 32px}.private-yachts-page .form-field{display:flex;flex-direction:column;margin-bottom:36px}.private-yachts-page .form-field label{font-family:'Montserrat',sans-serif;font-size:10px;font-weight:500;letter-spacing:.25em;text-transform:uppercase;color:var(--text-light);margin-bottom:10px}.private-yachts-page .form-field input,.private-yachts-page .form-field select,.private-yachts-page .form-field textarea{font-family:'Montserrat',sans-serif;font-size:14px;font-weight:300;color:var(--charcoal);background:transparent;border:none;border-bottom:1px solid rgba(42,42,39,.2);padding:8px 0;outline:none;transition:border-color .2s;width:100%;appearance:none}.private-yachts-page .form-field input:focus,.private-yachts-page .form-field select:focus,.private-yachts-page .form-field textarea:focus{border-bottom-color:var(--charcoal)}.private-yachts-page .form-field textarea{resize:none;height:72px;line-height:1.6}.private-yachts-page .form-submit{width:100%;font-family:'Montserrat',sans-serif;font-size:11px;font-weight:500;letter-spacing:.25em;text-transform:uppercase;color:#fff;background:var(--dark);border:1px solid var(--dark);padding:18px 32px;cursor:pointer;transition:background .25s,color .25s;margin-top:8px}.private-yachts-page .form-submit:hover{background:#fff;color:var(--dark)}.private-yachts-page .error-message{font-size:11px;color:#8b3a2f;margin-top:6px}.private-yachts-page #sedgemore__form-message{font-size:12px;color:var(--text-light);margin-top:16px;min-height:18px}
@media (max-width:900px){.private-yachts-page .split{grid-template-columns:1fr}.private-yachts-page .split-image{height:400px}.private-yachts-page .split-text{padding:64px 40px}.private-yachts-page .wwa-grid{grid-template-columns:1fr}.private-yachts-page .dest-grid{grid-template-columns:1fr 1fr}.private-yachts-page .enquiry-inner{grid-template-columns:1fr;gap:48px}}
@media (max-width:600px){.private-yachts-page .split-text{padding:56px 24px}.private-yachts-page .intro,.private-yachts-page .what-we-arrange,.private-yachts-page .testimonial,.private-yachts-page .destinations,.private-yachts-page .enquiry{padding:72px 24px}.private-yachts-page .form-row{grid-template-columns:1fr}.private-yachts-page .dest-grid{grid-template-columns:1fr}.private-yachts-page .wwa-item{padding:40px 0}.private-yachts-page .hero-cta,.private-yachts-page .form-submit{width:100%;text-align:center}}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="private-yachts-page" id="primary">
	<section class="hero">
		<div class="hero-bg" style="background-image:url('<?php echo esc_url( $hero_image ); ?>');"></div>
		<div class="hero-overlay"></div>
		<div class="hero-content">
			<p class="hero-label"><?php echo wp_kses_post( $hero_label ); ?></p>
			<h1 class="hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
			<?php if ( $hero_button && $hero_button_url ) : ?>
				<a href="<?php echo esc_url( $hero_button_url ); ?>" class="hero-cta"><?php echo esc_html( $hero_button ); ?></a>
			<?php endif; ?>
		</div>
	</section>

	<section class="intro">
		<div class="intro-inner">
			<p class="section-label"><?php echo esc_html( $intro_label ); ?></p>
			<h2 class="intro-heading"><?php echo wp_kses_post( $intro_title ); ?></h2>
			<p class="intro-body"><?php echo esc_html( $intro_body ); ?></p>
		</div>
	</section>

	<section class="split">
		<div class="split-image">
			<div class="split-image-placeholder" style="background-image:url('<?php echo esc_url( $split_image ); ?>');"></div>
		</div>
		<div class="split-text">
			<div class="split-text-inner">
				<p class="section-label"><?php echo esc_html( $split_label ); ?></p>
				<h2 class="split-heading"><?php echo wp_kses_post( $split_title ); ?></h2>
				<?php echo wp_kses_post( wpautop( $split_body, false ) ); ?>
			</div>
		</div>
	</section>

	<section class="what-we-arrange">
		<div class="what-we-arrange-inner">
			<div class="wwa-header">
				<p class="section-label"><?php echo esc_html( $arrange_label ); ?></p>
				<h2 class="wwa-heading"><?php echo wp_kses_post( $arrange_title ); ?></h2>
			</div>
				<div class="wwa-grid">
					<?php foreach ( $arrange_items as $arrange_item ) : ?>
						<?php if ( ! is_array( $arrange_item ) ) { continue; } ?>
						<div class="wwa-item">
							<div class="wwa-numeral"><?php echo esc_html( $arrange_item['number'] ?? '' ); ?></div>
							<h3 class="wwa-item-title"><?php echo esc_html( $arrange_item['title'] ?? '' ); ?></h3>
						<p class="wwa-item-body"><?php echo esc_html( $arrange_item['text'] ?? '' ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="destinations">
		<div class="destinations-inner">
			<div class="dest-header">
				<div>
					<p class="section-label"><?php echo esc_html( $destinations_label ); ?></p>
					<h2 class="dest-heading"><?php echo wp_kses_post( $destinations_title ); ?></h2>
				</div>
				<p class="dest-subtext"><?php echo esc_html( $destinations_text ); ?></p>
			</div>
			<div class="dest-grid">
				<?php foreach ( $destinations as $destination ) : ?>
					<?php if ( ! is_array( $destination ) ) { continue; } ?>
					<?php $destination_image = $image_url( $destination['image'] ?? '', '' ); ?>
					<div class="dest-card">
						<div class="dest-card-bg" style="background-image:url('<?php echo esc_url( $destination_image ); ?>');"></div>
						<div class="dest-card-overlay"></div>
						<div class="dest-card-content">
							<p class="dest-card-region"><?php echo esc_html( $destination['region'] ?? '' ); ?></p>
							<p class="dest-card-name"><?php echo esc_html( $destination['name'] ?? '' ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="enquiry" id="enquiry">
		<div class="enquiry-inner">
			<div class="enquiry-left">
				<p class="section-label"><?php echo esc_html( $enquiry_label ); ?></p>
				<h2 class="enquiry-heading"><?php echo wp_kses_post( $enquiry_title ); ?></h2>
				<p class="enquiry-body"><?php echo esc_html( $enquiry_text ); ?></p>
			</div>
			<form id="sedgemore__form" class="enquiry-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__first_name">First Name</label>
						<input type="text" id="sedgemore__first_name" name="first_name" placeholder="Your first name" required>
						<div class="error-message" data-field="sedgemore__first_name"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__last_name">Last Name</label>
						<input type="text" id="sedgemore__last_name" name="last_name" placeholder="Your last name" required>
						<div class="error-message" data-field="sedgemore__last_name"></div>
					</div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__email_address">Email Address</label>
						<input type="email" id="sedgemore__email_address" name="email_address" placeholder="your@email.com" required>
						<div class="error-message" data-field="sedgemore__email_address"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__phone">Phone</label>
						<input type="text" id="sedgemore__phone" name="phone" placeholder="+44 ..." required>
						<div class="error-message" data-field="sedgemore__phone"></div>
					</div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__dates">Travel Dates</label>
						<input type="text" id="sedgemore__dates" name="dates" placeholder="Approximate dates" required>
						<div class="error-message" data-field="sedgemore__dates"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__destination">Destination</label>
						<input type="text" id="sedgemore__destination" name="destination" placeholder="Country or region" required>
						<div class="error-message" data-field="sedgemore__destination"></div>
					</div>
				</div>
				<div class="form-field">
					<label for="sedgemore__preferences">Preferred Yacht Style</label>
					<select id="sedgemore__preferences" name="preferences" required>
						<option value="" disabled selected></option>
						<option value="Motor Yacht">Motor Yacht</option>
						<option value="Sailing Yacht">Sailing Yacht</option>
						<option value="Catamaran">Catamaran</option>
						<option value="Expedition Vessel">Expedition Vessel</option>
						<option value="Open to Suggestion">Open to Suggestion</option>
					</select>
					<div class="error-message" data-field="sedgemore__preferences"></div>
				</div>
				<div class="form-field">
					<label for="sedgemore__message">Special Requests / Notes</label>
					<textarea id="sedgemore__message" name="message" placeholder="Group size, occasion, preferred pace, onboard needs..." required></textarea>
					<div class="error-message" data-field="sedgemore__message"></div>
				</div>
				<button type="submit" id="sedgemore__submit-btn" class="form-submit">Submit Enquiry</button>
				<p id="sedgemore__form-message" aria-live="polite"></p>
				<input type="hidden" name="action" value="yacht_contact_form">
				<?php wp_nonce_field( 'yacht_contact_nonce_action', 'yacht_contact_nonce' ); ?>
			</form>
		</div>
	</section>
</main>

<?php
get_footer();
