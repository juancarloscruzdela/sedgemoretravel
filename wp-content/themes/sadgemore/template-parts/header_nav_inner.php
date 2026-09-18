<?php
$left_menu = get_field( 'left_menu', 'option' );
$right_menu = get_field( 'right_menu', 'option' );
?>
   <div id="close-icon" class="close-icon cursor-pointer mt-[24px] text-blacks-700">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="block w-6 h-6" >
            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
        </svg> 
    </div>   

<div class="header_nav_inner flex md:justify-center md:items-start" > 
    
    <div class="nav-top">
    <img src="<?php echo get_template_directory_uri() . '/assets/images/Union_1.png' ?>" class="divider_sharp divider_sharp_dark">
    <img src="<?php echo get_template_directory_uri() . '/assets/images/Union_1_bright.png' ?>" class="divider_sharp divider_sharp_bright" >

    <img src="<?php echo get_template_directory_uri() . '/assets/images/flower.png' ?>" class="flower-image " >

    <div class="clear"></div>
    </div>
    <div class="flex s-flex-col w-full md:s-flex-row text-left pt-16 md:pt-8 sedgemore-burger-menu-padding md:justify-center md:items-center"> <!-- custom-nav-container -->

        <?php
        if( !empty( $left_menu ) ){
            $deley = 0.1;
            $left_menu_size = sizeof($left_menu['menus']);
            $left_menu_count = 1;
            foreach ( $left_menu['menus'] as $menu ){
                            
            if( '0' == $menu['page_type'] ){
                if( $menu['select_page'] == get_the_ID() ){
                    $active_class = 'active';
                }else{
                    $active_class = '';
                }
                $page = '';
                if( '65' == $menu['select_page'] ){
                    $page = 'about';
                }?>
                <a href="<?php echo get_the_permalink( $menu['select_page'] ); ?>" class="md:px-4 uppercase tracking-adjusted inline-block wow fadeInLeft <?php print $active_class ? "$active_class $page text-blacks-700" : 'text-blacks-500'; ?> <?php print ($left_menu_count === 1 ? ' md:ml-16 ' : '');?>" style="visibility: visible; animation-delay: <?php echo $deley; ?>s;" ><?php echo get_the_title($menu['select_page']); ?></a> <?php
            }
            elseif( '1' == $menu['page_type'] ){ ?>
                <a href="<?php echo $menu['menu']['url']; ?>" target="<?php echo $menu['menu']['target']; ?>" class="md:px-4 uppercase tracking-adjusted text-blacks-500 inline-block  wow fadeInLeft <?php print ($left_menu_count === 1 ? ' md:ml-16 ' : '');?>" style="visibility: visible; animation-delay: <?php echo $deley; ?>s;" ><?php echo $menu['menu']['title']; ?></a><?php
            }
            if( $deley > 0){
                $deley = $deley - 0.3;
            }
                $left_menu_count++;
            }
        }
        ?>
        <div class="hidden md:block w-24"></div>
        <?php
        if( !empty( $right_menu ) ){
            $deley = 0.3;
            $right_menu_count = 1;
            foreach ( $right_menu['menus'] as $menu ){            
            if( '0' == $menu['page_type'] ){

                if( $menu['select_page'] == get_the_ID() ){
                    $active_class = 'active';
                }else{
                    $active_class = '';
                } 
                // 03-12-2025
                // Temporary whilst no Membership page.
                $page_name = get_the_title($menu['select_page']);
                /*if ( $right_menu_count === 2 && $page_name == 'Contact' ){
                    $page_name = 'Membership';
                }*/
                
                ?>

                <a href="<?php echo get_the_permalink( $menu['select_page'] ); ?>" class="md:px-4 uppercase tracking-adjusted inline-block wow fadeInLeft <?php print $active_class ? "$active_class text-blacks-700" : 'text-blacks-500'; ?> <?php print ($right_menu_count === 1 ? ' ' : '');?>" style="visibility: visible; animation-delay: <?php echo $deley; ?>s;" ><?php echo $page_name ?></a> <?php
            }
            elseif( '1' == $menu['page_type'] ){ ?>
                <a href="<?php echo $menu['menu']['url']; ?>" target="<?php echo $menu['menu']['target']; ?>" class="md:px-4 uppercase tracking-adjusted text-blacks-500 inline-block wow fadeInLeft" style="visibility: visible; animation-delay: <?php echo $deley; ?>s;" ><?php echo $menu['menu']['title']; ?></a><?php
            }
            if( $deley > 0 ){
                $deley = $deley + 0.3;
            }
             $right_menu_count++;
            }
            
	        }
	        ?>
	        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="mobile-nav-only uppercase tracking-adjusted text-blacks-500 wow fadeInLeft" style="visibility: visible; animation-delay: 0.9s;">Contact Us</a>

	    </div>

</div>
