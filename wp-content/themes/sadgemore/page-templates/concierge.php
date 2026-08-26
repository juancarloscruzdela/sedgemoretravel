<?php
/**
 * Template Name: Concierge
 *
 * @package sadgemore
 */

get_header();

if ( ! function_exists( 'sedgemore_concierge_asset_url' ) ) {
	function sedgemore_concierge_asset_url( $value, $size = 'full' ) {
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

if ( ! function_exists( 'sedgemore_concierge_field' ) ) {
	function sedgemore_concierge_field( $name, $fallback = '' ) {
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

$hero_slides = sedgemore_concierge_field(
	'concierge_page_hero_slides',
	array(
		array( 'image' => '/wp-content/uploads/2026/06/Concierge-Video-7-scaled.png' ),
		array( 'image' => '/wp-content/uploads/2026/06/Concierge-Video-1-scaled.png' ),
		array( 'image' => '/wp-content/uploads/2026/06/Concierge-Video-2-scaled.png' ),
		array( 'image' => '/wp-content/uploads/2026/06/Concierge-Video-3-scaled.png' ),
		array( 'image' => '/wp-content/uploads/2026/06/Concierge-Video-4-scaled.png' ),
		array( 'image' => '/wp-content/uploads/2026/06/Concierge-Video-5-scaled.png' ),
		array( 'image' => '/wp-content/uploads/2026/06/Concierge-Video-6-scaled.png' ),
	)
);
$hero_slide_urls = array();
foreach ( (array) $hero_slides as $slide ) {
	$slide_url = sedgemore_concierge_asset_url( $slide['image'] ?? $slide, 'full' );
	if ( $slide_url ) {
		$hero_slide_urls[] = $slide_url;
	}
}

if ( empty( $hero_slide_urls ) ) {
	$hero_slide_urls = array( '/wp-content/uploads/2026/06/Concierge-Video-7-scaled.png' );
}

$hero_eyebrow      = sedgemore_concierge_field( 'concierge_page_hero_eyebrow', 'Concierge' );
$hero_title        = sedgemore_concierge_field( 'concierge_page_hero_title', 'Considered support,<br><em>wherever life happens.</em>' );
$hero_text         = sedgemore_concierge_field( 'concierge_page_hero_text', 'A private concierge service for travel, lifestyle, dining, access, and the details that make movement feel effortless.' );
$hero_button_label = sedgemore_concierge_field( 'concierge_page_hero_button_label', 'Speak with Our Team' );
$hero_button_url   = sedgemore_concierge_field( 'concierge_page_hero_button_url', '#enquire' );

$services_label = sedgemore_concierge_field( 'concierge_page_services_label', 'What We Manage' );
$services_title = sedgemore_concierge_field( 'concierge_page_services_title', 'Core<br><em>services.</em>' );
$services_text  = sedgemore_concierge_field( 'concierge_page_services_text', 'Four areas of support, each managed with the same standard of care. From a single reservation to a week of coordinated logistics.' );
$service_cards  = sedgemore_concierge_field(
	'concierge_page_service_cards',
	array(
		array( 'title' => 'Dining &amp;<br>Reservations', 'text' => 'Tables, private rooms, chef introductions, and restaurant access arranged with discretion.', 'image' => '/wp-content/uploads/2026/06/1.MaisonDuCaviar.Paris_.jpg', 'link_label' => 'Enquire', 'link_url' => '#enquire' ),
		array( 'title' => 'Private<br>Shopping', 'text' => 'Appointments, sourcing, styling, and gifting handled quietly through trusted relationships.', 'image' => '/wp-content/uploads/2026/06/2.BeefBarParis.png', 'link_label' => 'Enquire', 'link_url' => '#enquire' ),
		array( 'title' => 'Flights &amp;<br>Upgrades', 'text' => 'Commercial flights, private aviation, upgrades, seat preferences, and disruption support.', 'image' => '/wp-content/uploads/2026/06/3.dollar-gill-BluBsfx4o8o-unsplash-scaled.jpg', 'link_label' => 'Enquire', 'link_url' => '#enquire' ),
		array( 'title' => 'Chauffeured<br>Transfers', 'text' => 'Private drivers, airport movement, hourly hire, and ground logistics across destinations.', 'image' => '/wp-content/uploads/2026/06/4.adrien-vajas-S5mzqeIOBB0-unsplash-scaled.jpg', 'link_label' => 'Enquire', 'link_url' => '#enquire' ),
	)
);

$support_label        = sedgemore_concierge_field( 'concierge_page_support_label', 'Beyond The Essentials' );
$support_title        = sedgemore_concierge_field( 'concierge_page_support_title', 'The requests<br><em>between categories.</em>' );
$support_body         = sedgemore_concierge_field( 'concierge_page_support_body', 'Some requests are simple to name. Others are not. Sedgemore is designed for both: the practical, the personal, the urgent, and the quietly particular.' );
$support_button_label = sedgemore_concierge_field( 'concierge_page_support_button_label', 'Speak with a Specialist' );
$support_button_url   = sedgemore_concierge_field( 'concierge_page_support_button_url', '#enquire' );
$support_items        = sedgemore_concierge_field(
	'concierge_page_support_items',
	array(
		array( 'title' => 'Hotel Coordination', 'text' => 'Suite requests, early check-ins, amenity arrangements, and property introductions handled ahead of arrival.' ),
		array( 'title' => 'Bespoke Itineraries', 'text' => 'Journeys designed around how you prefer to travel. Not templates adapted, but itineraries built from a conversation.' ),
		array( 'title' => 'Private Experiences', 'text' => 'Access to venues, people, and moments that are not listed. Arranged with care, and without fanfare.' ),
		array( 'title' => 'Event Support', 'text' => 'Tickets, access, logistics, and the particular details that make attending a significant occasion feel effortless.' ),
		array( 'title' => 'Lifestyle Requests', 'text' => 'The category that contains everything else. If it matters to you, it matters to us. We ask before we assume.' ),
		array( 'title' => 'Ground Logistics', 'text' => 'International transfers, cross-border coordination, and local arrangements managed ahead of every departure.' ),
	)
);

$process_label = sedgemore_concierge_field( 'concierge_page_process_label', 'How We Work' );
$process_title = sedgemore_concierge_field( 'concierge_page_process_title', 'The same care,<br><em>every time.</em>' );
$process_text  = sedgemore_concierge_field( 'concierge_page_process_text', 'Every request, regardless of scale, moves through the same approach. A dinner reservation and a week-long itinerary receive identical care at each stage.' );
$process_steps = sedgemore_concierge_field(
	'concierge_page_process_steps',
	array(
		array( 'number' => '1', 'title' => 'We Listen First', 'text' => 'Every request begins with a conversation. We ask the right questions before making any arrangements, because the details matter.' ),
		array( 'number' => '2', 'title' => 'We Work Discreetly', 'text' => 'Our work happens in the background. We do not create noise. We simply ensure that things are in place before you need them.' ),
		array( 'number' => '3', 'title' => 'We Confirm Calmly', 'text' => 'Clear, concise updates. No unnecessary messages. You hear from us when something is confirmed or when something has changed.' ),
		array( 'number' => '4', 'title' => 'We Remain Available', 'text' => 'Before, during, and after. Our team is reachable throughout, to adapt, adjust, and handle whatever may arise.' ),
	)
);

$membership_label        = sedgemore_concierge_field( 'concierge_page_membership_label', 'Sedgemore Priv&eacute;' );
$membership_title        = sedgemore_concierge_field( 'concierge_page_membership_title', 'For those who prefer<br><em>a standing arrangement.</em>' );
$membership_body         = sedgemore_concierge_field( 'concierge_page_membership_body', 'Sedgemore Privé is a quiet membership for clients who want consistent, prioritised support across travel, lifestyle, and events. Fewer introductions. Deeper familiarity. The same team, across every request.' );
$membership_button_label = sedgemore_concierge_field( 'concierge_page_membership_button_label', 'Learn About Membership' );
$membership_button_url   = sedgemore_concierge_field( 'concierge_page_membership_button_url', '#' );
$membership_note         = sedgemore_concierge_field( 'concierge_page_membership_note', 'Membership is by introduction and application only.' );

$enquire_label               = sedgemore_concierge_field( 'concierge_page_enquire_label', 'Contact' );
$enquire_title               = sedgemore_concierge_field( 'concierge_page_enquire_title', 'Here when<br><em>needed.</em>' );
$enquire_body                = sedgemore_concierge_field( 'concierge_page_enquire_body', 'Speak with our concierge team for tailored assistance, at home or while travelling. Every enquiry is handled with care and discretion.' );
$enquire_service_label       = sedgemore_concierge_field( 'concierge_page_enquire_service_label', 'Service' );
$enquire_service_placeholder = sedgemore_concierge_field( 'concierge_page_enquire_service_placeholder', 'What can we assist with?' );
$enquire_message_placeholder = sedgemore_concierge_field( 'concierge_page_enquire_message_placeholder', "Tell us what you have in mind. As much or as little as you'd like." );
$enquire_submit_label        = sedgemore_concierge_field( 'concierge_page_enquire_submit_label', 'Send Enquiry' );
$enquire_privacy             = sedgemore_concierge_field( 'concierge_page_enquire_privacy', 'All enquiries are handled in confidence. We do not share personal information with third parties.' );
$enquire_service_options     = sedgemore_concierge_field(
	'concierge_page_enquire_service_options',
	array(
		array( 'label' => 'Dining &amp; Reservations', 'value' => 'Dining & Reservations' ),
		array( 'label' => 'Private Shopping', 'value' => 'Private Shopping' ),
		array( 'label' => 'Flights &amp; Upgrades', 'value' => 'Flights & Upgrades' ),
		array( 'label' => 'Chauffeured Transfers', 'value' => 'Chauffeured Transfers' ),
		array( 'label' => 'Hotel Coordination', 'value' => 'Hotel Coordination' ),
		array( 'label' => 'Bespoke Itinerary', 'value' => 'Bespoke Itinerary' ),
		array( 'label' => 'Private Experiences', 'value' => 'Private Experiences' ),
		array( 'label' => 'Event Support', 'value' => 'Event Support' ),
		array( 'label' => 'Lifestyle Requests', 'value' => 'Lifestyle Requests' ),
		array( 'label' => 'Sedgemore Privé Membership', 'value' => 'Sedgemore Privé Membership' ),
		array( 'label' => 'Something else', 'value' => 'Something else' ),
	)
);
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

<style>
.header_bright{display:block}.header_dark{display:none}.header_nav_fixed{background:#f1eeea}.divider_sharp_bright{display:none!important}.divider_sharp_dark{display:inline-block!important}
.concierge-page,.concierge-page *,.concierge-page *::before,.concierge-page *::after{box-sizing:border-box;margin:0;padding:0}
.concierge-page{--cream:#F5F2EC;--warm-white:#FAF8F4;--charcoal:#2C2A27;--mid:#6B6560;--light:#B8B0A6;--gold:#9A8B6E;--gold-light:#C4B48A;--dark:#1A1814;--border:rgba(154,139,110,.2);background:var(--cream);color:var(--charcoal);font-family:'Montserrat',sans-serif;font-weight:300;font-size:15px;overflow-x:clip;-webkit-font-smoothing:antialiased}
.concierge-page a{text-decoration:none}.concierge-page img{display:block;max-width:100%}
.concierge-page .hero{position:relative;height:100vh;min-height:700px;display:flex;flex-direction:column;justify-content:flex-end;overflow:hidden}
.concierge-page .hero-slideshow,.concierge-page .hero-slide,.concierge-page .hero-gradient{position:absolute;inset:0}
.concierge-page .hero-slide{background-size:cover;background-position:center;opacity:0;transition:opacity 1.2s ease-in-out}
.concierge-page .hero-slide.active{opacity:1}
.concierge-page .hero-gradient{background:linear-gradient(to bottom,transparent 40%,rgba(20,18,14,.5) 70%,rgba(20,18,14,.85) 100%)}
.concierge-page .hero-pagination{position:absolute;right:40px;top:50%;transform:translateY(-50%);z-index:10;display:flex;flex-direction:column;align-items:center;gap:10px}
.concierge-page .hero-dot{width:1px;height:24px;background:rgba(245,242,236,.25);cursor:pointer;transition:background .3s,height .3s;position:relative;border:0;padding:0}
.concierge-page .hero-dot::after{content:'';position:absolute;top:0;left:0;width:100%;height:0;background:rgba(245,242,236,.9);transition:height 5s linear}
.concierge-page .hero-dot.active{background:rgba(245,242,236,.4);height:40px}.concierge-page .hero-dot.active::after{height:100%}
.concierge-page .hero-content{position:relative;z-index:2;padding:0 56px 64px;max-width:900px}
.concierge-page .hero-eyebrow,.concierge-page .section-label{font-family:'Montserrat',sans-serif;font-weight:300;font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:var(--gold-light);display:block}
.concierge-page .hero-eyebrow{margin-bottom:22px;opacity:0;animation:conciergeFadeUp 1s .3s forwards}
.concierge-page .section-label{font-size:11px;letter-spacing:.35em;color:var(--gold);margin-bottom:1.4rem}
.concierge-page .hero-h1{font-family:'Cormorant Garamond',serif;font-weight:300;font-size:clamp(52px,6vw,88px);line-height:1.03;color:var(--warm-white);opacity:0;animation:conciergeFadeUp 1.1s .5s forwards}
.concierge-page .hero-h1 em,.concierge-page h2 em{font-style:italic}.concierge-page .hero-h1 em{color:var(--gold-light)}
.concierge-page .hero-sub{margin-top:22px;font-size:15px;letter-spacing:.05em;line-height:1.6;color:rgba(245,242,236,.6);max-width:440px;opacity:0;animation:conciergeFadeUp 1.1s .75s forwards}
.concierge-page .hero-cta-row{margin-top:34px;opacity:0;animation:conciergeFadeUp 1.1s 1s forwards}
.concierge-page .btn-outline,.concierge-page .btn-dark,.concierge-page .form-submit{display:inline-block;font-family:'Montserrat',sans-serif;font-size:10px;letter-spacing:.25em;text-transform:uppercase;transition:background .3s,color .3s,border-color .3s}
.concierge-page .btn-outline{padding:14px 36px;border:1px solid rgba(245,242,236,.9);color:var(--warm-white)}.concierge-page .btn-outline:hover{background:var(--warm-white);color:var(--charcoal);border-color:var(--warm-white)}
@keyframes conciergeFadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
.concierge-page .services-section,.concierge-page .process,.concierge-page .membership-section,.concierge-page .enquire-section{padding:96px 56px}
.concierge-page .services-section{padding-top:76px;background:var(--warm-white)}
.concierge-page .services-header,.concierge-page .process-header,.concierge-page .enquire-section{display:grid;grid-template-columns:1fr 1fr;gap:44px;align-items:end}
.concierge-page .services-header{padding-bottom:42px;border-bottom:.5px solid var(--border);margin-bottom:42px}
.concierge-page .services-h2,.concierge-page .supporting-h2,.concierge-page .membership-h2,.concierge-page .enquire-h2,.concierge-page .process-header h2{font-family:'Cormorant Garamond',serif;font-weight:300;font-size:clamp(36px,3.5vw,56px);line-height:1.1;color:var(--charcoal);margin-top:12px}
.concierge-page .services-header-desc,.concierge-page .supporting-body,.concierge-page .supporting-item-desc,.concierge-page .process-header p,.concierge-page .step-desc,.concierge-page .membership-body,.concierge-page .enquire-body{font-size:15px;line-height:1.7;color:var(--mid);font-weight:300}
.concierge-page .services-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2px;background:var(--border)}
.concierge-page .service-card{position:relative;min-height:460px;overflow:hidden;background:var(--dark);color:#fff;display:block}
.concierge-page .service-card-img{position:absolute;inset:0;background-size:cover;background-position:center;transition:transform .8s ease}
.concierge-page .service-card:hover .service-card-img{transform:scale(1.05)}
.concierge-page .service-card-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.05) 0%,rgba(0,0,0,.28) 48%,rgba(0,0,0,.72) 100%);transition:background .45s ease}
.concierge-page .service-card:hover .service-card-overlay,.concierge-page .service-card:focus-visible .service-card-overlay{background:linear-gradient(to bottom,rgba(0,0,0,.05) 0%,rgba(0,0,0,.35) 42%,rgba(0,0,0,.86) 100%)}
.concierge-page .service-card-content{position:absolute;left:28px;right:28px;bottom:28px;z-index:1;transform:translateY(68px);transition:transform .45s ease}
.concierge-page .service-card:hover .service-card-content,.concierge-page .service-card:focus-visible .service-card-content{transform:translateY(0)}
.concierge-page .service-title{font-family:'Cormorant Garamond',serif;font-weight:300;font-size:32px;line-height:1.05;color:#fff;margin-bottom:14px}
.concierge-page .service-desc{font-size:14px;line-height:1.55;color:rgba(245,242,236,.68);margin-bottom:18px;opacity:0;transform:translateY(14px);transition:opacity .35s ease,transform .45s ease}
.concierge-page .service-link{font-size:10px;letter-spacing:.25em;text-transform:uppercase;color:var(--gold-light);opacity:0;transform:translateY(14px);transition:opacity .35s ease .05s,transform .45s ease .05s}
.concierge-page .service-card:hover .service-desc,.concierge-page .service-card:hover .service-link,.concierge-page .service-card:focus-visible .service-desc,.concierge-page .service-card:focus-visible .service-link{opacity:1;transform:translateY(0)}
.concierge-page .supporting-section{padding:96px 56px;background:var(--cream);display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;overflow:visible}
.concierge-page .supporting-left{position:relative;align-self:stretch;z-index:1}.concierge-page .supporting-left-pin{position:relative;height:max-content;will-change:transform}.concierge-page .supporting-h2 em,.concierge-page .membership-h2 em{color:var(--gold)}.concierge-page .supporting-body{margin-top:20px}
.concierge-page .supporting-cta{margin-top:32px;display:inline-block;font-size:10px;letter-spacing:.22em;text-transform:uppercase;color:#000;border-bottom:1px solid rgba(0,0,0,.3);padding-bottom:6px}
.concierge-page .supporting-list{list-style:none;display:flex;flex-direction:column}.concierge-page .supporting-item{padding:20px 0;border-bottom:1px solid var(--border)}.concierge-page .supporting-item:first-child{border-top:1px solid var(--border)}
.concierge-page .supporting-item-title{font-family:'Cormorant Garamond',serif;font-weight:400;font-size:20px;color:var(--charcoal);margin-bottom:6px}
.concierge-page .process{background:var(--warm-white)}.concierge-page .process-header{gap:3rem;margin-bottom:3.5rem}.concierge-page .process-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5px;background:var(--border)}
.concierge-page .process-card{background:var(--warm-white);padding:2.25rem;display:flex;gap:1.5rem;align-items:flex-start}.concierge-page .process-card-num{font-family:'Cormorant Garamond',serif;font-size:clamp(3.5rem,5vw,5rem);font-weight:300;line-height:1;color:rgba(154,139,110,.18);width:70px;text-align:right;flex-shrink:0}
.concierge-page .process-card-body{flex:1;padding-top:.25rem}.concierge-page .step-title{font-family:'Cormorant Garamond',serif;font-size:15px;font-weight:400;color:var(--charcoal);margin-bottom:.5rem;letter-spacing:.02em}.concierge-page .step-desc{line-height:1.65;letter-spacing:.02em}
.concierge-page .membership-section{background:var(--warm-white);text-align:center;position:relative;overflow:hidden}.concierge-page .membership-inner{max-width:700px;margin:0 auto}.concierge-page .membership-body{margin-top:20px;margin-bottom:34px}
.concierge-page .btn-dark,.concierge-page .form-submit{padding:16px 48px;background:#000;border:1px solid #000;color:#fff}.concierge-page .btn-dark:hover,.concierge-page .form-submit:hover{background:#fff;color:#000}.concierge-page .membership-note{margin-top:18px;font-size:11px;letter-spacing:.08em;color:var(--light)}
.concierge-page .enquire-section{background:var(--cream);gap:80px;align-items:start;}.concierge-page .enquire-h2{margin-bottom:16px}
.concierge-page .enquire-form{display:flex;flex-direction:column;gap:16px}.concierge-page .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}.concierge-page .form-field{display:flex;flex-direction:column;gap:6px}
.concierge-page .form-label{font-size:9px;letter-spacing:.2em;text-transform:uppercase;color:var(--mid)}
.concierge-page .form-input,.concierge-page .form-select,.concierge-page .form-textarea{background:transparent;border:none;border-bottom:1px solid var(--border);padding:10px 0;font-family:'Montserrat',sans-serif;font-weight:300;font-size:15px;color:var(--charcoal);outline:none;transition:border-color .3s;width:100%;appearance:none;-webkit-appearance:none;border-radius:0;box-shadow:none}
.concierge-page .form-input::placeholder,.concierge-page .form-textarea::placeholder{color:var(--light)}.concierge-page .form-input:focus,.concierge-page .form-select:focus,.concierge-page .form-textarea:focus{border-color:var(--gold)}
.concierge-page .form-textarea{resize:none;height:84px}.concierge-page .form-select{cursor:pointer}.concierge-page .form-submit{margin-top:8px;align-self:flex-start;cursor:pointer}.concierge-page .form-submit:disabled{opacity:.65;cursor:wait}
.concierge-page .form-privacy,.concierge-page .form-message{font-size:13px;color:var(--light);line-height:1.6}.concierge-page .form-message.success{color:#2f6b3d}.concierge-page .form-message.error{color:#9a4b43}
.concierge-page .fade-up,.concierge-page .reveal{opacity:0;transform:translateY(32px);transition:opacity .8s,transform .8s}.concierge-page .fade-up.visible,.concierge-page .reveal.visible{opacity:1;transform:translateY(0)}.concierge-page .reveal-delay-1{transition-delay:.1s}.concierge-page .reveal-delay-2{transition-delay:.2s}.concierge-page .reveal-delay-3{transition-delay:.3s}
@media (max-width:1100px){.concierge-page .services-grid{grid-template-columns:repeat(2,1fr)}.concierge-page .services-header,.concierge-page .supporting-section,.concierge-page .process-header,.concierge-page .enquire-section{grid-template-columns:1fr;gap:3rem}.concierge-page .supporting-left{position:static}}
@media (max-width:720px){.concierge-page .hero{min-height:580px}.concierge-page .hero-content{padding:0 24px 56px}.concierge-page .hero-pagination{right:20px}.concierge-page .hero-h1{font-size:clamp(44px,14vw,62px)}.concierge-page .services-section,.concierge-page .supporting-section,.concierge-page .process,.concierge-page .membership-section,.concierge-page .enquire-section{padding:60px 24px}.concierge-page .services-grid,.concierge-page .process-grid,.concierge-page .form-row{grid-template-columns:1fr}.concierge-page .service-card{min-height:380px}.concierge-page .services-header{padding-bottom:32px;margin-bottom:32px}.concierge-page .process-header{margin-bottom:2.5rem}.concierge-page .process-card{padding:1.6rem;gap:1rem}.concierge-page .process-card-num{width:48px}}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="concierge-page">
	<section class="hero">
		<div class="hero-slideshow">
			<?php foreach ( $hero_slide_urls as $index => $slide_url ) : ?>
				<div class="hero-slide<?php echo 0 === $index ? ' active' : ''; ?>" style="background-image:url('<?php echo esc_url( $slide_url ); ?>');"></div>
			<?php endforeach; ?>
		</div>
		<div class="hero-gradient"></div>
		<div class="hero-pagination" id="heroPagination">
			<?php foreach ( $hero_slide_urls as $index => $slide_url ) : ?>
				<button class="hero-dot<?php echo 0 === $index ? ' active' : ''; ?>" type="button" data-slide="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( 'Show slide ' . ( $index + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
		<div class="hero-content">
			<div class="hero-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></div>
			<h1 class="hero-h1"><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="hero-sub"><?php echo esc_html( $hero_text ); ?></p>
			<?php if ( $hero_button_label && $hero_button_url ) : ?>
				<div class="hero-cta-row">
					<a href="<?php echo esc_url( $hero_button_url ); ?>" class="btn-outline"><?php echo esc_html( $hero_button_label ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="services-section">
		<div class="services-header reveal">
			<div>
				<div class="section-label"><?php echo esc_html( $services_label ); ?></div>
				<h2 class="services-h2"><?php echo wp_kses_post( $services_title ); ?></h2>
			</div>
			<div>
				<p class="services-header-desc"><?php echo esc_html( $services_text ); ?></p>
			</div>
		</div>
		<div class="services-grid">
			<?php foreach ( (array) $service_cards as $index => $card ) : ?>
				<?php
				$card_image = sedgemore_concierge_asset_url( $card['image'] ?? '', 'large' );
				$card_url   = ! empty( $card['link_url'] ) ? $card['link_url'] : '#enquire';
				?>
				<a href="<?php echo esc_url( $card_url ); ?>" class="service-card reveal reveal-delay-<?php echo esc_attr( min( $index, 3 ) ); ?>">
					<div class="service-card-img" style="background-image:url('<?php echo esc_url( $card_image ); ?>');"></div>
					<div class="service-card-overlay"></div>
					<div class="service-card-content">
						<h3 class="service-title"><?php echo wp_kses_post( $card['title'] ?? '' ); ?></h3>
						<p class="service-desc"><?php echo esc_html( $card['text'] ?? '' ); ?></p>
						<span class="service-link"><?php echo esc_html( $card['link_label'] ?? 'Enquire' ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="supporting-section">
		<div class="supporting-left">
			<div class="supporting-left-pin">
				<div class="supporting-left-inner reveal">
					<div class="section-label"><?php echo esc_html( $support_label ); ?></div>
					<h2 class="supporting-h2"><?php echo wp_kses_post( $support_title ); ?></h2>
					<p class="supporting-body"><?php echo esc_html( $support_body ); ?></p>
					<?php if ( $support_button_label && $support_button_url ) : ?>
						<a href="<?php echo esc_url( $support_button_url ); ?>" class="supporting-cta"><?php echo esc_html( $support_button_label ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="supporting-right reveal reveal-delay-2">
			<ul class="supporting-list">
				<?php foreach ( (array) $support_items as $item ) : ?>
					<li class="supporting-item">
						<h4 class="supporting-item-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h4>
						<p class="supporting-item-desc"><?php echo esc_html( $item['text'] ?? '' ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="membership-section">
		<div class="membership-inner reveal">
			<div class="section-label"><?php echo wp_kses_post( $membership_label ); ?></div>
			<h2 class="membership-h2"><?php echo wp_kses_post( $membership_title ); ?></h2>
			<p class="membership-body"><?php echo esc_html( $membership_body ); ?></p>
			<?php if ( $membership_button_label && $membership_button_url ) : ?>
				<a href="<?php echo esc_url( $membership_button_url ); ?>" class="btn-dark"><?php echo esc_html( $membership_button_label ); ?></a>
			<?php endif; ?>
			<?php if ( $membership_note ) : ?>
				<p class="membership-note"><?php echo esc_html( $membership_note ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="enquire-section" id="enquire">
		<div class="enquire-left reveal">
			<div class="section-label"><?php echo esc_html( $enquire_label ); ?></div>
			<h2 class="enquire-h2"><?php echo wp_kses_post( $enquire_title ); ?></h2>
			<p class="enquire-body"><?php echo esc_html( $enquire_body ); ?></p>
		</div>
		<div class="enquire-form-wrap reveal reveal-delay-2">
			<form id="event__form" class="enquire-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<div class="form-row">
					<div class="form-field">
						<label class="form-label" for="event__first_name">First Name</label>
						<input class="form-input" id="event__first_name" type="text" name="first_name" placeholder="Your first name" required>
					</div>
					<div class="form-field">
						<label class="form-label" for="event__last_name">Last Name</label>
						<input class="form-input" id="event__last_name" type="text" name="last_name" placeholder="Your last name" required>
					</div>
				</div>
				<div class="form-field">
					<label class="form-label" for="event__email_address">Email Address</label>
					<input class="form-input" id="event__email_address" type="email" name="email_address" placeholder="Your email address" required>
				</div>
				<div class="form-field">
					<label class="form-label" for="event__phone">Phone</label>
					<input class="form-input" id="event__phone" type="tel" name="phone" placeholder="Your phone number">
				</div>
				<div class="form-field">
					<label class="form-label" for="event__service"><?php echo esc_html( $enquire_service_label ); ?></label>
					<select class="form-select form-input" id="event__service" name="service">
						<option value="" disabled selected><?php echo esc_html( $enquire_service_placeholder ); ?></option>
						<?php foreach ( (array) $enquire_service_options as $option ) : ?>
							<option value="<?php echo esc_attr( $option['value'] ?? wp_strip_all_tags( $option['label'] ?? '' ) ); ?>"><?php echo wp_kses_post( $option['label'] ?? '' ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-field">
					<label class="form-label" for="event__message">Message</label>
					<textarea class="form-textarea form-input" id="event__message" name="message" placeholder="<?php echo esc_attr( $enquire_message_placeholder ); ?>" required></textarea>
				</div>
				<p id="event__form-message" class="form-message" aria-live="polite"></p>
				<button type="submit" id="event__submit-btn" class="form-submit"><?php echo esc_html( $enquire_submit_label ); ?></button>
				<p class="form-privacy"><?php echo esc_html( $enquire_privacy ); ?></p>
				<input type="hidden" name="action" value="event_contact_form">
				<?php wp_nonce_field( 'event_contact_nonce_action', 'event_contact_nonce' ); ?>
			</form>
		</div>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var reveals = document.querySelectorAll('.concierge-page .reveal, .concierge-page .fade-up');
	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function (entries, io) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('visible');
					io.unobserve(entry.target);
				}
			});
		}, { threshold: 0.1 });
		reveals.forEach(function (el) { observer.observe(el); });
	} else {
		reveals.forEach(function (el) { el.classList.add('visible'); });
	}

	var slides = document.querySelectorAll('.concierge-page .hero-slide');
	var dots = document.querySelectorAll('.concierge-page .hero-dot');
	var current = 0;
	var timer;

	function goToSlide(n) {
		if (!slides.length || !dots.length || n === current) {
			return;
		}
		slides[current].classList.remove('active');
		dots[current].classList.remove('active');
		current = n;
		slides[current].classList.add('active');
		dots[current].classList.add('active');
		window.clearInterval(timer);
		timer = window.setInterval(nextSlide, 5000);
	}

	function nextSlide() {
		goToSlide((current + 1) % slides.length);
	}

	dots.forEach(function (dot) {
		dot.addEventListener('click', function () {
			goToSlide(parseInt(dot.getAttribute('data-slide'), 10));
		});
	});

	if (slides.length > 1) {
		timer = window.setInterval(nextSlide, 5000);
	}

	var supportingSection = document.querySelector('.concierge-page .supporting-section');
	var supportingPin = document.querySelector('.concierge-page .supporting-left-pin');
	var stickyTop = 120;

	function updateSupportingPin() {
		if (!supportingSection || !supportingPin) {
			return;
		}

		if (window.matchMedia('(max-width: 1100px)').matches) {
			supportingPin.style.transform = '';
			return;
		}

		var sectionRect = supportingSection.getBoundingClientRect();
		var sectionTop = sectionRect.top + window.pageYOffset;
		var pinHeight = supportingPin.offsetHeight;
		var sectionHeight = supportingSection.offsetHeight;
		var maxOffset = Math.max(0, sectionHeight - pinHeight - (stickyTop * 2));
		var currentOffset = window.pageYOffset + stickyTop - sectionTop;
		var clampedOffset = Math.min(Math.max(currentOffset, 0), maxOffset);

		supportingPin.style.transform = 'translate3d(0,' + clampedOffset + 'px,0)';
	}

	window.addEventListener('scroll', updateSupportingPin, { passive: true });
	window.addEventListener('resize', updateSupportingPin);
	updateSupportingPin();

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
		var service = form.querySelector('[name="service"]');
		var messageField = form.querySelector('[name="message"]');
		var messageParts = [];

		if (service && service.value.trim()) {
			messageParts.push('Service: ' + service.value.trim());
		}

		if (messageField && messageField.value.trim()) {
			messageParts.push('Message: ' + messageField.value.trim());
		}

		if (messageParts.length) {
			formData.set('message', messageParts.join("\n\n"));
		}

		var ajaxUrl = (window.myAjaxObject && window.myAjaxObject.ajaxurl) || form.getAttribute('action');

		fetch(ajaxUrl, {
			method: 'POST',
			body: formData,
			headers: { 'X-Requested-With': 'XMLHttpRequest' },
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
					submitButton.textContent = originalButtonText || <?php echo wp_json_encode( $enquire_submit_label ); ?>;
					submitButton.removeAttribute('aria-busy');
				}
			});
	});
});
</script>

<?php
get_footer();
