<?php

namespace ASENHA\Classes;

/**
 * Class related to Content Management features
 *
 * @since 1.0.0
 */
class Content_Management {

	/**
	 * Current post type. For Content Admin >> Show Custom Taxonomy Filters functionality.
	 */
	public $post_type;

	/**
	 * Show featured images column in list tables for pages and post types that support featured image
	 *
	 * @since 1.0.0
	 */
	public function show_featured_image_column() {

		$post_types = get_post_types( array( 'public' => true ), 'names' );

		foreach ( $post_types as $post_type_key => $post_type_name ) {

			if ( post_type_supports( $post_type_key, 'thumbnail' ) ) {

				add_filter( "manage_{$post_type_name}_posts_columns",[ $this, 'add_featured_image_column' ] );
				add_action( "manage_{$post_type_name}_posts_custom_column", [ $this, 'add_featured_image' ], 10, 2 );

			}

		}

	}

	/**
	 * Add a column called Featured Image as the first column
	 *
	 * @param mixed $columns
	 * @return void
	 * @since 1.0.0
	 */
	public function add_featured_image_column( $columns ) {

		$new_columns = array();

		foreach ( $columns as $key => $value ) {

			if ( $key == 'title' ) {

				$new_columns['asenha-featured-image'] = 'Featured Image';	

			}

			$new_columns[$key] = $value;

		}

		return $new_columns;

	}

	/**
	 * Echo featured image's in thumbnail size to a column
	 *
	 * @param mixed $column_name
	 * @param mixed $id
	 * @since 1.0.0
	 */
	public function add_featured_image( $column_name, $id ) {

		if ( 'asenha-featured-image' === $column_name ) {

			if ( has_post_thumbnail( $id ) ) {

				$size = 'thumbnail';

				echo get_the_post_thumbnail( $id, $size, '' );

			} else {

				echo '<img src="' . esc_url( plugins_url( 'assets/img/default_featured_image.jpg', __DIR__ ) ) . '" />';

			}
		}

	}

	/**
	 * Show excerpt column in list tables for pages and post types that support excerpt.
	 *
	 * @since 1.0.0
	 */
	public function show_excerpt_column() {

		$post_types = get_post_types( array( 'public' => true ), 'names' );

		foreach ( $post_types as $post_type_key => $post_type_name ) {

			if ( post_type_supports( $post_type_key, 'excerpt' ) ) {

				add_filter( "manage_{$post_type_name}_posts_columns",[ $this, 'add_excerpt_column' ] );
				add_action( "manage_{$post_type_name}_posts_custom_column", [ $this, 'add_excerpt' ], 10, 2 );

			}

		}

	}

	/**
	 * Add a column called Featured Image as the first column
	 *
	 * @param mixed $columns
	 * @return void
	 * @since 1.0.0
	 */
	public function add_excerpt_column( $columns ) {

		$new_columns = array();

		foreach ( $columns as $key => $value ) {

			$new_columns[$key] = $value;

			if ( $key == 'title' ) {

				$new_columns['asenha-excerpt'] = 'Excerpt';	

			}

		}

		return $new_columns;

	}

