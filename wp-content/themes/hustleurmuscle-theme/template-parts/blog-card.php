<?php
/**
 * Reusable Blog Post Card Template Part
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$col_class  = isset( $args['col_class'] ) ? $args['col_class'] : 'col-md-6';
$delay      = isset( $args['delay'] ) ? (int) $args['delay'] : 0;
$cta_text   = isset( $args['cta_text'] ) ? $args['cta_text'] : 'READ ARTICLE';
$categories = get_the_category();
$badge_text = ! empty( $categories ) ? strtoupper( $categories[0]->name ) : 'FITNESS';
$thumb_url  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) : get_template_directory_uri() . '/assets/images/blog-1.jpg';
?>
<div class="<?php echo esc_attr( $col_class ); ?>" data-aos="fade-up"<?php echo $delay > 0 ? ' data-aos-delay="' . esc_attr( $delay ) . '"' : ''; ?>>
	<div class="blog-card">
		<div class="blog-img-wrap">
			<span class="blog-badge"><?php echo esc_html( $badge_text ); ?></span>
			<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="blog-img">
		</div>
		<div class="blog-content">
			<div class="blog-meta">
				<span><i class="fa-regular fa-calendar"></i> <?php echo esc_html( strtoupper( get_the_date( 'M d, Y' ) ) ); ?></span>
				<span><i class="fa-regular fa-comment"></i> <?php echo esc_html( get_comments_number() ); ?></span>
			</div>
			<h3 class="blog-title">
				<a href="<?php the_permalink(); ?>"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></a>
			</h3>
			<p class="blog-excerpt">
				<?php echo esc_html( has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_excerpt(), 24, '...' ) ); ?>
			</p>
			<a href="<?php the_permalink(); ?>" class="blog-read-more">
				<?php echo esc_html( $cta_text ); ?> <i class="fa-solid fa-arrow-right"></i>
			</a>
		</div>
	</div>
</div>
