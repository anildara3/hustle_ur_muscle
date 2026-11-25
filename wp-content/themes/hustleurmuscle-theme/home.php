<?php
/**
 * Posts Page (Blog) Template
 *
 * @package HustleUrMuscle
 */

get_header();
get_template_part(
	'template-parts/blog-archive-layout',
	null,
	array(
		'tag'   => 'OUR FITNESS KNOWLEDGE',
		'title' => 'ARTICLES & BLOG',
		'desc'  => 'Science-backed training guides, macro nutrition insights, and athletic development advice written by Coach Sagar Soma.',
		'crumb' => 'BLOG',
	)
);
get_footer();
