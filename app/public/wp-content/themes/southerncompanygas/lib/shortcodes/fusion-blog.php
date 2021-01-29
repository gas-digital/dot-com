<?php
/**
 * Add an element to fusion-builder.
 *
 * @package fusion-builder
 * @since 1.0
 */

/*
if ( fusion_is_element_enabled( 'fusion_blog' ) ) {

	if ( ! class_exists( 'FusionSC_Blog' ) ) {
*/
		/**
		 * Shortcode class.
		 *
		 * @since 1.0
		 */
		class FusionSC_Blog extends Fusion_Element {

			/**
			 * Blog SC counter.
			 *
			 * @access private
			 * @since 1.0
			 * @var int
			 */
			private $blog_sc_counter = 1;

			/**
			 * Posts counter.
			 *
			 * @access private
			 * @since 1.0
			 * @var int
			 */
			private $post_count = 1;

			/**
			 * The post ID.
			 *
			 * @access private
			 * @since 1.0
			 * @var int
			 */
			private $post_id = 0;


			/**
			 * The post permalink.
			 *
			 * @access private
			 * @since 2.0.3
			 * @var string
			 */
			private $permalink = '';

			/**
			 * The month of the post.
			 *
			 * @access private
			 * @since 1.0
			 * @var null|int|string
			 */
			private $post_month = null;

			/**
			 * The post's year.
			 *
			 * @access private
			 * @since 1.0
			 * @var null|int|string
			 */
			private $post_year = null;

			/**
			 * An array of meta settings.
			 *
			 * @access private
			 * @since 1.0
			 * @var array
			 */
			private $meta_info_settings = [];

			/**
			 * Header arguments.
			 *
			 * @access private
			 * @since 1.0
			 * @var array
			 */
			private $header = [];

			/**
			 * The Query.
			 *
			 * @access private
			 * @since 1.0
			 * @var string|array|object
			 */
			private $query = '';

			/**
			 * An array of the shortcode arguments.
			 *
			 * @access protected
			 * @since 1.0
			 * @var array
			 */
			protected $args;

			/**
			 * Constructor.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function __construct() {
				parent::__construct();
				// Containers.
				add_action( 'fusion_blog_shortcode_before_loop', [ $this, 'before_loop' ] );
				add_action( 'fusion_blog_shortcode_before_loop_timeline', [ $this, 'before_loop_timeline' ] );
				add_action( 'fusion_blog_shortcode_after_loop', [ $this, 'after_loop' ] );

				// Post / loop basic structure.
				add_action( 'fusion_blog_shortcode_loop_header', [ $this, 'loop_header' ] );
				add_action( 'fusion_blog_shortcode_loop_footer', [ $this, 'loop_footer' ] );
				add_action( 'fusion_blog_shortcode_loop_content', [ $this, 'loop_content' ] );
				add_action( 'fusion_blog_shortcode_loop_content', [ $this, 'page_links' ] );
				add_action( 'fusion_blog_shortcode_loop', [ $this, 'loop' ] );

				// Special blog layout structure.
				add_action( 'fusion_blog_shortcode_wrap_loop_open', [ $this, 'wrap_loop_open' ] );
				add_action( 'fusion_blog_shortcode_wrap_loop_close', [ $this, 'wrap_loop_close' ] );
				add_action( 'fusion_blog_shortcode_date_and_format', [ $this, 'add_date_box' ] );
				add_action( 'fusion_blog_shortcode_date_and_format', [ $this, 'add_format_box' ] );
				add_action( 'fusion_blog_shortcode_timeline_date', [ $this, 'timeline_date' ] );

				// Element attributes.
				add_filter( 'fusion_attr_blog-shortcode', [ $this, 'attr' ] );
				add_filter( 'fusion_attr_blog-shortcode-posts-container', [ $this, 'posts_container_attr' ] );
				add_filter( 'fusion_attr_blog-shortcode-loop', [ $this, 'loop_attr' ] );
				add_filter( 'fusion_attr_blog-shortcode-post-title', [ $this, 'post_title_attr' ] );
				add_filter( 'fusion_attr_blog-shortcode-post-content-wrapper', [ $this, 'post_content_wrapper_attr' ] );
				add_filter( 'fusion_attr_blog-fusion-post-wrapper', [ $this, 'post_wrapper_attr' ] );
				add_filter( 'fusion_attr_blog-fusion-content-sep', [ $this, 'content_sep_attr' ] );

				add_shortcode( 'fusion_blog', [ $this, 'render' ] );

				// Ajax mechanism for query related part.
				add_action( 'wp_ajax_get_fusion_blog', [ $this, 'ajax_query' ] );
			}

			/**
			 * Gets the default values.
			 *
			 * @static
			 * @access public
			 * @since 2.0.0
			 * @return array
			 */
			public static function get_element_defaults() {
				global $fusion_settings;

				return [
					'hide_on_mobile'            => fusion_builder_default_visibility( 'string' ),
					'class'                     => '',
					'id'                        => '',
					'blog_grid_column_spacing'  => $fusion_settings->get( 'blog_grid_column_spacing' ),
					'blog_grid_padding'         => $fusion_settings->get( 'blog_grid_padding' ),
					'content_alignment'         => '',
					'equal_heights'             => 'no',
					'blog_grid_columns'         => $fusion_settings->get( 'blog_grid_columns' ),
					'pull_by'                   => '',
					'cat_slug'                  => '',
					'tag_slug'                  => '',
					'exclude_tags'              => '',
					'excerpt'                   => $fusion_settings->get( 'blog_excerpt' ),
					'excerpt_length'            => $fusion_settings->get( 'blog_excerpt_length' ),
					'exclude_cats'              => '',
					'grid_box_color'            => $fusion_settings->get( 'timeline_bg_color' ),
					'grid_element_color'        => $fusion_settings->get( 'timeline_color' ),
					'grid_separator_color'      => $fusion_settings->get( 'grid_separator_color' ),
					'grid_separator_style_type' => $fusion_settings->get( 'grid_separator_style_type' ),
					'layout'                    => 'large',
					'meta_all'                  => 'yes',
					'meta_author'               => 'yes',
					'meta_categories'           => 'yes',
					'meta_comments'             => 'yes',
					'meta_date'                 => 'yes',
					'meta_link'                 => 'yes',
					'meta_read'                 => 'yes',
					'meta_tags'                 => 'no',
					'number_posts'              => '6',
					'offset'                    => '',
					'order'                     => 'DESC',
					'orderby'                   => 'date',
					'paging'                    => '',
					'posts_per_page'            => '-1',
					'post_status'               => '',
					'scrolling'                 => 'infinite',
					'show_title'                => 'yes',
					'strip_html'                => 'yes',
					'taxonomy'                  => 'category',
					'thumbnail'                 => 'yes',
					'title_link'                => 'yes',
					'blog_masonry_grid_ratio'   => $fusion_settings->get( 'masonry_grid_ratio' ),
					'blog_masonry_width_double' => $fusion_settings->get( 'masonry_width_double' ),
					'excerpt_words'             => '50', // Deprecated.
					'title'                     => '',   // Deprecated.
				];
			}

			/**
			 * Maps settings to param variables.
			 *
			 * @static
			 * @access public
			 * @since 2.0.0
			 * @return array
			 */
			public static function settings_to_params() {
				return [
					'timeline_bg_color'        => 'grid_box_color',
					'timeline_color'           => 'grid_element_color',
					'blog_grid_padding'        => 'blog_grid_padding',
					'blog_grid_columns'        => 'blog_grid_columns',
					'blog_grid_column_spacing' => 'blog_grid_column_spacing',
					'blog_excerpt'             => 'excerpt',
					'blog_excerpt_length'      => 'excerpt_length',
				];
			}

			/**
			 * Used to set any other variables for use on front-end editor template.
			 *
			 * @static
			 * @access public
			 * @since 2.0.0
			 * @return array
			 */
			public static function get_element_extras() {
				$fusion_settings = fusion_get_fusion_settings();
				return [
					'disable_date_rich_snippet_pages'   => $fusion_settings->get( 'disable_date_rich_snippet_pages' ),
					'read_more_text'                    => apply_filters( 'avada_read_more_name', esc_attr__( 'Read More', 'fusion-builder' ) ),
					'pagination_global'                 => apply_filters( 'fusion_builder_blog_pagination', '' ),
					'pagination_range_global'           => apply_filters( 'fusion_pagination_size', $fusion_settings->get( 'pagination_range' ) ),
					'pagination_start_end_range_global' => apply_filters( 'fusion_pagination_start_end_size', $fusion_settings->get( 'pagination_start_end_range' ) ),
					'load_more_text'                    => apply_filters( 'avada_load_more_posts_name', esc_attr__( 'Load More Posts', 'fusion-builder' ) ),
					'image_rollover'                    => $fusion_settings->get( 'image_rollover' ),
				];
			}

			/**
			 * Maps settings to extra variables.
			 *
			 * @static
			 * @access public
			 * @since 2.0.0
			 * @return array
			 */
			public static function settings_to_extras() {

				return [
					'disable_date_rich_snippet_pages' => 'disable_date_rich_snippet_pages',
					'image_rollover'                  => 'image_rollover',
					'pagination_range'                => 'pagination_range_global',
					'pagination_start_end_range'      => 'pagination_start_end_range_global',
				];
			}

			/**
			 * Gets the query data.
			 *
			 * @static
			 * @access public
			 * @since 2.0.0
			 * @param array $defaults An array of defaults.
			 * @return void
			 */
			public function ajax_query( $defaults ) {
				check_ajax_referer( 'fusion_load_nonce', 'fusion_load_nonce' );
				$this->query( $defaults );
			}

			/**
			 * Gets the query data.
			 *
			 * @static
			 * @access public
			 * @since 2.0.0
			 * @param array $defaults The default args.
			 * @return array
			 */
			public function query( $defaults ) {

				global $fusion_settings;
				$live_request = false;

				// From Ajax Request.
				if ( isset( $_POST['model'] ) && isset( $_POST['model']['params'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
					$defaults     = $_POST['model']['params']; // phpcs:ignore WordPress.Security
					$return_data  = [];
					$live_request = true;
					fusion_set_live_data();
				}

				// Convert all attributes to correct values for WP query.
				$defaults['posts_per_page'] = $defaults['number_posts'];

				if ( isset( $defaults['title'] ) && $defaults['title'] ) {
					$defaults['show_title'] = $defaults['title'];
					unset( $defaults['title'] );
				}

				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				if ( is_front_page() || is_home() ) {
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
				}

				$defaults['paged'] = $paged;

				if ( '0' == $defaults['offset'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
					$defaults['offset'] = '';
				}

				if ( 'tag' !== $defaults['pull_by'] ) {
					// Check for cats to exclude; needs to be checked via exclude_cats param
					// and '-' prefixed cats on cats param exclusion via exclude_cats param.
					$cats_to_exclude    = explode( ',', $defaults['exclude_cats'] );
					$cats_id_to_exclude = [];
					if ( $cats_to_exclude ) {
						foreach ( $cats_to_exclude as $cat_to_exclude ) {
							$id_obj = get_category_by_slug( $cat_to_exclude );
							if ( $id_obj ) {
								$cats_id_to_exclude[] = $id_obj->term_id;
							}
						}
						if ( $cats_id_to_exclude ) {
							$defaults['category__not_in'] = $cats_id_to_exclude;
						}
					}

					// Setting up cats to be used and exclusion using '-' prefix on cats param; transform slugs to ids.
					$cat_ids = '';
					if ( '' !== $defaults['cat_slug'] ) {
						$categories = explode( ',', $defaults['cat_slug'] );
						if ( isset( $categories ) && $categories ) {
							foreach ( $categories as $category ) {

								$id_obj = get_category_by_slug( $category );

								if ( $id_obj ) {
									$cat_ids .= ( 0 === strpos( $category, '-' ) ) ? '-' . $id_obj->cat_ID . ',' : $id_obj->cat_ID . ',';
								}
							}
						}
					}
					$defaults['cat'] = substr( $cat_ids, 0, -1 );
				} else {
					// Check for tags to exclude; needs to be checked via exclude_tags param
					// and '-' prefixed tags on tags param exclusion via exclude_tags param.
					$tags_to_exclude    = explode( ',', $defaults['exclude_tags'] );
					$tags_id_to_exclude = [];
					if ( $tags_to_exclude ) {
						foreach ( $tags_to_exclude as $tag_to_exclude ) {
							$id_obj = get_term_by( 'slug', $tag_to_exclude, 'post_tag' );
							if ( $id_obj ) {
								$tags_id_to_exclude[] = $id_obj->term_id;
							}
						}
						if ( $tags_id_to_exclude ) {
							$defaults['tag__not_in'] = $tags_id_to_exclude;
						}
					}

					// Setting up tags to be used.
					$tag_ids = [];
					if ( '' !== $defaults['tag_slug'] ) {
						$tags = explode( ',', $defaults['tag_slug'] );
						if ( isset( $tags ) && $tags ) {
							foreach ( $tags as $tag ) {
								$id_obj = get_term_by( 'slug', $tag, 'post_tag' );

								if ( $id_obj ) {
									$tag_ids[] = $id_obj->term_id;
								}
							}
						}
					}
					$defaults['tag__in'] = $tag_ids;
				}

				if ( '' === $defaults['post_status'] ) {
					unset( $defaults['post_status'] );
				} else {
					$defaults['post_status'] = explode( ',', $defaults['post_status'] );
				}

				$fusion_query = fusion_cached_query( $defaults );

				wp_reset_postdata();

				if ( ! $live_request ) {
					return $fusion_query;
				}

				if ( ! $fusion_query->have_posts() ) {
					$return_data['placeholder'] = fusion_builder_placeholder( 'post', 'blog posts' );
					echo wp_json_encode( $return_data );
					wp_die();
				}

				$return_data['paged']         = $paged;
				$return_data['max_num_pages'] = $fusion_query->max_num_pages;
				$regular_images_found         = false;

				if ( $fusion_query->have_posts() ) {
					while ( $fusion_query->have_posts() ) {
						$fusion_query->the_post();

						$id        = get_the_ID();
						$title     = get_the_title();
						$permalink = get_the_permalink();

						// Slideshow data.
						$thumbnail             = $video = false;
						$featured_image_width  = get_post_meta( $id, 'pyre_fimg_width', true );
						$featured_image_height = get_post_meta( $id, 'pyre_fimg_height', true );

						$video = fusion_get_page_option( 'video', $id );

						if ( has_post_thumbnail() ) {
							$thumbnail = true;
						}

						$multiple_featured = $featured = [];
						$i                 = 2;

						$image_sizes = [ 'full', 'blog-medium', 'blog-large' ];
						while ( $i <= $fusion_settings->get( 'posts_slideshow_number' ) ) {
							$attachment_id = function_exists( 'fusion_get_featured_image_id' ) ? fusion_get_featured_image_id( 'featured-image-' . $i, 'post' ) : '';
							if ( $attachment_id ) {

								$attachment_data = wp_get_attachment_metadata( $attachment_id );
								$full_image      = wp_get_attachment_image_src( $attachment_id, 'full' );

								$featured['full_src'] = $full_image[0];

								if ( is_array( $attachment_data ) ) {

									$image_title   = get_post_field( 'post_title', $attachment_id );
									$image_caption = get_post_field( 'post_excerpt', $attachment_id );
									$image_alt     = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

									$featured['title']   = $image_title;
									$featured['caption'] = $image_caption;
									$featured['alt']     = $image_alt;
								}

								foreach ( $image_sizes as $image_size ) {
									$attachment_image        = wp_get_attachment_image_src( $attachment_id, $image_size );
									$image_markup            = '<img src="' . $attachment_image[0] . '" role="presentation"/>';
									$featured[ $image_size ] = $image_markup;
								}
								$multiple_featured[] = $featured;
							}
							$i++;
						}

						// Masonry Attributes.
						$masonry_attributes = [];

						// Set image or placeholder and correct corresponding styling.
						if ( has_post_thumbnail() ) {
							$post_thumbnail_attachment = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
							$masonry_attribute_style   = 'background-image:url(' . $post_thumbnail_attachment[0] . ');';
						} else {
							$post_thumbnail_attachment = [];
							$masonry_attribute_style   = 'background-color:#f6f6f6;';
						}

						// Get the correct image orientation class.
						$element_orientation_class = fusion_library()->images->get_element_orientation_class( get_post_thumbnail_id(), $post_thumbnail_attachment, $defaults['blog_masonry_grid_ratio'], $defaults['blog_masonry_width_double'] );
						$element_base_padding      = fusion_library()->images->get_element_base_padding( $element_orientation_class );

						// Check if we have a landscape image, then it has to stretch over 2 cols.
						if ( 'fusion-element-landscape' !== $element_orientation_class ) {
							$regular_images_found = true;
						}

						$masonry_data = [
							'element_orientation_class' => $element_orientation_class,
							'element_base_padding'      => $element_base_padding,
							'timeline_color'            => Fusion_Sanitize::color( $fusion_settings->get( 'timeline_color' ) ),
							'masonry_attribute_style'   => $masonry_attribute_style,
						];

						if ( ! empty( $post_thumbnail_attachment ) ) {
							$masonry_data['image_width']  = $post_thumbnail_attachment[1];
							$masonry_data['image_height'] = $post_thumbnail_attachment[2];
						}

						$masonry_data['specific_element_orientation_class'] = ( '' !== get_post_meta( get_post_thumbnail_id(), 'fusion_masonry_element_layout', true ) ) ? true : false;

						$image_data                 = fusion_get_image_data( $id, $image_sizes, $permalink );
						$image_data['masonry_data'] = $masonry_data;

						$slideshow = [
							'featured_image_width'  => $featured_image_width,
							'featured_image_height' => $featured_image_height,
							'id'                    => $id,
							'title'                 => $title,
							'permalink'             => $permalink,
							'multiple_featured'     => $multiple_featured,
							'thumbnail'             => $thumbnail,
							'video'                 => $video,
							'image_data'            => $image_data,
						];

						$post_timestamp = get_the_time( 'U' );

						$meta_data = fusion_get_meta_data( $id );

						$timeline_comments = '';
						if ( ! post_password_required( $id ) ) {
							$comments_icon = '<i ' . FusionBuilder::attributes( 'fusion-icon-bubbles' ) . '></i>&nbsp;';
							$comments      = '<i class="fusion-icon-bubbles"></i>&nbsp;' . esc_attr__( 'Protected', 'fusion-builder' );
							ob_start();
							comments_popup_link( $comments_icon . '0', $comments_icon . '1', $comments_icon . '%' );
							$timeline_comments = ob_get_contents();
							ob_get_clean();
						}

						$post_video = apply_filters( 'fusion_builder_post_video', '', $id );

						$post_class = false;
						$classes    = get_post_class( [], $id );
						if ( $classes && is_array( $classes ) ) {
							$post_class = ' ' . implode( ' ', $classes ) . ' ';
						}
						$content = fusion_get_content_data( 'fusion_blog' );

						if ( has_excerpt( $id ) ) {
							$content['has_custom_excerpt'] = true;
						} else {
							$content['has_custom_excerpt'] = false;
						}

						$return_data['posts'][] = [
							'id'                        => $id,
							'title'                     => $title,
							'permalink'                 => $permalink,
							'post_month'                => date( 'n', $post_timestamp ),
							'post_year'                 => get_the_date( 'Y' ),
							'timeline_date_format'      => get_the_date( $fusion_settings->get( 'timeline_date_format' ) ),
							'post_video'                => $post_video,
							'post_class'                => $post_class,
							'slideshow'                 => $slideshow,
							'alternate_date_format_day' => get_the_time( $fusion_settings->get( 'alternate_date_format_day' ) ),
							'alternate_date_format_month_year' => get_the_time( $fusion_settings->get( 'alternate_date_format_month_year' ) ),
							'format'                    => get_post_format(),
							'meta_data'                 => $meta_data,
							'link_icon_target'          => apply_filters( 'fusion_builder_link_icon_target', '', $id ),
							'post_links_target'         => apply_filters( 'fusion_builder_post_links_target', '', $id ),
							'content'                   => $content,
							'timeline_comments'         => $timeline_comments,
						];
					}
				}
				$return_data['regular_images_found'] = $regular_images_found;
				echo wp_json_encode( $return_data );
				wp_die();
			}

			/**
			 * Render the shortcode
			 *
			 * @access public
			 * @since 1.0
			 * @param  array  $args    Shortcode parameters.
			 * @param  string $content Content between shortcode.
			 * @return string          HTML output.
			 */
			public function render( $args, $content = '' ) {
				global $fusion_settings;

				$defaults = FusionBuilder::set_shortcode_defaults( self::get_element_defaults(), $args, 'fusion_blog' );

				$defaults['blog_grid_column_spacing'] = FusionBuilder::validate_shortcode_attr_value( $defaults['blog_grid_column_spacing'], '' );

				if ( isset( $args['padding_top'] ) && '' !== $args['padding_top'] ) {
					$defaults['blog_grid_padding']['top'] = $args['padding_top'];
				}
				if ( isset( $args['padding_right'] ) && '' !== $args['padding_right'] ) {
					$defaults['blog_grid_padding']['right'] = $args['padding_right'];
				}
				if ( isset( $args['padding_bottom'] ) && '' !== $args['padding_bottom'] ) {
					$defaults['blog_grid_padding']['bottom'] = $args['padding_bottom'];
				}
				if ( isset( $args['padding_left'] ) && '' !== $args['padding_left'] ) {
					$defaults['blog_grid_padding']['left'] = $args['padding_left'];
				}
				// Re-index the array to set the correct values.
				if ( ! isset( $args['blog_grid_padding'] ) ) {
					$defaults['blog_grid_padding'] = [
						$defaults['blog_grid_padding']['top'],
						$defaults['blog_grid_padding']['right'],
						$defaults['blog_grid_padding']['bottom'],
						$defaults['blog_grid_padding']['left'],
					];
				}

				if ( $defaults['title'] ) {
					$defaults['show_title'] = $defaults['title'];
				}
				unset( $defaults['title'] );

				extract( $defaults );

				$defaults['scrolling'] = ( isset( $defaults['paging'] ) && 'no' === $defaults['paging'] && 'pagination' === $defaults['scrolling'] ) ? 'no' : $defaults['scrolling'];

				if ( -1 == $defaults['number_posts'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
					$defaults['scrolling'] = 'no';
				}

				// Add hyphens for alternate layout options.
				if ( 'large alternate' === $defaults['layout'] ) {
					$defaults['layout'] = 'large-alternate';
				} elseif ( 'medium alternate' === $defaults['layout'] ) {
					$defaults['layout'] = 'medium-alternate';
				}

				$defaults['load_more'] = false;
				if ( 'no' !== $defaults['scrolling'] ) {
					if ( 'load_more_button' === $defaults['scrolling'] ) {
						$defaults['load_more'] = true;
						$defaults['scrolling'] = 'infinite';
					}
				}

				$defaults['meta_all']        = ( 'yes' === $defaults['meta_all'] );
				$defaults['meta_author']     = ( 'yes' === $defaults['meta_author'] );
				$defaults['meta_categories'] = ( 'yes' === $defaults['meta_categories'] );
				$defaults['meta_comments']   = ( 'yes' === $defaults['meta_comments'] );
				$defaults['meta_date']       = ( 'yes' === $defaults['meta_date'] );
				$defaults['meta_link']       = ( 'yes' === $defaults['meta_link'] );
				$defaults['meta_tags']       = ( 'yes' === $defaults['meta_tags'] );
				$defaults['strip_html']      = ( 'yes' === $defaults['strip_html'] );
				$defaults['thumbnail']       = ( 'yes' === $defaults['thumbnail'] );
				$defaults['show_title']      = ( 'yes' === $defaults['show_title'] );
				$defaults['title_link']      = ( 'yes' === $defaults['title_link'] );

				if ( isset( $args['excerpt_words'] ) && ! isset( $args['excerpt_length'] ) ) {
					$defaults['excerpt_length'] = $args['excerpt_words'];
				}

				// Combine meta info into one variable.
				$defaults['meta_info_combined'] = $defaults['meta_all'] * ( $defaults['meta_author'] + $defaults['meta_date'] + $defaults['meta_categories'] + $defaults['meta_tags'] + $defaults['meta_comments'] + $defaults['meta_link'] );
				// Create boolean that holds info whether content should be excerpted.
				$defaults['is_zero_excerpt'] = ( 'yes' === $defaults['excerpt'] && $defaults['excerpt_length'] < 1 ) ? 1 : 0;

				if ( '0' === $defaults['blog_grid_column_spacing'] ) {
					$defaults['blog_grid_column_spacing'] = '0.0';
				}

				$defaults['blog_sc_query'] = true;

				$this->args = $defaults;

				// Set the meta info settings for later use.
				$this->meta_info_settings['post_meta']          = $defaults['meta_all'];
				$this->meta_info_settings['post_meta_author']   = $defaults['meta_author'];
				$this->meta_info_settings['post_meta_date']     = $defaults['meta_date'];
				$this->meta_info_settings['post_meta_cats']     = $defaults['meta_categories'];
				$this->meta_info_settings['post_meta_tags']     = $defaults['meta_tags'];
				$this->meta_info_settings['post_meta_comments'] = $defaults['meta_comments'];

				$fusion_query = $this->query( $defaults );

				$this->query = $fusion_query;

				$posts = '';

				// Initialize the time stamps for timeline month/year check.
				if ( 'timeline' === $this->args['layout'] ) {
					$this->post_count = 1;

					$prev_post_timestamp = null;
					$prev_post_month     = null;
					$prev_post_year      = null;
					$first_timeline_loop = false;
				}

				// Do the loop.
				if ( $fusion_query->have_posts() ) {

					if ( 'masonry' === $this->args['layout'] ) {
						$posts .= '<article class="fusion-post-grid fusion-post-masonry post fusion-grid-sizer"></article>';
					}

					while ( $fusion_query->have_posts() ) :
						$fusion_query->the_post();

						$this->post_id   = get_the_ID();
						$this->permalink = get_the_permalink();

						if ( 'private' === get_post_status() && ! is_user_logged_in() || in_array( get_post_status(), [ 'pending', 'draft', 'future' ], true ) && ! current_user_can( 'edit-post' ) ) {
							$this->permalink = '#';
						}

						if ( 'timeline' === $this->args['layout'] ) {
							// Set the time stamps for timeline month/year check.
							$post_timestamp   = get_the_time( 'U' );
							$this->post_month = date( 'n', $post_timestamp );
							$this->post_year  = get_the_date( 'Y' );
							$current_date     = get_the_date( 'Y-n' );

							$date_params['prev_post_month'] = $prev_post_month;
							$date_params['post_month']      = $this->post_month;
							$date_params['prev_post_year']  = $prev_post_year;
							$date_params['post_year']       = $this->post_year;

							// Set the timeline month label.
							ob_start();
							do_action( 'fusion_blog_shortcode_timeline_date', $date_params );
							$timeline_date = ob_get_contents();
							ob_get_clean();

							$posts .= $timeline_date;
						}

						ob_start();
						do_action( 'fusion_blog_shortcode_before_loop' );
						$before_loop_action = ob_get_contents();
						ob_get_clean();

						$posts .= $before_loop_action;

						if ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] || 'timeline' === $this->args['layout'] ) {
							$posts .= '<div ' . FusionBuilder::attributes( 'blog-fusion-post-wrapper' ) . '>';
						}

						$this->header = [
							'title_link' => true,
						];

						ob_start();
						do_action( 'fusion_blog_shortcode_loop_header' );

						do_action( 'fusion_blog_shortcode_loop_content' );

						do_action( 'fusion_blog_shortcode_loop_footer' );

						do_action( 'fusion_blog_shortcode_after_loop' );
						$loop_actions = ob_get_contents();
						ob_get_clean();

						$posts .= $loop_actions;

						if ( 'timeline' === $this->args['layout'] ) {
							$prev_post_timestamp = $post_timestamp;
							$prev_post_month     = $this->post_month;
							$prev_post_year      = $this->post_year;
							$this->post_count++;
						}

					endwhile;
				} else {

					$this->blog_sc_counter++;
					return fusion_builder_placeholder( 'post', 'blog posts' );

				}

				// Prepare needed wrapping containers.
				$html = '';

				$html .= '<div ' . FusionBuilder::attributes( 'blog-shortcode' ) . '>';

				if ( ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] ) && $this->args['blog_grid_column_spacing'] ) {
					$html .= '<style type="text/css">.fusion-blog-shortcode-' . $this->blog_sc_counter . ' .fusion-blog-layout-grid .fusion-post-grid{padding:' . ( $defaults['blog_grid_column_spacing'] / 2 ) . 'px;}.fusion-blog-shortcode-' . $this->blog_sc_counter . ' .fusion-posts-container{margin-left: -' . ( $defaults['blog_grid_column_spacing'] / 2 ) . 'px !important; margin-right:-' . $defaults['blog_grid_column_spacing'] / 2 . 'px !important;}</style>';
				}

				$html .= '<div ' . FusionBuilder::attributes( 'blog-shortcode-posts-container' ) . '>';

				ob_start();
				do_action( 'fusion_blog_shortcode_wrap_loop_open' );
				$wrap_loop_open = ob_get_contents();
				ob_get_clean();

				$html .= $wrap_loop_open;

				$html .= $posts;

				ob_start();
				do_action( 'fusion_blog_shortcode_wrap_loop_close' );

				$wrap_loop_close_action = ob_get_contents();
				ob_get_clean();

				$html .= $wrap_loop_close_action;

				$html .= '</div>';

				if ( 'no' !== $this->args['scrolling'] ) {
					$pagination = $this->pagination( $this->query->max_num_pages, $fusion_settings->get( 'pagination_range' ), $this->query );

					$html .= $pagination;
				}

				// If infinite scroll with "load more" button is used.
				if ( $this->args['load_more'] && 1 < $this->query->max_num_pages ) {
					$html .= '<div class="fusion-load-more-button fusion-blog-button fusion-clearfix">' . apply_filters( 'avada_load_more_posts_name', esc_attr__( 'Load More Posts', 'fusion-builder' ) ) . '</div>';
				}

				$html .= '</div>';

				wp_reset_postdata();

				$this->blog_sc_counter++;

				return $html;

			}

			/**
			 * Render the blog pagination.
			 *
			 * @access public
			 * @since 1.0
			 * @param int    $max_pages     Max number of pages.
			 * @param int    $range         How many page numbers to display to either side of the current page.
			 * @param object $current_query The query.
			 */
			public function pagination( $max_pages = '', $range = 1, $current_query = '' ) {
				global $wp_query;

				$range = apply_filters( 'fusion_pagination_size', $range );

				if ( '' === $max_pages ) {
					if ( '' === $current_query ) {
						$max_pages = $wp_query->max_num_pages;
						$max_pages = ( ! $max_pages ) ? 1 : $max_pages;
					} else {
						$max_pages = $current_query->max_num_pages;
					}
				}
				$max_pages = intval( $max_pages );

				$blog_global_pagination = apply_filters( 'fusion_builder_blog_pagination', '' );
				$infinite_pagination    = 'pagination' !== $this->args['scrolling'] && 'pagination' !== strtolower( $blog_global_pagination );
				$pagination_html        = fusion_pagination( $max_pages, $range, $current_query, $infinite_pagination, true );

				return apply_filters( 'fusion_builder_blog_pagination_html', $pagination_html, $max_pages, $range, $current_query, $blog_global_pagination );
			}

			/**
			 * Builds the attributes array.
			 *
			 * @access public
			 * @since 1.0
			 * @return array
			 */
			public function attr() {

				$attr = [];

				// Set the correct layout class.
				$blog_layout = 'fusion-blog-layout-' . $this->args['layout'];
				if ( 'timeline' === $this->args['layout'] ) {
					$blog_layout = 'fusion-blog-layout-timeline-wrapper';
				} elseif ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] ) {
					$blog_layout = 'fusion-blog-layout-grid-wrapper';
				}

				$attr['class'] = 'fusion-blog-shortcode fusion-blog-shortcode-' . $this->blog_sc_counter . ' fusion-blog-archive ' . $blog_layout . ' fusion-blog-' . $this->args['scrolling'];

				$attr = fusion_builder_visibility_atts( $this->args['hide_on_mobile'], $attr );

				if ( ! $this->args['thumbnail'] ) {
					$attr['class'] .= ' fusion-blog-no-images';
				}

				if ( $this->args['content_alignment'] && ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] || 'timeline' === $this->args['layout'] ) ) {
					$attr['class'] .= ' fusion-blog-layout-' . $this->args['content_alignment'];
				}

				if ( $this->args['class'] ) {
					$attr['class'] .= ' ' . $this->args['class'];
				}

				if ( 0 === $this->args['blog_grid_column_spacing'] || '0' === $this->args['blog_grid_column_spacing'] || '0px' === $this->args['blog_grid_column_spacing'] ) {
					$attr['class'] .= ' fusion-no-col-space';
				}

				if ( $this->args['id'] ) {
					$attr['id'] = $this->args['id'];
				}

				return $attr;

			}

			/**
			 * Builds the posts-container attributes array.
			 *
			 * @access public
			 * @since 1.0
			 * @return array
			 */
			public function posts_container_attr() {
				global $post, $fusion_settings;

				$attr = [];

				$load_more = '';
				if ( $this->args['load_more'] ) {
					$load_more = ' fusion-posts-container-load-more';
				}

				$attr['class'] = 'fusion-posts-container fusion-posts-container-' . $this->args['scrolling'] . $load_more;

				if ( ! $this->args['meta_info_combined'] ) {
					$attr['class'] .= ' fusion-no-meta-info';
				}

				// Add class if rollover is enabled.
				if ( $fusion_settings->get( 'image_rollover' ) && $this->args['thumbnail'] ) {
					$attr['class'] .= ' fusion-blog-rollover';
				}

				$attr['data-pages'] = $this->query->max_num_pages;

				if ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] ) {
					$attr['class'] .= ' fusion-blog-layout-grid fusion-blog-layout-grid-' . $this->args['blog_grid_columns'] . ' isotope';

					if ( 'masonry' === $this->args['layout'] ) {
						$attr['class'] .= ' fusion-blog-layout-masonry';
					}

					if ( 'grid' === $this->args['layout'] ) {
						if ( 'yes' === $this->args['equal_heights'] ) {
							$attr['class'] .= ' fusion-blog-equal-heights';
						}
					}

					if ( $this->args['blog_grid_column_spacing'] || '0' === $this->args['blog_grid_column_spacing'] ) {
						$attr['data-grid-col-space'] = $this->args['blog_grid_column_spacing'];
					}

					$negative_margin = ( -1 ) * $this->args['blog_grid_column_spacing'] / 2;

					$min_height = 'min-height:500px;';

					if ( '1' === $this->args['posts_per_page'] ) {
						$min_height = '';
					}

					$attr['style'] = 'margin: ' . $negative_margin . 'px ' . $negative_margin . 'px 0;' . $min_height;
				}

				return $attr;

			}

			/**
			 * Opens the wrapper.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function wrap_loop_open() {
				global $post;

				$wrapper = $class_timeline_icon = '';

				if ( 'timeline' === $this->args['layout'] ) {

					$wrapper  = '<div ' . FusionBuilder::attributes( 'fusion-timeline-icon' . $class_timeline_icon ) . '>';
					$wrapper .= '<i ' . FusionBuilder::attributes( 'fusion-icon-bubbles' ) . ' style="color:' . $this->args['grid_element_color'] . ';"></i>';
					$wrapper .= '</div>';
					$wrapper .= '<div ' . FusionBuilder::attributes( 'fusion-blog-layout-timeline fusion-clearfix' ) . '>';
					$wrapper .= '<div class="fusion-timeline-line" style="border-left:1px solid ' . $this->args['grid_element_color'] . ';border-right:1px solid ' . $this->args['grid_element_color'] . ';"></div>';
				}

				echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput

			}

			/**
			 * Closes the wrapper.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function wrap_loop_close() {

				$wrapper = '';

				if ( 'timeline' === $this->args['layout'] ) {
					if ( $this->post_count > 1 ) {
						$wrapper = '</div>';
					}
					$wrapper .= '</div>';
				}

				if ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] ) {
					$wrapper .= '<div class="fusion-clearfix"></div>';
				}

				echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput

			}

			/**
			 * Add HTML before the loop.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function before_loop() {
				echo '<!-- Beginning -->';
				echo '<article ' . FusionBuilder::attributes( 'blog-shortcode-loop' ) . '>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput
			}

			/**
			 * Adds markup after the loop.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function after_loop() {
				if ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] || 'timeline' === $this->args['layout'] ) {
					echo '</div>' . "\n";
					echo '</article>' . "\n";
				} else {
					echo '</article>' . "\n";
				}
				echo '<!-- End -->';
			}

			/**
			 * Builds the loop attributes array.
			 *
			 * @access public
			 * @since 1.0
			 * @return array
			 */
			public function loop_attr() {
				$defaults = [
					'post_id'    => '',
					'post_count' => '',
				];

				$attr['id'] = 'blog-' . $this->blog_sc_counter . '-post-' . $this->post_id;

				$extra_classes = [];

				// Add the correct post class.
				$extra_classes[] = 'fusion-post-' . $this->args['layout'];

				if ( is_sticky() ) {
					$extra_classes[] = 'fusion-sticky';
				}

				if ( 'masonry' === $this->args['layout'] ) {
					// Additional grid class needed for masonry layout.
					$extra_classes[] = 'fusion-post-grid';

					// Get the element orientation class.
					$element_orientation_class = '';
					if ( has_post_thumbnail() ) {
						$element_orientation_class = fusion_library()->images->get_element_orientation_class( get_post_thumbnail_id(), [], $this->args['blog_masonry_grid_ratio'], $this->args['blog_masonry_width_double'] );
					}

					$extra_classes[] = $element_orientation_class;
				}

				// Set the correct column class for every post.
				if ( 'timeline' === $this->args['layout'] ) {

					if ( ( $this->post_count % 2 ) > 0 ) {
						$timeline_align = ' fusion-left-column';
					} else {
						$timeline_align = ' fusion-right-column';
					}

					$extra_classes[] = 'fusion-clearfix' . $timeline_align;

					$attr['style'] = 'border-color:' . $this->args['grid_element_color'] . ';';
				}

				// Set the has-post-thumbnail if a video is used. This is needed if no featured image is present.
				$post_video = apply_filters( 'fusion_builder_post_video', $this->post_id );

				if ( $post_video ) {
					$extra_classes[] = 'has-post-thumbnail';
				}

				$post_class = get_post_class( $extra_classes, $this->post_id );

				if ( $post_class && is_array( $post_class ) ) {
					$classes       = implode( ' ', $post_class );
					$attr['class'] = $classes;
				}

				return $attr;

			}

			/**
			 * Adds attributes to the content separator.
			 *
			 * @since 1.3
			 * @access public
			 * @return array
			 */
			public function content_sep_attr() {
				$attr = [
					'class' => 'fusion-content-sep',
					'style' => 'border-color:' . $this->args['grid_separator_color'] . ';',
				];

				$separator_styles_array = explode( '|', $this->args['grid_separator_style_type'] );
				$separator_styles       = '';

				foreach ( $separator_styles_array as $separator_style ) {
					$separator_styles .= ' sep-' . $separator_style;
				}

				$attr['class'] .= $separator_styles;

				return $attr;
			}

			/**
			 * Gets the HTML for masonry featured image..
			 *
			 * @access public
			 * @since 1.2
			 * @return string
			 */
			public function get_featured_image_masonry() {

				global $fusion_settings;

				$lazy_load                 = $fusion_settings->get( 'lazy_load' );
				$responsive_images_columns = $this->args['blog_grid_columns'];
				$masonry_attributes        = [];
				$element_base_padding      = 0.8;

				// Set image or placeholder and correct corresponding styling.
				if ( has_post_thumbnail() ) {
					$post_thumbnail_attachment = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$masonry_attribute_style   = $lazy_load ? '' : 'background-image:url(' . $post_thumbnail_attachment[0] . ');';
				} else {
					$post_thumbnail_attachment = [];
					$masonry_attribute_style   = 'background-color:#f6f6f6;';
				}

				// Get the correct image orientation class.
				$element_orientation_class = fusion_library()->images->get_element_orientation_class( get_post_thumbnail_id(), $post_thumbnail_attachment, $this->args['blog_masonry_grid_ratio'], $this->args['blog_masonry_width_double'] );
				$element_base_padding      = fusion_library()->images->get_element_base_padding( $element_orientation_class );

				$masonry_column_offset = ' - ' . ( (int) $this->args['blog_grid_column_spacing'] / 2 ) . 'px';
				if ( false !== strpos( $element_orientation_class, 'fusion-element-portrait' ) ) {
					$masonry_column_offset = '';
				}

				$masonry_column_spacing = ( (int) $this->args['blog_grid_column_spacing'] ) . 'px';

				// Calculate the correct size of the image wrapper container, based on orientation and column spacing.
				if ( class_exists( 'Fusion_Sanitize' ) && class_exists( 'Fusion_Color' ) && ! fusion_is_color_transparent( $this->args['grid_element_color'] ) ) {

					$masonry_column_offset = ' - ' . ( (int) $this->args['blog_grid_column_spacing'] / 2 ) . 'px';
					if ( false !== strpos( $element_orientation_class, 'fusion-element-portrait' ) ) {
						$masonry_column_offset = ' + 4px';
					}

					$masonry_column_spacing = ( (int) $this->args['blog_grid_column_spacing'] - 2 ) . 'px';
					if ( false !== strpos( $element_orientation_class, 'fusion-element-landscape' ) ) {
						$masonry_column_spacing = ( (int) $this->args['blog_grid_column_spacing'] - 6 ) . 'px';
					}
				}

				// Check if a featured image is set and also that not a video with no featured image.
				$post_video = apply_filters( 'fusion_builder_post_video', $this->post_id );
				if ( ! empty( $post_thumbnail_attachment ) || ! $post_video ) {

					// Calculate the correct size of the image wrapper container, based on orientation and column spacing.
					$masonry_attribute_style .= 'padding-top:calc((100% + ' . $masonry_column_spacing . ') * ' . $element_base_padding . $masonry_column_offset . ');';
				}

				// Check if we have a landscape image, then it has to stretch over 2 cols.
				if ( '1' !== $this->args['blog_grid_columns'] && 1 !== $this->args['blog_grid_columns'] && false !== strpos( $element_orientation_class, 'fusion-element-landscape' ) ) {
					$responsive_images_columns = (int) $this->args['blog_grid_columns'] / 2;
				}

				// Set the masonry attributes to use them in the first featured image function.
				$masonry_attributes = [
					'class' => 'fusion-masonry-element-container',
					'style' => $masonry_attribute_style,
				];

				if ( $lazy_load && isset( $post_thumbnail_attachment[0] ) ) {
					$masonry_attributes['data-bg'] = $post_thumbnail_attachment[0];
					$masonry_attributes['class']  .= ' lazyload';
				}

				// Get the post image.
				fusion_library()->images->set_grid_image_meta(
					[
						'layout'       => 'portfolio_full',
						'columns'      => $responsive_images_columns,
						'gutter_width' => $this->args['blog_grid_column_spacing'],
					]
				);

				$image = fusion_render_first_featured_image_markup( $this->post_id, 'full', $this->permalink, false, false, false, 'default', 'default', '', '', 'yes', false, $masonry_attributes );

				fusion_library()->images->set_grid_image_meta( [] );

				return $image;
			}

			/**
			 * Gets the HTML for slideshows.
			 *
			 * @access public
			 * @since 1.0
			 * @return string
			 */
			public function get_slideshow() {

				global $fusion_settings;

				$html = '';

				if ( ! post_password_required( $this->post_id ) ) {

					$slideshow = [
						'images' => $this->get_post_thumbnails( $this->post_id, $fusion_settings->get( 'posts_slideshow_number' ) ),
					];

					$post_video = apply_filters( 'fusion_builder_post_video', '', $this->post_id );

					if ( $post_video ) {
						$slideshow['video'] = $post_video;
					}

					if ( 'medium' === $this->args['layout'] || 'medium alternate' === $this->args['layout'] ) {
						$slideshow['size'] = 'blog-medium';
					}

					ob_start();
					$atts = $this->args;

					$atts['loop-id'] = '#blog-' . $this->blog_sc_counter . '-post-';

					include FUSION_BUILDER_PLUGIN_DIR . 'inc/templates/shortcodes/new-slideshow-blog-shortcode.php';

					$post_slideshow_action = ob_get_contents();
					ob_get_clean();

					$html .= $post_slideshow_action;
				}

				return $html;
			}

			/**
			 * Gets the post thumbnails.
			 *
			 * @access public
			 * @since 1.0
			 * @param int $post_id The post-ID.
			 * @param int $count   How many thumbnails.
			 * @return array
			 */
			public function get_post_thumbnails( $post_id, $count = '' ) {

				global $fusion_settings;

				$attachment_ids = [];

				if ( get_post_thumbnail_id( $post_id ) ) {
					$attachment_ids[] = get_post_thumbnail_id( $post_id );
				}

				$i                      = 2;
				$posts_slideshow_number = $fusion_settings->get( 'posts_slideshow_number' );
				if ( '' === $posts_slideshow_number ) {
					$posts_slideshow_number = 5;
				}
				while ( $i <= $posts_slideshow_number ) {

					if ( function_exists( 'fusion_get_featured_image_id' ) && fusion_get_featured_image_id( 'featured-image-' . $i, 'post' ) ) {
						$attachment_ids[] = fusion_get_featured_image_id( 'featured-image-' . $i, 'post' );
					}

					$i++;
				}

				if ( isset( $count ) && $count >= 1 ) {
					$attachment_ids = array_slice( $attachment_ids, 0, $count );
				}

				return $attachment_ids;

			} // End get_post_thumbnails().

			/**
			 * Adds the loop-header HTML.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function loop_header() {
				global $fusion_settings;

				$defaults = [
					'title_link' => false,
				];

				$args = wp_parse_args( $this->header, $defaults );

				$pre_title_content = $meta_data = $content_sep = $link = '';

				if ( $this->args['thumbnail'] && 'medium-alternate' !== $this->args['layout'] ) {

					// Masonry layout.
					if ( 'masonry' === $this->args['layout'] ) {
						$pre_title_content = $this->get_featured_image_masonry();
					} else {
						$pre_title_content = $this->get_slideshow();
					}
				}

				if ( 'medium-alternate' === $this->args['layout'] || 'large-alternate' === $this->args['layout'] ) {
					$pre_title_content .= '<div ' . FusionBuilder::attributes( 'fusion-date-and-formats' ) . '>';
					ob_start();
					do_action( 'fusion_blog_shortcode_date_and_format' );
					$pre_title_content .= ob_get_contents();
					ob_get_clean();
					$pre_title_content .= '</div>';

					if ( $this->args['thumbnail'] && 'medium-alternate' === $this->args['layout'] ) {
						$pre_title_content .= $this->get_slideshow();
					}

					if ( $this->args['meta_all'] ) {
						$meta_data .= fusion_builder_render_post_metadata( 'alternate', $this->meta_info_settings );
					}
				}

				if ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] || 'timeline' === $this->args['layout'] ) {
					$content_wrapper_styles = '';
					$is_there_meta_above    = 0 < $this->args['meta_all'] * ( $this->args['meta_author'] + $this->args['meta_date'] + $this->args['meta_categories'] + $this->args['meta_tags'] );
					$is_there_meta_below    = $this->args['meta_all'] * $this->args['meta_comments'] || $this->args['meta_all'] * $this->args['meta_link'];
					$is_there_content       = 'no' === $this->args['excerpt'] || ( 'yes' === $this->args['excerpt'] && ! $this->args['is_zero_excerpt'] );

					// See 7199.
					if ( 'masonry' !== $this->args['layout'] && ( ( $this->args['show_title'] && $is_there_meta_above && ( $is_there_content || $is_there_meta_below ) ) || ( $this->args['show_title'] && ! $is_there_meta_above && $is_there_meta_below ) ) ) {
						$content_sep = '<div ' . FusionBuilder::attributes( 'blog-fusion-content-sep' ) . '></div>';
					}

					if ( $this->args['meta_all'] ) {
						$meta_data .= fusion_builder_render_post_metadata( 'grid_timeline', $this->meta_info_settings );
					}
					$pre_title_content .= '<div ' . FusionBuilder::attributes( 'blog-shortcode-post-content-wrapper' ) . '>';
				}

				$pre_title_content .= '<div ' . FusionBuilder::attributes( 'fusion-post-content post-content' ) . '>';

				if ( $this->args['show_title'] ) {
					if ( $this->args['title_link'] ) {
						$link_target       = '';
						$link_icon_target  = apply_filters( 'fusion_builder_link_icon_target', '', $this->post_id );
						$post_links_target = apply_filters( 'fusion_builder_post_links_target', '', $this->post_id );

						if ( 'yes' === $link_icon_target || 'yes' === $post_links_target ) {
							$link_target = ' target="_blank" rel="noopener noreferrer"';
						}

						$link = '<a href="' . esc_url( $this->permalink ) . '"' . $link_target . '>' . get_the_title() . '</a>';
					} else {
						$link = get_the_title();
					}
				}

				if ( 'timeline' === $this->args['layout'] ) {
					$pre_title_content .= '<div ' . FusionBuilder::attributes( 'fusion-timeline-circle' ) . ' style="background-color:' . $this->args['grid_element_color'] . ';"></div>';
					$pre_title_content .= '<div ' . FusionBuilder::attributes( 'fusion-timeline-arrow' ) . ' style="color:' . $this->args['grid_element_color'] . ';"></div>';
				}
				if ( '' !== $link ) {
					$link = '<h2 ' . FusionBuilder::attributes( 'blog-shortcode-post-title' ) . '>' . $link . '</h2>';
				}
				$html = $pre_title_content . $link . $meta_data . $content_sep;

				echo $html; // phpcs:ignore WordPress.Security.EscapeOutput

			} // End loop_header().

			/**
			 * Builds the post-title attributes array.
			 *
			 * @access public
			 * @since 1.0
			 * @return array
			 */
			public function post_title_attr() {

				global $fusion_settings;

				$attr = [];

				$attr['class'] = 'blog-shortcode-post-title';

				if ( $fusion_settings->get( 'disable_date_rich_snippet_pages' ) && $fusion_settings->get( 'disable_rich_snippet_title' ) ) {
					$attr['class'] .= ' entry-title';
				}

				return $attr;

			}

			/**
			 * Builds the fusion-post-title-wrapper attributes array.
			 *
			 * @access public
			 * @since 1.2
			 * @return array
			 */
			public function post_content_wrapper_attr() {
				global $fusion_settings;

				$attr = [
					'class' => 'fusion-post-content-wrapper',
				];

				if ( 'grid' === $this->args['layout'] || 'timeline' === $this->args['layout'] || 'masonry' === $this->args['layout'] ) {
					$padding       = ( is_array( $this->args['blog_grid_padding'] ) ) ? implode( ' ', $this->args['blog_grid_padding'] ) : $this->args['blog_grid_padding'];
					$attr['style'] = 'padding:' . $padding . ';';

					if ( 'masonry' === $this->args['layout'] ) {
						$color     = Fusion_Color::new_color( $this->args['grid_box_color'] );
						$color_css = $color->to_css( 'rgba' );
						if ( 0 === $color->alpha ) {
							$color_css = $color->to_css( 'rgb' );
						}
						$attr['style'] .= 'background-color:' . $color_css . ';';
					}

					if ( ! $this->args['meta_info_combined'] && ( $this->args['is_zero_excerpt'] || 'hide' === $this->args['excerpt'] ) && ! $this->args['show_title'] ) {
						$attr['style'] .= ' display:none;';
					}
				}

				return $attr;
			}

			/**
			 * Builds the fusion-post-wrapper attributes array.
			 *
			 * @access public
			 * @since 1.3
			 * @return array
			 */
			public function post_wrapper_attr() {
				$attr = [
					'class' => 'fusion-post-wrapper',
				];

				if ( 'masonry' === $this->args['layout'] ) {
					$color     = Fusion_Color::new_color( $this->args['grid_box_color'] );
					$color_css = $color->to_css( 'rgba' );
					if ( 0 === $color->alpha ) {
						$color_css = $color->to_css( 'rgb' );
					}
					$attr['style'] = 'background-color:' . $color_css . ';';

					$element_color = Fusion_Color::new_color( $this->args['grid_element_color'] );
					if ( fusion_is_color_transparent( $this->args['grid_element_color'] ) ) {
						$attr['class'] .= ' fusion-masonary-is-transparent ';
						$attr['style'] .= 'border:none;';
					} else {
						$attr['style'] .= 'border:1px solid ' . $this->args['grid_element_color'] . ';border-bottom-width:3px;';
					}
				} elseif ( 'grid' === $this->args['layout'] ) {
					$color         = Fusion_Color::new_color( $this->args['grid_box_color'] );
					$color_css     = $color->to_css( 'rgba' );
					$attr['style'] = 'background-color:' . $color_css . ';';

					$element_color = Fusion_Color::new_color( $this->args['grid_element_color'] );
					if ( fusion_is_color_transparent( $this->args['grid_element_color'] ) ) {
						$attr['style'] .= 'border:none;';
					} else {
						$attr['style'] .= 'border:1px solid ' . $this->args['grid_element_color'] . ';border-bottom-width:3px;';
					}
				} elseif ( 'timeline' === $this->args['layout'] ) {
					$color         = Fusion_Color::new_color( $this->args['grid_box_color'] );
					$color_css     = $color->to_css( 'rgba' );
					$attr['style'] = 'background-color:' . $color_css . ';';
				}
				return $attr;
			}

			/**
			 * Adds the loop-footer HTML.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function loop_footer() {
				if ( in_array( $this->args['layout'], [ 'grid', 'masonry', 'timeline' ], true ) ) {
					echo '</div>';

					if ( 0 < $this->args['meta_info_combined'] && ( $this->args['meta_comments'] || $this->args['meta_link'] ) ) {
						$inner_content  = $this->read_more();
						$inner_content .= $this->grid_timeline_comments();

						echo '<div class="fusion-meta-info">' . $inner_content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput
					}
				}

				echo '</div>';
				echo '<div class="fusion-clearfix"></div>';

				if ( 0 < $this->args['meta_info_combined'] && in_array( $this->args['layout'], [ 'large', 'medium' ], true ) ) {
					echo '<div class="fusion-meta-info">' . fusion_builder_render_post_metadata( 'standard', $this->meta_info_settings ) . $this->read_more() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput
				}

				if ( $this->args['meta_all'] && in_array( $this->args['layout'], [ 'large-alternate', 'medium-alternate' ], true ) ) {
					echo $this->read_more(); // phpcs:ignore WordPress.Security.EscapeOutput
				}

			}

			/**
			 * Adds the date box.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function add_date_box() {

				global $fusion_settings;

				$inner_content  = '<div ' . FusionBuilder::attributes( 'fusion-date-box updated' ) . '>';
				$inner_content .= '<span ' . FusionBuilder::attributes( 'fusion-date' ) . '>' . get_the_time( $fusion_settings->get( 'alternate_date_format_day' ) ) . '</span>';
				$inner_content .= '<span ' . FusionBuilder::attributes( 'fusion-month-year' ) . '>' . get_the_time( $fusion_settings->get( 'alternate_date_format_month_year' ) ) . '</span>';
				$inner_content .= '</div>';

				echo $inner_content; // phpcs:ignore WordPress.Security.EscapeOutput

			}

			/**
			 * Adds the format box.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function add_format_box() {

				switch ( get_post_format() ) {
					case 'gallery':
						$format_class = 'images';
						break;
					case 'link':
						$format_class = 'link';
						break;
					case 'image':
						$format_class = 'image';
						break;
					case 'quote':
						$format_class = 'quotes-left';
						break;
					case 'video':
						$format_class = 'film';
						break;
					case 'audio':
						$format_class = 'headphones';
						break;
					case 'chat':
						$format_class = 'bubbles';
						break;
					default:
						$format_class = 'pen';
						break;
				}

				$inner_content  = '<div ' . FusionBuilder::attributes( 'fusion-format-box' ) . '>';
				$inner_content .= '<i ' . FusionBuilder::attributes( 'fusion-icon-' . $format_class ) . '></i>';
				$inner_content .= '</div>';

				echo $inner_content; // phpcs:ignore WordPress.Security.EscapeOutput

			}

			/**
			 * Adds the timeline date.
			 *
			 * @access public
			 * @since 1.0
			 * @param array $date_params The date parameters.
			 */
			public function timeline_date( $date_params ) {

				global $fusion_settings;

				$defaults = [
					'prev_post_month' => null,
					'post_month'      => null,
					'prev_post_year'  => null,
					'post_year'       => null,
				];

				$args          = wp_parse_args( $date_params, $defaults );
				$inner_content = '';

				if ( $args['prev_post_month'] !== $args['post_month'] || $args['prev_post_year'] !== $args['post_year'] ) {

					if ( $this->post_count > 1 ) {
						$inner_content = '</div>';
					}

					$inner_content .= '<h3 ' . FusionBuilder::attributes( 'fusion-timeline-date' ) . ' style="background-color:' . $this->args['grid_element_color'] . ';">' . get_the_date( $fusion_settings->get( 'timeline_date_format' ) ) . '</h3>';
					$inner_content .= '<div class="fusion-collapse-month">';
				}

				echo $inner_content; // phpcs:ignore WordPress.Security.EscapeOutput

			}

			/**
			 * The timeline comments for grids.
			 *
			 * @access public
			 * @since 1.0
			 * @return string
			 */
			public function grid_timeline_comments() {

				if ( $this->args['meta_comments'] ) {

					$comments_icon = '<i ' . FusionBuilder::attributes( 'fusion-icon-bubbles' ) . '></i>&nbsp;';

					$comments = '<i class="fusion-icon-bubbles"></i>&nbsp;' . esc_attr__( 'Protected', 'fusion-builder' );

					if ( ! post_password_required( $this->post_id ) ) {
						if ( '#' === $this->permalink ) {
							$comments = '<a href="#">' . $comments_icon . get_comments_number() . '</a>';
						} else {
							ob_start();
							comments_popup_link( $comments_icon . '0', $comments_icon . '1', $comments_icon . '%' );
							$comments = ob_get_contents();
							ob_get_clean();
						}
					}

					$comment_align_class = 'fusion-alignright';
					if ( ( ! $this->args['meta_link'] || ! $this->args['meta_read'] ) && $this->args['content_alignment'] ) {
						$comment_align_class = 'fusion-align' . $this->args['content_alignment'];
					}

					return '<div ' . FusionBuilder::attributes( $comment_align_class ) . '>' . $comments . '</div>';

				}

			}

			/**
			 * The read-more element.
			 *
			 * @access public
			 * @since 1.0
			 * @return string
			 */
			public function read_more() {

				if ( $this->args['meta_link'] ) {
					$inner_content = '';

					if ( $this->args['meta_read'] ) {

						$read_more_wrapper_class = 'fusion-alignright';
						if ( 'grid' === $this->args['layout'] || 'masonry' === $this->args['layout'] || 'timeline' === $this->args['layout'] ) {
							$read_more_wrapper_class = 'fusion-alignleft';

							if ( $this->args['content_alignment'] && ! $this->args['meta_comments'] ) {
								$read_more_wrapper_class = 'fusion-align' . $this->args['content_alignment'];
							}
						}

						$link_target       = '';
						$link_icon_target  = apply_filters( 'fusion_builder_link_icon_target', '', $this->post_id );
						$post_links_target = apply_filters( 'fusion_builder_post_links_target', '', $this->post_id );

						if ( 'yes' === $link_icon_target || 'yes' === $post_links_target ) {
							$link_target = ' target="_blank" rel="noopener noreferrer"';
						}

						$inner_content .= '<div ' . FusionBuilder::attributes( $read_more_wrapper_class ) . '>';

						$inner_content .= '<a class="fusion-read-more" href="' . esc_url( $this->permalink ) . '"' . $link_target . '>';
						$inner_content .= apply_filters( 'avada_read_more_name', esc_attr__( 'Read More', 'fusion-builder' ) );
						$inner_content .= '</a>';
						$inner_content .= '</div>';

						if ( 'large-alternate' === $this->args['layout'] || 'medium-alternate' === $this->args['layout'] ) {
							$inner_content = '<div class="fusion-meta-info">' . $inner_content . '</div>';
						}
					}

					return $inner_content;
				}

			}

			/**
			 * The loop content.
			 *
			 * @access public
			 * @since 1.0
			 * @return void
			 */
			public function loop_content() {

				if ( 'hide' !== $this->args['excerpt'] ) {
					$content = fusion_builder_get_post_content( '', $this->args['excerpt'], $this->args['excerpt_length'], $this->args['strip_html'] );

					echo '<div class="fusion-post-content-container">' . $content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput
				}

			}

			/**
			 * The page links.
			 *
			 * @access public
			 * @since 1.0
			 */
			public function page_links() {
				fusion_link_pages();
			}

			/**
			 * Builds the dynamic styling.
			 *
			 * @access public
			 * @since 1.1
			 * @return array
			 */
			public function add_styling() {

				global $wp_version, $six_fourty_media_query, $three_twenty_six_fourty_media_query, $ipad_portrait_media_query, $content_min_media_query, $small_media_query, $medium_media_query, $large_media_query, $fusion_settings, $dynamic_css_helpers;

				if ( $fusion_settings->get( 'blog_grid_column_spacing' ) || '0' === $fusion_settings->get( 'blog_grid_column_spacing' ) ) {

					$css['global']['#posts-container.fusion-blog-layout-grid']['margin'] = '-' . intval( $fusion_settings->get( 'blog_grid_column_spacing' ) / 2 ) . 'px -' . intval( $fusion_settings->get( 'blog_grid_column_spacing' ) / 2 ) . 'px 0 -' . intval( $fusion_settings->get( 'blog_grid_column_spacing' ) / 2 ) . 'px';

					$css['global']['#posts-container.fusion-blog-layout-grid .fusion-post-grid']['padding'] = intval( $fusion_settings->get( 'blog_grid_column_spacing' ) / 2 ) . 'px';

				}

				if ( $fusion_settings->get( 'slideshow_smooth_height' ) ) {
					$css['global']['.fusion-flexslider.fusion-post-slideshow']['overflow'] = 'hidden';
				}

				return $css;
			}

			/**
			 * Adds settings to element options panel.
			 *
			 * @access public
			 * @since 1.1
			 * @return array $sections Blog settings.
			 */
			public function add_options() {
				return [
					'blog_shortcode_section' => [
						'label'       => esc_attr__( 'Blog', 'fusion-builder' ),
						'description' => '',
						'id'          => 'blog_shortcode_section',
						'default'     => '',
						'icon'        => 'fusiona-blog',
						'type'        => 'accordion',
						'fields'      => [
							'blog_grid_columns'        => [
								'label'       => esc_attr__( 'Number of Columns', 'fusion-builder' ),
								'description' => __( 'Set the number of columns per row for grid and masonry layout. <strong>IMPORTANT:</strong> Masonry layout does not work with 1 column.', 'fusion-builder' ),
								'id'          => 'blog_grid_columns',
								'default'     => 3,
								'type'        => 'slider',
								'choices'     => [
									'min'  => 1,
									'max'  => 6,
									'step' => 1,
								],
								'transport'   => 'postMessage',
							],
							'blog_grid_column_spacing' => [
								'label'       => esc_attr__( 'Column Spacing', 'fusion-builder' ),
								'description' => esc_html__( 'Controls the column spacing for blog posts for grid and masonry layout.', 'fusion-builder' ),
								'id'          => 'blog_grid_column_spacing',
								'default'     => '40',
								'type'        => 'slider',
								'choices'     => [
									'min'  => '0',
									'step' => '1',
									'max'  => '300',
									'edit' => 'yes',
								],
								'transport'   => 'postMessage',
							],
							'blog_grid_padding'        => [
								'label'       => esc_attr__( 'Blog Grid Text Padding', 'fusion-builder' ),
								'description' => esc_html__( 'Controls the top/right/bottom/left padding of the blog text when using grid / masonry or timeline layout.', 'fusion-builder' ),
								'id'          => 'blog_grid_padding',
								'choices'     => [
									'top'    => true,
									'bottom' => true,
									'left'   => true,
									'right'  => true,
									'units'  => [ 'px', '%' ],
								],
								'default'     => [
									'top'    => '30px',
									'bottom' => '20px',
									'left'   => '25px',
									'right'  => '25px',
								],
								'type'        => 'spacing',

								// Could update variable here, but does not look necessary as set inline.
								'transport'   => 'postMessage',
							],
							'blog_excerpt'             => [
								'label'       => esc_attr__( 'Content Display', 'fusion-builder' ),
								'description' => esc_attr__( 'Controls if the post content displays an excerpt, full content or is completely disabled for blog elements.', 'fusion-builder' ),
								'id'          => 'blog_excerpt',
								'default'     => 'yes',
								'type'        => 'radio-buttonset',
								'choices'     => [
									'hide' => esc_attr__( 'No Text', 'fusion-builder' ),
									'yes'  => esc_attr__( 'Excerpt', 'fusion-builder' ),
									'no'   => esc_attr__( 'Full Content', 'fusion-builder' ),
								],
								'transport'   => 'postMessage',
							],
							'blog_excerpt_length'      => [
								'label'       => esc_attr__( 'Excerpt Length', 'fusion-builder' ),
								'description' => esc_attr__( 'Controls the number of words in the excerpts for blog elements.', 'fusion-builder' ),
								'id'          => 'blog_excerpt_length',
								'default'     => '10',
								'type'        => 'slider',
								'choices'     => [
									'min'  => '0',
									'max'  => '500',
									'step' => '1',
								],
								'required'    => [
									[
										'setting'  => 'blog_excerpt',
										'operator' => '==',
										'value'    => 'yes',
									],
								],
								'transport'   => 'postMessage',
							],
						],
					],
				];
			}

			/**
			 * Sets the necessary scripts.
			 *
			 * @access public
			 * @since 1.1
			 * @return void
			 */
			public function add_scripts() {

				Fusion_Dynamic_JS::enqueue_script( 'fusion-blog' );
			}
		}
// 	}

	new FusionSC_Blog();

// }