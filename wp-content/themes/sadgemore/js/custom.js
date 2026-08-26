function toSentenceCase(str) {
    if (!str || str.length === 0) {
      return "Oops! Looks like you forgot to type something.";
    }
    str = str.trim();
    var firstCharacter = str[0].toUpperCase();
    var restOfCharacters = str.slice(1).toLowerCase();
    var sentenceCaseString = firstCharacter + restOfCharacters;
    return sentenceCaseString;
  }

jQuery(document).ready(function($){

    //Contact Form Validation
	if(jQuery('#contact-form').length){
		jQuery('#contact-form').validate({
			rules: {
				username: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				phone: {
					required: true
				},
				subject: {
					required: true
				},
				message: {
					required: true
				}
			},
			messages: {  
				username: 'Please complete',  
				email: 'Please complete',  
				phone: 'Please complete',  
				subject: 'Please complete', 
				message: 'Please complete', 
			}
				
		});
	}

    // Form submition 
    if(jQuery('#contact-form').length){
        jQuery( document ).on('submit', '#contact-form', function(e) { 
            e.preventDefault();       
            $('.message').text('').removeClass('success danger');
            //nonce = jQuery(this).attr("data-nonce");
            jQuery.ajax({
                url : myAjax.ajaxurl,
                type : 'post',            
                data : $('#contact-form').serialize() + "&action=contact_us_form",
                beforeSend: function() {                
                    $('.send_btn_a').text('Sending...').attr('disabled');
                },
                success : function( response ) {
                    if( response == 'success'){
                        $('.message').text('Mail sent successfully.').addClass('success');
                        $('#contact-form').trigger("reset");
                    }else{
                        $('.message').text('Sorry something went wrong. Please try again letter.').addClass('danger');
                    }
                    $('.send_btn_a').text('Send').removeAttr('disabled');
                }
            });                 
        });  
    }   

    if( jQuery('.cel_input').length ){
        jQuery(document).on('input', '.cel_input', function(e){
            $value = jQuery(this).val();           
            if( $value != '' ){
                jQuery('.cel_plac').hide();
            }else{
                jQuery('.cel_plac').show();
            }
        });
    }

    timer = 0;
    function mySearch (){ 
        var keyword = $('.search_bar_main .search_bar_input').val();
        doSearch(keyword); 
    }

    // For Desktop search
    $('.search_bar_main .search_bar_input').on('change keyup input paste', function(e){
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(mySearch, 400); 
    });

    function mobileSearch (){ 
        var keyword = $('.mobile-search-wrapper .search_bar_input').val();
        doSearch(keyword); 
    }

    // For Mobile search
    $('.mobile-search-wrapper .search_bar_input').on('change keyup input paste', function(e){
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(mobileSearch, 400); 
    });

    function doSearch( keyword ){
        if( keyword == "" ){
            jQuery('.datafetch').html( "" );
            jQuery('.mobile-search-result .result-stat').hide();
            jQuery('.mobile-search-result .result-count').text("0");
            return;
        }
        jQuery.ajax({
            url : myAjax.ajaxurl,
            type : 'post',
            data: {               
                keyword: keyword,
                action: 'data_fetch',
            },
            success : function( response ) {         
                console.log(response);      
               jQuery('.datafetch').html( response );

               $total_result = $('.mobile-search-result .datafetch ul li').length;
               jQuery('.mobile-search-result .result-count').text( $total_result );
               jQuery('.mobile-search-result .result-stat').show();
            },error: function (xhr, ajaxOptions, thrownError) {
                jQuery('.mobile-search-result .result-stat').hide();
            }
        });
    }   

    // Travel Page js
    var owl = $('.travel-carousel');
    owl.owlCarousel({
        loop:true,
        autoplay:false, 
        autoplayTimeout:3000,
        nav:true,
        margin:20,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },            
            960:{
                items:5
            },
            1200:{
                items:5
            },
            1500:{
                items:5
            }
 
        }
    });
    owl.on('mousewheel', '.owl-stage', function (e) {
        if (e.deltaY>0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
    });

    var owlcarsl_slide = $('#owlcarsl_slide');
    owlcarsl_slide.owlCarousel({
        loop:true,
        autoplay:true, 
        autoplayTimeout:3000,
        nav:true,
        margin:20,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },            
            960:{
                items:5
            },
            1200:{
                items:5
            },
            1500:{
                items:5
            }
        }
    });
    owlcarsl_slide.on('mousewheel', '.owl-stage', function (e) {
        if (e.deltaY>0) {
            owlcarsl_slide.trigger('next.owl');
        } else {
            owlcarsl_slide.trigger('prev.owl');
        }
        e.preventDefault();
    });
    //End travel Page js

   //home page banner
   if ($('.main-slider-carousel').length) {
    $('.main-slider-carousel').owlCarousel({
       animateOut: 'fadeOut',
       animateIn: 'fadeIn',
       loop:true,
       margin:0,
       nav:true,
       autoHeight: true,
       smartSpeed: 500,
       autoplay: 6000,
       navText: [ '<span class="flaticon-back-1"></span>', '<span class="flaticon-arrow-pointing-to-right"></span>' ],
       responsive:{
          0:{
             items:1
          },
          600:{
             items:1
          },
          800:{
             items:1
          },
          1024:{
             items:1
          },
          1200:{
             items:1
          }
       }
    });         
 }

    //mobile view about show hide function
    function about_mobile_view(){
        var allProfilesThumbs = $('.prof-small-image');
        var profiles = $('.profiles');
        var profileWrapper = $('.profile-wrapper');

        allProfilesThumbs.not(':first').addClass('active');

        allProfilesThumbs.on('click touchstart', function() {
            var profileId = $(this).parent().data('profile-id');
            var selectedProfile = profileWrapper.find('[data-profile-id="' + profileId + '"]');
            var selectedProfileBigImage = selectedProfile.find('.prof-big-image');
            var selectedProfileInfo = selectedProfile.find('.prof-info');

            allProfilesThumbs.not(this).addClass('active');
            $(this).removeClass('active');

            profiles.css({
                marginTop: profileId === 1 ? '0rem' : '2.5rem'
            });

            $('.prof-big-image, .prof-info').removeClass('active');
            selectedProfileBigImage.add(selectedProfileInfo).addClass('active');

            $('html, body').animate({
                scrollTop: selectedProfile.offset().top - 100
            }, 500);
        });
    }
    about_mobile_view();

    // Get querystring function
    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

 
    // About popup
    $(document).on('click','.wrap_team_persn, .right_img_thum .circl_smal',function(e){
        e.preventDefault();

        $('.show_page').removeClass('show_page_show');
        $person = $(this).data('name');
        $(".popup-"+$person).addClass("show_page_show");
        $(".main-footer").addClass("footer_spacing");
        $('.header_nav_inner .about').addClass('activ_home');
    });

    // About popup with query string
    if ($('body').hasClass('page-template-about')) {        

        let $member =  getUrlVars()["member"];
        if( $member ){

            if ($(window).width() <= 767) {       // for mobile
                               
                $('.prof-small-image').addClass('active');
                $('.prof-big-image, .prof-info').removeClass('active');       
                $selected_profile = $('.profiles' ).find('[data-query="'+$member+'"]');
                $selected_profile.find('.prof-big-image').addClass('active');
                $selected_profile.find('.prof-info').addClass('active');
                $selected_profile.find('.prof-small-image').removeClass('active');  
                
                $('html, body').animate({
                    scrollTop: $selected_profile.offset().top
                }, 500);
                
            }
            else {                              // if width is more than 600px
                $('.show_page').removeClass('show_page_show');
                $person = $member;
                $(".popup-"+$person).addClass("show_page_show");
                $(".main-footer").addClass("footer_spacing");
                $('.header_nav_inner .about').addClass('activ_home');           
            }
            
        }
    }
    


    $(document).on('click','.show_page .a_cross',function(e){
        e.preventDefault();

        $('.show_page').removeClass('show_page_show');
        $( ".main-footer" ).removeClass( "footer_spacing" );

        //For event page
        $( '.event_wrapper' ).show();

        //For travel mobile version
        $( '.mobile-wrapper' ).removeClass('d-none');
        $('.main-footer').removeAttr('style');
    });

    function open_travel_popup( $travel_type = '', $slide_count = '') {

        $( '.travel_popup_wrap .' + $travel_type ).addClass( 'show_page_show' );
        $( ".main-footer" ).addClass( "footer_spacing" );

        // Jump slider
        jQuery('.main-slider-carousel').trigger('to.owl.carousel', $slide_count);
    }

    // Travel popup
    $(document).on('click','.tab-pane .custom-carousel-item',function(e){
        e.preventDefault();
        jQuery('.main-slider-carousel ').trigger('refresh.owl.carousel');

        //slide go to
        $slide_count = $(this).data('count');
        $travel_type = $(this).data('travel-type');

        open_travel_popup( $travel_type, $slide_count );

    });

    // Travel popup with query string
    if ($('body').hasClass('page-template-travel')) {        

        let $travel_type =  getUrlVars()["travel_type"];
        let $tname       =  getUrlVars()["tname"];
        
        if( $travel_type &&  $tname ){
            $slide_count = $('.tab-content #'+ $travel_type ).find('[data-name="'+$tname+'"]').attr('data-count');
            
            open_travel_popup( $travel_type, $slide_count );
            if ($(window).width() <= 767) {       // for mobile
                $('.mobile-wrapper').addClass('d-none');
                $('.footer_spacing').css({
                    "margin-top": "750px"
                });
            }
            
        }
    }

    function open_event_popup( $slide_count = 0) {

        $( '.travel_popup_wrap .show_page_travl' ).addClass( 'show_page_show' );
        $( '.event_wrapper' ).hide();
        $( ".main-footer" ).addClass( "footer_spacing" );
        $("html, body").animate({ scrollTop: 0 }, "slow");

        // Jump slider
        jQuery('.main-slider-carousel').trigger('to.owl.carousel', $slide_count);

    }

     // Event popup
     $(document).on('click','.page-template-events .custom-carousel-item',function(e){
        e.preventDefault();        

        //slide go to
        $slide_count = $(this).data('count');        
        open_event_popup( $slide_count );
    });

    // Event popup with query string
    if ($('body').hasClass('page-template-events')) {        

        let $ename  =  getUrlVars()["ename"];      
        if(  $ename ){
            $slide_count = $('#image-track3' ).find('[data-name="'+$ename+'"]').attr('data-count');            
            open_event_popup( $slide_count );
        }
    }
    
});
