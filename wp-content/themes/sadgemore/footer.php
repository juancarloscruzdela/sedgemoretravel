<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sadgemore
 */


$footer_logo = get_field('footer_logo', 'option');
$information = get_field('information', 'option');
$footer_links = get_field('footer_links', 'option');
$social_media = get_field('social_media', 'option');
$footer_sentence = get_field('footer_sentence', 'option');
?>
<div class="search_wrap_main">
    <div class="backgrnd_color_serch">
        <div class="backgrnd_color_serch_iner wow fadeIn" style="visibility: visible; animation-delay: <?php echo esc_attr('0.1s'); ?>;"></div>
    </div>
    <div class="search_wrap_iner wow animate__fadeInTopRight" style="visibility: visible; animation-delay: <?php echo esc_attr('0.01s'); ?>;">
        <div class="search_bar_main">
            <input type="text" placeholder="Search" class="search_bar_input">
            <div id="datafetch" class="datafetch">
                </div>
        </div>

    </div>
</div>

<footer class=" flex s-flex-col">
    <div class="sedgemore-footer w-full bg-browns-100">
        <div class="sedgemore-legacy-container sedgemore-section">

            <div class="flex s-flex-col md:s-flex-row">
                <div class="w-full md:w-1/2">
                    <div>
                        <h2 class="sedgemore-title font-bold mb-2">Stay Inspired Between Journeys</h2>
                    </div>
                    <div class="sedgemore-text max-w-128 pr-8">
                        <p class="mt-0 pb-2">
                            <?php 
                            // Assuming 'contact_info' might contain basic HTML (like <br> or <strong>), use wp_kses_post.
                            //$contact_info = isset($information['contact_info']) ? $information['contact_info'] : '';
                            //echo wp_kses_post($contact_info); 
                            ?>
                            Thoughtfully curated travel insights, destination
highlights, and moments of inspiration.
                        </p>
                    </div>
                    <div class=" max-w-128 pr-8">
                       <form id="newsletter-form">
                            <div class="flex gap-6">
                                <div class="basis-1/2 floating-label-group">                                    
                                    <input type="text" id="first_name" name="first_name" placeholder=" " required>
                                    <label for="first_name">First Name*</label>
                                    <div class="error-message" data-field="first_name"></div>
                                </div>
                                <div class="basis-1/2 floating-label-group">                                    
                                    <input type="text" id="last_name" name="last_name" placeholder=" " required>
                                    <label for="last_name">Last Name*</label>
                                    <div class="error-message" data-field="last_name"></div>
                                </div>
                            </div>
                            
                            <div class="basis-full floating-label-group">                                
                                <input type="email" id="email_address" name="email_address" placeholder=" " required>
                                <label for="email_address">Email Address*</label>
                                <div class="error-message" data-field="email_address"></div>
                            </div>
                            <p class="text-xs">By subscribing, you agree to receive curated updates from
