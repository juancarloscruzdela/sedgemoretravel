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

<div class="about_baner_main">
   <div class="mangmnt_team">
      <div class="mangmnt_team_text">
         MANAGEMENT TEAM
      </div>
      <div class="mangmnt_team_line">
      </div>
   </div>
   <div class="clear"></div>
   <div class="wrap_team_hedr">
        <?php
            $member_image =  get_field('single_image');

            if( $member_image ){ ?>
                <img src="<?php echo $member_image; ?>" class="wrap_team_left animate__animated animate__fadeInTopLeft" style="visibility: visible; animation-delay: 0.3s;"  > <?php
            }else{ ?>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/Gaelle_big.png' ?>" class="wrap_team_left animate__animated animate__fadeInTopLeft" style="visibility: visible; animation-delay: 0.3s;" > <?php
            }           
        ?>
        
      <div class="team_right_dm wow fadeInRight" style="visibility: visible; animation-delay: 0.3s;">
        <div class="team_right_1">
        <?php the_title(); ?>
        </div>
        <?php
        $position = get_field('position'); ?>    
        <div class="team_right_2" >
            <?php echo isset( $position ) ? $position : 0; ?>
        </div>
        
        <div class="team_right_3">
        <?php the_content(); ?>
        </div>

         <?php
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'team',
            'exclude'     => array(get_the_ID()),
        );

        $members = get_posts( $args );           
        $total_member = count( $members);
        if( $members ): ?>         
         <div class="right_img_thum">
            <?php
            $count = 1;
            foreach( $members as $post){
                setup_postdata( $post );
                $dot_class = '';                
                if( $count > 1 && $count <= ( (int)$total_member - 1 ) ):
                    $dot_class = "circl_smal_2";
                endif;
                if( $count == $total_member){
                    $dot_class .= " circl_smal_last";
                }
                if ( has_post_thumbnail() ): ?>
                    <a class="circl_smal <?php echo $dot_class; ?>" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(); ?>
                    </a> <?php
                endif;
                $count++;
            }
            ?>
         </div>
         <?php 
        endif; ?>
         <div class="clear"></div>
      </div>
      <div class="clear"></div>
   </div>
</div>
<div class="header_nav">
   <div class="a_cross" >
      <a href="<?php echo get_the_permalink('65'); ?>" class="a_cross_ancr">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/cross.png' ?>" class="" >
      </a>
   </div>
   <div class="clear"></div>

   <?php  get_template_part( 'template-parts/header_nav_inner' ); ?>
   
   <div class="clear"></div>
</div>
<!-- End Banner Section -->

<style type="text/css">
   /* .active_hom{
    background: #f64a3e;
    color: #fff;
   } */
   .about_baner_main{
        min-height: unset;
   }
   .dark_ver_1_2{
        display: inline-block;
   }
   .dark_ver_2{
    display: none;
   }

   .header_new {
        width: 100%;
        margin-left: 0%;
        padding: 0px 0px;
    }

</style>
<?php
get_footer();
