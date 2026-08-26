<?php

/**
 * The template for displaying all single posts
 * 
 * Template Name: Development Staging Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sedgemore
 */

get_header();

if ( post_password_required() ) {
    ?>
<style type="text/css">   
    form{
        padding-top:60px;
        text-align: center;
    }
    input{
        background-color:#f1eeea;
        border-radius: 4px;
    }
    input[type="submit"]{
        padding:0 7px;
    }
</style>

<?php
    // If a password is required (and not yet entered), display the password form
    echo get_the_password_form();
    get_footer('2025');
    return;
}
?>


<style type="text/css">    

    /* important styles for homepage*/

    .header_bright {
        display: none;
    }

    .header_nav_fixed {
        background: #f1eeea;
    }

    .divider_sharp_bright {
        display: none !important;
    }

    .divider_sharp_dark {
        display: inline-block !important;
    }
   
</style>
<div class="header_nav nav-menu">
    <?php get_template_part('template-parts/header_nav_inner'); ?>
    <div class="clear"></div>
</div>

<?php 

$banners = get_field('banners');
$call_to_action_buttons = get_field('call_to_action');

    
if ( $banners && isset( $banners[0] ) ):

    $single_banner = $banners[0];

    $banner_text = isset( $single_banner['text'] ) ? $single_banner['text'] : '';
    $banner_title = isset( $single_banner['title'] ) ? esc_html($single_banner['title']) : '';
    $banner_button = isset( $single_banner['button'] ) ? $single_banner['button'] : '';

    $image_url = isset($single_banner['image']) ? esc_url($single_banner['image']) : '';
    $mobile_image_url = isset($single_banner['image_mobile']) ? esc_url($single_banner['image_mobile']) : '';

?>

<section class="h-screen relative overflow-hidden js-parallax-section">

    <figure class="absolute inset-0 z--10 sedgemore-travel-section-image">
        <picture>
            <source 
            srcset="<?php echo esc_url($image_url); ?>"
            media="(min-width: 750px)"
            />
            <img src="<?php echo esc_url($mobile_image_url); ?>" class="js-parallax-scale-target object-fit-cover object-position-center w-full h-full " alt="" >
        </picture>
    </figure>

    <section class="w-full " >
        <div class="sedgemore-legacy-container">
            <div class="h-screen px-16 flex place-content-center">               
                    <div class="flex s-flex-col w-full h-full items-center text-center justify-center wow fadeInLeft" style="visibility: visible; animation-delay: 0.4s;">                                         
                        <div class="font-heading uppercase tracking-wide text-5xl md:text-6xl lg:text-8xl text-white font-bold w-3/4 lg:w-1/3 lg:w-1/4 shadow-text--light">
                            <?php echo esc_html($banner_title); ?>
                        </div>
                        <?php if ( $banner_text): ?>
                        <div class="tracking-wide text-white pt-8 lg:w-1/2 w-3/4 lg:w-3/4 xl:w-2/3 ">
                            <?php echo wp_kses_post($banner_text); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($banner_button && isset($banner_button['url']) && isset($banner_button['title'])) : ?>
                            <div class="pt-8 pb-16" >
                                <a href="<?php echo esc_url($banner_button['url']); ?>" target="<?php echo esc_attr($banner_button['target']); ?>" class="sedgemore-btn btn--light">
                                    <span class="shadow-text--light"><?php print esc_html( $banner_button['title'] ) ?></span>
                                </a>                            
                            </div>
                        <?php endif; ?>
                        <?php if ( $call_to_action_buttons ): ?>
                        <div class="pt-8 flex s-flex-col  lg:s-flex-row gap-4 lg:absolute lg:bottom-1/10" >
                            <?php foreach( $call_to_action_buttons as $cta_button){ 
                                $button = $cta_button['button'];
                                ?>

                                 <?php if ($button && isset($button['url']) && isset($button['title'])) : ?>
                               
                                    <a href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target']); ?>" class="flex-auto sedgemore-btn btn--small btn--white">
                                        <?php print esc_html( $button['title'] ) ?>
                                    </a>                            
                                
                            <?php endif; ?>

                            <?php  } ?>
                        </div>
                        <?php endif; ?>

                    </div>
                
            </div>
        </div>
    </section>
</section>


