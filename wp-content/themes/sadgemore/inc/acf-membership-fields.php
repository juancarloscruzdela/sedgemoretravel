<?php
/**
 * Membership page ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_membership_page_fields' );

function sadgemore_membership_acf_text_field( $key, $label, $name, $type = 'text', $instructions = '' ) {
	$field = array(
		'key'   => 'field_membership_page_' . $key,
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

function sadgemore_membership_acf_wysiwyg_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'          => 'field_membership_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'wysiwyg',
		'instructions' => $instructions,
		'tabs'         => 'all',
		'toolbar'      => 'basic',
		'media_upload' => 0,
	);
}

function sadgemore_membership_acf_image_field( $key, $label, $name, $instructions = '' ) {
	return array(
		'key'           => 'field_membership_page_' . $key,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'instructions'  => $instructions,
		'return_format' => 'id',
		'preview_size'  => 'large',
		'library'       => 'all',
	);
}

function sadgemore_membership_acf_repeater_field( $key, $label, $name, $sub_fields, $button_label ) {
	return array(
		'key'          => 'field_membership_page_' . $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'row',
		'button_label' => $button_label,
		'sub_fields'   => $sub_fields,
	);
}

function sadgemore_register_membership_page_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_membership_page',
			'title'                 => 'Membership Page',
			'fields'                => array(
				array( 'key' => 'field_membership_page_hero_tab', 'label' => 'Hero', 'name' => '', 'type' => 'tab' ),
				sadgemore_membership_acf_repeater_field(
					'hero_slides',
					'Hero slides',
					'membership_hero_slides',
					array(
						sadgemore_membership_acf_image_field( 'hero_slide_image', 'Image', 'image' ),
					),
					'Add slide'
				),
				sadgemore_membership_acf_text_field( 'hero_eyebrow', 'Eyebrow', 'membership_hero_eyebrow', 'text', 'HTML entities are allowed, for example &amp;nbsp; and &amp;middot;.' ),
				sadgemore_membership_acf_text_field( 'hero_title', 'Title', 'membership_hero_title', 'textarea', 'HTML is allowed for line breaks and emphasis, for example <br> and <em>.' ),
				sadgemore_membership_acf_text_field( 'hero_intro', 'Intro text', 'membership_hero_intro', 'textarea' ),
				sadgemore_membership_acf_text_field( 'hero_button', 'Button label', 'membership_hero_button' ),

				array( 'key' => 'field_membership_page_intro_tab', 'label' => 'Intro', 'name' => '', 'type' => 'tab' ),
				sadgemore_membership_acf_text_field( 'intro_title', 'Title', 'membership_intro_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_membership_acf_text_field( 'intro_text', 'Text', 'membership_intro_text', 'textarea' ),

				array( 'key' => 'field_membership_page_philosophy_tab', 'label' => 'Philosophy', 'name' => '', 'type' => 'tab' ),
				sadgemore_membership_acf_text_field( 'philosophy_label', 'Label', 'membership_philosophy_label' ),
				sadgemore_membership_acf_text_field( 'philosophy_title', 'Title', 'membership_philosophy_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_membership_acf_wysiwyg_field( 'philosophy_text', 'Text', 'membership_philosophy_text' ),
				sadgemore_membership_acf_repeater_field(
					'pillars',
					'Pillars',
					'membership_pillars',
					array(
						sadgemore_membership_acf_text_field( 'pillar_title', 'Title', 'title' ),
						sadgemore_membership_acf_text_field( 'pillar_text', 'Text', 'text', 'textarea' ),
					),
					'Add pillar'
				),

				array( 'key' => 'field_membership_page_tiers_tab', 'label' => 'Membership Tiers', 'name' => '', 'type' => 'tab' ),
				sadgemore_membership_acf_text_field( 'tiers_label', 'Label', 'membership_tiers_label' ),
				sadgemore_membership_acf_text_field( 'tiers_title', 'Title', 'membership_tiers_title', 'textarea', 'HTML is allowed for line breaks and emphasis.' ),
				sadgemore_membership_acf_text_field( 'tiers_text', 'Text', 'membership_tiers_text', 'textarea' ),
				sadgemore_membership_acf_repeater_field(
					'tiers',
					'Tiers',
					'membership_tiers',
					array(
						sadgemore_membership_acf_text_field( 'tier_name', 'Name', 'name' ),
						sadgemore_membership_acf_text_field( 'tier_tagline', 'Tagline', 'tagline' ),
						sadgemore_membership_acf_wysiwyg_field( 'tier_body', 'Body', 'body' ),
						array(
							'key'           => 'field_membership_page_tier_featured',
							'label'         => 'Featured dark card',
							'name'          => 'featured',
							'type'          => 'true_false',
							'ui'            => 1,
							'default_value' => 0,
						),
					),
					'Add tier'
				),

				array( 'key' => 'field_membership_page_interest_tab', 'label' => 'Interest Form', 'name' => '', 'type' => 'tab' ),
				sadgemore_membership_acf_text_field( 'interest_label', 'Label', 'membership_interest_label' ),
				sadgemore_membership_acf_text_field( 'interest_title', 'Title', 'membership_interest_title', 'textarea', 'HTML is allowed for emphasis.' ),
				sadgemore_membership_acf_text_field( 'interest_text', 'Text', 'membership_interest_text', 'textarea' ),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/membership.php',
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
