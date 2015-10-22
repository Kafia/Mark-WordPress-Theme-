<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentyeleven_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */

// if comments are open
if(comments_open()):
?>
					<div class="commentListOuter">
						<div class="innerMargin">
							<header class="page-header text-center">
								<h1 class="page-title"><?php _e('Speak out', 'frogsthemes'); ?></h1>
								<?php if ( post_password_required() ) : ?>
								<p class="nopassword"><?php _e('Comments are password protected.', 'frogsthemes'); ?></p>
							</header>
						</div>
					</div>
					<?php
					return;
					endif;
								if ( have_comments() ) : ?>
								<h2><?php $comments_number = get_comments_number('0', '1', '%'); printf( _n( '%d comment', '%d comments', $comments_number, 'frogsthemes' ), $comments_number ); ?></h2>
							</header>
							<ul class="commentList list-unstyled">
								<?php
								/* Loop through and list the comments. Tell wp_list_comments()
								* to use ft_comment() to format the comments.
								* If you want to overload this in a child theme then you can
								* define ft_comment() and that will be used instead.
								*/
								wp_list_comments( array( 'callback' => 'ft_comment', 'style' =>'li', 'type' => 'comment', 'max_depth' => 3 ) );
								?>
							</ul>
							<?php
							/* If there are no comments and comments are closed, let's leave a little note, shall we?
							* But we don't want the note on pages or post types that do not support comments.
							*/
							elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
							<p class="nocomments"><?php _e('Comments are closed.', 'frogsthemes'); ?></p>
							<?php endif; ?>
							
							<?php
							$fields =  array(
                                'author' 	=> '<div class="row"><div class="col-md-6"><div class="form-group"><label class="control-label">'.__('Name', 'frogsthemes').' <span>*</span></label><input name="author" type="text" aria-required="true" class="form-control" /></div></div>',
                                'email' 	=> '<div class="col-md-6"><div class="form-group"><label class="control-label">'.__('Email', 'frogsthemes').' <span>*</span></label><input type="text" name="email" aria-required="true" class="form-control" /></div></div></div>'
							); 
                            
							$defaults = array(
                                'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
                                'comment_field'        => '<div class="row"><div class="col-md-12"><div class="form-group"><label class="control-label">Comment <span>*</span></label><textarea name="comment" rows="5" tabindex="4" aria-required="true" class="form-control"></textarea></div></div></div>',
                                'logged_in_as'         => '',
                                'comment_notes_before' => '',
                                'comment_notes_after'  => '',
                                'id_submit'            => '',
                                'title_reply'			=> '',
                                'label_submit'         => __('Post Comment', 'frogsthemes'),
							);
							?>
							<header class="page-header text-center">
								<h2><?php _e('Leave a comment', 'frogsthemes'); ?></h2>
							</header>
							<?php comment_form_ft($defaults); ?>
						</div>
					</div>

<?php endif; ?>