<?php
    $button_params = array(
        'link'          => $button_link,
        'text'          => $button_text,
        'button_layout' => $button_layout,
        'size'          => 'normal',
        'target'        => 'button_target',
    );

if ( class_exists( 'CorsenCore_Button_Shortcode' ) & ! empty( $button_link ) ) { ?>
    <div class="qodef-m-button" <?php qode_framework_inline_style( $button_styles ); ?>>
        <?php echo CorsenCore_Button_Shortcode::call_shortcode( $button_params ); ?>
    </div>
<?php } ?>
