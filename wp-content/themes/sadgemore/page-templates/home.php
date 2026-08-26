<?php
/**
 * Template Name: Home
 * Template Post Type: page
 *
 * Homepage template updated to follow the static HTML design,
 * structure, spacing, typography, and layout.
 *
 * @package sadgemore
 */

get_header();

/**
 * Safely return an ACF image/video/file URL whether the field returns
 * a string, array, attachment ID, or WP_Post object.
 *
 * @param mixed  $value ACF field value.
 * @param string $size  Image size.
 * @return string
 */
function sedgemore_home_asset_url( $value, $size = 'full' ) {
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

/**
 * Return a URL from an ACF Link, Post Object, Page Link, or URL field.
 *
 * @param mixed  $value   ACF field value.
 * @param string $default URL used when no link has been selected.
 * @return string
 */
function sedgemore_home_link_url( $value, $default = '' ) {
	if ( empty( $value ) ) {
		return $default;
	}

	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return esc_url_raw( $value['url'] );
	}

	if ( $value instanceof WP_Post ) {
		$url = get_permalink( $value );
		return $url ? $url : $default;
	}

	if ( is_numeric( $value ) ) {
		$url = get_permalink( (int) $value );
		return $url ? $url : $default;
	}

	if ( is_string( $value ) ) {
		return esc_url_raw( $value );
	}

	return $default;
}

$banners        = function_exists( 'get_field' ) ? get_field( 'banners' ) : array();
$what_we_offer = function_exists( 'get_field' ) ? get_field( 'what_we_offer' ) : array();
$prive_list    = function_exists( 'get_field' ) ? get_field( 'prive_list' ) : array();
$prive_text    = function_exists( 'get_field' ) ? get_field( 'prive_text' ) : '';
$stories       = function_exists( 'get_field' ) ? get_field( 'stories_content' ) : array();

$hero_banner        = ( is_array( $banners ) && isset( $banners[0] ) && is_array( $banners[0] ) ) ? $banners[0] : array();
$hero_video_desktop = sedgemore_home_asset_url( $hero_banner['bg_video'] ?? '' );
$hero_video_mobile  = sedgemore_home_asset_url( $hero_banner['bg_video_mobile'] ?? '' );
$hero_image         = sedgemore_home_asset_url( $hero_banner['bg_image'] ?? '' );

$destination_link = home_url( '/travel/' );
$contact_link     = home_url( '/contact/' );
$membership_link  = home_url( '/membership/' );

/*
 * Privé background fallback.
 * If you want to change this from WP admin later, replace the fallback by adding
 * an ACF image field and assign it here.
 */
$prive_bg_image = 'https://b7b3de2e23a730adab54ac5f86fdd07c-18756.sites.k-hosting.co.uk/wp-content/uploads/2026/05/download.jpeg';

$how_steps = array(
	array(
		'title' => 'We listen',
		'text'  => 'A brief conversation about how you like to travel, what matters, and what you have in mind. No forms, no questionnaires.',
	),
	array(
		'title' => 'We design',
		'text'  => 'A bespoke proposal built around your preferences, with properties and experiences selected for your specific journey.',
	),
	array(
		'title' => 'We arrange',
		'text'  => 'Every reservation, transfer, and detail is confirmed and held in place. You receive a clear, complete itinerary.',
	),
	array(
		'title' => 'We travel with you',
		'text'  => 'Your advisor remains reachable throughout. Adjustments happen quietly, in the background, without disruption.',
	),
);

$offer_descriptions = array(
	'Journeys shaped around your interests, pace, and purpose. Each itinerary is curated to feel personal, seamless, and considered.',
	'From intimate celebrations to grand affairs. Every detail is refined, every atmosphere intentional.',
	'Restaurant bookings, transfers, access. Our team manages the details of daily life so you do not have to.',
);

$offer_labels = array(
	'View journeys',
	'Discover experiences',
	'See how we assist',
);

$destination_fallbacks = array(
	array( 'title' => 'Venice', 'region' => 'Italy' ),
	array( 'title' => 'Lake Como', 'region' => 'Italy' ),
	array( 'title' => 'Morocco', 'region' => 'North Africa' ),
	array( 'title' => 'Vietnam', 'region' => 'Southeast Asia' ),
	array( 'title' => 'Mediterranean', 'region' => 'Sardinia' ),
);
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ================================
	Sedgemore Home
   Static HTML design mapped to WP
================================ */
.home-review,
.home-review * ,
.home-review *::before,
.home-review *::after {
	box-sizing: border-box;
}

.home-review {
	--ivory: #f5f2ee;
	--warm-white: #faf8f5;
	--dark: #1c1a18;
	--charcoal: #2e2c29;
	--mid: #6b6560;
	--gold: #b8955a;
	--gold-light: #d4b483;
	--border: rgba(28, 26, 24, 0.12);
	--border-light: rgba(28, 26, 24, 0.07);
	--ff-display: 'Cormorant Garamond', Georgia, serif;
	--ff-body: 'Montserrat', Arial, sans-serif;

	background: var(--warm-white);
	color: var(--dark);
	font-family: var(--ff-body);
	font-weight: 300;
	-webkit-font-smoothing: antialiased;
	overflow-x: hidden;
}

.home-review a {
	color: inherit;
}

.home-review img,
.home-review video {
	max-width: 100%;
}

.home-review h1,
.home-review h2,
.home-review h3,
.home-review p {
	margin-top: 0;
}

.home-review h1,
.home-review h2,
.home-review h3 {
	font-family: var(--ff-display);
	font-weight: 300;
	line-height: 1.08;
	letter-spacing: -0.01em;
}

.home-review em {
	font-style: italic;
}

.home-review .section-inner {
	max-width: 1280px;
	margin: 0 auto;
}

.home-review .section-label {
font-family: var(--ff-body);
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 20px;
    align-items: center;
    gap: 0;
}

.home-review .reveal {
	opacity: 0;
	transform: translateY(28px);
	transition: opacity 0.9s ease, transform 0.9s ease;
}

.home-review .reveal.revealed {
	opacity: 1;
	transform: translateY(0);
}

.home-review .reveal-delay-1 {
	transition-delay: 0.12s;
}

.home-review .reveal-delay-2 {
	transition-delay: 0.24s;
}

.home-review .reveal-delay-3 {
	transition-delay: 0.36s;
}

/* Buttons */
.home-review .btn-primary,
.home-review .btn-ghost,
.home-review .btn-gold,
.home-review .form-submit {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-height: 48px;
	padding: 16px 36px;
	font-family: var(--ff-body);
	font-size: 11px;
	font-weight: 400;
	letter-spacing: 0.18em;
	line-height: 1;
	text-decoration: none;
	text-transform: uppercase;
	cursor: pointer;
	transition: all 0.3s ease;
}

.home-review .btn-primary,
.home-review .form-submit {
	background: var(--gold);
	border: 1px solid var(--gold);
	color: #fff;
}

.home-review .btn-primary:hover,
.home-review .form-submit:hover {
	background: #a07d48;
	border-color: #a07d48;
	color: #fff;
}

/* When the form is submitting, keep the button look stable and disable hover */
.home-review .form-submit[disabled],
.home-review .form-submit[aria-busy="true"] {
	cursor: default;
	opacity: 0.95;
	pointer-events: none;
}

.home-review .form-submit[disabled]:hover,
.home-review .form-submit[aria-busy="true"]:hover {
	background: var(--gold);
	border-color: var(--gold);
	color: #fff;
}

.home-review .btn-ghost {
	background: transparent;
	border: 1px solid rgba(255, 255, 255, 0.42);
	color: rgba(255, 255, 255, 0.88);
}

.home-review .btn-ghost:hover {
	background: rgba(255, 255, 255, 0.1);
	border-color: rgba(255, 255, 255, 0.7);
	color: #fff;
}

.home-review .btn-gold {
	background: transparent;
	border: 1px solid var(--gold);
	color: var(--gold-light);
}

.home-review .btn-gold:hover {
	background: var(--gold);
	color: #fff;
}

/* Hero */
.home-review .hero {
	--home-header-offset: clamp(84px, 9vw, 122px);
	position: relative;
	display: flex;
	align-items: flex-end;
	min-height: 100vh;
	padding: var(--home-header-offset) 0 96px;
	overflow: hidden;
	color: #fff;
	background: #1c1a18;
}

.home-review .hero-bg-wrap,
.home-review .hero-overlay {
	position: absolute;
	inset: 0;
}

.home-review .hero-bg-wrap {
	z-index: 0;
	background-size: cover;
	background-position: center 40%;
	animation: homeReviewHeroZoom 1.4s ease both;
}

@keyframes homeReviewHeroZoom {
	from { transform: scale(1.04); }
	to { transform: scale(1); }
}

.home-review .hero-bg-video {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
}

.home-review .hero-overlay {
	z-index: 1;
	background: linear-gradient(
		to bottom,
		rgba(20, 18, 14, 0.25) 0%,
		rgba(20, 18, 14, 0.1) 40%,
		rgba(20, 18, 14, 0.6) 100%
	);
}

.home-review .hero-content {
	position: relative;
	z-index: 2;
	max-width: 800px;
	padding: 0 64px;
	color: #fff;
}

.home-review .hero h1 {
	margin-bottom: 28px;
	color: #fff;
	font-size: clamp(52px, 7vw, 88px);
	font-weight: 300;
}

.home-review .hero-sub {
	max-width: 480px;
	margin-bottom: 44px;
	color: rgba(255, 255, 255, 0.78);
	font-family: var(--ff-body);
	font-size: 15px;
	font-weight: 300;
	letter-spacing: 0.02em;
	line-height: 1.7;
}

.home-review .hero-actions {
	display: flex;
	align-items: center;
	gap: 20px;
	flex-wrap: wrap;
}

@keyframes homeReviewScrollLine {
	from { top: -100%; }
	to { top: 100%; }
}

/* Header nav inserted after hero */
.home-review .home-review-nav {
	background: var(--warm-white);
	border-bottom: 1px solid var(--border-light);
}

/* Offer */
.home-review .offer {
	padding: 112px 64px;
	background: var(--warm-white);
}

.home-review .offer-header {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 80px;
	align-items: end;
	margin-bottom: 72px;
}

.home-review .offer-header h2 {
	margin: 0;
	color: var(--dark);
	font-size: clamp(38px, 4vw, 56px);
	font-weight: 300;
	line-height: 1.12;
}

.home-review .offer-header p {
	align-self: end;
	margin: 0;
	padding-bottom: 6px;
	color: #4a4743;
	font-size: 15px;
	font-weight: 300;
	letter-spacing: 0.02em;
	line-height: 1.75;
}

.home-review .offer-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 2px;
}

.home-review .offer-card {
	position: relative;
	display: block;
	overflow: hidden;
	aspect-ratio: 3 / 4;
	cursor: pointer;
	background: #d9d2c8;
	color: #fff;
	text-decoration: none;
}

.home-review .offer-card img,
.home-review .offer-card video {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
	transition: transform 0.7s ease;
}

.home-review .offer-card:hover img,
.home-review .offer-card:hover video {
	transform: scale(1.05);
}

.home-review .offer-card-overlay {
	position: absolute;
	inset: 0;
	display: flex;
	flex-direction: column;
	justify-content: flex-end;
	padding: 36px 32px;
	background: linear-gradient(to top, rgba(10, 8, 5, 0.92) 0%, rgba(10, 8, 5, 0.55) 45%, rgba(10, 8, 5, 0.1) 100%);
}

.home-review .offer-card h3 {
	margin: 0 0 10px;
	color: #fff;
	font-size: 26px;
	font-weight: 400;
	letter-spacing: 0.02em;
	line-height: 1.2;
	text-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
}

.home-review .offer-card p {
	max-width: 260px;
	margin: 0 0 20px;
	color: rgba(255, 255, 255, 0.92);
	font-family: var(--ff-body);
	font-size: 13px;
	font-weight: 400;
	line-height: 1.65;
	text-shadow: 0 1px 8px rgba(0, 0, 0, 0.4);
}