<?php 

endif;

?>

<?php 

$taxonomy_name = 'travel-type';
$term_slug = 'tailored-itineraries';
$acf_field_name = 'travel_name';

// 2. Get the specific taxonomy term object
$term = get_term_by( 'slug', $term_slug, $taxonomy_name );

// 3. Check if the term exists and is not an error    
if ( $term && ! is_wp_error( $term ) ):

    // The field is associated with the term, so we pass the term's identifier to get_field()
    // ACF uses the format 'taxonomy_name_term_id' (e.g., 'travel-type_25')
    $term_id_for_acf = $taxonomy_name . '_' . $term->term_id;

    // 4. Retrieve the ACF field value
    $travel_name = get_field( 'travel_name', $term_id_for_acf );
    $travel_about = get_field( 'about_travel', $term_id_for_acf );
    $travel_image = get_field( 'image_travel', $term_id_for_acf );

    $travel_text = isset($travel_about) ? $travel_about : '';

    $image_url = isset($travel_image) ? esc_url($travel_image) : '';
   

?>

<section id="section__tailored_itineraries"  class="bg-white sedgemore-section py-8 lg:py-16 ">
    <div class="w-full " >
        <div class="sedgemore-legacy-container">
            <div class="text-center">
                <h2 class="sedgemore-title text-2xl font-bold pt-4 animate-on-scroll delay-100"><?php echo esc_html($travel_name); ?></h2>
                <div class="sedgemore-text text-sm  animate-on-scroll delay-200 w-3/4 mx-auto" >
                    <p><?php echo wp_kses_post($travel_text); ?></p>
                </div> 
                <?php if ( false /*$banner_button && isset($banner_button['url']) && isset($banner_button['title']) */) : ?>
                    <div class="pt-8 pb-8 animate-on-scroll delay-300 " >
                        <a href="<?php echo esc_url($banner_button['url']); ?>" target="<?php echo esc_attr($banner_button['target']); ?>" class="sedgemore-btn">
                            <?php print esc_html( $banner_button['title'] ) ?>
                        </a>                            
                    </div>
                <?php endif; ?>
               
            </div>
        </div>        
    </div>
</section>

<?php 

endif;
?>

<?php 

$taxonomy_name = 'travel-type';
$term_slug = 'hotels-and-resorts';
$acf_field_name = 'travel_name';

// 2. Get the specific taxonomy term object
$term = get_term_by( 'slug', $term_slug, $taxonomy_name );

// 3. Check if the term exists and is not an error    
if ( $term && ! is_wp_error( $term ) ):

    // The field is associated with the term, so we pass the term's identifier to get_field()
    // ACF uses the format 'taxonomy_name_term_id' (e.g., 'travel-type_25')
    $term_id_for_acf = $taxonomy_name . '_' . $term->term_id;

    // 4. Retrieve the ACF field value
    $travel_name = get_field( 'travel_name', $term_id_for_acf );
    $travel_about = get_field( 'about_travel', $term_id_for_acf );
    $travel_image = get_field( 'image_travel', $term_id_for_acf );
    $travel_logos = get_field('logos_travel', $term_id_for_acf );

    $travel_text = isset($travel_about) ? $travel_about : '';

    $image_url = isset($travel_image) ? esc_url($travel_image) : '';


   

?>
<section  class="sedgemore-travel-section-image--aspect-ratio relative js-parallax-section overflow-hidden ">
    <figure class="absolute inset-0 z--10 ">
        <img src="<?php echo esc_url($image_url); ?>" class="js-parallax-scale-target w-full h-full " alt="" >
    </figure>
