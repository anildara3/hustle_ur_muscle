<?php
/**
 * Template Name: Program Details
 * Renders the featured/first Program CPT item or default Strength & Hypertrophy curriculum.
 *
 * @package HustleUrMuscle
 */

get_header();

$first_program = get_posts(
	array(
		'post_type'   => 'hum_program',
		'numberposts' => 1,
		'post_status' => 'publish',
		'orderby'     => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	)
);

get_template_part(
	'template-parts/program-detail',
	null,
	array( 'program_id' => ! empty( $first_program ) ? (int) $first_program[0]->ID : 0 )
);

get_footer();
