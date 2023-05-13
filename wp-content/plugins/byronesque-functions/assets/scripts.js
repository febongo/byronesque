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
                $(".mo-openid-app-icons a").removeAttr("style");
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
            if( $('.qodef-woo-single-inner').length && $('.qodef-woo-single-inner').isInViewport() && 
                !( ($('.upsells').length &&  $('.upsells').isInViewport()) || $('#qodef-page-footer').isInViewport()) 
            ) {
                $(".summary.entry-summary").css("top",offset)
            }
            // console.log(productOffset)

            if ($('#stepStarter').length ) {
                if( !$('#stepStarter').isInViewport() ) {
                    console.log("hidden");
                    $('.stepBack').css("top",60)
                    $('.stepBack').css("position","fixed")
                } else {
                    console.log("showing");
                    $('.stepBack').css("top",0)
                    $('.stepBack').css("position","relative")
                }
            }
            
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
            var links = $(".home-interactive-links .qodef-m-items a")
            // console.log(links[0],images);
            // links.each(function(ndx){
            //     console.log("this links",$(this).attr('href'));
            // })

            images.each(function(ndx){
                // console.log("index", $(links[0]).attr('href')   )
                // console.log($(this).find('img').attr('src'))
                var this_ = $(this)
                $.ajax({
                    url:opt.ajaxUrl,
                    type: 'post',
                    data: { 
                        action: 'get_image_meta', 
                        imgurl: $(this).find('img').attr('src'),
                        link: $(links[ndx]).attr('href') 
                    },
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

        // ADDRESS BOOK SCRIPTS
        $(".setDefault").click(function(){

            let id = $(this).attr('data-address-id')
            let type = $(this).attr('data-address-type')
            $.ajax({
                url:opt.ajaxUrl,
                type: 'get',
                data: { action:  'set_customer_default', id: id, type: type },
                success: function(data) {
                    location.reload();
                }
            });
        })

        $(".removeAddress").click(function(){

            let id = $(this).attr('data-address-id')
            $.ajax({
                url:opt.ajaxUrl,
                type: 'get',
                data: { action:  'delete_customer_address', id: id},
                success: function(data) {
                    location.reload();
                }
            });
        })

        // ADDRESS BOOK POPULATE CHECKOUT FIELDS
        if ( $(".woocommerce-checkout").length ) {

            var blockStep=[
                "shippingAddressCustom",
                "shippingMethodCustom",
                "paymentMethodCustom",
                "billingAddressCustom",
            ];
            var currentBlockStep=0;
            // var block
            // hide additional fields
            // $(".woocommerce-additional-fields").hide();

            var shipOption = $('input[name="shipOption"]:checked').val();
            let shippingAddress,billingAddress;
            let this_ = this;

            $.ajax({
                url:opt.ajaxUrl,
                async: false,
                'global': false,
                type: 'get',
                data: { action:  'get_customer_addresses', type: 'shipping' },
                success: function(data) {
                    let userData = $.parseJSON(data)
                    // return userData;
                    shippingAddress = userData;
                    if(userData)
                    setAddressFields("shipping", userData.userdata)
                    // $('.woocommerce-shipping-fields__field-wrapper').hide()
                }
            });

            $.ajax({
                url:opt.ajaxUrl,
                async: false,
                'global': false,
                type: 'get',
                data: { action:  'get_customer_addresses', type: 'billing' },
                success: function(data) {
                    let userData = $.parseJSON(data)
                    // return userData;
                    billingAddress = userData;
                    if(userData)
                    setAddressFields("billing", userData.userdata)
                    // $('.woocommerce-billing-fields').hide()
                }
            });

            // console.log("ajax returned data", shippingAddress);
            if (shippingAddress) {
                setAddressFields("shipping", shippingAddress.userdata)
                $('input[value="shipToDefault"]').prop('checked',true)
                $('.woocommerce-shipping-fields__field-wrapper').hide()

            } else {
                // show empty fields
                setAddressFields("shipping", null)
                $('input[value="shipToNew"]').prop('checked',true)
                $('.woocommerce-shipping-fields__field-wrapper').show()
                // $('input[name="shipOption"]').trigger('change')
            }

            appendShippingTo()

            // $('input[name="shipOption"]').trigger('change')


            $('input[name="shipOption"]').change(function(){ console.log('event called change');
                var shipOption = $('input[name="shipOption"]:checked').val();

                if (shipOption.trim() == "shipToDefault") {
                    setAddressFields("shipping", shippingAddress.userdata)
                    $('.woocommerce-shipping-fields__field-wrapper').hide()
                } else {
                    setAddressFields("shipping", null)
                    $('.woocommerce-shipping-fields__field-wrapper').show()
                }
            })

            $(document).on("click",".nextBlock",function() {
                currentBlockStep++;
                var nextBlockDiv = blockStep[currentBlockStep]
                // $(this).parent().hide();
                setActiveBlockCheckout(nextBlockDiv)
            });

            $(document).on("click",".stepBack",function() {
                if (currentBlockStep > 0) {
                    currentBlockStep--;
                    var nextBlockDiv = blockStep[currentBlockStep]
                    setActiveBlockCheckout(nextBlockDiv)
                }

                return false;
                
            });
            

            var selectedShippingMethod = $('#shipping_method input[type="radio"]:checked').attr('id');
            if (!selectedShippingMethod) {
                selectedShippingMethod = $('#shipping_method li:first-child input').attr('id');
                $('#shipping_method li:first-child .checkmark').hide()
            }
            console.log("shippping ",selectedShippingMethod);
            setShippingMethodPrice(selectedShippingMethod)

            $(document).on("change", "#shipping_method input[type='radio']", function(){
                console.log("method changed");
                var selectedShippingMethod = $('#shipping_method input[type="radio"]:checked').attr('id');
                setShippingMethodPrice(selectedShippingMethod)
            })

            
            // Billing actions
            setAddressFields("billing", billingAddress.userdata)
            $('input[value="billSameShip"]').prop('checked',true)
            $('.woocommerce-billing-fields__field-wrapper').hide()
            console.log("read billing");
            $('input[name="billOption"]').change(function(){ console.log('event called change');
                var billOption = $('input[name="billOption"]:checked').val();
                console.log("billing option changed");
                if (billOption.trim() == "billSameShip") {
                    let billingData = {
                        billing_first_name : $("#shipping_first_name").val(),
                        billing_last_name : $("#shipping_last_name").val(),
                        billing_country : $("#shipping_country").val(),
                        billing_address_1: $("#shipping_address_1").val(),
                        billing_city : $("#shipping_city").val(),
                        billing_state : $("#shipping_state").val(),
                        billing_postcode : $("#shipping_postcode").val(),
                        billing_phone : $("#shipping_phone").val()
                    }
                    setAddressFields("billing", billingData)
                    $('.woocommerce-billling-fields__field-wrapper').hide()
                } else if (billOption.trim() == "billToDefault") {
                    setAddressFields("billing", billingAddress.userdata)
                    $('.woocommerce-billing-fields__field-wrapper').hide()
                } else {
                    setAddressFields("billing", null)
                    $('.woocommerce-billing-fields__field-wrapper').show()
                }
            })

            
        }

        $(".single_add_to_cart_button").click(function(){
            alert();
        });

        if ( $("#JSLogin").length ) {
            $(".single_add_to_cart_button").hide();

            $("#JSLogin").click(function(){
                $("#get_account h4").text("Login")
                $("#get_account").addClass('login-wrap')
                $("#get_account").removeAttr("style");
            });

            $(document).on("click","#get_account #bn-login-close",function() {
                console.log("this");
                $("#get_account").removeClass('login-wrap')
                $("#get_account").hide()
            });
        }

        $(".jsSendEmail").click(function(){
            $(this).hide();
            $(this).parent().append("sending request...");
            let this_ = $(this);
            $.ajax({
                url:opt.ajaxUrl,
                type: 'get',
                data: { 
                    action:  'updateRequestSelling',
                    id:  $(this).attr('data-id'),
                    type:  $(this).attr('data-type'),
                    dataAction:  $(this).attr('data-action'),
                },
                success: function(data) {
                    let reqData = $.parseJSON(data);
                    this_.parent().html(reqData.message);
                },
                done: function(data){
                    let reqData = $.parseJSON(data);
                    this_.parent().html(reqData.message);
                }
            });

            return false;
        });
        
        
        
    }) // DOCUMENT READY -- END


    // ***************************************
    // LISTEN TO JQUERY EVENTS
    // TODO CLEAN UP SCRIPTS BELOW
    // ***************************************

    function setAddressFields(type,userShippingdata){

        if (userShippingdata) {
            $("#"+type+"_first_name").val(type == 'shipping' ? userShippingdata.shipping_first_name : userShippingdata.billing_first_name)
            $("#"+type+"_last_name").val(type == 'shipping' ? userShippingdata.shipping_last_name : userShippingdata.billing_last_name)
            $("#"+type+"_country").val(type == 'shipping' ? userShippingdata.shipping_country : userShippingdata.billing_country).change()
            $("#"+type+"_address_1").val(type == 'shipping' ? userShippingdata.shipping_address_1: userShippingdata.billing_address_1)
            $("#"+type+"_city").val(type == 'shipping' ? userShippingdata.shipping_city : userShippingdata.billing_city)
            $("#"+type+"_cstate").val(type == 'shipping' ? userShippingdata.shipping_state : userShippingdata.billing_state)
            $("#"+type+"_postcode").val(type == 'shipping' ? userShippingdata.shipping_postcode : userShippingdata.billing_postcode)
            $("#"+type+"_phone").val(type == 'shipping' ? userShippingdata.shipping_phone : userShippingdata.billing_phone)
        } else {
            $("#"+type+"_first_name").val('')
            $("#"+type+"_last_name").val('')
            $("#"+type+"_country").val('').change()
            $("#"+type+"_address_1").val('')
            $("#"+type+"_city").val('')
            $("#"+type+"_state").val('')
            $("#"+type+"_postcode").val('')
            $("#"+type+"_phone").val('')
        }

        
    }

    function setActiveBlockCheckout(target) {
        // hide all detail
        // set active / inactive
        $(".checkoutBlocks").addClass('inActive')
        $("#"+target).removeClass('inActive')

        if (target == "shippingMethodCustom") {
            appendShippingTo()
        }
        $('html, body').animate({
            scrollTop: $("#"+target).offset().top
        }, 500);
        // $.scrollTo($('#'+target), 300);

    }

    function setShippingMethodPrice(targetId) {
        let priceHtml = $("#"+targetId).parent().find('.woocommerce-Price-amount').html()
        setTimeout(function(){ 
            // x.value = "2 seconds" 
            $("#shippingMethodAmount").html(priceHtml)
        }, 2000);
        // console.log(priceHtml)
    }

    function appendShippingTo(){
        var name = $("#shipping_first_name").val() + " " + $("#shipping_last_name").val()
        var address = $("#shipping_address_1").val() 
        var addressCountry = $("#shipping_postcode").val() + " " + $("#shipping_city").val() + ", " + $("#shipping_country").val()
        var html = "";
        html += "<p class='shippingTo'>Shipping to</p>";
        html += "<p class='shippingToDetails'>" + 
                "<span>"+name+"</span><br>" +
                "<span>"+address+"</span><br>" +
                "<span>"+addressCountry+"</span>" +
                "</p>";
        $(".shippingTo").html(html);
        // $(".woocommerce-myaccount-detailblock").append("<p>test</p>")
    }
    
    $(document).on("click","#bn-shopby .menu-nav",function() {

        
        // console.log('click',$(this));
        if (!$("#bn-shopby .menu-nav").hasClass('show-side-menu')) {
            hideSideNav()
            $(".bn-shop-container").addClass('bn-show')
            $(this).addClass('show-side-menu')
        } else {
            hideSideNav()
            // console.log('else');
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