	/**
	 * Echo featured image's in thumbnail size to a column
	 *
	 * @param mixed $column_name
	 * @param mixed $id
	 * @since 1.0.0
	 */
	public function add_excerpt( $column_name, $id ) {

		if ( 'asenha-excerpt' === $column_name ) {

			$excerpt = get_the_excerpt( $id ); // about 310 characters
			$excerpt = substr( $excerpt, 0, 160 ); // truncate to 160 characters
			$short_excerpt = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );

			echo wp_kses_post( $short_excerpt );

		}

	}

	/**
	 * Add ID column list table of pages, posts, custom post types, media, taxonomies, custom taxonomies, users amd comments
	 *
	 * @since 1.0.0
	 */
	public function show_id_column() {

		// For pages and hierarchical post types list table

		add_filter( 'manage_pages_columns', [ $this, 'add_id_column' ] );
		add_action( 'manage_pages_custom_column', [ $this, 'add_id_echo_value' ], 10, 2 );				

		// For posts and non-hierarchical custom posts list table

		add_filter( 'manage_posts_columns', [ $this, 'add_id_column' ] );
		add_action( 'manage_posts_custom_column', [ $this, 'add_id_echo_value' ], 10, 2 );

		// For media list table

		add_filter( 'manage_media_columns', [ $this, 'add_id_column' ] );
		add_action( 'manage_media_custom_column', [ $this, 'add_id_echo_value' ], 10, 2 );

		// For list table of all taxonomies

		$taxonomies = get_taxonomies( [ 'public' => true ], 'names' );

		foreach ( $taxonomies as $taxonomy ) {
			
			add_filter( 'manage_edit-' . $taxonomy . '_columns', [ $this, 'add_id_column' ] );
			add_action( 'manage_' . $taxonomy . '_custom_column', [ $this, 'add_id_return_value' ], 10, 3 );

		}

		// For users list table

		add_filter( 'manage_users_columns', [ $this, 'add_id_column' ]);	
		add_action( 'manage_users_custom_column', [ $this, 'add_id_return_value' ], 10, 3 );

		// For comments list table

		add_filter( 'manage_edit-comments_columns', [ $this, 'add_id_column' ]);	
		add_action( 'manage_comments_custom_column', [ $this, 'add_id_echo_value' ], 10, 3 );		

	}

	/**
	 * Add a column called ID
	 *
	 * @param mixed $columns
	 * @return void
	 * @since 1.0.0
	 */
	public function add_id_column( $columns ) {

		$columns['asenha-id'] = 'ID';

		return $columns;

	}

	/**
	 * Echo post ID value to a column
	 *
	 * @param mixed $column_name
	 * @param mixed $id
	 * @since 1.0.0
	 */
	public function add_id_echo_value( $column_name, $id ) {

		if ( 'asenha-id' === $column_name ) {
			echo esc_html( $id );
		}

	}

	/**
	 * Return post ID value to a column
	 *
	 * @param mixed $value
	 * @param mixed $column_name
	 * @param mixed $id
	 * @since 1.0.0
	 */
	public function add_id_return_value( $value, $column_name, $id ) {

		if ( 'asenha-id' === $column_name ) {
			$value = $id;
		}

		return $value;

	}

	/**
	 * Hide comments column in list tables for pages, post types that support comments, and alse media/attachments.
	 *
	 * @since 1.0.0
	 */
	public function hide_comments_column() {

		$post_types = get_post_types( array( 'public' => true ), 'names' );

		foreach ( $post_types as $post_type_key => $post_type_name ) {

			if ( post_type_supports( $post_type_key, 'comments' ) ) {

				if ( 'attachment' != $post_type_name ) {

					// For list tables of pages, posts and other post types
					add_filter( "manage_{$post_type_name}_posts_columns", [ $this, 'remove_comment_column' ] );

				} else {

					// For list table of media/attachment
					add_filter( 'manage_media_columns', [ $this, 'remove_comment_column' ] );

				}

			}

		}

	}

	/**
	 * Add a column called ID
	 *
	 * @param mixed $columns
	 * @return void
	 * @since 1.0.0
	 */
	public function remove_comment_column( $columns ) {

		unset( $columns['comments'] );

		return $columns;

	}

	/**
	 * Hide tags column in list tables for posts.
	 *
	 * @since 1.0.0
	 */
	public function hide_post_tags_column() {

		$post_types = get_post_types( array( 'public' => true ), 'names' );

		foreach ( $post_types as $post_type_key => $post_type_name ) {

			if ( $post_type_name == 'post' ) {

				add_filter( "manage_posts_columns", [ $this, 'remove_post_tags_column' ] );

			}

		}

	}

	/**
	 * Add a column called ID
	 *
	 * @param mixed $columns
	 * @return void
	 * @since 1.0.0
	 */
	public function remove_post_tags_column( $columns ) {

		unset( $columns['tags'] );

		return $columns;

	}

	/**
	 * Show custom (hierarchical) taxonomy filter(s) for all post types.
	 *
	 * @since 1.0.0
	 */
	public function show_custom_taxonomy_filters( $post_type ) {

		$post_taxonomies = get_object_taxonomies( $post_type, 'objects' );

		// Only show custom taxonomy filters for post types other than 'post'

		if ( 'post' != $post_type ) {

			array_walk( $post_taxonomies, [ $this, 'output_taxonomy_filter' ] );

		}

	}

	/**
	 * Output filter on the post type's list table for a taxonomy
	 *
	 * @since 1.0.0
	 */
	public function output_taxonomy_filter( $post_taxonomy ) {

		// Only show taxonomy filter when the taxonomy is hierarchical

		if ( true === $post_taxonomy->hierarchical ) {

			wp_dropdown_categories( array(
				'show_option_all'	=> sprintf( 'All %s', $post_taxonomy->label ),
				'orderby'			=> 'name',
				'order'				=> 'ASC',
				'hide_empty'		=> false,
				'hide_if_empty'		=> true,
				'selected'			=> filter_input( INPUT_GET, $post_taxonomy->query_var, FILTER_SANITIZE_STRING ),
				'hierarchical'		=> true,
				'name'				=> $post_taxonomy->query_var,
				'taxonomy'			=> $post_taxonomy->name,
				'value_field'		=> 'slug',
			) );

		}

	}

	/**
	 * Enable duplication of pages, posts and custom posts
	 *
	 * @since 1.0.0
	 */
	public function asenha_enable_duplication() {

		$original_post_id = intval( sanitize_text_field( $_REQUEST['post'] ) );
		$nonce = sanitize_text_field( $_REQUEST['nonce'] );

		if ( wp_verify_nonce( $nonce, 'asenha-duplicate-' . $original_post_id ) && current_user_can( 'edit_posts' ) ) {

			$original_post = get_post( $original_post_id );

			// Set some attributes for the duplicate post

			$new_post_title_suffix = ' (DUPLICATE)';
			$new_post_status = 'draft';
			$current_user = wp_get_current_user();
			$new_post_author_id = $current_user->ID;

			// Create the duplicate post and store the ID
			
			$args = array(

				'comment_status'	=> $original_post->comment_status,
				'ping_status'		=> $original_post->ping_status,
				'post_author'		=> $new_post_author_id,
				'post_content'		=> $original_post->post_content,
				'post_excerpt'		=> $original_post->post_excerpt,
				'post_parent'		=> $original_post->post_parent,
				'post_password'		=> $original_post->post_password,
				'post_status'		=> $new_post_status,
				'post_title'		=> $original_post->post_title . $new_post_title_suffix,
				'post_type'			=> $original_post->post_type,
				'to_ping'			=> $original_post->to_ping,
				'menu_order'		=> $original_post->menu_order,

			);

			$new_post_id = wp_insert_post( $args );

			// Copy over the taxonomies

			$original_taxonomies = get_object_taxonomies( $original_post->post_type );

			if ( ! empty( $original_taxonomies ) && is_array( $original_taxonomies ) ) {

				foreach( $original_taxonomies as $taxonomy ) {

					$original_post_terms = wp_get_object_terms( $original_post_id, $taxonomy, array( 'fields' => 'slugs' ) );

					wp_set_object_terms( $new_post_id, $original_post_terms, $taxonomy, false );

				}

			}

			// Copy over the post meta
			
			$original_post_metas = get_post_meta( $original_post_id ); // all meta keys and the corresponding values

			if ( ! empty( $original_post_metas ) ) {

				foreach( $original_post_metas as $meta_key => $meta_values ) {

					foreach( $meta_values as $meta_value ) {

						add_post_meta( $new_post_id, $meta_key, $meta_value );

					}

				}

			}

			// Redirect to list table of the corresponding post type of original post
			
			$post_type = get_post_type( $original_post_id );

			if ( 'post'	== $post_type ) {

				wp_redirect( admin_url( 'edit.php' ) );

			} else {

				wp_redirect( admin_url( 'edit.php?post_type=' . $post_type ) );

			}

		} else {

			wp_die( 'You do not have permission to perform this action.' );

		}

	}

	/** 
	 * Add row action link to perform duplication in page/post list tables
	 *
	 * @since 1.0.0
	 */
	public function add_duplication_action_link( $actions, $post ) {

		if ( current_user_can( 'edit_posts' ) ) {

			$actions['asenha-duplicate'] = '<a href="admin.php?action=asenha_enable_duplication&amp;post=' . $post->ID . '&amp;nonce=' . wp_create_nonce( 'asenha-duplicate-' . $post->ID ) . '" title="Duplicate this as draft">Duplicate</a>';

		}

		return $actions;

	}

	/**
	 * Modify the 'Edit' link to be 'Edit or Replace'
	 * 
	 */
	public function modify_media_list_table_edit_link( $actions, $post ) {

		$new_actions = array();

		foreach( $actions as $key => $value ) {

			if ( $key == 'edit' ) {

				$new_actions['edit'] = '<a href="' . get_edit_post_link( $post ) . '" aria-label="Edit or Replace">Edit or Replace</a>';

			} else {

				$new_actions[$key] = $value;

			}

		}

		return $new_actions;

	}

	/**
	 * Add media replacement button in the edit screen of media/attachment
	 *
	 * @since 1.1.0
	 */
	public function add_media_replacement_button( $fields ) {

		// Enqueues all scripts, styles, settings, and templates necessary to use all media JS APIs.
		// Reference: https://codex.wordpress.org/Javascript_Reference/wp.media
		wp_enqueue_media();

		// Add new field to attachment fields for the media replace functionality
		$fields['asenha-media-replace'] = array();
		$fields['asenha-media-replace']['label'] = '';
		$fields['asenha-media-replace']['input'] = 'html';
		$fields['asenha-media-replace']['html'] = '
			<div id="media-replace-div" class="postbox">
				<div class="postbox-header">
					<h2 class="hndle ui-sortable-handle">Replace Media</h2>
				</div>
				<div class="inside">
				<button type="button" id="asenha-media-replace" class="button-secondary button-large asenha-media-replace-button">Select New Media File</button>
				<input type="hidden" id="new-attachment-id" name="new-attachment-id" />
				<div class="asenha-media-replace-notes">The current file will be replaced with the uploaded and/or selected file while retaining the current ID, publish date and file name. Thus, no existing links will break.</div>
				</div>
			</div>
		';

		return $fields;

	}

	/**
	 * Replace existing media with the newly updated file
	 *
	 * @link https://plugins.trac.wordpress.org/browser/replace-image/tags/1.1.7/hm-replace-image.php#L55
	 * @since 1.1.0
	 */
	public function replace_media( $old_attachment_id ) {

		$old_post_meta = get_post( $old_attachment_id, ARRAY_A );
		$old_post_mime = $old_post_meta['post_mime_type']; // e.g. 'image/jpeg'

		// Get the new attachment/media ID, meta and mime type
		$new_attachment_id = intval( sanitize_text_field( $_POST['new-attachment-id'] ) );
		$new_post_meta = get_post( $new_attachment_id, ARRAY_A );
		$new_post_mime = $new_post_meta['post_mime_type']; // e.g. 'image/jpeg'

		// Check if the media file ID selected via the media frame and passed on to the #new-attachment-id hidden field
		// Ensure the mime type matches too
		if ( ( ! empty( $new_attachment_id ) ) && is_numeric( $new_attachment_id ) && ( $old_post_mime == $new_post_mime ) ) {

			$new_attachment_meta = wp_get_attachment_metadata( $new_attachment_id );

			// If original file is larger than 2560 pixel
			// https://make.wordpress.org/core/2019/10/09/introducing-handling-of-big-images-in-wordpress-5-3/
			if ( array_key_exists( 'original_image', $new_attachment_meta ) ) {

				// Get the original media file path
				$new_media_file_path = wp_get_original_image_path( $new_attachment_id );

			} else {

				// Get the path to newly uploaded media file. An image file name may end with '-scaled'.
				$new_attachment_file = get_post_meta( $new_attachment_id, '_wp_attached_file', true );
				$upload_dir = wp_upload_dir();
				$new_media_file_path = $upload_dir['basedir'] . '/' . $new_attachment_file;

			}

			// Check if the new media file exist / was successfully uploaded
			if ( ! is_file( $new_media_file_path ) ) {
				return false;
			}

			// Delete existing/old media files. Post and post meta entries for it are still there in the database.
			$this->delete_media_files( $old_attachment_id );

			// If original file is larger than 2560 pixel
			// https://make.wordpress.org/core/2019/10/09/introducing-handling-of-big-images-in-wordpress-5-3/
			if ( array_key_exists( 'original_image', $new_attachment_meta ) ) {

				// Get the original media file path
				$old_media_file_path = wp_get_original_image_path( $old_attachment_id );

			} else {

				// Get the path to the old/existing media file that will be replaced and deleted. An image file name may end with '-scaled'.
				$old_attachment_file = get_post_meta( $old_attachment_id, '_wp_attached_file', true );
				$old_media_file_path = $upload_dir['basedir'] . '/' . $old_attachment_file;

			}

			// Check if the directory path to the old media file is still intact
			if ( ! file_exists( dirname( $old_media_file_path ) ) ) {

				// Recreate the directory path
				mkdir( dirname( $old_media_file_path ), 0755, true );

			}

			// Copy the new media file into the old media file's path
			copy( $new_media_file_path, $old_media_file_path );

			// Regenerate attachment meta data and image sub-sizes from the new media file that was just copied to the old path
			$old_media_post_meta_updated = wp_generate_attachment_metadata( $old_attachment_id, $old_media_file_path );

			// Update new media file's meta data with the ones from the old media. i.e. new media file will carry over the post ID and post meta of the old media file. i.e. only the files are replaced for the old media's ID and post meta in the database.
			wp_update_attachment_metadata( $old_attachment_id, $old_media_post_meta_updated );

			// Delete the newly uploaded media file and it's sub-sizes, and also delete post and post meta entries for it in the database.
			wp_delete_attachment( $new_attachment_id, true );

		}

	}

	/**
	 * Delete the existing/old media files when performing media replacement
	 *
	 * @link https://plugins.trac.wordpress.org/browser/replace-image/tags/1.1.7/hm-replace-image.php#L80
	 * @since 1.1.0
	 */
	public function delete_media_files( $post_id ) {

		$attachment_meta = wp_get_attachment_metadata( $post_id );

		// Will get '-scaled' version if it exists, e.g. /path/to/uploads/year/month/file-name.jpg
		$attachment_file_path = get_attached_file( $post_id ); 

		// e.g. file-name.jpg
		$attachment_file_basename = basename( $attachment_file_path );

		// Delete intermediate images if there are any
		
		if ( isset( $attachment_meta['sizes'] ) && is_array( $attachment_meta['sizes'] ) ) {

			foreach( $attachment_meta['sizes'] as $size => $size_info) {

				// /path/to/uploads/year/month/file-name.jpg --> /path/to/uploads/year/month/file-name-1024x768.jpg
				$intermediate_file_path = str_replace( $attachment_file_basename, $size_info['file'], $attachment_file_path );
				wp_delete_file( $intermediate_file_path );

			}

		}

		// Delete the attachment file, which maybe the '-scaled' version
		wp_delete_file( $attachment_file_path );

		// If original file is larger than 2560 pixel
		// https://make.wordpress.org/core/2019/10/09/introducing-handling-of-big-images-in-wordpress-5-3/
		if ( array_key_exists( 'original_image', $attachment_meta ) ) {

			$attachment_original_file_path = wp_get_original_image_path( $post_id );

			// Delete the original file
			wp_delete_file( $attachment_original_file_path );

		}

	}

	/**
	 * Customize the attachment updated message
	 *
	 * @link https://github.com/WordPress/wordpress-develop/blob/6.0.2/src/wp-admin/edit-form-advanced.php#L180
	 * @since 1.1.0
	 */
	public function attachment_updated_custom_message( $messages ) {

		$new_messages = array();

		foreach( $messages as $post_type => $messages_array ) {

			if ( $post_type == 'attachment' ) {

				// Message ID for successful edit/update of an attachment is 4. e.g. /wp-admin/post.php?post=a&action=edit&classic-editor&message=4 Customize it here.
				$messages_array[4] = 'Media file updated. You may need to <a href="https://fabricdigital.co.nz/blog/how-to-hard-refresh-your-browser-and-clear-cache" target="_blank">hard refresh</a> your browser to see the updated media preview image below.';

			}

			$new_messages[$post_type] = $messages_array;

		}

		return $new_messages;

	}

}