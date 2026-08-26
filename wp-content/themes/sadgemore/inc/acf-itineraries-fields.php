<?php
/**
 * Itineraries page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_itineraries_page_fields' );

function sadgemore_itineraries_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_itineraries_page_' . $key,
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

function sadgemore_itineraries_acf_wysiwyg_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'          => 'field_itineraries_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'wysiwyg',
		'instructions' => $instructions,
		'tabs'         => 'all',
		'toolbar'      => 'basic',
		'media_upload' => 0,
	);
}

function sadgemore_itineraries_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_itineraries_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_register_itineraries_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_itineraries_page',
			'title'                 => 'Itineraries Page',
			'fields'                => array(
				array(
					'key'   => 'field_itineraries_page_hero_tab',
					'label' => 'Hero',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_itineraries_acf_image_field( 'hero_image', 'Hero image', 'itineraries_page_hero_image' ),
				sadgemore_itineraries_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'itineraries_page_hero_eyebrow' ),
				sadgemore_itineraries_acf_text_field( 'hero_title', 'Title', 'itineraries_page_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_itineraries_acf_text_field( 'hero_text', 'Intro text', 'itineraries_page_hero_text', 'textarea' ),
				sadgemore_itineraries_acf_text_field( 'hero_button_label', 'Button label', 'itineraries_page_hero_button_label' ),
				sadgemore_itineraries_acf_text_field( 'hero_button_url', 'Button URL', 'itineraries_page_hero_button_url', 'url' ),

				array(
					'key'   => 'field_itineraries_page_intro_tab',
					'label' => 'Intro',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_itineraries_acf_text_field( 'intro_title', 'Intro title', 'itineraries_page_intro_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_itineraries_acf_wysiwyg_field( 'intro_body', 'Intro body', 'itineraries_page_intro_body' ),

				array(
					'key'   => 'field_itineraries_page_destinations_tab',
					'label' => 'Destinations',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_itineraries_acf_text_field( 'destinations_label', 'Section label', 'itineraries_page_destinations_label' ),
				array(
					'key'          => 'field_itineraries_page_destinations',
					'label'        => 'Destination cards',
					'name'         => 'itineraries_page_destinations',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add destination',
					'sub_fields'   => array(
						sadgemore_itineraries_acf_image_field( 'destination_image', 'Image', 'image' ),
						sadgemore_itineraries_acf_text_field( 'destination_region', 'Region', 'region' ),
						sadgemore_itineraries_acf_text_field( 'destination_name', 'Name', 'name' ),
						sadgemore_itineraries_acf_text_field( 'destination_subtitle', 'Subtitle', 'subtitle', 'textarea' ),
						sadgemore_itineraries_acf_text_field( 'destination_link_label', 'Link label', 'link_label' ),
						sadgemore_itineraries_acf_text_field( 'destination_link_url', 'Link URL', 'link_url', 'url' ),
					),
				),

				array(
					'key'   => 'field_itineraries_page_process_tab',
					'label' => 'Process',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_itineraries_acf_text_field( 'process_title', 'Process title', 'itineraries_page_process_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_itineraries_acf_text_field( 'process_text', 'Process intro text', 'itineraries_page_process_text', 'textarea' ),
				array(
					'key'          => 'field_itineraries_page_process_steps',
					'label'        => 'Process steps',
					'name'         => 'itineraries_page_process_steps',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add step',
					'sub_fields'   => array(
						sadgemore_itineraries_acf_text_field( 'process_step_number', 'Number', 'number' ),
						sadgemore_itineraries_acf_text_field( 'process_step_label', 'Step label', 'step' ),
						sadgemore_itineraries_acf_text_field( 'process_step_heading', 'Heading', 'heading' ),
						sadgemore_itineraries_acf_text_field( 'process_step_text', 'Text', 'text', 'textarea' ),
					),
				),

				array(
					'key'   => 'field_itineraries_page_enquiry_tab',
					'label' => 'Enquiry',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_itineraries_acf_text_field( 'enquiry_eyebrow', 'Eyebrow', 'itineraries_page_enquiry_eyebrow' ),
				sadgemore_itineraries_acf_text_field( 'enquiry_title', 'Title', 'itineraries_page_enquiry_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_itineraries_acf_text_field( 'enquiry_text', 'Text', 'itineraries_page_enquiry_text', 'textarea' ),
				sadgemore_itineraries_acf_text_field( 'interest_label', 'Interest label', 'itineraries_page_interest_label' ),
				array(
					'key'          => 'field_itineraries_page_interest_options',
					'label'        => 'Interest options',
					'name'         => 'itineraries_page_interest_options',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Add option',
					'sub_fields'   => array(
						sadgemore_itineraries_acf_text_field( 'interest_option_label', 'Label', 'label' ),
						sadgemore_itineraries_acf_text_field( 'interest_option_value', 'Value', 'value' ),
					),
				),
				sadgemore_itineraries_acf_text_field( 'submit_label', 'Submit label', 'itineraries_page_submit_label' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/itineraries.php',
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
