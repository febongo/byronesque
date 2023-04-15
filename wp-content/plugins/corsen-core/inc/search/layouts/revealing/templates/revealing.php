<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="qodef-search-revealing-form" method="get">
	<div class="qodef-m-inner">
		<input type="text" placeholder="<?php esc_attr_e( 'Search', 'corsen-core' ); ?>" name="s" class="qodef-m-form-field" autocomplete="off" required/>
        <?php
        corsen_core_get_opener_icon_html(
            array(
                'html_tag'     => 'button',
                'option_name'  => 'search',
                'custom_icon'  => 'search',
                'custom_class' => 'qodef-m-form-submit',
            )
        );
        ?>
        <div class="qodef-m-form-line"></div>
	</div>
</form>
