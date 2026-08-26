<?php
/**
 * Travel page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_travel_page_fields' );

function sadgemore_travel_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_travel_page_' . $key,
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

function sadgemore_travel_acf_wysiwyg_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'          => 'field_travel_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'wysiwyg',
		'instructions' => $instructions,
		'tabs'         => 'all',
		'toolbar'      => 'basic',
		'media_upload' => 0,
	);
}

function sadgemore_travel_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_travel_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_register_travel_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_travel_page',
			'title'                 => 'Travel Page',
			'fields'                => array(
				array(
					'key'   => 'field_travel_page_hero_tab',
					'label' => 'Hero',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'travel_page_hero_eyebrow' ),
				sadgemore_travel_acf_text_field( 'hero_title', 'Title', 'travel_page_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis, for example <br> and <em>.' ),
				sadgemore_travel_acf_text_field( 'hero_text', 'Intro text', 'travel_page_hero_text', 'textarea' ),
				sadgemore_travel_acf_image_field( 'hero_image', 'Hero image', 'travel_page_hero_image', 'Falls back to the first image in the existing Banners field.' ),
				sadgemore_travel_acf_image_field( 'hero_mobile_image', 'Hero mobile image', 'travel_page_hero_mobile_image', 'Optional. Falls back to the desktop hero image.' ),
				sadgemore_travel_acf_text_field( 'hero_button_label', 'Button label', 'travel_page_hero_button_label' ),
				sadgemore_travel_acf_text_field( 'hero_button_url', 'Button URL', 'travel_page_hero_button_url', 'url' ),

				array(
					'key'   => 'field_travel_page_intro_tab',
					'label' => 'Approach',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'intro_label', 'Label', 'travel_page_intro_label' ),
				sadgemore_travel_acf_text_field( 'intro_title', 'Title', 'travel_page_intro_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_travel_acf_wysiwyg_field( 'intro_body', 'Body copy', 'travel_page_intro_body' ),
				sadgemore_travel_acf_text_field( 'intro_quote', 'Quote', 'travel_page_intro_quote', 'textarea' ),

				array(
					'key'   => 'field_travel_page_services_tab',
					'label' => 'Services',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'services_label', 'Label', 'travel_page_services_label' ),
				sadgemore_travel_acf_text_field( 'services_title', 'Title', 'travel_page_services_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				array(
					'key'          => 'field_travel_page_service_cards',
					'label'        => 'Service cards',
					'name'         => 'travel_page_service_cards',
					'type'         => 'repeater',
					'instructions' => 'Leave empty to use the static layout copy. Images also fall back to the Travel Type term images.',
					'layout'       => 'row',
					'button_label' => 'Add service card',
					'sub_fields'   => array(
						sadgemore_travel_acf_text_field( 'service_card_title', 'Title', 'title', 'textarea', 'HTML is allowed for line breaks.' ),
						sadgemore_travel_acf_text_field( 'service_card_text', 'Text', 'text', 'textarea' ),
						sadgemore_travel_acf_image_field( 'service_card_image', 'Image', 'image' ),
						sadgemore_travel_acf_text_field( 'service_card_link_label', 'Link label', 'link_label' ),
						sadgemore_travel_acf_text_field( 'service_card_link_url', 'Link URL', 'link_url', 'url' ),
					),
				),

				array(
					'key'   => 'field_travel_page_story_tab',
					'label' => 'Story Sections',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'narrative_title', 'Narrative title', 'travel_page_narrative_title', 'textarea', 'HTML is allowed for line breaks.' ),
				sadgemore_travel_acf_wysiwyg_field( 'narrative_body', 'Narrative body', 'travel_page_narrative_body' ),
				sadgemore_travel_acf_text_field( 'narrative_attr', 'Narrative attribution', 'travel_page_narrative_attr' ),
				sadgemore_travel_acf_text_field( 'properties_title', 'Properties title', 'travel_page_properties_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_travel_acf_text_field( 'properties_text', 'Properties text', 'travel_page_properties_text', 'textarea' ),
				array(
					'key'          => 'field_travel_page_property_logos',
					'label'        => 'Partner logos',
					'name'         => 'travel_page_property_logos',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Add logo',
					'sub_fields'   => array(
						sadgemore_travel_acf_image_field( 'property_logo_image', 'Logo', 'image' ),
						sadgemore_travel_acf_text_field( 'property_logo_label', 'Name / alt text', 'label' ),
					),
				),

				array(
					'key'   => 'field_travel_page_reasons_tab',
					'label' => 'Reasons',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'reasons_label', 'Label', 'travel_page_reasons_label' ),
				sadgemore_travel_acf_text_field( 'reasons_title', 'Title', 'travel_page_reasons_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_travel_acf_text_field( 'reasons_text', 'Intro text', 'travel_page_reasons_text', 'textarea' ),
				array(
					'key'          => 'field_travel_page_reasons',
					'label'        => 'Reason cards',
					'name'         => 'travel_page_reasons',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add reason',
					'sub_fields'   => array(
						sadgemore_travel_acf_text_field( 'reason_number', 'Number', 'number' ),
						sadgemore_travel_acf_text_field( 'reason_title', 'Title', 'title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
						sadgemore_travel_acf_text_field( 'reason_text', 'Text', 'text', 'textarea' ),
					),
				),

				array(
					'key'   => 'field_travel_page_testimonial_tab',
					'label' => 'Testimonial',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'testimonial_quote', 'Quote', 'travel_page_testimonial_quote', 'textarea' ),
				sadgemore_travel_acf_text_field( 'testimonial_attr', 'Attribution', 'travel_page_testimonial_attr' ),

				array(
					'key'   => 'field_travel_page_prive_tab',
					'label' => 'Prive',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'prive_label', 'Label', 'travel_page_prive_label' ),
				sadgemore_travel_acf_text_field( 'prive_title', 'Title', 'travel_page_prive_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_travel_acf_text_field( 'prive_text', 'Text', 'travel_page_prive_text', 'textarea' ),
				sadgemore_travel_acf_text_field( 'prive_button_label', 'Button label', 'travel_page_prive_button_label' ),
				sadgemore_travel_acf_text_field( 'prive_button_url', 'Button URL', 'travel_page_prive_button_url', 'url' ),
				array(
					'key'          => 'field_travel_page_prive_features',
					'label'        => 'Prive features',
					'name'         => 'travel_page_prive_features',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add feature',
					'sub_fields'   => array(
						sadgemore_travel_acf_text_field( 'prive_feature_title', 'Title', 'title' ),
						sadgemore_travel_acf_text_field( 'prive_feature_text', 'Text', 'text', 'textarea' ),
					),
				),

				array(
					'key'   => 'field_travel_page_closing_tab',
					'label' => 'Closing Form',
					'name'  => '',
					'type'  => 'tab',
				),
				sadgemore_travel_acf_text_field( 'closing_label', 'Label', 'travel_page_closing_label' ),
				sadgemore_travel_acf_text_field( 'closing_title', 'Title', 'travel_page_closing_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_travel_acf_text_field( 'closing_text', 'Intro text', 'travel_page_closing_text', 'textarea' ),
				sadgemore_travel_acf_text_field( 'closing_note', 'Second line', 'travel_page_closing_note', 'textarea' ),
				array(
					'key'          => 'field_travel_page_interest_options',
					'label'        => 'Interest options',
					'name'         => 'travel_page_interest_options',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Add option',
					'sub_fields'   => array(
						sadgemore_travel_acf_text_field( 'interest_label', 'Label', 'label' ),
						sadgemore_travel_acf_text_field( 'interest_value', 'Value', 'value' ),
					),
				),
				sadgemore_travel_acf_text_field( 'closing_submit_label', 'Submit label', 'travel_page_closing_submit_label' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/travel.php',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(),
			'active'                => true,
			'description'           => 'Editable content for the redesigned Travel page.',
		)
	);
}
