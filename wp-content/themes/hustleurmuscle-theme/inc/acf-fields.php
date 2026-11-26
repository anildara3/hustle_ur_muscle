<?php
/**
 * ACF Free Field Groups Registration (100% compatible with Advanced Custom Fields Free)
 * Uses only free field types: tab, text, textarea, wysiwyg, image, url, email, number, true_false.
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper: build one ACF field definition concisely.
 */
function hum_acf_field( $key, $label, $name, $type = 'text', $extra = array() ) {
	$base = array(
		'key'   => $key,
		'label' => $label,
		'name'  => $name,
		'type'  => $type,
	);
	if ( 'image' === $type && ! isset( $extra['return_format'] ) ) {
		$extra['return_format'] = 'url';
		$extra['preview_size']  = 'medium';
	}
	return array_merge( $base, $extra );
}

/**
 * Register all ACF Free local field groups on acf/init.
 */
function hum_register_acf_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// 1. HERO SLIDES (CPT: hum_slide)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_slide',
			'title'    => 'Hero Slide Details (Set Slide Background via Featured Image)',
			'fields'   => array(
				hum_acf_field( 'field_hum_slide_tag', 'Top Tagline', 'slide_tag', 'text', array( 'default_value' => 'COACH SAGAR SOMA — HUSTLE UR MUSCLE' ) ),
				hum_acf_field( 'field_hum_slide_title_top', 'Heading Line 1', 'slide_title_top', 'text', array( 'default_value' => 'KEEP YOUR' ) ),
				hum_acf_field( 'field_hum_slide_highlight', 'Heading Highlighted Line', 'slide_highlight', 'text', array( 'default_value' => 'BODY FIT & STRONG' ) ),
				hum_acf_field( 'field_hum_slide_desc', 'Description', 'slide_description', 'textarea', array( 'rows' => 3 ) ),
				hum_acf_field( 'field_hum_slide_bg', 'Optional Background Image Override', 'slide_bg_image', 'image', array( 'instructions' => 'You can upload here or use Featured Image on the right.' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'hum_slide',
					),
				),
			),
		)
	);

	// 2. PROGRAMS (CPT: hum_program)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_program',
			'title'    => 'Program Settings & Curriculum',
			'fields'   => array(
				hum_acf_field( 'field_hum_prog_tab_home', 'Home Card & Icon', '', 'tab' ),
				hum_acf_field( 'field_hum_prog_show_home', 'Show in Home Page 4-Card Section?', 'show_on_home', 'true_false', array( 'ui' => 1, 'default_value' => 0 ) ),
				hum_acf_field( 'field_hum_prog_home_icon', 'Home Card PNG Icon', 'home_icon', 'image', array( 'instructions' => 'Upload PNG icon (used when displayed on the Home page).' ) ),
				hum_acf_field( 'field_hum_prog_home_sub', 'Home Card Subtitle', 'home_subtitle', 'text', array( 'placeholder' => 'e.g. 12 WEEKS TO BUILD MUSCLE' ) ),
				hum_acf_field( 'field_hum_prog_home_desc', 'Home Card Short Description', 'home_excerpt', 'textarea', array( 'rows' => 2 ) ),

				hum_acf_field( 'field_hum_prog_tab_card', 'Programs Grid Card', '', 'tab' ),
				hum_acf_field( 'field_hum_prog_badge', 'Category Badge', 'program_badge', 'text', array( 'default_value' => 'HYPERTROPHY' ) ),
				hum_acf_field( 'field_hum_prog_duration', 'Duration Label', 'program_duration', 'text', array( 'default_value' => '12 WEEKS' ) ),
				hum_acf_field( 'field_hum_prog_price', 'Price', 'program_price', 'text', array( 'default_value' => '$129' ) ),
				hum_acf_field( 'field_hum_prog_unit', 'Price Unit', 'program_price_unit', 'text', array( 'default_value' => '/ plan' ) ),
				hum_acf_field( 'field_hum_prog_featured', 'Highlight Card with Red Border (VIP)?', 'program_featured_border', 'true_false', array( 'ui' => 1 ) ),
				hum_acf_field( 'field_hum_prog_features', 'Card Feature Bullets (1 per line)', 'program_features', 'textarea', array( 'rows' => 4 ) ),

				hum_acf_field( 'field_hum_prog_tab_detail', 'Detail Page Meta & Overview', '', 'tab' ),
				hum_acf_field( 'field_hum_prog_banner_tag', 'Detail Banner Tag', 'program_banner_tag', 'text', array( 'default_value' => '12-WEEK TRANSFORMATION' ) ),
				hum_acf_field( 'field_hum_prog_intensity', 'Intensity', 'program_intensity', 'text', array( 'default_value' => 'INTERMEDIATE+' ) ),
				hum_acf_field( 'field_hum_prog_frequency', 'Frequency', 'program_frequency', 'text', array( 'default_value' => '5 DAYS / WK' ) ),
				hum_acf_field( 'field_hum_prog_goal', 'Primary Goal', 'program_goal', 'text', array( 'default_value' => 'LEAN MUSCLE' ) ),
				hum_acf_field( 'field_hum_prog_quote', 'Coach Pullquote', 'program_quote', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_prog_quote_author', 'Quote Author', 'program_quote_author', 'text', array( 'default_value' => 'Coach Sagar Soma' ) ),
				hum_acf_field( 'field_hum_prog_included', 'What’s Included List (1 item per line, format: Title: Description)', 'program_included', 'textarea', array( 'rows' => 5 ) ),

				hum_acf_field( 'field_hum_prog_tab_phases', '3-Phase Curriculum', '', 'tab' ),
				hum_acf_field( 'field_hum_p1_badge', 'Phase 1 Badge', 'program_phase_1_badge', 'text', array( 'default_value' => 'PHASE 1: WEEKS 1 – 4' ) ),
				hum_acf_field( 'field_hum_p1_title', 'Phase 1 Title', 'program_phase_1_title', 'text' ),
				hum_acf_field( 'field_hum_p1_desc', 'Phase 1 Description', 'program_phase_1_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_p1_meta', 'Phase 1 Badges (comma separated)', 'program_phase_1_meta', 'text', array( 'placeholder' => 'Rep Range: 8–10, Volume: Moderate, RPE: 7–8' ) ),
				hum_acf_field( 'field_hum_p2_badge', 'Phase 2 Badge', 'program_phase_2_badge', 'text', array( 'default_value' => 'PHASE 2: WEEKS 5 – 8' ) ),
				hum_acf_field( 'field_hum_p2_title', 'Phase 2 Title', 'program_phase_2_title', 'text' ),
				hum_acf_field( 'field_hum_p2_desc', 'Phase 2 Description', 'program_phase_2_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_p2_meta', 'Phase 2 Badges (comma separated)', 'program_phase_2_meta', 'text' ),
				hum_acf_field( 'field_hum_p3_badge', 'Phase 3 Badge', 'program_phase_3_badge', 'text', array( 'default_value' => 'PHASE 3: WEEKS 9 – 12' ) ),
				hum_acf_field( 'field_hum_p3_title', 'Phase 3 Title', 'program_phase_3_title', 'text' ),
				hum_acf_field( 'field_hum_p3_desc', 'Phase 3 Description', 'program_phase_3_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_p3_meta', 'Phase 3 Badges (comma separated)', 'program_phase_3_meta', 'text' ),

				hum_acf_field( 'field_hum_prog_tab_sidebar', 'Sidebar, Review & FAQs', '', 'tab' ),
				hum_acf_field( 'field_hum_prog_sidebar_desc', 'Sidebar Intro Text', 'sidebar_cta_desc', 'text', array( 'default_value' => 'Complete 12-Week Access & Personalized Coaching Blueprint.' ) ),
				hum_acf_field( 'field_hum_prog_sidebar_inc', 'Sidebar What You Receive (1 per line)', 'sidebar_includes', 'textarea', array( 'rows' => 4 ) ),
				hum_acf_field( 'field_hum_prog_rev_name', 'Client Review Name', 'program_review_name', 'text', array( 'default_value' => 'Steve Rogers' ) ),
				hum_acf_field( 'field_hum_prog_rev_role', 'Client Review Subtitle', 'program_review_role', 'text', array( 'default_value' => 'Strength Athlete • Gained 9 lbs Lean Mass' ) ),
				hum_acf_field( 'field_hum_prog_rev_text', 'Client Review Quote', 'program_review_text', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_prog_rev_img', 'Client Review Photo', 'program_review_photo', 'image' ),
				hum_acf_field( 'field_hum_prog_faq1_q', 'Program FAQ 1 Question', 'program_faq_1_q', 'text' ),
				hum_acf_field( 'field_hum_prog_faq1_a', 'Program FAQ 1 Answer', 'program_faq_1_a', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_prog_faq2_q', 'Program FAQ 2 Question', 'program_faq_2_q', 'text' ),
				hum_acf_field( 'field_hum_prog_faq2_a', 'Program FAQ 2 Answer', 'program_faq_2_a', 'textarea', array( 'rows' => 2 ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'hum_program',
					),
				),
			),
		)
	);

	// 3. TESTIMONIALS (CPT: hum_testimonial)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_testimonial',
			'title'    => 'Client Testimonial Details (Use Title for Client Name & Featured Image for Avatar)',
			'fields'   => array(
				hum_acf_field( 'field_hum_test_role', 'Client Result / Subtitle', 'client_role', 'text', array( 'placeholder' => 'Client • Lost 16 lbs' ) ),
				hum_acf_field( 'field_hum_test_quote', 'Testimonial Quote', 'testimonial_quote', 'textarea', array( 'rows' => 3 ) ),
				hum_acf_field( 'field_hum_test_stars', 'Star Rating (1–5)', 'rating_stars', 'number', array( 'default_value' => 5, 'min' => 1, 'max' => 5 ) ),
				hum_acf_field( 'field_hum_test_avatar', 'Optional Avatar Override', 'client_avatar', 'image' ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'hum_testimonial',
					),
				),
			),
		)
	);

	// 4. FAQs (CPT: hum_faq)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_faq',
			'title'    => 'FAQ Display Settings (Use Title for Question & Editor for Answer)',
			'fields'   => array(
				hum_acf_field( 'field_hum_faq_on_page', 'Show on FAQs Page?', 'show_in_faqs_page', 'true_false', array( 'ui' => 1, 'default_value' => 1 ) ),
				hum_acf_field( 'field_hum_faq_on_contact', 'Show on Contact Page Accordion?', 'show_on_contact', 'true_false', array( 'ui' => 1, 'default_value' => 0 ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'hum_faq',
					),
				),
			),
		)
	);

	// 5. TRAINERS (CPT: hum_trainer)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_trainer',
			'title'    => 'Trainer Details (Use Title for Name & Featured Image for Photo)',
			'fields'   => array(
				hum_acf_field( 'field_hum_tr_role', 'Trainer Role / Title', 'trainer_role', 'text' ),
				hum_acf_field( 'field_hum_tr_bio', 'Short Specialty Bio', 'trainer_bio', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_tr_ig', 'Instagram URL', 'trainer_instagram', 'url' ),
				hum_acf_field( 'field_hum_tr_fb', 'Facebook URL', 'trainer_facebook', 'url' ),
				hum_acf_field( 'field_hum_tr_wa', 'WhatsApp URL (optional)', 'trainer_whatsapp', 'url' ),
				hum_acf_field( 'field_hum_tr_photo', 'Optional Photo Override', 'trainer_photo', 'image' ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'hum_trainer',
					),
				),
			),
		)
	);

	// 6. HOME PAGE & GLOBAL SITE SETTINGS (Front Page)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_home_page',
			'title'    => 'Home Page Content & Global Header/Footer Settings',
			'fields'   => array(
				hum_acf_field( 'field_hum_tab_global', 'Global Contact, Header & Social', '', 'tab' ),
				hum_acf_field( 'field_hum_site_logo', 'Header / Footer Logo Image', 'site_logo', 'image' ),
				hum_acf_field( 'field_hum_site_phone', 'Phone Number', 'site_phone', 'text', array( 'default_value' => '9948660025' ) ),
				hum_acf_field( 'field_hum_site_email', 'Email Address', 'site_email', 'email', array( 'default_value' => 'info@hustleurmuscle.in' ) ),
				hum_acf_field( 'field_hum_site_club', 'Footer Club Label', 'site_club_name', 'text', array( 'default_value' => 'Hustle Ur Muscle Training Club' ) ),
				hum_acf_field( 'field_hum_site_wa', 'WhatsApp URL', 'site_whatsapp_url', 'url', array( 'default_value' => 'https://wa.me/' ) ),
				hum_acf_field( 'field_hum_site_ig', 'Instagram URL', 'site_instagram_url', 'url', array( 'default_value' => 'https://www.instagram.com/ssagarsomahustleurmuscle/' ) ),
				hum_acf_field( 'field_hum_site_fb', 'Facebook URL', 'site_facebook_url', 'url', array( 'default_value' => 'https://www.facebook.com/hustleurmuscle/' ) ),
				hum_acf_field( 'field_hum_site_tw', 'Twitter / X URL', 'site_twitter_url', 'url', array( 'default_value' => 'https://twitter.com' ) ),
				hum_acf_field( 'field_hum_site_yt', 'YouTube URL', 'site_youtube_url', 'url', array( 'default_value' => 'https://youtube.com' ) ),
				hum_acf_field( 'field_hum_modal_cf7', 'Booking Modal Contact Form 7 Shortcode', 'modal_cf7_shortcode', 'text', array( 'placeholder' => '[contact-form-7 id="..." title="Booking Modal Form"]' ) ),

				hum_acf_field( 'field_hum_tab_reels', 'Footer Instagram Top 6 Reels', '', 'tab' ),
				hum_acf_field( 'field_hum_reel_1', 'Reel 1 URL', 'site_reel_1', 'url' ),
				hum_acf_field( 'field_hum_reel_1_img', 'Reel 1 Thumbnail', 'site_reel_1_img', 'image' ),
				hum_acf_field( 'field_hum_reel_2', 'Reel 2 URL', 'site_reel_2', 'url' ),
				hum_acf_field( 'field_hum_reel_2_img', 'Reel 2 Thumbnail', 'site_reel_2_img', 'image' ),
				hum_acf_field( 'field_hum_reel_3', 'Reel 3 URL', 'site_reel_3', 'url' ),
				hum_acf_field( 'field_hum_reel_3_img', 'Reel 3 Thumbnail', 'site_reel_3_img', 'image' ),
				hum_acf_field( 'field_hum_reel_4', 'Reel 4 URL', 'site_reel_4', 'url' ),
				hum_acf_field( 'field_hum_reel_4_img', 'Reel 4 Thumbnail', 'site_reel_4_img', 'image' ),
				hum_acf_field( 'field_hum_reel_5', 'Reel 5 URL', 'site_reel_5', 'url' ),
				hum_acf_field( 'field_hum_reel_5_img', 'Reel 5 Thumbnail', 'site_reel_5_img', 'image' ),
				hum_acf_field( 'field_hum_reel_6', 'Reel 6 URL', 'site_reel_6', 'url' ),
				hum_acf_field( 'field_hum_reel_6_img', 'Reel 6 Thumbnail', 'site_reel_6_img', 'image' ),

				hum_acf_field( 'field_hum_tab_about', 'Section 2: About Gym', '', 'tab' ),
				hum_acf_field( 'field_hum_ha_tag', 'Section Tag', 'home_about_tag', 'text', array( 'default_value' => 'TRAIN WITH SAGAR SOMA' ) ),
				hum_acf_field( 'field_hum_ha_t1', 'Title Line 1', 'home_about_title_1', 'text', array( 'default_value' => 'FULL-SERVICE' ) ),
				hum_acf_field( 'field_hum_ha_t2', 'Title Highlight Line 2', 'home_about_title_2', 'text', array( 'default_value' => 'FITNESS CLUB & GYM' ) ),
				hum_acf_field( 'field_hum_ha_lead', 'Lead Heading', 'home_about_lead', 'text', array( 'default_value' => 'Welcome to Hustle Ur Muscle training program.' ) ),
				hum_acf_field( 'field_hum_ha_desc', 'Description', 'home_about_desc', 'textarea', array( 'rows' => 3 ) ),
				hum_acf_field( 'field_hum_ha_img1', 'Main Collage Photo', 'home_about_img_1', 'image' ),
				hum_acf_field( 'field_hum_ha_img2', 'Overlay Coach Photo', 'home_about_img_2', 'image' ),
				hum_acf_field( 'field_hum_ha_exp', 'Experience Years Number', 'home_about_years', 'number', array( 'default_value' => 12 ) ),

				hum_acf_field( 'field_hum_tab_srv', 'Section 3: Services Header', '', 'tab' ),
				hum_acf_field( 'field_hum_hs_tag', 'Section Tag', 'home_services_tag', 'text', array( 'default_value' => 'HEALTHY LIFE' ) ),
				hum_acf_field( 'field_hum_hs_title', 'Section Title', 'home_services_title', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_hs_div', 'Divider Name', 'home_services_divider', 'text', array( 'default_value' => 'SAGAR SOMA' ) ),

				hum_acf_field( 'field_hum_tab_goal', 'Section 4: Goal & Mission', '', 'tab' ),
				hum_acf_field( 'field_hum_hg_tag', 'Section Tag', 'home_goal_tag', 'text', array( 'default_value' => 'ABOUT COACH SAGAR SOMA' ) ),
				hum_acf_field( 'field_hum_hg_title', 'Goal Title', 'home_goal_title', 'text', array( 'default_value' => 'OUR GOAL IS TO MAKE YOU STRONG & HEALTHY' ) ),
				hum_acf_field( 'field_hum_hg_lead', 'Goal Description', 'home_goal_lead', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_hg_list', 'Checklist Items (1 per line)', 'home_goal_checklist', 'textarea', array( 'rows' => 3 ) ),
				hum_acf_field( 'field_hum_hg_img1', 'Gallery Left Image', 'home_goal_img_1', 'image' ),
				hum_acf_field( 'field_hum_hg_img2', 'Gallery Right Image', 'home_goal_img_2', 'image' ),

				hum_acf_field( 'field_hum_tab_banners', 'Section 5: Dual Banners', '', 'tab' ),
				hum_acf_field( 'field_hum_hb1_tag', 'Left Banner Tag', 'home_banner_1_tag', 'text', array( 'default_value' => 'CUSTOM NUTRITION' ) ),
				hum_acf_field( 'field_hum_hb1_title', 'Left Banner Title', 'home_banner_1_title', 'text', array( 'default_value' => 'WANT TO START NOW?' ) ),
				hum_acf_field( 'field_hum_hb1_desc', 'Left Banner Description', 'home_banner_1_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_hb1_btn', 'Left Banner Button Text', 'home_banner_1_btn', 'text', array( 'default_value' => 'GET A PLAN' ) ),
				hum_acf_field( 'field_hum_hb1_img', 'Left Banner Background Image', 'home_banner_1_img', 'image' ),
				hum_acf_field( 'field_hum_hb2_tag', 'Right Banner Tag', 'home_banner_2_tag', 'text', array( 'default_value' => 'JOIN OUR TEAM' ) ),
				hum_acf_field( 'field_hum_hb2_title', 'Right Banner Title', 'home_banner_2_title', 'text', array( 'default_value' => 'WANT TO WORK WITH US?' ) ),
				hum_acf_field( 'field_hum_hb2_desc', 'Right Banner Description', 'home_banner_2_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_hb2_btn', 'Right Banner Button Text', 'home_banner_2_btn', 'text', array( 'default_value' => 'JOIN TEAM' ) ),
				hum_acf_field( 'field_hum_hb2_img', 'Right Banner Background Image', 'home_banner_2_img', 'image' ),

				hum_acf_field( 'field_hum_tab_hc', 'Section 6–8: Testimonials, Contact CF7 & Blog', '', 'tab' ),
				hum_acf_field( 'field_hum_ht_tag', 'Testimonials Tag', 'home_test_tag', 'text', array( 'default_value' => 'TESTIMONIALS' ) ),
				hum_acf_field( 'field_hum_ht_title', 'Testimonials Title', 'home_test_title', 'text', array( 'default_value' => 'OUR CLIENTS CHOOSE US BECAUSE WE ARE THE BEST' ) ),
				hum_acf_field( 'field_hum_hc_img', 'Contact Section Side Photo', 'home_contact_img', 'image' ),
				hum_acf_field( 'field_hum_hc_tag', 'Contact Section Tag', 'home_contact_tag', 'text', array( 'default_value' => 'SEND US A LINE' ) ),
				hum_acf_field( 'field_hum_hc_title', 'Contact Section Heading', 'home_contact_title', 'text', array( 'default_value' => 'HAVE QUESTIONS? GET IN TOUCH WITH SAGAR!' ) ),
				hum_acf_field( 'field_hum_hc_cf7', 'Home Contact Form 7 Shortcode', 'home_cf7_shortcode', 'text', array( 'placeholder' => '[contact-form-7 id="..." title="Home Consultation Form"]' ) ),
				hum_acf_field( 'field_hum_hb_tag', 'Blog Section Tag', 'home_blog_tag', 'text', array( 'default_value' => 'LATEST NEWS' ) ),
				hum_acf_field( 'field_hum_hb_title', 'Blog Section Title', 'home_blog_title', 'text', array( 'default_value' => 'LATEST ARTICLES' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
		)
	);

	// 7. ABOUT US PAGE (page-about.php)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_about_page',
			'title'    => 'About Page Sections & 4 Pillars (PNG Icons)',
			'fields'   => array(
				hum_acf_field( 'field_hum_ab_tab_banner', 'Banner & Story', '', 'tab' ),
				hum_acf_field( 'field_hum_ab_btag', 'Banner Tag', 'about_banner_tag', 'text', array( 'default_value' => 'WHO WE ARE' ) ),
				hum_acf_field( 'field_hum_ab_btitle', 'Banner Title', 'about_banner_title', 'text', array( 'default_value' => 'ABOUT HUSTLE UR MUSCLE' ) ),
				hum_acf_field( 'field_hum_ab_bdesc', 'Banner Description', 'about_banner_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_ab_bimg', 'Banner Background Image', 'about_banner_img', 'image' ),
				hum_acf_field( 'field_hum_ab_stag', 'Story Tag', 'about_story_tag', 'text', array( 'default_value' => 'THE HUSTLE STORY' ) ),
				hum_acf_field( 'field_hum_ab_st1', 'Story Title Line 1', 'about_story_title_1', 'text', array( 'default_value' => 'WE ARE PASSIONATE ABOUT' ) ),
				hum_acf_field( 'field_hum_ab_st2', 'Story Title Highlight', 'about_story_title_2', 'text', array( 'default_value' => 'REAL TRANSFORMATION' ) ),
				hum_acf_field( 'field_hum_ab_slead', 'Story Lead', 'about_story_lead', 'text', array( 'default_value' => 'Founded by Head Coach Sagar Soma' ) ),
				hum_acf_field( 'field_hum_ab_sp1', 'Story Paragraph 1', 'about_story_p1', 'textarea', array( 'rows' => 3 ) ),
				hum_acf_field( 'field_hum_ab_sp2', 'Story Paragraph 2', 'about_story_p2', 'textarea', array( 'rows' => 3 ) ),
				hum_acf_field( 'field_hum_ab_schecks', 'Story 4 Highlights (1 per line)', 'about_story_checks', 'textarea', array( 'rows' => 4 ) ),
				hum_acf_field( 'field_hum_ab_img1', 'Story Main Image', 'about_story_img_1', 'image' ),
				hum_acf_field( 'field_hum_ab_img2', 'Story Overlay Image', 'about_story_img_2', 'image' ),

				hum_acf_field( 'field_hum_ab_tab_stats', 'Stats Counters (4)', '', 'tab' ),
				hum_acf_field( 'field_hum_st1_n', 'Stat 1 Number', 'stat_1_num', 'number', array( 'default_value' => 1500 ) ),
				hum_acf_field( 'field_hum_st1_s', 'Stat 1 Suffix', 'stat_1_suffix', 'text', array( 'default_value' => '+' ) ),
				hum_acf_field( 'field_hum_st1_l', 'Stat 1 Label', 'stat_1_label', 'text', array( 'default_value' => 'Clients Transformed' ) ),
				hum_acf_field( 'field_hum_st2_n', 'Stat 2 Number', 'stat_2_num', 'number', array( 'default_value' => 12 ) ),
				hum_acf_field( 'field_hum_st2_s', 'Stat 2 Suffix', 'stat_2_suffix', 'text', array( 'default_value' => '+' ) ),
				hum_acf_field( 'field_hum_st2_l', 'Stat 2 Label', 'stat_2_label', 'text', array( 'default_value' => 'Years of Coaching' ) ),
				hum_acf_field( 'field_hum_st3_n', 'Stat 3 Number', 'stat_3_num', 'number', array( 'default_value' => 98 ) ),
				hum_acf_field( 'field_hum_st3_s', 'Stat 3 Suffix', 'stat_3_suffix', 'text', array( 'default_value' => '%' ) ),
				hum_acf_field( 'field_hum_st3_l', 'Stat 3 Label', 'stat_3_label', 'text', array( 'default_value' => 'Success Rate' ) ),
				hum_acf_field( 'field_hum_st4_n', 'Stat 4 Number', 'stat_4_num', 'number', array( 'default_value' => 2000 ) ),
				hum_acf_field( 'field_hum_st4_s', 'Stat 4 Suffix', 'stat_4_suffix', 'text', array( 'default_value' => 'm²' ) ),
				hum_acf_field( 'field_hum_st4_l', 'Stat 4 Label', 'stat_4_label', 'text', array( 'default_value' => 'Modern Training Zone' ) ),

				hum_acf_field( 'field_hum_ab_tab_pil', '4 Philosophy Pillars (PNG Icons)', '', 'tab' ),
				hum_acf_field( 'field_hum_pil_tag', 'Pillars Section Tag', 'pillars_tag', 'text', array( 'default_value' => 'WHY HUSTLE UR MUSCLE' ) ),
				hum_acf_field( 'field_hum_pil_title', 'Pillars Section Title', 'pillars_title', 'text', array( 'default_value' => 'THE 4 PILLARS OF OUR ATHLETIC PHILOSOPHY' ) ),
				hum_acf_field( 'field_hum_p1_icon', 'Pillar 1 PNG Icon', 'pillar_1_icon', 'image' ),
				hum_acf_field( 'field_hum_p1_title', 'Pillar 1 Title', 'pillar_1_title', 'text', array( 'default_value' => 'SCIENCE-BASED DESIGN' ) ),
				hum_acf_field( 'field_hum_p1_desc', 'Pillar 1 Text', 'pillar_1_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_p2_icon', 'Pillar 2 PNG Icon', 'pillar_2_icon', 'image' ),
				hum_acf_field( 'field_hum_p2_title', 'Pillar 2 Title', 'pillar_2_title', 'text', array( 'default_value' => 'CUSTOM MACRO DIETS' ) ),
				hum_acf_field( 'field_hum_p2_desc', 'Pillar 2 Text', 'pillar_2_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_p3_icon', 'Pillar 3 PNG Icon', 'pillar_3_icon', 'image' ),
				hum_acf_field( 'field_hum_p3_title', 'Pillar 3 Title', 'pillar_3_title', 'text', array( 'default_value' => 'WEEKLY AUDITS' ) ),
				hum_acf_field( 'field_hum_p3_desc', 'Pillar 3 Text', 'pillar_3_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_p4_icon', 'Pillar 4 PNG Icon', 'pillar_4_icon', 'image' ),
				hum_acf_field( 'field_hum_p4_title', 'Pillar 4 Title', 'pillar_4_title', 'text', array( 'default_value' => 'UNSTOPPABLE MOTIVATION' ) ),
				hum_acf_field( 'field_hum_p4_desc', 'Pillar 4 Text', 'pillar_4_desc', 'textarea', array( 'rows' => 2 ) ),

				hum_acf_field( 'field_hum_ab_tab_cta', 'Video CTA Banner', '', 'tab' ),
				hum_acf_field( 'field_hum_ab_vurl', 'Video Play URL', 'about_video_url', 'url', array( 'default_value' => 'https://www.youtube.com' ) ),
				hum_acf_field( 'field_hum_ab_vtitle', 'Video Banner Heading', 'about_video_title', 'text', array( 'default_value' => 'PUSH BEYOND YOUR LIMITS WITH COACH SAGAR SOMA' ) ),
				hum_acf_field( 'field_hum_ab_vdesc', 'Video Banner Subtext', 'about_video_desc', 'text', array( 'default_value' => 'Join Hustle Ur Muscle today and unlock the body and mindset you have always envisioned.' ) ),
				hum_acf_field( 'field_hum_ab_vimg', 'Video Banner Background Image', 'about_video_img', 'image' ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-about.php',
					),
				),
			),
		)
	);

	// 8. CONTACT PAGE (page-contact.php)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_contact_page',
			'title'    => 'Contact Page Content, PNG Icons, CF7 Form & Map',
			'fields'   => array(
				hum_acf_field( 'field_hum_cp_tab_banner', 'Banner & 3 Info Cards', '', 'tab' ),
				hum_acf_field( 'field_hum_cp_btag', 'Banner Tag', 'contact_banner_tag', 'text', array( 'default_value' => 'REACH OUT ANYTIME' ) ),
				hum_acf_field( 'field_hum_cp_btitle', 'Banner Title', 'contact_banner_title', 'text', array( 'default_value' => 'CONTACT COACH SAGAR SOMA' ) ),
				hum_acf_field( 'field_hum_cp_bdesc', 'Banner Description', 'contact_banner_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_cp_c1_icon', 'Location PNG Icon', 'contact_loc_icon', 'image' ),
				hum_acf_field( 'field_hum_cp_c1_title', 'Location Card Title', 'contact_loc_title', 'text', array( 'default_value' => 'OUR LOCATION' ) ),
				hum_acf_field( 'field_hum_cp_c1_line1', 'Address Line 1', 'contact_loc_line1', 'text', array( 'default_value' => '123 Fitness Boulevard, Suite 500' ) ),
				hum_acf_field( 'field_hum_cp_c1_line2', 'Address Line 2', 'contact_loc_line2', 'text', array( 'default_value' => 'New York, NY 10001' ) ),
				hum_acf_field( 'field_hum_cp_c2_icon', 'Phone PNG Icon', 'contact_phone_icon', 'image' ),
				hum_acf_field( 'field_hum_cp_c2_sub', 'Phone Card Subtext', 'contact_phone_subtext', 'text', array( 'default_value' => 'Instant Coach Hotline' ) ),
				hum_acf_field( 'field_hum_cp_c3_icon', 'Email PNG Icon', 'contact_email_icon', 'image' ),

				hum_acf_field( 'field_hum_cp_tab_coach', 'Coach Card & CF7 Form', '', 'tab' ),
				hum_acf_field( 'field_hum_cp_coach_img', 'Coach Avatar', 'contact_coach_photo', 'image' ),
				hum_acf_field( 'field_hum_cp_coach_quote', 'Coach Personal Quote', 'contact_coach_quote', 'textarea', array( 'rows' => 3 ) ),
				hum_acf_field( 'field_hum_cp_cf7', 'Contact Page CF7 Shortcode', 'contact_cf7_shortcode', 'text', array( 'placeholder' => '[contact-form-7 id="..." title="Contact Page Inquiry Form"]' ) ),

				hum_acf_field( 'field_hum_cp_tab_map', 'Google Map & FAQ Heading', '', 'tab' ),
				hum_acf_field( 'field_hum_cp_map_embed', 'Google Maps Embed URL', 'contact_map_url', 'url' ),
				hum_acf_field( 'field_hum_cp_map_dir', 'Google Maps Directions Link', 'contact_directions_url', 'url', array( 'default_value' => 'https://maps.google.com' ) ),
				hum_acf_field( 'field_hum_cp_map_note', 'Facility Parking Note', 'contact_parking_note', 'text', array( 'default_value' => 'Ample parking & locker room facilities available' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-contact.php',
					),
				),
			),
		)
	);

	// 9. PROGRAMS PAGE & FAQs PAGE BANNERS
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_programs_page',
			'title'    => 'Programs Page Settings',
			'fields'   => array(
				hum_acf_field( 'field_hum_prp_btag', 'Banner Tag', 'programs_banner_tag', 'text', array( 'default_value' => 'PROVEN METHODS' ) ),
				hum_acf_field( 'field_hum_prp_btitle', 'Banner Title', 'programs_banner_title', 'text', array( 'default_value' => 'TRAINING PROGRAMS' ) ),
				hum_acf_field( 'field_hum_prp_bdesc', 'Banner Description', 'programs_banner_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_prp_stag', 'Grid Tag', 'programs_grid_tag', 'text', array( 'default_value' => 'INDIVIDUAL PLANS' ) ),
				hum_acf_field( 'field_hum_prp_stitle', 'Grid Title', 'programs_grid_title', 'text', array( 'default_value' => 'DEVELOPED WITH CARE AND YEARS OF EXPERIENCE' ) ),
				hum_acf_field( 'field_hum_prp_ctat', 'Bottom CTA Title', 'programs_cta_title', 'text', array( 'default_value' => 'NOT SURE WHICH PROGRAM FITS YOUR BODY?' ) ),
				hum_acf_field( 'field_hum_prp_ctad', 'Bottom CTA Text', 'programs_cta_desc', 'textarea', array( 'rows' => 2 ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-programs.php',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_faqs_page',
			'title'    => 'FAQs Page Settings',
			'fields'   => array(
				hum_acf_field( 'field_hum_fqp_btag', 'Banner Tag', 'faqs_banner_tag', 'text', array( 'default_value' => 'HELP & ANSWERS' ) ),
				hum_acf_field( 'field_hum_fqp_btitle', 'Banner Title', 'faqs_banner_title', 'text', array( 'default_value' => 'FREQUENTLY ASKED QUESTIONS' ) ),
				hum_acf_field( 'field_hum_fqp_bdesc', 'Banner Description', 'faqs_banner_desc', 'textarea', array( 'rows' => 2 ) ),
				hum_acf_field( 'field_hum_fqp_stag', 'Section Tag', 'faqs_section_tag', 'text', array( 'default_value' => 'COMMON INQUIRIES' ) ),
				hum_acf_field( 'field_hum_fqp_stitle', 'Section Title', 'faqs_section_title', 'text', array( 'default_value' => 'ANSWERS FROM COACH SAGAR SOMA' ) ),
				hum_acf_field( 'field_hum_fqp_ctat', 'Still Have Questions Title', 'faqs_cta_title', 'text', array( 'default_value' => 'STILL HAVE QUESTIONS?' ) ),
				hum_acf_field( 'field_hum_fqp_ctad', 'Still Have Questions Text', 'faqs_cta_desc', 'textarea', array( 'rows' => 2 ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-faqs.php',
					),
				),
			),
		)
	);

	// 10. FOOTER (CPT: hum_footer)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_footer',
			'title'    => 'Footer Content & Links (Most recent / lowest Order published Footer is active site-wide)',
			'fields'   => array(
				hum_acf_field( 'field_hum_ft_tab_banner', 'Top CTA Banner', '', 'tab' ),
				hum_acf_field( 'field_hum_ft_logo', 'Footer Brand Logo', 'footer_logo', 'image', array( 'instructions' => 'Leave empty to use Global Header/Footer Logo or default theme logo.' ) ),
				hum_acf_field( 'field_hum_ft_heading', 'Banner Heading', 'footer_banner_heading', 'textarea', array( 'rows' => 2, 'default_value' => "JOIN HUSTLE UR MUSCLE TO\nSTART A NEW LIFE", 'instructions' => 'Use a new line for the line break.' ) ),
				hum_acf_field( 'field_hum_ft_founder_lbl', 'Founder Prefix Label', 'footer_founder_label', 'text', array( 'default_value' => 'HEAD COACH & FOUNDER:' ) ),
				hum_acf_field( 'field_hum_ft_founder_name', 'Founder Highlighted Name', 'footer_founder_name', 'text', array( 'default_value' => 'SAGAR SOMA' ) ),
				hum_acf_field( 'field_hum_ft_cta_text', 'CTA Button Text', 'footer_cta_text', 'text', array( 'default_value' => 'JOIN NOW' ) ),
				hum_acf_field( 'field_hum_ft_cta_url', 'CTA Button Custom URL (optional)', 'footer_cta_url', 'text', array( 'instructions' => 'Leave empty to open the Booking Consultation modal.' ) ),

				hum_acf_field( 'field_hum_ft_tab_about', 'About & Contact Info', '', 'tab' ),
				hum_acf_field( 'field_hum_ft_about_title', 'Column Title', 'footer_about_title', 'text', array( 'default_value' => 'ABOUT HUSTLE UR MUSCLE' ) ),
				hum_acf_field( 'field_hum_ft_about_text', 'About Description', 'footer_about_text', 'textarea', array( 'rows' => 3, 'default_value' => 'Hustle Ur Muscle, founded by Coach Sagar Soma, is dedicated to scientific strength conditioning, body transformation, and empowering individuals with peak athletic discipline.' ) ),
				hum_acf_field( 'field_hum_ft_email', 'Email Address', 'footer_email', 'email', array( 'default_value' => 'info@hustleurmuscle.in' ) ),
				hum_acf_field( 'field_hum_ft_phone', 'Phone Number', 'footer_phone', 'text', array( 'default_value' => '9948660025' ) ),
				hum_acf_field( 'field_hum_ft_location', 'Club / Location Label', 'footer_location', 'text', array( 'default_value' => 'Hustle Ur Muscle Training Club' ) ),

				hum_acf_field( 'field_hum_ft_tab_links', 'Social & Quick Links', '', 'tab' ),
				hum_acf_field( 'field_hum_ft_social_title', 'Social Column Title', 'footer_social_title', 'text', array( 'default_value' => 'SOCIAL' ) ),
				hum_acf_field( 'field_hum_ft_fb', 'Facebook URL', 'footer_facebook_url', 'url', array( 'default_value' => 'https://www.facebook.com/hustleurmuscle/' ) ),
				hum_acf_field( 'field_hum_ft_ig', 'Instagram URL', 'footer_instagram_url', 'url', array( 'default_value' => 'https://www.instagram.com/ssagarsomahustleurmuscle/' ) ),
				hum_acf_field( 'field_hum_ft_tw', 'Twitter / X URL', 'footer_twitter_url', 'url', array( 'default_value' => 'https://twitter.com' ) ),
				hum_acf_field( 'field_hum_ft_yt', 'YouTube URL', 'footer_youtube_url', 'url', array( 'default_value' => 'https://youtube.com' ) ),
				hum_acf_field( 'field_hum_ft_links_title', 'Quick Links Column Title', 'footer_links_title', 'text', array( 'default_value' => 'QUICK LINKS' ) ),
				hum_acf_field( 'field_hum_ft_quick_links', 'Quick Links (1 per line: Label | URL)', 'footer_quick_links', 'textarea', array( 'rows' => 6, 'instructions' => 'Format: Label | /path/ or https://... Leave empty to use the WordPress "Footer Quick Links" menu.' ) ),

				hum_acf_field( 'field_hum_ft_tab_ig', 'Instagram Grid (6)', '', 'tab' ),
				hum_acf_field( 'field_hum_ft_ig_title', 'Instagram Column Title', 'footer_instagram_title', 'text', array( 'default_value' => 'INSTAGRAM' ) ),
				hum_acf_field( 'field_hum_ft_r1', 'Reel 1 URL', 'footer_reel_1', 'url' ),
				hum_acf_field( 'field_hum_ft_r1_img', 'Reel 1 Thumbnail', 'footer_reel_1_img', 'image' ),
				hum_acf_field( 'field_hum_ft_r2', 'Reel 2 URL', 'footer_reel_2', 'url' ),
				hum_acf_field( 'field_hum_ft_r2_img', 'Reel 2 Thumbnail', 'footer_reel_2_img', 'image' ),
				hum_acf_field( 'field_hum_ft_r3', 'Reel 3 URL', 'footer_reel_3', 'url' ),
				hum_acf_field( 'field_hum_ft_r3_img', 'Reel 3 Thumbnail', 'footer_reel_3_img', 'image' ),
				hum_acf_field( 'field_hum_ft_r4', 'Reel 4 URL', 'footer_reel_4', 'url' ),
				hum_acf_field( 'field_hum_ft_r4_img', 'Reel 4 Thumbnail', 'footer_reel_4_img', 'image' ),
				hum_acf_field( 'field_hum_ft_r5', 'Reel 5 URL', 'footer_reel_5', 'url' ),
				hum_acf_field( 'field_hum_ft_r5_img', 'Reel 5 Thumbnail', 'footer_reel_5_img', 'image' ),
				hum_acf_field( 'field_hum_ft_r6', 'Reel 6 URL', 'footer_reel_6', 'url' ),
				hum_acf_field( 'field_hum_ft_r6_img', 'Reel 6 Thumbnail', 'footer_reel_6_img', 'image' ),

				hum_acf_field( 'field_hum_ft_tab_bottom', 'Bottom Copyright & Legal', '', 'tab' ),
				hum_acf_field( 'field_hum_ft_copyright', 'Copyright Text', 'footer_copyright', 'text', array( 'default_value' => 'Hustle Ur Muscle © {year}. All rights reserved. Directed by Coach Sagar Soma.', 'instructions' => 'Use {year} to insert the current year automatically.' ) ),
				hum_acf_field( 'field_hum_ft_priv_lbl', 'Privacy Link Label', 'footer_privacy_label', 'text', array( 'default_value' => 'Privacy Policy' ) ),
				hum_acf_field( 'field_hum_ft_priv_url', 'Privacy Link Custom URL (optional)', 'footer_privacy_url', 'text', array( 'instructions' => 'Leave empty to link to the Privacy Policy page automatically.' ) ),
				hum_acf_field( 'field_hum_ft_terms_lbl', 'Terms Link Label', 'footer_terms_label', 'text', array( 'default_value' => 'Terms & Conditions' ) ),
				hum_acf_field( 'field_hum_ft_terms_url', 'Terms Link Custom URL (optional)', 'footer_terms_url', 'text', array( 'instructions' => 'Leave empty to link to the Terms & Conditions page automatically.' ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'hum_footer',
					),
				),
			),
		)
	);

	// 11. HEADER (CPT: hum_header)
	acf_add_local_field_group(
		array(
			'key'      => 'group_hum_header',
			'title'    => 'Header Content & Actions (Most recent / lowest Order published Header is active; Primary Menu is managed in Appearance → Menus)',
			'fields'   => array(
				hum_acf_field( 'field_hum_hd_tab_brand', 'Brand & Logo', '', 'tab' ),
				hum_acf_field( 'field_hum_hd_logo', 'Header Logo Image', 'header_logo', 'image', array( 'instructions' => 'Leave empty to use Global Header/Footer Logo or default theme logo.' ) ),
				hum_acf_field( 'field_hum_hd_favicon', 'Site Favicon Override', 'header_favicon', 'image', array( 'instructions' => 'Leave empty to use default favicon.png.' ) ),
				hum_acf_field( 'field_hum_hd_brand_main', 'Brand Title (Main)', 'header_brand_main', 'text', array( 'default_value' => 'HUSTLE UR' ) ),
				hum_acf_field( 'field_hum_hd_brand_hl', 'Brand Title (Highlighted)', 'header_brand_highlight', 'text', array( 'default_value' => 'MUSCLE' ) ),
				hum_acf_field( 'field_hum_hd_brand_sub', 'Brand Subtext', 'header_brand_subtext', 'text', array( 'default_value' => 'BY SAGAR SOMA' ) ),
				hum_acf_field( 'field_hum_hd_brand_url', 'Brand Link Custom URL (optional)', 'header_brand_url', 'text', array( 'instructions' => 'Leave empty for default (#hero on Home, Home URL on inner pages).' ) ),

				hum_acf_field( 'field_hum_hd_tab_actions', 'Navbar Actions & CTA', '', 'tab' ),
				hum_acf_field( 'field_hum_hd_ig', 'Instagram URL', 'header_instagram_url', 'url', array( 'default_value' => 'https://www.instagram.com/ssagarsomahustleurmuscle/', 'instructions' => 'Clear to hide Instagram icon in navbar and side quick tools.' ) ),
				hum_acf_field( 'field_hum_hd_fb', 'Facebook URL', 'header_facebook_url', 'url', array( 'default_value' => 'https://www.facebook.com/hustleurmuscle/', 'instructions' => 'Clear to hide Facebook icon in navbar and side quick tools.' ) ),
				hum_acf_field( 'field_hum_hd_search', 'Show Search Button?', 'header_show_search', 'true_false', array( 'ui' => 1, 'default_value' => 1 ) ),
				hum_acf_field( 'field_hum_hd_bmi', 'Show BMI Calculator Button?', 'header_show_bmi', 'true_false', array( 'ui' => 1, 'default_value' => 1 ) ),
				hum_acf_field( 'field_hum_hd_cta_text', 'CTA Button Text', 'header_cta_text', 'text', array( 'default_value' => 'GET STARTED' ) ),
				hum_acf_field( 'field_hum_hd_cta_url', 'CTA Button Custom URL (optional)', 'header_cta_url', 'text', array( 'instructions' => 'Leave empty to open the Booking Consultation modal.' ) ),

				hum_acf_field( 'field_hum_hd_tab_float', 'Floating Tools & WhatsApp', '', 'tab' ),
				hum_acf_field( 'field_hum_hd_quick', 'Show Side Quick Tools Bar?', 'header_show_quick_tools', 'true_false', array( 'ui' => 1, 'default_value' => 1 ) ),
				hum_acf_field( 'field_hum_hd_wa_show', 'Show Floating WhatsApp Button?', 'header_show_whatsapp', 'true_false', array( 'ui' => 1, 'default_value' => 1 ) ),
				hum_acf_field( 'field_hum_hd_wa_url', 'WhatsApp URL', 'header_whatsapp_url', 'url', array( 'default_value' => 'https://wa.me/' ) ),
				hum_acf_field( 'field_hum_hd_contact', 'Quick Tools Contact URL (optional)', 'header_contact_url', 'text', array( 'instructions' => 'Leave empty for default (#contact on Home, Contact page on inner pages).' ) ),
				hum_acf_field( 'field_hum_hd_btt', 'Show Back to Top Button?', 'header_show_back_to_top', 'true_false', array( 'ui' => 1, 'default_value' => 1 ) ),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'hum_header',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'hum_register_acf_field_groups' );
