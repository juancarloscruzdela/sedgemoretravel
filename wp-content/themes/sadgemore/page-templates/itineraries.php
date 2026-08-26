<?php
/**
 * Template Name: Itineraries
 *
 * @package sadgemore
 */

get_header();

if ( ! function_exists( 'sedgemore_itineraries_asset_url' ) ) {
	function sedgemore_itineraries_asset_url( $value, $size = 'full' ) {
		if ( empty( $value ) ) {
			return '';
		}

		if ( is_string( $value ) ) {
			return esc_url_raw( $value );
		}

		if ( is_numeric( $value ) ) {
			$url = wp_get_attachment_image_url( (int) $value, $size );
			return $url ? esc_url_raw( $url ) : '';
		}

		if ( is_array( $value ) ) {
			if ( ! empty( $value['url'] ) ) {
				return esc_url_raw( $value['url'] );
			}

			if ( ! empty( $value['ID'] ) ) {
				$url = wp_get_attachment_image_url( (int) $value['ID'], $size );
				return $url ? esc_url_raw( $url ) : '';
			}
		}

		if ( $value instanceof WP_Post ) {
			$url = wp_get_attachment_image_url( (int) $value->ID, $size );
			return $url ? esc_url_raw( $url ) : '';
		}

		return '';
	}
}

if ( ! function_exists( 'sedgemore_itineraries_field' ) ) {
	function sedgemore_itineraries_field( $name, $fallback = '' ) {
		if ( ! function_exists( 'get_field' ) ) {
			return $fallback;
		}

		$value = get_field( $name );
		if ( null === $value || false === $value || '' === $value || ( is_array( $value ) && empty( $value ) ) ) {
			return $fallback;
		}

		return $value;
	}
}

$asset_base = get_template_directory_uri() . '/assets/images/';

$banners     = sedgemore_itineraries_field( 'banners', array() );
$hero_banner = ( is_array( $banners ) && isset( $banners[0] ) && is_array( $banners[0] ) ) ? $banners[0] : array();
$hero_image  = sedgemore_itineraries_asset_url( sedgemore_itineraries_field( 'itineraries_page_hero_image' ) );
if ( ! $hero_image ) {
	$hero_image = sedgemore_itineraries_asset_url( $hero_banner['image'] ?? '' );
}
if ( ! $hero_image ) {
	$hero_image = $asset_base . 'travel_slider1.jpg';
}

$hero_eyebrow      = sedgemore_itineraries_field( 'itineraries_page_hero_eyebrow', 'Travel / Itineraries' );
$hero_title        = sedgemore_itineraries_field( 'itineraries_page_hero_title', 'Thoughtfully<br><em>Designed</em><br>Itineraries' );
$hero_text         = sedgemore_itineraries_field( 'itineraries_page_hero_text', 'Every journey begins with a conversation. We take the time to understand what matters to you, then design an itinerary that feels effortless, meaningful, and uniquely yours.' );
$hero_button_label = sedgemore_itineraries_field( 'itineraries_page_hero_button_label', 'Begin Planning' );
$hero_button_url   = sedgemore_itineraries_field( 'itineraries_page_hero_button_url', '#enquiry' );

$intro_title = sedgemore_itineraries_field( 'itineraries_page_intro_title', 'Built around<br><em>how you travel,</em><br>not where.' );
$intro_body  = sedgemore_itineraries_field(
	'itineraries_page_intro_body',
	'<p>From a single weekend escape to a multi-country expedition, each Sedgemore itinerary is designed with clarity, care, and intention. We do not work from templates. We work from conversations.</p><p>What matters to you, your pace, your interests, the moments you want to remember. These are the details that shape every journey we design.</p>'
);

