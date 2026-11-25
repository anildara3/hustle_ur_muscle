<?php
/**
 * Single Program Template (CPT: hum_program)
 *
 * @package HustleUrMuscle
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part(
		'template-parts/program-detail',
		null,
		array( 'program_id' => get_the_ID() )
	);
endwhile;

get_footer();