.home-review .offer-card-link {
	display: flex;
	align-items: center;
	gap: 10px;
	color: var(--gold-light);
	font-family: var(--ff-body);
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.2em;
	text-decoration: none;
	text-transform: uppercase;
	transition: gap 0.3s ease;
}

.home-review .offer-card:hover .offer-card-link {
	gap: 16px;
}

.home-review .offer-card-link::after {
	content: '→';
	font-size: 14px;
}

/* How */
.home-review .how {
	padding: 112px 64px;
	background: var(--warm-white);
}

.home-review .how-header {
	max-width: 600px;
	margin: 0 auto 80px;
	text-align: center;
}

.home-review .how-header h2 {
	margin: 0 0 16px;
	color: var(--dark);
	font-size: clamp(36px, 3.5vw, 52px);
	font-weight: 300;
	line-height: 1.15;
}

.home-review .how-header p {
	margin: 0;
	color: var(--mid);
	font-size: 15px;
	font-weight: 300;
	line-height: 1.75;
}

.home-review .how-steps {
	position: relative;
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 48px;
	align-items: start;
}

.home-review .how-steps::before {
	content: '';
	position: absolute;
	top: 21px;
	left: 22px;
	right: 22px;
	z-index: 0;
	height: 1px;
	background: var(--border);
}

.home-review .step-num {
	position: relative;
	z-index: 2;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 44px;
	height: 44px;
	margin-bottom: 28px;
	background: var(--warm-white);
	border: 1px solid var(--border);
	border-radius: 50%;
	color: var(--gold);
	font-family: var(--ff-display);
	font-size: 16px;
	font-weight: 400;
}

.home-review .how-step h3 {
	margin: 0 0 12px;
	color: var(--dark);
	font-size: 20px;
	font-weight: 400;
}

.home-review .how-step p {
	margin: 0;
	color: var(--mid);
	font-size: 13px;
	font-weight: 300;
	letter-spacing: 0.02em;
	line-height: 1.75;
}

/* Trusted Brands */
.home-review .partners {
	background: var(--ivory);
	padding: 52px 9vw;
}

.home-review .partners .section-label {
	display: block;
	margin-bottom: 30px;
	color: var(--mid);
	font-size: 11px;
	font-weight: 500;
	letter-spacing: 0.35em;
	text-align: center;
}

.home-review .partner-row {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 32px 40px;
	flex-wrap: wrap;
}

.home-review .partner-logo {
	display: block;
	width: auto;
	max-width: 220px;
	object-fit: contain;
	opacity: 0.55;
	filter: grayscale(100%);
	transition: opacity 0.3s;
}

.home-review .partner-logo:hover {
	opacity: 0.85;
}

.home-review .partner-logo[alt="Serandipians"] {
	height: 54px;
	max-width: min(450px, 80vw);
}

/* Privé */
.home-review .prive {
	position: relative;
	display: flex;
	align-items: center;
	min-height: 600px;
	overflow: hidden;
	background: #1c1a18;
}

.home-review .prive-bg,
.home-review .prive-overlay {
	position: absolute;
	inset: 0;
}

.home-review .prive-bg {
	background-size: cover;
	background-position: center;
}

.home-review .prive-overlay {
	background: linear-gradient(
		to right,
		rgba(20, 18, 14, 0.88) 0%,
		rgba(20, 18, 14, 0.6) 55%,
		rgba(20, 18, 14, 0.15) 100%
	);
}

.home-review .prive-content {
	position: relative;
	z-index: 2;
	max-width: 620px;
	padding: 96px 64px;
}

.home-review .prive-content .section-label {
	color: var(--gold-light);
}

.home-review .prive-content h2 {
	margin: 0 0 20px;
	color: #fff;
	font-size: clamp(36px, 4vw, 56px);
	font-weight: 300;
	line-height: 1.1;
}

.home-review .prive-tagline {
	font-size: 15px;
    font-weight: 300;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.8;
    margin-bottom: 36px;
    letter-spacing: 0.02em;
}
.home-review .prive-content p {
	font-size: 15px;
    font-weight: 300;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.8;
    margin-bottom: 36px;
    letter-spacing: 0.02em;
}
.home-review .prive-content p:not(.section-label):not(.prive-tagline) {
	margin: 0 0 36px;
	color: rgba(255, 255, 255, 0.7);
	font-size: 15px;
	font-weight: 300;
	letter-spacing: 0.02em;
	line-height: 1.8;
}

.home-review .prive-benefits {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 12px 32px;
	margin: 0 0 44px;
	padding: 0;
	list-style: none;
}

.home-review .prive-benefits li {
	display: flex;
	align-items: center;
	gap: 10px;
	color: rgba(255, 255, 255, 0.65);
	font-family: var(--ff-body);
	font-size: 12px;
	font-weight: 300;
	letter-spacing: 0.08em;
	text-transform: uppercase;
}

.home-review .prive-benefits li::before {
	content: '✓';
	flex-shrink: 0;
	color: var(--gold);
	font-size: 13px;
	font-weight: 400;
	line-height: 1;
}

/* Testimonial */
.home-review .testimonial {
	padding: 96px 64px;
	background: var(--ivory);
	text-align: center;
}

.home-review .testimonial-inner {
	max-width: 760px;
	margin: 0 auto;
}

.home-review .testimonial blockquote {
	position: relative;
	margin: 0 0 32px;
	color: var(--dark);
	font-family: var(--ff-display);
	font-size: clamp(22px, 3vw, 32px);
	font-style: italic;
	font-weight: 300;
	line-height: 1.5;
}

.home-review .testimonial blockquote::before {
	content: '\201C';
	position: absolute;
	top: -40px;
	left: 50%;
	transform: translateX(-50%);
	color: var(--gold-light);
	font-family: var(--ff-display);
	font-size: 120px;
	line-height: 1;
	opacity: 0.3;
	pointer-events: none;
}

.home-review .testimonial-attr {
	margin: 0;
	color: var(--mid);
	font-family: var(--ff-body);
	font-size: 12px;
	font-weight: 400;
	letter-spacing: 0.18em;
	text-transform: uppercase;
}

.home-review .testimonial-attr strong {
	color: var(--dark);
	font-weight: 400;
}

/* Destinations */
.home-review .destinations {
	padding: 96px 64px;
	background: var(--ivory);
}

.home-review .destinations-header {
	display: flex;
	align-items: flex-end;
	justify-content: space-between;
	margin-bottom: 56px;
	gap: 32px;
}

.home-review .destinations-header h2 {
	margin: 0;
	color: var(--dark);
	font-size: clamp(36px, 3.5vw, 52px);
	font-weight: 300;
	line-height: 1.1;
}

.home-review .destinations-header a {
	display: flex;
	align-items: center;
	gap: 10px;
	color: var(--gold);
	font-family: var(--ff-body);
	font-size: 11px;
	font-weight: 400;
	letter-spacing: 0.18em;
	text-decoration: none;
	text-transform: uppercase;
	transition: gap 0.3s ease;
}

.home-review .destinations-header a:hover {
	gap: 16px;
}

.home-review .destinations-header a::after {
	content: '→';
}

.home-review .dest-grid {
	display: grid;
	grid-template-columns: 2fr 1fr 1fr;
	grid-template-rows: 1fr 1fr;
	gap: 2px;
	height: 600px;
}

.home-review .dest-card {
	position: relative;
	display: block;
	overflow: hidden;
	background: #d9d2c8;
	color: #fff;
	text-decoration: none;
	cursor: pointer;
}

.home-review .dest-card.tall {
	grid-row: 1 / 3;
}

.home-review .dest-card img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
	transition: transform 0.7s ease;
}

.home-review .dest-card:hover img {
	transform: scale(1.06);
}

.home-review .dest-card-info {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 0;
	padding: 28px 24px;
	background: linear-gradient(to top, rgba(20, 18, 14, 0.75) 0%, transparent 100%);
	transform: translateY(8px);
	transition: transform 0.4s ease;
}

.home-review .dest-card:hover .dest-card-info {
	transform: translateY(0);
}

.home-review .dest-card-info h3 {
	margin: 0 0 4px;
	color: #fff;
	font-size: 22px;
	font-weight: 400;
}

.home-review .dest-card-info span {
	color: rgba(255, 255, 255, 0.6);
	font-family: var(--ff-body);
	font-size: 11px;
	font-weight: 300;
	letter-spacing: 0.12em;
	text-transform: uppercase;
}

/* Enquire CTA */
.home-review .enquire-cta {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 80px;
	align-items: center;
	padding: 96px 64px;
	background: var(--warm-white);
}

.home-review .enquire-text h2 {
	margin: 0 0 20px;
	color: var(--dark);
	font-size: clamp(36px, 3.5vw, 52px);
	font-weight: 300;
	line-height: 1.12;
}

.home-review .enquire-text p {
	margin: 0 0 36px;
	color: var(--mid);
	font-size: 15px;
	font-weight: 300;
	letter-spacing: 0.02em;
	line-height: 1.8;
}

.home-review .enquire-form {
	display: block;
}

.home-review .form-2col {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 20px;
}

.home-review .form-group {
	margin-bottom: 16px;
}

.home-review .form-group label {
	display: block;
	margin-bottom: 8px;
	color: var(--mid);
	font-family: var(--ff-body);
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.2em;
	text-transform: uppercase;
}

.home-review .form-group input,
.home-review .form-group select,
.home-review .form-group textarea {
	width: 100%;
	padding: 12px 0;
	background: transparent;
	border: none;
	border-bottom: 1px solid var(--border);
	border-radius: 0;
	box-shadow: none;
	color: var(--dark);
	font-family: var(--ff-body);
	font-size: 14px;
	font-weight: 300;
	letter-spacing: 0.02em;
	outline: none;
	appearance: none;
	transition: border-color 0.3s ease;
}

.home-review .form-group input:focus,
.home-review .form-group select:focus,
.home-review .form-group textarea:focus {
	border-color: var(--gold);
}

.home-review .form-group input::placeholder,
.home-review .form-group textarea::placeholder {
	color: rgba(28, 26, 24, 0.35);
}

.home-review .form-group textarea {
	min-height: 120px;
	line-height: 1.6;
	resize: vertical;
}

.home-review .interest-grid {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 10px 18px;
	padding: 12px 0 4px;
	border-top: 1px solid var(--border-light);
	border-bottom: 1px solid var(--border-light);
}

.home-review .interest-option {
	display: flex;
	align-items: center;
	gap: 10px;
	font-size: 14px;
	font-weight: 300;
	letter-spacing: 0.01em;
	color: var(--charcoal);
	cursor: pointer;
}

.home-review #home-enquiry-form .interest-option input[type="checkbox"] {
	appearance: auto;
	accent-color: #2E2E2E;
	width: 16px;
	height: 16px;
	margin: 0;
	padding: 0;
	border: 1px solid var(--border);
}

.home-review .form-message {
	min-height: 20px;
	margin-top: 16px;
	font-family: var(--ff-body);
	font-size: 13px;
	font-weight: 400;
	line-height: 1.5;
	letter-spacing: 0.02em;
	color: var(--mid);
}

.home-review .form-message.success {
	color: #2f6b3d;
}

.home-review .form-message.error {
	color: #9a4b43;
}

.home-review .form-submit {
	width: 100%;
    background: var(--dark);
    border: none;
    color: #fff;
    padding: 18px;
    font-family: var(--ff-body);
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    cursor: pointer;
    margin-top: 24px;
    transition: background 0.3s;
}

/* Responsive */
@media (max-width: 1199px) {
	.home-review .offer,
	.home-review .how,
	.home-review .destinations,
	.home-review .enquire-cta {
		padding-left: 38px;
		padding-right: 38px;
	}

	.home-review .offer-header,
	.home-review .enquire-cta {
		gap: 48px;
	}

	.home-review .dest-grid {
		grid-template-columns: 1fr 1fr;
		height: auto;
		grid-auto-rows: 280px;
	}

	.home-review .dest-card.tall {
		grid-row: span 2;
	}

	.home-review .how-steps {
		gap: 28px;
	}
}