</section>
<section  id="section__hotels_and_resorts"   class="bg-white sedgemore-section py-8 lg:py-16 ">
    <div class="w-full " >
        <div class="sedgemore-legacy-container">
            <div class="text-center">
                <h2 class="sedgemore-title text-2xl font-bold pt-4 animate-on-scroll delay-100"><?php echo esc_html($travel_name); ?></h2>
                <div class="sedgemore-text text-sm  animate-on-scroll delay-200 w-3/4 mx-auto" >
                    <p><?php echo wp_kses_post($travel_text); ?></p>
                </div> 
                <?php if ( $travel_logos ) : ?>
                <div class="flex-wrap py-8 flex s-flex-row gap-12 self-center justify-center">
                    <?php
                    $delay = 300;
                    foreach ($travel_logos as $logo) {
                        
                        $logo_url = isset($logo['image']) ? esc_url($logo['image']) : '';
                        if ($logo_url) : ?>
                            <img src="<?php echo $logo_url; ?>" alt="<?php echo esc_attr( $logo['title'] ); ?>" class="w-24 animate-on-scroll delay-<?php echo esc_attr($delay); ?>" >                      
                        <?php   
                        endif;
                        $delay =  $delay + 100;                     
                    }             
                    ?>
                </div>
                <?php endif; ?>
                <?php if ( false /*$banner_button && isset($banner_button['url']) && isset($banner_button['title']) */ ) : ?>
                    <div class="pt-8 pb-8 animate-on-scroll delay-300 " >
                        <a href="<?php echo esc_url($banner_button['url']); ?>" target="<?php echo esc_attr($banner_button['target']); ?>" class="sedgemore-btn">
                            <?php print esc_html( $banner_button['title'] ) ?>
                        </a>                            
                    </div>
                <?php endif; ?>
               
            </div>
        </div>        
    </div>
</section>

<?php 

endif;
?>


<?php 

$taxonomy_name = 'travel-type';
$term_slug = 'private-villas';
$acf_field_name = 'travel_name';

// 2. Get the specific taxonomy term object
$term = get_term_by( 'slug', $term_slug, $taxonomy_name );

// 3. Check if the term exists and is not an error    
if ( $term && ! is_wp_error( $term ) ):

    // The field is associated with the term, so we pass the term's identifier to get_field()
    // ACF uses the format 'taxonomy_name_term_id' (e.g., 'travel-type_25')
    $term_id_for_acf = $taxonomy_name . '_' . $term->term_id;

    // 4. Retrieve the ACF field value
    $travel_name = get_field( 'travel_name', $term_id_for_acf );
    $travel_about = get_field( 'about_travel', $term_id_for_acf );
    $travel_image = get_field( 'image_travel', $term_id_for_acf );

    $travel_text = isset($travel_about) ? $travel_about : '';

    $image_url = isset($travel_image) ? esc_url($travel_image) : '';
   

?>
<section class="sedgemore-travel-section-image--aspect-ratio relative overflow-hidden js-parallax-section">
    <figure class="absolute inset-0 z--10">
        <img src="<?php echo esc_url($image_url); ?>" class="js-parallax-scale-target w-full h-full " alt="" >
    </figure>
</section>
<section id="section__private_villas"  class="bg-white sedgemore-section py-8 lg:py-16 ">
    <div class="w-full " >
        <div class="sedgemore-legacy-container">
            <div class="text-center">
                <h2 class="sedgemore-title text-2xl font-bold pt-4 animate-on-scroll delay-100"><?php echo esc_html($travel_name); ?></h2>
                <div class="sedgemore-text text-sm  animate-on-scroll delay-200 w-3/4 mx-auto" >
                    <p><?php echo wp_kses_post($travel_text); ?></p>
                </div> 
                <?php if ( false /*$banner_button && isset($banner_button['url']) && isset($banner_button['title']) */ ) : ?>
                    <div class="pt-8 pb-8 animate-on-scroll delay-300 " >
                        <a href="<?php echo esc_url($banner_button['url']); ?>" target="<?php echo esc_attr($banner_button['target']); ?>" class="sedgemore-btn">
                            <?php print esc_html( $banner_button['title'] ) ?>
                        </a>                            
                    </div>
                <?php endif; ?>
               
            </div>
        </div>        
    </div>
</section>

<?php 

endif;
?>


<?php 

$taxonomy_name = 'travel-type';
$term_slug = 'private-yacht-voyages';
$acf_field_name = 'travel_name';

// 2. Get the specific taxonomy term object
$term = get_term_by( 'slug', $term_slug, $taxonomy_name );

