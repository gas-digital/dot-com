<?php

add_action( 'template_redirect', 'avada_change_search_permalink' );
function avada_change_search_permalink() {
    if ( is_search() && ! empty( $_GET['s'] ) ) {
        wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
    }   
}

add_filter('avada_load_more_posts_name', function(){
	return 'Load More';
});

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

/**
 * Proper way to enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'child_theme_custom_css' );
function child_theme_custom_css() {
    wp_enqueue_style( 'scogas_styles', get_stylesheet_directory_uri().'/css/custom.css' );
}

add_action( 'fusion_builder_shortcodes_init', 'recent_posts_carousel_init', 9999 );
function recent_posts_carousel_init() {
	require_once('lib/shortcodes/recent-posts-carousel.php');
	require_once('lib/shortcodes/counters-bubbles.php');
	require_once('lib/shortcodes/blockquote.php');
	//require_once('lib/shortcodes/fusion-blog.php');
}

add_action('avada_after_main_container', 'add_pre_footer_widget');
function add_pre_footer_widget(){
	echo '<div class="fusion-footer fusion-pre-footer">';
		echo '<div class="fusion-pre-footer-widget-area fusion-widget-area">';
			echo '<div class="fusion-row">';
				echo '<div class="fusion-columns">';
					dynamic_sidebar( 'avada-custom-sidebar-pre-footerwidget');
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

/**
 *
 * Media Statement Layout
 *
*/
add_filter('body_class', 'media_is_full_width_class', 99, 1);
function media_is_full_width_class($classes){
	
	$post = $wp_query->post;

	if(in_category('media-statement', $post->ID) && is_single()){

		$has_sidebar[] = 'has-sidebar';
		
		$classes = array_merge($classes, $has_sidebar);

	}

	return $classes;
}

add_action('avada_after_content', 'media_is_hundred_percent_remove_styling', 21, 1);
function media_is_hundred_percent_remove_styling($option){
	$post = $wp_query->post;
	if(in_category('media-statement', $post->ID)){
		$option = true;
	}
	return $option;
}
add_filter('fusion_is_hundred_percent_template', 'media_is_hundred_percent_width', 11, 1);
function media_is_hundred_percent_width($value){
	$post = $wp_query->post;
	if(in_category('media-statement', $post->ID)){
		$value = false;
	}
	return $value;
}
add_filter('fusion_content_class', 'media_is_hundred_percent_class');
function media_is_hundred_percent_class($filter){
	$post = $wp_query->post;
	if(in_category('media-statement', $post->ID)){
		unset($filter['full-width']);
	}
	return $filter;
}
add_filter( 'single_template', 'single_media_statement_template', 10, 1);
function single_media_statement_template( $single_template ) {
	global $post;

    if ( in_category('media-statement') ) {
        $single_template = dirname( __FILE__ ) . '/single-media-statement.php';
    }
    return $single_template;
}

/**
 *
 * Relevanssi Fix
 *
*/
/*
add_filter('get_the_excerpt', 'fusion_get_post_content_excerpt');
function fusion_get_post_content_excerpt( $limit = 185, $strip_html, $page_id = '' ) {
	global $post;
	return trim($post->post_excerpt);
}
*/

add_filter('relevanssi_results', 'fusion_exact_boost');
function fusion_exact_boost($results) {
	$query = strtolower(get_search_query());
	foreach ($results as $post_id => $weight) {
		$post = relevanssi_get_post($post_id);
 
                // Boost exact title matches
		if (stristr($post->post_title, $query) != false) $results[$post_id] = $weight * 100;
 
                // Boost exact matches in post content
		if (stristr($post->post_content, $query) != false) $results[$post_id] = $weight * 100;
	}
	return $results;
}


/**
 *
 * Search Layout
 *
*/
add_filter('body_class', 'search_is_full_width_class', 11, 1);
function search_is_full_width_class($classes){
	if(is_search()){
		foreach($classes as &$class){
			if(strpos($class, 'has-sidebar') !== false){
				$class = str_replace('has-sidebar', '', $class);
				break;
			}
		}
	}
	return $classes;
}

add_action('avada_after_content', 'search_is_hundred_percent_remove_styling', 21, 1);
function search_is_hundred_percent_remove_styling($option){
	if(is_search()){
		$option = false;
	}
	return $option;
}
add_filter('fusion_is_hundred_percent_template', 'search_is_hundred_percent_width', 11, 1);
function search_is_hundred_percent_width($value){
	if(is_search()){
		$value = true;
	}
	return $value;
}
add_filter('fusion_content_class', 'search_is_hundred_percent_class');
function search_is_hundred_percent_class($filter){
	if(is_search()){
		$filter = ['full-width'];
	}
	return $filter;
}


