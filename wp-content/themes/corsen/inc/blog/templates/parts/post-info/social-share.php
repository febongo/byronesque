<?php if ( class_exists( 'CorsenCore_Social_Share_Shortcode' ) ) { ?>
    <div class="qodef-e-info-item qodef-info--social-share">
        <?php
        $params = array();
        $params['layout'] = 'dropdown';
        $params['dropdown_behavior'] = 'left';
        $params['title'] = ' ';

        echo CorsenCore_Social_Share_Shortcode::call_shortcode( $params ); ?>
    </div>
<?php } ?>