$destinations_label = sedgemore_itineraries_field( 'itineraries_page_destinations_label', 'Our Favourite Destinations' );
$destinations       = sedgemore_itineraries_field(
	'itineraries_page_destinations',
	array(
		array(
			'image'      => $asset_base . 'travl_2.jpg',
			'region'     => 'Southern Europe',
			'name'       => 'Italy',
			'subtitle'   => 'Slow days in Tuscany and the Amalfi Coast',
			'link_label' => 'View Itineraries',
			'link_url'   => '#enquiry',
		),
		array(
			'image'      => $asset_base . 'travl_3.jpg',
			'region'     => 'Africa',
			'name'       => 'Africa',
			'subtitle'   => 'Safari, coastline, culture and wildlife',
			'link_label' => 'View Itineraries',
			'link_url'   => '#enquiry',
		),
		array(
			'image'      => $asset_base . 'travl_4.jpg',
			'region'     => 'East Asia',
			'name'       => 'Japan',
			'subtitle'   => 'Temples, ryokans, and seasonal landscapes',
			'link_label' => 'View Itineraries',
			'link_url'   => '#enquiry',
		),
		array(
			'image'      => $asset_base . 'travl_5.jpg',
			'region'     => 'Western Europe',
			'name'       => 'France',
			'subtitle'   => 'Burgundy, the Riviera, and Paris in depth',
			'link_label' => 'View Itineraries',
			'link_url'   => '#enquiry',
		),
		array(
			'image'      => $asset_base . 'travel3.png',
			'region'     => 'North Africa',
			'name'       => 'Morocco',
			'subtitle'   => 'Medinas, Atlas, and desert evenings',
			'link_label' => 'View Itineraries',
			'link_url'   => '#enquiry',
		),
		array(
			'image'      => $asset_base . 'slider1.png',
			'region'     => 'United Kingdom',
			'name'       => 'Scotland',
			'subtitle'   => 'Estates, distilleries, and the Highlands',
			'link_label' => 'View Itineraries',
			'link_url'   => '#enquiry',
		),
	)
);

$process_title = sedgemore_itineraries_field( 'itineraries_page_process_title', 'How we<br><em>design your</em><br>journey.' );
$process_text  = sedgemore_itineraries_field( 'itineraries_page_process_text', 'Our process is quiet and considered. We listen carefully before we plan, and we plan carefully before we confirm. Every detail is placed with purpose.' );
$process_steps = sedgemore_itineraries_field(
	'itineraries_page_process_steps',
	array(
		array(
			'number'  => '01',
			'step'    => 'The Conversation',
			'heading' => 'We begin by listening',
			'text'    => 'A call or exchange that covers what matters to you: your pace, your interests, who you are travelling with, what you want to feel. This is not a form. It is a conversation.',
		),
		array(
			'number'  => '02',
			'step'    => 'The Design',
			'heading' => 'We build your itinerary',
			'text'    => 'Drawing from our network of private guides, properties, and local contacts, we design a journey around your brief. Each element is chosen with intention, not filler.',
		),
		array(
			'number'  => '03',
			'step'    => 'The Refinement',
			'heading' => 'We refine together',
			'text'    => 'You review the proposed journey. We adjust, add, remove, or rethink until the itinerary feels right. No detail is too small. No request is unreasonable.',
		),
		array(
			'number'  => '04',
			'step'    => 'The Journey',
			'heading' => 'We remain with you',
			'text'    => 'Once you depart, Sedgemore remains available. Our team is reachable throughout your trip, ready to assist, adjust, or simply be on hand should anything arise.',
		),
	)
);

$enquiry_eyebrow = sedgemore_itineraries_field( 'itineraries_page_enquiry_eyebrow', 'Start Planning' );
$enquiry_title   = sedgemore_itineraries_field( 'itineraries_page_enquiry_title', 'Where would<br>you like<br><em>to go?</em>' );
$enquiry_text    = sedgemore_itineraries_field( 'itineraries_page_enquiry_text', 'Tell us about your journey. A specialist will be in touch to discuss your vision and begin designing your itinerary.' );
$interest_label  = sedgemore_itineraries_field( 'itineraries_page_interest_label', 'I am interested in' );
$submit_label    = sedgemore_itineraries_field( 'itineraries_page_submit_label', 'Submit and Start Planning' );
$interest_options = sedgemore_itineraries_field(
	'itineraries_page_interest_options',
	array(
		array( 'label' => 'Safari', 'value' => 'Safari' ),
		array( 'label' => 'City Stays', 'value' => 'City Stays' ),
		array( 'label' => 'Coastal', 'value' => 'Coastal' ),
		array( 'label' => 'Cultural', 'value' => 'Cultural' ),
		array( 'label' => 'Multi-Country', 'value' => 'Multi-Country' ),
		array( 'label' => 'Rail Journeys', 'value' => 'Rail Journeys' ),
		array( 'label' => 'Private Villa', 'value' => 'Private Villa' ),
		array( 'label' => 'Island Escapes', 'value' => 'Island Escapes' ),
	)
);
?>

