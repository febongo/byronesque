<?php 

// Creating the widget
class wpb_widget_currency extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_widget_currency', 
        
        // Widget name will appear in UI
        __('Byronesque Currency Switcher', 'wpb_widget_currency_domain'), 
        
        // Widget description
        array( 'description' => __( 'Currency Switcher', 'wpb_widget_currency_domain' ), )
        );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        ?>
            <div id="bn-curr-switcher" class="currency-area">
                <span class="menu-nav menu-nav-side" 
                    data-action="get_currency"
                    data-img-hover="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/region_b.svg'?>" 
                    data-img="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/region_w.svg'?>" 
                    style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/region_w.svg'?>')">
                </span>
            </div>
            <div id="get_currency" style="display:none">
                <?php $currentCurrency = '';
                if(isset($_COOKIE['wcu_current_currency'])) {
                    $currentCurrency = $_COOKIE['wcu_current_currency'];
                }

                $countries = arrayOfCountries();

                $currencyName = getUserGeoCountry();

                $key = array_search($currencyName, array_column($countries, 'countryname'));
                
                $keyBilled = array_search($currentCurrency, array_column($countries, 'code'));
                
                $currentCurrencyObj = $keyBilled ? $countries[$keyBilled] : '';

                $currentCountry = $key ? $countries[$key] : '';
                ?>
                <div id="byronesque-currency-nav">
                    <h4>Region</h4>
                    <p>You are currently shipping to <?= $currencyName ?> and order will be billed in <?= $currentCurrencyObj ? $currentCurrencyObj['symbol'] : '' ?>-<?= $currentCurrency ?></p>
                    
                    <div class="search-form">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="Search Country" name="country-search" class="country-search" id="country-search">
                    </div>
                    
                    <div class="country-list-pre-selected">
                        <ul>
                            <li><a href="?currency=GBP">United Kingdom (£ - GBP)</a></li>
                            <li><a href="?currency=EUR">France  (€ - EUR)</a></li>
                            <li><a href="?currency=EUR">Italy (€ - EUR)</a></li>
                            <li><a href="?currency=EUR">Belgium (€ - EUR)</a></li>
                            <li><a href="?currency=EUR">Danmark (€ - EUR)</a></li>
                            <li><a href="?currency=EUR">Germany (€ - EUR)</a></li>
                            <li><a href="?currency=CNY">China (¥ - CNY)</a></li>
                            <li><a href="?currency=JPY">Japan (¥ - JPY)</a></li>
                            <li><a href="?currency=CAD">Canada (€ - CAD)</a></li>
                            <li><a href="?currency=USD">United States ($ - USD)</a></li>
                        </ul>
                    </div>

                    <div class="country-list grid">
                        <?php
                        $firstLetter = '';
                        $currentLetter = 'A';
                        $containerHtml = "";
                        $listHtml = "";
                        foreach($countries as $key => $country) {
                            // var_dump($country);
                            $firstLetter = substr($country['countryname'], 0, 1);
                            if ($currentLetter <> $firstLetter) {
                                
                                $containerHtml .= "<p class='element-item' data-category='".$currentLetter."'>".$currentLetter."</p><ul>" . $listHtml . "</ul>";
                                $currentLetter = $firstLetter;
                                $listHtml = "<li class='element-item' data-category='".$currentLetter."'><a href='?currency=".$country['code']."'>".$country['countryname'] . " (". $country['symbol']. ' - ' .$country['code'] .")</a></li>";

                            } else {
                                $listHtml .= "<li class='element-item' data-category='".$currentLetter."'><a href='?currency=".$country['code']."'>".$country['countryname'] . " (". $country['symbol']. ' - ' .$country['code'] .")</a></li>";
                            }
                            
                        }

                        $containerHtml .= "<p class='element-item' data-category='".$currentLetter."'>".$currentLetter."</p><ul>" . $listHtml . "</ul>";

                        echo $containerHtml;
                        ?>
                    </div>
                    

                </div>
            </div>
        <?php
        //  $countries_obj   = new WC_Countries();
        //     $countries   = $countries_obj->__get('countries');
            // var_dump($countries_obj);
        // END FRONT END DISPLAY
        echo $args['after_widget'];
    }
     
    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = __( 'New title', 'wpb_widget_currency_domain' );
        }
        // Widget admin form
        ?>
        <p>Byronesque Currency Switcher Function</p>
        <?php
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
     
    // Class wpb_widget ends here
} 

