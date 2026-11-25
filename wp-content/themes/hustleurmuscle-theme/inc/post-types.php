<?php
/**
 * Custom Post Types Registration (Hero Slides, Programs, Testimonials, FAQs, Trainers)
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register all theme Custom Post Types uniformly from one config table.
 */
function hum_register_custom_post_types() {
	$post_types = array(
		'hum_slide'       => array(
			'singular'  => 'Hero Slide',
			'plural'    => 'Hero Slides',
			'icon'      => 'dashicons-images-alt2',
			'position'  => 21,
			'supports'  => array( 'title', 'thumbnail', 'page-attributes' ),
			'publicly'  => false,
			'has_archive' => false,
			'slug'      => '',
		),
		'hum_program'     => array(
			'singular'  => 'Program',
			'plural'    => 'Programs',
			'icon'      => 'dashicons-awards',
			'position'  => 22,
			'supports'  => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'publicly'  => true,
			'has_archive' => false,
			'slug'      => 'training-program',
		),
		'hum_testimonial' => array(
			'singular'  => 'Testimonial',
			'plural'    => 'Testimonials',
			'icon'      => 'dashicons-format-quote',
			'position'  => 23,
			'supports'  => array( 'title', 'thumbnail', 'page-attributes' ),
			'publicly'  => false,
			'has_archive' => false,
			'slug'      => '',
		),
		'hum_faq'         => array(
			'singular'  => 'FAQ',
			'plural'    => 'FAQs',
			'icon'      => 'dashicons-editor-help',
			'position'  => 24,
			'supports'  => array( 'title', 'editor', 'page-attributes' ),
			'publicly'  => false,
			'has_archive' => false,
			'slug'      => '',
		),
		'hum_trainer'     => array(
			'singular'  => 'Trainer',
			'plural'    => 'Team Trainers',
			'icon'      => 'dashicons-groups',
			'position'  => 25,
			'supports'  => array( 'title', 'thumbnail', 'page-attributes' ),
			'publicly'  => false,
			'has_archive' => false,
			'slug'      => '',
		),
	);

	foreach ( $post_types as $post_type => $cfg ) {
		$labels = array(
			'name'               => $cfg['plural'],
			'singular_name'      => $cfg['singular'],
			'menu_name'          => $cfg['plural'],
			'name_admin_bar'     => $cfg['singular'],
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New ' . $cfg['singular'],
			'new_item'           => 'New ' . $cfg['singular'],
			'edit_item'          => 'Edit ' . $cfg['singular'],
			'view_item'          => 'View ' . $cfg['singular'],
			'all_items'          => 'All ' . $cfg['plural'],
			'search_items'       => 'Search ' . $cfg['plural'],
			'not_found'          => 'No ' . strtolower( $cfg['plural'] ) . ' found.',
			'not_found_in_trash' => 'No ' . strtolower( $cfg['plural'] ) . ' found in Trash.',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => $cfg['publicly'],
			'publicly_queryable' => $cfg['publicly'],
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => $cfg['publicly'],
			'rewrite'            => $cfg['slug'] ? array( 'slug' => $cfg['slug'] ) : false,
			'capability_type'    => 'post',
			'has_archive'        => $cfg['has_archive'],
			'hierarchical'       => false,
			'menu_position'      => $cfg['position'],
			'menu_icon'          => $cfg['icon'],
			'supports'           => $cfg['supports'],
			'show_in_rest'       => true,
		);

		register_post_type( $post_type, $args );
	}
}
add_action( 'init', 'hum_register_custom_post_types' );
