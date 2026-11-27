<?php
/**
 * Hustle Ur Muscle Theme Functions and Definitions
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HUM_THEME_VERSION', '1.1.3' );

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/cf7.php';
require_once get_template_directory() . '/inc/seed-content.php';

/**
 * Set up theme defaults and register WordPress features.
 */
function hustleurmuscle_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 80,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary'            => __( 'Primary Navigation Menu', 'hustleurmuscle' ),
			'footer_quick_links' => __( 'Footer Quick Links Menu', 'hustleurmuscle' ),
		)
	);
}
add_action( 'after_setup_theme', 'hustleurmuscle_setup' );

/**
 * Build Hero Slider data from CPT (hum_slide) for JS slider transitions.
 */
function hum_get_hero_slides_data() {
	$theme_uri = get_template_directory_uri();
	$slides    = array();

	$query = new WP_Query(
		array(
			'post_type'      => 'hum_slide',
			'posts_per_page' => 10,
			'post_status'    => 'publish',
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
		)
	);

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$pid       = get_the_ID();
			$bg_img    = hum_get_image_url( 'slide_bg_image', $pid );
			if ( ! $bg_img && has_post_thumbnail( $pid ) ) {
				$bg_img = get_the_post_thumbnail_url( $pid, 'full' );
			}
			if ( ! $bg_img ) {
				$bg_img = $theme_uri . '/assets/images/hero-bg.jpg';
			}

			$top_line  = hum_get_field( 'slide_title_top', $pid, '' );
			$highlight = hum_get_field( 'slide_highlight', $pid, '' );
			if ( $top_line || $highlight ) {
				$title_html = esc_html( $top_line ) . ' <span class="highlight">' . esc_html( $highlight ) . '</span>';
			} else {
				$title_html = esc_html( get_the_title() );
			}

			$slides[] = array(
				'image'       => $bg_img,
				'tag'         => hum_get_field( 'slide_tag', $pid, 'COACH SAGAR SOMA — HUSTLE UR MUSCLE' ),
				'title'       => $title_html,
				'description' => hum_get_field( 'slide_description', $pid, '' ),
			);
		}
		wp_reset_postdata();
	}

	if ( empty( $slides ) ) {
		$slides = array(
			array(
				'image'       => $theme_uri . '/assets/images/hero-bg.jpg',
				'tag'         => 'COACH SAGAR SOMA — HUSTLE UR MUSCLE',
				'title'       => 'KEEP YOUR <span class="highlight">BODY FIT &amp; STRONG</span>',
				'description' => 'Transform your physique with science-based personal training, tailored nutrition protocols, and 1-on-1 expert coaching designed for life-changing results with Sagar Soma at Hustle Ur Muscle.',
			),
			array(
				'image'       => $theme_uri . '/assets/images/about-1.jpg',
				'tag'         => 'NO PAIN NO GAIN',
				'title'       => 'UNLEASH YOUR <span class="highlight">TRUE POWER &amp; AGILITY</span>',
				'description' => 'Elevate your performance and endurance. Our customized functional strength conditioning at Hustle Ur Muscle unlocks peak athletic capability.',
			),
			array(
				'image'       => $theme_uri . '/assets/images/banner-gym.jpg',
				'tag'         => 'ELITE TRAINING METHOD',
				'title'       => 'BUILD LEAN MUSCLE <span class="highlight">&amp; PEAK RESILIENCE</span>',
				'description' => 'Step into the personal training zone with professional equipment, certified guidance from Coach Sagar Soma, and relentless motivation.',
			),
		);
	}

	return $slides;
}

/**
 * Enqueue stylesheets and scripts preserving exact design order.
 */
