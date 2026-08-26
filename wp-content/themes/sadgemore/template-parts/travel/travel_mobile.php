<?php
    $args = array(
        'taxonomy' => 'travel-type',
        'orderby' => 'name',
        'order'   => 'DESC'
    );
    $cats = get_categories($args);
?>
<div class="mobile-wrapper">
    <?php    
    if( $cats ){ 
        $count = 1;
        foreach ( $cats as $cat ) {

            $args = array(
                'post_type' => 'travel',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'travel-type',
                        'field'    => 'term_id',
                        'terms'    => $cat->term_id,
                    ),
                ),
            );
            
            $posts = get_posts($args); ?>

            <div class="mobile-slider-wrapper">
                <div class="owl-carousel" id="travel_slider<?php echo $count++; ?>">
                    <?php
                    if ( $posts ) {
                        foreach ($posts as $post) {
                            setup_postdata($post);
                            $banners = get_field('banner'); 
                            $singleBanner = $banners[0];
                            
                            $banner_image = get_template_directory_uri() . "/assets/images/travel_slider1.jpg";
                            if( $singleBanner['background_image'] ){
                                $banner_image = $singleBanner['background_image'];
                            }   ?>
                            <div class="item">
                                <img src="<?php echo $banner_image; ?>" alt="Image 1">
                            </div>
                        <?php
                        }
                        wp_reset_postdata();
                    } 
                    ?>                    
                </div>

                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-bar-fill"></div>
                    </div>
                </div>

                <div class="carousel-info1 wow fadeInLeft animated" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                    <?php
                    $travel_name = get_field('travel_name', $cat->taxonomy . '_' . $cat->term_id); ?>
                    <div class="info-heading"> <?php echo isset($travel_name) ? $travel_name : ''; ?></div>                   
                </div>
            </div>
            <section class="about-section about_sec_as" data-test="" style="position: relative;">
                <div class="auto-container">
                    <!-- Sec Title -->
                    <div class="row clearfix">
                        <!-- Content Column -->
                        <div class="content-column col-lg-4 col-md-12 col-sm-12">
                            <div class="inner-column">
                                <?php
                                $about_travel = get_field('about_travel', $cat->taxonomy . '_' . $cat->term_id); ?>
                                <div class="text about_text1 wow fadeInLeft" style="visibility: visible; animation-delay: 0.3s;">
                                    <?php echo isset($about_travel) ? $about_travel : ''; ?>
                                </div>                               
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <div class="mobile-slider-wrapper">
                <div class="owl-carousel" id="travel_slider<?php echo $count++; ?>">
                    <?php
                    if ( $posts ) {
                        foreach ($posts as $post) {
                            setup_postdata($post);
                            $banners = get_field('banner'); 
                            $singleBanner = $banners[0];
                            $top_title = isset($singleBanner['top_title']) ? $singleBanner['top_title'] : '';
                            $title = isset($singleBanner['title']) ? $singleBanner['title'] : '';
                            $content = isset($singleBanner['content']) ? $singleBanner['content'] : '';
                            $button = isset($singleBanner['button']) ? $singleBanner['button'] : '';
                            
                            $banner_image = get_template_directory_uri() . "/assets/images/travel_slider1.jpg";
                            if( $singleBanner['background_image'] ){
                                $banner_image = $singleBanner['background_image'];
                            }   ?>
                            <div class="item">
                                <img src="<?php echo $banner_image; ?>" alt="Image travel">

                                <div class="carousel-info2 wow fadeInLeft animated" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                    <div class="info-heading-tag"><?php echo $top_title; ?></div>
                                    <div class="info-heading"><?php echo $title; ?></div>
                                    <div class="btnwrapper" style="position: relative;">
                                        <?php if ($button) : ?>
                                        <a href="<?php echo $button['url']; ?>" target="<?php echo $button['target']; ?>" class="enqry_btn">
                                            <?php echo $button['title']; ?>
                                        </a>
                                        <?php endif; ?>
                                        <a href="javascript:void(0);" class="enqry_btn_overlay"></a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        wp_reset_postdata();
                    } ?>                    
                </div>

                <div class="progress-bar">
                    <div class="progress-bar-fill"></div>
                </div>

            </div>

            <?php
        } //endforeach
        wp_reset_postdata();
    } //endif
    ?>
    
</div>