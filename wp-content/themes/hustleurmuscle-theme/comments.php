<?php
/**
 * The template for displaying comments
 *
 * @package HustleUrMuscle
 */

if ( post_password_required() ) {
	return;
}
?>
<div class="post-comments-wrap" id="comments">
	<h3 class="heading-font text-uppercase mb-4">
		COMMENTS (<?php echo esc_html( get_comments_number() ); ?>)
	</h3>

	<?php if ( have_comments() ) : ?>
		<?php
		wp_list_comments(
			array(
				'style'      => 'div',
				'short_ping' => true,
				'callback'   => function ( $comment, $args, $depth ) {
					$avatar_url = get_avatar_url( $comment, array( 'size' => 64 ) );
					?>
					<div <?php comment_class( 'comment-item' ); ?> id="comment-<?php comment_ID(); ?>">
						<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( get_comment_author() ); ?>" class="comment-avatar">
						<div class="w-100">
							<div class="d-flex justify-content-between align-items-center mb-1">
								<h5 class="mb-0 fw-bold"><?php echo esc_html( get_comment_author() ); ?></h5>
								<small class="text-muted"><?php echo esc_html( get_comment_date( 'M d, Y' ) ); ?></small>
							</div>
							<div class="text-muted small mb-0">
								<?php comment_text(); ?>
							</div>
						</div>
					</div>
					<?php
				},
			)
		);
		?>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<div class="mt-5 p-4 bg-light rounded border">
			<?php
			$commenter = wp_get_current_commenter();
			comment_form(
				array(
					'title_reply'         => '<h4 class="heading-font text-uppercase mb-3">LEAVE A COMMENT</h4>',
					'title_reply_before'  => '',
					'title_reply_after'   => '',
					'class_form'          => 'row g-3',
					'comment_notes_before' => '',
					'fields'              => array(
						'author' => '<div class="col-md-6"><input id="author" name="author" type="text" class="form-control" placeholder="Your Name *" value="' . esc_attr( $commenter['comment_author'] ) . '" required></div>',
						'email'  => '<div class="col-md-6"><input id="email" name="email" type="email" class="form-control" placeholder="Your Email *" value="' . esc_attr( $commenter['comment_author_email'] ) . '" required></div>',
					),
					'comment_field'       => '<div class="col-12"><textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Your Thoughts or Question for Coach Sagar..." required></textarea></div>',
					'submit_field'        => '<div class="col-12">%1$s %2$s</div>',
					'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="btn-fitness-red">POST COMMENT <i class="fa-solid fa-paper-plane ms-2"></i></button>',
				)
			);
			?>
		</div>
	<?php endif; ?>
</div>
