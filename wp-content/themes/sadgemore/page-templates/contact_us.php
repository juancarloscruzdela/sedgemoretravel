<?php

/**
 * The template for displaying all single posts
 * 
 * Template Name: Contact Us
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sadgemore
 */

get_header();
?>

<div class="about_baner_main">
    <div class="mangmnt_team">
        <div class="mangmnt_team_text">
            CONTACT US
        </div>
        <div class="mangmnt_team_line">
        </div>
    </div>
    <div class="clear"></div>
    <div class="wrap_team_hedr">
        <?php
        $contact_details = get_field('contact_details');
        $enquiry_options = get_field('enquiry_options');
        ?>
        <div class="auto-container">
            <div class="contct_us_left wow fadeInLeft" style="visibility: visible; animation-delay: 0.3s;">
                <div class="cont_left_inr1">
                    <?php echo isset($contact_details['title']) ? $contact_details['title'] : ''; ?>
                </div>
                <div class="cont_left_inr2">
                    <div class="cont_left_inr2_1">
                        <?php echo isset($contact_details['contact_info']) ? $contact_details['contact_info'] : ''; ?>
                    </div>
                    <div class="cont_left_inr2_1 cont_left_inr2_2">
                        <?php echo isset($contact_details['address']) ? $contact_details['address'] : ''; ?>
                    </div>
                </div>

                <div class="clear"></div>
            </div>

            <div class="contct_us_right wow fadeInRight" style="visibility: visible; animation-delay: 0.3s;">
                <div class="form_right_a">
                    <form id="contact-form" action="" method="post">
                        <div class="form_con_singl">
                            <input type="text" placeholder="Name" name="username">
                        </div>
                        <div class="form_con_singl">
                            <input type="text" placeholder="Surname" name="surname">
                        </div>
                        <div class="clear"></div>
                        <div class="form_con_singl form_con_singl_half">
                            <input type="email" placeholder="Email" name="email" id="email">
                        </div>
                        <div class="or_labl_clas">
                            OR
                        </div>
                        <div class="form_con_singl form_con_singl_half cel_input_wrp">
                            <input type="text" placeholder="Mobile" class="cel_input" name="phone" id="phone">
                            <div class="cel_plac" style="margin-left:50px;">+44</div>
                        </div>
                        <div class="clear"></div>
                        <div class="form_con_singl form_con_singl_selct">
                            <select name="subject">
                                <option value="" disabled selected>Enquiry</option>
                                <?php
                                if ($enquiry_options) {
                                    foreach ($enquiry_options as $option) {
                                        echo '<option value="' . $option['options'] . '">' . $option['options'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <div class="down_ar_selct">
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="form_con_singl text_wrap_cont_msg">
                            <textarea placeholder="Message" rows="3" name="message" id="message"></textarea>
                            <div class="count_msg">
                                250
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="message">
                        </div>
                        <?php wp_nonce_field('contact_nonce'); ?>
                        <button type="submit" class="send_btn_a sedgemore-btn">SEND</button>

                    </form>
                </div>
                <div class="clear"></div>
            </div>

        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="header_nav  nav-menu">
    <?php get_template_part('template-parts/header_nav_inner'); ?>
    <div class="clear"></div>
</div>
<!-- End Banner Section -->

<style type="text/css">
    .active_hom {
        background: #f64a3e;
        color: #fff;
    }

    .about_baner_main {
        min-height: unset;
    }

    .header_new {
        width: 100%;
        margin-left: 0%;
    }



    .header_nav {
        background: #F8F5F1;
    }

    .divider_sharp_dark {
        display: none !important;
    }

    .divider_sharp_bright {
        display: inline-block !important;
    }

    .mangmnt_team {
        display: none;
    }

    .header_nav .a_cross {
        display: none;
    }
</style>
<?php
get_footer();
