<?php
/**
 * Template Name: Gallery (hum_gallery CPT + hum_gallery_cat + ACF Free)
 *
 * @package HustleUrMuscle
 */

get_header();

$theme_uri = get_template_directory_uri();
$page_id   = get_queried_object_id();

$gallery_terms = get_terms(
	array(
		'taxonomy'   => 'hum_gallery_cat',
		'hide_empty' => false,
		'orderby'    => 'term_id',
		'order'      => 'ASC',
	)
);
if ( is_wp_error( $gallery_terms ) ) {
	$gallery_terms = array();
}

$gallery_query = new WP_Query(
	array(
		'post_type'      => 'hum_gallery',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
	)
);
?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-gym" style="background-image: url('<?php echo esc_url( hum_get_image_url( 'gallery_banner_img', $page_id, 'assets/images/banner-gym.jpg' ) ); ?>');">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( hum_get_field( 'gallery_banner_tag', $page_id, 'TRAINING & NUTRITION SHOWCASE' ) ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( hum_get_field( 'gallery_banner_title', $page_id, 'HUSTLE UR MUSCLE GALLERY' ) ); ?></h1>
				<p class="page-header-desc">
					<?php echo esc_html( hum_get_field( 'gallery_banner_desc', $page_id, 'Explore workout sessions, group training energy, 1-on-1 personal coaching, recovery massage training, and clean diet food blueprints by Coach Sagar Soma.' ) ); ?>
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current">GALLERY</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Gallery Filter & Grid Section -->
	<section class="section-services py-5">
		<div class="container px-lg-4 my-4">

			<div class="text-center mb-4" data-aos="fade-up">
				<span class="section-tag tag-center"><?php echo esc_html( hum_get_field( 'gallery_grid_tag', $page_id, 'PHOTOS & VIDEOS' ) ); ?></span>
				<h2 class="services-title"><?php echo esc_html( hum_get_field( 'gallery_grid_title', $page_id, 'INSIDE THE HUSTLE UR MUSCLE ZONE' ) ); ?></h2>
				<div class="trainer-name-divider">
					<span class="trainer-name-text">SAGAR SOMA</span>
				</div>
			</div>

			<!-- Filter Controls -->
			<div class="gallery-filter-bar mb-5" data-aos="fade-up" data-aos-delay="100">
				<div class="gallery-filter-group" role="group" aria-label="Filter gallery by category">
					<button type="button" class="gallery-filter-btn active" data-cat="all">ALL</button>
					<?php foreach ( $gallery_terms as $term ) : ?>
						<button type="button" class="gallery-filter-btn" data-cat="<?php echo esc_attr( $term->slug ); ?>">
							<?php echo esc_html( strtoupper( $term->name ) ); ?>
						</button>
					<?php endforeach; ?>
				</div>

				<div class="gallery-type-group" role="group" aria-label="Filter gallery by media type">
					<button type="button" class="gallery-type-btn active" data-media-type="all">
						<i class="fa-solid fa-layer-group me-1"></i> ALL MEDIA
					</button>
					<button type="button" class="gallery-type-btn" data-media-type="photo">
						<i class="fa-solid fa-camera me-1"></i> PHOTOS
					</button>
					<button type="button" class="gallery-type-btn" data-media-type="video">
						<i class="fa-solid fa-video me-1"></i> VIDEOS
					</button>
				</div>
			</div>

			<!-- Gallery Grid (hum_gallery CPT) -->
			<div class="row g-4 text-start" id="galleryGrid">
				<?php
				if ( $gallery_query->have_posts() ) :
					$delay = 100;
					while ( $gallery_query->have_posts() ) :
						$gallery_query->the_post();
						$gid        = get_the_ID();
						$media_type = 'video' === hum_get_field( 'gallery_media_type', $gid, 'photo' ) ? 'video' : 'photo';
						$caption    = hum_get_field( 'gallery_caption', $gid, '' );

						$video_file = hum_get_file_url( 'gallery_video_file', $gid );
						$video_url  = hum_get_field( 'gallery_video_url', $gid, '' );
						$raw_video  = $video_file ? $video_file : $video_url;
						$embed_info = ( 'video' === $media_type && $raw_video ) ? hum_parse_video_embed( $raw_video ) : array( 'type' => 'none', 'src' => '', 'poster_fallback' => '' );

						$thumb_url = hum_get_image_url( 'gallery_photo', $gid, '', 'large' );
						if ( '' === $thumb_url && has_post_thumbnail( $gid ) ) {
							$thumb_url = get_the_post_thumbnail_url( $gid, 'large' );
						}
						if ( '' === $thumb_url && ! empty( $embed_info['poster_fallback'] ) ) {
							$thumb_url = $embed_info['poster_fallback'];
						}
						if ( '' === $thumb_url ) {
							$thumb_url = $theme_uri . '/assets/images/banner-gym.jpg';
						}

						$full_img_url = hum_get_image_url( 'gallery_photo', $gid, '', 'full' );
						if ( '' === $full_img_url && has_post_thumbnail( $gid ) ) {
							$full_img_url = get_the_post_thumbnail_url( $gid, 'full' );
						}
						if ( '' === $full_img_url ) {
							$full_img_url = $thumb_url;
						}

						$item_terms = get_the_terms( $gid, 'hum_gallery_cat' );
						$cat_slugs  = array();
						$cat_label  = 'WORKOUT';
						if ( ! empty( $item_terms ) && ! is_wp_error( $item_terms ) ) {
							$cat_label = strtoupper( $item_terms[0]->name );
							foreach ( $item_terms as $it ) {
								$cat_slugs[] = $it->slug;
							}
						}
						$cats_attr = implode( ',', $cat_slugs );
						?>
						<div class="col-lg-4 col-md-6 gallery-grid-col"
							data-category="<?php echo esc_attr( $cats_attr ); ?>"
							data-type="<?php echo esc_attr( $media_type ); ?>"
							data-aos="fade-up"
							data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<article class="gallery-card"
								role="button"
								tabindex="0"
								data-title="<?php echo esc_attr( get_the_title() ); ?>"
								data-caption="<?php echo esc_attr( $caption ); ?>"
								data-cat-label="<?php echo esc_attr( $cat_label ); ?>"
								data-media-type="<?php echo esc_attr( $media_type ); ?>"
								data-img="<?php echo esc_url( $full_img_url ); ?>"
								data-video-type="<?php echo esc_attr( $embed_info['type'] ); ?>"
								data-video-src="<?php echo esc_url( $embed_info['src'] ); ?>">
								<div class="gallery-media-wrap">
									<span class="gallery-badge-cat"><?php echo esc_html( $cat_label ); ?></span>
									<span class="gallery-badge-type<?php echo 'video' === $media_type ? ' is-video' : ''; ?>">
										<?php if ( 'video' === $media_type ) : ?>
											<i class="fa-solid fa-video me-1"></i> VIDEO
										<?php else : ?>
											<i class="fa-solid fa-camera me-1"></i> PHOTO
										<?php endif; ?>
									</span>
									<?php if ( 'video' === $media_type && 'mp4' === $embed_info['type'] && ! has_post_thumbnail( $gid ) && '' === hum_get_image_url( 'gallery_photo', $gid, '' ) ) : ?>
										<video class="gallery-thumb" muted playsinline preload="metadata">
											<source src="<?php echo esc_url( $embed_info['src'] ); ?>">
										</video>
									<?php else : ?>
										<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="gallery-thumb">
									<?php endif; ?>
									<div class="gallery-overlay">
										<span class="gallery-action-circle">
											<?php if ( 'video' === $media_type ) : ?>
												<i class="fa-solid fa-play"></i>
											<?php else : ?>
												<i class="fa-solid fa-magnifying-glass-plus"></i>
											<?php endif; ?>
										</span>
									</div>
								</div>
								<div class="gallery-card-body">
									<h3 class="gallery-card-title"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h3>
									<?php if ( $caption ) : ?>
										<p class="gallery-card-caption"><?php echo esc_html( $caption ); ?></p>
									<?php endif; ?>
									<span class="gallery-card-cta">
										<?php echo 'video' === $media_type ? 'WATCH VIDEO' : 'VIEW PHOTO'; ?>
										<i class="fa-solid fa-arrow-right ms-1"></i>
									</span>
								</div>
							</article>
						</div>
						<?php
						$delay = ( $delay % 300 ) + 100;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>

			<!-- Empty Filter State -->
			<div id="galleryEmptyState" class="p-5 bg-light border rounded text-center mt-4 gallery-empty-hidden">
				<i class="fa-solid fa-photo-film text-danger fs-1 mb-3"></i>
				<h3 class="heading-font text-uppercase mb-2">NO GALLERY ITEMS IN THIS FILTER YET</h3>
				<p class="text-muted mb-3">Try selecting another category or media type, or add new photos and videos from WordPress Dashboard → Gallery.</p>
				<button type="button" class="btn-fitness-red" id="galleryResetFilterBtn">SHOW ALL GALLERY ITEMS</button>
			</div>

			<!-- Bottom Assessment CTA Banner -->
			<div class="mt-5 p-4 p-md-5 bg-dark text-white rounded border border-secondary text-center" data-aos="fade-up">
				<h3 class="heading-font text-uppercase text-white mb-2"><?php echo esc_html( hum_get_field( 'gallery_cta_title', $page_id, 'READY TO START YOUR OWN TRANSFORMATION?' ) ); ?></h3>
				<p class="text-white-50 max-w-600 mx-auto mb-4">
					<?php echo esc_html( hum_get_field( 'gallery_cta_desc', $page_id, 'Train 1-on-1 or join group conditioning with Coach Sagar Soma. Book your complimentary movement and nutrition consultation today.' ) ); ?>
				</p>
				<a href="#" class="btn-fitness-blue" data-bs-toggle="modal" data-bs-target="#consultationModal">
					TRAIN WITH COACH SAGAR <i class="fa-solid fa-calendar-check ms-2"></i>
				</a>
			</div>

		</div>
	</section>

	<!-- Gallery Lightbox Modal -->
	<div class="modal fade modal-fitness-dark" id="galleryLightboxModal" tabindex="-1" aria-labelledby="galleryLightboxTitle" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header align-items-center">
					<div>
						<span class="badge bg-danger text-uppercase mb-1" id="galleryLightboxCat">WORKOUT</span>
						<h4 class="modal-title heading-font text-white mb-0" id="galleryLightboxTitle">GALLERY ITEM</h4>
					</div>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-3 p-md-4">
					<div class="gallery-lightbox-stage" id="galleryLightboxStage"></div>
					<p class="text-white-50 mt-3 mb-0" id="galleryLightboxCaption"></p>
				</div>
				<div class="modal-footer border-top border-secondary justify-content-between">
					<button type="button" class="btn btn-outline-light btn-sm" id="galleryLightboxPrev">
						<i class="fa-solid fa-arrow-left me-1"></i> PREV
					</button>
					<span class="text-white-50 small font-monospace" id="galleryLightboxCounter">1 / 1</span>
					<button type="button" class="btn btn-outline-light btn-sm" id="galleryLightboxNext">
						NEXT <i class="fa-solid fa-arrow-right ms-1"></i>
					</button>
				</div>
			</div>
		</div>
	</div>

<?php
get_footer();
