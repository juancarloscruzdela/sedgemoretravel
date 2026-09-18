<?php
/**
 * Sedgemore Collective landing page fields.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_collective_page_fields' );

function sadgemore_collective_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_collective_' . $key,
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

function sadgemore_collective_list_field( $key, $label, $name ) {
	return array(
		'key'          => 'field_collective_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'table',
		'button_label' => 'Add item',
		'sub_fields'   => array(
			array(
				'key'   => 'field_collective_' . $key . '_text',
				'label' => 'Text',
				'name'  => 'text',
				'type'  => 'text',
			),
		),
	);
}

function sadgemore_register_collective_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_sedgemore_collective_page',
			'title'  => 'Sedgemore Collective Page',
			'fields' => array(
				array( 'key' => 'field_collective_hero_tab', 'label' => 'Hero', 'type' => 'tab' ),
				sadgemore_collective_text_field( 'hero_label', 'Label', 'collective_hero_label' ),
				sadgemore_collective_text_field( 'hero_title', 'Title', 'collective_hero_title', 'textarea', 'Basic emphasis is allowed, for example <em>behind you</em>.' ),
				sadgemore_collective_text_field( 'hero_text', 'Introductory text', 'collective_hero_text', 'textarea' ),
				sadgemore_collective_text_field( 'hero_button', 'Button label', 'collective_hero_button' ),

				array( 'key' => 'field_collective_benefits_tab', 'label' => 'Benefits', 'type' => 'tab' ),
				sadgemore_collective_text_field( 'benefits_label', 'Section label', 'collective_benefits_label' ),
				sadgemore_collective_text_field( 'benefits_title', 'Section title', 'collective_benefits_title', 'textarea', 'Basic emphasis is allowed.' ),
				sadgemore_collective_text_field( 'bring_label', 'Left column label', 'collective_bring_label' ),
				sadgemore_collective_list_field( 'bring_items', 'You bring items', 'collective_bring_items' ),
				sadgemore_collective_text_field( 'provide_label', 'Right column label', 'collective_provide_label' ),
				sadgemore_collective_list_field( 'provide_items', 'We provide items', 'collective_provide_items' ),

				array( 'key' => 'field_collective_form_tab', 'label' => 'Enquiry Form', 'type' => 'tab' ),
				sadgemore_collective_text_field( 'form_label', 'Section label', 'collective_form_label' ),
				sadgemore_collective_text_field( 'form_title', 'Section title', 'collective_form_title', 'textarea', 'Basic emphasis is allowed.' ),
				sadgemore_collective_text_field( 'form_intro', 'Introductory text', 'collective_form_intro', 'textarea' ),
				sadgemore_collective_text_field( 'form_button', 'Submit button label', 'collective_form_button' ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/collective.php',
					),
				),
			),
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
