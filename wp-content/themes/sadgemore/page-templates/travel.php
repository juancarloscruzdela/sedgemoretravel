<?php
/**
 * Template Name: Travel
 *
 * @package sadgemore
 */

get_header();

if ( ! function_exists( 'sedgemore_travel_asset_url' ) ) {
	/**
	 * Return a usable media URL for common ACF return formats.
	 *
	 * @param mixed  $value ACF media value.
	 * @param string $size  Image size.
	 * @return string
	 */
	function sedgemore_travel_asset_url( $value, $size = 'full' ) {
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

if ( ! function_exists( 'sedgemore_travel_field' ) ) {
	/**
	 * Read an ACF field with a fallback.
	 *
	 * @param string $name     Field name.
	 * @param mixed  $fallback Fallback value.
	 * @return mixed
	 */
	function sedgemore_travel_field( $name, $fallback = '' ) {
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

if ( ! function_exists( 'sedgemore_travel_term_field' ) ) {
	/**
	 * Read a field from a travel-type term.
	 *
	 * @param string $slug       Term slug.
	 * @param string $field_name ACF field name.
	 * @return mixed
	 */
	function sedgemore_travel_term_field( $slug, $field_name ) {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		$term = get_term_by( 'slug', $slug, 'travel-type' );
		if ( ! $term || is_wp_error( $term ) ) {
			return '';
		}

		return get_field( $field_name, 'travel-type_' . $term->term_id );
	}
}

$banners     = sedgemore_travel_field( 'banners', array() );
$hero_banner = ( is_array( $banners ) && isset( $banners[0] ) && is_array( $banners[0] ) ) ? $banners[0] : array();

$legacy_hero_image        = sedgemore_travel_asset_url( $hero_banner['image'] ?? '' );
$legacy_hero_mobile_image = sedgemore_travel_asset_url( $hero_banner['image_mobile'] ?? '' );

$hero_image        = sedgemore_travel_asset_url( sedgemore_travel_field( 'travel_page_hero_image' ) );
$hero_mobile_image = sedgemore_travel_asset_url( sedgemore_travel_field( 'travel_page_hero_mobile_image' ) );
$hero_image        = $hero_image ? $hero_image : $legacy_hero_image;
$hero_mobile_image = $hero_mobile_image ? $hero_mobile_image : ( $legacy_hero_mobile_image ? $legacy_hero_mobile_image : $hero_image );

$hero_eyebrow      = sedgemore_travel_field( 'travel_page_hero_eyebrow', 'Sedgemore &nbsp;&middot;&nbsp; Travel' );
$hero_title        = sedgemore_travel_field( 'travel_page_hero_title', 'Some journeys<br><em>change how you see.</em>' );
$hero_text         = sedgemore_travel_field( 'travel_page_hero_text', 'We design travel around people, not itineraries. Every journey begins with a conversation and ends exactly as it should.' );
$hero_button_label = sedgemore_travel_field( 'travel_page_hero_button_label', 'Start Planning' );
$hero_button_url   = sedgemore_travel_field( 'travel_page_hero_button_url', '#conversation' );

$intro_label = sedgemore_travel_field( 'travel_page_intro_label', 'Our approach' );
$intro_title = sedgemore_travel_field( 'travel_page_intro_title', 'We travel with<br>you in mind,<br><em>long before<br>you depart.</em>' );
$intro_body  = sedgemore_travel_field(
	'travel_page_intro_body',
	'<p>Most travel is arranged around destinations. Ours begins with you. The pace at which you move through the world. The kind of morning you want to wake up to. The moments you will still be talking about a year from now.</p><p>Sedgemore is not a booking platform. It is a private travel house, and the distinction matters. Where others confirm reservations, we curate experiences. Where others respond to requests, we anticipate them.</p>'
);
$intro_quote = sedgemore_travel_field( 'travel_page_intro_quote', 'We do not sell travel. We design the conditions for something worth remembering.' );

$service_fallbacks = array(
	array(
		'class'      => 'sc-itineraries',
		'term_slug'  => 'tailored-itineraries',
		'title'      => 'Tailored<br>Itineraries',
		'text'       => 'Some journeys are planned around destinations. Ours begin with the way you want to feel.',
		'link_label' => 'Explore',
		'link_url'   => home_url( '/travel/itineraries/' ),
	),
	array(
		'class'      => 'sc-hotels',
		'term_slug'  => 'hotels-and-resorts',
		'title'      => 'Hotels<br>&amp; Resorts',
		'text'       => 'Not every great hotel belongs on every list. We know the rooms worth having, and the ones worth waiting for.',
		'link_label' => 'View Stays',
		'link_url'   => home_url( '/travel/hotel-resorts/' ),
	),
	array(
		'class'      => 'sc-villas',
		'term_slug'  => 'private-villas',
		'title'      => 'Private<br>Villas',
		'text'       => 'Space, quiet, and the feeling that no one else will be here. Homes chosen for families, for milestones, for longer stays.',
		'link_label' => 'Discover Villas',
		'link_url'   => home_url( '/travel/villa/' ),
	),
	array(
		'class'      => 'sc-yachts',
		'term_slug'  => 'private-yacht-voyages',
		'title'      => 'Private<br>Yacht Voyages',
		'text'       => 'The water changes everything. Distance dissolves. We arrange the vessel, the crew, and the route worth taking.',
		'link_label' => 'Yacht Experiences',
		'link_url'   => home_url( '/travel/private-yachts/' ),
	),
);

$service_rows  = sedgemore_travel_field( 'travel_page_service_cards', array() );
$service_cards = array();

if ( is_array( $service_rows ) && ! empty( $service_rows ) ) {
	foreach ( array_values( $service_rows ) as $index => $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$fallback = $service_fallbacks[ $index ] ?? array(
			'class'      => 'sc-custom',
			'term_slug'  => '',
			'title'      => 'Travel',
			'text'       => '',
			'link_label' => 'Explore',
			'link_url'   => '#conversation',
		);

		$image = sedgemore_travel_asset_url( $row['image'] ?? '' );
		if ( ! $image && ! empty( $fallback['term_slug'] ) ) {
			$image = sedgemore_travel_asset_url( sedgemore_travel_term_field( $fallback['term_slug'], 'image_travel' ) );
		}

		$service_cards[] = array(
			'class'      => $fallback['class'],
			'title'      => ! empty( $row['title'] ) ? $row['title'] : $fallback['title'],
			'text'       => ! empty( $row['text'] ) ? $row['text'] : $fallback['text'],
			'image'      => $image,
			'link_label' => ! empty( $row['link_label'] ) ? $row['link_label'] : $fallback['link_label'],
			'link_url'   => ! empty( $row['link_url'] ) ? $row['link_url'] : $fallback['link_url'],
		);
	}
}

if ( empty( $service_cards ) ) {
	foreach ( $service_fallbacks as $fallback ) {
		$fallback['image'] = sedgemore_travel_asset_url( sedgemore_travel_term_field( $fallback['term_slug'], 'image_travel' ) );
		$service_cards[]   = $fallback;
	}
}

$services_label = sedgemore_travel_field( 'travel_page_services_label', 'How we travel' );
$services_title = sedgemore_travel_field( 'travel_page_services_title', 'Four ways to move<br>through the world <em>well.</em>' );

$narrative_title = sedgemore_travel_field( 'travel_page_narrative_title', "The world's finest places<br>are rarely found.<br>They are introduced." );
$narrative_body  = sedgemore_travel_field(
	'travel_page_narrative_body',
	'<p>Access is not something we advertise. It is something we have cultivated, quietly, over years spent in the right rooms, at the right tables, with the right people. Our clients travel further and deeper than most, not because of what they spend, but because of who we know.</p>'
);
$narrative_attr  = sedgemore_travel_field( 'travel_page_narrative_attr', 'Sedgemore Travel &nbsp;&middot;&nbsp; United Kingdom' );

$properties_title = sedgemore_travel_field( 'travel_page_properties_title', 'Properties we<br>know <em>firsthand.</em>' );
$properties_text  = sedgemore_travel_field( 'travel_page_properties_text', 'Not a curated list. Not a rate agreement. These are the places we have placed clients, returned to ourselves, and chosen not to remove.' );
$property_logos   = sedgemore_travel_field(
	'travel_page_property_logos',
	array(
		array( 'label' => 'Four Seasons' ),
		array( 'label' => 'Belmond' ),
		array( 'label' => 'Dorchester Collection' ),
		array( 'label' => 'Rosewood' ),
	)
);

$reasons_label = sedgemore_travel_field( 'travel_page_reasons_label', 'For those who notice the difference' );
$reasons_title = sedgemore_travel_field( 'travel_page_reasons_title', 'What makes a<br>journey <em>feel right.</em>' );
$reasons_text  = sedgemore_travel_field( 'travel_page_reasons_text', 'It is rarely the headline hotel or the famous coastline. It is everything else. The timing. The introductions. The space left for the unplanned.' );
$reasons       = sedgemore_travel_field(
	'travel_page_reasons',
	array(
		array(
			'number' => '01',
			'title'  => '<em>Access</em> over attention',
			'text'   => 'We have spent years in the right rooms so that you do not have to. Private openings, closed restaurants, estate access, and introductions that cannot be bought, only earned.',
		),
		array(
			'number' => '02',
			'title'  => 'One person,<br><em>always</em>',
			'text'   => 'Not a call centre. Not a ticketing system. One specialist who knows your preferences, anticipates your needs, and is available when it matters.',
		),
		array(
			'number' => '03',
			'title'  => 'Designed for<br><em>your pace</em>',
			'text'   => 'Some travellers want every hour filled. Others need the itinerary to breathe. We design for the way you actually travel, not the way most people do.',
		),
	)
);

$testimonial_quote = sedgemore_travel_field( 'travel_page_testimonial_quote', 'Every journey Sedgemore has arranged for us has felt genuinely considered. They knew what we wanted before we did.' );
$testimonial_attr  = sedgemore_travel_field( 'travel_page_testimonial_attr', 'Private client' );

$prive_label        = sedgemore_travel_field( 'travel_page_prive_label', 'For those who prefer access over attention' );
$prive_title        = sedgemore_travel_field( 'travel_page_prive_title', 'Sedgemore<br><em>Prive.</em>' );
$prive_text         = sedgemore_travel_field( 'travel_page_prive_text', 'A private tier for clients whose travel demands a different kind of continuity. Not more service. A different quality of it altogether. Prive is for those who travel often, quietly, and well.' );
$prive_button_label = sedgemore_travel_field( 'travel_page_prive_button_label', 'Discover Prive' );
$prive_button_url   = sedgemore_travel_field( 'travel_page_prive_button_url', home_url( '/membership/' ) );
$prive_features     = sedgemore_travel_field(
	'travel_page_prive_features',
	array(
		array(
			'title' => 'Rooms worth waiting for',
			'text'  => 'Waitlisted properties, closed seasons, and last rooms held. Prive members travel when others cannot.',
		),
		array(
			'title' => 'One contact, always',
			'text'  => 'A single specialist who knows your life, not just your preferences. Available when it matters.',
		),
		array(
			'title' => 'A curated world',
			'text'  => "Monthly intelligence on the world's most considered openings, tables, and invitations, before they become known.",
		),
		array(
			'title' => 'Absolute discretion',
			'text'  => 'Everything we arrange remains ours to hold. No directories, no guest lists, no public profiles.',
		),
	)
);

$closing_label        = sedgemore_travel_field( 'travel_page_closing_label', 'The beginning' );
$closing_title        = sedgemore_travel_field( 'travel_page_closing_title', 'Tell us what<br>you are <em>imagining.</em>' );
$closing_text         = sedgemore_travel_field( 'travel_page_closing_text', 'There is no form to submit and no timeline to follow. Share what you have in mind, however vague, and one of our specialists will be in touch to explore it with you.' );
$closing_note         = sedgemore_travel_field( 'travel_page_closing_note', 'Most of our best journeys began with a sentence or two.' );
$closing_submit_label = sedgemore_travel_field( 'travel_page_closing_submit_label', 'Share What Inspires You' );
$interest_options     = sedgemore_travel_field(
	'travel_page_interest_options',
	array(
		array( 'label' => 'A tailored journey', 'value' => 'itinerary' ),
		array( 'label' => 'Hotels & resorts', 'value' => 'hotels' ),
		array( 'label' => 'A private villa', 'value' => 'villa' ),
		array( 'label' => 'A yacht voyage', 'value' => 'yacht' ),
		array( 'label' => 'Sedgemore Prive', 'value' => 'prive' ),
		array( 'label' => 'Not sure yet', 'value' => 'notyet' ),
	)
);
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

<style>
.header_bright,
.divider_sharp_bright {
	display: none !important;
}

.divider_sharp_dark {
	display: inline-block !important;
}

.header_nav_fixed {
	background: rgba(250, 248, 245, 0.96);
}

.travel-page,
.travel-page *,
.travel-page *::before,
.travel-page *::after {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

.travel-page {
	--ivory: #F5F2EE;
	--warm-white: #FAF8F5;
	--dark: #1C1A18;
	--charcoal: #2E2C29;
	--mid: #6B6560;
	--gold: #B8955A;
	--gold-light: #D4B483;
	--border: rgba(28, 26, 24, 0.12);
	--border-light: rgba(28, 26, 24, 0.07);
	--ff-display: 'Cormorant Garamond', Georgia, serif;
	--ff-body: 'Jost', sans-serif;

	background: var(--warm-white);
	color: var(--dark);
	font-family: var(--ff-body);
	font-weight: 300;
	-webkit-font-smoothing: antialiased;
	overflow-x: hidden;
}

.travel-page img {
	display: block;
	max-width: 100%;
}

.travel-page .hero {
	position: relative;
	height: 96vh;
	min-height: 680px;
	overflow: hidden;
	display: flex;
	align-items: flex-end;
	padding: 0 72px 104px;
}

.travel-page .hero-picture {
	position: absolute;
	inset: 0;
	width: 100%;
	height: 100%;
}

.travel-page .hero-bg {
	position: absolute;
	inset: 0;
	width: 100%;
	height: 100%;
	object-fit: cover;
	background: linear-gradient(155deg, #C9B99A 0%, #A89070 35%, #7A6A52 70%, #5A4D3A 100%);
}

.travel-page .hero-overlay {
	position: absolute;
	inset: 0;
	background: linear-gradient(
		to bottom,
		rgba(20, 18, 14, 0.05) 0%,
		rgba(20, 18, 14, 0.18) 45%,
		rgba(20, 18, 14, 0.72) 100%
	);
}

.travel-page .hero-content {
	position: relative;
	z-index: 2;
	max-width: 680px;
}

.travel-page .hero-eyebrow {
	font-family: var(--ff-body);
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.3em;
	text-transform: uppercase;
	color: rgba(255, 255, 255, 0.45);
	margin-bottom: 24px;
	display: block;
}

.travel-page .hero h1 {
	font-family: var(--ff-display);
	font-size: clamp(52px, 6.5vw, 88px);
	font-weight: 300;
	font-style: italic;
	color: #fff;
	line-height: 1.04;
	margin-bottom: 28px;
	letter-spacing: -0.01em;
}

.travel-page .hero-sub {
	font-family: var(--ff-body);
	font-size: 15px;
	font-weight: 300;
	color: rgba(255, 255, 255, 0.65);
	line-height: 1.82;
	max-width: 440px;
	margin-bottom: 48px;
	letter-spacing: 0.02em;
}

.travel-page .btn-primary {
	font-family: var(--ff-body);
	font-size: 11px;
	font-weight: 400;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	background: var(--dark);
	color: #fff;
	border: 1px solid var(--dark);
	padding: 16px 40px;
	text-decoration: none;
	cursor: pointer;
	transition: background 0.3s, color 0.3s;
	display: inline-block;
}

.travel-page .btn-primary:hover {
	background: #fff;
	color: var(--dark);
}

.travel-page .section-label {
	font-family: var(--ff-body);
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.28em;
	text-transform: uppercase;
	color: var(--gold);
	margin-bottom: 20px;
	display: block;
}

.travel-page .philosophy {
	padding: 120px 72px;
	background: var(--warm-white);
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 100px;
	align-items: center;
	max-width: 1400px;
	margin: 0 auto;
}

.travel-page .philosophy-left h2 {
	font-family: var(--ff-display);
	font-size: clamp(40px, 4.2vw, 60px);
	font-weight: 300;
	line-height: 1.1;
	color: var(--dark);
	letter-spacing: -0.01em;
	margin-bottom: 0;
}

.travel-page .philosophy-left h2 em {
	font-style: italic;
}

.travel-page .philosophy-right p {
	font-size: 16px;
	font-weight: 300;
	color: var(--mid);
	line-height: 1.88;
	letter-spacing: 0.02em;
	margin-bottom: 22px;
}

.travel-page .philosophy-right p:last-child {
	margin-bottom: 0;
}

.travel-page .philosophy-divider {
	display: none;
}

.travel-page .philosophy-quote {
	font-family: var(--ff-display);
	font-size: 24px;
	font-weight: 400;
	font-style: italic;
	color: var(--dark);
	line-height: 1.58;
	padding-left: 22px;
	border-left: 1px solid var(--gold);
	margin-top: 32px;
}

.travel-page .services {
	padding: 0 72px 112px;
	background: var(--warm-white);
}

.travel-page .services-header {
	padding-bottom: 52px;
}

.travel-page .services-header h2 {
	font-family: var(--ff-display);
	font-size: clamp(34px, 3.5vw, 48px);
	font-weight: 300;
	color: var(--dark);
	line-height: 1.15;
	max-width: 560px;
}

.travel-page .services-header h2 em {
	font-style: italic;
}

.travel-page .services-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
	gap: 2px;
}

.travel-page .service-card {
	position: relative;
	overflow: hidden;
	aspect-ratio: 3 / 4;
	cursor: pointer;
	display: block;
	color: inherit;
	text-decoration: none;
	background: #c4b29b;
}

.travel-page .service-card-img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
	display: block;
}

.travel-page .sc-itineraries .service-card-img {
	background: linear-gradient(160deg, #C4A882 0%, #8B6E4E 100%);
}

.travel-page .sc-hotels .service-card-img {
	background: linear-gradient(160deg, #A8B89C 0%, #5A7A52 100%);
}

.travel-page .sc-villas .service-card-img {
	background: linear-gradient(160deg, #94A8B4 0%, #3D6070 100%);
}

.travel-page .sc-yachts .service-card-img {
	background: linear-gradient(160deg, #7A8FA0 0%, #2D4A5E 100%);
}

.travel-page .service-card:hover .service-card-img {
	transform: scale(1.07);
}

.travel-page .service-card-overlay {
	position: absolute;
	inset: 0;
	background: linear-gradient(to top, rgba(10, 8, 5, 0.92) 0%, rgba(10, 8, 5, 0.48) 50%, rgba(10, 8, 5, 0.06) 100%);
	display: flex;
	flex-direction: column;
	justify-content: flex-end;
	padding: 38px 32px;
}

.travel-page .service-card h3 {
	font-family: var(--ff-display);
	font-size: 24px;
	font-weight: 400;
	color: #fff;
	line-height: 1.2;
	margin-bottom: 12px;
}

.travel-page .service-card p {
	font-family: var(--ff-body);
	font-size: 13px;
	font-weight: 300;
	color: rgba(255, 255, 255, 0.78);
	line-height: 1.7;
	margin-bottom: 22px;
	max-width: 230px;
	opacity: 0;
	transform: translateY(10px);
	transition: opacity 0.4s ease, transform 0.4s ease;
}

.travel-page .service-card:hover p {
	opacity: 1;
	transform: translateY(0);
}

.travel-page .service-card-link {
	font-family: var(--ff-body);
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: var(--gold-light);
	text-decoration: none;
	display: flex;
	align-items: center;
	gap: 10px;
	transition: gap 0.3s;
}

.travel-page .service-card:hover .service-card-link {
	gap: 16px;
}

.travel-page .service-card-link::after {
	content: '\2192';
	font-size: 14px;
}

.travel-page .narrative {
	background: var(--dark);
	padding: 100px 72px;
	text-align: center;
}

.travel-page .narrative-inner {
	max-width: 760px;
	margin: 0 auto;
}

.travel-page .narrative h2 {
	font-family: var(--ff-display);
	font-size: clamp(36px, 4vw, 58px);
	font-weight: 300;
	font-style: italic;
	color: #fff;
	line-height: 1.22;
	margin-bottom: 32px;
	letter-spacing: -0.01em;
}

.travel-page .narrative p {
	font-size: 15px;
	font-weight: 300;
	color: rgba(255, 255, 255, 0.52);
	line-height: 1.85;
	letter-spacing: 0.02em;
	margin-bottom: 16px;
}

.travel-page .narrative-rule {
	width: 40px;
	height: 1px;
	background: var(--gold);
	margin: 40px auto;
}

.travel-page .narrative-attr {
	font-size: 11px;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: rgba(255, 255, 255, 0.25);
}

.travel-page .previously {
	background: var(--warm-white);
	padding: 80px 72px;
	border-top: 1px solid var(--border);
	border-bottom: 1px solid var(--border);
}

.travel-page .previously-inner {
	max-width: 1280px;
	margin: 0 auto;
	display: grid;
	grid-template-columns: 300px 1fr;
	gap: 72px;
	align-items: center;
}

.travel-page .previously-text {
	border-right: 1px solid var(--border);
	padding-right: 72px;
}

.travel-page .previously-text h3 {
	font-family: var(--ff-display);
	font-size: 28px;
	font-weight: 300;
	color: var(--dark);
	line-height: 1.28;
	margin-bottom: 12px;
}

.travel-page .previously-text h3 em {
	font-style: italic;
}

.travel-page .previously-text p {
	font-size: 13px;
	font-weight: 300;
	color: var(--mid);
	line-height: 1.78;
}

.travel-page .previously-logos {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
	align-items: center;
    gap: 0 5rem;
    justify-content: center;
	width: 100%;
}

.travel-page .prev-logo {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	min-height: 72px;
	font-family: var(--ff-display);
	font-size: 15px;
	font-weight: 400;
	letter-spacing: 0.1em;
	color: rgba(28, 26, 24, 0.35);
	text-transform: uppercase;
	transition: color 0.3s;
	cursor: default;
}

.travel-page .prev-logo img {
	display: block;
	width: auto;
	max-width: 150px;
	object-fit: contain;
	filter: grayscale(1);
	opacity: 0.55;
	transition: filter 0.3s, opacity 0.3s;
}

.travel-page .prev-logo:hover {
	color: var(--dark);
}

.travel-page .prev-logo:hover img {
	filter: grayscale(0);
	opacity: 1;
}

.travel-page .reasons {
	padding: 112px 72px;
	background: var(--ivory);
}

.travel-page .reasons-header {
	text-align: center;
	max-width: 560px;
	margin: 0 auto 80px;
}

.travel-page .reasons-header h2 {
	font-family: var(--ff-display);
	font-size: clamp(36px, 3.5vw, 52px);
	font-weight: 300;
	color: var(--dark);
	line-height: 1.15;
	margin-bottom: 16px;
}

.travel-page .reasons-header h2 em {
	font-style: italic;
}

.travel-page .reasons-header p {
	font-size: 15px;
	font-weight: 300;
	color: var(--mid);
	line-height: 1.75;
}

.travel-page .reasons-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 48px;
	max-width: 1280px;
	margin: 0 auto;
}

.travel-page .reason-num {
	font-family: var(--ff-display);
	font-size: 44px !important;
	font-weight: 400;
	color: var(--dark);
	opacity: 0.25;
	line-height: 1;
	margin-bottom: 20px;
	letter-spacing: -0.02em;
	display: block;
}

.travel-page .reason-cell h3 {
	font-family: var(--ff-display);
	font-size: 22px;
	font-weight: 400;
	color: var(--dark);
	margin-bottom: 14px;
	line-height: 1.2;
}

.travel-page .reason-cell h3 em {
	font-style: italic;
}

.travel-page .reason-cell p {
	font-size: 14px;
	font-weight: 300;
	color: var(--mid);
	line-height: 1.8;
}

.travel-page .testimonial {
	background: var(--warm-white);
	padding: 100px 72px;
}

.travel-page .testimonial-inner {
	max-width: 820px;
	margin: 0 auto;
	text-align: center;
}

.travel-page .testimonial-mark {
	font-family: var(--ff-display);
	font-size: 80px;
	font-weight: 300;
	color: var(--gold);
	opacity: 0.25;
	line-height: 0.6;
	margin-bottom: 36px;
	display: block;
}

.travel-page .testimonial blockquote {
	font-family: var(--ff-display);
	font-size: clamp(22px, 2.8vw, 32px);
	font-weight: 300;
	font-style: italic;
	color: var(--dark);
	line-height: 1.56;
	margin-bottom: 36px;
	letter-spacing: -0.01em;
}

.travel-page .testimonial-attr {
	font-size: 11px;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: var(--mid);
	opacity: 0.6;
}

.travel-page .prive {
	background: var(--charcoal);
	padding: 96px 72px;
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 88px;
	align-items: center;
}

.travel-page .prive-text .section-label {
	color: var(--gold);
}

.travel-page .prive-text h2 {
	font-family: var(--ff-display);
	font-size: clamp(34px, 3.2vw, 48px);
	font-weight: 300;
	color: #fff;
	line-height: 1.14;
	margin-bottom: 22px;
}

.travel-page .prive-text h2 em {
	font-style: italic;
}

.travel-page .prive-text > p {
	font-size: 15px;
	font-weight: 300;
	color: rgba(255, 255, 255, 0.55);
	line-height: 1.85;
	max-width: 460px;
	margin-bottom: 40px;
}

.travel-page .prive-features {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 36px;
}

.travel-page .prive-feat {
	border-top: 1px solid rgba(255, 255, 255, 0.08);
	padding-top: 22px;
}

.travel-page .prive-feat-title {
	font-family: var(--ff-display);
	font-size: 18px;
	font-weight: 400;
	color: #fff;
	margin-bottom: 10px;
	line-height: 1.2;
}

.travel-page .prive-feat p {
	font-size: 13px;
	font-weight: 300;
	color: rgba(255, 255, 255, 0.38);
	line-height: 1.75;
}

.travel-page .closing {
	padding: 112px 72px;
	background: var(--warm-white);
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 88px;
	align-items: start;
}

.travel-page .closing-text h2 {
	font-family: var(--ff-display);
	font-size: clamp(36px, 3.8vw, 54px);
	font-weight: 300;
	color: var(--dark);
	line-height: 1.1;
	margin-bottom: 22px;
	letter-spacing: -0.01em;
}

.travel-page .closing-text h2 em {
	font-style: italic;
}

.travel-page .closing-text p {
	font-size: 15px;
	font-weight: 300;
	color: var(--mid);
	line-height: 1.85;
	letter-spacing: 0.02em;
	margin-bottom: 14px;
}

.travel-page .form-group {
	margin-bottom: 22px;
}

.travel-page .form-group-label,
.travel-page .form-group label {
	display: block;
	font-family: var(--ff-body);
	font-size: 10px;
	font-weight: 400;
	letter-spacing: 0.22em;
	text-transform: uppercase;
	color: var(--mid);
	margin-bottom: 10px;
}

.travel-page .form-group input,
.travel-page .form-group select,
.travel-page .form-group textarea {
	width: 100%;
	background: transparent;
	border: none;
	border-bottom: 1px solid var(--border);
	outline: none;
	padding: 12px 0;
	font-family: var(--ff-body);
	font-size: 14px;
	font-weight: 300;
	color: var(--dark);
	letter-spacing: 0.02em;
	transition: border-color 0.3s;
	appearance: none;
	border-radius: 0;
	box-shadow: none;
}

.travel-page .form-group input:focus,
.travel-page .form-group select:focus,
.travel-page .form-group textarea:focus {
	border-color: var(--gold);
}

.travel-page .form-group input::placeholder,
.travel-page .form-group textarea::placeholder {
	color: rgba(28, 26, 24, 0.25);
}

.travel-page .form-group textarea {
	resize: none;
	height: 88px;
}

.travel-page .form-2col {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 24px;
}

.travel-page .interest-options {
	display: grid;
	grid-template-columns: 1fr 1fr;
	column-gap: 80px;
	margin-top: 20px;
	padding-top: 24px;
	border-top: 1px solid rgba(28, 26, 24, 0.12);
}

.travel-page .interest-opt {
	display: flex;
	align-items: center;
	gap: 12px;
	cursor: pointer;
	user-select: none;
}

.travel-page .interest-opt input[type="checkbox"] {
	position: static;
	opacity: 1;
	width: 16px;
	height: 16px;
	min-width: 16px;
	margin: 0;
	padding: 0;
	pointer-events: auto;
	appearance: auto;
	accent-color: #2e2e2e;
	border: 1px solid rgba(28, 26, 24, 0.25);
}

.travel-page .interest-opt-box {
	display: none;
}

.travel-page .form-submit {
	width: 100%;
	background: var(--dark);
	border: 1px solid var(--dark);
	color: #fff;
	padding: 18px;
	font-family: var(--ff-body);
	font-size: 11px;
	font-weight: 400;
	letter-spacing: 0.2em;
	text-transform: uppercase;
	cursor: pointer;
	margin-top: 28px;
	transition: background 0.3s, color 0.3s;
}

.travel-page .form-submit:hover {
	background: #fff;
	color: var(--dark);
	border: 1px solid var(--dark);
}

.travel-page .form-submit[disabled],
.travel-page .form-submit[aria-busy="true"] {
	cursor: default;
	opacity: 0.8;
	pointer-events: none;
}

.travel-page .form-message {
	min-height: 22px;
	margin-top: 16px;
	color: var(--mid);
	font-size: 13px;
	line-height: 1.5;
}

.travel-page .form-message.success {
	color: #2f6b3d;
}

.travel-page .form-message.error {
	color: #9a4b43;
}

.travel-page .reveal {
	opacity: 0;
	transform: translateY(24px);
	transition: opacity 0.8s ease, transform 0.8s ease;
}

.travel-page .reveal.visible {
	opacity: 1;
	transform: translateY(0);
}

.travel-page .reveal-delay-1 {
	transition-delay: 0.15s;
}

.travel-page .reveal-delay-2 {
	transition-delay: 0.3s;
}

@media (max-width: 1024px) {
	.travel-page .hero {
		padding: 0 40px 88px;
	}

	.travel-page .philosophy {
		padding: 88px 40px;
		grid-template-columns: 1fr;
		gap: 48px;
	}

	.travel-page .services {
		padding: 0 40px 88px;
	}

	.travel-page .services-grid {
		grid-template-columns: repeat(2, 1fr);
	}

	.travel-page .narrative {
		padding: 80px 40px;
	}

	.travel-page .previously {
		padding: 64px 40px;
	}

	.travel-page .previously-inner {
		grid-template-columns: 1fr;
		gap: 36px;
	}

	.travel-page .previously-text {
		border-right: none;
		border-bottom: 1px solid var(--border);
		padding-right: 0;
		padding-bottom: 32px;
	}

	.travel-page .reasons {
		padding: 88px 40px;
	}

	.travel-page .reasons-grid {
		grid-template-columns: 1fr 1fr;
	}

	.travel-page .testimonial {
		padding: 80px 40px;
	}

	.travel-page .prive {
		padding: 80px 40px;
		grid-template-columns: 1fr;
		gap: 56px;
	}

	.travel-page .closing {
		padding: 88px 40px;
		grid-template-columns: 1fr;
		gap: 56px;
	}
}

@media (max-width: 640px) {
	.travel-page .hero {
		padding: 0 24px 72px;
	}

	.travel-page .services-grid,
	.travel-page .reasons-grid,
	.travel-page .prive-features,
	.travel-page .interest-options,
	.travel-page .form-2col {
		grid-template-columns: 1fr;
	}
}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="travel-page">
	<section class="hero">
		<?php if ( $hero_image ) : ?>
			<picture class="hero-picture">
				<source srcset="<?php echo esc_url( $hero_image ); ?>" media="(min-width: 750px)">
				<img class="hero-bg" src="<?php echo esc_url( $hero_mobile_image ? $hero_mobile_image : $hero_image ); ?>" alt="">
			</picture>
		<?php else : ?>
			<div class="hero-bg" aria-hidden="true"></div>
		<?php endif; ?>
		<div class="hero-overlay"></div>
		<div class="hero-content">
			<span class="hero-eyebrow"><?php echo wp_kses_post( $hero_eyebrow ); ?></span>
			<h1><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="hero-sub"><?php echo esc_html( $hero_text ); ?></p>
			<a href="<?php echo esc_url( $hero_button_url ); ?>" class="btn-primary"><?php echo esc_html( $hero_button_label ); ?></a>
		</div>
	</section>

	<section>
		<div class="philosophy reveal">
			<div class="philosophy-left">
				<span class="section-label"><?php echo esc_html( $intro_label ); ?></span>
				<h2><?php echo wp_kses_post( $intro_title ); ?></h2>
			</div>
			<div class="philosophy-right">
				<?php echo wp_kses_post( $intro_body ); ?>
				<div class="philosophy-divider"></div>
				<p class="philosophy-quote"><?php echo esc_html( $intro_quote ); ?></p>
			</div>
		</div>
	</section>

	<section class="services" id="services">
		<div class="services-header reveal">
			<span class="section-label"><?php echo esc_html( $services_label ); ?></span>
			<h2><?php echo wp_kses_post( $services_title ); ?></h2>
		</div>
		<div class="services-grid">
			<?php foreach ( $service_cards as $index => $card ) : ?>
				<a class="service-card <?php echo esc_attr( $card['class'] ); ?> reveal<?php echo $index ? ' reveal-delay-' . esc_attr( min( $index, 2 ) ) : ''; ?>" href="<?php echo esc_url( $card['link_url'] ); ?>">
					<?php if ( ! empty( $card['image'] ) ) : ?>
						<img class="service-card-img" src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $card['title'] ) ); ?>">
					<?php else : ?>
						<div class="service-card-img" aria-hidden="true"></div>
					<?php endif; ?>
					<div class="service-card-overlay">
						<h3><?php echo wp_kses_post( $card['title'] ); ?></h3>
						<p><?php echo esc_html( $card['text'] ); ?></p>
						<span class="service-card-link"><?php echo esc_html( $card['link_label'] ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="narrative">
		<div class="narrative-inner reveal">
			<h2><?php echo wp_kses_post( $narrative_title ); ?></h2>
			<div class="narrative-rule"></div>
			<?php echo wp_kses_post( $narrative_body ); ?>
			<p class="narrative-attr"><?php echo wp_kses_post( $narrative_attr ); ?></p>
		</div>
	</section>

	<div class="previously">
		<div class="previously-inner reveal">
			<div class="previously-text">
				<h3><?php echo wp_kses_post( $properties_title ); ?></h3>
				<p><?php echo esc_html( $properties_text ); ?></p>
			</div>
			<div class="previously-logos">
				<?php foreach ( (array) $property_logos as $logo ) : ?>
					<?php
					$logo_label = is_array( $logo ) ? ( $logo['label'] ?? '' ) : $logo;
					$logo_image = is_array( $logo ) ? sedgemore_travel_asset_url( $logo['image'] ?? '', 'medium' ) : '';
					?>
					<?php if ( $logo_image || $logo_label ) : ?>
						<span class="prev-logo">
							<?php if ( $logo_image ) : ?>
								<img src="<?php echo esc_url( $logo_image ); ?>" alt="<?php echo esc_attr( $logo_label ); ?>" loading="lazy">
							<?php else : ?>
								<?php echo esc_html( $logo_label ); ?>
							<?php endif; ?>
						</span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<section class="reasons">
		<div class="reasons-header reveal">
			<span class="section-label"><?php echo esc_html( $reasons_label ); ?></span>
			<h2><?php echo wp_kses_post( $reasons_title ); ?></h2>
			<p><?php echo esc_html( $reasons_text ); ?></p>
		</div>
		<div class="reasons-grid">
			<?php foreach ( (array) $reasons as $index => $reason ) : ?>
				<div class="reason-cell reveal<?php echo $index ? ' reveal-delay-' . esc_attr( min( $index, 2 ) ) : ''; ?>">
					<p class="reason-num"><?php echo esc_html( $reason['number'] ?? '' ); ?></p>
					<h3><?php echo wp_kses_post( $reason['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $reason['text'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="prive" id="prive">
		<div class="prive-text reveal">
			<span class="section-label"><?php echo esc_html( $prive_label ); ?></span>
			<h2><?php echo wp_kses_post( $prive_title ); ?></h2>
			<p><?php echo esc_html( $prive_text ); ?></p>
			<a href="<?php echo esc_url( $prive_button_url ); ?>" class="btn-primary"><?php echo esc_html( $prive_button_label ); ?></a>
		</div>
		<div class="prive-features reveal reveal-delay-1">
			<?php foreach ( (array) $prive_features as $feature ) : ?>
				<div class="prive-feat">
					<p class="prive-feat-title"><?php echo esc_html( $feature['title'] ?? '' ); ?></p>
					<p><?php echo esc_html( $feature['text'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="closing" id="conversation">
		<div class="closing-text reveal">
			<span class="section-label"><?php echo esc_html( $closing_label ); ?></span>
			<h2><?php echo wp_kses_post( $closing_title ); ?></h2>
			<p><?php echo esc_html( $closing_text ); ?></p>
			<p><?php echo esc_html( $closing_note ); ?></p>
		</div>
		<form id="travel-enquiry-form" class="closing-form reveal reveal-delay-1" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
			<input type="hidden" name="action" value="home_form">
			<input type="hidden" name="form_title" value="Travel Request">
			<input type="hidden" name="form_heading" value="travel enquiry details">
			<?php wp_nonce_field( 'home_nonce_action', 'home_nonce' ); ?>

			<div class="form-group">
				<p class="form-group-label">What draws you to travel right now?</p>
				<div class="interest-options">
					<?php foreach ( (array) $interest_options as $index => $interest ) : ?>
						<?php
						$interest_label = is_array( $interest ) ? ( $interest['label'] ?? '' ) : '';
						$interest_value = is_array( $interest ) ? ( $interest['value'] ?? '' ) : '';
						$interest_value = $interest_value ? $interest_value : sanitize_title( $interest_label );
						if ( ! $interest_label || ! $interest_value ) {
							continue;
						}
						$interest_id = 'travel_interest_' . $index . '_' . sanitize_title( $interest_value );
						?>
						<label class="interest-opt" for="<?php echo esc_attr( $interest_id ); ?>">
							<input id="<?php echo esc_attr( $interest_id ); ?>" type="checkbox" name="topic[]" value="<?php echo esc_attr( $interest_value ); ?>">
							<span class="interest-opt-box"></span>
							<span class="interest-opt-label"><?php echo esc_html( $interest_label ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="form-group" style="margin-top: 28px;">
				<label for="travel_destination">Where are you drawn to?</label>
				<input id="travel_destination" type="text" name="destination" placeholder="A place, a region, or an atmosphere...">
			</div>

			<div class="form-2col">
				<div class="form-group">
					<label for="travel_dates">When are you thinking?</label>
					<input id="travel_dates" type="text" name="dates" placeholder="Month, season, or flexible">
				</div>
				<div class="form-group">
					<label for="travel_party">Travelling with</label>
					<input id="travel_party" type="text" name="travelling_with" placeholder="Partner, family, group...">
				</div>
			</div>

			<div class="form-2col">
				<div class="form-group">
					<label for="travel_first_name">First name</label>
					<input id="travel_first_name" type="text" name="first_name" placeholder="Your first name" required>
				</div>
				<div class="form-group">
					<label for="travel_last_name">Last name</label>
					<input id="travel_last_name" type="text" name="last_name" placeholder="Your last name" required>
				</div>
			</div>

			<div class="form-group">
				<label for="travel_email">Email address</label>
				<input id="travel_email" type="email" name="email" placeholder="Where we can reach you" required>
			</div>

			<div class="form-group">
				<label for="travel_message">Anything else worth knowing</label>
				<textarea id="travel_message" name="message" placeholder="A pace, a preference, an occasion, an instinct..." required></textarea>
			</div>

			<div id="travel-form-message" class="form-message" aria-live="polite"></div>
			<button class="form-submit" type="submit"><?php echo esc_html( $closing_submit_label ); ?></button>
		</form>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var reveals = document.querySelectorAll('.travel-page .reveal');

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

	var form = document.getElementById('travel-enquiry-form');
	var message = document.getElementById('travel-form-message');

	if (!form || !message) {
		return;
	}

	form.addEventListener('submit', function (event) {
		event.preventDefault();

		var selectedTopics = form.querySelectorAll('input[name="topic[]"]:checked');
		if (selectedTopics.length === 0) {
			message.textContent = 'Please select at least one interest.';
			message.classList.remove('success');
			message.classList.add('error');
			return;
		}

		if (!form.checkValidity()) {
			message.textContent = 'Please complete all required fields.';
			message.classList.remove('success');
			message.classList.add('error');
			form.reportValidity();
			return;
		}

		message.textContent = '';
		message.classList.remove('success', 'error');

		var submitButton = form.querySelector('.form-submit');
		var originalButtonText = submitButton ? submitButton.textContent : '';
		if (submitButton) {
			submitButton.disabled = true;
			submitButton.textContent = 'Sending...';
			submitButton.setAttribute('aria-busy', 'true');
		}

		var formData = new FormData(form);
		var details = [];
		var destination = form.querySelector('[name="destination"]');
		var dates = form.querySelector('[name="dates"]');
		var travellingWith = form.querySelector('[name="travelling_with"]');
		var messageField = form.querySelector('[name="message"]');
		var originalMessage = messageField ? messageField.value.trim() : '';

		if (destination && destination.value.trim()) {
			details.push('Where drawn to: ' + destination.value.trim());
		}

		if (dates && dates.value.trim()) {
			details.push('Timing: ' + dates.value.trim());
		}

		if (travellingWith && travellingWith.value.trim()) {
			details.push('Travelling with: ' + travellingWith.value.trim());
		}

		if (originalMessage) {
			details.push('Notes: ' + originalMessage);
		}

		formData.set('message', details.join("\n\n"));

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
					submitButton.textContent = originalButtonText || <?php echo wp_json_encode( $closing_submit_label ); ?>;
					submitButton.removeAttribute('aria-busy');
				}
			});
	});
});
</script>

<?php
get_footer();
