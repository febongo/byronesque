<?php
/*
Template Name: Timetable Event
*/
get_header();

// Include event content template
if ( corsen_is_installed( 'core' ) ) {
	corsen_core_template_part( 'plugins/timetable', 'templates/content' );
}

get_footer();
