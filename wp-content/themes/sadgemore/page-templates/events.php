<?php
/**
 * Template Name: Events
 *
 * @package sadgemore
 */

get_header();

$asset_base = get_template_directory_uri() . '/assets/images/events-page/';

if ( ! function_exists( 'sedgemore_events_asset_url' ) ) {
	function sedgemore_events_asset_url( $value, $size = 'full' ) {
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

if ( ! function_exists( 'sedgemore_events_field' ) ) {
	function sedgemore_events_field( $name, $fallback = '' ) {
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

$hero_video        = sedgemore_events_field( 'events_page_hero_video_url', '/wp-content/uploads/2026/06/events-page-hero-banner-video-bg.mp4' );
$hero_eyebrow      = sedgemore_events_field( 'events_page_hero_eyebrow', 'Events &amp; Experiences' );
$hero_title        = sedgemore_events_field( 'events_page_hero_title', 'Every occasion<br><em>composed in full.</em>' );
$hero_text         = sedgemore_events_field( 'events_page_hero_text', 'Sedgemore does not produce events. It composes them. From the first conversation to the final departure, each occasion is shaped around the people it is designed for.' );
$hero_button_label = sedgemore_events_field( 'events_page_hero_button_label', 'Begin a conversation' );
$hero_button_url   = sedgemore_events_field( 'events_page_hero_button_url', '#cta' );

$intro_label = sedgemore_events_field( 'events_page_intro_label', 'Our Approach' );
$intro_title = sedgemore_events_field( 'events_page_intro_title', 'Quietly exceptional.<br><em>Deliberately yours.</em>' );
$intro_body  = sedgemore_events_field(
	'events_page_intro_body',
	"There is a particular kind of occasion that resists the ordinary. A corporate incentive that moves beyond reward into genuine memory. A private gathering that holds its atmosphere long after guests have left. A fashion week schedule that feels deliberate rather than rushed.\n\nThis is the territory Sedgemore works within. We are not an event agency in the conventional sense. We are a curatorial partner, brought in where precision, discretion, and deep operational knowledge are required in equal measure.\n\nEvery engagement begins with a conversation. We listen before we propose."
);
$intro_image = sedgemore_events_asset_url( sedgemore_events_field( 'events_page_intro_image' ), 'large' );
$intro_image = $intro_image ? $intro_image : $asset_base . 'our-approach.svg';

$services_label = sedgemore_events_field( 'events_page_services_label', 'What We Create' );
$services_title = sedgemore_events_field( 'events_page_services_title', 'Occasions with<br><em>a private standard.</em>' );
$services_text  = sedgemore_events_field( 'events_page_services_text', 'Every event is different because every client, guest list, location, and intention is different. Sedgemore builds each occasion from the ground up.' );
$service_cards  = sedgemore_events_field(
	'events_page_service_cards',
	array(
		array( 'title' => 'Private Celebrations', 'text' => 'Milestone birthdays, anniversaries, family gatherings, and intimate occasions shaped with discretion and personal nuance.' ),
		array( 'title' => 'Corporate Retreats', 'text' => 'Executive escapes, leadership programmes, and incentive travel designed to feel considered rather than conventional.' ),
		array( 'title' => 'Brand Experiences', 'text' => 'Launches, dinners, hospitality moments, and cultural programmes with a clear sense of atmosphere and intention.' ),
		array( 'title' => 'Destination Events', 'text' => 'Multi-day occasions across private estates, hotels, villas, yachts, and venues selected for the people attending.' ),
		array( 'title' => 'Fashion Week Programmes', 'text' => 'Show schedules, private dinners, accommodation, transportation, access, and guest logistics held by one team.' ),
		array( 'title' => 'Private Hospitality', 'text' => 'A quiet layer around major sporting, cultural, and social occasions, from arrivals to tables to onward travel.' ),
	)
);

$difference_image = sedgemore_events_asset_url( sedgemore_events_field( 'events_page_difference_image' ), 'large' );
$difference_image = $difference_image ? $difference_image : $asset_base . 'the-sedgemore-difference.svg';
$difference_label = sedgemore_events_field( 'events_page_difference_label', 'The Sedgemore Difference' );
$difference_title = sedgemore_events_field( 'events_page_difference_title', 'Atmosphere is<br><em>not accidental.</em>' );
$difference_body  = sedgemore_events_field(
	'events_page_difference_body',
	"The quality of an occasion is determined long before guests arrive. The seating arrangement relative to the light. The temperature of the room at 9pm. The brief given to the sommelier. The pause between courses.\n\nSedgemore operates at this level of specificity because our clients expect it and because it is the only way to produce something genuinely measured."
);
$difference_points = sedgemore_events_field(
	'events_page_difference_points',
	array(
		array( 'text' => 'Discreet, non-intrusive operations' ),
		array( 'text' => 'Trusted supplier network across 40+ destinations' ),
		array( 'text' => 'Named specialist assigned from brief to completion' ),
		array( 'text' => 'Access to venues not available through conventional channels' ),
		array( 'text' => 'Full confidentiality as standard' ),
	)
);

$process_label = sedgemore_events_field( 'events_page_process_label', 'How We Work' );
$process_title = sedgemore_events_field( 'events_page_process_title', 'Four stages.<br><em>One point of contact.</em>' );
$process_text  = sedgemore_events_field( 'events_page_process_text', 'Every engagement moves through the same four stages, regardless of scale. A twenty-person executive retreat and a three-hundred-person brand event receive identical care at each one.' );
$process_steps = sedgemore_events_field(
	'events_page_process_steps',
	array(
		array( 'number' => '1', 'title' => 'Listen', 'text' => 'We begin with a brief. Not a form. A conversation with the person responsible for the outcome, to understand what the occasion is actually for.' ),
		array( 'number' => '2', 'title' => 'Design', 'text' => 'A tailored proposal follows. Venue recommendations, programme structure, supplier selection, and a logistics overview, presented for discussion and refinement.' ),
		array( 'number' => '3', 'title' => 'Execute', 'text' => 'Sedgemore manages every operational layer. You or your guests experience the event. We manage everything behind it.' ),
		array( 'number' => '4', 'title' => 'Follow Through', 'text' => 'After the event, we handle guest departures, supplier settlements, and a full debrief. The relationship does not end when the occasion does.' ),
	)
);

$concierge_label        = sedgemore_events_field( 'events_page_concierge_label', 'Connected Services' );
$concierge_title        = sedgemore_events_field( 'events_page_concierge_title', 'The event is one part<br><em>of the journey.</em>' );
$concierge_body         = sedgemore_events_field( 'events_page_concierge_body', "Sedgemore manages not only the occasion itself, but everything surrounding it. The suite reserved ahead of arrival. The private transfer from the airport. The restaurant held for the night before. The departure arranged without delay.\n\nThis is where events and concierge become one service, held by the same team, to the same standard." );
$concierge_button_label = sedgemore_events_field( 'events_page_concierge_button_label', 'Explore concierge services' );
$concierge_button_url   = sedgemore_events_field( 'events_page_concierge_button_url', home_url( '/concierge/' ) );
$concierge_pillars      = sedgemore_events_field(
	'events_page_concierge_pillars',
	array(
		array( 'title' => 'Travel &amp; Accommodation', 'text' => 'Private suites, curated properties, and seamless arrivals coordinated across all guest profiles.' ),
		array( 'title' => 'Ground Transportation', 'text' => 'Helicopter transfers, private drivers, yacht charters, and airport coordination for all arrivals and departures.' ),
		array( 'title' => 'Access &amp; Reservations', 'text' => 'Tables, tickets, cultural access, and venue arrangements that are not available through conventional enquiry.' ),
		array( 'title' => 'Guest Coordination', 'text' => 'Dedicated attention for each principal guest, from dietary requirements to personal preferences held across every touchpoint.' ),
	)
);

$cta_label                = sedgemore_events_field( 'events_page_cta_label', 'Begin Here' );
$cta_title                = sedgemore_events_field( 'events_page_cta_title', 'Something particular<br><em>in mind.</em>' );
$cta_text                 = sedgemore_events_field( 'events_page_cta_text', 'Tell us the occasion. We will handle the rest.' );
$cta_occasion_label       = sedgemore_events_field( 'events_page_cta_occasion_label', 'The Occasion' );
$cta_occasion_placeholder = sedgemore_events_field( 'events_page_cta_occasion_placeholder', 'Corporate retreat, private celebration, brand event...' );
$cta_message_label        = sedgemore_events_field( 'events_page_cta_message_label', 'Tell Us More' );
$cta_message_placeholder  = sedgemore_events_field( 'events_page_cta_message_placeholder', 'Dates, location, number of guests, or any other detail that shapes the occasion.' );
$cta_submit_label         = sedgemore_events_field( 'events_page_cta_submit_label', 'Send Enquiry' );
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

<style>
.header_bright {
	display: block;
}

.header_dark {
	display: none;
}

.header_nav_fixed {
	background: #f1eeea;
}

.divider_sharp_bright {
	display: none !important;
}

.divider_sharp_dark {
	display: inline-block !important;
}

.events-page,
.events-page *,
.events-page *::before,
.events-page *::after {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

.events-page {
	--cream: #F5F2ED;
	--warm-white: #FAFAF7;
	--charcoal: #2A2A27;
	--mid: #6B6861;
	--light: #A8A49E;
	--accent: #C9A87C;
	--border: rgba(42, 42, 39, 0.12);
	--serif: 'Cormorant Garamond', Georgia, serif;
	--sans: 'Montserrat', sans-serif;
	background: var(--warm-white);
	color: var(--charcoal);
	font-family: var(--sans);
	overflow-x: hidden;
	-webkit-font-smoothing: antialiased;
}

.events-page img {
	display: block;
	max-width: 100%;
}

.events-page a {
	text-decoration: none;
}

.events-page .hero {
	position: relative;
	height: 100vh;
	min-height: 700px;
	display: flex;
	align-items: flex-end;
	padding: 0 3rem 6rem;
	overflow: hidden;
}

.events-page .hero-bg {
	position: absolute;
	inset: 0;
	width: 100%;
	height: 100%;
	object-fit: cover;
	object-position: center;
	background: var(--charcoal);
}

.events-page .hero-overlay {
	position: absolute;
	inset: 0;
	background: linear-gradient(135deg, rgba(201, 168, 124, 0.06) 0%, transparent 60%);
}

.events-page .hero-content {
	position: relative;
	z-index: 2;
	max-width: 700px;
}

.events-page .hero-eyebrow,
.events-page .section-label {
	display: block;
	font-family: var(--sans);
	font-size: 10px;
	letter-spacing: 0.3em;
	text-transform: uppercase;
	color: var(--accent);
}

.events-page .hero-eyebrow {
	margin-bottom: 1.5rem;
}

.events-page .section-label {
	font-size: 11px;
	letter-spacing: 0.35em;
	margin-bottom: 2rem;
}

.events-page .hero-title {
	font-family: var(--serif);
	font-size: clamp(3rem, 5.5vw, 5.5rem);
	font-weight: 300;
	line-height: 1.05;
	color: #fff;
	margin-bottom: 1.75rem;
}

.events-page .hero-title em,
.events-page h2 em {
	font-style: italic;
	font-weight: 300;
}

.events-page .hero-sub {
	font-family: var(--sans);
	font-size: 15px;
	font-weight: 300;
	line-height: 1.8;
	color: rgba(255, 255, 255, 0.72);
	max-width: 480px;
	letter-spacing: 0.04em;
}

.events-page .hero-cta {
	display: flex;
	align-items: center;
	gap: 2rem;
	margin-top: 2.25rem;
}

.events-page .hero-btn {
	display: inline-block;
	background: #fff;
	color: var(--charcoal);
	font-family: var(--sans);
	font-size: 10px;
	letter-spacing: 0.28em;
	text-transform: uppercase;
	padding: 1rem 2rem;
	transition: background 0.3s, color 0.3s;
}

.events-page .hero-btn:hover {
	background: var(--charcoal);
	color: #fff;
}

.events-page section {
	padding: 7rem 3rem;
}

.events-page .intro {
	background: var(--warm-white);
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 6rem;
	align-items: center;
}

.events-page .intro-text h2,
.events-page .services-intro h2,
.events-page .process-header h2,
.events-page .concierge-bridge h2,
.events-page .cta-left h2 {
	font-family: var(--serif);
	font-weight: 300;
	line-height: 1.2;
	color: var(--charcoal);
}

.events-page .intro-text h2 {
	font-size: clamp(2.2rem, 3.5vw, 3.5rem);
	margin-bottom: 2rem;
}

.events-page .intro-text p,
.events-page .services-intro p,
.events-page .process-header p,
.events-page .cta-left p {
	font-size: 15px;
	font-weight: 300;
	line-height: 1.85;
	color: var(--mid);
	letter-spacing: 0.03em;
}

.events-page .intro-text p {
	line-height: 1.9;
	margin-bottom: 1.25rem;
}

.events-page .intro-image {
	position: relative;
	height: 580px;
	overflow: hidden;
}

.events-page .intro-image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.events-page .divider {
	border: none;
	border-top: 0.5px solid var(--border);
	margin: 0 3rem;
}

.events-page .services {
	background: var(--cream);
}

.events-page .services-intro {
	max-width: 560px;
	margin-bottom: 5rem;
}

.events-page .services-intro h2,
.events-page .process-header h2,
.events-page .concierge-bridge h2 {
	font-size: clamp(2rem, 3vw, 3rem);
	margin-bottom: 1.25rem;
}

.events-page .services-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 1.5px;
	background: var(--border);
}

.events-page .service-card {
	background: var(--cream);
	padding: 2.5rem;
	position: relative;
	overflow: hidden;
	cursor: default;
}

.events-page .service-title {
	font-family: var(--serif);
	font-size: 1.4rem;
	font-weight: 400;
	line-height: 1.25;
	color: var(--charcoal);
	margin-bottom: 1rem;
}

.events-page .service-desc {
	font-size: 15px;
	font-weight: 300;
	line-height: 1.8;
	color: var(--mid);
	letter-spacing: 0.02em;
}

.events-page .cinematic {
	display: grid;
	grid-template-columns: 1fr 1fr;
	min-height: 600px;
}

.events-page .cinematic-image {
	overflow: hidden;
	position: relative;
}

.events-page .cinematic-image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	transition: transform 0.8s ease;
}

.events-page .cinematic-image:hover img {
	transform: scale(1.04);
}

.events-page .cinematic-text {
	background: var(--charcoal);
	padding: 6rem 4rem;
	display: flex;
	flex-direction: column;
	justify-content: center;
}

.events-page .cinematic-text h2 {
	font-family: var(--serif);
	font-size: clamp(2rem, 2.8vw, 2.8rem);
	font-weight: 300;
	color: #fff;
	line-height: 1.2;
	margin-bottom: 2rem;
}

.events-page .cinematic-text p,
.events-page .concierge-bridge p {
	font-size: 15px;
	font-weight: 300;
	line-height: 1.85;
	color: rgba(255, 255, 255, 0.6);
	letter-spacing: 0.03em;
	margin-bottom: 1.25rem;
	max-width: 400px;
}

.events-page .cinematic-list {
	list-style: none;
	margin-top: 1rem;
}

.events-page .cinematic-list li {
	font-size: 15px;
	font-weight: 300;
	letter-spacing: 0.06em;
	color: rgba(255, 255, 255, 0.45);
	padding: 0.7rem 0;
	display: flex;
	align-items: center;
	gap: 1rem;
	text-transform: uppercase;
}

.events-page .cinematic-list li::before {
	content: '\2713';
	color: var(--accent);
	font-size: 13px;
	flex-shrink: 0;
}

.events-page .process {
	background: var(--warm-white);
}

.events-page .process-header {
	text-align: center;
	margin-bottom: 4rem;
}

.events-page .process-header p {
	max-width: 500px;
	margin: 0 auto;
}

.events-page .process-grid {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 1.5px;
	background: var(--border);
}

.events-page .process-card {
	background: var(--warm-white);
	padding: 3rem;
	display: flex;
	gap: 2rem;
	align-items: flex-start;
}

.events-page .process-card-num {
	font-family: var(--serif);
	font-size: clamp(3.5rem, 5vw, 5rem);
	font-weight: 300;
	line-height: 1;
	color: rgba(201, 168, 124, 0.18);
	flex-shrink: 0;
	width: 70px;
	text-align: right;
	user-select: none;
}

.events-page .process-card-body {
	flex: 1;
	padding-top: 0.5rem;
}

.events-page .step-title {
	font-family: var(--serif);
	font-size: 15px;
	font-weight: 400;
	color: var(--charcoal);
	margin-bottom: 0.75rem;
	letter-spacing: 0.02em;
}

.events-page .step-desc {
	font-size: 15px;
	font-weight: 300;
	line-height: 1.8;
	color: var(--mid);
	letter-spacing: 0.02em;
}

.events-page .concierge-bridge {
	background: var(--charcoal);
	padding: 8rem 3rem;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 6rem;
	align-items: center;
}

.events-page .concierge-bridge h2 {
	color: #fff;
}

.events-page .concierge-bridge p {
	color: rgba(255, 255, 255, 0.55);
	margin-bottom: 1rem;
}

.events-page .cta-ghost {
	display: inline-block;
	margin-top: 1.5rem;
	font-size: 10px;
	letter-spacing: 0.25em;
	text-transform: uppercase;
	color: #fff;
	border: 0.5px solid rgba(255, 255, 255, 0.5);
	padding: 0.9rem 1.75rem;
	transition: background 0.3s, color 0.3s, border-color 0.3s;
}

.events-page .cta-ghost:hover {
	background: #fff;
	color: var(--charcoal);
	border-color: #fff;
}

.events-page .concierge-pillars {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 2rem;
}

.events-page .pillar-title {
	font-family: var(--serif);
	font-size: 1rem;
	font-weight: 400;
	color: #fff;
	margin-bottom: 0.6rem;
}

.events-page .pillar-text {
	font-size: 15px;
	font-weight: 300;
	line-height: 1.7;
	color: rgba(255, 255, 255, 0.4);
	letter-spacing: 0.02em;
}

.events-page .cta-section {
	background: var(--warm-white);
	padding: 8rem 3rem;
	position: relative;
	overflow: hidden;
}

.events-page .cta-inner {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 6rem;
	align-items: start;
	max-width: 1200px;
	margin: auto;
}

.events-page .cta-left h2 {
	font-size: clamp(2.2rem, 3.5vw, 3.8rem);
	line-height: 1.15;
	margin-bottom: 1.5rem;
}

.events-page .cta-left p {
	max-width: 340px;
}

.events-page .cta-form {
	display: flex;
	flex-direction: column;
	gap: 1.25rem;
}

.events-page .form-row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 1rem;
}

.events-page .form-group {
	display: flex;
	flex-direction: column;
	gap: 0.4rem;
}

.events-page .form-group label {
	font-size: 9px;
	letter-spacing: 0.25em;
	text-transform: uppercase;
	color: var(--light);
}

.events-page .form-group input,
.events-page .form-group textarea {
	background: transparent;
	border: none;
	border-bottom: 0.5px solid var(--border);
	padding: 0.65rem 0;
	font-family: var(--sans);
	font-size: 15px;
	font-weight: 300;
	color: var(--charcoal);
	letter-spacing: 0.03em;
	outline: none;
	transition: border-color 0.3s;
	resize: none;
	border-radius: 0;
	box-shadow: none;
}

.events-page .form-group input::placeholder,
.events-page .form-group textarea::placeholder {
	color: var(--light);
}

.events-page .form-group input:focus,
.events-page .form-group textarea:focus {
	border-color: var(--accent);
}

.events-page .form-submit {
	align-self: flex-start;
	margin-top: 0.5rem;
	background: var(--charcoal);
	color: #fff;
	border: 0.5px solid var(--charcoal);
	font-family: var(--sans);
	font-size: 10px;
	letter-spacing: 0.3em;
	text-transform: uppercase;
	padding: 1rem 2.25rem;
	cursor: pointer;
	transition: background 0.3s, color 0.3s;
}

.events-page .form-submit:hover {
	background: #fff;
	color: var(--charcoal);
}

.events-page .form-message {
	min-height: 22px;
	color: var(--mid);
	font-size: 13px;
	line-height: 1.5;
}

.events-page .form-message.success {
	color: #2f6b3d;
}

.events-page .form-message.error {
	color: #9a4b43;
}

.events-page .fade-up {
	opacity: 0;
	transform: translateY(24px);
	transition: opacity 0.75s ease, transform 0.75s ease;
}

.events-page .fade-up.visible {
	opacity: 1;
	transform: none;
}

@media (max-width: 1024px) {
	.events-page .intro,
	.events-page .cinematic,
	.events-page .concierge-bridge,
	.events-page .cta-inner {
		grid-template-columns: 1fr;
		gap: 4rem;
	}

	.events-page .services-grid {
		grid-template-columns: 1fr 1fr;
	}
}

@media (max-width: 720px) {
	.events-page .hero {
		min-height: 620px;
		padding: 0 1.5rem 7rem;
	}

	.events-page section,
	.events-page .concierge-bridge,
	.events-page .cta-section {
		padding: 4.5rem 1.5rem;
	}

	.events-page .intro-image {
		height: 360px;
	}

	.events-page .services-grid,
	.events-page .process-grid,
	.events-page .concierge-pillars,
	.events-page .form-row {
		grid-template-columns: 1fr;
	}

	.events-page .cinematic-text {
		padding: 4.5rem 1.5rem;
	}

	.events-page .process-card {
		padding: 2rem;
		gap: 1.25rem;
	}
}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="events-page">
	<section class="hero">
		<video class="hero-bg" autoplay muted loop playsinline>
			<source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
		</video>
		<div class="hero-overlay"></div>
		<div class="hero-content">
			<span class="hero-eyebrow"><?php echo wp_kses_post( $hero_eyebrow ); ?></span>
			<h1 class="hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="hero-sub"><?php echo esc_html( $hero_text ); ?></p>
			<?php if ( $hero_button_label && $hero_button_url ) : ?>
				<div class="hero-cta">
					<a class="hero-btn" href="<?php echo esc_url( $hero_button_url ); ?>"><?php echo esc_html( $hero_button_label ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="intro">
		<div class="intro-text fade-up">
			<span class="section-label"><?php echo esc_html( $intro_label ); ?></span>
			<h2><?php echo wp_kses_post( $intro_title ); ?></h2>
			<?php foreach ( preg_split( "/\n\s*\n/", trim( (string) $intro_body ) ) as $paragraph ) : ?>
				<?php if ( trim( $paragraph ) ) : ?>
					<p><?php echo esc_html( trim( $paragraph ) ); ?></p>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<div class="intro-image fade-up">
			<img src="<?php echo esc_url( $intro_image ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $intro_label ) ); ?>">
		</div>
	</section>

	<hr class="divider">

	<section class="services">
		<div class="services-intro fade-up">
			<span class="section-label"><?php echo esc_html( $services_label ); ?></span>
			<h2><?php echo wp_kses_post( $services_title ); ?></h2>
			<p><?php echo esc_html( $services_text ); ?></p>
		</div>
		<div class="services-grid">
			<?php foreach ( (array) $service_cards as $card ) : ?>
				<div class="service-card fade-up">
					<div class="service-inner">
						<h3 class="service-title"><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
						<p class="service-desc"><?php echo esc_html( $card['text'] ?? '' ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<div class="cinematic">
		<div class="cinematic-image">
			<img src="<?php echo esc_url( $difference_image ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $difference_label ) ); ?>">
		</div>
		<div class="cinematic-text">
			<span class="section-label"><?php echo esc_html( $difference_label ); ?></span>
			<h2><?php echo wp_kses_post( $difference_title ); ?></h2>
			<?php foreach ( preg_split( "/\n\s*\n/", trim( (string) $difference_body ) ) as $paragraph ) : ?>
				<?php if ( trim( $paragraph ) ) : ?>
					<p><?php echo esc_html( trim( $paragraph ) ); ?></p>
				<?php endif; ?>
			<?php endforeach; ?>
			<ul class="cinematic-list">
				<?php foreach ( (array) $difference_points as $point ) : ?>
					<?php if ( ! empty( $point['text'] ) ) : ?>
						<li><?php echo esc_html( $point['text'] ); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<div class="concierge-bridge">
		<div class="fade-up">
			<span class="section-label"><?php echo esc_html( $concierge_label ); ?></span>
			<h2><?php echo wp_kses_post( $concierge_title ); ?></h2>
			<?php foreach ( preg_split( "/\n\s*\n/", trim( (string) $concierge_body ) ) as $paragraph ) : ?>
				<?php if ( trim( $paragraph ) ) : ?>
					<p><?php echo esc_html( trim( $paragraph ) ); ?></p>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if ( $concierge_button_label && $concierge_button_url ) : ?>
				<a class="cta-ghost" href="<?php echo esc_url( $concierge_button_url ); ?>"><?php echo esc_html( $concierge_button_label ); ?></a>
			<?php endif; ?>
		</div>
		<div class="concierge-pillars fade-up">
			<?php foreach ( (array) $concierge_pillars as $pillar ) : ?>
				<div class="concierge-pillar">
					<h4 class="pillar-title"><?php echo wp_kses_post( $pillar['title'] ?? '' ); ?></h4>
					<p class="pillar-text"><?php echo esc_html( $pillar['text'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<section class="cta-section" id="cta">
		<div class="cta-inner">
			<div class="cta-left">
				<span class="section-label"><?php echo esc_html( $cta_label ); ?></span>
				<h2><?php echo wp_kses_post( $cta_title ); ?></h2>
				<p><?php echo esc_html( $cta_text ); ?></p>
			</div>
			<form id="event__form" class="cta-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<div class="form-row">
					<div class="form-group">
						<label for="event__first_name">First Name</label>
						<input id="event__first_name" type="text" name="first_name" placeholder="First name" required>
					</div>
					<div class="form-group">
						<label for="event__last_name">Last Name</label>
						<input id="event__last_name" type="text" name="last_name" placeholder="Last name" required>
					</div>
				</div>
				<div class="form-group">
					<label for="event__email_address">Email Address</label>
					<input id="event__email_address" type="email" name="email_address" placeholder="Your email" required>
				</div>
				<div class="form-group">
					<label for="event__occasion"><?php echo esc_html( $cta_occasion_label ); ?></label>
					<input id="event__occasion" type="text" name="occasion" placeholder="<?php echo esc_attr( $cta_occasion_placeholder ); ?>">
				</div>
				<div class="form-group">
					<label for="event__message"><?php echo esc_html( $cta_message_label ); ?></label>
					<textarea id="event__message" name="message" rows="4" placeholder="<?php echo esc_attr( $cta_message_placeholder ); ?>" required></textarea>
				</div>
				<p id="event__form-message" class="form-message" aria-live="polite"></p>
				<button type="submit" id="event__submit-btn" class="form-submit"><?php echo esc_html( $cta_submit_label ); ?></button>
				<input type="hidden" name="action" value="event_contact_form">
				<?php wp_nonce_field( 'event_contact_nonce_action', 'event_contact_nonce' ); ?>
			</form>
		</div>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var reveals = document.querySelectorAll('.events-page .fade-up');

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries, io) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('visible');
					io.unobserve(entry.target);
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

	var form = document.getElementById('event__form');
	var message = document.getElementById('event__form-message');
	if (!form || !message) {
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

		var submitButton = document.getElementById('event__submit-btn');
		var originalButtonText = submitButton ? submitButton.textContent : '';
		if (submitButton) {
			submitButton.disabled = true;
			submitButton.textContent = 'Sending...';
			submitButton.setAttribute('aria-busy', 'true');
		}

		var formData = new FormData(form);
		var occasion = form.querySelector('[name="occasion"]');
		var messageField = form.querySelector('[name="message"]');
		var messageParts = [];

		if (occasion && occasion.value.trim()) {
			messageParts.push('The Occasion: ' + occasion.value.trim());
		}

		if (messageField && messageField.value.trim()) {
			messageParts.push('Tell Us More: ' + messageField.value.trim());
		}

		if (messageParts.length) {
			formData.set('message', messageParts.join("\n\n"));
		}

		var ajaxUrl = (window.myAjaxObject && window.myAjaxObject.ajaxurl) || form.getAttribute('action');

		fetch(ajaxUrl, {
			method: 'POST',
			body: formData,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			credentials: 'same-origin'
		})
			.then(function (response) {
				if (!response.ok) {
					throw new Error('Server error');
				}
				return response.json();
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
				if (submitButton) {
					submitButton.disabled = false;
					submitButton.textContent = originalButtonText || <?php echo wp_json_encode( $cta_submit_label ); ?>;
					submitButton.removeAttribute('aria-busy');
				}
			});
	});
});
</script>

<?php
get_footer();
