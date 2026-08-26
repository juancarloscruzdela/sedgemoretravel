<?php
/**
 * Private Yachts page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_private_yachts_page_fields' );

function sadgemore_private_yachts_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_private_yachts_page_' . $key,
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

function sadgemore_private_yachts_acf_wysiwyg_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'          => 'field_private_yachts_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'wysiwyg',
		'instructions' => $instructions,
		'tabs'         => 'all',
		'toolbar'      => 'basic',
		'media_upload' => 0,
	);
}

function sadgemore_private_yachts_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_private_yachts_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_private_yachts_acf_repeater_field( $key, $label, $name, $sub_fields, $button_label ) {
	return array(
		'key'          => 'field_private_yachts_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'row',
		'button_label' => $button_label,
		'sub_fields'   => $sub_fields,
	);
}

function sadgemore_register_private_yachts_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_private_yachts_page',
			'title'                 => 'Private Yachts Page',
			'fields'                => array(
				array( 'key' => 'field_private_yachts_page_hero_tab', 'label' => 'Hero', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_yachts_acf_image_field( 'hero_image', 'Hero image', 'private_yachts_hero_image' ),
				sadgemore_private_yachts_acf_text_field( 'hero_label', 'Label', 'private_yachts_hero_label' ),
				sadgemore_private_yachts_acf_text_field( 'hero_title', 'Title', 'private_yachts_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis, for example <br> and <em>.' ),
				sadgemore_private_yachts_acf_text_field( 'hero_button_label', 'Button label', 'private_yachts_hero_button_label' ),
				sadgemore_private_yachts_acf_text_field( 'hero_button_url', 'Button URL', 'private_yachts_hero_button_url', 'url' ),

				array( 'key' => 'field_private_yachts_page_intro_tab', 'label' => 'Intro', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_yachts_acf_text_field( 'intro_label', 'Label', 'private_yachts_intro_label' ),
				sadgemore_private_yachts_acf_text_field( 'intro_title', 'Title', 'private_yachts_intro_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_private_yachts_acf_text_field( 'intro_body', 'Body copy', 'private_yachts_intro_body', 'textarea' ),

				array( 'key' => 'field_private_yachts_page_split_tab', 'label' => 'Split Section', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_yachts_acf_image_field( 'split_image', 'Image', 'private_yachts_split_image' ),
				sadgemore_private_yachts_acf_text_field( 'split_label', 'Label', 'private_yachts_split_label' ),
				sadgemore_private_yachts_acf_text_field( 'split_title', 'Title', 'private_yachts_split_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_private_yachts_acf_wysiwyg_field( 'split_body', 'Body copy', 'private_yachts_split_body' ),

				array( 'key' => 'field_private_yachts_page_arrange_tab', 'label' => 'What We Arrange', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_yachts_acf_text_field( 'arrange_label', 'Label', 'private_yachts_arrange_label' ),
				sadgemore_private_yachts_acf_text_field( 'arrange_title', 'Title', 'private_yachts_arrange_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_private_yachts_acf_repeater_field(
					'arrange_items',
					'Arrangement cards',
					'private_yachts_arrange_items',
					array(
						sadgemore_private_yachts_acf_text_field( 'arrange_number', 'Number', 'number' ),
						sadgemore_private_yachts_acf_text_field( 'arrange_item_title', 'Title', 'title' ),
						sadgemore_private_yachts_acf_text_field( 'arrange_item_text', 'Text', 'text', 'textarea' ),
					),
					'Add arrangement'
				),

				array( 'key' => 'field_private_yachts_page_testimonial_tab', 'label' => 'Testimonial', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_yachts_acf_text_field( 'testimonial_text', 'Quote', 'private_yachts_testimonial_text', 'textarea' ),
				sadgemore_private_yachts_acf_text_field( 'testimonial_cite', 'Citation', 'private_yachts_testimonial_cite' ),

				array( 'key' => 'field_private_yachts_page_destinations_tab', 'label' => 'Destinations', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_yachts_acf_text_field( 'destinations_label', 'Label', 'private_yachts_destinations_label' ),
				sadgemore_private_yachts_acf_text_field( 'destinations_title', 'Title', 'private_yachts_destinations_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_private_yachts_acf_text_field( 'destinations_text', 'Text', 'private_yachts_destinations_text', 'textarea' ),
				sadgemore_private_yachts_acf_repeater_field(
					'destinations',
					'Destination cards',
					'private_yachts_destinations',
					array(
						sadgemore_private_yachts_acf_image_field( 'destination_image', 'Image', 'image' ),
						sadgemore_private_yachts_acf_text_field( 'destination_region', 'Region', 'region' ),
						sadgemore_private_yachts_acf_text_field( 'destination_name', 'Name', 'name' ),
					),
					'Add destination'
				),

				array( 'key' => 'field_private_yachts_page_enquiry_tab', 'label' => 'Enquiry', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_yachts_acf_text_field( 'enquiry_label', 'Label', 'private_yachts_enquiry_label' ),
				sadgemore_private_yachts_acf_text_field( 'enquiry_title', 'Title', 'private_yachts_enquiry_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_private_yachts_acf_text_field( 'enquiry_text', 'Text', 'private_yachts_enquiry_text', 'textarea' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/private-yachts.php',
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
