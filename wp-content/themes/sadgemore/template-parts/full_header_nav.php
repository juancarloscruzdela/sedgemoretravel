<div class="header_nav">
    <div class="a_cross" >
      <a href="#" class="a_cross_ancr">
      <?php
      $cross_img = 'cross.png';
      if( is_page( 'Travel' ) || is_page( 'event' ) ){
        $cross_img = 'cross_white.png';
      }
      ?>
      <img src="<?php echo get_template_directory_uri() . '/assets/images/'.$cross_img ?>" class="" >
      </a>
    </div>
      <div class="clear"></div>
         <?php  get_template_part( 'template-parts/header_nav_inner' ); ?>
      <div class="clear"></div>
</div>