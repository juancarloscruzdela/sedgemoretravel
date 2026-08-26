<?php

/**
 * Template Name: Blog Story
 * Template Post Type: post, page
 *
 * Editorial blog template inspired by the static Scotland and Venice layouts.
 * Content is driven by the editor/ACF fields so staff can create future stories in wp-admin.
 *
 * @package sadgemore
 */

if (! function_exists('sedgemore_blog_asset_url')) {
    function sedgemore_blog_asset_url($value, $size = 'full')
    {
        if (empty($value)) {
            return '';
        }

        if (is_string($value)) {
            return esc_url_raw($value);
        }

        if (is_numeric($value)) {
            $url = wp_get_attachment_image_url((int) $value, $size);
            return $url ? esc_url_raw($url) : '';
        }

        if (is_array($value)) {
            if (! empty($value['url'])) {
                return esc_url_raw($value['url']);
            }

            if (! empty($value['ID'])) {
                $url = wp_get_attachment_image_url((int) $value['ID'], $size);
                return $url ? esc_url_raw($url) : '';
            }
        }

        if ($value instanceof WP_Post) {
            $url = wp_get_attachment_image_url((int) $value->ID, $size);
            return $url ? esc_url_raw($url) : '';
        }

        return '';
    }
}

get_header();

while (have_posts()) :
    the_post();

    $hero_location        = function_exists('get_field') ? (string) get_field('hero_location') : '';
    $hero_kicker          = function_exists('get_field') ? (string) get_field('hero_kicker') : '';
    $hero_title           = function_exists('get_field') ? (string) get_field('hero_title') : '';
    $hero_descriptor      = function_exists('get_field') ? (string) get_field('hero_descriptor') : '';
    $hero_image           = function_exists('get_field') ? get_field('hero_image') : '';
    $statement_label      = function_exists('get_field') ? (string) get_field('statement_aside_label') : '';
    $statement_image      = function_exists('get_field') ? get_field('statement_aside_image') : '';
    $statement_headline   = function_exists('get_field') ? (string) get_field('statement_headline') : '';
    $statement_left_text  = function_exists('get_field') ? (string) get_field('statement_left_text') : '';
    $statement_right_text = function_exists('get_field') ? (string) get_field('statement_right_text') : '';
    $pull_quote           = function_exists('get_field') ? (string) get_field('statement_pull_quote') : '';
    $stats                = function_exists('get_field') ? get_field('stats') : array();
    $itin_title           = function_exists('get_field') ? (string) get_field('itinerary_intro_title') : '';
    $itin_note            = function_exists('get_field') ? (string) get_field('itinerary_intro_note') : '';
    $itin_days            = function_exists('get_field') ? get_field('itinerary_days') : array();
    $exp_title            = function_exists('get_field') ? (string) get_field('experiences_title') : '';
    $exp_note             = function_exists('get_field') ? (string) get_field('experiences_note') : '';
    $experiences          = function_exists('get_field') ? get_field('experiences') : array();
    $stay_image           = function_exists('get_field') ? get_field('stay_image') : '';
    $stay_eyebrow         = function_exists('get_field') ? (string) get_field('stay_eyebrow') : '';
    $stay_name            = function_exists('get_field') ? (string) get_field('stay_name') : '';
    $stay_loc             = function_exists('get_field') ? (string) get_field('stay_loc') : '';
    $stay_text            = function_exists('get_field') ? (string) get_field('stay_text') : '';
    $stay_facts           = function_exists('get_field') ? get_field('stay_facts') : array();
    $stay_cta_label       = function_exists('get_field') ? (string) get_field('stay_cta_label') : '';
    $stay_cta_url         = function_exists('get_field') ? (string) get_field('stay_cta_url') : '';
    $contact_kicker       = function_exists('get_field') ? (string) get_field('contact_kicker') : '';
    $contact_title        = function_exists('get_field') ? (string) get_field('contact_title') : '';
    $contact_desc         = function_exists('get_field') ? (string) get_field('contact_desc') : '';
    $contact_note         = function_exists('get_field') ? (string) get_field('contact_note') : '';
    $contact_interest_label = function_exists('get_field') ? (string) get_field('contact_interest_label') : '';
    $contact_interest_options = function_exists('get_field') ? get_field('contact_interest_options') : array();
    $contact_message_label = function_exists('get_field') ? (string) get_field('contact_message_label') : '';
    $contact_message_placeholder = function_exists('get_field') ? (string) get_field('contact_message_placeholder') : '';

    if (! $hero_title) {
        $hero_title = get_the_title();
    }

    if (! $hero_kicker) {
        $hero_kicker = $hero_location ? $hero_location : get_bloginfo('name');
    }

    if (! $hero_location) {
        $terms = get_the_terms(get_the_ID(), 'category');
        if ($terms && ! is_wp_error($terms)) {
            $hero_location = implode(
                ' &middot; ',
                wp_list_pluck($terms, 'name')
            );
        }
    }

    if (! $hero_descriptor) {
        $hero_descriptor = has_excerpt() ? get_the_excerpt() : '';
    }

    if (! $statement_headline) {
        $statement_headline = has_excerpt() ? get_the_excerpt() : get_the_title();
    }

    if (! $statement_left_text) {
        $statement_left_text = get_the_content(null, false);
    }

    if (! $statement_right_text) {
        $statement_right_text = has_excerpt() ? get_the_excerpt() : '';
    }

    if (! $pull_quote) {
        $pull_quote = get_the_title();
    }

    if (empty($stats) || ! is_array($stats)) {
        $stats = array(
            array(
                'value' => get_the_date('Y'),
                'label' => 'Published',
            ),
            array(
                'value' => get_the_author_meta('display_name', get_post_field('post_author', get_the_ID())),
                'label' => 'Author',
            ),
            array(
                'value' => number_format_i18n(str_word_count(wp_strip_all_tags(get_the_content()))),
                'label' => 'Words',
            ),
            array(
                'value' => ($hero_location ? wp_strip_all_tags($hero_location) : 'Sedgemore'),
                'label' => 'Destination',
            ),
        );
    }

    if (empty($itin_title)) {
        $itin_title = 'A journey, <em>curated as a story.</em>';
    }

    if (! $itin_note) {
        $itin_note = 'Use the itinerary section for a sequence of moments, or treat it as a long-form editorial module that can be reused for any destination story.';
    }

    if (empty($itin_days) || ! is_array($itin_days)) {
        $itin_days = array(
            array(
                'day_number' => '01',
                'day_kicker'  => 'Story',
                'day_title'   => get_the_title(),
                'day_body'    => get_the_content(null, false),
                'day_tags'    => '',
            ),
        );
    }

    if (! $exp_title) {
        $exp_title = 'Experiences <em>in focus.</em>';
    }

    if (! $exp_note) {
        $exp_note = 'Add image-led highlights here to create the horizontal gallery feel from the reference pages.';
    }

    if (empty($experiences) || ! is_array($experiences)) {
        $experiences = array(
            array(
                'image'  => get_post_thumbnail_id(),
                'region' => $hero_location ? wp_strip_all_tags($hero_location) : 'Sedgemore',
                'title'  => get_the_title(),
            ),
        );
    }

    $experience_count      = count($experiences);
    $experience_grid_class = $experience_count < 4 ? 'exp-grid exp-grid--fill' : 'exp-grid';

    if (! $stay_image) {
        $stay_image = get_post_thumbnail_id();
    }

    if (! $stay_eyebrow) {
        $stay_eyebrow = $hero_location ? wp_strip_all_tags($hero_location) : 'Sedgemore';
    }

    if (! $stay_name) {
        $stay_name = get_the_title();
    }

    if (! $stay_loc) {
        $stay_loc = 'Available on request';
    }

    if (! $stay_text) {
        $stay_text = has_excerpt() ? get_the_excerpt() : get_the_content(null, false);
    }

    if (empty($stay_facts) || ! is_array($stay_facts)) {
        $stay_facts = array(
            array('label' => 'Format', 'value' => 'Blog story'),
            array('label' => 'Created in', 'value' => get_the_date('F Y')),
        );
    }

    if (! $stay_cta_label) {
        $stay_cta_label = 'Enquire about this story';
    }

    if (! $stay_cta_url) {
        $stay_cta_url = '#enquire';
    }

    if (! $contact_kicker) {
        $contact_kicker = 'Let us plan the next one';
    }

    if (! $contact_title) {
        $contact_title = 'Start a conversation';
    }

    if (! $contact_desc) {
        $contact_desc = 'Use this form to turn a story into a live enquiry. The template keeps the same contact contract used throughout the site.';
    }

    if (! $contact_note) {
        $contact_note = '';
    }

    if (! $contact_interest_label) {
        $contact_interest_label = 'Interest';
    }

    if (empty($contact_interest_options) || ! is_array($contact_interest_options)) {
        $contact_interest_options = array(
            array('label' => 'Bespoke travel', 'value' => 'travel'),
            array('label' => 'Events & experiences', 'value' => 'events'),
            array('label' => 'Concierge services', 'value' => 'concierge'),
            array('label' => 'Sedgemore Priv&eacute; membership', 'value' => 'membership'),
            array('label' => 'Corporate travel', 'value' => 'corporate'),
        );
    }

    if (! $contact_message_label) {
        $contact_message_label = 'Anything else we should know?';
    }

    if (! $contact_message_placeholder) {
        $contact_message_placeholder = 'Dietary requirements, special occasions, specific requests';
    }