// OTHER FUNCTIONS

function get_currency() {

    $currentCurrency = '';
    if(isset($_COOKIE['wcu_current_currency'])) {
        $currentCurrency = $_COOKIE['wcu_current_currency'];
    }

    $countries = arrayOfCountries();

    $currencyName = getUserGeoCountry();

    $key = array_search($currencyName, array_column($countries, 'countryname'));
    
    $keyBilled = array_search($currentCurrency, array_column($countries, 'code'));
    
    $currentCurrencyObj = $keyBilled ? $countries[$keyBilled] : '';

    $currentCountry = $key ? $countries[$key] : '';
    ?>
    <div id="byronesque-currency-nav">
        <h4>Region</h4>
        <p>You are currently shipping to <?= $currencyName ?> and order will be billed in <?= $currentCurrencyObj ? $currentCurrencyObj['symbol'] : '' ?>-<?= $currentCurrency ?></p>
        
        <div class="search-form">
        <i class="fa fa-search"></i>
        <input type="text" placeholder="Search Country" name="country-search" class="country-search" id="country-search">
        </div>
        
        <div class="country-list-pre-selected">
            <ul>
                <li><a href="?currency=GBP">United Kingdom (£ - GBP)</a></li>
                <li><a href="?currency=EUR">France  (€ - EUR)</a></li>
                <li><a href="?currency=EUR">Italy (€ - EUR)</a></li>
                <li><a href="?currency=EUR">Belgium (€ - EUR)</a></li>
                <li><a href="?currency=EUR">Danmark (€ - EUR)</a></li>
                <li><a href="?currency=EUR">Germany (€ - EUR)</a></li>
                <li><a href="?currency=CNY">China (¥ - CNY)</a></li>
                <li><a href="?currency=JPY">Japan (¥ - JPY)</a></li>
                <li><a href="?currency=CAD">Canada (€ - CAD)</a></li>
                <li><a href="?currency=USD">United States ($ - USD)</a></li>
            </ul>
        </div>

        <div class="country-list grid">
            <?php
            $firstLetter = '';
            $currentLetter = 'A';
            $containerHtml = "";
            $listHtml = "";
            foreach($countries as $key => $country) {
                // var_dump($country);
                $firstLetter = substr($country['countryname'], 0, 1);
                if ($currentLetter <> $firstLetter) {
                    
                    $containerHtml .= "<p class='element-item' data-category='".$currentLetter."'>".$currentLetter."</p><ul>" . $listHtml . "</ul>";
                    $currentLetter = $firstLetter;
                    $listHtml = "<li class='element-item' data-category='".$currentLetter."'><a href='?currency=".$country['code']."'>".$country['countryname'] . " (". $country['symbol']. ' - ' .$country['code'] .")</a></li>";

                } else {
                    $listHtml .= "<li class='element-item' data-category='".$currentLetter."'><a href='?currency=".$country['code']."'>".$country['countryname'] . " (". $country['symbol']. ' - ' .$country['code'] .")</a></li>";
                }
                
            }

            $containerHtml .= "<p class='element-item' data-category='".$currentLetter."'>".$currentLetter."</p><ul>" . $listHtml . "</ul>";

            echo $containerHtml;
            ?>
        </div>
        

    </div>
    <?php

    die();
}


add_action( 'wp_ajax_get_currency', 'get_currency' );
add_action( 'wp_ajax_nopriv_get_currency', 'get_currency' );



