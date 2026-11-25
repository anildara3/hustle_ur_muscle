<?php
/**
 * Contact Form 7 Integration & Auto-Provisioning
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Keep Contact Form 7 from injecting extra <p> and <br> tags into Bootstrap grid columns.
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Definition of the 3 default Contact Form 7 forms matching exact theme markup.
 */
function hum_get_cf7_form_definitions() {
	return array(
		'home'    => array(
			'option' => 'hum_cf7_home_id',
			'title'  => 'Home Consultation Form',
			'form'   => '<div class="row g-4">
  <div class="col-md-6 form-fitness-group">
    [text* your-name id:contactName class:form-fitness-control placeholder "YOUR NAME *"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [tel* your-phone id:contactPhone class:form-fitness-control placeholder "PHONE NUMBER *"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [email* your-email id:contactEmail class:form-fitness-control placeholder "YOUR EMAIL *"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [select your-goal id:contactGoal class:form-fitness-control first_as_label "SELECT PRIMARY GOAL" "Strength Training" "Weight Loss & Fat Burn" "Cardio & Health Program" "1-on-1 Coaching with Sagar Soma"]
  </div>
  <div class="col-12 form-fitness-group">
    [textarea* your-message id:contactMessage x3 class:form-fitness-control placeholder "YOUR MESSAGE / QUESTIONS *"]
  </div>
  <div class="col-12 mt-4">
    <button type="submit" class="btn-fitness-blue wpcf7-submit">SEND MESSAGE <i class="fa-solid fa-paper-plane"></i></button>
  </div>
</div>',
		),
		'contact' => array(
			'option' => 'hum_cf7_contact_id',
			'title'  => 'Contact Page Inquiry Form',
			'form'   => '<div class="row g-4">
  <div class="col-md-6 form-fitness-group">
    [text* your-name id:cName class:form-fitness-control placeholder "YOUR FULL NAME *"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [tel* your-phone id:cPhone class:form-fitness-control placeholder "PHONE / WHATSAPP NUMBER *"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [email* your-email id:cEmail class:form-fitness-control placeholder "YOUR EMAIL ADDRESS *"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [select your-service id:cService class:form-fitness-control first_as_label "PROGRAM INTERESTED IN" "Strength Training (12 Weeks)" "Rapid Weight Loss & Fat Burn (8 Weeks)" "Health & Cardio Conditioning (7 Weeks)" "1-on-1 Personal Mentoring" "Online Distance Coaching (Global)"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [select preferred-time id:cTime class:form-fitness-control first_as_label "BEST TIME TO REACH YOU" "Morning (08:00 - 12:00)" "Afternoon (12:00 - 17:00)" "Evening (17:00 - 21:00)"]
  </div>
  <div class="col-md-6 form-fitness-group">
    [text your-city id:cCity class:form-fitness-control placeholder "YOUR CURRENT CITY / LOCATION"]
  </div>
  <div class="col-12 form-fitness-group">
    [textarea* your-message id:cMessage x4 class:form-fitness-control placeholder "TELL SAGAR ABOUT YOUR GOALS, PAST INJURIES, OR QUESTIONS *"]
  </div>
  <div class="col-12">
    <div class="form-check text-white-50">
      [acceptance consent default:on id:cConsent class:form-check-input] <span class="form-check-label fs-6">I agree to receive coaching consultation details and routine updates via WhatsApp / Email.</span> [/acceptance]
    </div>
  </div>
  <div class="col-12 mt-4">
    <button type="submit" class="btn-fitness-red w-100 py-3 wpcf7-submit">SUBMIT INQUIRY TO COACH SAGAR <i class="fa-solid fa-paper-plane ms-2"></i></button>
  </div>
</div>',
		),
		'modal'   => array(
			'option' => 'hum_cf7_modal_id',
			'title'  => 'Booking Modal Form',
			'form'   => '<div class="mb-3">
  <label class="form-label text-uppercase fs-6 fw-bold">Full Name</label>
  [text* your-name class:form-control class:bg-dark class:text-white class:border-secondary placeholder "John Doe"]
</div>
<div class="mb-3">
  <label class="form-label text-uppercase fs-6 fw-bold">Phone Number</label>
  [tel* your-phone class:form-control class:bg-dark class:text-white class:border-secondary placeholder "+1 (555) 000-0000"]
</div>
<div class="mb-3">
  <label class="form-label text-uppercase fs-6 fw-bold">Preferred Time</label>
  [select preferred-time class:form-select class:bg-dark class:text-white class:border-secondary "Morning (07:00 - 11:00)" "Afternoon (12:00 - 16:00)" "Evening (17:00 - 21:00)"]
</div>
<button type="submit" class="btn-fitness-red w-100 mt-2 wpcf7-submit">CONFIRM BOOKING</button>',
		),
	);
}

/**
 * Ensure the 3 default Contact Form 7 forms exist when CF7 is active.
 */
function hum_provision_cf7_forms() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	$recipient = sanitize_email( hustleurmuscle_get_option( 'hum_email', 'info@hustleurmuscle.in' ) );
	if ( empty( $recipient ) ) {
		$recipient = get_option( 'admin_email' );
	}

	foreach ( hum_get_cf7_form_definitions() as $key => $def ) {
		$saved_id = (int) get_option( $def['option'], 0 );
		if ( $saved_id > 0 && 'wpcf7_contact_form' === get_post_type( $saved_id ) && 'publish' === get_post_status( $saved_id ) ) {
			continue;
		}

		// Check if a form with the same title already exists
		$existing = get_posts(
			array(
				'post_type'   => 'wpcf7_contact_form',
				'title'       => $def['title'],
				'post_status' => 'publish',
				'numberposts' => 1,
			)
		);
		if ( ! empty( $existing ) ) {
			update_option( $def['option'], (int) $existing[0]->ID );
			continue;
		}

		$cf7 = WPCF7_ContactForm::get_template();
		$cf7->set_title( $def['title'] );
		$cf7->set_properties(
			array(
				'form' => $def['form'],
				'mail' => array(
					'active'             => true,
					'subject'            => '[Hustle Ur Muscle] ' . $def['title'] . ' from [your-name]',
					'sender'             => '[_site_title] <wordpress@hustleurmuscle.in>',
					'recipient'          => $recipient,
					'body'               => "Name: [your-name]\nPhone: [your-phone]\nEmail: [your-email]\nGoal / Service: [your-goal][your-service]\nPreferred Time: [preferred-time]\nCity: [your-city]\n\nMessage:\n[your-message]",
					'additional_headers' => '',
					'attachments'        => '',
					'use_html'           => false,
					'exclude_blank'      => true,
				),
			)
		);
		$new_id = $cf7->save();
		if ( $new_id ) {
			update_option( $def['option'], (int) $new_id );
		}
	}
}

/**
 * Render a Contact Form 7 shortcode (ACF override -> auto-provisioned CF7 -> fallback HTML form).
 */
function hum_render_cf7_or_fallback( $custom_shortcode, $form_key ) {
	if ( class_exists( 'WPCF7_ContactForm' ) ) {
		if ( ! empty( $custom_shortcode ) && false !== strpos( $custom_shortcode, '[contact-form-7' ) ) {
			echo do_shortcode( $custom_shortcode );
			return;
		}

		$defs   = hum_get_cf7_form_definitions();
		$opt    = isset( $defs[ $form_key ]['option'] ) ? $defs[ $form_key ]['option'] : '';
		$cf7_id = $opt ? (int) get_option( $opt, 0 ) : 0;

		if ( $cf7_id > 0 && 'publish' === get_post_status( $cf7_id ) ) {
			echo do_shortcode( '[contact-form-7 id="' . $cf7_id . '"]' );
			return;
		}
	}

	// Fallback native HTML form preserving 100% design if CF7 is disabled.
	if ( 'home' === $form_key ) :
		?>
		<form id="contactForm" novalidate>
			<div class="row g-4">
				<div class="col-md-6 form-fitness-group">
					<input type="text" class="form-fitness-control" id="contactName" placeholder="YOUR NAME *" required>
				</div>
				<div class="col-md-6 form-fitness-group">
					<input type="tel" class="form-fitness-control" id="contactPhone" placeholder="PHONE NUMBER *" required>
				</div>
				<div class="col-md-6 form-fitness-group">
					<input type="email" class="form-fitness-control" id="contactEmail" placeholder="YOUR EMAIL *" required>
				</div>
				<div class="col-md-6 form-fitness-group">
					<select class="form-fitness-control" id="contactGoal">
						<option value="" disabled selected>SELECT PRIMARY GOAL</option>
						<option value="strength">Strength Training</option>
						<option value="weightloss">Weight Loss &amp; Fat Burn</option>
						<option value="health">Cardio &amp; Health Program</option>
						<option value="coach">1-on-1 Coaching with Sagar Soma</option>
					</select>
				</div>
				<div class="col-12 form-fitness-group">
					<textarea class="form-fitness-control" id="contactMessage" rows="3" placeholder="YOUR MESSAGE / QUESTIONS *" required></textarea>
				</div>
				<div class="col-12 mt-4">
					<button type="submit" class="btn-fitness-blue">
						SEND MESSAGE <i class="fa-solid fa-paper-plane"></i>
					</button>
				</div>
			</div>
		</form>
		<?php
	elseif ( 'contact' === $form_key ) :
		?>
		<form id="contactPageForm" novalidate>
			<div class="row g-4">
				<div class="col-md-6 form-fitness-group">
					<input type="text" class="form-fitness-control" id="cName" placeholder="YOUR FULL NAME *" required>
				</div>
				<div class="col-md-6 form-fitness-group">
					<input type="tel" class="form-fitness-control" id="cPhone" placeholder="PHONE / WHATSAPP NUMBER *" required>
				</div>
				<div class="col-md-6 form-fitness-group">
					<input type="email" class="form-fitness-control" id="cEmail" placeholder="YOUR EMAIL ADDRESS *" required>
				</div>
				<div class="col-md-6 form-fitness-group">
					<select class="form-fitness-control" id="cService">
						<option value="" disabled selected>PROGRAM INTERESTED IN</option>
						<option value="strength">Strength Training (12 Weeks)</option>
						<option value="weightloss">Rapid Weight Loss &amp; Fat Burn (8 Weeks)</option>
						<option value="health">Health &amp; Cardio Conditioning (7 Weeks)</option>
						<option value="private">1-on-1 Personal Mentoring</option>
						<option value="online">Online Distance Coaching (Global)</option>
					</select>
				</div>
				<div class="col-md-6 form-fitness-group">
					<select class="form-fitness-control" id="cTime">
						<option value="" disabled selected>BEST TIME TO REACH YOU</option>
						<option value="morning">Morning (08:00 - 12:00)</option>
						<option value="afternoon">Afternoon (12:00 - 17:00)</option>
						<option value="evening">Evening (17:00 - 21:00)</option>
					</select>
				</div>
				<div class="col-md-6 form-fitness-group">
					<input type="text" class="form-fitness-control" id="cCity" placeholder="YOUR CURRENT CITY / LOCATION">
				</div>
				<div class="col-12 form-fitness-group">
					<textarea class="form-fitness-control" id="cMessage" rows="4" placeholder="TELL SAGAR ABOUT YOUR GOALS, PAST INJURIES, OR QUESTIONS *" required></textarea>
				</div>
				<div class="col-12">
					<div class="form-check text-white-50">
						<input class="form-check-input bg-dark border-secondary" type="checkbox" value="" id="cConsent" checked>
						<label class="form-check-label fs-6" for="cConsent">
							I agree to receive coaching consultation details and routine updates via WhatsApp / Email.
						</label>
					</div>
				</div>
				<div class="col-12 mt-4">
					<button type="submit" class="btn-fitness-red w-100 py-3">
						SUBMIT INQUIRY TO COACH SAGAR <i class="fa-solid fa-paper-plane ms-2"></i>
					</button>
				</div>
			</div>
		</form>
		<?php
	else :
		?>
		<form id="consultationForm">
			<div class="mb-3">
				<label class="form-label text-uppercase fs-6 fw-bold">Full Name</label>
				<input type="text" name="hum_name" class="form-control bg-dark text-white border-secondary" required placeholder="John Doe">
			</div>
			<div class="mb-3">
				<label class="form-label text-uppercase fs-6 fw-bold">Phone Number</label>
				<input type="tel" name="hum_phone" class="form-control bg-dark text-white border-secondary" required placeholder="+1 (555) 000-0000">
			</div>
			<div class="mb-3">
				<label class="form-label text-uppercase fs-6 fw-bold">Preferred Time</label>
				<select name="hum_time" class="form-select bg-dark text-white border-secondary">
					<option>Morning (07:00 - 11:00)</option>
					<option>Afternoon (12:00 - 16:00)</option>
					<option>Evening (17:00 - 21:00)</option>
				</select>
			</div>
			<button type="submit" class="btn-fitness-red w-100 mt-2">
				CONFIRM BOOKING
			</button>
		</form>
		<?php
	endif;
}