/**
 *
 * Person Post Type
 *
*/
add_action( 'init', 'leadership_init' );
add_filter( 'post_updated_messages', 'leadership_init_messages' );
function leadership_init() {
    $labels = array(
      'public' => true,
      'name' => 'Leadership',
      'singular_name' => 'Person',
      'add_new' => 'Add Person',
      'add_new_item' => 'Add New Person',
      'new_item' => 'New Person',
      'edit_item' => 'Edit Person',
      'view_item' => 'View Person',
      'all_items' => 'All Leadership',
      'search_items' => 'Search Leadership',
      'not_found' => 'Person not found',
      'not_found_in_trash' => 'No person found in trash',
      'label'  => 'Leadership'
    );
    $args = array(
	    'labels' => $labels,
	    'capability_type' => 'page',
	    'description' => 'Add your companies leadership',
	    'menu_icon' => 'dashicons-groups',
	    'public' => true,
	    'publicly_queryable' => true,
	    'rewrite' => array(
		    'slug' => 'who-we-are/leadership',
		    'with_front' => false
	    ),
	    'has_archive' => false,
	    'hierarchical' => false,
	    'supports' => array(
		    'title',
		    'editor',
		    'thumbnail'
	    )
    );
    register_post_type( 'leadership', $args );
}
function leadership_init_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['leadership'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Person updated.', 'Avada' ),
		4  => __( 'Person updated.', 'Avada' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Person restored to revision from %s', 'Avada' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Person published.', 'Avada' ),
		7  => __( 'Person saved.', 'Avada' ),
		8  => __( 'Person submitted.', 'Avada' ),
		9  => sprintf(
			__( 'Person scheduled for: <strong>%1$s</strong>.', 'Avada' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'Avada' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Person draft updated.', 'Avada' )
	);

	if ( $post_type_object->publicly_queryable && 'person' === $post_type ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View person', 'Avada' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview person', 'Avada' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}


/**
 * Render related posts carousel.
 *
 * @param  string $post_type The post type to determine correct related posts and headings.
 * @return void              Directly includes the template file.
 */
function avada_render_related_posts( $post_type = '' ) {

	if ( ! $post_type ) {
		global $wp_query;
		$post_type = 'post';
		if ( is_object( $wp_query ) && isset( $wp_query->post ) && is_object( $wp_query->post ) && isset( $wp_query->post->ID ) && $wp_query->post->ID ) {
			$post_type = get_post_type( $wp_query->post->ID );
		}
	}
	// Set the needed variables according to post type.
	if ( 'post' === $post_type ) {
		$theme_option_name = 'related_posts';
		$main_heading      = esc_html__( 'Related News', 'Avada' );
	} elseif ( 'avada_portfolio' === $post_type ) {
		$theme_option_name = 'portfolio_related_posts';
		$main_heading      = esc_html__( 'Related Projects', 'Avada' );
	} elseif ( 'avada_faq' === $post_type ) {
		$theme_option_name = 'faq_related_posts';
		$main_heading      = esc_html__( 'Related Faqs', 'Avada' );
	}

	// Check if related posts should be shown.
	if ( isset( $theme_option_name ) && ( fusion_get_option( $theme_option_name ) ) ) { // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
		$number_related_posts = Avada()->settings->get( 'number_related_posts' );
		$number_related_posts = ( '0' == $number_related_posts ) ? '-1' : $number_related_posts; // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
		if ( 'post' === $post_type ) {
			$related_posts = fusion_get_related_posts( get_the_ID(), $number_related_posts );
		} else {
			$related_posts = fusion_get_custom_posttype_related_posts( get_the_ID(), $number_related_posts, $post_type );
		}

		// If there are related posts, display them.
		if ( isset( $related_posts ) && $related_posts->have_posts() ) {
			include wp_normalize_path( locate_template( 'templates/related-posts.php' ) );
		}
	}
}

/**
 * Render the full meta data for blog archive and single layouts.
 *
 * @param string $layout    The blog layout (either single, standard, alternate or grid_timeline).
 * @param string $settings HTML markup to display the date and post format box.
 * @return  string
 */
function fusion_render_post_metadata( $layout, $settings = [] ) {

	$html     = '';
	$author   = '';
	$date     = '';
	$metadata = '';

	$settings = ( is_array( $settings ) ) ? $settings : [];

	if ( is_search() ) {
		$search_meta = array_flip( fusion_library()->get_option( 'search_meta' ) );

		$default_settings = [
			'post_meta'          => empty( $search_meta ) ? false : true,
			'post_meta_author'   => isset( $search_meta['author'] ),
			'post_meta_date'     => isset( $search_meta['date'] ),
			'post_meta_cats'     => isset( $search_meta['categories'] ),
			'post_meta_tags'     => isset( $search_meta['tags'] ),
			'post_meta_comments' => isset( $search_meta['comments'] ),
			'post_meta_type'     => isset( $search_meta['post_type'] ),
		];
	} else {
		$default_settings = [
			'post_meta'          => fusion_library()->get_option( 'post_meta' ),
			'post_meta_author'   => fusion_library()->get_option( 'post_meta_author' ),
			'post_meta_date'     => fusion_library()->get_option( 'post_meta_date' ),
			'post_meta_cats'     => fusion_library()->get_option( 'post_meta_cats' ),
			'post_meta_tags'     => fusion_library()->get_option( 'post_meta_tags' ),
			'post_meta_comments' => fusion_library()->get_option( 'post_meta_comments' ),
			'post_meta_type'     => false,
		];
	}

	$settings  = wp_parse_args( $settings, $default_settings );
	$post_meta = get_post_meta( get_queried_object_id(), 'pyre_post_meta', true );

	// Check if meta data is enabled.
	if ( ( $settings['post_meta'] && 'no' !== $post_meta ) || ( ! $settings['post_meta'] && 'yes' === $post_meta ) ) {

		// For alternate, grid and timeline layouts return empty single-line-meta if all meta data for that position is disabled.
		if ( in_array( $layout, [ 'alternate', 'grid_timeline' ], true ) && ! $settings['post_meta_author'] && ! $settings['post_meta_date'] && ! $settings['post_meta_cats'] && ! $settings['post_meta_tags'] && ! $settings['post_meta_comments'] && ! $settings['post_meta_type'] ) {
			return '';
		}

		// Render post type meta data.
		if ( $settings['post_meta_type'] ) {
			$metadata .= '<span class="fusion-meta-post-type">' . esc_html( ucwords( get_post_type() ) ) . '</span>';
			$metadata .= '<span class="fusion-inline-sep">|</span>';
		}

		// Render author meta data.
		if ( $settings['post_meta_author'] ) {
			ob_start();
			the_author_posts_link();
			$author_post_link = ob_get_clean();

			// Check if rich snippets are enabled.
			if ( fusion_library()->get_option( 'disable_date_rich_snippet_pages' ) && fusion_library()->get_option( 'disable_rich_snippet_author' ) ) {
				/* translators: The author. */
				$metadata .= sprintf( esc_html__( 'By %s', 'Avada' ), '<span class="vcard"><span class="fn">' . $author_post_link . '</span></span>' );
			} else {
				/* translators: The author. */
				$metadata .= sprintf( esc_html__( 'By %s', 'Avada' ), '<span>' . $author_post_link . '</span>' );
			}
			$metadata .= '<span class="fusion-inline-sep">|</span>';
		} else { // If author meta data won't be visible, render just the invisible author rich snippet.
			$author .= fusion_render_rich_snippets_for_pages( false, true, false );
		}

		// Render the updated meta data or at least the rich snippet if enabled.
		if ( $settings['post_meta_date'] ) {
			$metadata .= fusion_render_rich_snippets_for_pages( false, false, true );

			$formatted_date = get_the_time( fusion_library()->get_option( 'date_format' ) );
			$date_markup    = '<span>' . $formatted_date . '</span><span class="fusion-inline-sep">|</span>';
			$metadata      .= apply_filters( 'fusion_post_metadata_date', $date_markup, $formatted_date );
		} else {
			$date .= fusion_render_rich_snippets_for_pages( false, false, true );
		}

		// Render rest of meta data.
		// Render categories.
		if ( $settings['post_meta_cats'] ) {
			$post_type  = get_post_type();
			$taxonomies = [
				'avada_portfolio' => 'portfolio_category',
				'avada_faq'       => 'faq_category',
				'product'         => 'product_cat',
				'tribe_events'    => 'tribe_events_cat',
			];
			ob_start();
			if ( 'post' === $post_type ) {
				the_category( ', ' );
			} elseif ( 'page' !== $post_type && isset( $taxonomies[ $post_type ] ) ) {
				the_terms( get_the_ID(), $taxonomies[ $post_type ], '', ', ' );
			}
			$categories = ob_get_clean();

			if ( $categories ) {
				/* translators: The categories list. */
				$metadata .= ( $settings['post_meta_tags'] ) ? sprintf( esc_html__( 'Categories: %s', 'Avada' ), $categories ) : $categories;
				$metadata .= '<span class="fusion-inline-sep">|</span>';
			}
		}

		// Render tags.
		if ( $settings['post_meta_tags'] ) {
			ob_start();
			the_tags( '' );
			$tags = ob_get_clean();

			if ( $tags ) {
				/* translators: The tags list. */
				$metadata .= '<span class="meta-tags">' . sprintf( esc_html__( 'Tags: %s', 'Avada' ), $tags ) . '</span><span class="fusion-inline-sep">|</span>';
			}
		}

		// Render comments.
		if ( $settings['post_meta_comments'] && 'grid_timeline' !== $layout ) {
			ob_start();
			comments_popup_link( esc_html__( '0 Comments', 'Avada' ), esc_html__( '1 Comment', 'Avada' ), esc_html__( '% Comments', 'Avada' ) );
			$comments  = ob_get_clean();
			$metadata .= '<span class="fusion-comments">' . $comments . '</span>';
		}

		// Render the HTML wrappers for the different layouts.
		if ( $metadata ) {
			$metadata = $author . $date . $metadata;

			if ( 'single' === $layout ) {
				$html .= '<div class="fusion-meta-info"><div class="fusion-meta-info-wrapper">' . $metadata . '</div></div>';
			} elseif ( in_array( $layout, [ 'alternate', 'grid_timeline' ], true ) ) {
				$html .= '<p class="fusion-single-line-meta">' . $metadata . '</p>';
			} else {
				$html .= '<div class="fusion-alignleft">' . $metadata . '</div>';
			}
		} else {
			$html .= $author . $date;
		}
	} else {
		// Render author and updated rich snippets for grid and timeline layouts.
		if ( fusion_library()->get_option( 'disable_date_rich_snippet_pages' ) ) {
			$html .= fusion_render_rich_snippets_for_pages( false );
		}
	}

	return apply_filters( 'fusion_post_metadata_markup', $html );
}

/**
 *
 * Remove link tags around # custom links
 *
 */
add_action( 'after_setup_theme', 'register_custom_nav_menus' );
function register_custom_nav_menus() {
	register_nav_menu( 'pre_footer', __( 'Pre-Footer Menu', 'Avada' ) );
}
add_filter('wp_nav_menu_args', 'fusion_custom_nav_walker');
function fusion_custom_nav_walker($args){
	if($args['theme_location'] !== 'main_navigation'){
		return array_merge( $args, array(
        	'walker' => new Custom_Fusion_Nav_Walker()
		) );
	}
	return $args;
}
class Custom_Fusion_Nav_Walker extends Walker_Nav_Menu {
    
	// Displays start of an element. E.g '<li> Item Name'
	// @see Walker::start_el()
	function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {

		$object = $item->object;
		$type = $item->type;
		$title = $item->title;
		$description = $item->description;
		$permalink = $item->url;
		$output .= "<li class='" .  implode(" ", $item->classes) . "'>";
		$target = (($item->target === '_blank')?'target="_blank"':'');
	
		//Add SPAN if no Permalink
		if( $permalink && $permalink != '#' ) {
			$output .= '<a href="' . $permalink . '" ' . $target . '>';
		} else {
			$output .= '<span>';
		}
	
		$output .= $title;
		if( $description != '' && $depth == 0 ) {
			$output .= '<small class="description">' . $description . '</small>';
		}
		if( $permalink && $permalink != '#' ) {
			$output .= '</a>';
		} else {
			$output .= '</span>';
		}

	}
}

// If Statement Shortcodes
function if_statement($atts, $content) {
    if (empty($atts)) return '';
        
    $callable = array_shift($atts);
    if (is_callable($callable)) {
      $condition = (boolean)call_user_func_array($callable, $atts);
    } else {
       throw new Excaption('First argument must be callable!');
    }
   
    $else = '[else]';
    if (strpos($content, $else) !== false) {
      list($if, $else) = explode($else, $content, 2);
    } else {
      $if = $content;
      $else = "";
    }
        
    return do_shortcode($condition ? $if : $else);
  }
 
  // register shortcode
  add_shortcode('if', 'if_statement');