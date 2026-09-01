<?php
/**
 * Blog story ACF field group.
 *
 * @package sadgemore
 */

add_action( 'acf/init', 'sadgemore_register_blog_story_fields' );
add_action( 'acf/init', 'sadgemore_register_blog_editorial_fields' );

function sadgemore_register_blog_story_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_blog_story',
			'title'                 => 'Blog Story',
			'fields'                => array(
				array(
					'key'   => 'field_blog_hero_tab',
					'label' => 'Hero',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_blog_hero_location',
					'label' => 'Location',
					'name'  => 'hero_location',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_hero_kicker',
					'label' => 'Kicker',
					'name'  => 'hero_kicker',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_hero_title',
					'label' => 'Hero title override',
					'name'  => 'hero_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_hero_descriptor',
					'label' => 'Hero descriptor',
					'name'  => 'hero_descriptor',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'           => 'field_blog_hero_image',
					'label'         => 'Hero image',
					'name'          => 'hero_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'large',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_blog_statement_tab',
					'label' => 'Statement',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_blog_statement_label',
					'label' => 'Aside label',
					'name'  => 'statement_aside_label',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_blog_statement_image',
					'label'         => 'Aside image',
					'name'          => 'statement_aside_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_blog_statement_headline',
					'label' => 'Headline',
					'name'  => 'statement_headline',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_blog_statement_left_text',
					'label'         => 'Left text',
					'name'          => 'statement_left_text',
					'type'          => 'wysiwyg',
					'tabs'          => 'all',
					'toolbar'       => 'basic',
					'media_upload'  => 0,
				),
				array(
					'key'           => 'field_blog_statement_right_text',
					'label'         => 'Right text',
					'name'          => 'statement_right_text',
					'type'          => 'wysiwyg',
					'tabs'          => 'all',
					'toolbar'       => 'basic',
					'media_upload'  => 0,
				),
				array(
					'key'   => 'field_blog_statement_quote',
					'label' => 'Pull quote',
					'name'  => 'statement_pull_quote',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_blog_stats_tab',
					'label' => 'Stats',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_blog_stats',
					'label'        => 'Stats',
					'name'         => 'stats',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add stat',
					'sub_fields'   => array(
						array(
							'key'   => 'field_blog_stat_value',
							'label' => 'Value',
							'name'  => 'value',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_blog_stat_label',
							'label' => 'Label',
							'name'  => 'label',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_blog_itinerary_tab',
					'label' => 'Itinerary',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_blog_itinerary_title',
					'label' => 'Intro title',
					'name'  => 'itinerary_intro_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_itinerary_note',
					'label' => 'Intro note',
					'name'  => 'itinerary_intro_note',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'          => 'field_blog_itinerary_days',
					'label'        => 'Days',
					'name'         => 'itinerary_days',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add day',
					'sub_fields'   => array(
						array(
							'key'   => 'field_blog_day_number',
							'label' => 'Day number',
							'name'  => 'day_number',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_blog_day_kicker',
							'label' => 'Kicker',
							'name'  => 'day_kicker',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_blog_day_title',
							'label' => 'Title',
							'name'  => 'day_title',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_blog_day_body',
							'label'        => 'Body',
							'name'         => 'day_body',
							'type'         => 'wysiwyg',
							'tabs'         => 'all',
							'toolbar'      => 'basic',
							'media_upload' => 0,
						),
						array(
							'key'   => 'field_blog_day_tags',
							'label' => 'Tags',
							'name'  => 'day_tags',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_blog_experiences_tab',
					'label' => 'Experiences',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_blog_experiences_title',
					'label' => 'Section title',
					'name'  => 'experiences_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_experiences_note',
					'label' => 'Section note',
					'name'  => 'experiences_note',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'          => 'field_blog_experiences',
					'label'        => 'Experiences',
					'name'         => 'experiences',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add experience',
					'sub_fields'   => array(
						array(
							'key'           => 'field_blog_experience_image',
							'label'         => 'Image',
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
						),
						array(
							'key'   => 'field_blog_experience_region',
							'label' => 'Region',
							'name'  => 'region',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_blog_experience_title',
							'label' => 'Title',
							'name'  => 'title',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_blog_stay_tab',
					'label' => 'Stay',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_blog_stay_image',
					'label'         => 'Image',
					'name'          => 'stay_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'large',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_blog_stay_eyebrow',
					'label' => 'Eyebrow',
					'name'  => 'stay_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_stay_name',
					'label' => 'Name',
					'name'  => 'stay_name',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_stay_loc',
					'label' => 'Location',
					'name'  => 'stay_loc',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_blog_stay_text',
					'label'        => 'Text',
					'name'         => 'stay_text',
					'type'         => 'wysiwyg',
					'tabs'         => 'all',
					'toolbar'      => 'basic',
					'media_upload' => 0,
				),
				array(
					'key'          => 'field_blog_stay_facts',
					'label'        => 'Facts',
					'name'         => 'stay_facts',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add fact',
					'sub_fields'   => array(
						array(
							'key'   => 'field_blog_fact_label',
							'label' => 'Label',
							'name'  => 'label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_blog_fact_value',
							'label' => 'Value',
							'name'  => 'value',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_blog_stay_cta_label',
					'label' => 'CTA label',
					'name'  => 'stay_cta_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_stay_cta_url',
					'label' => 'CTA URL',
					'name'  => 'stay_cta_url',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blog_contact_tab',
					'label' => 'Contact',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_blog_contact_kicker',
					'label' => 'Kicker',
					'name'  => 'contact_kicker',
					'type'  => 'text',
					'default_value' => 'Begin your journey',
				),
				array(
					'key'   => 'field_blog_contact_title',
					'label' => 'Title',
					'name'  => 'contact_title',
					'type'  => 'text',
					'default_value' => 'Tell us about your journey.',
				),
				array(
					'key'   => 'field_blog_contact_desc',
					'label' => 'Description',
					'name'  => 'contact_desc',
					'type'  => 'textarea',
					'rows'  => 4,
					'default_value' => 'Share a few details and we will reach out to arrange a brief conversation. There is no obligation, and no questionnaire. Just a quiet exchange about what you have in mind.',
				),
				array(
					'key'   => 'field_blog_contact_note',
					'label' => 'Note',
					'name'  => 'contact_note',
					'type'  => 'textarea',
					'rows'  => 3,
					'default_value' => 'We aim to respond within one business day.',
				),
				array(
					'key'   => 'field_blog_contact_interest_label',
					'label' => 'Interest label',
					'name'  => 'contact_interest_label',
					'type'  => 'text',
					'default_value' => 'Interest',
				),
				array(
					'key'          => 'field_blog_contact_interest_options',
					'label'        => 'Interest options',
					'name'         => 'contact_interest_options',
					'type'         => 'repeater',
					'layout'       => 'row',
					'button_label' => 'Add interest option',
					'sub_fields'   => array(
						array(
							'key'   => 'field_blog_contact_interest_option_label',
							'label' => 'Label',
							'name'  => 'label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_blog_contact_interest_option_value',
							'label' => 'Value',
							'name'  => 'value',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_blog_contact_message_label',
					'label' => 'Message label',
					'name'  => 'contact_message_label',
					'type'  => 'text',
					'default_value' => 'Anything else we should know?',
				),
				array(
					'key'   => 'field_blog_contact_message_placeholder',
					'label' => 'Message placeholder',
					'name'  => 'contact_message_placeholder',
					'type'  => 'text',
					'default_value' => 'Dietary requirements, special occasions, specific requests',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/blog.php',
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
			'description'           => 'Editable editorial travel blog layout.',
		)
	);
}

function sadgemore_register_blog_editorial_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sedgemore_blog_editorial',
			'title'                 => 'Blog Editorial Article',
			'fields'                => array(
				array(
					'key'   => 'field_editorial_hero_tab',
					'label' => 'Hero',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_editorial_label',
					'label'        => 'Label',
					'name'         => 'editorial_label',
					'type'         => 'text',
					'instructions' => 'Example: Winter Sun &middot; 2026/27',
				),
				array(
					'key'          => 'field_editorial_title',
					'label'        => 'Title',
					'name'         => 'editorial_title',
					'type'         => 'textarea',
					'instructions' => 'HTML is allowed for line breaks and emphasis, for example &lt;br&gt; and &lt;em&gt;.',
					'rows'         => 3,
				),
				array(
					'key'   => 'field_editorial_standfirst',
					'label' => 'Standfirst',
					'name'  => 'editorial_standfirst',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'           => 'field_editorial_byline',
					'label'         => 'Byline',
					'name'          => 'editorial_byline',
					'type'          => 'text',
					'default_value' => 'Sedgemore Editorial',
				),
				array(
					'key'           => 'field_editorial_hero_image',
					'label'         => 'Hero image',
					'name'          => 'editorial_hero_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'large',
					'library'       => 'all',
				),
				array(
					'key'          => 'field_editorial_hero_credit',
					'label'        => 'Hero image credit',
					'name'         => 'editorial_hero_credit',
					'type'         => 'text',
					'instructions' => 'HTML is allowed for emphasis, for example &lt;em&gt;Property name&lt;/em&gt; &amp;middot; Courtesy of the property.',
				),
				array(
					'key'   => 'field_editorial_intro_tab',
					'label' => 'Intro',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_editorial_intro',
					'label'        => 'Intro paragraphs',
					'name'         => 'editorial_intro',
					'type'         => 'wysiwyg',
					'tabs'         => 'all',
					'toolbar'      => 'basic',
					'media_upload' => 0,
				),
				array(
					'key'   => 'field_editorial_blocks_tab',
					'label' => 'Article Blocks',
					'name'  => '',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_editorial_blocks',
					'label'        => 'Article blocks',
					'name'         => 'editorial_blocks',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => 'Add article block',
					'instructions' => 'Add blocks in page order. Editorial sections can include optional dividers and pull quotes.',
					'sub_fields'   => array(
						array(
							'key'     => 'field_editorial_block_type',
							'label'   => 'Block type',
							'name'    => 'block_type',
							'type'    => 'select',
							'choices' => array(
								'movement' => 'Editorial section',
								'image'    => 'Image',
								'closing'  => 'Closing CTA',
								'credits'  => 'Image credits',
							),
							'default_value' => 'movement',
							'ui'            => 1,
						),
						array(
							'key'   => 'field_editorial_block_label',
							'label' => 'Label',
							'name'  => 'label',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_editorial_block_title',
							'label'        => 'Title',
							'name'         => 'title',
							'type'         => 'text',
							'instructions' => 'HTML is allowed for emphasis, for example &lt;em&gt;word&lt;/em&gt;.',
						),
						array(
							'key'          => 'field_editorial_block_body',
							'label'        => 'Body',
							'name'         => 'body',
							'type'         => 'wysiwyg',
							'tabs'         => 'all',
							'toolbar'      => 'basic',
							'media_upload' => 0,
						),
						array(
							'key'   => 'field_editorial_block_divider_before',
							'label' => 'Divider before section',
							'name'  => 'divider_before',
							'type'  => 'true_false',
							'ui'    => 1,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_editorial_block_type',
										'operator' => '==',
										'value'    => 'movement',
									),
								),
							),
						),
						array(
							'key'   => 'field_editorial_block_divider_after',
							'label' => 'Divider after section',
							'name'  => 'divider_after',
							'type'  => 'true_false',
							'ui'    => 1,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_editorial_block_type',
										'operator' => '==',
										'value'    => 'movement',
									),
								),
							),
						),
						array(
							'key'   => 'field_editorial_block_pull_quote',
							'label' => 'Pull quote',
							'name'  => 'pull_quote',
							'type'  => 'textarea',
							'rows'  => 4,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_editorial_block_type',
										'operator' => '==',
										'value'    => 'movement',
									),
								),
							),
						),
						array(
							'key'           => 'field_editorial_block_image',
							'label'         => 'Image',
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
						),
						array(
							'key'          => 'field_editorial_block_caption',
							'label'        => 'Image caption / credit',
							'name'         => 'caption',
							'type'         => 'text',
							'instructions' => 'HTML is allowed for emphasis.',
						),
						array(
							'key'   => 'field_editorial_block_portrait',
							'label' => 'Portrait image width',
							'name'  => 'portrait_image',
							'type'  => 'true_false',
							'ui'    => 1,
						),
						array(
							'key'   => 'field_editorial_block_short_rule',
							'label' => 'Short divider',
							'name'  => 'short_rule',
							'type'  => 'true_false',
							'ui'    => 1,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_editorial_block_type',
										'operator' => '==',
										'value'    => 'movement',
									),
								),
							),
						),
						array(
							'key'   => 'field_editorial_block_cta_label',
							'label' => 'CTA label',
							'name'  => 'cta_label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_editorial_block_cta_url',
							'label' => 'CTA URL',
							'name'  => 'cta_url',
							'type'  => 'text',
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/blog-editorial.php',
					),
				),
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
			),
			'menu_order'            => 1,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => array(),
			'active'                => true,
			'description'           => 'Editable long-form editorial article layout matching the Winter Sun reference.',
		)
	);
}
