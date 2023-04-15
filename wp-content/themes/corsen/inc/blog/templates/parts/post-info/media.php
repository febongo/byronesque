<div class="qodef-e-media">
	<?php
	switch ( get_post_format() ) {
		case 'gallery':
			corsen_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			corsen_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			corsen_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			corsen_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?>
</div>
