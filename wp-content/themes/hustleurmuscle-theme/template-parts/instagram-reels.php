<?php
/**
 * Reusable 3x2 Instagram Reels Grid for Footer (ACF Free + Customizer powered)
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$front_id = hum_get_front_page_id();
$defaults = array(
	1 => array( 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4', 'assets/images/hero-bg.jpg' ),
	2 => array( 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj', 'assets/images/trainer-2.jpg' ),
	3 => array( 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==', 'assets/images/about-2.jpg' ),
	4 => array( 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4', 'assets/images/banner-gym.jpg' ),
	5 => array( 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj', 'assets/images/trainer-3.jpg' ),
	6 => array( 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==', 'assets/images/contact-trainer.jpg' ),
);
?>
<div class="footer-reels-grid">
	<?php foreach ( $defaults as $num => $pair ) : ?>
		<?php
		$reel_url = hustleurmuscle_get_option( 'hum_reel_' . $num, $pair[0] );
		$reel_img = $front_id
			? hum_get_image_url( 'site_reel_' . $num . '_img', $front_id, $pair[1] )
			: get_template_directory_uri() . '/' . $pair[1];
		?>
		<a href="<?php echo esc_url( $reel_url ); ?>" target="_blank" rel="noopener noreferrer" class="footer-reel-item" title="<?php echo esc_attr( 'Watch Instagram Reel ' . $num ); ?>">
			<img src="<?php echo esc_url( $reel_img ); ?>" alt="<?php echo esc_attr( 'Hustle Ur Muscle Instagram Reel ' . $num ); ?>" class="footer-reel-img">
			<span class="footer-reel-overlay"><span class="footer-reel-play"><i class="fa-solid fa-play"></i></span></span>
		</a>
	<?php endforeach; ?>
</div>
