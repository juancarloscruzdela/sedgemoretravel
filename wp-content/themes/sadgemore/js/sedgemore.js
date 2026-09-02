
/* Sedgemore animate on scroll. 
Usage:
animate-on-scroll delay-300 delay-400 etc...
*/
document.addEventListener('DOMContentLoaded', () => {

    const animatedElements = document.querySelectorAll('.animate-on-scroll');

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.2
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                
                // Get delay from class name, e.g., 'delay-0-3s' -> '0.3s'
                const delayClass = Array.from(element.classList).find(cls => cls.startsWith('delay-'));
                if (delayClass) {
                    const delay = delayClass.replace('delay-', '').replace('-', '.'); // Convert 'delay-0-3s' to '0.3s'
                    element.style.transitionDelay = delay;
                }

                element.classList.add('is-visible');
                observer.unobserve(element);
            }
        });
    }, observerOptions);

    animatedElements.forEach(element => {
        observer.observe(element);
    });    
});


document.addEventListener('DOMContentLoaded', function() {
    // 1. Select all links with hashes, excluding '#' and '#0'
    const smoothScrollLinks = document.querySelectorAll('a[href*="#"]:not([href="#"]):not([href="#0"])');
    const BOTTOM_SCROLL_SUFFIX = '___bottom';

    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            const isSamePath = location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '');
            const isSameHost = location.hostname === this.hostname;

            if (isSamePath && isSameHost) {
                // Determine if this link should trigger bottom alignment
                const scrollToBottom = this.hash.endsWith(BOTTOM_SCROLL_SUFFIX);
                
                // Get the actual ID/name of the target element, removing the suffix if present
                const targetHash = scrollToBottom 
                    ? this.hash.slice(0, -BOTTOM_SCROLL_SUFFIX.length)
                    : this.hash;

                let target = document.querySelector(targetHash);
                if (!target && targetHash.slice(1)) {
                    target = document.querySelector(`[name="${targetHash.slice(1)}"]`);
                }

                if (target) {
                    // Prevent default jump action
                    event.preventDefault();
                    
                    let adjustedPosition;
                    
                    if (scrollToBottom) {
                        // **BOTTOM ALIGNMENT CALCULATION FOR THE TRAVEL PAGE!
                       const bottom_menu = 85;
                       var targetPosition = (target.getBoundingClientRect().bottom + window.pageYOffset) - (window.innerHeight - bottom_menu);
                      
                       adjustedPosition = targetPosition ;
                        
                    } else {
                        // **DEFAULT (TOP) ALIGNMENT CALCULATION**
                        const offset = 120;
                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
                        adjustedPosition = targetPosition - offset;
                    }
                    
                    // 1. Set the element as focusable if it isn't already
                    if (!target.hasAttribute('tabindex')) {
                        target.setAttribute('tabindex', '-1');
                    }
                    
                    // 2. Perform the smooth scroll
                    window.scrollTo({
                        top: adjustedPosition,
                        behavior: 'smooth'
                    });

                    // 3. Immediately apply focus, telling the browser *not* to scroll
                    // This is the critical change to prevent the jump.
                    target.focus({ preventScroll: true }); 

                    // 4. Clean up the tabindex attribute (optional, but good practice)
                    // Wait a moment longer than the scroll animation would take (e.g., 500ms)
                    // The focus will persist even if tabindex is removed.
                    setTimeout(() => {
                        target.removeAttribute('tabindex');
                    }, 500); 
                }
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {

    // Select the element(s) with the class 'sedgemore-sliding-gallery'
    const gallery = document.querySelector(".sedgemore-sliding-gallery");

    if (gallery) {
        // Attach an event listener for the 'wheel' event
        gallery.addEventListener("wheel", function (e) {
            // The 'wheel' event uses deltaY for vertical scroll amount.
            // A negative deltaY means scrolling "up" (or forward/right in this horizontal context).
            if (e.deltaY < 0) {
                // Prevent default vertical scrolling behavior
                e.preventDefault();
                // Stop event propagation to prevent other handlers from firing
                e.stopPropagation();
                // Scroll the element's content horizontally by adding 100px
                this.scrollLeft += 100;
            } else {
                // A positive deltaY means scrolling "down" (or backward/left in this horizontal context).
                e.preventDefault();
                e.stopPropagation();
                // Scroll the element's content horizontally by subtracting 100px
                this.scrollLeft -= 100;
            }
        });
    }

});

document.addEventListener('DOMContentLoaded', function() {
// 1. Define the class you want to target
    const targetClass = 'no-click';

    // 2. Get all elements with the target class
    const elements = document.querySelectorAll(`a.${targetClass}`);

    // 3. Loop through the NodeList of elements
    elements.forEach(anchor => {
        // 4. Attach an event listener for the 'click' event to each element
        anchor.addEventListener('click', function(event) {
            // 5. Crucial step: Prevent the browser's default action (navigation)
            event.preventDefault();
        });
    });
});

/* search menu code */
document.addEventListener('DOMContentLoaded', function () {
    
    // --- Selectors (Using querySelectorAll for multiple elements) ---
    const rightSearchList = document.querySelectorAll(".clickable--search-open");
    const rightSearchCloseList = document.querySelectorAll(".clickable--search-close");
    
    // Note: These selectors are assumed to be unique elements in the original code's logic,
    // as applying 's-dwlnd' or 'header_nav_search' multiple times might break styling.
    // If these also have multiple instances, they would need iteration too.
    const dwlnd = document.querySelector(".dwlnd");
    const backgrndColorSerch = document.querySelector(".backgrnd_color_serch");
    const headerNav = document.querySelector(".header_nav");
    const searchWrapMain = document.querySelector(".search_wrap_main");
    const body = document.body;


    // ---------------------------------------------
    // 1. Logic for opening the search bar (Desktop: width > 600)
    // ---------------------------------------------
            
    // Loop through all elements with the class .right_search
    rightSearchList.forEach(rightSearch => {
        
        rightSearch.addEventListener('click', function () {
            
            // Opening actions
            if (dwlnd) {
                dwlnd.classList.add("s-dwlnd");
            }
            
           // backgrndColorSerch.classList.add("backgrnd_color_serch_show");
                
            if (headerNav) {
                headerNav.classList.add("header_nav_search");
            }
            if (searchWrapMain) {
                searchWrapMain.classList.add("search_wrap_main_show");
            }
            body.classList.add("search_bar_on");
        });
    });
   

    // ---------------------------------------------
    // 2. Logic for closing the search bar (All screen sizes)
    // ---------------------------------------------

    // Loop through all elements with the class .right_search_close
    rightSearchCloseList.forEach(rightSearchClose => {
        
        rightSearchClose.addEventListener('click', function () {
            
            // Closing actions
            if (headerNav) {
                headerNav.classList.remove("header_nav_search");
            }

            if (searchWrapMain) {
                searchWrapMain.classList.remove("search_wrap_main_show");
            }
            
            body.classList.remove("search_bar_on");
            
            // Removing associated opening classes for a clean slate
            if (dwlnd) {
                 dwlnd.classList.remove("s-dwlnd");
            }
            if (backgrndColorSerch) {
                 backgrndColorSerch.classList.remove("backgrnd_color_serch_show");
            }
        });
    });
});

/* Burger menu activation */
document.addEventListener('DOMContentLoaded', () => {
    // 1. Get references to the icon and the menu
    const burgerIconDark = document.getElementById('burger-icon-dark');
    const closeIcon = document.getElementById('close-icon');
    const burgerIconBright = document.getElementById('burger-icon-bright');
    const navMenu = document.querySelector('.nav-menu');

    if (!navMenu) {
        return;
    }

    // 2. Add an event listener to whichever burger icon this page renders
    if (burgerIconDark) {
        burgerIconDark.addEventListener('click', () => {
            navMenu.classList.toggle('open');
        });
    }

    if (burgerIconBright) {
        burgerIconBright.addEventListener('click', () => {
            navMenu.classList.toggle('open');
        });
    }

    if (closeIcon) {
        closeIcon.addEventListener('click', (e) => {
            navMenu.classList.remove('open');
        });
    }

    // Now handle the movement of the window to remove the class open 

    // 1. Define the media query you want to listen for
    const mediaQuery = window.matchMedia('(min-width: 769px)');

// 2. Get all elements with the class .nav-menu
    const navMenus = document.querySelectorAll('.nav-menu');

    // 3. Define the function that performs the action
    function handleScreenChange(e) {

        if (e.matches) {
            // This block runs when the screen is WIDER than 768px
            
            navMenus.forEach(menu => {
                // Check if the element has the 'open' class before trying to remove it
                if (menu.classList.contains('open')) {
                    menu.classList.remove('open');
                    console.log('Removed "open" class from .nav-menu due to screen size.');
                }
            });
            
        }
    }

    // 4. Attach the listener function to the media query object
    mediaQuery.addEventListener('change',handleScreenChange);

    // 5. Run the function once on page load to set the initial state
    handleScreenChange(mediaQuery);
});

/* Listen to the scroll on the header nav */
document.addEventListener('DOMContentLoaded', function() {
    // 1. Get a reference to the element you want to modify
    const headerNav = document.querySelector(".header_nav");
    const headerNew = document.querySelector(".header_new");
    
    // 2. Define the scroll threshold (10 pixels)
    const scrollThreshold = 10;
    const scrollThresholdTopHeader = 50;

    // Check if either header element exists
    if (headerNav || headerNew) {
        
        /**
         * Function to check the scroll position and apply the necessary class.
         * @param {number} scrollY - The current vertical scroll position.
         */
        function checkScrollPosition(scrollY) {

            if (headerNav && scrollY >= scrollThreshold) {
                // If scrolled down 10px or more, add the class
                headerNav.classList.add("header_nav_fixed___a");
            } else if (headerNav) {
                // If scrolled less than 10px, remove the class
                headerNav.classList.remove("header_nav_fixed___a");
            }

            if (headerNew && scrollY >= scrollThresholdTopHeader) {
                // If scrolled down 10px or more, add the class
                headerNew.classList.add("aply_black_hedr");
            } else if (headerNew) {
                // If scrolled less than 10px, remove the class
                headerNew.classList.remove("aply_black_hedr");
            }
            
        }
        
        // --- 1. Initial Check on Page Load ---
        // Run the check immediately using the current scroll position
        checkScrollPosition(window.scrollY);

        // --- 2. Event Listener for Ongoing Scrolling ---
        window.addEventListener('scroll', function() {
            // Run the check every time the user scrolls
            checkScrollPosition(window.scrollY);
        });
    }
   
});