<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Jost:wght@200;300;400&display=swap');

.header_bright { display: block; }
.header_dark { display: none; }
.header_nav_fixed { background: #f1eeea; }
.divider_sharp_bright { display: none !important; }
.divider_sharp_dark { display: inline-block !important; }

.itineraries-page,
.itineraries-page * ,
.itineraries-page *::before,
.itineraries-page *::after {
	box-sizing: border-box;
}

.itineraries-page {
	--warm-white: #FAF8F5;
	--cream: #F2EDE6;
	--parchment: #E8E0D5;
	--dark: #1C1A18;
	--charcoal: #2A2825;
	--mid: #6B6560;
	--muted: #9E9890;
	--accent: #C4A882;
	--rule: rgba(28, 26, 24, 0.12);
	--ff-display: 'Cormorant Garamond', Georgia, serif;
	--ff-body: 'Jost', system-ui, sans-serif;
	background: var(--warm-white);
	color: var(--dark);
	font-family: var(--ff-body);
	font-weight: 300;
	-webkit-font-smoothing: antialiased;
	text-rendering: geometricPrecision;
	overflow-x: hidden;
}

.itineraries-page h1,
.itineraries-page h2,
.itineraries-page h3,
.itineraries-page p,
.itineraries-page span,
.itineraries-page a,
.itineraries-page label,
.itineraries-page input,
.itineraries-page textarea,
.itineraries-page button {
	font-weight: inherit;
}

.itineraries-page a {
	text-decoration: none;
}

.itineraries-page .hero {
	position: relative;
	height: 88vh;
	min-height: 580px;
	display: flex;
	align-items: flex-end;
	overflow: hidden;
	background: var(--charcoal);
}

.itineraries-page .hero-img {
	position: absolute;
	inset: 0;
	background-position: center;
	background-size: cover;
	background-repeat: no-repeat;
}

.itineraries-page .hero-img::after {
	content: '';
	position: absolute;
	inset: 0;
	background: linear-gradient(to bottom, rgba(10, 8, 6, 0.35) 0%, rgba(10, 8, 6, 0.2) 40%, rgba(10, 8, 6, 0.72) 100%);
}

.itineraries-page .hero-content {
	position: relative;
	z-index: 2;
	padding: 0 80px 80px;
	max-width: 820px;
	opacity: 0;
	animation: itinerariesFadeUp 1s 0.4s forwards;
}

.itineraries-page .hero-eyebrow,
.itineraries-page .section-label,
.itineraries-page .enquiry-eyebrow {
	font-size: 15px;
	font-weight: 400;
	letter-spacing: 0.28em;
	text-transform: uppercase;
	display: block;
}

.itineraries-page .hero-eyebrow {
	color: var(--accent);
	margin-bottom: 20px;
}

.itineraries-page .hero-title {
	font-family: var(--ff-display);
	font-size: clamp(46px, 6vw, 80px);
	font-weight: 300;
	line-height: 1.05;
	color: #fff;
	margin: 0 0 24px;
}

.itineraries-page em {
	font-style: italic;
}

.itineraries-page .hero-sub {
	font-size: 14px;
	line-height: 1.8;
	color: rgba(255, 255, 255, 0.6);
	letter-spacing: 0.04em;
	max-width: 480px;
	margin: 0 0 40px;
}

.itineraries-page .hero-cta {
	display: inline-block;
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.24em;
	text-transform: uppercase;
	color: var(--dark);
	background: #fff;
	padding: 14px 32px;
	transition: background 0.3s, color 0.3s;
}

.itineraries-page .hero-cta:hover {
	background: var(--dark);
	color: #fff;
}

.itineraries-page .intro {
	padding: 100px 80px;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 100px;
	align-items: start;
	max-width: 1400px;
	margin: 0 auto;
	border-bottom: 1px solid var(--rule);
}

.itineraries-page .intro-headline,
.itineraries-page .how-title,
.itineraries-page .enquiry-title {
	font-family: var(--ff-display);
	font-weight: 300;
	color: var(--dark);
}

.itineraries-page .intro-headline {
	font-size: clamp(34px, 3.5vw, 50px);
	line-height: 1.18;
	margin: 0;
}

.itineraries-page .intro-body {
	padding-top: 8px;
}

.itineraries-page .intro-body p,
.itineraries-page .how-intro,
.itineraries-page .enquiry-text {
	font-size: 14px;
	line-height: 1.9;
	color: var(--mid);
	letter-spacing: 0.02em;
	margin: 0;
}

.itineraries-page .intro-body p + p {
	margin-top: 20px;
}

.itineraries-page .destinations {
	padding: 80px 80px 100px;
	max-width: 1400px;
	margin: 0 auto;
}

.itineraries-page .section-label {
	color: var(--muted);
	margin-bottom: 48px;
}

.itineraries-page .dest-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 2px;
}

