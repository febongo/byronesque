(function ($) {

    $.fn.isInViewport = function() {
        var elementTop = $(this).offset() ? $(this).offset().top : 0;
        var elementBottom = elementTop + $(this).outerHeight();
    
        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        console.log(elementTop, elementBottom)
    
        return elementBottom > viewportTop && elementTop < viewportBottom;
    };
    
    $(document).on("ready", function(){

        // init Isotope
        var qsRegex;
        var $grid;

        // NAVIGATION FUNCTIONS
        $("#qodef-page-header").append("<div id='menu-overlay' class='overlay'></div><div id='byro-side-content'></div>")
        $.ajax({
            url:opt.ajaxUrl,
            type: 'get',
            data: { action:  'get_customer_addresses', type: 'shipping' },
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            success: function(data) {
                
                console.log(data);
            }
        });

        // fetch cart contents 
        $.ajax({
            url:opt.ajaxUrl,
            type: 'get',
            data: { action:  'get_cart' },
            success: function(data) {
                
                $("#get_cart").html(data)
            }
        });
        // fetch Accounts
        $.ajax({
            url:opt.ajaxUrl,
            type: 'get',
            data: { action:  'get_account' },
            success: function(data) {
                $("#get_account").html(data)
                
                // change placeholder in login form
                $('#loginform input[type="text"]').attr('placeholder', 'Email address*');
            	$('#loginform input[type="password"]').attr('placeholder', 'Password*');
            	
            	$('#loginform label[for="user_login"]').contents().filter(function() {
            		return this.nodeType === 3;
            	}).remove();
            	$('#loginform label[for="user_pass"]').contents().filter(function() {
            		return this.nodeType === 3;
            	}).remove();
            	
                // remove social login inline styles
                $("#loginform .mo-openid-app-icons a").removeAttr("style");
            }
        });

        // fetch Currency
        $.ajax({
            url:opt.ajaxUrl,
            type: 'get',
            data: { action:  'get_currency' },
            success: function(data) {
                $("#get_currency").html(data)
            }
        });
        
        
        hideSideNav();

        $(".menu-nav-side").mouseenter(function(){
            if (!$(this).hasClass('show-side-menu')) {
                let hoverImg = $(this).attr('data-img-hover')
                if(hoverImg)
                $(this).css('background-image', 'url('+hoverImg+')')
            }
        })
        
        $(".menu-nav-side").mouseout(function(){
            let defaultimg = ''
            if (!$(this).hasClass('show-side-menu')) {
                defaultimg = $(this).attr('data-img')
            } else {
                defaultimg = $(this).attr('data-img-close') ? $(this).attr('data-img-close') : $(this).attr('data-img-hover')
            }
            if(defaultimg)
            $(this).css('background-image', 'url('+defaultimg+')')
        })

        $(".menu-nav-no-side").mouseenter(function(){
            let hoverImg = $(this).attr('data-img-hover')
            
            if(hoverImg)
            $(this).css('background-image', 'url('+hoverImg+')')
        })
        
        $(".menu-nav-no-side").mouseout(function(){
            let defaultimg = ''
            if (!$(this).hasClass('show-side-menu')) {
                defaultimg = $(this).attr('data-img')
            } else {
                defaultimg = $(this).attr('data-img-hover')
            }
            
            if(defaultimg)
            $(this).css('background-image', 'url('+defaultimg+')')
        })
        
        $(".menu-nav-side").click(function(){
            if (!$(this).hasClass('show-side-menu')) {

                var dataAction = $(this).attr('data-action')
                if(dataAction) {
                    hideSideNav()
                    $("#byro-side-content").html("Loading...")
                    // create ajax call to get contents
                    let htmlContent = $("#"+dataAction).html()

                    $("#byro-side-content").html(htmlContent)

                    $grid = $('#byro-side-content .grid').isotope({
                        itemSelector: '.element-item',
                        category: '[data-category]',
                        layoutMode: 'vertical',
                            filter: function() {
                                return qsRegex ? $(this).text().match( qsRegex ) : true;
                            }
                    });
                    
                    showSideNav(this)
                }
                

                
            } else {
                hideSideNav()
            }
        })
        
        $("#menu-overlay").click(function(){
            hideSideNav()
        })

        
        

        // use value of search field to filter
        $(document).on("keyup",".country-search",debounce( function() {
            console.log($(this).val());
            qsRegex = new RegExp( $(this).val(), 'gi' );
            $grid.isotope();
        }, 200 ) )

        // debounce so filtering doesn't happen every millisecond
        function debounce( fn, threshold ) {
        var timeout;
        threshold = threshold || 100;
        return function debounced() {
            clearTimeout( timeout );
            var args = arguments;
            var _this = this;
            function delayed() {
            fn.apply( _this, args );
            }
            timeout = setTimeout( delayed, threshold );
        };
        }

        $(document).on("click","#byronesque-side-nav .open-news-form",function() {
            $(".newsletter-form").addClass("show-form")

            $(".byro-side-nav").css("display","none")
        })

        // CHECK IF SCROLL, IF IT'S TO LOW AND SIDE MENU IS STILL ON, HIDE IT!
        $( window ).scroll(function() {
            var offset = $(window).scrollTop();
            if (offset > 700)
                hideSideNav();

            // ADD PRODUCT EVENT ON SCROLL TO RETAIN DESCRIPTION VISIBLE
            // if (offset > 300) {
            //     console.log(offset)
            // }
            if( $('.qodef-woo-single-inner').isInViewport() && 
                !( ($('.upsells').length &&  $('.upsells').isInViewport()) || $('#qodef-page-footer').isInViewport()) 
            ) {
                $(".summary.entry-summary").css("top",offset)
            }
            // console.log(productOffset)
        });

        // EVENT REMOVE TO CART 
        // REMOVE ITEM AND UPDATE NUMBER OF CART ITEMS
        $(".remove_from_cart_button").on("click", function(){

            $(this).remove();

            // UPDATE CART ITEMS 
            $.ajax({
                url:opt.ajaxUrl,
                type: 'post',
                data: { action: 'bro_get_cart_count' },
                success: function(data) {
                    
                    console.log(data)
                    // if (data) {
                    //     $("#byro-search-result").html(data)
                    // } else {
                    //     $("#byro-search-result").html("<p>Sorry, no search term found!</p>")
                    // }
                }
            });

        })
        
        if ($(".woocommerce-notices-wrapper").length)
        setTimeout(function(){
            $(".woocommerce-notices-wrapper").hide('slow')
        },1000)
            
        $(".filter-container .browseBy").click(function(){
            if (!$(this).parent().hasClass('opened')) {
                $(this).parent().addClass('opened')
            } else {
                $(this).parent().removeClass('opened')
            }
        })

        $(".filter-container .close-filter").click(function(){
            $('.filter-container .browseBy').trigger("click")
        })


        // filter query 
        $("#filter-products").click(function(e){
            var urlQuery = []
            var designers = []
            var category = []
            var viewAll = false;
            var origLink = e.originalEvent.currentTarget.href

            $('input[name=designers]:checked').each(function() {
                designers.push(this.value)
            });

            $('input[name=category]:checked').each(function() {
                if (this.value !== 'shop'){
                    category.push(this.value)
                } else {
                    viewAll = true;
                }
            });

            if (designers.length > 0) urlQuery.push('designers='+designers.join(';'))

            if (category.length > 0) urlQuery.push('category='+category.join(';'))

            if (viewAll) {
                e.originalEvent.currentTarget.href = origLink;
            } else {
                e.originalEvent.currentTarget.href = origLink + "?" + urlQuery.join('&');
            }

        })

        $('input[name=category]').change(function(e){


            if ( this.value === 'shop') {
                $(".chk-container input:checkbox").prop('checked', $(this).prop("checked"));
            }
        })

        // HEADER TOP AREA CLOSE
        $("#close-top-head").click(function(){
            $("#qodef-top-area").hide('slow')
        });

        // FIX ON LANDING PAGE 
        // ADD IMAGE INFO
        if ( $(".home-interactive-links .qodef-m-images .qodef-e-image img").length ) {
            var images = $(".home-interactive-links .qodef-m-images .qodef-e-image")

            images.each(function(ndx){
                // console.log($(this).find('img').attr('src'))
                var this_ = $(this)
                $.ajax({
                    url:opt.ajaxUrl,
                    type: 'post',
                    data: { action: 'get_image_meta', imgurl: $(this).find('img').attr('src') },
                    success: function(data) {
                        if (data) {
                            this_.append(data);
                        }
                        // console.log(data)
                        
                    }
                });
            })
        }


        // NEWSLETTER POPUP
        $(".newsletter-marquee").click(function(){
            console.log("click");
            $("html, body").animate({ scrollTop: 0 }, "slow");

            // trigger click 
            setTimeout(function(){
                $("#bn-menu-ico .menu-nav-side").trigger("click")
            }, 300);

            setTimeout(function(){
                $(".open-news-form").trigger("click")
            }, 500);
            

        });

        // SLIDER ARROW HIDE
        $("rs-module").change(function(){
            console.log('slider changed');
        });
        
        
        
    }) // DOCUMENT READY -- END
    
    $(document).on("click","#bn-shopby .menu-nav",function() {

        
        console.log('click',$(this));
        if (!$("#bn-shopby .menu-nav").hasClass('show-side-menu')) {
            hideSideNav()
            $(".bn-shop-container").addClass('bn-show')
            $(this).addClass('show-side-menu')
        } else {
            hideSideNav()
            console.log('else');
        }
        
    });

    $(document).on("click","#bn-search .menu-nav",function() {
        hideSideNav()
        $(".bn-search-form").addClass('bn-show')
    });

    $(document).on("click","#bn-search-close",function() {

        $(".bn-search-form").removeClass('bn-show')
    });

    $(document).on("keyup","#bn-search-value", function() {
        var query = $(this).val();
        if (query.length >= 4) {
            productSearch(query);
        }
    })

    $(document).on("click","#search-btn",function() {
        var query = $("#bn-search-value").val();
        if (query.length >= 2) {
            productSearch(query);
        }
    });

    function hideSideNav() {
        $("#qodef-page-header").removeClass('open-side-menu')
        // $(".menu-nav-side").removeClass('show-side-menu')
        $(".menu-nav").removeClass('show-side-menu')

        $(".menu-nav-side").each(function(el){
            let defaultimg = $(this).attr('data-img')
            if(defaultimg)
            $(this).css('background-image', 'url('+defaultimg+')')
        })

        $('.bn-shop-container').removeClass('bn-show')
    }

    function showSideNav(divClass) {

        setTimeout(function(){
            $("#qodef-page-header").addClass('open-side-menu')
            $(divClass).addClass('show-side-menu')
    
            let defaultimg = $(divClass).attr('data-img-hover')
            if ($(divClass).attr('data-img-close')) {
                defaultimg = $(divClass).attr('data-img-close')
            }
            if(defaultimg)
            $(divClass).css('background-image', 'url('+defaultimg+')')
        }, 200);

    }

    function productSearch(query){

        query = query.trim();
        $("#byro-search-result").css("visibility","visible")
        $("#byro-search-result").html("Searching...")
        $.ajax({
            url:opt.ajaxUrl,
            type: 'post',
            data: { action: 'search_product', keyword: query },
            success: function(data) {
                
                console.log(data)
                if (data) {
                    $("#byro-search-result").html(data)
                } else {
                    $("#byro-search-result").html("<p>Sorry, no search term found!</p>")
                }
            }
        });


    }

    // $('rs-slide').on('stylechanged', function () {
    //     console.log('css changed');
    // });

    // (function() {
    //     orig = $.fn.css;
    //     $.fn.css = function() {
    //         var ev = new $.Event('style');
    //         orig.apply(this, arguments);
    //         $(this).trigger(ev);
    //     }
    // })();
    
    // // Perform change
    // // $('element').css('background', 'red');


})(jQuery);

