<?php
/**
 * Archive Template (Categories, Tags, Dates)
 *
 * @package HustleUrMuscle
 */

get_header();
get_template_part(
	'template-parts/blog-archive-layout',
	null,
	array(
		'tag'   => 'BLOG ARCHIVE',
		'title' => strtoupper( wp_strip_all_tags( get_the_archive_title() ) ),
		'desc'  => get_the_archive_description() ? wp_strip_all_tags( get_the_archive_description() ) : 'Science-backed training guides and articles by Coach Sagar Soma.',
		'crumb' => 'ARCHIVE',
	)
);
get_footer();