.itineraries-page .dest-card {
	position: relative;
	aspect-ratio: 3 / 4;
	overflow: hidden;
	background: var(--cream);
}

.itineraries-page .dest-card-img {
	position: absolute;
	inset: 0;
	background-position: center;
	background-size: cover;
	background-repeat: no-repeat;
	transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.itineraries-page .dest-card:hover .dest-card-img {
	transform: scale(1.04);
}

.itineraries-page .dest-card-overlay {
	position: absolute;
	inset: 0;
	background: linear-gradient(to top, rgba(15, 12, 8, 0.82) 0%, rgba(15, 12, 8, 0.15) 55%, transparent 100%);
}

.itineraries-page .dest-card-body {
	position: absolute;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 2;
	padding: 32px;
}

.itineraries-page .dest-region,
.itineraries-page .process-step,
.itineraries-page .interest-label,
.itineraries-page .form-field label {
	font-size: 9px;
	font-weight: 400;
	letter-spacing: 0.28em;
	text-transform: uppercase;
	color: var(--accent);
	display: block;
}

.itineraries-page .dest-region {
	margin-bottom: 8px;
}

.itineraries-page .dest-name {
	font-family: var(--ff-display);
	font-size: 28px;
	font-weight: 300;
	color: #fff;
	line-height: 1.1;
	margin: 0 0 6px;
}

.itineraries-page .dest-sub {
	font-size: 11px;
	letter-spacing: 0.04em;
	color: rgba(255, 255, 255, 0.5);
	line-height: 1.6;
	margin: 0;
}

.itineraries-page .dest-link {
	display: inline-block;
	margin-top: 16px;
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: rgba(255, 255, 255, 0.7);
	border-bottom: 1px solid rgba(255, 255, 255, 0.25);
	padding-bottom: 4px;
	opacity: 0;
	transform: translateY(8px);
	transition: opacity 0.3s, transform 0.3s, color 0.3s;
}

.itineraries-page .dest-card:hover .dest-link {
	opacity: 1;
	transform: translateY(0);
}

.itineraries-page .dest-link::after {
	content: ' ->';
}

.itineraries-page .how {
	padding: 100px 80px;
	max-width: 1400px;
	margin: 0 auto;
	border-top: 1px solid var(--rule);
}

.itineraries-page .how-header {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 80px;
	margin-bottom: 72px;
}

.itineraries-page .how-title {
	font-size: clamp(34px, 3.5vw, 50px);
	line-height: 1.15;
	margin: 0;
}

.itineraries-page .how-intro {
	padding-top: 8px;
}

.itineraries-page .process-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 2px;
}

.itineraries-page .process-card {
	background: var(--cream);
	padding: 48px 40px;
	position: relative;
	overflow: hidden;
}

.itineraries-page .process-number {
	font-family: var(--ff-display);
	font-size: 80px;
	font-weight: 300;
	color: rgba(28, 26, 24, 0.06);
	line-height: 1;
	position: absolute;
	top: 20px;
	right: 24px;
}

.itineraries-page .process-step {
	margin-bottom: 20px;
}

.itineraries-page .process-heading {
	font-family: var(--ff-display);
	font-size: 22px;
	font-weight: 300;
	line-height: 1.25;
	color: var(--dark);
	margin: 0 0 16px;
}

.itineraries-page .process-text {
	font-size: 13px;
	line-height: 1.85;
	color: var(--mid);
	letter-spacing: 0.02em;
	margin: 0;
}

.itineraries-page .enquiry {
	background: var(--cream);
	padding: 100px 80px;
	border-top: 1px solid var(--rule);
}

