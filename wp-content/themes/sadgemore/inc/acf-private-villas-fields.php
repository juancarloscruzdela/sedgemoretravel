<?php
/**
 * Private Villas page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_private_villas_page_fields' );

function sadgemore_private_villas_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_private_villas_page_' . $key,
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

function sadgemore_private_villas_acf_wysiwyg_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'          => 'field_private_villas_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'wysiwyg',
		'instructions' => $instructions,
		'tabs'         => 'all',
		'toolbar'      => 'basic',
		'media_upload' => 0,
	);
}

function sadgemore_private_villas_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_private_villas_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_private_villas_acf_repeater_field( $key, $label, $name, $sub_fields, $button_label ) {
	return array(
		'key'          => 'field_private_villas_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'row',
		'button_label' => $button_label,
		'sub_fields'   => $sub_fields,
	);
}

function sadgemore_register_private_villas_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_private_villas_page',
			'title'                 => 'Private Villas Page',
			'fields'                => array(
				array( 'key' => 'field_private_villas_page_hero_tab', 'label' => 'Hero', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_image_field( 'hero_image', 'Hero image', 'private_villas_hero_image' ),
				sadgemore_private_villas_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'private_villas_hero_eyebrow' ),
				sadgemore_private_villas_acf_text_field( 'hero_title', 'Title', 'private_villas_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis, for example <br> and <em>.' ),
				sadgemore_private_villas_acf_text_field( 'hero_subtitle', 'Subtitle', 'private_villas_hero_subtitle', 'textarea' ),
				sadgemore_private_villas_acf_text_field( 'hero_button_label', 'Button label', 'private_villas_hero_button_label' ),
				sadgemore_private_villas_acf_text_field( 'hero_button_url', 'Button URL', 'private_villas_hero_button_url', 'url' ),

				array( 'key' => 'field_private_villas_page_intro_tab', 'label' => 'Intro', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_text_field( 'intro_label', 'Label', 'private_villas_intro_label' ),
				sadgemore_private_villas_acf_text_field( 'intro_title', 'Title', 'private_villas_intro_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_private_villas_acf_wysiwyg_field( 'intro_body', 'Body copy', 'private_villas_intro_body' ),
				sadgemore_private_villas_acf_image_field( 'intro_image', 'Image', 'private_villas_intro_image' ),
				sadgemore_private_villas_acf_text_field( 'intro_image_caption', 'Image caption', 'private_villas_intro_image_caption' ),

				array( 'key' => 'field_private_villas_page_pillars_tab', 'label' => 'Pillars', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_text_field( 'pillars_label', 'Label', 'private_villas_pillars_label' ),
				sadgemore_private_villas_acf_text_field( 'pillars_title', 'Title', 'private_villas_pillars_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_private_villas_acf_text_field( 'pillars_text', 'Intro text', 'private_villas_pillars_text', 'textarea' ),
				sadgemore_private_villas_acf_repeater_field(
					'pillars',
					'Pillar cards',
					'private_villas_pillars',
					array(
						sadgemore_private_villas_acf_text_field( 'pillar_number', 'Number', 'number' ),
						sadgemore_private_villas_acf_text_field( 'pillar_title', 'Title', 'title', 'textarea', 'HTML is allowed for emphasis.' ),
						sadgemore_private_villas_acf_text_field( 'pillar_text', 'Text', 'text', 'textarea' ),
					),
					'Add pillar'
				),

				array( 'key' => 'field_private_villas_page_strip_tab', 'label' => 'Image Strip', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_repeater_field(
					'image_strip',
					'Image strip',
					'private_villas_image_strip',
					array(
						sadgemore_private_villas_acf_image_field( 'strip_image', 'Image', 'image' ),
						sadgemore_private_villas_acf_text_field( 'strip_caption', 'Caption', 'caption' ),
					),
					'Add image'
				),

				array( 'key' => 'field_private_villas_page_experience_tab', 'label' => 'Experience', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_text_field( 'experience_label', 'Label', 'private_villas_experience_label' ),
				sadgemore_private_villas_acf_text_field( 'experience_title', 'Title', 'private_villas_experience_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_private_villas_acf_text_field( 'experience_text', 'Intro text', 'private_villas_experience_text', 'textarea' ),
				sadgemore_private_villas_acf_repeater_field(
					'experience_items',
					'Experience items',
					'private_villas_experience_items',
					array(
						sadgemore_private_villas_acf_text_field( 'experience_marker', 'Marker', 'marker' ),
						sadgemore_private_villas_acf_text_field( 'experience_item_title', 'Title', 'title' ),
						sadgemore_private_villas_acf_text_field( 'experience_item_text', 'Text', 'text', 'textarea' ),
					),
					'Add experience item'
				),

				array( 'key' => 'field_private_villas_page_process_tab', 'label' => 'Process', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_text_field( 'process_label', 'Label', 'private_villas_process_label' ),
				sadgemore_private_villas_acf_text_field( 'process_title', 'Title', 'private_villas_process_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_private_villas_acf_text_field( 'process_text', 'Intro text', 'private_villas_process_text', 'textarea' ),
				sadgemore_private_villas_acf_repeater_field(
					'process_items',
					'Process cards',
					'private_villas_process_items',
					array(
						sadgemore_private_villas_acf_text_field( 'process_number', 'Number', 'number' ),
						sadgemore_private_villas_acf_text_field( 'process_item_title', 'Title', 'title' ),
						sadgemore_private_villas_acf_text_field( 'process_item_text', 'Text', 'text', 'textarea' ),
					),
					'Add process card'
				),

				array( 'key' => 'field_private_villas_page_testimonial_tab', 'label' => 'Testimonial', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_text_field( 'testimonial_text', 'Quote', 'private_villas_testimonial_text', 'textarea' ),
				sadgemore_private_villas_acf_text_field( 'testimonial_cite', 'Citation', 'private_villas_testimonial_cite' ),

				array( 'key' => 'field_private_villas_page_enquiry_tab', 'label' => 'Enquiry', 'name' => '', 'type' => 'tab' ),
				sadgemore_private_villas_acf_text_field( 'enquiry_label', 'Label', 'private_villas_enquiry_label' ),
				sadgemore_private_villas_acf_text_field( 'enquiry_title', 'Title', 'private_villas_enquiry_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_private_villas_acf_text_field( 'enquiry_text', 'Text', 'private_villas_enquiry_text', 'textarea' ),
				sadgemore_private_villas_acf_text_field( 'form_note', 'Form note', 'private_villas_form_note', 'textarea' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/private-villas.php',
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