@media (max-width: 900px) {
	.home-review .offer-header,
	.home-review .enquire-cta {
		grid-template-columns: 1fr;
	}

	.home-review .offer-grid {
		grid-template-columns: 1fr;
	}

	.home-review .offer-card {
		aspect-ratio: 16 / 11;
	}

	.home-review .how-steps {
		grid-template-columns: 1fr 1fr;
	}

	.home-review .how-steps::before {
		display: none;
	}
}

@media (max-width: 767px) {
	.home-review .hero {
		--home-header-offset: 96px;
		min-height: 88vh;
		padding-bottom: 64px;
	}

	.home-review .hero-content {
		padding: 0 24px;
	}

	.home-review .hero h1 {
		font-size: clamp(42px, 13vw, 60px);
	}

	.home-review .hero-actions {
		gap: 12px;
	}

	.home-review .btn-primary,
	.home-review .btn-ghost,
	.home-review .btn-gold,
	.home-review .form-submit {
		width: 100%;
		padding-left: 20px;
		padding-right: 20px;
	}

	.home-review .offer,
	.home-review .how,
	.home-review .destinations,
	.home-review .enquire-cta,
	.home-review .testimonial {
		padding: 72px 20px;
	}

	.home-review .offer-header,
	.home-review .how-header,
	.home-review .destinations-header {
		margin-bottom: 42px;
	}

	.home-review .offer-card {
		aspect-ratio: 3 / 4;
	}

	.home-review .offer-card-overlay {
		padding: 30px 24px;
	}

	.home-review .how-header {
		text-align: center;
		max-width: 640px;
		margin-left: auto;
		margin-right: auto;
	}

	.home-review .how-header .section-label {
		justify-content: center;
		text-align: center;
	}

	.home-review .how-header p {
		max-width: 34ch;
		margin-left: auto;
		margin-right: auto;
	}

	.home-review .how-steps {
		display: flex;
		flex-direction: column;
		gap: 0;
		position: relative;
		padding-left: 60px;
	}

	.home-review .how-steps::before {
		display: none;
		right: auto;
		height: auto;
		background: rgba(28, 26, 24, 0.12);
		
		content: '';
        position: absolute;
        left: 22px;
        top: 44px;
        bottom: -24px;
        width: 1px;
        z-index: 0;
	}

	.home-review .how-step {
		position: relative;
		min-height: 132px;
		padding: 0 0 36px;
	}

	.home-review .how-step::before {
		content: '';
		position: absolute;
		left: -42px;
		top: 40px;
		bottom: 0;
		width: 1px;
		background: rgba(28, 26, 24, 0.12);
		z-index: 0;
	}

	.home-review .how-step:last-child {
		min-height: 0;
		padding-bottom: 0;
	}

	.home-review .how-step:last-child::before {
		display: none;
	}

	.home-review .step-num {
		position: absolute;
		top: 0;
		left: -60px;
		margin: 0;
		background: var(--warm-white);
		border-color: rgba(28, 26, 24, 0.12);
		color: var(--gold);
		width: 40px;
        height: 40px;
        font-size: 0.875rem;
	}

	.home-review .how-step h3 {
		margin: 0 0 14px;
		font-size: 20px;
		line-height: 1.2;
	}

	.home-review .how-step p {
		font-size: 14px;
		line-height: 1.7;
		letter-spacing: 0.02em;
	}

	.home-review .prive {
		min-height: 620px;
	}

	.home-review .prive-content {
		max-width: 100%;
		padding: 72px 20px;
	}

	.home-review .prive-benefits {
		grid-template-columns: 1fr;
	}

	.home-review .destinations-header {
		flex-direction: column;
		align-items: flex-start;
	}

	.home-review .dest-grid {
		grid-template-columns: 1fr;
		grid-auto-rows: 230px;
		height: auto;
	}

	.home-review .dest-card.tall {
		grid-row: span 1;
	}

	.home-review .form-2col {
		grid-template-columns: 1fr;
		gap: 0;
	}

	.home-review .interest-grid {
		grid-template-columns: 1fr;
	}
}
</style>

