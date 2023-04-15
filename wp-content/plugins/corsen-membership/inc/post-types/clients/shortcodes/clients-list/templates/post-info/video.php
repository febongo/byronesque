<?php
$item_id            = get_the_ID();
$client_video_image = get_post_meta( $item_id, 'qodef_client_video_image', true );
$client_video_link  = get_post_meta( $item_id, 'qodef_client_video_link', true );

$video_button_params = array(
    'video_link'    => $client_video_link,
    'video_image'   => $client_video_image,
);

if ( class_exists( 'CorsenCore_Video_Button_Shortcode' ) & ! empty( $client_video_link ) ) { ?>
    <div class="qodef-e-image">
        <?php echo CorsenCore_Video_Button_Shortcode::call_shortcode( $video_button_params ); ?>
    </div>
<?php } ?>