.itineraries-page .enquiry-inner {
	max-width: 1400px;
	margin: 0 auto;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 100px;
	align-items: start;
}

.itineraries-page .enquiry-eyebrow {
	color: var(--muted);
	margin-bottom: 24px;
}

.itineraries-page .enquiry-title {
	font-size: clamp(34px, 3.5vw, 52px);
	line-height: 1.12;
	margin: 0 0 28px;
}

.itineraries-page .enquiry-text {
	font-size: 13px;
}

.itineraries-page .enquiry-form {
	display: flex;
	flex-direction: column;
	gap: 16px;
	padding-top: 4px;
}

.itineraries-page .interest-label {
	color: var(--muted);
	margin-bottom: 12px;
}

.itineraries-page .interest-options {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 8px;
}

.itineraries-page .interest-chip {
	position: relative;
	display: inline-flex;
	align-items: center;
	font-size: 10px;
	font-weight: 300;
	letter-spacing: 0.08em;
	color: var(--mid);
	border: 1px solid var(--parchment);
	padding: 8px 16px;
	cursor: pointer;
	transition: border-color 0.2s, color 0.2s, background 0.2s;
	user-select: none;
	background: var(--warm-white);
}

.itineraries-page .interest-chip input {
	position: absolute;
	opacity: 0;
	pointer-events: none;
}

.itineraries-page .interest-chip:hover,
.itineraries-page .interest-chip.active {
	border-color: var(--dark);
	color: var(--dark);
	background: #fff;
}

.itineraries-page .form-row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 12px;
}

.itineraries-page .form-field {
	display: flex;
	flex-direction: column;
	gap: 6px;
}

.itineraries-page .form-field label {
	color: var(--muted);
}

.itineraries-page .form-field input,
.itineraries-page .form-field textarea {
	background: var(--warm-white);
	border: 1px solid var(--parchment);
	color: var(--dark);
	font-family: var(--ff-body);
	font-size: 13px;
	font-weight: 300;
	padding: 12px 16px;
	outline: none;
	transition: border-color 0.2s;
	resize: none;
}

.itineraries-page .form-field input::placeholder,
.itineraries-page .form-field textarea::placeholder {
	color: var(--muted);
	font-size: 12px;
}

.itineraries-page .form-field input:focus,
.itineraries-page .form-field textarea:focus {
	border-color: var(--dark);
}

.itineraries-page .form-field.full {
	grid-column: 1 / -1;
}

.itineraries-page .form-submit {
	display: inline-block;
	font-family: var(--ff-body);
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.24em;
	text-transform: uppercase;
	color: #fff;
	background: var(--dark);
	border: none;
	padding: 15px 36px;
	cursor: pointer;
	transition: background 0.3s, color 0.3s;
	align-self: flex-start;
	margin-top: 8px;
}

.itineraries-page .form-submit:hover {
	background: #fff;
	color: var(--dark);
}

.itineraries-page .form-message {
	font-size: 13px;
	color: var(--mid);
	min-height: 20px;
	margin: 0;
}

.itineraries-page .reveal {
	opacity: 0;
	transform: translateY(24px);
	transition: opacity 0.75s ease, transform 0.75s ease;
}

.itineraries-page .reveal.visible {
	opacity: 1;
	transform: none;
}

@keyframes itinerariesFadeUp {
	from {
		opacity: 0;
		transform: translateY(20px);
	}
	to {
		opacity: 1;
		transform: none;
	}
}

@media (max-width: 1100px) {
	.itineraries-page .intro,
	.itineraries-page .enquiry-inner {
		grid-template-columns: 1fr;
		gap: 48px;
	}

	.itineraries-page .dest-grid,
	.itineraries-page .process-grid {
		grid-template-columns: repeat(2, 1fr);
	}

	.itineraries-page .how-header {
		grid-template-columns: 1fr;
		gap: 24px;
	}
}

@media (min-width: 721px) and (max-height: 760px) {
	.itineraries-page .hero {
		min-height: 620px;
	}

	.itineraries-page .hero-content {
		padding-bottom: 118px;
	}

	.itineraries-page .hero-eyebrow {
		margin-bottom: 14px;
	}

	.itineraries-page .hero-title {
		font-size: clamp(42px, 4.6vw, 64px);
		line-height: 1;
		margin-bottom: 18px;
	}

	.itineraries-page .hero-sub {
		line-height: 1.65;
		margin-bottom: 28px;
	}
}

