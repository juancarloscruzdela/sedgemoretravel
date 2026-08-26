<?php
/**
 * Events page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_events_page_fields' );

function sadgemore_events_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_events_page_' . $key,
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

function sadgemore_events_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_events_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_events_acf_repeater_field( $key, $label, $name, $sub_fields, $button_label = 'Add item' ) {
	return array(
		'key'          => 'field_events_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'row',
		'button_label' => $button_label,
		'sub_fields'   => $sub_fields,
	);
}

function sadgemore_register_events_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_events_page',
			'title'                 => 'Events Page',
			'fields'                => array(
				array(
					'key'   => 'field_events_page_hero_tab',
					'label' => 'Hero',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_events_acf_text_field( 'hero_video_url', 'Hero video URL', 'events_page_hero_video_url', 'url' ),
				sadgemore_events_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'events_page_hero_eyebrow' ),
				sadgemore_events_acf_text_field( 'hero_title', 'Title', 'events_page_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_events_acf_text_field( 'hero_text', 'Intro text', 'events_page_hero_text', 'textarea' ),
				sadgemore_events_acf_text_field( 'hero_button_label', 'Button label', 'events_page_hero_button_label' ),
				sadgemore_events_acf_text_field( 'hero_button_url', 'Button URL', 'events_page_hero_button_url', 'url' ),

				array(
					'key'   => 'field_events_page_intro_tab',
					'label' => 'Intro',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_events_acf_text_field( 'intro_label', 'Label', 'events_page_intro_label' ),
				sadgemore_events_acf_text_field( 'intro_title', 'Title', 'events_page_intro_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_events_acf_text_field( 'intro_body', 'Body copy', 'events_page_intro_body', 'textarea' ),
				sadgemore_events_acf_image_field( 'intro_image', 'Image', 'events_page_intro_image', 'Optional. Falls back to the theme SVG asset.' ),

				array(
					'key'   => 'field_events_page_services_tab',
					'label' => 'Services',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_events_acf_text_field( 'services_label', 'Label', 'events_page_services_label' ),
				sadgemore_events_acf_text_field( 'services_title', 'Title', 'events_page_services_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_events_acf_text_field( 'services_text', 'Intro text', 'events_page_services_text', 'textarea' ),
				sadgemore_events_acf_repeater_field(
					'service_cards',
					'Service cards',
					'events_page_service_cards',
					array(
						sadgemore_events_acf_text_field( 'service_title', 'Title', 'title' ),
						sadgemore_events_acf_text_field( 'service_text', 'Text', 'text', 'textarea' ),
					),
					'Add service'
				),

				array(
					'key'   => 'field_events_page_difference_tab',
					'label' => 'Difference',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_events_acf_image_field( 'difference_image', 'Image', 'events_page_difference_image', 'Optional. Falls back to the theme SVG asset.' ),
				sadgemore_events_acf_text_field( 'difference_label', 'Label', 'events_page_difference_label' ),
				sadgemore_events_acf_text_field( 'difference_title', 'Title', 'events_page_difference_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_events_acf_text_field( 'difference_body', 'Body copy', 'events_page_difference_body', 'textarea' ),
				sadgemore_events_acf_repeater_field(
					'difference_points',
					'Points',
					'events_page_difference_points',
					array(
						sadgemore_events_acf_text_field( 'difference_point_text', 'Text', 'text' ),
					),
					'Add point'
				),

				array(
					'key'   => 'field_events_page_process_tab',
					'label' => 'Process',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_events_acf_text_field( 'process_label', 'Label', 'events_page_process_label' ),
				sadgemore_events_acf_text_field( 'process_title', 'Title', 'events_page_process_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_events_acf_text_field( 'process_text', 'Intro text', 'events_page_process_text', 'textarea' ),
				sadgemore_events_acf_repeater_field(
					'process_steps',
					'Process steps',
					'events_page_process_steps',
					array(
						sadgemore_events_acf_text_field( 'process_step_number', 'Number', 'number' ),
						sadgemore_events_acf_text_field( 'process_step_title', 'Title', 'title' ),
						sadgemore_events_acf_text_field( 'process_step_text', 'Text', 'text', 'textarea' ),
					),
					'Add step'
				),

				array(
					'key'   => 'field_events_page_concierge_tab',
					'label' => 'Connected Services',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_events_acf_text_field( 'concierge_label', 'Label', 'events_page_concierge_label' ),
				sadgemore_events_acf_text_field( 'concierge_title', 'Title', 'events_page_concierge_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_events_acf_text_field( 'concierge_body', 'Body copy', 'events_page_concierge_body', 'textarea' ),
				sadgemore_events_acf_text_field( 'concierge_button_label', 'Button label', 'events_page_concierge_button_label' ),
				sadgemore_events_acf_text_field( 'concierge_button_url', 'Button URL', 'events_page_concierge_button_url', 'url' ),
				sadgemore_events_acf_repeater_field(
					'concierge_pillars',
					'Pillars',
					'events_page_concierge_pillars',
					array(
						sadgemore_events_acf_text_field( 'concierge_pillar_title', 'Title', 'title' ),
						sadgemore_events_acf_text_field( 'concierge_pillar_text', 'Text', 'text', 'textarea' ),
					),
					'Add pillar'
				),

				array(
					'key'   => 'field_events_page_cta_tab',
					'label' => 'CTA Form',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_events_acf_text_field( 'cta_label', 'Label', 'events_page_cta_label' ),
				sadgemore_events_acf_text_field( 'cta_title', 'Title', 'events_page_cta_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_events_acf_text_field( 'cta_text', 'Text', 'events_page_cta_text', 'textarea' ),
				sadgemore_events_acf_text_field( 'cta_occasion_label', 'Occasion field label', 'events_page_cta_occasion_label' ),
				sadgemore_events_acf_text_field( 'cta_occasion_placeholder', 'Occasion placeholder', 'events_page_cta_occasion_placeholder' ),
				sadgemore_events_acf_text_field( 'cta_message_label', 'Message field label', 'events_page_cta_message_label' ),
				sadgemore_events_acf_text_field( 'cta_message_placeholder', 'Message placeholder', 'events_page_cta_message_placeholder', 'textarea' ),
				sadgemore_events_acf_text_field( 'cta_submit_label', 'Submit label', 'events_page_cta_submit_label' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/events.php',
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
