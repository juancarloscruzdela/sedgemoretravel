<div class="mobile-wrapper">

    <div class="profile-wrapper">
        <?php
        $args = array(
            'post_type' => 'team',
            'numberposts' => -1
        );

        $posts = get_posts($args);
        if ( $posts ) : ?>
        <div class="profiles">
            <?php
            $count_m = 1;
            foreach ($posts as $post) {
                setup_postdata($post);

                $ac_class = "";
                if ( $count_m == 1 && ( !isset($_GET['member']) ) ) {
                    $ac_class = "active";
                }  ?>
                <div class="profile-wrapper" data-profile-id="<?php echo $count_m; ?>" data-query="<?php echo sanitize_title(get_the_title()); ?>">
                    <div class="prof-small-image">
                        <?php
                        if (has_post_thumbnail()) {
                            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');                            
                            echo '<img src="' . esc_url($featured_img_url) . '" class="profile" data-name="' . get_the_title() . '" alt="' . get_the_title() . '">';
                        }
                        ?>                        
                    </div>
                    <?php
                    $member_image =  get_field('single_image');
                    $single_image_mobile =  get_field('single_image_mobile');
                    ?>
                    <div class="prof-big-image <?php echo $ac_class; ?>" data-image-id="<?php echo $count_m; ?>">
                        <?php 
                        if( $single_image_mobile ){ ?>
                            <img src="<?php echo $single_image_mobile; ?>" class="profile" data-name="<?php the_title(); ?>"> <?php
                        }else{ ?>
                            <img src="<?php echo $member_image; ?>" class="profile" data-name="<?php the_title(); ?>"> <?php
                        }  ?>                        
                    </div>
                    <div class="prof-info <?php echo $ac_class; ?>">
                        <div class="prof-info-title"><?php the_title(); ?></div>
                        <?php $position = get_field('position'); ?>
                        <div class="prof-info-position"><?php echo isset( $position ) ? $position : ""; ?></div>
                        <div class="prof-info-description">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                <?php
                $count_m++;
            }
            wp_reset_postdata(); ?>

        </div>
        <?php
        endif;
        ?>
    </div>
    
    <?php
    $history = get_field('history');
    if ($history) : ?>
    <section>
        <div class="custom_heading_section">
            <div class="custom_heading_title wow fadeInDown" style="visibility: visible; animation-delay: 0.3s;">
                <div class="custom_heading_title_text"> About </div>
                <div class="custom_heading_title_line"></div>
            </div>
        </div>
    </section>

    <section class="about-section about_sec_as pt-2rem" data-test="" style="position: relative;">
        <div class="auto-container">
            <!-- Sec Title -->
            <div class="row clearfix">
                <!-- Content Column -->
                <div class="content-column col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="text about_text1 wow fadeInLeft" style="visibility: visible; animation-delay: 0.3s;">
                            <?php echo $history; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php
    endif; 
    
    $gallery = get_field('gallery');
    if ( !empty( $gallery ) ) {  ?> 
        <div class="mobile-wrapper">
            <div class="mobile-slider-wrapper">
                <div class="owl-carousel" id="event_mobile_slider">    
                <?php
                foreach ( $gallery['images'] as $img ) { ?>                    
                    <div class="item">
                        <img src="<?= $img['image']['url'] ?>" alt="<?= $img['image']['alt'] ?>">            
                    </div> 
                    <?php
                    }
                    ?>
                </div>
    
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-bar-fill"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
       }
    ?>
</div>

<script>
    jQuery(document).ready(function($){    

        $(function() {
            function initCarousel(carouselId, autoplayTimeout) {
                var owl = $("#" + carouselId);
                owl.owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 10,
                    nav: false,
                    autoplay: true,
                    autoplayTimeout: autoplayTimeout,
                    autoplayHoverPause: true,
                    mouseDrag: false, // Prevent dragging with mouse
                    touchDrag: false, // Prevent dragging with touch
                    onDragged: resetProgressBar,
                    onTranslated: animateProgressBar,
                    onInitialized: animateProgressBar // Make the progress bar start on page load
                });

                var slideCount = $("#" + carouselId + ' .owl-stage .owl-item:not(.cloned)').length;
                var parentSelector = owl.closest(".mobile-slider-wrapper");
                var progressBar = parentSelector.find(".progress-bar-fill");

                // console.log(progressBar);

                function resetProgressBar(event) {
                    var currentSlide = event.item.index - event.relatedTarget.clones().length / 2;
                    while (currentSlide < 0) {
                        currentSlide += event.item.count;
                    }
                    currentSlide = currentSlide % event.item.count;

                    var progress = (currentSlide / slideCount) * 100;
                    progressBar.css("width", progress + "%");
                }

                function animateProgressBar(event) {
                    var parentSelector = owl.closest(".mobile-slider-wrapper");
                    var progressBar = parentSelector.find(".progress-bar-fill");



                    var currentSlide = event.item.index - event.relatedTarget.clones().length / 2;
                    while (currentSlide < 0) {
                        currentSlide += event.item.count;
                    }
                    currentSlide = currentSlide % event.item.count;

                    var progress = (currentSlide / slideCount) * 100;
                    progressBar.css({
                        "transition": "none",
                        "width": progress + "%"
                    });

                    setTimeout(function() {
                        var progress = ((currentSlide + 1) / slideCount) * 100;
                        progressBar.css({
                            "transition": "width " + autoplayTimeout + "ms linear",
                            "width": progress + "%"
                        });
                    }, 50);
                }
            }


            initCarousel('event_mobile_slider', 8000);
        });
    });
</script>