<?php
/**
 * Hotels & Resorts page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_hotels_resorts_page_fields' );

function sadgemore_hotels_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_hotels_page_' . $key,
		'label' => $label,
		'name'  => $name,
		'type'  => $type,
	);

	if ( $instructions ) {
		$field['instructions'] = $instructions;
	}

	if ( 'textarea' === $type ) {
		$field['rows'] = 4;
	}

	return $field;
}

function sadgemore_hotels_acf_wysiwyg_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'          => 'field_hotels_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'wysiwyg',
		'instructions' => $instructions,
		'tabs'         => 'all',
		'toolbar'      => 'basic',
		'media_upload' => 0,
	);
}

function sadgemore_hotels_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_hotels_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_hotels_acf_repeater_field( $key, $label, $name, $sub_fields, $button_label ) {
	return array(
		'key'          => 'field_hotels_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'row',
		'button_label' => $button_label,
		'sub_fields'   => $sub_fields,
	);
}

function sadgemore_register_hotels_resorts_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_hotels_resorts_page',
			'title'                 => 'Hotels & Resorts Page',
			'fields'                => array(
				array( 'key' => 'field_hotels_page_hero_tab', 'label' => 'Hero', 'name' => '', 'type' => 'tab' ),
				sadgemore_hotels_acf_image_field( 'hero_image', 'Hero image', 'hotels_page_hero_image', 'Falls back to /wp-content/uploads/2026/06/hero-banner.webp.' ),
				sadgemore_hotels_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'hotels_page_hero_eyebrow' ),
				sadgemore_hotels_acf_text_field( 'hero_title', 'Title', 'hotels_page_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_hotels_acf_text_field( 'hero_text', 'Intro text', 'hotels_page_hero_text', 'textarea' ),
				sadgemore_hotels_acf_text_field( 'hero_button_label', 'Button label', 'hotels_page_hero_button_label' ),
				sadgemore_hotels_acf_text_field( 'hero_button_url', 'Button URL', 'hotels_page_hero_button_url', 'url' ),

				array( 'key' => 'field_hotels_page_intro_tab', 'label' => 'Intro', 'name' => '', 'type' => 'tab' ),
				sadgemore_hotels_acf_text_field( 'intro_title', 'Intro title', 'hotels_page_intro_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_hotels_acf_wysiwyg_field( 'intro_body', 'Intro body', 'hotels_page_intro_body' ),

				array( 'key' => 'field_hotels_page_collection_tab', 'label' => 'Hotel Collection', 'name' => '', 'type' => 'tab' ),
				sadgemore_hotels_acf_text_field( 'collection_label', 'Section label', 'hotels_page_collection_label' ),
				sadgemore_hotels_acf_text_field( 'collection_title', 'Collection title', 'hotels_page_collection_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_hotels_acf_repeater_field(
					'hotels',
					'Hotels',
					'hotels_page_hotels',
					array(
						sadgemore_hotels_acf_image_field( 'hotel_image', 'Image', 'image' ),
						sadgemore_hotels_acf_text_field( 'hotel_badge', 'Badge', 'badge' ),
						sadgemore_hotels_acf_text_field( 'hotel_location', 'Location', 'location' ),
						sadgemore_hotels_acf_text_field( 'hotel_name', 'Name', 'name' ),
						sadgemore_hotels_acf_text_field( 'hotel_description', 'Description', 'description', 'textarea' ),
						sadgemore_hotels_acf_text_field( 'hotel_tags', 'Tags', 'tags', 'text', 'Comma-separated tags, e.g. Heritage, City, Iconic.' ),
						sadgemore_hotels_acf_text_field( 'hotel_region', 'Filter region', 'region', 'text', 'Use values such as europe, asia, africa, americas, middleeast.' ),
						sadgemore_hotels_acf_text_field( 'hotel_brand', 'Filter brand', 'brand', 'text', 'Use values such as fourseasons, mandarin, aman, rosewood, taj, belmond, independent.' ),
						sadgemore_hotels_acf_text_field( 'hotel_type', 'Filter type', 'type', 'text', 'Space-separated values such as city beach spa heritage safari island.' ),
					),
					'Add hotel'
				),

				array( 'key' => 'field_hotels_page_destinations_tab', 'label' => 'Destinations', 'name' => '', 'type' => 'tab' ),
				sadgemore_hotels_acf_text_field( 'destinations_label', 'Section label', 'hotels_page_destinations_label' ),
				sadgemore_hotels_acf_repeater_field(
					'destinations',
					'Destination cards',
					'hotels_page_destinations',
					array(
						sadgemore_hotels_acf_image_field( 'destination_image', 'Image', 'image' ),
						sadgemore_hotels_acf_text_field( 'destination_region', 'Region', 'region' ),
						sadgemore_hotels_acf_text_field( 'destination_name', 'Name', 'name' ),
						sadgemore_hotels_acf_text_field( 'destination_subtitle', 'Subtitle', 'subtitle', 'textarea' ),
					),
					'Add destination'
				),

				array( 'key' => 'field_hotels_page_process_tab', 'label' => 'Process', 'name' => '', 'type' => 'tab' ),
				sadgemore_hotels_acf_text_field( 'process_title', 'Process title', 'hotels_page_process_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_hotels_acf_text_field( 'process_text', 'Process intro text', 'hotels_page_process_text', 'textarea' ),
				sadgemore_hotels_acf_repeater_field(
					'process_steps',
					'Process steps',
					'hotels_page_process_steps',
					array(
						sadgemore_hotels_acf_text_field( 'process_step_number', 'Number', 'number' ),
						sadgemore_hotels_acf_text_field( 'process_step_label', 'Step label', 'step' ),
						sadgemore_hotels_acf_text_field( 'process_step_heading', 'Heading', 'heading' ),
						sadgemore_hotels_acf_text_field( 'process_step_text', 'Text', 'text', 'textarea' ),
					),
					'Add step'
				),

				array( 'key' => 'field_hotels_page_enquiry_tab', 'label' => 'Enquiry', 'name' => '', 'type' => 'tab' ),
				sadgemore_hotels_acf_text_field( 'enquiry_eyebrow', 'Eyebrow', 'hotels_page_enquiry_eyebrow' ),
				sadgemore_hotels_acf_text_field( 'enquiry_title', 'Title', 'hotels_page_enquiry_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_hotels_acf_text_field( 'enquiry_text', 'Text', 'hotels_page_enquiry_text', 'textarea', 'HTML is allowed for links.' ),
				sadgemore_hotels_acf_text_field( 'interest_label', 'Interest label', 'hotels_page_interest_label' ),
				sadgemore_hotels_acf_repeater_field(
					'interest_options',
					'Interest options',
					'hotels_page_interest_options',
					array(
						sadgemore_hotels_acf_text_field( 'interest_option_label', 'Label', 'label' ),
						sadgemore_hotels_acf_text_field( 'interest_option_value', 'Value', 'value' ),
					),
					'Add option'
				),
				sadgemore_hotels_acf_text_field( 'submit_label', 'Submit label', 'hotels_page_submit_label' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/hotels-resorts.php',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
