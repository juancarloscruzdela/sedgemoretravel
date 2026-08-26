<style>
    .main-footer.footer_spacing {
  /*  margin-top: 0px;*/
    margin-top: var(--banner-height);
}
</style>
    
<div class="show_page_our_work show_page">

<?php  get_template_part( 'template-parts/travel/header' ); ?>

<section class="banner-section">
    <div class="main-slider-carousel our-work-slider-carousel owl-carousel owl-theme">
        <?php
        // Query Arguments
        $args = array(
            'post_type' => 'our-work',
        );

        // The query
        $the_query = new WP_Query( $args );
        
        // The Loop
        if ( $the_query->have_posts() ) {                   
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                
                $banners = get_field('banner'); 

                if ( !$banners ){
                            continue;
                        }

                
                $singleBanner = $banners[0];
                $top_title = isset($singleBanner['top_title']) ? $singleBanner['top_title'] : '';
                $title = isset($singleBanner['title']) ? $singleBanner['title'] : '';
                $content = isset($singleBanner['content']) ? $singleBanner['content'] : '';
                $button = isset($singleBanner['button']) ? $singleBanner['button'] : '';

                $banner_image = "background-image: url(". get_template_directory_uri() . "/assets/images/travel_slider1.jpg); background-size: cover !important;";
                if( $singleBanner['background_image'] ){
                    $banner_image = "background-image: url(" . $singleBanner['background_image'] . "); background-size: cover !important;";
                }                        
                ?>
                <div class="slide" style="<?php echo $banner_image; ?>">
                    <div class="auto-container">
                    <!-- Content Column -->
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

                                <?php if ($button) : ?>
                                    <div class="btnwrapper" style="position: relative;">
                                        <a href="<?php echo $button['url']; ?>" target="<?php echo $button['target']; ?>" class="enqry_btn2">
                                            <?php echo $button['title']; ?>
                                        </a>
                                        <a href="javascript:void(0);" class="enqry_btn2_overlay"> </a>
                                    </div>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div> <?php                   
            }
        } 

        wp_reset_postdata(); 
        ?>
    </div>
</section>

<?php  get_template_part( 'template-parts/full_header_nav' ); ?>

</div>