Sedgemore Travel, as outlined in our Privacy Policy and Terms of Use.</p>
                            <div class="flex gap-2">
                                <div class="basis-1/2">
                                    <button type="submit" id="submit-btn" class="sedgemore-submit w-full">Subscribe</button>
                                </div>
                            </div>
                            
                            <p id="form-message" aria-live="polite"></p>
                            
                            <input type="hidden" name="action" value="newsletter_subscribe">
                            <?php wp_nonce_field('newsletter_nonce_action', 'newsletter_nonce'); ?>
                        </form>
                    </div>
                    <div class="flex s-flex-row gap-2 mb-4">
                        <?php          
                        if (!empty($social_media)) { ?>
                            <?php
                                $delay = 0.6;
                                foreach ($social_media as $link) { 
                                    $link_url = isset($link['url']) ? esc_url($link['url']) : '#';
                                    $icon_url = isset($link['icon']) ? esc_url($link['icon']) : '';
                                    ?>
                                    <a href="<?php echo $link_url; ?>" target="<?php echo esc_attr('_blank'); ?>" class="w-8 h-8">
                                        <img src="<?php echo $icon_url; ?>" alt="<?php echo esc_attr('Social Media Icon'); ?>">
                                    </a>
                                <?php
                                    $delay += 0.3;
                                }
                                ?>
                            
                        <?php
                        } ?>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class=" grid md:grid-cols-3 gap-6">
                    <?php
                        if (!empty($footer_links)) {
                            
                        if (isset($footer_links['column_1']) && is_array($footer_links['column_1'])) { ?>
                            <div>
                                <h4 class="sedgemore-title font-bold mb-2">Sedgemore</h4>
                                <ul class="sedgemore-list">
                                <?php
                                foreach ($footer_links['column_1'] as $link_group) {
                                    if ( is_array( $link_group['link'] ) && !empty( $link_group['link'] ) ){
                                        $url = isset($link_group['link']['url']) ? esc_url($link_group['link']['url']) : '#';
                                        $target = isset($link_group['link']['target']) ? esc_attr($link_group['link']['target']) : '_self';
                                        $title = isset($link_group['link']['title']) ? esc_html($link_group['link']['title']) : 'Link';

                                        // All output is now safely escaped
                                        echo '<li><a href="' . $url . '" target="' . $target . '"> ' . $title . '</a></li>';
                                    }
                                }
                                ?>
                                </ul>
                            </div>
                            <?php
                        }

                        if (isset($footer_links['column_2']) && is_array($footer_links['column_2'])) { ?>
                                <div>
                                    <h4 class="sedgemore-title font-bold mb-2">Travel & Services</h4>
                                    <ul class="sedgemore-list">
                                    <?php
                                    foreach ($footer_links['column_2'] as $link_group) {
                                        if ( is_array( $link_group['link'] ) && !empty( $link_group['link'] ) ){
                                            $url = isset($link_group['link']['url']) ? esc_url($link_group['link']['url']) : '#';
                                            $target = isset($link_group['link']['target']) ? esc_attr($link_group['link']['target']) : '_self';
                                            $title = isset($link_group['link']['title']) ? esc_html($link_group['link']['title']) : 'Link';
                                            
                                            // All output is now safely escaped
                                            echo '<li><a href="' . $url . '" target="' . $target . '"> ' . $title . '</a></li>';
                                        }
                                    }
                                    ?>
                                    </ul> </div>
                        <?php
                            }
                       
                        if ( true ) { ?>
                            <div>
                                <h4 class="sedgemore-title font-bold mb-2">Legal</h4>
                                <ul class="sedgemore-list">
                                    <li><a href="/agreement">Agreement</a></li>
                                    <li><a href="/agreement#terms">Terms of Use</a></li>
                                </ul>
                            </div>
                        <?php
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
                
            
            <div class=" w-full py-8 text-center sedgemore-text">
                <p class="mb-1">© <?php echo esc_html(isset($information['title']) ? $information['title'] : 'Sedgemore'); ?> <?php echo esc_html(date('Y')); ?> All rights reserved.</p>
                <p class="mt-1"><?php echo wp_kses_post(isset($information['address']) ? $information['address'] : ''); ?></p>
            </div>

        </div> </div>
   <!-- <div class="w-full bg-blacks-600">
        <div class="sedgemore-legacy-container text-center min-h-32 py-8">

        <?php
                if ($footer_logo) :
                    // wp_get_attachment_image safely handles output, including alt text.
                    echo wp_get_attachment_image($footer_logo, 'full', "", array("class" => "max-w-64", "style" => "margin:0 auto"));
                else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo_dark.png'); ?>" class="" alt="<?php echo esc_attr('Sedgemore Logo'); ?>">
                <?php
                endif; ?>
        </div>
    </div>
            -->
    <div class="w-full bg-white md:pb-24">
        <div class="sedgemore-section">
            <div class="sedgemore-legacy-container py-16 relative">

                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo_dark.png'); ?>" class="logo_dark " alt="<?php echo esc_attr('Sedgemore Logo'); ?>">
                <div class="footer_down_right">
                    <div class="footer_down_right_text">
                        <?php echo isset($footer_sentence) ? $footer_sentence : '';   ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!--End pagewrapper-->

<!-- Search Popup -->
<div class="search-popup">
    <button class="close-search style-two"><span class="flaticon-multiply"></span></button>
    <button class="close-search"><span class="flaticon-up-arrow-1"></span></button>
    <form method="post" action="#">
        <div class="form-group">
            <input type="search" name="search-field" value="" placeholder="Search Here" required="">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>
<!-- End Header Search -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>