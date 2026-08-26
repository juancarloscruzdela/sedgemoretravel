<?php
/**
 * Template Name: Hotels And Resorts
 *
 * @package sadgemore
 */

get_header();

if ( ! function_exists( 'sedgemore_hotels_asset_url' ) ) {
	function sedgemore_hotels_asset_url( $value, $size = 'full' ) {
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

if ( ! function_exists( 'sedgemore_hotels_field' ) ) {
	function sedgemore_hotels_field( $name, $fallback = '' ) {
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

$upload_base = '/wp-content/uploads/2026/06/';

$banners     = sedgemore_hotels_field( 'banners', array() );
$hero_banner = ( is_array( $banners ) && isset( $banners[0] ) && is_array( $banners[0] ) ) ? $banners[0] : array();
$hero_image  = sedgemore_hotels_asset_url( sedgemore_hotels_field( 'hotels_page_hero_image' ) );
if ( ! $hero_image ) {
	$hero_image = sedgemore_hotels_asset_url( $hero_banner['image'] ?? '' );
}
if ( ! $hero_image ) {
	$hero_image = $upload_base . 'hero-banner.webp';
}

$hero_eyebrow      = sedgemore_hotels_field( 'hotels_page_hero_eyebrow', 'Travel / Hotels &amp; Resorts' );
$hero_title        = sedgemore_hotels_field( 'hotels_page_hero_title', 'Hotels<br><em>&amp; Resorts</em>' );
$hero_text         = sedgemore_hotels_field( 'hotels_page_hero_text', 'Every property in our collection is chosen for its character, consistency, and sense of place. We only recommend hotels we trust.' );
$hero_button_label = sedgemore_hotels_field( 'hotels_page_hero_button_label', 'Explore The Collection' );
$hero_button_url   = sedgemore_hotels_field( 'hotels_page_hero_button_url', '#collection' );

$intro_title = sedgemore_hotels_field( 'hotels_page_intro_title', 'Our approach to<br><em>exceptional stays.</em>' );
$intro_body  = sedgemore_hotels_field(
	'hotels_page_intro_body',
	'<p>From a single city night to a multi-destination journey, each Sedgemore hotel recommendation is made with clarity and care. We do not work from supplier lists. We work from direct knowledge.</p><p>What matters to us: the quality of service when things go quietly wrong, the character of the breakfast room at 7am, the view from the room we actually book for you. These are the details that shape every stay we design.</p>'
);

$collection_label = sedgemore_hotels_field( 'hotels_page_collection_label', 'Featured Hotels &amp; Resorts' );
$collection_title = sedgemore_hotels_field( 'hotels_page_collection_title', 'A small selection of stays<br><em>we confidently recommend.</em>' );
$hotels           = sedgemore_hotels_field(
	'hotels_page_hotels',
	array(
		array( 'image' => $upload_base . 'Taj-Mahal-Palace.jpg', 'badge' => 'Heritage', 'location' => 'Mumbai, India', 'name' => 'Taj Mahal Palace', 'description' => "One of India's most storied addresses, standing at Apollo Bunder since 1903. Moorish domes, Arabian Sea views, and interiors that carry more than a century of quiet distinction.", 'tags' => 'Heritage, City, Iconic', 'region' => 'asia', 'brand' => 'taj', 'type' => 'heritage city' ),
		array( 'image' => $upload_base . 'Aman-Tokyo.jpg', 'badge' => '', 'location' => 'Tokyo, Japan', 'name' => 'Aman Tokyo', 'description' => "High in the Otemachi Tower, Aman Tokyo brings the stillness of traditional Japanese interiors to the centre of one of the world's most purposeful cities. Fuji is visible on clear mornings.", 'tags' => 'City, Spa, Elevated', 'region' => 'asia', 'brand' => 'aman', 'type' => 'city spa' ),
		array( 'image' => $upload_base . 'Mandarin-Oriental-Hyde-Park.jpg', 'badge' => 'Top Searched', 'location' => 'London, United Kingdom', 'name' => 'Mandarin Oriental Hyde Park', 'description' => "Knightsbridge's most enduring address. The spa, Dinner by Heston Blumenthal, and rooms overlooking the park's tree canopy make this a perennial choice for discerning visitors to the city.", 'tags' => 'City, Spa, Dining', 'region' => 'europe', 'brand' => 'mandarin', 'type' => 'city spa' ),
		array( 'image' => $upload_base . 'villa-dEste-1.webp', 'badge' => '', 'location' => 'Lake Como, Italy', 'name' => "Villa d'Este", 'description' => "A 16th-century cardinal's retreat on the western bank of Como. The floating pool, the terraced gardens, and the particular quality of afternoon light on the water define a stay here.", 'tags' => 'Heritage, Gardens, Lake', 'region' => 'europe', 'brand' => 'independent', 'type' => 'heritage' ),
		array( 'image' => $upload_base . 'Rosewood-Abu-Dhabi.jpg', 'badge' => 'Top Searched', 'location' => 'Abu Dhabi, UAE', 'name' => 'Rosewood Abu Dhabi', 'description' => 'Set on Al Maryah Island with views across the Arabian Gulf, Rosewood Abu Dhabi delivers contemporary luxury with restraint. The private beach club and spa are consistently praised by returning guests.', 'tags' => 'Beach, Spa, City', 'region' => 'middleeast', 'brand' => 'rosewood', 'type' => 'beach city spa' ),
		array( 'image' => $upload_base . 'Four-Seasons-Resort-Maui.jpg', 'badge' => '', 'location' => 'Maui, Hawaii', 'name' => 'Four Seasons Resort Maui', 'description' => "Wailea's finest address occupies a prime stretch above the Pacific. The three pools arranged along the cliff's edge, the ocean-facing terrace at sunset, and the consistent service draw guests back year after year.", 'tags' => 'Beach, Pool, Spa', 'region' => 'americas', 'brand' => 'fourseasons', 'type' => 'beach spa' ),
		array( 'image' => $upload_base . 'africa.jpg', 'badge' => 'Top Searched', 'location' => 'Serengeti, Tanzania', 'name' => 'Singita Grumeti', 'description' => 'A private 350,000-acre reserve within the Western Serengeti corridor. Singita Grumeti positions guests in the path of the wildebeest migration with access unavailable through any other operator.', 'tags' => 'Safari, Private Reserve, Wildlife', 'region' => 'africa', 'brand' => 'independent', 'type' => 'safari' ),
		array( 'image' => $upload_base . 'Mandarin-Oriental-Bankok.jpg', 'badge' => '', 'location' => 'Bangkok, Thailand', 'name' => 'Mandarin Oriental Bangkok', 'description' => "Open since 1879 and Bangkok's original luxury address. The Author's Lounge, the Chao Phraya River views at dusk, and the Thai spa have made it the city's most consistent point of reference.", 'tags' => 'Heritage, River, Spa', 'region' => 'asia', 'brand' => 'mandarin', 'type' => 'heritage city spa' ),
		array( 'image' => $upload_base . 'Rosewood-London.webp', 'badge' => 'Top Searched', 'location' => 'London, United Kingdom', 'name' => 'Rosewood London', 'description' => 'Housed in the Edwardian baroque Pearl Assurance building on High Holborn. The Mirror Room, the spa, and the Holborn Dining Room have positioned it as one of the most sought-after city addresses in Europe.', 'tags' => 'City, Dining, Design', 'region' => 'europe', 'brand' => 'rosewood', 'type' => 'city' ),
		array( 'image' => $upload_base . 'Aman-Dubai.webp', 'badge' => '', 'location' => 'Dubai, UAE', 'name' => 'Aman Dubai', 'description' => "Aman's first Middle East property brings its signature quiet to a city that rarely pauses. Set above Downtown Dubai with a private rooftop pool, it reframes what a Dubai stay can be.", 'tags' => 'City, Design, Rooftop', 'region' => 'middleeast', 'brand' => 'aman', 'type' => 'city' ),
		array( 'image' => $upload_base . 'Belmond-Copacabana-Palace.jpg', 'badge' => '', 'location' => 'Rio de Janeiro, Brazil', 'name' => 'Belmond Copacabana Palace', 'description' => "The white facade has anchored Rio's most celebrated shoreline since 1923. The rooftop pool, the terrace facing Copacabana beach, and the Atlantic-facing suites remain among South America's finest.", 'tags' => 'Beach, Heritage, City', 'region' => 'americas', 'brand' => 'belmond', 'type' => 'beach heritage city' ),
		array( 'image' => $upload_base . 'Four-Seasons-Bali-at-Sayan.jpg', 'badge' => 'Top Searched', 'location' => 'Ubud, Bali', 'name' => 'Four Seasons Bali at Sayan', 'description' => "Above the Ayung River gorge in Ubud's jungle interior. The villa residences, the dawn walks through the rice paddies, and the Balinese wellness rituals define one of Asia's most considered stays.", 'tags' => 'Jungle, Spa, Villas', 'region' => 'asia', 'brand' => 'fourseasons', 'type' => 'spa' ),
		array( 'image' => $upload_base . 'Hotel-du-Cap-Eden-Roc.webp', 'badge' => '', 'location' => 'Antibes, French Riviera', 'name' => 'Hotel du Cap-Eden-Roc', 'description' => "Twenty-two acres of private Mediterranean coastline at the tip of Cap d'Antibes. The saltwater pool hewn from the rock and the pine-shaded grounds have sustained its reputation since 1870.", 'tags' => 'Coastal, Heritage, Gardens', 'region' => 'europe', 'brand' => 'independent', 'type' => 'beach heritage' ),
		array( 'image' => $upload_base . 'Ellerman-House.jpg', 'badge' => '', 'location' => 'Cape Town, South Africa', 'name' => 'Ellerman House', 'description' => 'Eleven suites in a 1912 mansion above Bantry Bay, with one of the finest private art collections in the country. The view from the upper pool across the Atlantic is among Cape Town\'s most quietly commanding.', 'tags' => 'Boutique, Art, Ocean View', 'region' => 'africa', 'brand' => 'independent', 'type' => 'city' ),
		array( 'image' => $upload_base . 'Belmond-Hotel-Cipriani.jpg', 'badge' => 'Top Searched', 'location' => 'Venice, Italy', 'name' => 'Belmond Hotel Cipriani', 'description' => "On Giudecca Island, a private launch from St Mark's Square. The Olympic pool, the kitchen garden, and the silence that descends each evening when the visitors depart set it apart entirely from the city.", 'tags' => 'Island, Heritage, Private', 'region' => 'europe', 'brand' => 'belmond', 'type' => 'island heritage' ),
		array( 'image' => $upload_base . 'Rosewood-Hong-Kong.webp', 'badge' => '', 'location' => 'Hong Kong', 'name' => 'Rosewood Hong Kong', 'description' => 'From a 65-floor tower above Victoria Harbour in Tsim Sha Tsui, Rosewood Hong Kong sets a new standard for the harbour-view hotel. The Manor Club and the restaurant collection define its position in the city.', 'tags' => 'Harbour View, City, Dining', 'region' => 'asia', 'brand' => 'rosewood', 'type' => 'city' ),
		array( 'image' => $upload_base . 'four-seasons-bora-bora.webp', 'badge' => '', 'location' => 'French Polynesia', 'name' => 'Four Seasons Bora Bora', 'description' => "The overwater bungalows face both the lagoon and Mount Otemanu, each with a private ladder descending into the water. The lagoon's clarity at dawn and the stillness of the surrounding reef are what guests carry home.", 'tags' => 'Overwater, Lagoon, Island', 'region' => 'americas', 'brand' => 'fourseasons', 'type' => 'island beach' ),
		array( 'image' => $upload_base . 'al-maha.webp', 'badge' => '', 'location' => 'Dubai Desert Conservation Reserve, UAE', 'name' => 'Al Maha Desert Resort', 'description' => 'Forty-two private suites within a protected conservation reserve, each with its own pool and unbroken views of the Dubai desert. Wildlife walks at dusk and the silence after sunset belong to a different Dubai entirely.', 'tags' => 'Desert, Private Pool, Wildlife', 'region' => 'middleeast', 'brand' => 'independent', 'type' => 'safari' ),
	)
);

$destinations_label = sedgemore_hotels_field( 'hotels_page_destinations_label', 'Our Favourite Destinations' );
$destinations       = sedgemore_hotels_field(
	'hotels_page_destinations',
	array(
		array( 'image' => $upload_base . 'Udaipur-Rajasthan-India.jpg', 'region' => 'South Asia', 'name' => 'India', 'subtitle' => 'Palace hotels, coastal retreats and city addresses' ),
		array( 'image' => $upload_base . 'Japan.jpg', 'region' => 'East Asia', 'name' => 'Japan', 'subtitle' => 'Ryokan, city sanctuaries and mountain retreats' ),
		array( 'image' => $upload_base . 'Middle-East-Arabian-Gulf.jpg', 'region' => 'Middle East', 'name' => 'Arabian Gulf', 'subtitle' => 'Desert estates, coastal resorts and city towers' ),
		array( 'image' => $upload_base . 'Italy.jpg', 'region' => 'Southern Europe', 'name' => 'Italy', 'subtitle' => 'Lake estates, Riviera villas and Roman addresses' ),
		array( 'image' => $upload_base . 'africa.jpg', 'region' => 'Africa', 'name' => 'East Africa', 'subtitle' => 'Private reserves, migration camps and coastal lodges' ),
		array( 'image' => $upload_base . 'French-Polynesia.jpg', 'region' => 'Pacific', 'name' => 'French Polynesia', 'subtitle' => 'Overwater retreats and private lagoon escapes' ),
	)
);

$process_title = sedgemore_hotels_field( 'hotels_page_process_title', 'How we<br><em>select your</em><br>hotel.' );
$process_text  = sedgemore_hotels_field( 'hotels_page_process_text', 'Our process is quiet and considered. We visit before we recommend, and we stay in contact with the properties we trust. Every suggestion is made with a specific guest in mind, not from a general list.' );
$process_steps = sedgemore_hotels_field(
	'hotels_page_process_steps',
	array(
		array( 'number' => '01', 'step' => 'The Conversation', 'heading' => 'We begin by listening', 'text' => 'A call that covers what matters to you: your pace, your interests, who you are travelling with, and the moments you want to remember. This is not a form. It is a conversation.' ),
		array( 'number' => '02', 'step' => 'The Selection', 'heading' => 'We match the property', 'text' => 'Drawing from our network of trusted properties and direct relationships, we select the hotels that are genuinely right for your brief. Each recommendation is considered, not compiled.' ),
		array( 'number' => '03', 'step' => 'The Refinement', 'heading' => 'We refine together', 'text' => 'You review the proposed stay. We adjust, add, and rethink until every detail feels right. No request is too small. No revision is unreasonable.' ),
		array( 'number' => '04', 'step' => 'The Journey', 'heading' => 'We remain with you', 'text' => 'Once you depart, Sedgemore remains available. Our team is reachable throughout your stay, ready to assist or simply be on hand should anything arise.' ),
	)
);

$enquiry_eyebrow = sedgemore_hotels_field( 'hotels_page_enquiry_eyebrow', 'Start Planning' );
$enquiry_title   = sedgemore_hotels_field( 'hotels_page_enquiry_title', 'Which hotel<br>would you like<br><em>to stay in?</em>' );
$enquiry_text    = sedgemore_hotels_field( 'hotels_page_enquiry_text', 'Tell us about your journey. If there is a hotel you have in mind, we can arrange it along with added benefits through our global partnerships. A specialist will be in touch to begin planning.' );
$interest_label  = sedgemore_hotels_field( 'hotels_page_interest_label', 'I am interested in' );
$submit_label    = sedgemore_hotels_field( 'hotels_page_submit_label', 'Submit and Start Planning' );
$interest_options = sedgemore_hotels_field(
	'hotels_page_interest_options',
	array(
		array( 'label' => 'City Stays', 'value' => 'City Stays' ),
		array( 'label' => 'Beach &amp; Coastal', 'value' => 'Beach & Coastal' ),
		array( 'label' => 'Safari', 'value' => 'Safari' ),
		array( 'label' => 'Heritage', 'value' => 'Heritage' ),
		array( 'label' => 'Spa &amp; Wellness', 'value' => 'Spa & Wellness' ),
		array( 'label' => 'Island Retreats', 'value' => 'Island Retreats' ),
		array( 'label' => 'Multi-Country', 'value' => 'Multi-Country' ),
		array( 'label' => 'Private Villa', 'value' => 'Private Villa' ),
	)
);

$filter_regions = array(
	'all'        => 'All Regions',
	'europe'     => 'Europe',
	'asia'       => 'Asia',
	'africa'     => 'Africa',
	'americas'   => 'Americas &amp; Pacific',
	'middleeast' => 'Middle East',
);
$filter_brands = array(
	'all'         => 'All Brands',
	'fourseasons' => 'Four Seasons',
	'mandarin'    => 'Mandarin Oriental',
	'aman'        => 'Aman',
	'rosewood'    => 'Rosewood',
	'taj'         => 'Taj Hotels',
	'belmond'     => 'Belmond',
	'independent' => 'Independent',
);
$filter_types = array(
	'all'      => 'All Types',
	'city'     => 'City',
	'beach'    => 'Beach &amp; Coastal',
	'safari'   => 'Safari &amp; Wildlife',
	'heritage' => 'Heritage',
	'spa'      => 'Spa &amp; Wellness',
	'island'   => 'Island &amp; Overwater',
);
?>

<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Montserrat:wght@300;400;500&display=swap');
.header_bright{display:block}.header_dark{display:none}.header_nav_fixed{background:#f1eeea}.divider_sharp_bright{display:none!important}.divider_sharp_dark{display:inline-block!important}
.hotels-page,.hotels-page *,.hotels-page *::before,.hotels-page *::after{box-sizing:border-box;margin:0;padding:0}.hotels-page{--cream:#F5F2EC;--white:#FDFAF6;--sand:#E6DFD3;--taupe:#B8AA98;--mocha:#6B5D4F;--espresso:#2C2218;--accent:#8B6B42;--text:#2C2218;background:var(--white);color:var(--text);font-family:'Montserrat',sans-serif;font-weight:300;line-height:1.7;-webkit-font-smoothing:antialiased;overflow-x:hidden}.hotels-page a{text-decoration:none}.hotels-page img{display:block;max-width:100%}
.hotels-page .hero{position:relative;height:100vh;min-height:600px;max-height:820px;display:flex;align-items:flex-end;overflow:hidden}.hotels-page .hero-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 60%}.hotels-page .hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,7,4,.88) 0%,rgba(10,7,4,.65) 35%,rgba(10,7,4,.38) 65%,rgba(10,7,4,.18) 100%)}.hotels-page .hero-content{position:relative;z-index:2;padding:0 80px 72px;color:#fff;max-width:700px}.hotels-page .hero-eyebrow{font-size:10px;font-weight:400;letter-spacing:.3em;text-transform:uppercase;color:rgba(255,255,255,.8);margin-bottom:20px;display:block;text-shadow:0 1px 8px rgba(0,0,0,.6)}.hotels-page .hero-title{font-family:'Cormorant Garamond',serif;font-size:clamp(48px,6.5vw,80px);font-weight:300;line-height:1;margin-bottom:20px;text-shadow:0 2px 20px rgba(0,0,0,.65),0 1px 6px rgba(0,0,0,.5)}.hotels-page em{font-style:italic}.hotels-page .hero-title em{font-weight:300;display:block}.hotels-page .hero-sub{font-size:12px;font-weight:300;color:rgba(255,255,255,.9);line-height:1.8;max-width:420px;margin-bottom:36px;text-shadow:0 1px 10px rgba(0,0,0,.65)}.hotels-page .hero-btn{display:inline-block;padding:13px 32px;font-size:9px;font-weight:500;letter-spacing:.28em;text-transform:uppercase;color:#fff;border:1px solid #fff;transition:background .25s,color .25s}.hotels-page .hero-btn:hover{background:#fff;color:var(--espresso)}
.hotels-page .intro{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:start;padding:96px 80px;border-bottom:1px solid var(--sand)}.hotels-page .intro-left h2,.hotels-page .collection-title,.hotels-page .process-top h2,.hotels-page .planning-left h2{font-family:'Cormorant Garamond',serif;font-weight:300;line-height:1.15;color:var(--espresso)}.hotels-page .intro-left h2{font-size:clamp(34px,3.5vw,48px)}.hotels-page .intro-right{padding-top:10px}.hotels-page .intro-right p{font-size:13px;color:var(--mocha);line-height:1.9;margin-bottom:18px}.hotels-page .intro-right p:last-child{margin-bottom:0}.hotels-page .section-label{font-size:9.5px;font-weight:500;letter-spacing:.3em;text-transform:uppercase;color:var(--taupe)}
.hotels-page .collection-section{background:var(--cream);padding:80px 80px 100px}.hotels-page .collection-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:44px;flex-wrap:wrap;gap:20px}.hotels-page .collection-title{font-size:clamp(28px,3vw,40px)}.hotels-page .filters-row{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.hotels-page .filter-select-wrap{position:relative}.hotels-page .filter-select{appearance:none;-webkit-appearance:none;padding:10px 36px 10px 16px;font-size:10px;font-weight:400;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--taupe);background:transparent;color:var(--mocha);cursor:pointer;outline:none;transition:border-color .2s,color .2s;min-width:150px}.hotels-page .filter-select:focus,.hotels-page .filter-select:hover{border-color:var(--espresso);color:var(--espresso)}.hotels-page .filter-arrow{position:absolute;right:12px;top:50%;transform:translateY(-50%);pointer-events:none;color:var(--taupe);font-size:9px}.hotels-page .search-wrap{position:relative;flex:1;min-width:200px;max-width:280px}.hotels-page .search-input{width:100%;padding:10px 36px 10px 16px;font-size:10px;letter-spacing:.1em;border:1px solid var(--taupe);background:transparent;color:var(--espresso);outline:none;transition:border-color .2s}.hotels-page .search-input:focus{border-color:var(--espresso)}.hotels-page .search-input::placeholder{color:var(--taupe)}.hotels-page .search-icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--taupe);font-size:12px;pointer-events:none}.hotels-page .results-count{font-size:10px;letter-spacing:.18em;text-transform:uppercase;color:var(--taupe);white-space:nowrap}
.hotels-page .hotels-grid,.hotels-page .destinations-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:3px}.hotels-page .hotel-card{background:var(--white);overflow:hidden;transition:box-shadow .3s}.hotels-page .hotel-card.hidden{display:none}.hotels-page .hotel-card:hover{box-shadow:0 8px 32px rgba(44,34,24,.1)}.hotels-page .hotel-img-wrap{position:relative;overflow:hidden;height:230px}.hotels-page .hotel-img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease}.hotels-page .hotel-card:hover .hotel-img{transform:scale(1.04)}.hotels-page .hotel-badge{position:absolute;top:14px;left:14px;font-size:8px;letter-spacing:.2em;text-transform:uppercase;background:var(--espresso);color:#fff;padding:4px 10px;font-weight:500}.hotels-page .hotel-body{padding:24px 22px 28px}.hotels-page .hotel-loc{font-size:9px;letter-spacing:.24em;text-transform:uppercase;color:var(--accent);margin-bottom:8px;font-weight:400}.hotels-page .hotel-name{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:400;line-height:1.2;color:var(--espresso);margin-bottom:12px}.hotels-page .hotel-desc{font-size:12px;color:var(--mocha);line-height:1.85;margin-bottom:18px}.hotels-page .hotel-tags{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:20px}.hotels-page .hotel-tag{font-size:8.5px;letter-spacing:.18em;text-transform:uppercase;color:var(--mocha);border:1px solid var(--sand);padding:3px 10px;font-weight:400}.hotels-page .hotel-enquire{display:inline-block;font-size:9px;letter-spacing:.22em;text-transform:uppercase;color:var(--espresso);font-weight:500;border:1px solid var(--espresso);padding:8px 18px;transition:background .2s,color .2s}.hotels-page .hotel-enquire:hover{background:var(--espresso);color:#fff}.hotels-page .no-results{display:none;grid-column:1/-1;text-align:center;padding:80px 0;font-family:'Cormorant Garamond',serif;font-size:22px;font-style:italic;color:var(--taupe)}.hotels-page .no-results.visible{display:block}
.hotels-page .destinations-section{padding:72px 80px;background:var(--white);border-bottom:1px solid var(--sand)}.hotels-page .destinations-section .section-label{margin-bottom:36px;display:block}.hotels-page .dest-card{position:relative;overflow:hidden;height:260px;cursor:pointer}.hotels-page .dest-card img{width:100%;height:100%;object-fit:cover;transition:transform .6s ease}.hotels-page .dest-card:hover img{transform:scale(1.05)}.hotels-page .dest-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(20,14,8,.7) 0%,rgba(20,14,8,.1) 55%,transparent 100%)}.hotels-page .dest-card-text{position:absolute;bottom:0;left:0;right:0;padding:24px 22px;color:#fff}.hotels-page .dest-card-region{font-size:8.5px;letter-spacing:.28em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:5px;font-weight:400}.hotels-page .dest-card-name{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:400;line-height:1.1}.hotels-page .dest-card-sub{font-size:10.5px;color:rgba(255,255,255,.6);margin-top:4px;font-weight:300}
.hotels-page .process-section{background:var(--cream);padding:96px 80px;border-top:1px solid var(--sand)}.hotels-page .process-top{display:grid;grid-template-columns:1fr 1fr;gap:60px;margin-bottom:60px}.hotels-page .process-top h2{font-size:clamp(32px,3.2vw,46px)}.hotels-page .process-top p{font-size:13px;color:var(--mocha);line-height:1.9;padding-top:10px}.hotels-page .process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2px}.hotels-page .process-step{background:var(--white);padding:32px 26px 36px;position:relative}.hotels-page .process-num{font-family:'Cormorant Garamond',serif;font-size:72px;font-weight:300;color:var(--sand);line-height:1;position:absolute;top:20px;right:20px;pointer-events:none;user-select:none}.hotels-page .process-step-label{font-size:8.5px;letter-spacing:.28em;text-transform:uppercase;color:var(--taupe);margin-bottom:14px;font-weight:400}.hotels-page .process-step h3{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:400;color:var(--espresso);margin-bottom:12px;line-height:1.2}.hotels-page .process-step p{font-size:12px;color:var(--mocha);line-height:1.85}
.hotels-page .planning-section{background:var(--cream);padding:0 80px 100px}.hotels-page .planning-inner{display:grid;grid-template-columns:1fr 1.4fr;gap:80px;align-items:start;border-top:1px solid var(--sand);padding-top:80px}.hotels-page .plan-label,.hotels-page .interest-label{font-size:9px;letter-spacing:.3em;text-transform:uppercase;color:var(--taupe);margin-bottom:24px;display:block;font-weight:500}.hotels-page .planning-left h2{font-size:clamp(32px,3.5vw,52px);margin-bottom:20px}.hotels-page .planning-left p{font-size:12.5px;color:var(--mocha);line-height:1.9}.hotels-page .planning-left p a{color:var(--accent)}.hotels-page .interest-label{font-size:8.5px;letter-spacing:.24em;margin-bottom:12px}.hotels-page .interest-row{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:24px}.hotels-page .interest-btn{position:relative;padding:7px 15px;font-size:9px;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--taupe);background:transparent;color:var(--mocha);cursor:pointer;transition:all .2s;font-weight:400}.hotels-page .interest-btn input{position:absolute;opacity:0;pointer-events:none}.hotels-page .interest-btn.selected,.hotels-page .interest-btn:hover{background:var(--espresso);color:#fff;border-color:var(--espresso)}.hotels-page .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}.hotels-page .screen-reader-text{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.hotels-page .form-input{padding:12px 14px;font-size:11px;letter-spacing:.06em;border:1px solid var(--taupe);background:transparent;color:var(--espresso);outline:none;width:100%;transition:border-color .2s;font-family:'Montserrat',sans-serif}.hotels-page .form-input:focus{border-color:var(--espresso)}.hotels-page .form-input::placeholder{color:var(--taupe)}.hotels-page .form-full{grid-column:1/-1}.hotels-page textarea.form-input{resize:none}.hotels-page .form-message{grid-column:1/-1;font-size:12px;color:var(--mocha);min-height:18px}.hotels-page .form-submit{grid-column:1/-1;margin-top:6px;padding:14px;font-size:9px;letter-spacing:.28em;text-transform:uppercase;background:var(--espresso);color:#fff;border:1px solid var(--espresso);cursor:pointer;font-weight:500;transition:background .2s,color .2s}.hotels-page .form-submit:hover{background:#fff;color:var(--espresso);border-color:var(--espresso)}
.hotels-page .reveal{opacity:0;transform:translateY(24px);transition:opacity .75s ease,transform .75s ease}.hotels-page .reveal.visible{opacity:1;transform:none}
@media (max-width:1100px){.hotels-page .hotels-grid,.hotels-page .destinations-grid,.hotels-page .process-grid{grid-template-columns:repeat(2,1fr)}.hotels-page .intro,.hotels-page .process-top,.hotels-page .planning-inner{grid-template-columns:1fr;gap:40px}}
@media (max-width:768px){.hotels-page .hero-content{padding:0 32px 52px}.hotels-page .intro,.hotels-page .destinations-section,.hotels-page .collection-section,.hotels-page .process-section,.hotels-page .planning-section{padding-left:32px;padding-right:32px}.hotels-page .destinations-grid{grid-template-columns:1fr 1fr}.hotels-page .hotels-grid,.hotels-page .process-grid,.hotels-page .form-grid{grid-template-columns:1fr}.hotels-page .collection-header{flex-direction:column;align-items:flex-start}.hotels-page .hero{min-height:620px}.hotels-page .form-full{grid-column:auto}}
</style>

<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
	<div class="clear"></div>
</div>

<main class="hotels-page">
	<section class="hero">
		<img class="hero-img" src="<?php echo esc_url( $hero_image ); ?>" alt="">
		<div class="hero-overlay"></div>
		<div class="hero-content reveal">
			<span class="hero-eyebrow"><?php echo wp_kses_post( $hero_eyebrow ); ?></span>
			<h1 class="hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="hero-sub"><?php echo esc_html( $hero_text ); ?></p>
			<?php if ( $hero_button_label && $hero_button_url ) : ?>
				<a href="<?php echo esc_url( $hero_button_url ); ?>" class="hero-btn"><?php echo esc_html( $hero_button_label ); ?></a>
			<?php endif; ?>
		</div>
	</section>

	<section class="intro reveal">
		<div class="intro-left">
			<h2><?php echo wp_kses_post( $intro_title ); ?></h2>
		</div>
		<div class="intro-right">
			<?php echo wp_kses_post( $intro_body ); ?>
		</div>
	</section>

	<section class="collection-section" id="collection">
		<div class="collection-header reveal">
			<div>
				<span class="section-label" style="display:block;margin-bottom:14px;"><?php echo wp_kses_post( $collection_label ); ?></span>
				<h2 class="collection-title"><?php echo wp_kses_post( $collection_title ); ?></h2>
			</div>
			<div class="filters-row">
				<div class="filter-select-wrap">
					<select class="filter-select" id="regionFilter" aria-label="Filter by region">
						<?php foreach ( $filter_regions as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>"><?php echo wp_kses_post( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<span class="filter-arrow">&#9662;</span>
				</div>
				<div class="filter-select-wrap">
					<select class="filter-select" id="brandFilter" aria-label="Filter by brand">
						<?php foreach ( $filter_brands as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>"><?php echo wp_kses_post( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<span class="filter-arrow">&#9662;</span>
				</div>
				<div class="filter-select-wrap">
					<select class="filter-select" id="typeFilter" aria-label="Filter by type">
						<?php foreach ( $filter_types as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>"><?php echo wp_kses_post( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<span class="filter-arrow">&#9662;</span>
				</div>
				<div class="search-wrap">
					<input type="text" class="search-input" id="searchInput" placeholder="Search properties...">
					<span class="search-icon">&#9906;</span>
				</div>
				<span class="results-count" id="resultsCount"><?php echo esc_html( count( (array) $hotels ) ); ?> Properties</span>
			</div>
		</div>
		<div class="hotels-grid" id="hotelsGrid">
			<?php foreach ( (array) $hotels as $hotel ) : ?>
				<?php
				$hotel_image = sedgemore_hotels_asset_url( $hotel['image'] ?? '', 'large' );
				$hotel_name  = $hotel['name'] ?? '';
				$hotel_tags  = array_filter( array_map( 'trim', explode( ',', (string) ( $hotel['tags'] ?? '' ) ) ) );
				?>
				<div class="hotel-card reveal" data-region="<?php echo esc_attr( $hotel['region'] ?? '' ); ?>" data-brand="<?php echo esc_attr( $hotel['brand'] ?? '' ); ?>" data-type="<?php echo esc_attr( $hotel['type'] ?? '' ); ?>" data-name="<?php echo esc_attr( strtolower( wp_strip_all_tags( $hotel_name . ' ' . ( $hotel['location'] ?? '' ) ) ) ); ?>">
					<div class="hotel-img-wrap">
						<img class="hotel-img" src="<?php echo esc_url( $hotel_image ); ?>" alt="<?php echo esc_attr( $hotel_name ); ?>">
						<?php if ( ! empty( $hotel['badge'] ) ) : ?>
							<span class="hotel-badge"><?php echo esc_html( $hotel['badge'] ); ?></span>
						<?php endif; ?>
					</div>
					<div class="hotel-body">
						<p class="hotel-loc"><?php echo esc_html( $hotel['location'] ?? '' ); ?></p>
						<h3 class="hotel-name"><?php echo esc_html( $hotel_name ); ?></h3>
						<p class="hotel-desc"><?php echo esc_html( $hotel['description'] ?? '' ); ?></p>
						<div class="hotel-tags">
							<?php foreach ( $hotel_tags as $tag ) : ?>
								<span class="hotel-tag"><?php echo esc_html( $tag ); ?></span>
							<?php endforeach; ?>
						</div>
						<a href="#enquiry" class="hotel-enquire">Enquire</a>
					</div>
				</div>
			<?php endforeach; ?>
			<div class="no-results" id="noResults">No properties match your current selection.</div>
		</div>
	</section>

	<section class="destinations-section">
		<span class="section-label reveal"><?php echo esc_html( $destinations_label ); ?></span>
		<div class="destinations-grid">
			<?php foreach ( (array) $destinations as $destination ) : ?>
				<?php $destination_image = sedgemore_hotels_asset_url( $destination['image'] ?? '', 'large' ); ?>
				<div class="dest-card reveal">
					<img src="<?php echo esc_url( $destination_image ); ?>" alt="<?php echo esc_attr( $destination['name'] ?? '' ); ?>">
					<div class="dest-card-overlay"></div>
					<div class="dest-card-text">
						<p class="dest-card-region"><?php echo esc_html( $destination['region'] ?? '' ); ?></p>
						<h3 class="dest-card-name"><?php echo esc_html( $destination['name'] ?? '' ); ?></h3>
						<p class="dest-card-sub"><?php echo esc_html( $destination['subtitle'] ?? '' ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="process-section">
		<div class="process-top reveal">
			<h2><?php echo wp_kses_post( $process_title ); ?></h2>
			<p><?php echo esc_html( $process_text ); ?></p>
		</div>
		<div class="process-grid">
			<?php foreach ( (array) $process_steps as $step ) : ?>
				<div class="process-step reveal">
					<span class="process-num"><?php echo esc_html( $step['number'] ?? '' ); ?></span>
					<p class="process-step-label"><?php echo esc_html( $step['step'] ?? '' ); ?></p>
					<h3><?php echo esc_html( $step['heading'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $step['text'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="planning-section" id="enquiry">
		<div class="planning-inner">
			<div class="planning-left reveal">
				<span class="plan-label"><?php echo esc_html( $enquiry_eyebrow ); ?></span>
				<h2><?php echo wp_kses_post( $enquiry_title ); ?></h2>
				<p><?php echo wp_kses_post( $enquiry_text ); ?></p>
			</div>
			<form id="sedgemore__form" class="reveal">
				<span class="interest-label"><?php echo esc_html( $interest_label ); ?></span>
				<div class="interest-row" role="group" aria-label="<?php echo esc_attr( $interest_label ); ?>">
					<?php foreach ( (array) $interest_options as $index => $option ) : ?>
						<?php
						$option_label = $option['label'] ?? '';
						$option_value = $option['value'] ?? wp_strip_all_tags( $option_label );
						if ( ! $option_label ) {
							continue;
						}
						$option_id = 'hotel_interest_' . $index . '_' . sanitize_title( $option_value );
						?>
						<label class="interest-btn" for="<?php echo esc_attr( $option_id ); ?>">
							<input id="<?php echo esc_attr( $option_id ); ?>" type="checkbox" name="hotel_interest[]" value="<?php echo esc_attr( $option_value ); ?>">
							<span><?php echo wp_kses_post( $option_label ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
				<div class="form-grid">
					<div>
						<label class="screen-reader-text" for="sedgemore__destination">Destination</label>
						<input type="text" class="form-input" id="sedgemore__destination" name="destination_display" placeholder="Destination">
						<div class="error-message" data-field="sedgemore__destination"></div>
					</div>
					<div>
						<label class="screen-reader-text" for="sedgemore__dates">Travel Dates</label>
						<input type="text" class="form-input" id="sedgemore__dates" name="dates" placeholder="Travel Dates" required>
						<div class="error-message" data-field="sedgemore__dates"></div>
					</div>
					<div>
						<label class="screen-reader-text" for="sedgemore__first_name">First Name</label>
						<input type="text" class="form-input" id="sedgemore__first_name" name="first_name" placeholder="First Name" required>
						<div class="error-message" data-field="sedgemore__first_name"></div>
					</div>
					<div>
						<label class="screen-reader-text" for="sedgemore__last_name">Last Name</label>
						<input type="text" class="form-input" id="sedgemore__last_name" name="last_name" placeholder="Last Name" required>
						<div class="error-message" data-field="sedgemore__last_name"></div>
					</div>
					<div>
						<label class="screen-reader-text" for="sedgemore__email_address">Email Address</label>
						<input type="email" class="form-input" id="sedgemore__email_address" name="email_address" placeholder="Email Address" required>
						<div class="error-message" data-field="sedgemore__email_address"></div>
					</div>
					<div>
						<label class="screen-reader-text" for="sedgemore__phone">Phone</label>
						<input type="tel" class="form-input" id="sedgemore__phone" name="phone" placeholder="Phone">
						<div class="error-message" data-field="sedgemore__phone"></div>
					</div>
					<div>
						<label class="screen-reader-text" for="sedgemore__group_size">Group Size</label>
						<input type="text" class="form-input" id="sedgemore__group_size" name="group_size_display" placeholder="Group Size">
						<div class="error-message" data-field="sedgemore__group_size"></div>
					</div>
					<label class="screen-reader-text" for="sedgemore__message">Notes</label>
					<textarea class="form-input form-full" id="sedgemore__message" name="message" rows="3" placeholder="Hotel of interest or anything we should know before we begin"></textarea>
					<p id="sedgemore__form-message" class="form-message" aria-live="polite"></p>
					<button class="form-submit" type="submit"><?php echo esc_html( $submit_label ); ?></button>
					<input type="hidden" id="sedgemore__preferences" name="preferences" value="Hotels and resorts enquiry">
					<input type="hidden" name="form_origin" value="hotels_and_resorts">
					<input type="hidden" name="action" value="travel_contact_form">
					<?php wp_nonce_field( 'travel_contact_nonce_action', 'travel_contact_nonce' ); ?>
				</div>
			</form>
		</div>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var page = document.querySelector('.hotels-page');
	var reveals = document.querySelectorAll('.hotels-page .reveal');
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

		reveals.forEach(function (el) { observer.observe(el); });
	} else {
		reveals.forEach(function (el) { el.classList.add('visible'); });
	}

	function applyFilters() {
		var region = document.getElementById('regionFilter').value;
		var brand = document.getElementById('brandFilter').value;
		var type = document.getElementById('typeFilter').value;
		var search = document.getElementById('searchInput').value.toLowerCase().trim();
		var cards = document.querySelectorAll('.hotel-card[data-region]');
		var visible = 0;

		cards.forEach(function (card) {
			var matchesRegion = region === 'all' || card.dataset.region === region;
			var matchesBrand = brand === 'all' || card.dataset.brand === brand;
			var matchesType = type === 'all' || (card.dataset.type || '').split(/\s+/).indexOf(type) !== -1;
			var matchesSearch = !search || (card.dataset.name || '').indexOf(search) !== -1;
			var show = matchesRegion && matchesBrand && matchesType && matchesSearch;
			card.classList.toggle('hidden', !show);
			if (show) {
				visible++;
			}
		});

		document.getElementById('resultsCount').textContent = visible + (visible === 1 ? ' Property' : ' Properties');
		document.getElementById('noResults').classList.toggle('visible', visible === 0);
	}

	['regionFilter', 'brandFilter', 'typeFilter'].forEach(function (id) {
		var filter = document.getElementById(id);
		if (filter) {
			filter.addEventListener('change', applyFilters);
		}
	});

	var searchInput = document.getElementById('searchInput');
	if (searchInput) {
		searchInput.addEventListener('input', applyFilters);
	}

	if (form) {
		var chips = form.querySelectorAll('.interest-btn');
		var preferences = document.getElementById('sedgemore__preferences');
		var destination = document.getElementById('sedgemore__destination');
		var groupSize = document.getElementById('sedgemore__group_size');

		function syncPreferences() {
			var selected = [];
			form.querySelectorAll('input[name="hotel_interest[]"]:checked').forEach(function (input) {
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

			preferences.value = parts.length ? parts.join(' | ') : 'Hotels and resorts enquiry';
		}

		chips.forEach(function (chip) {
			var input = chip.querySelector('input');
			if (!input) {
				return;
			}

			input.addEventListener('change', function () {
				chip.classList.toggle('selected', input.checked);
				syncPreferences();
			});
		});

		['input', 'change'].forEach(function (eventName) {
			form.addEventListener(eventName, syncPreferences, true);
		});

		form.addEventListener('submit', syncPreferences, true);
		form.addEventListener('reset', function () {
			setTimeout(function () {
				chips.forEach(function (chip) { chip.classList.remove('selected'); });
				syncPreferences();
			}, 0);
		});
	}

	if (page) {
		applyFilters();
	}
});
</script>

<?php
get_footer();
