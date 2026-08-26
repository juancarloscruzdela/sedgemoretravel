<?php
/**
 * Concierge page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_concierge_page_fields' );

function sadgemore_concierge_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_concierge_page_' . $key,
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

function sadgemore_concierge_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_concierge_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_concierge_acf_repeater_field( $key, $label, $name, $sub_fields, $button_label = 'Add item' ) {
	return array(
		'key'          => 'field_concierge_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'row',
		'button_label' => $button_label,
		'sub_fields'   => $sub_fields,
	);
}

function sadgemore_register_concierge_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_concierge_page',
			'title'                 => 'Concierge Page',
			'fields'                => array(
				array( 'key' => 'field_concierge_page_hero_tab', 'label' => 'Hero', 'name' => '', 'type' => 'tab' ),
				sadgemore_concierge_acf_repeater_field(
					'hero_slides',
					'Hero slides',
					'concierge_page_hero_slides',
					array(
						sadgemore_concierge_acf_image_field( 'hero_slide_image', 'Image', 'image', 'Falls back to /wp-content/uploads/2026/06/Concierge-Video-7-scaled.png when no slides are set.' ),
					),
					'Add slide'
				),
				sadgemore_concierge_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'concierge_page_hero_eyebrow' ),
				sadgemore_concierge_acf_text_field( 'hero_title', 'Title', 'concierge_page_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_concierge_acf_text_field( 'hero_text', 'Intro text', 'concierge_page_hero_text', 'textarea' ),
				sadgemore_concierge_acf_text_field( 'hero_button_label', 'Button label', 'concierge_page_hero_button_label' ),
				sadgemore_concierge_acf_text_field( 'hero_button_url', 'Button URL', 'concierge_page_hero_button_url', 'url' ),

				array( 'key' => 'field_concierge_page_services_tab', 'label' => 'Core Services', 'name' => '', 'type' => 'tab' ),
				sadgemore_concierge_acf_text_field( 'services_label', 'Label', 'concierge_page_services_label' ),
				sadgemore_concierge_acf_text_field( 'services_title', 'Title', 'concierge_page_services_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_concierge_acf_text_field( 'services_text', 'Intro text', 'concierge_page_services_text', 'textarea' ),
				sadgemore_concierge_acf_repeater_field(
					'service_cards',
					'Service cards',
					'concierge_page_service_cards',
					array(
						sadgemore_concierge_acf_text_field( 'service_card_title', 'Title', 'title', 'textarea', 'HTML is allowed for line breaks.' ),
						sadgemore_concierge_acf_text_field( 'service_card_text', 'Text', 'text', 'textarea' ),
						sadgemore_concierge_acf_image_field( 'service_card_image', 'Image', 'image' ),
						sadgemore_concierge_acf_text_field( 'service_card_link_label', 'Link label', 'link_label' ),
						sadgemore_concierge_acf_text_field( 'service_card_link_url', 'Link URL', 'link_url', 'text', 'Accepts a hash link such as #enquire, a relative path, or a full URL.' ),
					),
					'Add service'
				),

				array( 'key' => 'field_concierge_page_support_tab', 'label' => 'Supporting Services', 'name' => '', 'type' => 'tab' ),
				sadgemore_concierge_acf_text_field( 'support_label', 'Label', 'concierge_page_support_label' ),
				sadgemore_concierge_acf_text_field( 'support_title', 'Title', 'concierge_page_support_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_concierge_acf_text_field( 'support_body', 'Body copy', 'concierge_page_support_body', 'textarea' ),
				sadgemore_concierge_acf_text_field( 'support_button_label', 'Button label', 'concierge_page_support_button_label' ),
				sadgemore_concierge_acf_text_field( 'support_button_url', 'Button URL', 'concierge_page_support_button_url', 'url' ),
				sadgemore_concierge_acf_repeater_field(
					'support_items',
					'Supporting items',
					'concierge_page_support_items',
					array(
						sadgemore_concierge_acf_text_field( 'support_item_title', 'Title', 'title' ),
						sadgemore_concierge_acf_text_field( 'support_item_text', 'Text', 'text', 'textarea' ),
					),
					'Add item'
				),

				array( 'key' => 'field_concierge_page_process_tab', 'label' => 'How We Work', 'name' => '', 'type' => 'tab' ),
				sadgemore_concierge_acf_text_field( 'process_label', 'Label', 'concierge_page_process_label' ),
				sadgemore_concierge_acf_text_field( 'process_title', 'Title', 'concierge_page_process_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_concierge_acf_text_field( 'process_text', 'Intro text', 'concierge_page_process_text', 'textarea' ),
				sadgemore_concierge_acf_repeater_field(
					'process_steps',
					'Process steps',
					'concierge_page_process_steps',
					array(
						sadgemore_concierge_acf_text_field( 'process_step_number', 'Number', 'number' ),
						sadgemore_concierge_acf_text_field( 'process_step_title', 'Title', 'title' ),
						sadgemore_concierge_acf_text_field( 'process_step_text', 'Text', 'text', 'textarea' ),
					),
					'Add step'
				),

				array( 'key' => 'field_concierge_page_membership_tab', 'label' => 'Membership', 'name' => '', 'type' => 'tab' ),
				sadgemore_concierge_acf_text_field( 'membership_label', 'Label', 'concierge_page_membership_label' ),
				sadgemore_concierge_acf_text_field( 'membership_title', 'Title', 'concierge_page_membership_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_concierge_acf_text_field( 'membership_body', 'Body copy', 'concierge_page_membership_body', 'textarea' ),
				sadgemore_concierge_acf_text_field( 'membership_button_label', 'Button label', 'concierge_page_membership_button_label' ),
				sadgemore_concierge_acf_text_field( 'membership_button_url', 'Button URL', 'concierge_page_membership_button_url', 'url' ),
				sadgemore_concierge_acf_text_field( 'membership_note', 'Note', 'concierge_page_membership_note', 'textarea' ),

				array( 'key' => 'field_concierge_page_enquire_tab', 'label' => 'Enquiry Form', 'name' => '', 'type' => 'tab' ),
				sadgemore_concierge_acf_text_field( 'enquire_label', 'Label', 'concierge_page_enquire_label' ),
				sadgemore_concierge_acf_text_field( 'enquire_title', 'Title', 'concierge_page_enquire_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_concierge_acf_text_field( 'enquire_body', 'Body copy', 'concierge_page_enquire_body', 'textarea' ),
				sadgemore_concierge_acf_text_field( 'enquire_service_label', 'Service field label', 'concierge_page_enquire_service_label' ),
				sadgemore_concierge_acf_text_field( 'enquire_service_placeholder', 'Service placeholder', 'concierge_page_enquire_service_placeholder' ),
				sadgemore_concierge_acf_repeater_field(
					'enquire_service_options',
					'Service options',
					'concierge_page_enquire_service_options',
					array(
						sadgemore_concierge_acf_text_field( 'service_option_label', 'Label', 'label' ),
						sadgemore_concierge_acf_text_field( 'service_option_value', 'Value', 'value' ),
					),
					'Add option'
				),
				sadgemore_concierge_acf_text_field( 'enquire_message_placeholder', 'Message placeholder', 'concierge_page_enquire_message_placeholder', 'textarea' ),
				sadgemore_concierge_acf_text_field( 'enquire_submit_label', 'Submit label', 'concierge_page_enquire_submit_label' ),
				sadgemore_concierge_acf_text_field( 'enquire_privacy', 'Privacy note', 'concierge_page_enquire_privacy', 'textarea' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/concierge.php',
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