?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        :root {
            --ink: #161410;
            --ink2: #2C2920;
            --ink3: #3D3A34;
            --fog: #8C8479;
            --mist: #B8B2A7;
            --rule: #D4CBB8;
            --parchment: #F6F1E9;
            --parchment2: #EDE8DF;
            --white: #FDFAF5;
            --dark: #161410;
            --mid: #6b6560;
            --border: rgba(28, 26, 24, 0.12);
            --border-light: rgba(28, 26, 24, 0.07);
            --warm-white: #faf8f5;
            --ff-body: 'Montserrat', Arial, sans-serif;
            --ff-display: 'Cormorant Garamond', Georgia, serif;
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--parchment);
            color: var(--ink);
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden
        }

        img {
            display: block;
            max-width: 100%
        }

        .blog-story-shell {
            background: var(--parchment)
        }

        .hero {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 700px;
            overflow: hidden
        }

        .hero__img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 35%
        }

        .hero__veil {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(20, 18, 14, 0.58) 0%, rgba(20, 18, 14, 0.12) 60%), linear-gradient(to top, rgba(20, 18, 14, 0.72) 0%, transparent 50%)
        }

        .hero__loc {
            position: absolute;
            top: 50%;
            right: 48px;
            transform: translateY(-50%);
            z-index: 2;
            writing-mode: vertical-rl;
            font-size: 9px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px
        }

        .hero__loc::before {
            content: '';
            width: 1px;
            height: 48px;
            background: rgba(255, 255, 255, 0.22)
        }

        .hero__title-wrap {
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 2;
            padding: 0 52px 60px;
            max-width: 75%
        }

        .hero__kicker {
            font-size: 9px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 18px;
            display: block
        }

        .hero__title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(52px, 8vw, 108px);
            font-weight: 400;
            font-style: italic;
            color: #fff;
            line-height: 0.93;
            letter-spacing: -0.01em
        }

        .hero__descriptor {
            position: absolute;
            bottom: 60px;
            right: 52px;
            z-index: 2;
            max-width: 260px;
            text-align: right
        }

        .hero__descriptor p {
            font-size: 12px;
            line-height: 1.82;
            color: rgba(255, 255, 255, 0.55);
            font-weight: 300
        }

        .hero__scroll {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            width: 1px;
            height: 64px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.38), transparent)
        }

        .statement {
            padding: 112px 52px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 0 80px;
            max-width: 1300px;
            margin: 0 auto;
            align-items: start
        }

        .statement__aside {
            padding-top: 10px
        }

        .statement__aside-label {
            font-size: 9px;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: var(--fog);
            display: block;
            margin-bottom: 20px
        }

        .statement__aside-img {
            overflow: hidden;
            aspect-ratio: 3/4;
            margin-top: 28px
        }

        .statement__aside-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 20%;
            transition: transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94)
        }

        .statement__aside-img:hover img {
            transform: scale(1.04)
        }

        .statement__headline {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(34px, 4.2vw, 60px);
            font-weight: 400;
            line-height: 1.1;
            letter-spacing: -0.01em;
            margin-bottom: 44px
        }

        .statement__headline em {
            font-style: italic
        }

        .statement__body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 48px
        }

        .statement__body p {
            font-size: 14px;
            line-height: 1.95;
            color: var(--ink3);
            font-weight: 300;
            margin-bottom: 20px
        }

        .statement__pull {
            grid-column: 1/-1;
            border-top: 1px solid var(--rule);
            padding-top: 32px;
            margin-top: 12px;
            display: flex;
            align-items: flex-start;
            gap: 22px
        }

        .statement__pull::before {
            content: '';
            flex-shrink: 0;
            width: 2px;
            height: 44px;
            background: var(--ink);
            margin-top: 4px
        }

        .statement__pull p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-style: italic;
            font-weight: 400;
            color: var(--ink);
            line-height: 1.55;
            margin-bottom: 0
        }

        .stats {
            background: var(--ink);
            display: grid;
            grid-template-columns: repeat(4, 1fr)
        }

        .stats__cell {
            padding: 52px 44px;
            border-right: 1px solid rgba(255, 255, 255, 0.07)
        }

        .stats__cell:last-child {
            border-right: none
        }

        .stats__n {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(44px, 5vw, 62px);
            font-weight: 400;
            color: #fff;
            display: block;
            line-height: 1;
            letter-spacing: -0.02em;
            margin-bottom: 12px
        }

        .stats__l {
            font-size: 9px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.65;
            display: block
        }

        .itin-intro {
            padding: 112px 52px 0;
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 1px solid var(--rule);
            padding-bottom: 52px;
            gap: 40px
        }

        .itin-intro__title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(44px, 5.5vw, 72px);
            font-weight: 400;
            line-height: 1.03;
            letter-spacing: -0.01em
        }

        .itin-intro__title em {
            font-style: italic
        }

        .itin-intro__note {
            max-width: 360px;
            font-size: 13px;
            line-height: 1.9;
            color: var(--fog);
            font-weight: 300
        }

        .itin-days {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 52px
        }

        .day {
            display: grid;
            grid-template-columns: 112px 1fr 1fr;
            gap: 0;
            padding: 60px 0;
            border-bottom: 1px solid var(--rule);
            align-items: start;
            position: relative
        }

        .day__n {
            font-family: 'Cormorant Garamond', serif;
            font-size: 112px;
            font-weight: 300;
            color: transparent;
            -webkit-text-stroke: 1px var(--rule);
            line-height: 0.85;
            letter-spacing: -0.03em;
            user-select: none;
            padding-top: 6px
        }

        .day__left {
            padding: 0 52px 0 18px;
            border-right: 1px solid var(--rule)
        }

        .day__kicker {
            font-size: 9px;
            letter-spacing: 0.26em;
            text-transform: uppercase;
            color: var(--fog);
            display: block;
            margin-bottom: 14px
        }

        .day__title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(19px, 2vw, 26px);
            font-weight: 400;
            color: var(--ink);
            line-height: 1.32
        }

        .day__right {
            padding: 0 0 0 52px
        }

        .day__body {
            font-size: 13px;
            line-height: 1.95;
            color: var(--ink3);
            font-weight: 300;
            margin-bottom: 22px
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 7px
        }

        .tag {
            font-size: 9px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--fog);
            border: 1px solid var(--rule);
            padding: 5px 12px;
            background: transparent;
            transition: border-color 0.25s ease, color 0.25s ease;
            cursor: default
        }

        .tag:hover {
            border-color: var(--ink);
            color: var(--ink)
        }

        .exp-header {
            padding: 104px 52px 52px;
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 48px
        }

        .exp-header__title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(40px, 5vw, 64px);
            font-weight: 400;
            line-height: 1.04;
            letter-spacing: -0.01em
        }

        .exp-header__title em {
            font-style: italic
        }

        .exp-header__note {
            max-width: 320px;
            font-size: 13px;
            line-height: 1.88;
            color: var(--fog);
            font-weight: 300
        }

        .exp-grid {
            display: flex;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            gap: 3px;
            cursor: grab
        }

        .exp-grid:active {
            cursor: grabbing
        }

        .exp-grid::-webkit-scrollbar {
            height: 2px
        }

        .exp-grid::-webkit-scrollbar-track {
            background: var(--rule)
        }

        .exp-grid::-webkit-scrollbar-thumb {
            background: var(--ink)
        }

        .exp-cell {
            position: relative;
            overflow: hidden;
            flex: 0 0 520px;
            height: 560px;
            scroll-snap-align: start
        }

        @media(min-width:769px) {
            .exp-grid--fill {
                overflow-x: hidden;
                scroll-snap-type: none;
                cursor: default
            }

            .exp-grid--fill:active {
                cursor: default
            }

            .exp-grid--fill .exp-cell {
                flex: 1 1 0;
                min-width: 0
            }
        }

        .exp-cell img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            pointer-events: none
        }

        .exp-cell:hover img {
            transform: scale(1.04)
        }

        .exp-cell__cap {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 80px 28px 28px;
            background: linear-gradient(transparent, rgba(16, 13, 10, 0.88))
        }

        .exp-cell__region {
            font-size: 9px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            display: block;
            margin-bottom: 6px
        }

        .exp-cell__title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 400;
            font-style: italic;
            color: #fff;
            line-height: 1.3
        }

        .stay {
            display: grid;
            grid-template-columns: 55% 45%;
            min-height: 640px;
            margin-top: 3px
        }

        .stay__img {
            position: relative;
            overflow: hidden
        }

        .stay__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 50%;
            transition: transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94)
        }

        .stay__img:hover img {
            transform: scale(1.04)
        }

        .stay__body {
            background: var(--ink);
            padding: 88px 68px;
            display: flex;
            flex-direction: column;
            justify-content: center
        }

        .stay__eyebrow {
            font-size: 9px;
            letter-spacing: 0.26em;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 22px
        }

        .stay__name {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(34px, 3.5vw, 50px);
            font-weight: 400;
            color: #fff;
            line-height: 1.05;
            letter-spacing: -0.01em;
            margin-bottom: 6px
        }

        .stay__loc {
            font-size: 10px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 32px
        }

        .stay__text {
            font-size: 13px;
            line-height: 1.95;
            color: #fff;
            font-weight: 300;
            margin-bottom: 12px
        }

        .stay__facts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 20px;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08)
        }

        .stay__dt {
            font-size: 9px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.55);
            display: block;
            margin-bottom: 4px
        }

        .stay__dd {
            font-size: 12px;
            color: #fff;
            font-weight: 300
        }

        .stay__cta {
            display: inline-block;
            margin-top: 40px;
            align-self: flex-start;
            font-size: 9px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 12px 26px;
            text-decoration: none;
            transition: background 0.25s ease, color 0.25s ease, border-color 0.25s ease
        }

        .stay__cta:hover {
            background: #fff;
            color: var(--ink);
            border-color: #fff
        }

        .contact {
            background: var(--parchment);
            padding: 112px 52px;
            border-top: 1px solid var(--rule);
            position: relative;
            overflow: hidden
        }

        .contact__ghost {
            position: absolute;
            bottom: -60px;
            right: -30px;
            font-family: 'Cormorant Garamond', serif;
            font-size: 360px;
            font-weight: 300;
            font-style: italic;
            color: transparent;
            -webkit-text-stroke: 1px rgba(22, 20, 16, 0.05);
            line-height: 1;
            pointer-events: none;
            user-select: none
        }

        .contact__inner {
            max-width: 1300px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 96px;
            align-items: start
        }

        .contact__kicker {
            font-size: 9px;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: var(--fog);
            margin-bottom: 20px;
            display: block
        }

        .contact__title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(36px, 4.5vw, 60px);
            font-weight: 400;
            font-style: italic;
            color: var(--ink);
            line-height: 1.08;
            letter-spacing: -0.01em;
            margin-bottom: 24px
        }

        .contact__desc {
            font-size: 13px;
            line-height: 1.92;
            color: var(--ink3);
            font-weight: 300;
            max-width: 380px
        }

        .contact__form {
            padding-top: 8px
        }

        .form-group {
            margin-bottom: 20px
        }

        .form-label {
            display: block;
            font-size: 9px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--fog);
            margin-bottom: 8px
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            background: var(--white);
            border: 1px solid var(--rule);
            color: var(--ink);
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 300;
            padding: 14px 16px;
            outline: none;
            transition: border-color 0.25s ease, background 0.25s ease;
            -webkit-appearance: none;
            appearance: none;
            border-radius: 0
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--mist)
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--ink);
            background: var(--white)
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='none'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%238C8479' stroke-width='1.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
            cursor: pointer;
            background-color: var(--white)
        }

        .form-select option {
            background: var(--white);
            color: var(--ink)
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .form-submit {
            width: 100%;
            margin-top: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            font-weight: 400;
            color: var(--white);
            background: var(--ink);
            border: 1px solid var(--ink);
            padding: 15px 28px;
            cursor: pointer;
            transition: background 0.25s ease, color 0.25s ease, border-color 0.25s ease
        }

        .form-submit:hover {
            background: var(--ink2);
            border-color: var(--ink2)
        }

        .form-note {
            font-size: 10px;
            line-height: 1.7;
            color: var(--mist);
            margin-top: 14px;
            font-weight: 300;
            text-align: center
        }

        .blog-story .enquire-cta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            padding: 96px 64px;
            background: var(--warm-white);
        }

        .blog-story .enquire-text{
            margin: 0 auto auto;
        }
        .blog-story .enquire-text h2 {
            margin: 0 0 20px;
            color: var(--dark);
            font-size: clamp(36px, 3.5vw, 52px);
            font-weight: 300;
            font-family: Cormorant Garamond, serif !important;
            line-height: 1.12;
        }

        .blog-story .enquire-text p {
            margin: 0 0 36px;
            color: var(--mid);
            font-size: 15px;
            font-weight: 300;
            letter-spacing: 0.02em;
            line-height: 1.8;
            max-width: 380px;
        }

        .blog-story .enquire-form {
            display: block;
        }

        .blog-story .form-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .blog-story .enquire-cta .form-group {
            margin-bottom: 16px;
        }

        .blog-story .enquire-cta .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--mid);
            font-family: var(--ff-body);
            font-size: 10px;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        .blog-story .enquire-cta .form-group input,
        .blog-story .enquire-cta .form-group select,
        .blog-story .enquire-cta .form-group textarea {
            width: 100%;
            padding: 12px 0;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--border);
            border-radius: 0;
            box-shadow: none;
            color: var(--dark);
            font-family: var(--ff-body);
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 0.02em;
            outline: none;
            appearance: none;
            transition: border-color 0.3s ease;
        }

        .blog-story .enquire-cta .form-group input:focus,
        .blog-story .enquire-cta .form-group select:focus,
        .blog-story .enquire-cta .form-group textarea:focus {
            border-color: var(--gold);
        }

        .blog-story .enquire-cta .form-group input::placeholder,
        .blog-story .enquire-cta .form-group textarea::placeholder {
            color: rgba(28, 26, 24, 0.35);
        }

        .blog-story .enquire-cta .form-group textarea {
            min-height: 120px;
            line-height: 1.6;
            resize: vertical;
        }

        .blog-story .interest-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 18px;
            padding: 12px 0 4px;
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .blog-story .interest-option {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 0.01em;
            color: var(--charcoal);
            cursor: pointer;
        }

        .blog-story #home-enquiry-form .interest-option input[type="checkbox"] {
            appearance: auto;
            accent-color: #2E2E2E;
            width: 16px;
            height: 16px;
            margin: 0;
            padding: 0;
            border: 1px solid var(--border);
        }

        .blog-story .form-message {
            min-height: 20px;
            margin-top: 16px;
            font-family: var(--ff-body);
            font-size: 13px;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: 0.02em;
            color: var(--mid);
        }

        .blog-story .form-message.success {
            color: #2f6b3d;
        }

        .blog-story .form-message.error {
            color: #9a4b43;
        }

        .blog-story .enquire-cta .form-submit {
            width: 100%;
            background: var(--dark);
            border: none;
            color: #fff;
            padding: 18px;
            font-family: var(--ff-body);
            font-size: 11px;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 24px;
            transition: background 0.3s;
        }

        .blog-story .enquire-cta .form-submit:hover {
            background: var(--ink2);
        }

        @media(min-width:769px) and (max-width:1024px) {

            .hero__loc,
            .hero__descriptor {
                display: none
            }

            .hero__title-wrap {
                padding: 0 36px 52px;
                max-width: 90%
            }

            .statement {
                padding: 80px 36px;
                gap: 0 48px
            }

            .statement__body {
                grid-template-columns: 1fr
            }

            .stats {
                grid-template-columns: repeat(2, 1fr)
            }

            .stats__cell:nth-child(2) {
                border-right: none
            }

            .stats__cell:nth-child(3) {
                border-top: 1px solid rgba(255, 255, 255, 0.07)
            }

            .itin-intro {
                padding: 80px 36px 44px;
                flex-direction: column;
                align-items: flex-start
            }

            .itin-days {
                padding: 0 36px
            }

            .day {
                grid-template-columns: 72px 1fr 1fr;
                padding: 44px 0
            }

            .day__n {
                font-size: 72px
            }

            .day__left {
                padding: 0 32px 0 14px
            }

            .day__right {
                padding-left: 32px
            }

            .exp-header {
                padding: 80px 36px 44px
            }

            .exp-cell {
                flex: 0 0 400px;
                height: 480px
            }

            .stay {
                grid-template-columns: 1fr
            }

            .stay__img {
                height: 360px
            }

            .stay__body {
                padding: 52px 36px
            }

            .enquire-cta {
                padding: 80px 36px;
                gap: 48px
            }

            .enquire-cta,
            .enquire-text {
                grid-template-columns: 1fr
            }

            .interest-grid {
                grid-template-columns: 1fr
            }
        }

        @media(max-width:768px) {

            .hero__loc,
            .hero__descriptor {
                display: none
            }

            .hero__title-wrap {
                padding: 0 22px 52px;
                max-width: 100%
            }

            .hero__title {
                font-size: clamp(44px, 12vw, 62px)
            }

            .statement {
                grid-template-columns: 1fr;
                padding: 64px 22px;
                gap: 0
            }

            .statement__aside {
                border-bottom: 1px solid var(--rule);
                padding-bottom: 36px;
                margin-bottom: 36px
            }

            .statement__aside-img {
                aspect-ratio: 16/9
            }

            .statement__headline {
                font-size: clamp(30px, 8vw, 42px);
                margin-bottom: 28px
            }

            .statement__body {
                grid-template-columns: 1fr
            }

            .statement__pull p {
                font-size: 17px
            }

            .stats {
                grid-template-columns: 1fr 1fr
            }

            .stats__cell {
                padding: 28px 20px
            }

            .stats__cell:nth-child(even) {
                border-right: none
            }

            .stats__cell:nth-child(3),
            .stats__cell:nth-child(4) {
                border-top: 1px solid rgba(255, 255, 255, 0.07)
            }

            .stats__n {
                font-size: 36px
            }

            .itin-intro {
                padding: 64px 22px 32px;
                flex-direction: column;
                align-items: flex-start;
                gap: 18px
            }

            .itin-intro__note {
                max-width: 100%
            }

            .itin-days {
                padding: 0 22px
            }

            .day {
                grid-template-columns: 1fr;
                padding: 36px 0;
                gap: 20px;
                position: relative
            }

            .day__n {
                font-size: 72px;
                position: absolute;
                top: 24px;
                right: 0;
                opacity: 0.35
            }

            .day__left {
                border-right: none;
                padding: 0;
                padding-right: 64px
            }

            .day__right {
                padding: 0
            }

            .day__title {
                font-size: 19px
            }

            .day__body {
                font-size: 13px
            }

            .exp-header {
                padding: 64px 22px 32px;
                flex-direction: column;
                align-items: flex-start;
                gap: 18px
            }

            .exp-cell {
                flex: 0 0 85vw;
                height: 340px
            }

            .stay {
                grid-template-columns: 1fr
            }

            .stay__img {
                height: 260px
            }

            .stay__body {
                padding: 40px 22px 48px
            }

            .stay__cta {
                width: 100%;
                text-align: center
            }
            .blog-story .enquire-cta{
                display: block;
                padding: 20px;
            }

            .enquire-text h2 {
                font-size: clamp(32px, 9vw, 48px)
            }

            .enquire-text p {
                font-size: 14px
            }

            .form-2col {
                grid-template-columns: 1fr;
                gap: 0
            }

            .interest-grid {
                grid-template-columns: 1fr
            }

            .enquire-cta .form-submit {
                width: 100%;
                padding-left: 20px;
                padding-right: 20px
            }
        }
    </style>

    <div class="header_nav nav-menu">
        <?php get_template_part('template-parts/header_nav_inner'); ?>
        <div class="clear"></div>
    </div>

    <main class="blog-story">
        <section class="hero">
            <?php if ($hero_image) : ?>
                <img class="hero__img" src="<?php echo esc_url(sedgemore_blog_asset_url($hero_image)); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
            <?php elseif (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('full', array('class' => 'hero__img')); ?>
            <?php endif; ?>
            <div class="hero__veil"></div>
            <div class="hero__loc"><?php echo esc_html(wp_strip_all_tags($hero_location ? $hero_location : $hero_kicker)); ?></div>
            <div class="hero__title-wrap">
                <span class="hero__kicker"><?php echo wp_kses_post($hero_kicker); ?></span>
                <h1 class="hero__title"><?php echo wp_kses($hero_title, array('br' => array())); ?></h1>
            </div>
            <div class="hero__descriptor">
                <p><?php echo wp_kses_post($hero_descriptor); ?></p>
            </div>
            <div class="hero__scroll"></div>
        </section>

        <section class="statement">
            <div class="statement__aside">
                <span class="statement__aside-label"><?php echo esc_html(wp_strip_all_tags($statement_label ? $statement_label : $hero_location)); ?></span>
                <div class="statement__aside-img">
                    <?php if ($statement_image) : ?>
                        <img src="<?php echo esc_url(sedgemore_blog_asset_url($statement_image)); ?>" alt="<?php echo esc_attr(wp_strip_all_tags($statement_label ? $statement_label : $hero_location)); ?>">
                    <?php elseif (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('full'); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="statement__main">
                <h2 class="statement__headline"><?php echo wp_kses_post($statement_headline); ?></h2>
                <div class="statement__body">
                    <div><?php echo wp_kses_post($statement_left_text); ?></div>
                    <div><?php echo wp_kses_post($statement_right_text); ?></div>
                    <div class="statement__pull">
                        <p><?php echo wp_kses_post($pull_quote); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <div class="stats">
            <?php foreach ($stats as $stat) : ?>
                <div class="stats__cell">
                    <span class="stats__n"><?php echo esc_html($stat['value'] ?? ''); ?></span>
                    <span class="stats__l"><?php echo esc_html($stat['label'] ?? ''); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="itin-intro">
            <h2 class="itin-intro__title"><?php echo wp_kses_post($itin_title); ?></h2>
            <p class="itin-intro__note"><?php echo wp_kses_post($itin_note); ?></p>
        </div>
        <div class="itin-days">
            <?php foreach ($itin_days as $day) : ?>
                <article class="day">
                    <div class="day__n"><?php echo esc_html($day['day_number'] ?? ''); ?></div>
                    <div class="day__left">
                        <span class="day__kicker"><?php echo esc_html($day['day_kicker'] ?? ''); ?></span>
                        <h3 class="day__title"><?php echo esc_html($day['day_title'] ?? ''); ?></h3>
                    </div>
                    <div class="day__right">
                        <div class="day__body"><?php echo wp_kses_post($day['day_body'] ?? ''); ?></div>
                        <?php if (! empty($day['day_tags'])) : ?>
                            <div class="tags">
                                <?php foreach (preg_split('/,\s*/', wp_strip_all_tags($day['day_tags'])) as $tag) : if (! $tag) {
                                        continue;
                                    } ?>
                                    <span class="tag"><?php echo esc_html($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="exp-header">
            <h2 class="exp-header__title"><?php echo wp_kses_post($exp_title); ?></h2>
            <p class="exp-header__note"><?php echo wp_kses_post($exp_note); ?></p>
        </div>
        <div class="<?php echo esc_attr($experience_grid_class); ?>">
            <?php foreach ($experiences as $experience) : ?>
                <div class="exp-cell">
                    <?php if (! empty($experience['image'])) : ?>
                        <img src="<?php echo esc_url(sedgemore_blog_asset_url($experience['image'])); ?>" alt="<?php echo esc_attr($experience['title'] ?? ''); ?>">
                    <?php elseif (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('full'); ?>
                    <?php endif; ?>
                    <div class="exp-cell__cap">
                        <span class="exp-cell__region"><?php echo esc_html($experience['region'] ?? ''); ?></span>
                        <div class="exp-cell__title"><?php echo esc_html($experience['title'] ?? ''); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="stay">
            <div class="stay__img">
                <?php if ($stay_image) : ?>
                    <img src="<?php echo esc_url(sedgemore_blog_asset_url($stay_image)); ?>" alt="<?php echo esc_attr($stay_name); ?>">
                <?php elseif (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full'); ?>
                <?php endif; ?>
            </div>
            <div class="stay__body">
                <div class="stay__eyebrow"><?php echo esc_html($stay_eyebrow); ?></div>
                <div class="stay__name"><?php echo esc_html($stay_name); ?></div>
                <div class="stay__loc"><?php echo esc_html($stay_loc); ?></div>
                <div class="stay__text"><?php echo wp_kses_post($stay_text); ?></div>
                <div class="stay__facts">
                    <?php foreach ($stay_facts as $fact) : ?>
                        <div>
                            <span class="stay__dt"><?php echo esc_html($fact['label'] ?? ''); ?></span>
                            <div class="stay__dd"><?php echo esc_html($fact['value'] ?? ''); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="stay__cta" href="<?php echo esc_url($stay_cta_url); ?>"><?php echo esc_html($stay_cta_label); ?></a>
            </div>
        </div>

        <section id="enquire" class="enquire-cta">
            <div class="enquire-text">
                <p class="section-label"><?php echo esc_html($contact_kicker); ?></p>
                <h2>
                    <?php echo wp_kses(
                        $contact_title,
                        array(
                            'br' => array(),
                            'i'  => array(),
                        )
                    ); ?>
                </h2>
                <p><?php echo esc_html($contact_desc); ?></p>
                <p style="font-size:13px;color:var(--mid);letter-spacing:0.02em;"><?php echo esc_html($contact_note); ?></p>
            </div>

            <form id="home-enquiry-form" class="enquire-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="home_form">
                <?php wp_nonce_field('home_nonce_action', 'home_nonce'); ?>
                <div class="form-2col">
                    <div class="form-group">
                        <label for="home_first_name">First name</label>
                        <input id="home_first_name" type="text" name="first_name" placeholder="First name" required>
                    </div>
                    <div class="form-group">
                        <label for="home_last_name">Last name</label>
                        <input id="home_last_name" type="text" name="last_name" placeholder="Last name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="home_email">Email address</label>
                    <input id="home_email" type="email" name="email" placeholder="name@example.com" required>
                </div>

                <div class="form-group">
                    <label for="home_phone">Phone number</label>
                    <input id="home_phone" type="tel" name="phone" placeholder="+447960629866" value="+44" inputmode="tel">
                </div>

                <div class="form-group">
                    <label><?php echo esc_html($contact_interest_label); ?></label>
                    <div class="interest-grid" role="group" aria-label="<?php echo esc_attr($contact_interest_label); ?>">
                        <?php foreach ($contact_interest_options as $index => $interest_option) :
                            $interest_label = isset($interest_option['label']) ? (string) $interest_option['label'] : '';
                            $interest_value  = isset($interest_option['value']) ? (string) $interest_option['value'] : '';
                            if (! $interest_value) {
                                $interest_value = sanitize_title($interest_label);
                            }
                            if (! $interest_label || ! $interest_value) {
                                continue;
                            }
                            $interest_id = 'home_topic_' . $index . '_' . sanitize_title($interest_value);
                        ?>
                            <label class="interest-option" for="<?php echo esc_attr($interest_id); ?>">
                                <input id="<?php echo esc_attr($interest_id); ?>" type="checkbox" name="topic[]" value="<?php echo esc_attr($interest_value); ?>">
                                <span><?php echo esc_html($interest_label); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="home_message"><?php echo esc_html($contact_message_label); ?></label>
                    <textarea id="home_message" name="message" placeholder="<?php echo esc_attr($contact_message_placeholder); ?>" required></textarea>
                </div>

                <div id="home-form-message" class="form-message" aria-live="polite"></div>

                <button class="form-submit" type="submit">Send enquiry</button>
            </form>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var enquiryForm = document.getElementById('home-enquiry-form');
            var enquiryMessage = document.getElementById('home-form-message');

            if (enquiryForm && enquiryMessage && typeof myAjaxObject !== 'undefined') {
                enquiryForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    var selectedTopics = enquiryForm.querySelectorAll('input[name="topic[]"]:checked');
                    if (selectedTopics.length === 0) {
                        enquiryMessage.textContent = 'Please select at least one interest.';
                        enquiryMessage.classList.remove('success');
                        enquiryMessage.classList.add('error');
                        return;
                    }

                    if (!enquiryForm.checkValidity()) {
                        enquiryMessage.textContent = 'Please complete all required fields.';
                        enquiryMessage.classList.remove('success');
                        enquiryMessage.classList.add('error');
                        enquiryForm.reportValidity();
                        return;
                    }

                    // keep message area empty while sending; button shows progress
                    enquiryMessage.textContent = '';
                    enquiryMessage.classList.remove('success', 'error');

                    var submitButton = enquiryForm.querySelector('.form-submit');
                    var _origButtonText = null;
                    if (submitButton) {
                        _origButtonText = submitButton.textContent;
                        submitButton.disabled = true;
                        submitButton.textContent = 'Sending...';
                        submitButton.setAttribute('aria-busy', 'true');
                    }

                    var formData = new FormData(enquiryForm);

                    // DEBUG: log FormData entries to console to confirm payload
                    try {
                        var _pairs = [];
                        formData.forEach(function(v, k) {
                            _pairs.push(k + "=" + v);
                        });
                        console.log('Home payload:', _pairs.join('&'));
                    } catch (e) {}

                    // disable other form fields to prevent edits while sending
                    var _disabledElems = enquiryForm.querySelectorAll('input, textarea, select, button');
                    _disabledElems.forEach(function(el) {
                        if (el === submitButton) return;
                        if (!el.disabled) {
                            el.classList.add('sedgemore-temp-disabled');
                            el.disabled = true;
                        }
                    });

                    fetch(myAjaxObject.ajaxurl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        })
                        .then(function(response) {
                            if (response.ok) {
                                return response.json().then(function(data) {
                                    if (data && data.success) {
                                        enquiryMessage.textContent = (data.data && data.data.message) ? data.data.message : 'Thank you. Your message has been sent.';
                                        enquiryMessage.classList.add('success');
                                        enquiryForm.reset();
                                        return;
                                    }
                                    enquiryMessage.textContent = (data && data.data && data.data.message) ? data.data.message : 'An error occurred during submission.';
                                    enquiryMessage.classList.add('error');
                                });
                            }

                            // Non-JSON or non-200 response: read text and show it for debugging
                            return response.text().then(function(txt) {
                                enquiryMessage.textContent = txt || 'Server error (status ' + response.status + ').';
                                enquiryMessage.classList.add('error');
                            });
                        })
                        .catch(function(err) {
                            console.error('Fetch error', err);
                            enquiryMessage.textContent = 'Network error. Please try again.';
                            enquiryMessage.classList.add('error');
                        })
                        .finally(function() {
                            // re-enable fields we disabled
                            var _reenable = enquiryForm.querySelectorAll('.sedgemore-temp-disabled');
                            _reenable.forEach(function(el) {
                                el.disabled = false;
                                el.classList.remove('sedgemore-temp-disabled');
                            });

                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.textContent = _origButtonText || 'Send enquiry';
                                submitButton.removeAttribute('aria-busy');
                            }
                        });
                });
            }
        });
    </script>

<?php
endwhile;

get_footer();