function hustleurmuscle_enqueue_assets() {
	$theme_uri = get_template_directory_uri();

	wp_enqueue_style(
		'hum-google-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700&family=Caveat:wght@600;700&family=Montserrat:wght@300;400;500;600;700&family=Oswald:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'hum-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3' );
	wp_enqueue_style( 'hum-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2' );
	wp_enqueue_style( 'hum-aos', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1' );
	wp_enqueue_style( 'hum-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );
	wp_enqueue_style( 'hum-main-style', $theme_uri . '/assets/css/style.css', array( 'hum-bootstrap', 'hum-fontawesome', 'hum-aos', 'hum-swiper' ), HUM_THEME_VERSION );
	wp_enqueue_style( 'hum-theme-style', get_stylesheet_uri(), array( 'hum-main-style' ), HUM_THEME_VERSION );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'hum-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.3.3', true );
	wp_enqueue_script( 'hum-aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true );
	wp_enqueue_script( 'hum-swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );
	wp_enqueue_script( 'hum-main-js', $theme_uri . '/assets/js/main.js', array( 'jquery', 'hum-bootstrap-js', 'hum-aos-js', 'hum-swiper-js' ), HUM_THEME_VERSION, true );

	wp_localize_script(
		'hum-main-js',
		'hustleurmuscleData',
		array(
			'themeUrl' => $theme_uri,
			'homeUrl'  => home_url( '/' ),
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'hum_form_nonce' ),
			'slides'   => is_front_page() ? hum_get_hero_slides_data() : array(),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hustleurmuscle_enqueue_assets' );

/**
 * Customizer fallback settings (Home Page ACF fields take priority if edited).
 */
function hustleurmuscle_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'hum_contact_section',
		array(
			'title'    => __( 'Hustle Ur Muscle Contact & Social', 'hustleurmuscle' ),
			'priority' => 30,
		)
	);

	$settings = array(
		'hum_phone'         => array( 'Phone Number', '9948660025' ),
		'hum_email'         => array( 'Email Address', 'info@hustleurmuscle.in' ),
		'hum_whatsapp_url'  => array( 'WhatsApp URL', 'https://wa.me/' ),
		'hum_instagram_url' => array( 'Instagram Profile URL', 'https://www.instagram.com/ssagarsomahustleurmuscle/' ),
		'hum_facebook_url'  => array( 'Facebook Page URL', 'https://www.facebook.com/hustleurmuscle/' ),
		'hum_twitter_url'   => array( 'Twitter / X URL', 'https://twitter.com' ),
		'hum_youtube_url'   => array( 'YouTube URL', 'https://youtube.com' ),
		'hum_reel_1'        => array( 'Instagram Reel 1 URL', 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4' ),
		'hum_reel_2'        => array( 'Instagram Reel 2 URL', 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj' ),
		'hum_reel_3'        => array( 'Instagram Reel 3 URL', 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==' ),
		'hum_reel_4'        => array( 'Instagram Reel 4 URL', 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4' ),
		'hum_reel_5'        => array( 'Instagram Reel 5 URL', 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj' ),
		'hum_reel_6'        => array( 'Instagram Reel 6 URL', 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==' ),
	);

	foreach ( $settings as $id => $meta ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $meta[1],
				'sanitize_callback' => ( false !== strpos( $id, '_url' ) || false !== strpos( $id, 'reel_' ) ) ? 'esc_url_raw' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $meta[0],
				'section' => 'hum_contact_section',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'hustleurmuscle_customize_register' );

/**
 * Bootstrap 5 Nav Walker preserving exact .nav-item and .nav-link classes.
 */
class HustleUrMuscle_Nav_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$is_active = in_array( 'current-menu-item', (array) $item->classes, true )
			|| in_array( 'current_page_item', (array) $item->classes, true )
			|| in_array( 'current-menu-ancestor', (array) $item->classes, true );

		$output .= '<li class="nav-item">';
		$atts    = array(
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
			'target' => ! empty( $item->target ) ? $item->target : '',
			'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
			'href'   => ! empty( $item->url ) ? $item->url : '#',
			'class'  => 'nav-link' . ( $is_active ? ' active' : '' ),
		);

		$attr_str = '';
		foreach ( $atts as $attr => $value ) {
			if ( '' !== $value ) {
				$value     = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attr_str .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$output .= '<a' . $attr_str . '>' . esc_html( strtoupper( $item->title ) ) . '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * Fallback Primary Navigation matching exact HTML menu structure.
 */
function hustleurmuscle_primary_menu_fallback() {
	$items = array(
		array(
			'label'  => 'HOME',
			'url'    => home_url( '/' ),
			'active' => is_front_page(),
		),
		array(
			'label'  => 'ABOUT US',
			'url'    => hustleurmuscle_get_page_url( array( 'about', 'about-us' ) ),
			'active' => is_page_template( 'page-about.php' ) || is_page( array( 'about', 'about-us' ) ),
		),
		array(
			'label'  => 'PROGRAMS',
			'url'    => hustleurmuscle_get_page_url( array( 'programs' ) ),
			'active' => is_page_template( array( 'page-programs.php', 'page-program-single.php' ) ) || is_singular( 'hum_program' ) || is_page( array( 'programs', 'program-single' ) ),
		),
		array(
			'label'  => 'GALLERY',
			'url'    => hustleurmuscle_get_page_url( array( 'gallery' ) ),
			'active' => is_page_template( 'page-gallery.php' ) || is_page( array( 'gallery' ) ),
		),
		array(
			'label'  => 'FAQS',
			'url'    => hustleurmuscle_get_page_url( array( 'faqs', 'faq' ) ),
			'active' => is_page_template( 'page-faqs.php' ) || is_page( array( 'faqs', 'faq' ) ),
		),
		array(
			'label'  => 'BLOG',
			'url'    => hustleurmuscle_get_page_url( array( 'blog' ) ),
			'active' => is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_archive(),
		),
		array(
			'label'  => 'CONTACTS',
			'url'    => hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) ),
			'active' => is_page_template( 'page-contact.php' ) || is_page( array( 'contact', 'contacts' ) ),
		),
	);

	echo '<ul class="navbar-nav mx-auto mb-2 mb-lg-0">';
	foreach ( $items as $item ) {
		$active_class = $item['active'] ? ' active' : '';
		echo '<li class="nav-item"><a class="nav-link' . esc_attr( $active_class ) . '" href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Fallback Footer Quick Links matching exact HTML links.
 */
function hustleurmuscle_footer_menu_fallback() {
	$links = array(
		'Home'     => home_url( '/' ),
		'About Us' => hustleurmuscle_get_page_url( array( 'about', 'about-us' ) ),
		'Programs' => hustleurmuscle_get_page_url( array( 'programs' ) ),
		'Gallery'  => hustleurmuscle_get_page_url( array( 'gallery' ) ),
		'FAQs'     => hustleurmuscle_get_page_url( array( 'faqs', 'faq' ) ),
		'Blog'     => hustleurmuscle_get_page_url( array( 'blog' ) ),
		'Contact'  => hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) ),
	);

	echo '<ul class="footer-links-list">';
	foreach ( $links as $label => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * AJAX fallback handler (used when Contact Form 7 is inactive).
 */
function hustleurmuscle_handle_form_submission() {
	check_ajax_referer( 'hum_form_nonce', 'nonce' );

	$form_type = isset( $_POST['form_type'] ) ? sanitize_text_field( wp_unslash( $_POST['form_type'] ) ) : 'contact';
	$name      = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone     = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$goal      = isset( $_POST['goal'] ) ? sanitize_text_field( wp_unslash( $_POST['goal'] ) ) : '';
	$time      = isset( $_POST['time'] ) ? sanitize_text_field( wp_unslash( $_POST['time'] ) ) : '';
	$city      = isset( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';
	$message   = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( empty( $name ) || empty( $phone ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'hustleurmuscle' ) ) );
	}

	$to = sanitize_email( hustleurmuscle_get_option( 'hum_email', 'info@hustleurmuscle.in' ) );
	if ( empty( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$subject = sprintf( '[Hustle Ur Muscle] New %s Submission from %s', ucfirst( $form_type ), $name );
	$body    = "Name: {$name}\nPhone: {$phone}\n";
	if ( $email ) {
		$body .= "Email: {$email}\n";
	}
	if ( $goal ) {
		$body .= "Goal / Program: {$goal}\n";
	}
	if ( $time ) {
		$body .= "Preferred Time: {$time}\n";
	}
	if ( $city ) {
		$body .= "City / Location: {$city}\n";
	}
	if ( $message ) {
		$body .= "\nMessage:\n{$message}\n";
	}

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $email ) {
		$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	}

	@wp_mail( $to, $subject, $body, $headers );

	wp_send_json_success(
		array(
			'message' => __( 'Thank you for reaching out! Coach Sagar Soma from Hustle Ur Muscle will contact you within 24 hours.', 'hustleurmuscle' ),
		)
	);
}
add_action( 'wp_ajax_hum_submit_form', 'hustleurmuscle_handle_form_submission' );
add_action( 'wp_ajax_nopriv_hum_submit_form', 'hustleurmuscle_handle_form_submission' );
