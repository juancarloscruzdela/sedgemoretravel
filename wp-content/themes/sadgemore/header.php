<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sadgemore
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class('hidden-bar-wrapper'); ?>>
<!-- Preloader -->
<div class="preloader">
    <div class="loading_circl_outer">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/flower.png' ?>" class="loading_circl" >
    </div>
</div>
<?php wp_body_open(); ?>
<div class="page-wrapper">
<!-- SEDGEMORE_HEADER_VERSION: A -->
   
   <!-- Main Header-->
   <!-- End Main Header -->
   <?php
      $header_logo = get_field( 'header_logo', 'option' );
      $dark_logo = get_field( 'dark_logo', 'option' );
   ?>
   <?php
      // Force the dark header (black logo + search) on specific page templates
      $force_black_header = false;
      if ( function_exists('is_page_template') && (
            is_page_template('page-templates/concierge.php') ||
            is_page_template('page-templates/our-work.php') ||
            is_page_template('page-templates/contact_us.php') ||
            is_page_template('page-templates/blog-editorial.php') ||
            is_page_template('page-templates/collective.php') ||
            is_page_template('page-templates/agreement.php')
         ) ) {
         $force_black_header = true;
      }

      if ( function_exists( 'get_page_template_slug' ) && 'page-templates/blog-editorial.php' === get_page_template_slug( get_queried_object_id() ) ) {
         $force_black_header = true;
      }

      // Also allow matching by page slug in case the template check doesn't trigger
      if ( function_exists('is_page') && is_page( array( 'concierge', 'our-work', 'contact', 'agreement' ) ) ) {
         $force_black_header = true;
      }

      if ( function_exists('is_singular') && is_singular( 'our-work' ) ) {
         $force_black_header = true;
      }
   ?>
   <?php if ( $force_black_header ) : // inline override to ensure dark header on initial load ?>
      <style>
         .header_new.force-black-header .header_bright { display: none !important; }
         .header_new.force-black-header .header_dark  { display: block !important; }
         .header_new.force-black-header .logo_a::before {
            background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo_dark.png' ); ?>') !important;
         }
         .header_new.force-black-header .clickable--search-open::before {
            background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/search_black.png' ); ?>') !important;
         }
         .header_new.force-black-header .burger-icon,
         .header_new.force-black-header .burger-icon svg {
            color: #2A2A27 !important;
         }
         .header_new.force-black-header { position: fixed; width:100%; top:0; left:0; z-index:999; }
         /* keep transparent on initial load, but allow the scroll class to set a solid background */
         .header_new.force-black-header:not(.aply_black_hedr) { background-color: transparent !important; }
      </style>
   <?php endif; ?>
   <section class="header_new<?php echo $force_black_header ? ' aply_black_hedr force-black-header' : ''; ?>" >
      <div class="auto-container">
         <?php if ( ! $force_black_header ) : ?>
         <div class="header_bright" >
            <div class="float-left mt-[24px] ">
               <div class="flex s-flex-row items-center">
                  <div id="burger-icon-bright" class="burger-icon cursor-pointer text-white mr-1">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24" fill="currentColor" class="block w-6 h-6" >
                     <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Zm0 5.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                     </svg>
                  </div>    
                  <a href="<?php echo home_url(); ?>" class="logo_a wow fadeIn" style="visibility: visible; animation-delay: 0.0s;" >
                     <?php if( $header_logo ):
                           echo wp_get_attachment_image( $header_logo, 'full', "", "" ); 
                        else: ?>
                           <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" alt ="sedgemore">
                        <?php
                     endif; ?>  
                  </a>
               </div>
            </div>
            <div class="clickable--search-open float-right mt-[26px] md:mt-[21px] cursor-pointer "  >
               <img src="<?php echo get_template_directory_uri() . '/assets/images/search_icon.png' ?>" class="w-4 h-4 md:w-6 md:h-6 block" >
            </div>
            <div class="clickable--search-close hidden float-right mt-[26px] md:mt-[21px] cursor-pointer "  >
               <img src="<?php echo get_template_directory_uri() . '/assets/images/cross.png' ?>" class="w-4 h-4 md:w-6 md:h-6" >
            </div>
            <div class="clear"></div>
         </div>
         <?php endif; ?>
         <div class="header_dark" >
            <div class="float-left mt-[24px] ">
               <div class="flex s-flex-row items-center">
                  <div id="burger-icon-dark" class="burger-icon cursor-pointer text-blacks-700  mr-1">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24" fill="currentColor" class="block w-6 h-6" >
                     <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Zm0 5.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                     </svg>
                  </div>     
                  <a href="<?php echo home_url(); ?>" class="logo_a wow fadeIn" style="visibility: visible; animation-delay: 0.0s;" > 
                     
                     <?php if( $dark_logo ):
                           echo wp_get_attachment_image( $dark_logo, 'full', "", ['class'=>'dark_ver_2'] ); 
                        else: ?>
                           <img src="<?php echo get_template_directory_uri() . '/assets/images/logo_dark.png' ?>" class="dark_ver_2" >
                        <?php
                     endif; ?> 
                     
                     
                     <?php if( $header_logo ):
                           echo wp_get_attachment_image( $header_logo, 'full', "", ['class'=>'dark_ver_1_2'] ); 
                        else: ?>
                           <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" class="dark_ver_1_2" >
                        <?php
                     endif; ?> 
                  </a>
               </div>
            </div>
            <div class="clickable--search-open float-right mt-[26px] md:mt-[21px] cursor-pointer " >
               <img src="<?php echo get_template_directory_uri() . '/assets/images/search_black.png' ?>" class="w-4 h-4 md:w-6 md:h-6 block" >
            </div>
            <div class="clickable--search-close hidden float-right mt-[26px] md:mt-[21px] cursor-pointer  " >
               <img src="<?php echo get_template_directory_uri() . '/assets/images/cross.png' ?>" class="w-4 h-4 md:w-6 md:h-6 " >
            </div>
            <div class="clear"></div>
         </div>
      </div>
   </section>
