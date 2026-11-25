<?php
/**
 * Search Results Template
 *
 * @package HustleUrMuscle
 */

get_header();
get_template_part(
	'template-parts/blog-archive-layout',
	null,
	array(
		'tag'   => 'SEARCH RESULTS',
		'title' => 'SEARCH: ' . strtoupper( get_search_query() ),
		'desc'  => 'Results across Hustle Ur Muscle articles and training guides.',
		'crumb' => 'SEARCH',
	)
);
get_footer();