// 3. Check if the term exists and is not an error    
if ( $term && ! is_wp_error( $term ) ):

    // The field is associated with the term, so we pass the term's identifier to get_field()
    // ACF uses the format 'taxonomy_name_term_id' (e.g., 'travel-type_25')
    $term_id_for_acf = $taxonomy_name . '_' . $term->term_id;

    // 4. Retrieve the ACF field value
    $travel_name = get_field( 'travel_name', $term_id_for_acf );
    $travel_about = get_field( 'about_travel', $term_id_for_acf );
    $travel_image = get_field( 'image_travel', $term_id_for_acf );

    $travel_text = isset($travel_about) ? $travel_about : '';

    $image_url = isset($travel_image) ? esc_url($travel_image) : '';
   

?>
<section  class="sedgemore-travel-section-image--aspect-ratio relative overflow-hidden js-parallax-section">
    <figure class="absolute inset-0 z--10">
        <img src="<?php echo esc_url($image_url); ?>" class="js-parallax-scale-target w-full h-full " alt="" >
    </figure>
</section>
<section  id="section__private_yacht_voyages"  class="bg-white sedgemore-section py-8 lg:py-16 ">
    <div class="w-full " >
        <div class="sedgemore-legacy-container">
            <div class="text-center">
                <h2 class="sedgemore-title text-2xl font-bold pt-4 animate-on-scroll delay-100"><?php echo esc_html($travel_name); ?></h2>
                <div class="sedgemore-text text-sm  animate-on-scroll delay-200 w-3/4 mx-auto" >
                    <p><?php echo wp_kses_post($travel_text); ?></p>
                </div> 
                <?php if ( false /*$banner_button && isset($banner_button['url']) && isset($banner_button['title']) */ ) : ?>
                    <div class="pt-8 pb-8 animate-on-scroll delay-300 " >
                        <a href="<?php echo esc_url($banner_button['url']); ?>" target="<?php echo esc_attr($banner_button['target']); ?>" class="sedgemore-btn">
                            <?php print esc_html( $banner_button['title'] ) ?>
                        </a>                            
                    </div>
                <?php endif; ?>
               
            </div>
        </div>        
    </div>
</section>

<?php 

endif;
?>

<?php 
$lower_banners = get_field('lower_banners');

if ( $lower_banners && isset( $lower_banners[0] ) ):

    $single_lower_banner = $lower_banners[0];

    $banner_title = isset( $single_lower_banner['title'] ) ? esc_html($single_lower_banner['title']) : '';
    $banner_text = isset( $single_lower_banner['text'] ) ? $single_lower_banner['text'] : '';
    $banner_button = isset( $single_lower_banner['button'] ) ? $single_lower_banner['button'] : '';

?>
<section class="bg-white sedgemore-section py-8 lg:py-24 shadow-negative-lg" >
     <div class="w-full">
        <div class="sedgemore-legacy-container">
            <div class="text-center ">
                    <h2 class="sedgemore-title text-2xl font-bold pt-4 animate-on-scroll delay-100"><?php print $banner_title; ?></h2>
                    <div class="sedgemore-text text-base  animate-on-scroll delay-200 w-3/4 mx-auto" >
                        <?php echo wp_kses_post($banner_text); ?>
                    </div>                
                    <?php if ($banner_button && isset($banner_button['url']) && isset($banner_button['title'])) : ?>
                    <div class="pt-8 pb-24 animate-on-scroll delay-300 " >
                        <a href="<?php echo esc_url($banner_button['url']); ?>" target="<?php echo esc_attr($banner_button['target']); ?>" class="sedgemore-btn">
                            <?php print esc_html( $banner_button['title'] ); ?>
                        </a>                            
                    </div>
                    <?php endif; ?>
                   
            </div>
        </div>
     </div>
</section>
<?php 
endif;
?>


