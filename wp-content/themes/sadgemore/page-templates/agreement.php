<?php

/**
 * The template for displaying all single posts
 * 
 * Template Name: Agreement
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sadgemore
 */

get_header();
?>

<!-- Start Agreement section -->
<?php 
$agreement_section = get_field('agreement');
?>
<section>
    <div class="general_section pt-24">
        <div class="general_title wow fadeInDown " style="visibility: visible; animation-delay: 0.3s;">
            <div class="general_title_text">Agreement</div>
            <div class="general_title_line"></div>
        </div>
        <div class="general_wrap wrap-general-match-line pt-8" style="margin: 0 auto; text-align:center; ">
            <div style="text-align:left;">

                <?php if ( $agreement_section ):  ?>
                   
                    <?php print isset( $agreement_section ) ? $agreement_section : '' ?>
                     
                <?php endif; ?>    

                    <?php // the_content(); ?>
            </div>  
            <div class="clear"></div>
 
        </div>
    </div>
</section>
<!-- End Agreement section -->

<!-- Start Terms and Conditions section -->
<?php 
$agreement_section = get_field('terms_and_conditions');
?>
<section id="terms">
    <div class="general_section pt-4">
        <div class="general_title wow fadeInDown " style="visibility: visible; animation-delay: 0.3s;">
            <div class="general_title_text">Terms and Conditions</div>
            <div class="general_title_line"></div>
        </div>
        <div class="general_wrap wrap-general-match-line pt-8" style="margin: 0 auto; text-align:center; ">
            <div style="text-align:left;">

                <?php if ( $agreement_section ):  ?>
                  
                <?php print isset( $agreement_section ) ?  $agreement_section  : '' ?>
                       
                <?php endif; ?>    

                <?php //the_content(); ?>
            </div>  
            <div class="clear"></div>

        </div>
    </div>
</section>
<!-- End Terms and Conditions section -->

<div class="header_nav nav-menu">
    <?php get_template_part('template-parts/header_nav_inner'); ?>
    <div class="clear"></div>
</div>
<!-- End Banner Section -->

<style type="text/css">

    .general_section{
        background: #f1eeea;
        padding: 40px 0;
       /* padding-top: 80px;
        padding-bottom:80px;*/
    }

    .general_title{
        font-size: 20px;
        letter-spacing: 3px;
        color: #000;
        font-weight: 500;
        text-align:center;
    }

    .general_title_text {
        background: #f1eeea;
        display: inline-block;
        padding: 0px 4%;
        color: #313131;
       /* font-weight: 400;
        font-family: "alta";*/
        font-family: "Jost_300";
        text-transform:uppercase;
        font-size: 18px;
    }

    .general_title_line {
        min-width: 300px;
        max-width: 600px;
        width: 50%;
        height: 0.5px;
        background: #989694;
        z-index: -1;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }

    @media only screen and (min-width: 700px) {
        .general_title_line{
            width: 100%;
        }

    }

    .wrap-general-match-line{
        min-width: 300px;
        max-width: 1100px;
        width: 100%;
    }

    .general_wrap {
        width: 100%;
        padding: 0px 10%;
        margin-bottom: 180px;
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


    .header_nav .a_cross {
        display: none;
    }

 

    @media only screen and (min-width: 1340px) {
       
    }
</style>
<?php
get_footer();
