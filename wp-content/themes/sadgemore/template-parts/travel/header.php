<?php 
   $header_logo = get_field( 'header_logo', 'option' );
   $dark_logo = get_field( 'dark_logo', 'option' );
?>
<section class="header_new" >
    <div class="auto-container">
        <div class="header_bright" >
        <a href="<?php echo home_url(); ?>" class="logo_a wow fadeInLeft" style="visibility: visible; animation-delay: 0.3s;" >
            <?php if( $header_logo ):
                echo wp_get_attachment_image( $header_logo, 'full', "", "" ); 
            else: ?>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" alt ="sedgemore">
            <?php
        endif; ?>
        </a>
        <div class="right_search wow fadeIn" style="visibility: visible; animation-delay: 0.0s;" >
            <!-- <i class="fa fa-search" aria-hidden="true"></i> -->
            <img src="<?php echo get_template_directory_uri() . '/assets/images/search_icon.png' ?>" class="search_img" >
        </div>
        <div class="clear"></div>
        </div>
        <div class="header_dark" >
        <a href="<?php echo home_url(); ?>" class="logo_a wow fadeIn" style="visibility: visible; animation-delay: 0.0s;" >
        <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" class="dark_ver_1_2" style="display: inline-block;" >
        </a>
        <div class="right_search wow fadeIn" style="visibility: visible; animation-delay: 0.0s;" >
            <!-- <i class="fa fa-search" aria-hidden="true"></i> -->
            <img src="<?php echo get_template_directory_uri() . '/assets/images/search_icon.png' ?>" class="search_img" >
        </div>
        <div class="clear"></div>
        </div>
    </div>
</section>