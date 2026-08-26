<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sadgemore
 */

get_header();
?>

<style type="text/css">
   /* .active_hom{
   background: #f64a3e;
   color: #fff;
   } */
   .header_bright{
   display: block;
   }
   .header_dark{
   display: none;
   }
   .header_nav_fixed{
   background:#f1eeea;
   }
   .divider_sharp_bright{
   display: none !important;
   }
   .divider_sharp_dark{
   display: inline-block !important;
   }
   .banner-section .slide {
   padding: 100px 0px 200px 0px;
   min-height: 720px;
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

   .owl-dots{
      display: none;
   }

   .owl-nav {
    opacity: 1 !important;
}

   

.flaticon-back-1:before {
    content: "\f163";
}

.flaticon-arrow-pointing-to-right:before {
    content: "\f162";
}



</style>
<!-- Banner Section -->
<?php
$banners = get_field( 'banner' );

if( $banners ): ?>
<section class="banner-section">
   <div class="main-slider-carousel owl-carousel owl-theme">
    <?php 
      foreach( $banners as $banner ) : ?>
      <div class="slide" style="background-image: url(<?php echo $banner['background_image']; ?>);     background-size: cover !important; ">
         <div class="auto-container">
            <!-- Content Column -->
            <?php
            $top_title = isset( $banner['top_title'] ) ? $banner['top_title'] : '';
            $title = isset( $banner['title'] ) ? $banner['title'] : '';
            $content = isset( $banner['content'] ) ? $banner['content'] : '';
            $button = isset( $banner['button'] ) ? $banner['button'] : '';
            ?>
            <div class="content-column">
               <div class="inner-column">
                  <div class="center_slider_text">
                     <div class="center_slider_text_iner">
                        <div class="travl_into wow fadeInDown" style="visibility: visible; animation-delay: 0.4s;">
                            <?php echo $top_title; ?>
                        </div>
                        <div class="hedi_slider wow fadeInDown" style="visibility: visible; animation-delay: 0.4s;">
                            <?php echo $title; ?>
                        </div>
                        <div class="lorem_slider_2 wow fadeInDown" style="visibility: visible; animation-delay: 0.4s;">
                            <?php echo $content; ?>
                        </div>
                        <?php if($button): ?>
                        <a href="<?php echo $button['url']; ?>" target="<?php echo $button['url']; ?>" class="enqry_btn wow fadeInUp" style="visibility: visible; animation-delay: 0.8s;" >
                            <?php echo $button['title']; ?>
                        </a>
                        <?php endif; ?>                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php
      endforeach; ?>
   </div>
</section>
<?php
endif;
?>

<div class="header_nav">
    <div class="a_cross" >  
      <a href="<?php echo home_url('/travel'); ?>" class="a_cross_ancr">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/cross_white.png' ?>" class="" >
      </a>
   </div>

   <div class="clear"></div>
   <div class="header_nav_inner">
    <?php  get_template_part( 'template-parts/header_nav_inner' ); ?>
   </div>
   <div class="clear"></div>
</div>
<!-- End Banner Section -->
<?php
get_footer();
