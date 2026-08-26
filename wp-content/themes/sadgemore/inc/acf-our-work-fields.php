<?php
/**
 * Our Work page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_our_work_page_fields' );

function sadgemore_our_work_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_our_work_page_' . $key,
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

function sadgemore_our_work_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_our_work_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_our_work_acf_repeater_field( $key, $label, $name, $sub_fields, $button_label ) {
	return array(
		'key'          => 'field_our_work_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'row',
		'button_label' => $button_label,
		'sub_fields'   => $sub_fields,
	);
}

function sadgemore_register_our_work_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_our_work_page',
			'title'                 => 'Our Work Page',
			'fields'                => array(
				array( 'key' => 'field_our_work_page_hero_tab', 'label' => 'Hero', 'name' => '', 'type' => 'tab' ),
				sadgemore_our_work_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'our_work_hero_eyebrow' ),
				sadgemore_our_work_acf_text_field( 'hero_title', 'Title', 'our_work_hero_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_our_work_acf_text_field( 'hero_intro', 'Intro text', 'our_work_hero_intro', 'textarea' ),

				array( 'key' => 'field_our_work_page_gallery_tab', 'label' => 'Gallery', 'name' => '', 'type' => 'tab' ),
				sadgemore_our_work_acf_repeater_field(
					'gallery',
					'Gallery items',
					'our_work_gallery',
					array(
						sadgemore_our_work_acf_image_field( 'gallery_image', 'Image', 'image', 'SVG uploads are supported by the template defaults; use the uploaded artwork for this project.' ),
						sadgemore_our_work_acf_text_field( 'gallery_title', 'Title', 'title' ),
						sadgemore_our_work_acf_text_field( 'gallery_location', 'Location', 'location' ),
						array(
							'key'           => 'field_our_work_page_gallery_span',
							'label'         => 'Span two columns',
							'name'          => 'span',
							'type'          => 'true_false',
							'instructions'  => 'Used by the first gallery item to match the static layout.',
							'ui'            => 1,
							'default_value' => 0,
						),
					),
					'Add gallery item'
				),

				array( 'key' => 'field_our_work_page_statement_tab', 'label' => 'Statement', 'name' => '', 'type' => 'tab' ),
				sadgemore_our_work_acf_text_field( 'statement_eyebrow', 'Eyebrow', 'our_work_statement_eyebrow' ),
				sadgemore_our_work_acf_text_field( 'statement_title', 'Title', 'our_work_statement_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_our_work_acf_text_field( 'statement_text', 'Text', 'our_work_statement_text', 'textarea' ),
				sadgemore_our_work_acf_text_field( 'statement_button', 'Button label', 'our_work_statement_button' ),

				array( 'key' => 'field_our_work_page_enquiry_tab', 'label' => 'Enquiry', 'name' => '', 'type' => 'tab' ),
				sadgemore_our_work_acf_text_field( 'enquiry_eyebrow', 'Eyebrow', 'our_work_enquiry_eyebrow' ),
				sadgemore_our_work_acf_text_field( 'enquiry_title', 'Title', 'our_work_enquiry_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_our_work_acf_text_field( 'enquiry_text', 'Text', 'our_work_enquiry_text', 'textarea' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/our-work.php',
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