@media (max-width: 720px) {
	.itineraries-page .hero-content {
		padding: 0 32px 60px;
	}

	.itineraries-page .intro,
	.itineraries-page .destinations,
	.itineraries-page .how {
		padding: 64px 32px;
	}

	.itineraries-page .enquiry {
		padding: 72px 32px;
	}

	.itineraries-page .dest-grid,
	.itineraries-page .process-grid,
	.itineraries-page .form-row {
		grid-template-columns: 1fr;
	}
}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="itineraries-page">
	<section class="hero">
		<div class="hero-img" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');"></div>
		<div class="hero-content">
			<span class="hero-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></span>
			<h1 class="hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="hero-sub"><?php echo esc_html( $hero_text ); ?></p>
			<a href="<?php echo esc_url( $hero_button_url ); ?>" class="hero-cta"><?php echo esc_html( $hero_button_label ); ?></a>
		</div>
	</section>

	<section class="intro reveal">
		<div>
			<h2 class="intro-headline"><?php echo wp_kses_post( $intro_title ); ?></h2>
		</div>
		<div class="intro-body">
			<?php echo wp_kses_post( $intro_body ); ?>
		</div>
	</section>

	<section class="destinations">
		<span class="section-label reveal"><?php echo esc_html( $destinations_label ); ?></span>
		<div class="dest-grid">
			<?php foreach ( (array) $destinations as $destination ) : ?>
				<?php
				$destination_image      = sedgemore_itineraries_asset_url( $destination['image'] ?? '', 'large' );
				$destination_url        = $destination['link_url'] ?? '#enquiry';
				$destination_link_label = trim( (string) ( $destination['link_label'] ?? 'View Itineraries' ) );
				?>
				<div class="dest-card reveal">
					<div class="dest-card-img" style="background-image: url('<?php echo esc_url( $destination_image ); ?>');"></div>
					<div class="dest-card-overlay"></div>
					<div class="dest-card-body">
						<span class="dest-region"><?php echo esc_html( $destination['region'] ?? '' ); ?></span>
						<h3 class="dest-name"><?php echo esc_html( $destination['name'] ?? '' ); ?></h3>
						<p class="dest-sub"><?php echo esc_html( $destination['subtitle'] ?? '' ); ?></p>
						<?php if ( '' !== $destination_link_label ) : ?>
							<a href="<?php echo esc_url( $destination_url ); ?>" class="dest-link"><?php echo esc_html( $destination_link_label ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="how">
		<div class="how-header reveal">
			<h2 class="how-title"><?php echo wp_kses_post( $process_title ); ?></h2>
			<p class="how-intro"><?php echo esc_html( $process_text ); ?></p>
		</div>
		<div class="process-grid">
			<?php foreach ( (array) $process_steps as $step ) : ?>
				<div class="process-card reveal">
					<span class="process-number"><?php echo esc_html( $step['number'] ?? '' ); ?></span>
					<span class="process-step"><?php echo esc_html( $step['step'] ?? '' ); ?></span>
					<h3 class="process-heading"><?php echo esc_html( $step['heading'] ?? '' ); ?></h3>
					<p class="process-text"><?php echo esc_html( $step['text'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="enquiry" id="enquiry">
		<div class="enquiry-inner">
			<div class="enquiry-left reveal">
				<span class="enquiry-eyebrow"><?php echo esc_html( $enquiry_eyebrow ); ?></span>
				<h2 class="enquiry-title"><?php echo wp_kses_post( $enquiry_title ); ?></h2>
				<p class="enquiry-text"><?php echo esc_html( $enquiry_text ); ?></p>
			</div>
			<form id="sedgemore__form" class="enquiry-form reveal">
				<div>
					<span class="interest-label"><?php echo esc_html( $interest_label ); ?></span>
					<div class="interest-options" role="group" aria-label="<?php echo esc_attr( $interest_label ); ?>">
						<?php foreach ( (array) $interest_options as $index => $option ) : ?>
							<?php
							$option_label = $option['label'] ?? '';
							$option_value = $option['value'] ?? $option_label;
							if ( ! $option_label ) {
								continue;
							}
							$option_id = 'itinerary_interest_' . $index . '_' . sanitize_title( $option_value );
							?>
							<label class="interest-chip" for="<?php echo esc_attr( $option_id ); ?>">
								<input id="<?php echo esc_attr( $option_id ); ?>" type="checkbox" name="itinerary_interest[]" value="<?php echo esc_attr( $option_value ); ?>">
								<span><?php echo esc_html( $option_label ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__destination">Destination</label>
						<input type="text" id="sedgemore__destination" name="destination_display" placeholder="Where are you considering?">
						<div class="error-message" data-field="sedgemore__destination"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__dates">Travel Dates</label>
						<input type="text" id="sedgemore__dates" name="dates" placeholder="Approximate dates or season" required>
						<div class="error-message" data-field="sedgemore__dates"></div>
					</div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__first_name">First Name</label>
						<input type="text" id="sedgemore__first_name" name="first_name" placeholder="First name" required>
						<div class="error-message" data-field="sedgemore__first_name"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__last_name">Last Name</label>
						<input type="text" id="sedgemore__last_name" name="last_name" placeholder="Last name" required>
						<div class="error-message" data-field="sedgemore__last_name"></div>
					</div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="sedgemore__email_address">Email</label>
						<input type="email" id="sedgemore__email_address" name="email_address" placeholder="Your email address" required>
						<div class="error-message" data-field="sedgemore__email_address"></div>
					</div>
					<div class="form-field">
						<label for="sedgemore__group_size">Group Size</label>
						<input type="text" id="sedgemore__group_size" name="group_size_display" placeholder="How many travellers?">
						<div class="error-message" data-field="sedgemore__group_size"></div>
					</div>
				</div>
				<div class="form-field full">
					<label for="sedgemore__message">Notes</label>
					<textarea id="sedgemore__message" name="message" rows="3" placeholder="Anything we should know before we begin?"></textarea>
					<div class="error-message" data-field="sedgemore__message"></div>
				</div>
				<p id="sedgemore__form-message" class="form-message" aria-live="polite"></p>
				<button class="form-submit" type="submit"><?php echo esc_html( $submit_label ); ?></button>
				<input type="hidden" id="sedgemore__preferences" name="preferences" value="Itinerary enquiry">
				<input type="hidden" name="form_origin" value="itineraries">
				<input type="hidden" name="action" value="travel_contact_form">
				<?php wp_nonce_field( 'travel_contact_nonce_action', 'travel_contact_nonce' ); ?>
			</form>
		</div>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var reveals = document.querySelectorAll('.itineraries-page .reveal');
	var form = document.getElementById('sedgemore__form');

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('visible');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.08 });

		reveals.forEach(function (el) {
			observer.observe(el);
		});
	} else {
		reveals.forEach(function (el) {
			el.classList.add('visible');
		});
	}

	if (form) {
		var chips = form.querySelectorAll('.interest-chip');
		var preferences = document.getElementById('sedgemore__preferences');
		var destination = document.getElementById('sedgemore__destination');
		var groupSize = document.getElementById('sedgemore__group_size');

		function syncPreferences() {
			var selected = [];
			form.querySelectorAll('input[name="itinerary_interest[]"]:checked').forEach(function (input) {
				selected.push(input.value);
			});

			var parts = [];
			if (selected.length) {
				parts.push('Interests: ' + selected.join(', '));
			}
			if (destination && destination.value.trim()) {
				parts.push('Destination: ' + destination.value.trim());
			}
			if (groupSize && groupSize.value.trim()) {
				parts.push('Group size: ' + groupSize.value.trim());
			}

			preferences.value = parts.length ? parts.join(' | ') : 'Itinerary enquiry';
		}

		chips.forEach(function (chip) {
			var input = chip.querySelector('input');
			if (!input) {
				return;
			}

			input.addEventListener('change', function () {
				chip.classList.toggle('active', input.checked);
				syncPreferences();
			});
		});

		['input', 'change'].forEach(function (eventName) {
			form.addEventListener(eventName, syncPreferences, true);
		});

		form.addEventListener('submit', syncPreferences, true);
		form.addEventListener('reset', function () {
			setTimeout(function () {
				chips.forEach(function (chip) {
					chip.classList.remove('active');
				});
				syncPreferences();
			}, 0);
		});
	}
});
</script>

<?php
get_footer();
