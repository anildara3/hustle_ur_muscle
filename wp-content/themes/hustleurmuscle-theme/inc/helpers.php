<?php
/**
 * Theme Helper Functions (ACF Free safe wrappers + URL & Image utilities)
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the Front Page ID safely.
 */
function hum_get_front_page_id() {
	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id > 0 ) {
		return $front_id;
	}
	$home_page = get_page_by_path( 'home' );
	return $home_page instanceof WP_Post ? (int) $home_page->ID : 0;
}

/**
 * Safely retrieve an ACF field or post meta value with a default fallback.
 */
function hum_get_field( $selector, $post_id = false, $default = '' ) {
	$target_id = $post_id ? $post_id : get_the_ID();
	$val       = null;

	if ( function_exists( 'get_field' ) ) {
		$val = get_field( $selector, $target_id );
	} elseif ( $target_id ) {
		$val = get_post_meta( $target_id, $selector, true );
	}

	if ( null === $val || '' === $val || ( is_array( $val ) && empty( $val ) ) ) {
		return $default;
	}

	return $val;
}

/**
 * Retrieve a boolean ACF field with a default value when unset.
 */
function hum_get_bool_field( $selector, $post_id = false, $default = false ) {
	$target_id = $post_id ? $post_id : get_the_ID();
	if ( ! $target_id ) {
		return $default;
	}

	$raw = get_post_meta( $target_id, $selector, true );
	if ( '' === $raw ) {
		return $default;
	}

	return (bool) (int) $raw || true === $raw || '1' === $raw;
}

/**
 * Safely resolve an ACF image field (array, ID, or URL) with theme asset fallback.
 */
function hum_get_image_url( $selector, $post_id = false, $default_relative = '', $size = 'full' ) {
	$val = hum_get_field( $selector, $post_id, '' );

	if ( is_array( $val ) && ! empty( $val['url'] ) ) {
		return $val['url'];
	}
	if ( is_numeric( $val ) && (int) $val > 0 ) {
		$src = wp_get_attachment_image_url( (int) $val, $size );
		if ( $src ) {
			return $src;
		}
	}
	if ( is_string( $val ) && '' !== trim( $val ) ) {
		return $val;
	}

	return $default_relative ? get_template_directory_uri() . '/' . ltrim( $default_relative, '/' ) : '';
}

/**
 * Retrieve global site option: Front Page ACF field -> Customizer -> Default.
 */
function hum_get_site_setting( $acf_key, $customizer_key, $default = '' ) {
	$front_id = hum_get_front_page_id();
	if ( $front_id > 0 && $acf_key ) {
		$acf_val = hum_get_field( $acf_key, $front_id, '' );
		if ( '' !== $acf_val ) {
			return $acf_val;
		}
	}

	if ( $customizer_key ) {
		$mod = get_theme_mod( $customizer_key, '' );
		if ( '' !== $mod ) {
			return $mod;
		}
	}

	return $default;
}

/**
 * Backward-compatible alias for templates using hustleurmuscle_get_option().
 */
function hustleurmuscle_get_option( $key, $default = '' ) {
	$map = array(
		'hum_phone'         => 'site_phone',
		'hum_email'         => 'site_email',
		'hum_whatsapp_url'  => 'site_whatsapp_url',
		'hum_instagram_url' => 'site_instagram_url',
		'hum_facebook_url'  => 'site_facebook_url',
		'hum_twitter_url'   => 'site_twitter_url',
		'hum_youtube_url'   => 'site_youtube_url',
		'hum_reel_1'        => 'site_reel_1',
		'hum_reel_2'        => 'site_reel_2',
		'hum_reel_3'        => 'site_reel_3',
		'hum_reel_4'        => 'site_reel_4',
		'hum_reel_5'        => 'site_reel_5',
		'hum_reel_6'        => 'site_reel_6',
	);

	$acf_key = isset( $map[ $key ] ) ? $map[ $key ] : '';
	return hum_get_site_setting( $acf_key, $key, $default );
}

/**
 * Get URL for a theme page by slug or assigned template.
 */
function hustleurmuscle_get_page_url( $slugs, $fallback_path = '' ) {
	if ( ! is_array( $slugs ) ) {
		$slugs = array( $slugs );
	}

	foreach ( $slugs as $slug ) {
		if ( 'blog' === $slug ) {
			$posts_page_id = (int) get_option( 'page_for_posts' );
			if ( $posts_page_id > 0 ) {
				return get_permalink( $posts_page_id );
			}
		}

		$page = get_page_by_path( $slug );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			return get_permalink( $page->ID );
		}
	}

	$template_map = array(
		'about'            => 'page-about.php',
		'programs'         => 'page-programs.php',
		'program-single'   => 'page-program-single.php',
		'faqs'             => 'page-faqs.php',
		'contact'          => 'page-contact.php',
		'privacy-policy'   => 'page-privacy-policy.php',
		'terms-conditions' => 'page-terms-conditions.php',
	);

	foreach ( $slugs as $slug ) {
		if ( isset( $template_map[ $slug ] ) ) {
			$pages = get_pages(
				array(
					'meta_key'   => '_wp_page_template',
					'meta_value' => $template_map[ $slug ],
					'number'     => 1,
				)
			);
			if ( ! empty( $pages ) ) {
				return get_permalink( $pages[0]->ID );
			}
		}
	}

	return home_url( $fallback_path ? '/' . ltrim( $fallback_path, '/' ) : '/' );
}

/**
 * Split multi-line textarea into clean non-empty array of lines.
 */
function hum_split_lines( $text ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $text );
	return array_values( array_filter( array_map( 'trim', $lines ) ) );
}

/**
 * Estimated reading time for blog posts.
 */
function hustleurmuscle_reading_time( $post_id = null ) {
	$content    = get_post_field( 'post_content', $post_id ? $post_id : get_the_ID() );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = max( 1, (int) ceil( $word_count / 200 ) );
	return $minutes . ' MIN READ';
}