<section id="contact__form" class="sedgemore-section md:py-8 lg:py-24 bg-browns-100 shadow-negative-lg" >
    <div class="bg-browns-100 w-full">
        <div class="sedgemore-legacy-container">
            <div class="flex flex-wrap s-flex-row text-center">
                <div class="w-full lg:w-1/2 lg:text-left">
                    <h2 class="sedgemore-title text-2xl font-bold pt-4 animate-on-scroll delay-200 lg:pr-8">Let's Begin Your Journey</h2>
                    <div class="sedgemore-text text-sm lg:pr-8 xl:pr-16 pb-4">
                        <p>Tell us what inspires your next trip, and our team will be in touch to start curating your experience.</p>
                    </div>
                    
                </div>
                <div  class="w-full lg:w-1/2">
                    <div class="w-full lg:w-3/4 md:pl-16">

                    <form id="event__form">
                            <div class="flex gap-6">
                                <div class="basis-1/2 floating-label-group">                                    
                                    <input type="text" id="event__first_name" name="first_name" placeholder=" " required>
                                    <label for="event__first_name">First Name*</label>
                                    <div class="error-message" data-field="event__first_name"></div>
                                </div>
                                <div class="basis-1/2 floating-label-group">                                    
                                    <input type="text" id="event__last_name" name="last_name" placeholder=" " required>
                                    <label for="event__last_name">Last Name*</label>
                                    <div class="error-message" data-field="event__last_name"></div>
                                </div>
                            </div>
                            
                            <div class="basis-full floating-label-group">                                
                                <input type="email" id="event__email_address" name="email_address" placeholder=" " required>
                                <label for="event__email_address">Email Address*</label>
                                <div class="error-message" data-field="event__email_address"></div>
                            </div>
                            <div class="basis-full floating-label-group">                                
                                <input type="text" id="event__phone" name="phone" placeholder=" ">
                                <label for="event__phone">Phone</label>
                                <div class="error-message" data-field="event__phone"></div>
                            </div>

                            <div class="basis-full floating-label-group">                                
                                <textarea  id="event__message" name="message" placeholder=" " required></textarea>
                                <label for="event__message">Message</label>
                                <div class="error-message" data-field="event__message"></div>
                            </div>
                            
                            <div class="flex gap-2">
                                <div class="basis-full xl:basis-1/2">
                                    <button type="submit" id="event__submit-btn" class="sedgemore-submit w-full">Send Enquiry</button>
                                </div>
                            </div>
                            
                            
                            <p id="event__form-message" aria-live="polite"></p>
                            
                            <input type="hidden" name="action" value="event_contact_form">
                            <?php wp_nonce_field('event_contact_nonce_action', 'event_contact_nonce'); ?>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
get_footer();

?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Target the sections and the elements to be scaled
    const parallaxSections = document.querySelectorAll('.js-parallax-section');

    // Define the scaling parameters
    const MAX_SCALE = 1.2; // Maximum scale factor (e.g., 15% growth)
    const BASE_SCALE = 1.0;
    
    // The vertical distance (relative to the screen) over which the scaling animation will occur
    // We use viewport height (window.innerHeight) as a reference for a smooth animation
    const ANIMATION_DISTANCE = window.innerHeight * 1.5; 

    /**
     * Calculates the scale factor based on the element's position in the viewport.
     */
    const updateParallaxScale = () => {
        // Current scroll position of the entire window
        const scrollY = window.scrollY;
        
        // Viewport height
        const viewportHeight = window.innerHeight;

        parallaxSections.forEach(section => {
            // Get the position and size of the current section
            const rect = section.getBoundingClientRect();
            
            // Calculate the position relative to the top of the viewport
            // This is equivalent to rect.top - scrollY
            const sectionTop = scrollY + rect.top; 

            // Calculate how far the section has scrolled into the viewport, relative to the animation distance
            // 0 when the section is exactly at the bottom of the viewport (just entering)
            // Becomes positive as the section scrolls up
            const scrollIntoView = viewportHeight - rect.top;

            // Normalize the scroll distance to a ratio between 0 and 1
            // Clamping ensures the ratio doesn't go below 0 or above 1
            let ratio = Math.min(1, Math.max(0, scrollIntoView / ANIMATION_DISTANCE));

            // Map the ratio (0 to 1) to the scale range (BASE_SCALE to MAX_SCALE)
            const scale = BASE_SCALE + (ratio * (MAX_SCALE - BASE_SCALE));
            
            // 2. Apply the transformation to the target element within this section
            const scaleTarget = section.querySelector('.js-parallax-scale-target');
            if (scaleTarget) {
                scaleTarget.style.transform = `scale(${scale})`;
            }
        });
    };

    // 3. Attach the scroll event listener and run on page load
    window.addEventListener('scroll', updateParallaxScale);
    // Also listen for resize events in case the viewport height changes
    window.addEventListener('resize', updateParallaxScale); 
    
    // Run once on load to set the initial state
    updateParallaxScale();
});
</script>