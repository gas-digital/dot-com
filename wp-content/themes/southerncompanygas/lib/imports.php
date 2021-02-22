<?php

/**
 *
 * Import Scripts
 *
 * Convert posts from the wp admin api to input content
 * into the appropriate shortcodes for fusion templating
 *
*/
add_filter( 'http_request_timeout', 'fusion_timeout_extend' );
function fusion_timeout_extend( $time ){
    return 60;
}

add_action('admin_init', 'fusion_import_blog_items');
function fusion_import_blog_items(){
	if($_GET['fusion_import'] !== 'blog'){
		return;
	}
	
	$api = 'https://southerncompanygas.com/wp-json/wp/v2';
	
	$args = array(
		'per_page' => 1,
		'offset' => 19,
		'status' => 'publish'
	);
	$response = wp_remote_get(
		$api.'/posts?'.http_build_query($args)
	);
	
	if( is_wp_error( $response ) ) {
		return;
	}
	$pages = json_decode( wp_remote_retrieve_body( $response ) );
	if( empty( $pages ) ) {
		return;
	}
	
	require_once(ABSPATH . '/wp-load.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/media.php');

	foreach($pages as $post){

		$tmp_post = (array) $post;

		// Featured Image
		$featured_image = $post->featured_media;

		// Fetch our categories
		$terms = array();
		if($tmp_post['categories']){
			foreach($tmp_post['categories'] as $taxID){
				$response = wp_remote_get(
					$api.'/categories/'.$taxID
				);
				if( is_wp_error( $response ) ) {
					return;
				}
				$taxonomy = json_decode( wp_remote_retrieve_body( $response ) );
				if( empty( $taxonomy ) ) {
					return;
				}
				$terms[] = $taxonomy;
			}
		}

		// Create our post
		$postID = wp_insert_post(
			array(
				'post_title' => $post->title->rendered,
				'post_name' => $post->slug,
				'post_date' => $post->date,
				'post_date_gmt' => $post->date_gmt,
				'post_type' => 'post'
			)
		);

		// Set our terms if they exist
		if($terms){
			foreach($terms as $term){
				if($term->name){
					if(!term_exists($term->slug, 'category')){
						wp_insert_term($term->name, 'category');
					}
				}
			}
			$setTerms = wp_list_pluck($terms, 'slug');
			wp_set_object_terms($postID, $setTerms, 'category');
		}

		// Add in our Featured Media
/*
		$media_response = wp_remote_get(
			$api.'/media/'.$featured_image
		);
		if( is_wp_error( $media_response ) ) {
			return;
		}
		$media_response = json_decode( wp_remote_retrieve_body( $media_response ) );
		if( empty( $media_response ) ) {
			return;
		}

		$temp_featured_file = download_url($media_response->guid->rendered, 5000);
		if(!is_wp_error($temp_featured_file)){
			$file = array(
		        'name' => basename($media_response->guid->rendered),
		        'type' => 'application/pdf',
		        'tmp_name' => $temp_featured_file,
		        'error' => 0,
		        'size' => filesize($temp_featured_file)
		    );
		    $overrides = array(
			    'test_form' => false,
			    'test_size' => true
			);
			$results = wp_handle_sideload( $file, $overrides );
			if (!is_wp_error($results)){
				$wp_upload_dir = wp_upload_dir();
				$attachment = array(
					'guid'           => $wp_upload_dir['url'] . '/' . basename( $media_response->guid->rendered ), 
					'post_mime_type' => $results['type'],
					'post_title'     => $media_response->title->rendered,
					'post_content'   => '',
					'post_status'    => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $results['file'], $postID );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $results['file'] );
				wp_update_attachment_metadata( $attach_id, $attach_data );
				set_post_thumbnail($postID, $attach_id);
			}
		}
*/

		// Convert the content into the Fusion Shortcodes
		$content = '';
		$content .= '[fusion_builder_container hundred_percent="no" equal_height_columns="no" menu_anchor="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" background_color="" background_image="" background_position="center center" background_repeat="no-repeat" fade="no" background_parallax="none" parallax_speed="0.3" video_mp4="" video_webm="" video_ogv="" video_url="" video_aspect_ratio="16:9" video_loop="yes" video_mute="yes" overlay_color="" video_preview_image="" border_size="" border_color="" border_style="solid" padding_top="" padding_bottom="" padding_left="" padding_right="" admin_label="Post"]';

			$content .= '[fusion_builder_row]';

				$content .= '[fusion_builder_column type="1_5" layout="1_1" background_position="left top" background_color="" border_size="" border_color="" border_style="solid" border_position="all" spacing="yes" background_image="" background_repeat="no-repeat" padding_top="" padding_right="" padding_bottom="" padding_left="" margin_top="0px" margin_bottom="0px" class="" id="" animation_type="" animation_speed="0.3" animation_direction="left" hide_on_mobile="small-visibility,medium-visibility,large-visibility" center_content="no" last="no" min_height="" hover_type="none" link=""][/fusion_builder_column]';

					
					$content .= '[fusion_builder_column type="3_5" layout="1_1" background_position="left top" background_color="" border_size="" border_color="" border_style="solid" border_position="all" spacing="yes" background_image="" background_repeat="no-repeat" padding_top="" padding_right="" padding_bottom="" padding_left="" margin_top="0px" margin_bottom="0px" class="" id="" animation_type="" animation_speed="0.3" animation_direction="left" hide_on_mobile="small-visibility,medium-visibility,large-visibility" center_content="no" last="no" min_height="" hover_type="none" link=""][fusion_text]';

						$content .= $post->content->rendered;

					$content .= '[/fusion_text][/fusion_builder_column]';

				$content .= '[fusion_builder_column type="1_5" layout="1_1" background_position="left top" background_color="" border_size="" border_color="" border_style="solid" border_position="all" spacing="yes" background_image="" background_repeat="no-repeat" padding_top="" padding_right="" padding_bottom="" padding_left="" margin_top="0px" margin_bottom="0px" class="" id="" animation_type="" animation_speed="0.3" animation_direction="left" hide_on_mobile="small-visibility,medium-visibility,large-visibility" center_content="no" last="no" min_height="" hover_type="none" link=""][/fusion_builder_column]';

			$content .= '[/fusion_builder_row]';

		$content .= '[/fusion_builder_container]';

		// Updating the posts content & status
		wp_update_post(
			array(
				'ID' => $postID,
				'post_content' => $content,
				'post_status' => 'publish'
			)
		);

		update_post_meta('original_ID', $post->ID, $postID);
		
		echo '<pre>';
			var_dump('Imported', $post->title->rendered, $postID);
		echo '</pre>';

	}

	exit;

}