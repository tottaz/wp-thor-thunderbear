<?php
/**
 * The sidebar containing the single download widget area.
 *
 * If no widget is used, the sidebar will output a placeholder
 * download details area that copies the layout of the native
 * EDD "Download Details" widget and also the actual EDD
 * "Download Cart" widget.
 *
 * @package ThunderBear
 */
?>

<aside class="col-sm-4">

	<?php if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>

		<div class="widget widget_edd_product_details">
			<?php
				the_title( '<h3 class="download-title">', '</h3>' );
				echo edd_get_purchase_link( array( 'download_id' => get_the_ID() ) );
			?>
		</div>


		<?php if ( thunderbear_fes_is_activated() || apply_filters( 'thunderbear_show_single_download_author_details', false, $post ) ) { ?>
			<div class="widget widget_download_author">
				<?php $user = new WP_User( $post->post_author ); ?>
				<?php if ( apply_filters( 'thunderbear_show_single_download_author_avatar', true, $post ) ) { ?>
					<span class="thunderbear-download-author"><?php echo get_avatar( $user->ID, 90 ); ?></span>
				<?php } ?>
				<ul class="thunderbear-details-list thunderbear-author-info">
					<?php if ( apply_filters( 'thunderbear_show_single_download_author_name', true, $post ) ) { ?>
						<li class="thunderbear-details-list-item thunderbear-author-details">
							<span class="thunderbear-detail-name"><?php _e( 'Author:', 'thunderbear' ); ?></span>
							<span class="thunderbear-detail-info">
								<?php if ( thunderbear_fes_is_activated() ) {
									$vendor_url = thunderbear_edd_fes_author_url( get_the_author_meta( 'ID', $post->post_author ) );
									?>
									<a class="vendor-url" href="<?php echo $vendor_url; ?>">
										<?php echo $user->display_name; ?>
									</a>
								<?php } else { ?>
									<?php echo $user->display_name; ?>
								<?php } ?>
							</span>
						</li>
					<?php } ?>
					<?php if ( apply_filters( 'thunderbear_show_single_download_author_since', true, $post ) ) { ?>
						<li class="thunderbear-details-list-item thunderbear-author-details">
							<span class="thunderbear-detail-name"><?php _e( 'Author since:', 'thunderbear' ); ?></span>
							<span class="thunderbear-detail-info"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ); ?></span>
						</li>
					<?php } ?>
					<?php
						if ( apply_filters( 'thunderbear_show_single_download_author_links', true, $post ) ) {
							$website  = get_the_author_meta( 'user_url', $post->post_author );
							$twitter  = get_the_author_meta( 'twitter_profile', $post->post_author );
							$gplus    = get_the_author_meta( 'gplus_profile', $post->post_author );
							$facebook = get_the_author_meta( 'facebook_profile', $post->post_author );
							$youtube  = get_the_author_meta( 'youtube_profile', $post->post_author );
							$social_profiles = array(
								'twitter'	=> array(
									'name'	=> 'twitter',
									'data'	=> $twitter,
									'icon'	=> '<i class="fa fa-twitter-square"></i>',
								),
								'gplus'	=> array(
									'name'	=> 'google-plus',
									'data'	=> $gplus,
									'icon'	=> '<i class="fa fa-google-plus-square"></i>',
								),
								'facebook'	=> array(
									'name'	=> 'facebook',
									'data'	=> $facebook,
									'icon'	=> '<i class="fa fa-facebook-square"></i>',
								),
								'youtube'	=> array(
									'name'	=> 'youtube',
									'data'	=> $youtube,
									'icon'	=> '<i class="fa fa-youtube-square"></i>',
								),
							);

							if (
								! empty( $website ) ||
								! empty( $twitter ) ||
								! empty( $gplus ) ||
								! empty( $facebook ) ||
								! empty( $youtube ) ) {
								?>
								<li class="thunderbear-details-list-item thunderbear-author-details">
									<div class="thunderbear-author-contact clear">
										<?php
											foreach ( $social_profiles as $profile ) {
												if ( '' != $profile['data'] ) {
													?>
													<span class="thunderbear-contact-method">
														<?php
															printf( '<a href="%1$s" class="thunderbear-social-profile thunderbear-%2$s" target="_blank">%3$s</a>',
																$profile['data'],
																$profile['name'],
																$profile['icon']
															);
														?>
													</span>
													<?php
												}
											}
										?>
										<?php if ( ! empty( $website ) ) { ?>
											<span class="thunderbear-contact-method thunderbear-author-website">
												<a href="<?php echo $website; ?>" title="<?php echo $user->display_name; echo _x( '\'s website', 'title attribute of the FES vendor\'s website link', 'thunderbear' ); ?>" class="thunderbear-social-profile thunderbear-website" target="_blank">
													<i class="fa fa-home"></i>
												</a>
											</span>
										<?php } ?>
									</div>
								</li>
								<?php
							}
						}
					?>
				</ul>
			</div>
		<?php } ?>

		<div class="widget widget_download_details">
			<span class="widget-title"><?php _e( 'Download Details', 'thunderbear' ); ?></span>
			<ul class="thunderbear-details-list">
				<li class="thunderbear-details-list-item">
					<?php
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
						$time_string = sprintf( $time_string,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() ),
							esc_attr( get_the_modified_date( 'c' ) ),
							esc_html( get_the_modified_date() )
						);
					?>
					<span class="thunderbear-detail-name"><?php _e( 'Published:', 'thunderbear' ); ?></span>
					<span class="thunderbear-detail-info"><?php echo $time_string; ?></span>
				</li>
				<?php if ( thunderbear_fes_is_activated() || apply_filters( 'thunderbear_show_sales_in_sidebar', false, $post ) ) { ?>
					<li class="thunderbear-details-list-item">
						<?php $sales = apply_filters( 'thunderbear_download_sales_count', edd_get_download_sales_stats( $post->ID ), $post ); ?>
						<span class="thunderbear-detail-name"><?php _e( 'Sales:', 'thunderbear' ); ?></span>
						<span class="thunderbear-detail-info"><?php echo $sales; ?></span>
					</li>
				<?php } ?>
				<?php if ( thunderbear_SL_is_activated() ) { ?>
					<li class="thunderbear-details-list-item thunderbear-license-details">
						<?php $licensed = apply_filters( 'thunderbear_download_is_licensed', get_post_meta( get_the_ID(), '_edd_sl_enabled', true ), $post ); ?>
						<span class="thunderbear-detail-name"><?php _e( 'Licensed:', 'thunderbear' ); ?></span>
						<span class="thunderbear-detail-info"><?php echo $licensed ? __( 'Yes', 'thunderbear' ) : __( 'No', 'thunderbear' ); ?></span>
					</li>
					<li class="thunderbear-details-list-item thunderbear-license-details">
						<?php $version = apply_filters( 'thunderbear_download_version', get_post_meta( get_the_ID(), '_edd_sl_version', true ), $post ); ?>
						<span class="thunderbear-detail-name"><?php _e( 'Current Version:', 'thunderbear' ); ?></span>
						<span class="thunderbear-detail-info"><?php echo $version ? $version : __( 'Unversioned', 'thunderbear' ); ?></span>
					</li>
				<?php }

					$categories = get_the_term_list( $post->ID, 'download_category', '', ', ', '' );
					if ( '' != $categories ) {
						?>
						<li class="thunderbear-details-list-item">
							<span class="thunderbear-detail-name"><?php _e( 'Categories:', 'thunderbear' ); ?></span>
							<span class="thunderbear-detail-info"><?php echo $categories; ?></span>
						</li>
						<?php
					}

					$tags = get_the_term_list( $post->ID, 'download_tag', '', ', ', '' );
					if ( '' != $tags ) {
						?>
						<li class="thunderbear-details-list-item">
							<span class="thunderbear-detail-name"><?php _e( 'Tags:', 'thunderbear' ); ?></span>
							<span class="thunderbear-detail-info"><?php echo $tags; ?></span>
						</li>
						<?php
					}
				?>
			</ul>
		</div>

		<?php the_widget( 'edd_cart_widget' ); ?>

	<?php endif; // end sidebar widget area ?>

</aside>