<div class="home-review">
	<section class="hero">
		<div class="hero-bg-wrap"<?php if ( ! $hero_video_desktop && $hero_image ) : ?> style="background-image: url('<?php echo esc_url( $hero_image ); ?>');"<?php endif; ?>>
			<?php if ( $hero_video_desktop ) : ?>
				<video id="homeReviewHeroVideo" class="hero-bg-video" autoplay muted loop playsinline<?php echo $hero_image ? ' poster="' . esc_url( $hero_image ) . '"' : ''; ?>>
					<source src="<?php echo esc_url( $hero_video_desktop ); ?>" type="video/mp4">
				</video>
			<?php endif; ?>
		</div>
		<div class="hero-overlay"></div>
		<div class="hero-content reveal">
			<h1>Tailored journeys,<br><em>thoughtfully</em> delivered.</h1>
			<p class="hero-sub">From private itineraries to extraordinary events, Sedgemore curates experiences shaped around the way you travel. We begin with listening.</p>
			<div class="hero-actions">
				<a href="#enquire" class="btn-primary">Begin your journey</a>
				<a href="#how" class="btn-ghost">How we work</a>
			</div>
		</div>
	</section>

	<div class="home-review-nav header_nav nav-menu">
		<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
		<div class="clear"></div>
	</div>

	<section class="offer">
		<div class="section-inner">
			<div class="offer-header reveal">
				<h2>Every detail,<br><em>considered.</em></h2>
				<p>Travel and events shaped around your needs. We design and manage tailored experiences for private individuals, families, and global teams, from intimate escapes to grand celebrations.</p>
			</div>

			<?php if ( is_array( $what_we_offer ) && ! empty( $what_we_offer ) ) : ?>
				<div class="offer-grid">
					<?php
					foreach ( array_values( $what_we_offer ) as $index => $offer ) :
						if ( $index > 2 ) {
							break;
						}

						$link_url    = ! empty( $offer['link'] ) ? $offer['link'] : '#';
						$video       = sedgemore_home_asset_url( $offer['video'] ?? '' );
						$poster      = sedgemore_home_asset_url( $offer['poster'] ?? '' );
						$title       = ! empty( $offer['text'] ) ? wp_strip_all_tags( $offer['text'] ) : 'Bespoke Service';
						$description = $offer_descriptions[ $index ] ?? 'Considered travel support shaped around your plans, preferences, and pace.';
						$label       = $offer_labels[ $index ] ?? 'Learn more';
						?>
						<a class="offer-card reveal<?php echo $index ? ' reveal-delay-' . esc_attr( $index ) : ''; ?>" href="<?php echo esc_url( $link_url ); ?>">
							<?php if ( $video ) : ?>
								<video muted loop playsinline<?php echo $poster ? ' poster="' . esc_url( $poster ) . '"' : ''; ?>>
									<source src="<?php echo esc_url( $video ); ?>" type="video/mp4">
								</video>
							<?php elseif ( $poster ) : ?>
								<img src="<?php echo esc_url( $poster ); ?>" alt="<?php echo esc_attr( $title ); ?>">
							<?php endif; ?>
							<div class="offer-card-overlay">
								<h3><?php echo esc_html( $title ); ?></h3>
								<p><?php echo esc_html( $description ); ?></p>
								<span class="offer-card-link"><?php echo esc_html( $label ); ?></span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section id="how" class="how">
		<div class="section-inner">
			<div class="how-header reveal">
				<p class="section-label">How we work</p>
				<h2>Every journey begins<br><em>with listening.</em></h2>
				<p>Sedgemore is a boutique agency with global reach. We collaborate closely with each client to create journeys that are seamless, meaningful, and entirely individual.</p>
			</div>

			<div class="how-steps">
				<?php foreach ( $how_steps as $index => $step ) : ?>
					<div class="how-step reveal<?php echo $index ? ' reveal-delay-' . esc_attr( $index ) : ''; ?>">
						<div class="step-num"><?php echo esc_html( (string) ( $index + 1 ) ); ?></div>
						<div class="step-content">
							<h3><?php echo esc_html( $step['title'] ); ?></h3>
							<p><?php echo esc_html( $step['text'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =============================================
	     TRUSTED PARTNERS STRIP
	     ============================================= -->
	<section class="partners">
	  <span class="section-label">TRUSTED BRANDS</span>
	  <div class="partner-row">
	    <img src="data:image/png;base64,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" alt="Four Seasons" class="partner-logo">
	    <img src="data:image/png;base64,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" alt="Belmond" class="partner-logo">
	    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAA7jElEQVR42u29d1wUV/c/fu7M7C67S2/SpYgFsGMvoLF3iYuxJvaOMZjEvqxEo1GDJcZoND7RWMIauzF2UGMMiCUqdkTa0hFYYMvMnN8f7JgNDxrzPMnzye+beb9e6svdmZ1b3vecc0+5AyBChAgRIkSIECFChAgRIkSIECFChAgRIkSIECFChAgRIkSIECFChAgRIkSIECFChAgRIkSIECFChAgRIkSIECFChAgRIkSIECFChAgRf0sQcQj+aTNOaudcrVYziYmJ9Ovco1KpfnMdIorE+ScgMTFRGhER4YiINgJx6pKhHmIQAACGYQAA7H18fOSISP9TScP8EzqJiIQQgnK53C00NHTZjBkz3MeMGZO2atWqLT4+PiUAQAEAX480QoZhYPr06QOrq6vH1NTUKAICAg4yDLNryZIlFACguAz/3yYOvWfPHtfly5e3VqlU3/Xu3fuXzZs3t6AoCrZu3SqxJphKpaIRUTp06NDP+/btm/vee++9c/z4cQ+dTqcUbZl/IBQKBURGRp574403csrLyxsDAKVWqymLfUNJpVIYO3b0x507d8J169b1E0fsnytliFqtlgIAJCQkRDZt2hSHDh26QyKRglqtfkGaL7/cEtmsWRPzgAF99ysUCoiIiGAs34nS5Z9IGgAgOp3OPTy87dOQkKaGPXv2tLd8TSEi6dev76GgoACcNWvGVACAiIgIRhy5WmPvH8sbDw8PvbOzk668vFx26tQPb9I0DQDAHzz4bYucnOzehBBTYGCjRwAAkZGRvEiXfyhhCCEIAJREIqlmWfYOz/P49GlGF5ZlbQEAzpxJ6lVVVa2Uy22q/f29i0SaiBIGAICwLAtSqfQ5RVFEr9eHbdy4sQkAQG5ubpvKygrw8vJyCA1t1QEAIDQ0VLRd/smEUalUAAAglUqRYRgwGAwOqampbohI9PpKP6PRCA4OjsTR0d5RpIlImBeQy+VAURQYjUaUSqVuAKBkWTYYEYGmaVAq7ViRJiJhXoCmaUIIAZ7nSYsWoYMBwNVorOEBACiKAEWJYyQSpn5DGHgezVAbIiAAABzHAwBlFEdHJMwLmM1mREQghODt23ePA0CpRGKDDMNAcXFJBaLpKgDA3bt3xbiRSBgAs9kMHMeBXC4nHMeVAECVVCp9QNM0GAw1hmfP8ipFmoiEAa1WCwAA1dXVhOM4kEplJd26dcunKBpdXV2zaZpBk8nEFBXl2Yg0EQkDAMAjIuF53p3nObS3t78zefLkR4g8eHp6XrW1VZKqqioqP18nqqJ/OmEssSQEAIVMZhNKURRp0qTxFZqmawAA+vbte1apVJQZDAbbnJw8bwCA9PR00XH3TyVMXFwcAQDy8GG2o06n83B2dqmOihr6Lc/zoFKp6OHDhz/09w/8HhGZzMysYAAgggoTCfMP3EE7OztLAACPHNnf3Gg0+jRrFrp90KDht4TxMJlMMH785PVKpV3N3bv3ekmlUlSpVPSFCxcYENMb/plARJsuXbpc7dGjRwoiOlvnwqjVaoqiKJg8efK77du3x9jY2MHiiFlW2z+ps2q1mjGbzW56vb5tdnb2fKPRBDExk8f16zc8GxFpQggnjItKpaISExP58ePHL3n+/PkkV1fXL7y9vQ8VFhbmb926tZIQ8o9Md6D+IdKEAACEh4c3KCsrW6DX60d6eXntP3HieL9+/YZnq9VqyoosAAB44MABjhCC33zzTXz79u3HEkI8S0pK1IGBgcMAAAVpJOL/beLIDh8+bGdJlBKkDvW6iwoR5Ygosy4/EfH/uKSxLmR73doiS8GbNXHIP7UuibxqcKOjo1+5+kJCQhAAQKPRIPz/qEanvr5ptVr+NfpAQKxFEu0hcXPy3zWEAABu27atVWZmZiuWZQlN0zVKpY2ZZTnGbDYpEJFwtSZiSXZ29rOePXs+mTJlSiXP8yQuLo4sX76cR8S/68Dj2rVrfSsrK98wGo1muVxuUCgUpEmTJklDhgwp/htKkb9Ve14qFViWDa6urhlKCOl99+7tlV9//fWB48eP76+srHzTaDR1MhprIp4/fz68srIy5ty5c4nR0dFzAUCm0Wj4ZcuW/S1LMgQSsyxrzzCMX0VFxaDExMQDBw4kalNTfwq12DZ/m9WsVgNV22y0ed2DA/4WBO/Xr9cnLi5OfEhI0/zExMSAuvbA5MmTW0VGRl7p2bPnpZSUlMDX3H38n2PkyJHdfHy8uZCQpvyePXtmW03S3wZXrlxxXrNmzYrExETbv5t6qsNuNRUREcEgItWvX5/1np4NsEWL0PyEhM3Nar2iEYKbnAAA/PLLLw1at25V1K1b15slJSW+1t/93RAREcGoVCparV4+oGFDP7Z165Z4/PjxtX8jW4wAAIwbNy48IqLbxd69e15HRPrvQJiXDo5Go+GTk5N5mqZ5QggiIiAC0DSHGo2GB4gUdhU4depUScuWLQuaNGm6PDs7u2VMzKx1f1MbBgAA3N3dUavVchSFCAAEEYHjOPPfTbI/eHBv2pMnT7oZDKaqv8vi+1NsjV69evHbtm0jzZs3v5Ca+rM+NfXasI8+iusGABdVKhWt1Wq5l21rQ0JCLAT8962vJar8AnFxcQILSXR0NPm9e4WUhJdd95vpERw0tWEB+vfuE44QsX5WSEgIAQBeo9HwwvfCtZZn4O/1Xfg+JCQEjx49bEZEXiaTUmB1WIDFjfGbdgAAUavVJDQ0lNy9exfrc3UgItFqtZRKpcK4uLgXgkHQBiqVirzOWL1SAlEUBf37903w8HDH5s1D8zdu3Ni0ro0iDMipU9+5d+rU4YGnZwMcOnTwDsshPFRddVDP4NMW9/xvfq+e66i6tpFaraasHWmIQCxR5fqcbwDw6yFCGo2mf8OGflyrVi3w6NGjq15SbE+9jDDXrl2TqNXq+hYdhYhUnTZSL/ktYn2tdd979+610dvbE7t06ZBMUaTeNliur7eN1uPwsjEVxpNhGKAoCgghYN2ev0TCCBM9dOiYwnbt2t7nOLaxTqfrdOfOM9emTb2LrVYBlZyczK5Zs8Zdp9P1pmna1Ww2XweAKwKrhWvPnDnjcuvWrWYmk8nYqFFIla9vAzMAZMbHx5vHjRvXWCaTdba1tU2Nj4+/GxoaSkdHR3OWpiDD9GZnzZrVRqFQtGdZ1szz/OWRI0c+sF71dcHzLGg0Gv7QoUOOSUlJvauqqrw9PPzOffyx5jbHcfX2u23btmyHDh1w1apVoQUFBZ0NBgNrMpkuffXVV4+jo6Npa/VumVS+uLjYfu7cud2kUql7cXHxpRMnTjwWJA8ASACA2759ewuKouT79u314jgWGEbqsGPHV10KCgpIcHDwkzfffFNnEYoo/C4ikmnTpnWztbVtzTBMbsuWLZN69uxZbC3hd+/e7ZOfnx9oY2Ojb9CggdnX17eyY8eOWXFxcXRiYuLSvLw8IyHkK0JIwcu283+qgYeIoFAozIRQUFlZ4XPq1IHGAAAWEUwxDMNPmjRpWmpq6iG5XN5ZqVSy5eXl44YMGXLg66+3NUZEatq0aQwAQHJyste1a9eGXLlyZdanCSuTNZq4pMuXfw6ZOnXquxERETdUqhE7JRLJ2dmzZ78RHR3NWQ4EwkuXjjsNGDBgd0VFxVKKomR+fn6hALBlypQpE4SJsaiO38DW1p5ftGhR++PHjx++f//+wKdPn045duy7KyrVm2pBslmtUkGD0UOGDF6bkpKylhDCyOVym9LS4rVvvz1u/uHDhzhhfBMTE+n4+Hh+8eLF3efMmXWuZ8+ex0aNGvVV7969L40fP37RzZs33WfOnLFx8+bN7QGASUlJGXjixImhpaWlgYQQMJtNrufPnx+SkpLyZnp6erM60oE/fvxAw6ioYYcMBkOMl5eXc01NTfCBAwf2zJo1q5dWq+VUKhVNCMGff/656ZUrV4ZcuHBheULCpxfj45d/DADUzJkzN129elXJsubOWVmZZ/bt2+dr2c6Tv0QlCWJcKpXCwIH9vvP0bIBNmjTGDz/8cIaghmiahpEjR85t164dfvbZZ4sEqSSTySAiIiKxT59euoIC3aeIKLVuQLdunTp7erlxLVs1R602MU2jiUutqCg/N336VGNwcBCqVKoTlh0EjYhOPXtGnOvZs8cVRLQXRC0i2s2ePfsrtVrdz9J2qaCS/P0bYlhYCH/u3JmcBQs+fLhu3boJFvK7tG7d4mZQUAB++OGHwwkhgiojFjVChg0btLNNm1a69evX+wntff/995u0a9e2KDo6eg5FUWBRWQQR3Tp0aHd3+/YvERE5RGQREb///nuuS5fO91q1CsPNmzf0se57mzYtNvn6euMbb/S4KJFI6ttJUffupXl16dLpl65dO39vrUqGDBkyvUOHDqUJCQmd6s7XgAED5ru4OGHv3r0ebdmyedekSZPmffnlly1atWr5pEWLUJw+fcpEa9X9l0kYmqbBwcGJICKwLAsPHjyQWqQFu3LlyjY3b95cQwg5+eGHH65ERGbnzp02RqMRoqKiPn3y5InHsmXqUQAgre1g7QE+dnZOMplMaqIIhbdu3Qp1d2/wtp2d/ZsXL156rtdXAcMwuQCAUqmUGzNm1Md5ebqe7dt3+IgQUjF16lTJJ5984tmrV58Pnz59GlhUVDQIACApKYm3loo0TUFqaqqXQqFcHhsbu3Pq1KkKiqJKQkLCLnEshzdv3pzA8zyl1Wp5tVpNaJrGJUsWTUxPv/+Ou7v7F/PmzctSqVTSiIgIZv369Q+MRsOVe/fSV586dqpxXFwcBwAYFxfXIT9f1yw4OJgDAGIwGGiz2Yz9+/cngwcPalpRWcE6OTmxAABTp06V1CZxMYxld0qZTCapZdJfzJlEIuXfe2/xqqKiouYRET1WEUJ4tVpto1arqalTp35bXl4uO3z48MeIKNFoNCgciiSVShmGYVChkDcqKipuuWPHjoSMjIxGer0+sKqqGuzt7Sv+J/EfnufAbDYiTdPA8zzk5eVxgl2SnJz0XlWVXhIUFHTbaDRCREQEKJVKMwBAx44dM5VK24yTJ086rly5sgMAQGlpC1qj0fAcZ0SalkBxcQn55ZfbR+fMmZMOABWdO3cY7+PjO6NLly7LCCF8QkJCi5s3b75NCMkZOXJkOgCQbdu2mdPT78x4+vTx4rS0axHp6elSiqKsvdkgkTB8ZWUluXHjxrkVK1Z8AwBU27ZtzTzPExcXZxNFA8nKfuYFADIAQI1Gw+fn53v99NPV+JqaGr5Jk2Y3LCubS05ORpPJRPz9/XMq9RXyb7/7djhN0wgAYDIZAsxmFr79dj/heY7Y2NgAABKO42DK1Gl887CWkJZ2HQAAHjx4YNmp/Mbe4i22EFoMeFyz5pOuT548fothmNx+/SIzLSqE1Wg0OHDgQM7Z2Tk3Ly+ny+7dO9sBAOr1eqLRaHieZ0EikZCHDx/Cs2eZOwAAZswYfNLT0+utoKDAsatXrz0J8CIg+1cGDAkQQgMiDzRNQVBQkBQA4NKlS8EFBflv8DyHiJjOsixERkZCdHQ0DwDQvn37Ip5nswDQJiXl6hBCCFy5csWqsTwQQsDBwSHVbDYTQgjZvv1fp1JTU7+YPXt2PkVRcPXqlcHPnz+3cXV1M7Rq1cokGGw+Pj65zs6OYG9vzzdv3vwWAECLFi3oXyUMgNnMglKp/NlkMgEAkLNnz/KEEOQ4s4FHHgjhbABALtzz8ceftM/MfOopk8kqHR0dMwCAtxiWHCEEJRKmjOc57v7D+10E1Wtra3/dzs4Ov/12P0yZMpm/ffsXkEikQNM0ODk6Ub169aELCopfy/2/efNmwjAMnD9//s3q6mqJVCrJ7Nq1VzYhBDUaDWvpu1EikRQbjDXUDz+cDAcASEtLs/S5lohms1nv5+f/MwCAn19nw6VLl749ffrcHkJIlTA8fylhKIoChmEIy3LAMAwGBAToAQAOHz7csKKiwoUQQgoLdeUAAOnp6daNIa6urrTRaISysucteZ6XpaWlcQAAHEeQ52ttKUTqNiEEVSoVqFQq2rJFJxzHMTk5eV3NZjPK5TY8/HqEKlGrNbvmzImZN3bs6Dc3bty4df/+/XRYWJil2J5CRKQYhkGpVJJS19lYa9kiMDTDVFZW0rVqQAJFRfldDAYDyOVy1tfXV3LhwgXmwoULNmq12gYRGUSw43merqmpaXXr1i0PACCLFi26HhYWttPBwZH67rvvqKio4dz777+P9+/fB0IIDBs2rGDgwIHPBMfiKzzwJDk5mTObzfLKysqOLGsGR0dHOj8/X/Hw4UPZ0aNHFYmJidK7d+8qCQFbo9FIlZWVt2MYyQsCUFStKrazs6/u0yeiVPhdlUpFW9lpf922WgDHcVBYmM/VTi5UeHt737DYNi0QUcIwDFRWVloa89uyDaXS1mL7mPxv377tCAAFUGvJEkAgDMOAXq9/IXUsK1rY+jEVFeVyi3GpB4BqwT4hhNQAwHoAgGXLNCQxMZE6e/YsL3QfEUEqlfASiU2xxdCr6zMAHvFFroylHX48j8DzvCItLSX24sWkPJ6vtb2mT5/OVlZWByEPNx0dHQ06nc4eAPLj4uKMBw4cnB0d/WbW48cZc4uKipy3bv0Cjhw5bI6NjZVMmjQ576233no6atSoF3lGr9qQnj17VlFdXeWNSMBsNgfEx2vWlpdXchRFUTRN82fOnJHU1BieKxV2dxwcnCmz2UT96lKgABHB1lZJPDwa0nXG9K/39AowGo1U166dbDiOAxcXJ92IESOyZ82aBSZTjVwQzVKpsAlS/YY01dU1SNM0mEwsq9P9Wm1IJAQBEBiGAXd3l5cOIMdxnMXpxMG/H9IsSFI+Ojqaq2v9E0KBvb39a0lbk8kEZWVlHCEA9vZ2NV26dN+2bNmy+2azmbGzs+N9fX1JTU2NYejQ4eZBgwZRvXr1qrF4qd0AoPzAgUPLt2/ffuD48ePvPnhwb0xpaYli0aKFeOnSZef169e7AUCeRqP53XacO3cODAYjD4Dg5eWd1bVr9/gpU6ZwLi4uVEBAAHp6eiIi1mze/Lmw0PBXyVGr4gkBtry8/A+dTvGnEEatVhONRoMnTpxwN5nMoQzDgJub+xUfH+98y0q/i4g8Ik/p9TVoYfNvfkMulxOz2QxOTo50nz59fiMS0fI3DfS/+X0EIrq4OEtycrIFclB1rkNCCF64cMG2oqLCY+jQoRn1pHO89k7Qw8OjOj39DtrY2FB9+/asGTt2bKHwfXp6OgAAXL58GT7//PMXnuxdu3b1MZlMpxHRNGnSpHSJRDJVo9HsuHz54qIHDx4OOXv2rP/8+fPHUxS1iuf5l6qE0NBQwbvL/vjj5RqdDsHGRmaYPHlyXnV1NVRVVUFWVhZYbaHr8fRSlk0KcjRN/6EDk/4sG4YCAPLzzz97FxeXNHB0dOQ7duy8x2yubYunZ4NMmUym5zge/P396XpEP+r1eo6iCCoUirsA8Fxo268dJQD1mIQWaWF2dHTMtIhcW2sD1bK6CQDAxYsXm1+/fj1GkEDMH1gudnZ2gqEIzs6uqTTNEKlU6lBdbRxkFX8SIvTkwoULzJEjR0KPHj2qAAA+JSUl6uHDh22FYK3ZbKYWLVr084kTJ4f37t1nrVTKoE6XG8VxnA0A8L+Gtn6L6OhojhCCNjbychsb2Q2KotBkMjNVVVVC9gAl+IkAgCQmJjr88MMPTX9rl/BQu11HirzsQX8OYQhyHPdv+vX48eOEoii8f//+ELPZpGjXrv3FBQsWpAnfL1iw9L6rq+s9iqLQ3t420BIEe3F/Xl6erLz8uUKptCVeXp7HCSHGtm3b0vXZSHUREhJCCCF8gwaeJ+3sbElZ2XMqJSWl3kGorKxsUVZWdqeegCNQ9QVrXuLN7tChXYqtrbI8Jye35uefU08IgUSLMAMAgJycHI9Tp04tSEtLk8rlciwoKHC4e/feSIZh8MGDBwgAfGJiIk0I4bds2bLEz8/3YXV1ladF6qMwsXWdo7t37/Y8ePBgkMlkhODgJpcUCgV59uyZ9bPR4vexxPdOdTl16tQESx0V9WdIhpcNDAEAiuM4Gn5d24xEIpGrVCpap9MJmfR0WlqaOSsry/f+/ftzvLy8s2Nipk0GgIravBmgCKFqWrVq8zXDMCQ/vzBYJpNhREQEuXDhAg0AdHr6TR+j0Rjm7OyUFRcXf9gSpwGVSkWbTCYK+VrV4+rqSqtUKrpXr16UEP21OMZg8+bNJ11d3R7q9foGFRUV9gBAx8XFSRITE2mNRgMURUFVVVVHd3f3FKFvxcXFRmFuCgtzjQBAhYSEkMLCQqJSqejarVmts+DRo0cvAp/jx4+/16NHz3vl5eU2d+7caggAqNVqGbVaTcXFxUkAAJOSkto3atSoVVxcnBmRB5Zl9U+fPo7atm1TcHJyMqtSqaRubm5EpVLRdnZ2RgcHpzJXV7diwWCvJTFtMeqRWIhEPXz4cPC1a9f6IyKo1epDjo4Oz8rLK5o9e/bMnRCCW7duZRITE+mkpCQKAJCm6V48z9+0SGPhHQpEIJfZbKZe9UaX/wh9+/b+2MXFiWvdumXljz/+2K5u4HHz5s3tevbsebNdu3bPNm3aJLiimV+3tmoKEaV9+/ZNatGiRWlZWZljHTE7MzQ0FGNjY6PrRpY7d24X7uvrVd20aWNux44dXQWboE6cgyIEYN68eQNatmyJUVFRamsHnWX3Ejt9+vSNgvucEAJHjx6d1bChLxcS0pRNSbm6Sir9rft97ty5cb6+3lzz5mF3EdHBKkLsWlxclBYVNQzbtw8/rVQqf3NffHy8b0xMzM0rV64st1xPR0ePONa4cRC+/fbbqRcv/tSijuRz7969e+68efPetUT4aUIIDB06eL2Xlwf26BFxXiaTAQDAtGnTEubNmzfAKhQxMiQkhFu8ePHXiPibs2zee+891eTJk4/cuXPH1npMhw4dPMfDw53r3r1LFiK6/uHMrno+ww0bNvTLyMgYoFQqy2/dujHk9u3bLZycnKBbt27bOI7L5XmwLSwsNPI8742IbfR6fcq4ceNWTpgwIfPatWuKtm3bGoVqQqEMVafTdfjggw++zMvLu9usWbPP/f39C27fvt05KyvrQ29v7y379+/bOHHiJMnWrVvZL7/8MvjZs2ft8vPzm1+5cvlDhmGgV69eCa6urk98fRueGjdu3BOtVktZotQgBDdnzJgx6969e7ENGzb8Ijg4+EpNTY3NvXv33lAoFI369Okze/To0QVqtdrPxcWxv1yuWLd27VqljY0NxMbON+v1VfP9/f33ZWdnt8zOzvbLzc0ZnZR04Q0fHx+YPn3GuadPM3dFRkYe6tq1ayUi+l66dGm8Wr30bUdH5+v+/v7/Cg4Orrp582ZDo9E40sPD49DatWu/ioqKor///nuub99ex9zdG7gNH/6m7siRI47V1dX/at269R2dTufy6NGjxQzDZO/fv/9ti5+JaLVabvXq1RF79uw+ZzKZ9J06dZlQXV0d4ujo2PSLL76YTgipjoiIoC9fvsxGR0dPqK6u/rxdu3aXEHGVXq9nnzx50lEqlfZo2LBh7Mcff5yOiEx8fHxLpVLZ5fbtX946c+Z0p8aNG8Pw4cM3FxeXJg8ZMuR0eHh4+asi+q8kzLZt23o+efKkNyFoMplMLM/zZkSCMplEAUBRhKC5rKz82Y0bN/KjoqIeLV68OEM4LmPmzJkkKSkJAICPi4tDIUps+ddu9OjRo+3s7Frb2tpKdTrdcw8Pj8SEhISrljwSQgjhdu/eHZKdna0yGKrZyspK1mw2oZ2dvVSpVMoDAxvtHTVqVHpSUhIdGRnJEUKQEALLli1jli9fzi5ZsqTtL7/8MiYwMDCAZdmaqqqqazExMVtbtWpVBQCwc+fWprm5upGlpc9reJ4HAOQpijAuLg2Yrl27fn3v3r3GRUUFb1RVVVVWV1dzNE2jXC5ztLNzKO3YsfPWHj166K3ybNx27949wcXFpZWbm5tNQUHBUxcXl28TEhJShGw+AIAvvtjcX6m0v/bOO28XTp06rbXRaBzp6urqW1RUxFVVVV1OTEzcSQgxWydEMQyDM2dOG3Tnzt1oPz9/T4PBcM3d3X39xo0bC4TfjouLo+Pj49nx48c3Ly4uHhsUFBRsNBoNRUVF9wYNGvTlhAkT8i9cuMD06NGD3bhxY6+ysrLI6urq6pqaKpaiKJDLlQoXF5eKN95446vWrVs//z3C/Kmxx5e8wOFFakDdpCtEVP4ZO7ZXJVy9xgL5b5754vctUXHZb9UkeaXdiIg2daLQpL72SqVSQETmFddZ/ybzO9f+NSmaarWa+r1Tl6w8kpRGo2GTk5Nh165dymPHjoUGBgb65ubmPti3b98djUYDFmcU7tq1K8zGxqaAEFIMAFUqlYp+Vaqi9WeDBw92yc/Pt3NxcamYOHEip9frmWfPnlUDQJVwz65du5zz8vIcfHx8asrLyw06nU6Sm5trDA8Pr7CKjRCVSlUvQYWIdH19t26nZRW+SLnUarUcIcRo1R+0StzmLAYxWiLKVHp6OiGEGITFZtkS1U2phOjoaFqr1SIhhLUQo74qU14wXC3XgUqlohMTE8F6i/6yatY/kpb5Z7BPyPiy6dev3xyOY8e4ubnfb968uVSv1zd78uRJ8gcffLChTZs2ZQCgnzFjxhc0TS/fvHnzQ6tBxNdZ0evWrXu/pKSka1FRYfCDB/clEolU1qJFy0/Xr1+fYDEUufXr188pLCzomZub65mRkeFKUbSsWbNmG7Zu3bqW5/l6X9X3J0sdeI3+EAvZ6CVLlnh99NFHeXVOj6hXer6mqniRKfdXqJf/al9usbz5Xbu2h3Xu3PH74uLC1WFhzT/bu3fv6IULF45asWJF35qamudfffXVVQD46dSpH85mZmZKP/vss0whdfF1O0RRFFZWVn4xdOjQsa1atbycnZ0dlJHxxEcmkz0UHIEWD+nXLVu2Gufl5flVXl5u0OPHj3ykUqlgX/2lmfeWbT4BADh69Kjr7Nmz1dOmTVuxYcMGH+v8XbVaTRBRMnTokFVHjx6+NmzYkI9ediKExT7DPzDx+AcJ9r+BYI+cO3cuukuXzjlBQYEYGzvvLSsiCp5aunPnTpfHjx+LgwYNwMGDBy+yHLdB/SerFwBg7NixS3x8vLiOHTvcFOygOimUMGHChBg/Px+uU6dO9xHR/VW2zp8JQTW8++67bwcGBmKrVq0rDx065C+0UXA3rFwZ3y8sLARdXZ2xUaOg22q12uavsDn+FhAG/vjx480iIrpmeXl54ahRo9ZYiPDCRzJ16lQJAIFJk96Z7ezsyPv4eBvVanWfl6X//d4zLX8UXbt2SfX29kSV6s111uQTVikiynr06H7W09Md33xz+FZLwPN/VWpKEJHq27fPQS8vD27gwAF7apOlat31Qib/pk2bOoWHh5cGBwfjsGHDVlsM9L89Waj/TPISgoh269cnfHbv3n1fb2/vx9Onx37KcRxRq9UvxKenpycHgKRZs7Dr7u7uvKenR9Hw4cNvWtTZvxm5ryqv1Wq1FCEEExISWhcWFoTK5XLs2bPHTxzHgVqtto4Z4fbt28MKC4va29jIMSCg4fcmkwksBmC9RPwjZb2vul74/NSpU4E6na6zVCqlOnbsdLWmpoZSqVQUIQQjIyM5tVpNvfvuuz8NHDiw14gRI/ocOnRoicV1/zIVQl7nfZP1qTWrUpT/GzIK9UPjx49f6O/viw0b+uHYsWPn1Sc1hAG8ceNGq3bt2mK3bl2OCCtJ6Eh9CTuC+7rObzGEEBg7dqymQQNXHDx4oL6qqqqD9XMEKTJq1KgFfn7e2KFD+IPKykr3+rbY1ocg1pmUeieibjutiWM1KTQAwKxZsyZ7eHhg795vYGZm5tL/lJx1c3jr9PU3Ktb681c8g/qfkwVqz6wNbd26ZaG7uyvfoUO7J9evX3ezipD+W+eqq6t9O3RoXzps2JDFFkrQ1gNsya73WbJkSXOLVxiuXbsmsZpkQdXYdOrU6WdnZwdcvz7hOSK2F8hgrY4iI7uf8/Ly4IcPH7rF4uf4N/LRNA1SqRS2bdvWeM2aNWGCP8RqK/xiUoR3WhNCoF+/fm7dunXzFf6PiBJL1h7QNAW1teh9j9nZKXHVqpUcIuYhYh9E9BXc8xs2bHDbsmWLNyEEtm7dKrl27ZrkZZNrGRvnJUuWtEZEuXV2gFW/KQCADz/80G/FihVuwphY7DoZInrt3bu3gVB899/Ycn8oH0aj0QBN07h79+6ZxcUlbjY2NtCkSZM9bdu2LbI4qvg6aQWo0WggNzcXHBwcivz8/K/WSpAXb53nYmNju9+4cWNKRkYG8fb2NowbN46ZP3/+Z+Hh4dcEwqhUKkqr1XLr1q0LLykpaens7MK6ujq/DwCpwnMtEoDbsmVLSHFxcTu5XE4aNw4+azabX9xv7TP66KOPvFNTUxfcuXPHg6Ko6r59+8LAgQM/IoQ8si6DJYSgQqEwv/POO30LCwun9OzZs5tEIsHw8PCTfn5+GkJIJkVREBcXNzU3N3f07NkzjLm5Od0kEgmfl5dHffPN154VFfqTzZqF9IyOjs6OiYkZlJGREU1RlF1MTMz+6dOnf5uamiqp63/Sag9wS5YsbpaSkjL7zp077sHBwWUTJ06Uzp49+8SWLVu0LMsSiqJ4nucpQgj/3nvvjaiqqnozLy8PV61a9TEA3NVoNHxwcPCbWVlZsY8ePcq5ePFy6pYtmz8WVPdfbcNQAMAfPLgvIDMzc5jBYEBHR6eS3r377reI2pfeePbsWdrNzS3Hz8/vISEEtFotIiIzYkTURydOHD8HAMbhw4fPXbVq1WSz2Zx0+/Yve3fu3NkULKdVarVapGkabt++PaC6ukrm6up2f8yY8fsF55nFxkFEZG7evDmspKTEztnZ+dGoUWMvCfaS1UrkFy5c2O3w4cPJHMdBaWnpOwkJCZMKCgqafPvttzsQUUIIgcTERKlFgkgjIyPXZmQ8OfnOO+9ETps2LS0mJsYlKirqnbNnzyQgopLjOMJx3B0bG+W/TCbT88LCQnn79h2ofv36p124cGHEzZu3onv06HH1gw8+6G8wGGYEBwcvpWn6u6ysrDXnz593DA8PN1v5cKiDBw9y8+e/O/748WM/GgyGNmFhYUtXrVo1VSaT7bh///7auXPnDiKE4JQpUySEEH7ZsmUdy8vLJ4WEhMzNy8t7ePbs2UUURfExMTFhSUlJY6uqquYqlcoNd+/+siQ2NraTRqPh//LjWAT7ZPz40fOCgvzR09MD+/fvf/RVBpUwCIcOHfL95JNPpiCiVKVS0RKJBKKjoz8ODPTHjh3bXaxTW2zfrVuXsj59em22tktq1VH7qz4+nhgdHf2pJRpNWas+RGw0ZswonaurE44e/dY+hULx4prExEQaEcmnn37Sq3nzsIrw8PBTQgSYoijo2rXrytDQUF6Itq9bt06OiNSAAQO2BAUFoFb7rQkR21MUBVqtNqVnzx5s3769MTMzY4515H7AgH5fubg44ezZs9IRsY3w3aJFi7wnTpx4csWKFWEAACNGjJjcunVrfsyYMU2E9gn2YWxs7NtNmzY2N2vWNPvOnTsewjhQFAVt2rRJioyMTLGEIaiCggLbmTNn7pk3b15HAIDevXvvb9GiRTIiSidPnrxv6dKl/WvV4Nq2bdq0whEjolb8J7vUPyxhtFoth4h0Xp7ujaqqKlQoFOjq6nrYqr63XkcWAEBUVFT2woULv4yLi2O1Wi03b968qOvXr8cSQoxDhgxfSQjha7fgANnZ2XY8z3PFxcURiGgneGY/+WRlp9LSstYymdzcpEmTE/U54j7//HP3mzdv2tvbO2BISNjJmpoaUKlURK1WU9HR0dzJkyfDv/1W+21VlV46adKkDyz1UQzHccRgMLQHANDr9TJLaoBh9uzZ8WlpadPDw8OfjRgRHUcISVm+fHnH+fPfb/Ljj5dplmVNiKRYIO2lS5eCcnJy+9va2qLZbIwnhFyfM2eOjKIoyM/PX2Bra5u4ePHiO4go0+kKxhoMBggICBCkMKXRaPgDB/aFnT9/NqGyspJp06b1x2FhYfmWSk0eAMBkMhnLyspafPfdd34AwH/66acjaJrOSEhIuIqIzgUFhV38/f2dtm/f/h4iZsTHx59ERPLLL3c66fWVqFDIbS3z+ddtq4UVnJeX4V1eXhHGshxRKpUV/fv3/5kQAmq1Gl+11Tt//jxz9uxZpvYYjOdOV65cXl5ZWSFp2DDgwsKFC8+pVCq6dgsOoNV+Iy8uLpFIpYzv9evXfSxJQHD79t3+1dXVUnd3t/vLly9Ps45laTQaIITA1auXu5eVlSlcXd2ezJ079wdEhJCQEGKJ6yjXrftk9bNnz5wDAwP2x8TE3AoJCZEmJyezGzd+2qGoqLCrs7Pz3QULFtwEANi+/YvOly9fipXJpOjn57uYELISEYmzs7PR1dWFBAQEgpub24bg4OB9U6dOlWg0Gv6bb77pUVHx3MPFxaV04sQpaWq1mtq0aZPxgw8+GEBRlNuGDRv2IKLvli2fDcrLy+5qZ2eXvXDhwkrBBYGI1I4dXy/W6XRODRp4PFy9es23AEBCQ0M5qE10l5vNZjuz2SjV6XKaICJVVVU1yMHBYS8AkNWrV3cqLS32DA0NDSkrK1PxPL/eMneSJ08yhtbUGAkhTMpfEnysD4cP/+BYWVlpR1EUODg43B41alTm6NGjf3NeSV2yWKQMK4jAmJjFo3Nzc0PlchuuSZMm/yKEmNVqoNLTa6VFTk5R85qaajtHR4fnmZmZNAAAy7J2Xbp0juA4DgID/S8wDPPcYrwK57DwPM/bREZ27weA4Obmft7JyalQpVLRGo2Gk8lk+NFH8R89fpzRQ6FQGFu1arv37NkLJD093fTkyRO/MWPe2mdrq6T79eutpmn6OSJSgwb1n5Ofr5P5+TV8OmXK9NMKhR2VlpZGz5gx4ybP88MLCgoUy5cvPx0VpaWjo6NZRCT9+vUbUF5egSqVimvfvr1bhw4dHiIi2bhxo87T03O5RXWvfPTo8cDS0hI6OLjxj46OjnkAINFoNGaGkXd9+vTpcJqmoGFDv+98fX1LAIASXh+4dGm8P0VRIYQAadDA3WbWrFkjEFG3cuXKezRNw08//dQHAGmWNYObm1vO+++/X04IQZ7nu+Xl5Ufa2dlXBQUFpVuEAL5OdcJ/JGGEyG1hoa4pTdNOAACBgQGlSqVt1e/5a0pLS/2+//77FiEhIYiIkjt37g7V6/Xo4uKSNWnSpIuWq0EwbJ89e9rBaDQShpEURUVFPQcASEhIaFdcXNhSLpebfX19T3Ac90IdCbGb1atXtCoqKuosk8mxRYsWJ1mWhZCQEBoA0GAw2J07d75fTU01urm5p23evPk01CZj9xg16q3jiEANHjz0TbV6+UGe58m+ffuaZWXl9KUoCnx8vE+FhIQUaTQaaNu2LZuUlETPnj37XHx8/DGtVssGBgZSAICpqakBOp2uo52dPZFK5XEAcFVYJHPnzr3x7rvvphNCjHv37r5y/vx5JxcXFxgyZMgds9kMISEhhKZp+OWXtOiKigqZUqmsatu23VFhMyGMf35+Vhu9Xu8AAFVKpYPO29vb19XVdS/P88CyJU7Z2Zm9JRIJFhQUFHXv3n0tALAymQxv3779VmWlnmnQoEHq0qVL7/83Trw/ZCmbTCYHiqIITdOgUNhmVlXpCbzkHBFLJ/HcuXNzk5KSVsTHx/N79+71LSoqasUwDGnQwONix44ddQBALCdLIcuydjpdfi+appAQuCuRSHIsZbB9qqpqZL6+vvkff7zmurU6sqQJwK1bt3uWl5dLXF1dH0+fPl3I2+UBAJYtX9Y5Ly87iGEYkEqZOxMmTIgeMWLEvzIyMj6Ijh5ZdOzYiXGrVq06yrIsAQA8f/58l6oqvaNcboMBAf7nWZYlKpWKCJ5awUB96623uLS0NCCEwM6dO3tUVlZ4Ojk553fs2PEoIYQTjhVJTEykR4wYQSMi869/7YrIzc1Fb2+vu7NmzdplSXUwsSyryMnJaseyLLq4uN9ZvHjxL1CbzI1arZaXSqWQlfWsr8lkAFtbu+w2bZo8WrRo0frmzZunAAAsXryyo16vb8yyLEHkvwoKCrpECOGPHz/e+Nmzp4MkEhoCAwNPUxRVAwDC0bjkLyGMMDn29k6PTCZTjY2NDWRmZt60pBNSL7uHpmn4/vvv3QoKChJ5nofHjx+3rKmpcVQoFODr65dkqQWiLDkaGBPzXpeioqJWEomEtGnT5j7LssBxnF1eXn5PlmWhTZs2ty25LyQuLk5+4cIFW61Wy/E8b5Ofn98TkQdXV5czAQEBeYQQ7N27txwRFcX5+V1ZziRRKhUkanjUaFdX1yA3N7e9Z86cGREbG9vbzc3tCgDA1q1bwxBRqdPp2hqNRrCzs8/v06f/DQBAYQwsx37wnTp1ctyxY0fTadOmsVKpFHJyng0xGGrQz8/nzKBBg/IsqRvMzZs3He7evYtarZaLi4sLz8nJiVIoFCQw0H8nISQHAGy2b9/e6ciRIyFGozGYpmni5eV1kaKoagCgBAm6c+fOwPx8XW+apsHJyTnVwyOoiBDCa7VakEgk8Phx5sDKSj3t5ORUOnjw0F0CGfbs+XpIcXGxh4uLS/HgwYOP8DxPXbt2ze706dMO9Tlb/1QJ07FjxxypVPqcoijw9HRnXrUF12g0/OzZszuxLGv7/vvvHwIA0Ol0DQFA4u7uBipVlMGy+kCr1fKISJ4+fTSqoqKScnNzKxk9emwSAMCKFStCi4qKwuzsbHknJ4dNhJAaiqJw4cKFS69cudKyVh0lBBUUFLZTKJQQGzu/KcdxjogoP3funObIkRMdLl/+UV9TY4CGDQNKZ86a8+6qVas/3rJly2mKoqpILdiEhIRmaWlpSwBAYjAYFIgIXl5e6X379n1qMaxRcCISQvD06dOzcnNzRwEA/vxzckBenq6NRCIlAQFBpy1F8fzixYvf/+GHHyIsthZ15076mOfPn0s8PNwfaDQr91rGP0Sn02lKS0vl5eXlUoVCDnZ2dkmICCqVimg0GkIIwRMnjg0vKyvzUCqVXMuWoVpCCKrValqr1XImk8np2bOnEYgIAQH+ySqV6oHF8WiTm5s3yGxm0cnJ+eCwYcPSCSH8sWPHFufm5k4nhPBJSUn0n04YYbAiIyNz7O0d0hGRr6mpYQGAhISE/IaliCixfEY9f/78Qzc3N21YWJgeAMDV1bWCohCAYNobb/Q5Y72927hxbbPMzIyBEglDAgMb7evSpfNpQgiUlBSGGwzVcjc39/tLlsSlAgDMmTMnsqyszNvGxuY6AEBJia5NaWmpfXBwMHbr1q0nAGjv3bt3tbS0tJHJNPAiw9AKCSMBiqIPyWSyHSaTkRbiVWq1mlAUBffv359FUdQpQqjnACCTSGhQKuU/M4xEOEkKExMT6e+++46bPHlyqKur67uTJ0+4DwDwww9nm1ZUVPg4OzvpevXqdRER6R07dkQYDIbOzZs3t9hpYKPT5bZmGAk0bRrydaNGjXSEED4vLy/ax8fncceOHctomrYBwMIRI0bcFXJ8AIAvLS11zMh4OtZoNIKfX8Ozq1atPQ0AQt40WbZsWfvi4pKmtra22KRJyF4hGWvv3r2+Ol1BMzs7WzJ/fqwdInrv3bs31Gg0dmnfvn2WZU75v0LCIAAQqVRqmDhxQpVcLqcqKysVFEVhenq6kLsq+Dt4jUbDTpkyZQHP88Xr1q1LFGIxYWFhKQDAy20UGRKJtEQwvmiaxjNnLkwpLi5y8fPze/Dee7GrOY6nGIaB3NwcHwDABg08TgFA6c6dO22qq6tnBQQEbI2Nja0BAMjIyAjieR67d+/OS6UyBIBeSUlJoaWlpeuiowkXGhrK2NjYgKurq/7ChQuMSqWCxMREPiIigtZoNOyECRNUPM8rtmzZ8jUhBGxtbXPkCjkaDMbHHFdrv6hUKjo6OprjOE4ml8s3+Pj4JDRo4LWfoijIzs5tYTabwcvLO3nw4MHZADAAEY/37dvXGBUVVQYAkJWV5WEwGJrZ2dllL168dBfLshAbG9sKALwyMzPfbdas2XN7e4dSuVxZNXDgwEpEJKtXr6YAAOfPnz88OzurpZeXl2Ho0GHxllRQKjIykqdpGm/fvj3YaDQybm5u91avXn0efj07ualer3cPDQ2Ffv36jbKEUs4/e/ZsU0hIyD7LUWb8X6aSFi1aRE2cOPlLPz+/9JKS55M5jqO0Wq1wFgtqNBr+yJEj3MKFC+eVl5d36dSp0yIA4PPy8hAAYOTIkQ9d3NxuURQloWs9tUSr1XKbNm0Ku3///lQ3N/fyYcOGz+jYsWMOAFA8z4PJxBK5XA7NmgWfIITgjRs33pNIJHcWLFhwWTh6DBHRwcEBIiN78ADAJicnwfXr19fv2bMnGQAgNDT0DI/A1dTUQI8ePVhL/i0mJyezY8aM6ebq6rpuypQphwkhHCIPAQEBP0ilNoTnCQW1RWrE4rikZs6c+RkiJo8fP/4jQggDAPD8ebkTwzC8v7/fIUIIfvLJJ23v3bt3sE+fPtOuXLkiAQDw8/MroWla7+vre6ZZs2a5iNiU5/n1rq6uxzUajQkAPCIjIytomuYBoIwQgmlpaWZEdEhJSXnfwcGBzJgx49icOXNSLZIdNRoNz7KsS0FBQQ+O4zE4OOiERCIpValUEgAAJycnnmXN0KlTJ54QylRaWuqZmpr60MPD40hiYiJdN8XkzyaMYPQdf/NNVZRSqYThw4ftevvtt/0fPnxof/jwYbvZs2c3feedd77Mzc2N6tWr1+SZM2cWxsXFEY1Gw1q22aZ2bTustLFRho0dN7YFIuKSJUua7N799V5bW/uKkSNHjVmwYMEFAKBUKhVyHAf+/oG/uLk1KO/SJeJxTEzMW2azudWcOXM+VavVlMWhBc7Ozld9ff1IkybNJA8fPpQkJ18sWbp06WlLyia1YMGSyxHdIx8VFRUOu3z5chNEdN60aZPL5MmTxzds2HBP//79N7dr1+6EJZpMEhISzjs5upysqqp6+/jx406ISJYsWRI6c+bM3Z6enspNmzZ9ZEkk53meB0dHpwfu7u5Umzat8+fMmdP50aNHbUpLS+cTQgrCw8NZAKBkMlm5t7f3LScnJ/O2bdvsli1btsXe3r5g5cqVRy1jc61ZsxCVm5s7JiSsW4aI0q1bt3r26NH9K0KwcXT0WxunTp0+yVKH9WJXumHDp+/k5+eF2NoqSVhYqyMsy4KTkxMCAIwZM+aWnZ19jpubG2UyGaXbt283m81mdUJCQs3du3fxP0nh/EMWMiEEUlNTJeHh4eacnByXuXPnfcDzbJC3tzdjNBrpgoICdHFx+XnatGmbOnXqVGGJEdVNlLKJj4+flpKS0jkgIIB99OiRJyEkZ8qUKR+rVKp7x44dkw0YMMAotA0RlW+//fYauVzeSCKR6AICAhbGxsbmWtIQhJon6cSJE9cGBwePLCgo+DkkJGTR1KlT0wXJR1EUFhc/HzB//txxALx3o0ZNah4+fFhMCMlVq9X3/P39vyGEsMIpFACA6enpLosWLfpUqVS6enl5FRYXF0sdHR1PbNmyZe+HH37IxMXFcUL9ECIqR42K/lyhUAbKZPLHbdu2/WzKlCnXli1bRmk0Gj4xMZFWqVR8XFxc69zc3KU8zzMVFRXXDh48qOF5HhCRSktLo9u3b2+Oj4+PePLkyQo7O7v8oqICh8LCAjYiovvqjz5alWQ0GoVyE85SF86vW7dmRXp6+viqquqj+/btjwUAk8U/BfHx8fy4cePekUrpeA8PL16ny1++a9euHVeuXJGEh4f/b04+r5sEtGbNGuWnn37aZs2aNe2s8lJ/9+UUu3fvtl+3bl3E1q1bPYWy1voSp4QclQ0bNrRFRIl1UFMIfBJCgKZpmDlzZiPBXrIi3IvgKEURWLVK7bdhw7qImJiYBtaStp7yW6AoCtavXx+2atWq9tY1V3WuE55DffXV1jZZWVny+vov/P/gwYMu27dvD7Mq/RACp5T1QcwrV67stHbt2qbC6wYtb5Cj6rbR8lpBL0uJ7b+1jRACX3+91S8+Pt73/zpn+GUnUP9uKmE9ZKJeQTDyR6Vifb/1khTHV6UuknoSr16rja953cueTb3mOL+utiD/Zxl3r8o3fZ2c0/rue03H0WvltL5u3usfaesf6Bv5g89/3TF9reT4//YaESJEiBAhQoQIESJEiBAhQoQIESJEiBAhQoQIESJEiBAhQoQIESJEiBAhQoQIESJEiBAhQoQIESJEiBAhQoQIESJEiBAhQoQIEf8L/H+8Gsv2QzS3QwAAAABJRU5ErkJggg==" alt="Dorchester Collection" class="partner-logo">
	    <img src="data:image/png;base64,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FBCRxVPfp08ftGzZUubaa5omi9f9/PPPeOWVVwrNa7969WrauXMngIu59cnJyXj00UcBAGlpafIKPoZhGIZhooMBAwZo1apVk4Z3v9+PlJQUAMDJkyexa9cuDsdnGIZhxZ4pbJKSki5OimBefZ06dTBlyhRLIRzhwff5fPjwww8LrS0rVqyQ/9Pv9+Pee++1VIW12WzyKj6GYRiGYaKD6667Tn7udDpx9uxZmXv/ySefcAfFEbt376ZFixaxsYZhWLFnoo2MjAzr5NB19O/fX6tQoQIMw7Dk22uahh07dmDlypUFvqEfPnyYFi5cKP9PmTJl8OKLL1oKyPh8PhiGIaMJbDYbdu3aFbdjs3LlSuratSsfniWEtLS0HI/12rVracSIEXTgwAGeH0XA4MGD6aOPPspXXx87dozHiolbhg0bJj/PzMyEpmky7/7EiRPcQTnk5MmTNHfuXHruueeidr+YOXMmbr311lz9zYEDB+iee+6h999/n/fBHLJw4UIaMmQI9xdzWUzuAkbw3//+V1axFQcxAIwfPx4TJkyA3++Hy+VCRkaGVKznzZtX4O14/PHHYRiGjBx4+OGHMW7cOPnzatWq4eeff7bcZe/1emXhv8Lg0KFDtGHDBpw4cQInT56Ex+PByZMn0aZNG6Snp6N27dro168fbrrppgKtYLtu3Tp65plnMGDAACQkJODhhx+mZ555Jux/bN++nZYuXYqffvoJP/30E7755htcffXVSEhIQMWKFdGhQwdMmDAhx23bsWMH7d69G9u3b8d///tfHDlyBFWqVEHFihXhcDjQuXNnXHvttWjTpo2WlpZGCQkJRV659+DBg7RhwwYcPHgQ//vf//DHH3/g2LFjaNWqFUzTRP369dG2bVvccccdhd62xYsX06ZNm/Dtt9/i3LlzOHnyJGrVqoWKFSuiYsWK6NixIzp27Ij69evnqC056c89e/bQzJkzccMNNwCATJMJ5Z133qElS5bg6NGjqF69Ovr164dp06ZxpeVcMnHiRJo/fz6WLFmCPXv2RPyd7du30yuvvILvv/8e//d//4dWrVrh8ccfR9OmTS39feWVV172/+3atYs2b96MQ4cO4ZdffsFPP/2E33//Ha1bt8aff/6Jq666Cs2aNUO7du3QrVu3QhvPolzfx48fp3r16oX9r/3799O6deuwZ88epKen44svvkD9+vWRmpqKQCCATp06oUePHujcuTPP6yggOTkZlStXxunTpy1Fbv1+P3744Yd8v//hw4fpo48+wrZt22CaJvbv34/ExERUrlwZdrsdffr0QadOndC2bdsCmw/79++nbdu2YcOGDfjvf/+L9PR0/Pbbb2jUqBGcTicqVKiApk2bYvz48fn+nwcPHqS1a9eiadOmyMjIQPv27QtsbD799FPaunUrtm3bBrvdjj179qB69eooU6YMDMPA9ddfj2rVquXo3Dx58iQ1b94cpmnmqObR7t27ae7cuWjWrJkYx0vuBStWrMCqVaug6zoOHTqERo0aoXz58qhatSo6d+5cJGe7yquvvko//vgjvvzyS5w+fRo//PADOnToAJ/Phzp16qBVq1YYMWJEgbZp7969NHr0aIwaNQpnzpzBY489Rk899VTY/3j99ddp0aJFOH78OGrUqIHbbrsN48aN4/2QYUoyU6ZMIdM0CQABoMWLF0vrYOXKlcnhcMif6bouP9+6dWtBWxHJ5XIRAKpZs2bYe7dr107+b03T5OedOnUqFGvmpEmTqHTp0qRpGpmmSbquW/6v0+mUn1etWrVArOvz5s2jhg0bWv6Ppmk0fvx4y3u/+eabVK1aNfk7AMhut8vPRXvtdjslJSXR1KlT6XICRe3atS3vp2kaJSQkyK9tNpsc/wEDBtDXX39dIP3epk0b0jTN8szJyclh77169Wrq0KGD/J3ExET5uWEYlJSUZJmjbrebpkyZQnv27Cnw+TFjxgyqWLGi7BfxUdM0yxoBQElJSTRlypRct+HEiRMUqvDddNNN8nnFxxYtWoS9d+vWrWUfid8FQM2aNaMvvvgiZqz/rVu3lv2pzpHQ9VAY/OMf/6CqVataxjK4P4X9XuieYLfbKTExkV599dUct3PDhg3UokULyzoW80n0gZhr4lW/fn1auHDhZf/H3XffTQCoQoUK1Lx5c+rQoQO1aNGCmjVrRh06dKCWLVtSkyZNqFOnTtSmTRvq2rUr1a5dm6677jo6efLkJd//gw8+oFKlSlGVKlWobdu21KZNG2rdujV16NCB2rZtSx06dKBu3brRNddcQ5qmUfny5emzzz675HseO3aMbrjhBst+pj6/ruvkdrvl91q1akUrVqzI15xYtWpV2P4HgCZMmBB162X8+PGyfep+Ew1tve6668L2QGW/zhMf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" alt="Serandipians" class="partner-logo">
	    <img src="data:image/png;base64,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" alt="Aman" class="partner-logo">
	  </div>
	</section>

	<section class="prive reveal">
		<div class="prive-bg"<?php if ( $prive_bg_image ) : ?> style="background-image: url('<?php echo esc_url( $prive_bg_image ); ?>');"<?php endif; ?>></div>
		<div class="prive-overlay"></div>
		<div class="prive-content">
			<p class="section-label">Sedgemore Priv&eacute;</p>
			<h2>For those who<br><em>travel often</em><br>and expect more.</h2>
			<p class="prive-tagline">Quietly personal. Thoughtfully tailored.</p>
			<p><?php echo wp_kses_post( $prive_text ? $prive_text : 'A membership for clients seeking a refined layer of continuity, access, and care across every journey. As a member, you are supported by a dedicated advisor who understands your preferences and anticipates your needs.' ); ?></p>

			<?php if ( is_array( $prive_list ) && ! empty( $prive_list ) ) : ?>
				<ul class="prive-benefits">
					<?php foreach ( $prive_list as $list_item ) : ?>
						<?php $item_text = isset( $list_item['prive_list_item'] ) ? wp_strip_all_tags( $list_item['prive_list_item'] ) : ''; ?>
						<?php if ( $item_text ) : ?>
							<li><?php echo esc_html( $item_text ); ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<a href="<?php echo esc_url( $membership_link ); ?>" class="btn-gold">Enquire about membership</a>
		</div>
	</section>

	<!-- <section class="testimonial reveal">
		<div class="testimonial-inner">
			<blockquote>Every journey Sedgemore has arranged for us has felt genuinely considered. They know what we want before we do.</blockquote>
			<p class="testimonial-attr"><strong>Sarah M.</strong> &mdash; Private client since 2019</p>
		</div>
	</section> -->

	<section class="destinations reveal">
		<div class="section-inner">
			<div class="destinations-header">
				<div>
					<p class="section-label">Places we love</p>
					<h2>Places, stories<br><em>and inspiration.</em></h2>
				</div>
				<a href="<?php echo esc_url( $destination_link ); ?>">Discover all destinations</a>
			</div>

			<?php if ( is_array( $stories ) && ! empty( $stories ) ) : ?>
				<div class="dest-grid">
					<?php
					foreach ( array_values( $stories ) as $index => $story ) :
						if ( $index > 4 ) {
							break;
						}

						$image    = sedgemore_home_asset_url( $story['image'] ?? '' );
						$raw_text = ! empty( $story['text'] ) ? wp_strip_all_tags( $story['text'] ) : '';
						$parts    = array_map( 'trim', explode( '-', $raw_text, 2 ) );
						$title    = ! empty( $parts[0] ) ? $parts[0] : ( $destination_fallbacks[ $index ]['title'] ?? 'Destination' );
						$region   = ! empty( $parts[1] ) ? $parts[1] : ( $destination_fallbacks[ $index ]['region'] ?? 'Sedgemore Selection' );
						$story_url = sedgemore_home_link_url( $story['link'] ?? '', $destination_link );
						?>
						<a href="<?php echo esc_url( $story_url ); ?>" class="dest-card <?php echo 0 === $index ? 'tall' : ''; ?>">
							<?php if ( $image ) : ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
							<?php endif; ?>
							<div class="dest-card-info">
								<h3><?php echo esc_html( $title ); ?></h3>
								<span><?php echo esc_html( $region ); ?></span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section id="enquire" class="enquire-cta">
		<div class="enquire-text reveal">
			<p class="section-label">Begin your journey</p>
			<h2>Tell us about<br><em>your journey.</em></h2>
			<p>Share a few details and we will reach out to arrange a brief conversation. There is no obligation, and no questionnaire. Just a quiet exchange about what you have in mind.</p>
			<p style="font-size:13px;color:var(--mid);letter-spacing:0.02em;">We aim to respond within one business day.</p>
		</div>

		<form id="home-enquiry-form" class="enquire-form reveal reveal-delay-1" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
			<input type="hidden" name="action" value="home_form">
			<?php wp_nonce_field( 'home_nonce_action', 'home_nonce' ); ?>
			<div class="form-2col">
				<div class="form-group">
					<label for="home_first_name">First name</label>
					<input id="home_first_name" type="text" name="first_name" placeholder="First name" required>
				</div>
				<div class="form-group">
					<label for="home_last_name">Last name</label>
					<input id="home_last_name" type="text" name="last_name" placeholder="Last name" required>
				</div>
			</div>

			<div class="form-group">
				<label for="home_email">Email address</label>
				<input id="home_email" type="email" name="email" placeholder="name@example.com" required>
			</div>

			<div class="form-group">
				<label for="home_phone">Phone number</label>
				<input id="home_phone" type="tel" name="phone" placeholder="+447960629866" value="+44" inputmode="tel">
			</div>

			<div class="form-group">
				<label>Interest</label>
				<div class="interest-grid" role="group" aria-label="Interest">
					<label class="interest-option" for="home_topic_travel">
						<input id="home_topic_travel" type="checkbox" name="topic[]" value="travel">
						<span>Bespoke travel</span>
					</label>
					<label class="interest-option" for="home_topic_events">
						<input id="home_topic_events" type="checkbox" name="topic[]" value="events">
						<span>Events &amp; experiences</span>
					</label>
					<label class="interest-option" for="home_topic_concierge">
						<input id="home_topic_concierge" type="checkbox" name="topic[]" value="concierge">
						<span>Concierge services</span>
					</label>
					<label class="interest-option" for="home_topic_membership">
						<input id="home_topic_membership" type="checkbox" name="topic[]" value="membership">
						<span>Sedgemore Priv&eacute; membership</span>
					</label>
					<label class="interest-option" for="home_topic_corporate">
						<input id="home_topic_corporate" type="checkbox" name="topic[]" value="corporate">
						<span>Corporate travel</span>
					</label>
				</div>
			</div>

			<div class="form-group">
				<label for="home_message">Message</label>
				<textarea id="home_message" name="message" placeholder="Destination, dates, what matters to you..." required></textarea>
			</div>

			<div id="home-form-message" class="form-message" aria-live="polite"></div>

			<button class="form-submit" type="submit">Send enquiry</button>
		</form>
	</section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

		var enquiryForm = document.getElementById('home-enquiry-form');
		var enquiryMessage = document.getElementById('home-form-message');

		if (enquiryForm && enquiryMessage && typeof myAjaxObject !== 'undefined') {
			enquiryForm.addEventListener('submit', function (e) {
				e.preventDefault();

				var selectedTopics = enquiryForm.querySelectorAll('input[name="topic[]"]:checked');
				if (selectedTopics.length === 0) {
					enquiryMessage.textContent = 'Please select at least one interest.';
					enquiryMessage.classList.remove('success');
					enquiryMessage.classList.add('error');
					return;
				}

				if (!enquiryForm.checkValidity()) {
					enquiryMessage.textContent = 'Please complete all required fields.';
					enquiryMessage.classList.remove('success');
					enquiryMessage.classList.add('error');
					enquiryForm.reportValidity();
					return;
				}

				// keep message area empty while sending; button shows progress
				enquiryMessage.textContent = '';
				enquiryMessage.classList.remove('success', 'error');

				var submitButton = enquiryForm.querySelector('.form-submit');
				var _origButtonText = null;
				if (submitButton) {
					_origButtonText = submitButton.textContent;
					submitButton.disabled = true;
					submitButton.textContent = 'Sending...';
					submitButton.setAttribute('aria-busy', 'true');
				}

				var formData = new FormData(enquiryForm);

				// DEBUG: log FormData entries to console to confirm payload
				try {
					var _pairs = [];
					formData.forEach(function(v,k){ _pairs.push(k+"="+v); });
					console.log('Home payload:', _pairs.join('&'));
				} catch (e) {}

				// disable other form fields to prevent edits while sending
				var _disabledElems = enquiryForm.querySelectorAll('input, textarea, select, button');
				_disabledElems.forEach(function (el) {
					if (el === submitButton) return;
					if (!el.disabled) {
						el.classList.add('sedgemore-temp-disabled');
						el.disabled = true;
					}
				});

				fetch(myAjaxObject.ajaxurl, {
					method: 'POST',
					body: formData,
					headers: {
						'X-Requested-With': 'XMLHttpRequest'
					},
					credentials: 'same-origin'
				})
				.then(function (response) {
					if (response.ok) {
						return response.json().then(function (data) {
							if (data && data.success) {
								enquiryMessage.textContent = (data.data && data.data.message) ? data.data.message : 'Thank you. Your message has been sent.';
								enquiryMessage.classList.add('success');
								enquiryForm.reset();
								return;
							}
							enquiryMessage.textContent = (data && data.data && data.data.message) ? data.data.message : 'An error occurred during submission.';
							enquiryMessage.classList.add('error');
						});
					}

					// Non-JSON or non-200 response: read text and show it for debugging
					return response.text().then(function (txt) {
						enquiryMessage.textContent = txt || 'Server error (status ' + response.status + ').';
						enquiryMessage.classList.add('error');
					});
				})
				.catch(function (err) {
					console.error('Fetch error', err);
					enquiryMessage.textContent = 'Network error. Please try again.';
					enquiryMessage.classList.add('error');
				})
				.finally(function () {
					// re-enable fields we disabled
					var _reenable = enquiryForm.querySelectorAll('.sedgemore-temp-disabled');
					_reenable.forEach(function (el) {
						el.disabled = false;
						el.classList.remove('sedgemore-temp-disabled');
					});

					if (submitButton) {
						submitButton.disabled = false;
						submitButton.textContent = _origButtonText || 'Send enquiry';
						submitButton.removeAttribute('aria-busy');
					}
				});
			});
		}
	var revealItems = document.querySelectorAll('.home-review .reveal');

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries, io) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('revealed');
					io.unobserve(entry.target);
				}
			});
		}, { threshold: 0.15 });

		revealItems.forEach(function (item) {
			observer.observe(item);
		});
	} else {
		revealItems.forEach(function (item) {
			item.classList.add('revealed');
		});
	}

	var offerCards = document.querySelectorAll('.home-review .offer-card');
	offerCards.forEach(function (card) {
		var video = card.querySelector('video');

		if (!video) {
			return;
		}

		card.addEventListener('mouseenter', function () {
			video.play().catch(function () {});
		});

		card.addEventListener('mouseleave', function () {
			video.pause();
			video.currentTime = 0;
		});
	});

	var heroVideo = document.getElementById('homeReviewHeroVideo');

	if (heroVideo) {
		var source = heroVideo.querySelector('source');
		var desktopVideo = <?php echo wp_json_encode( $hero_video_desktop ); ?>;
		var mobileVideo = <?php echo wp_json_encode( $hero_video_mobile ); ?>;

		function updateHeroSource() {
			if (!source || !mobileVideo || !desktopVideo) {
				return;
			}

			var target = window.innerWidth < 768 ? mobileVideo : desktopVideo;

			if (source.getAttribute('src') !== target) {
				source.setAttribute('src', target);
				heroVideo.load();
				heroVideo.play().catch(function () {});
			}
		}

		updateHeroSource();
		window.addEventListener('resize', updateHeroSource);
	}
});
</script>

<?php
get_footer();
