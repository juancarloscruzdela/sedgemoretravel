<?php
$args = array(
    'post_type' => 'team',
    'posts_per_page' => -1
);

$team_query = new WP_Query($args);
$total_member = $team_query->post_count;
if ($team_query->have_posts()) {
    $count = 1;
    while ($team_query->have_posts()) {
        $team_query->the_post();
        $show_page_class = get_field('show_page_class');  ?>

        <div class="show_page <?php echo $show_page_class; ?> popup-<?php echo sanitize_title(get_the_title(get_the_ID())); ?>">
            <?php get_template_part('template-parts/about/header'); ?>
            <div class="about_baner_main">
                <div class="mangmnt_team wow fadeInDown animated">
                    <div class="mangmnt_team_text">
                        MANAGEMENT TEAM
                    </div>
                    <div class="mangmnt_team_line">
                    </div>
                </div>
                <div class="clear"></div>
                <div class="wrap_team_hedr">
                    <div class="prof-image-wrapper animate__animated animate__fadeInTopLeft" style="visibility: visible; animation-delay: 0.3s;">
                        <?php
                        $member_image =  get_field('single_image');
                        if ($member_image) { ?>
                            <img src="<?php echo $member_image; ?>" class="wrap_team_left"> <?php
                                                                                                                                                                                        } else { ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/Gaelle_big.png' ?>" class="wrap_team_left"> <?php
                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                            ?>
                    </div>

                    <div class="team_right_dm wow fadeInRight" style="visibility: visible; animation-delay: 0.3s;">
                        <div class="team_right_1">
                            <?php the_title(); ?>
                        </div>
                        <?php
                        $position = get_field('position'); ?>
                        <div class="team_right_2">
                            <?php echo isset($position) ? $position : 0; ?>
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

                        $members = get_posts($args);
                        $total_member = count($members);
                        if ($members) : ?>
                            <div class="right_img_thum " style="visibility: visible; animation-delay: 1.1s;">
                                <?php
                                $count = 1;
                                foreach ($members as $post) {
                                    setup_postdata($post);
                                    $dot_class = '';
                                    if ($count > 1 && $count <= ((int)$total_member - 1)) :
                                        $dot_class = " circl_smal_2";
                                    endif;
                                    if ($count == $total_member) {
                                        $dot_class .= " circl_smal_last";
                                    }
                                    if (has_post_thumbnail()) : ?>
                                        <a class="circl_smal hit_btn<?php echo $count;
                                                                    echo $dot_class; ?>" data-name="<?php echo sanitize_title(get_the_title(get_the_ID())) ?>" href="<?php the_permalink(); ?>">
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
            <?php get_template_part('template-parts/full_header_nav'); ?>
        </div>

    <?php
        $count++;
    }
    wp_reset_postdata();
    ?>
<?php
} ?>