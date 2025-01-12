<?php

/**
 * Register admin menu
 *
 * @since 1.0.0
 */
function asenha_register_admin_menu() {

	add_submenu_page(
		'tools.php', // Parent page/menu
		'Admin and Site Enhancements', // Browser tab/window title
		'Enhancements', // Sube menu title
		'manage_options', // Minimal user capabililty
		ASENHA_SLUG, // Page slug. Shows up in URL.
		'asenha_add_settings_page'
	);

}

/**
 * Create the settings page of the plugin
 *
 * @since 1.0.0
 */
function asenha_add_settings_page() {
	?>
	<div class="wrap asenha">

		<div id="asenha-header" class="asenha-header">
			<div class="asenha-header-left">
				<h1 class="asenha-heading"><?php echo get_admin_page_title(); ?> <small><?php esc_html_e( 'by', 'admin-site-enhancements' ); ?> <a href="https://bowo.io" target="_blank">bowo.io</a></small></h1>
				<!-- <a href="https://wordpress.org/plugins/admin-site-enhancements/" target="_blank" class="asenha-header-action"><span>&#8505;</span> <?php // esc_html_e( 'Info', 'admin-site-enhancements' ); ?></a> -->
				<a href="https://wordpress.org/plugins/admin-site-enhancements/#reviews" target="_blank" class="asenha-header-action"><span>&starf;</span> <?php esc_html_e( 'Review', 'admin-site-enhancements' ); ?></a>
				<a href="https://wordpress.org/support/plugin/admin-site-enhancements/" target="_blank" class="asenha-header-action">&#10010; <?php esc_html_e( 'Feedback', 'admin-site-enhancements' ); ?></a>
				<a href="https://paypal.me/qriouslad" target="_blank" class="asenha-header-action">&#9829; <?php esc_html_e( 'Donate', 'admin-site-enhancements' ); ?></a>
			</div>
			<div class="asenha-header-right">
				<a class="button button-primary asenha-save-button">Save Changes</a>
				<div class="asenha-changes-saved" style="display:none;">Changes have been saved.</div>
			</div>
		</div>

		<div class="asenha-body">
			<form action="options.php" method="post">
				<div class="asenha-vertical-tabs">
					<div class="asenha-tab-buttons">
					    <input id="tab-content-management" type="radio" name="tabs" checked><label for="tab-content-management">Content Management</label>
					    <input id="tab-admin-interface" type="radio" name="tabs"><label for="tab-admin-interface">Admin Interface</label>
					    <input id="tab-security" type="radio" name="tabs"><label for="tab-security">Security</label>
					    <input id="tab-utilities" type="radio" name="tabs"><label for="tab-utilities">Utilities</label>
					</div>
					<div class="asenha-tab-contents">
					    <section class="asenha-fields fields-content-management"> 
					    	<table class="form-table" role="presentation">
					    		<tbody></tbody>
					    	</table>
					    </section>
					    <section class="asenha-fields fields-admin-interface"> 
					    	<table class="form-table" role="presentation">
					    		<tbody></tbody>
					    	</table>
					    </section>
					    <section class="asenha-fields fields-security"> 
					    	<table class="form-table" role="presentation">
					    		<tbody></tbody>
					    	</table>
					    </section>
					    <section class="asenha-fields fields-utilities"> 
					    	<table class="form-table" role="presentation">
					    		<tbody></tbody>
					    	</table>
					    </section>
					</div>
				</div>
				<div style="display:none;"><!-- Hide to prevent flash of fields appearing at the bottom of the page -->
					<?php settings_fields( ASENHA_ID ); ?>
					<?php do_settings_sections( ASENHA_SLUG ); ?>
					<?php submit_button(
						'Save Changes', // Button copy
						'primary', // Type: 'primary', 'small', or 'large'
						'submit', // The 'name' attribute
						true, // Whether to wrap in <p> tag
						array( 'id' => 'asenha-submit' ), // additional attributes
					); ?>
				</div>
			</form>
		</div>

		<div class="asenha-footer">
		</div>

	</div>
	<?php

}

/**
 * Register plugin settings and the corresponding fields
 *
 * @link https://wpshout.com/making-an-admin-options-page-with-the-wordpress-settings-api/
 * @link https://rudrastyh.com/wordpress/creating-options-pages.html
 * @since 1.0.0
 */
function asenha_register_settings() {
	
	// Add "Content Management" section

	add_settings_section(
		'main-section', // Section ID
		'', // Section title. Can be blank.
		'', // Callback function to output section intro. Can be blank.
		ASENHA_SLUG // Settings page slug
	);

	// Register main setttings

	register_setting( 
		ASENHA_ID, // Option group or option_page
		ASENHA_SLUG_U, // Option name in wp_options table
		array(
			'type'					=> 'array', // 'string', 'boolean', 'integer', 'number', 'array', or 'object'
			'description'			=> '', // A description of the data attached to this setting.
			'sanitize_callback'		=> 'asenha_sanitize_options',
			'show_in_rest'			=> false,
			'default'				=> array(), // When calling get_option()
		)
	);

	// Register fields for "Content Management" section

	// Call WordPress globals required for the fields

	global $wp_roles;
	$roles = $wp_roles->get_names();

	// Enable Page and Post Duplication

	$field_id = 'enable_duplication';
	$field_slug = 'enable-duplication';

	add_settings_field(
		$field_id, // Field ID
		'Enable Page and Post Duplication', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'			=> $field_id, // Custom argument
			'field_name'		=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'	=> 'Enable one-click duplication of pages, posts and custom posts. The corresponding taxonomy terms and post meta will also be duplicated.', // Custom argument
			'class'				=> 'asenha-toggle content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Enable Media Replacement

	$field_id = 'enable_media_replacement';
	$field_slug = 'enable-media-replacement';

	add_settings_field(
		$field_id, // Field ID
		'Enable Media Replacement', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'			=> $field_id, // Custom argument
			'field_name'		=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'	=> 'Easily replace any type of media file with a new one while retaining the existing media ID, publish date and file name. So, no existing links will break.', // Custom argument
			'class'				=> 'asenha-toggle content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Enhance List Tables

	$field_id = 'enhance_list_tables';
	$field_slug = 'enhance-list-tables';

	add_settings_field(
		$field_id, // Field ID
		'Enhance List Tables', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Improve the usefulness of listing pages of various post types by adding / removing columns and elements.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Show Featured Image Column

	$field_id = 'show_featured_image_column';
	$field_slug = 'show-featured-image-column';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Show featured image column.', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Show Excerpt Column

	$field_id = 'show_excerpt_column';
	$field_slug = 'show-excerpt-column';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Show excerpt column.', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Show ID Column

	$field_id = 'show_id_column';
	$field_slug = 'show-id-column';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Show ID column.', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Hide Comments Column

	$field_id = 'hide_comments_column';
	$field_slug = 'hide-comments-column';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove comments column.', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Hide Post Tags Column

	$field_id = 'hide_post_tags_column';
	$field_slug = 'hide-post-tags-column';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove tags column (for posts).', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Show Custom Taxonomy Filters

	$field_id = 'show_custom_taxonomy_filters';
	$field_slug = 'show-custom-taxonomy-filters';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Show additional filter(s) for hierarchical, custom taxonomies.', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th content-management ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Hide Admin Notices

	$field_id = 'hide_admin_notices';
	$field_slug = 'hide-admin-notices';

	add_settings_field(
		$field_id, // Field ID
		'Hide Admin Notices', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'			=> $field_id, // Custom argument
			'field_name'		=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'	=> 'Clean up admin pages by moving notices into a separate panel easily accessible via the admin bar.', // Custom argument
			'class'				=> 'asenha-toggle admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// View Admin as Role

	$field_id = 'view_admin_as_role';
	$field_slug = 'view-admin-as-role';

	add_settings_field(
		$field_id, // Field ID
		'View Admin as Role', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'View admin pages and the site (logged-in) as one of the non-administrator user roles.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Hide or Modify Elements

	$field_id = 'hide_modify_elements';
	$field_slug = 'hide-modify-elements';

	add_settings_field(
		$field_id, // Field ID
		'Clean Up Admin Bar', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Remove various elements from the admin bar.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'hide_ab_wp_logo_menu';
	$field_slug = 'hide-ab-wp-logo-menu';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove WordPress logo/menu', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'hide_ab_customize_menu';
	$field_slug = 'hide-ab-customize-menu';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove customize menu', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'hide_ab_updates_menu';
	$field_slug = 'hide-ab-updates-menu';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove updates counter/link', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'hide_ab_comments_menu';
	$field_slug = 'hide-ab-comments-menu';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove comments counter/link', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'hide_ab_new_content_menu';
	$field_slug = 'hide-ab-new-content-menu';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove new content menu', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'hide_ab_howdy';
	$field_slug = 'hide-ab-howdy';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_checkbox_plain', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '[' . $field_id . ']', // Custom argument
			'field_label'			=> 'Remove \'Howdy\'', // Custom argument
			'class'					=> 'asenha-checkbox asenha-hide-th admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Hide Admin Bar

	$field_id = 'hide_admin_bar';
	$field_slug = 'hide-admin-bar';

	add_settings_field(
		$field_id, // Field ID
		'Hide Admin Bar', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Hide admin bar on the front end for all or some user roles.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'hide_admin_bar_for';
	$field_slug = 'hide-admin-bar-for';

	if ( is_array( $roles ) ) {
		foreach ( $roles as $role_slug => $role_label ) { // e.g. $role_slug is administrator, $role_label is Administrator

			add_settings_field(
				$field_id . '_' . $role_slug, // Field ID
				'', // Field title
				'asenha_render_field_checkbox_subfield', // Callback to render field with custom arguments in the array below
				ASENHA_SLUG, // Settings page slug
				'main-section', // Section ID
				array(
					'parent_field_id'		=> $field_id, // Custom argument
					'field_id'				=> $role_slug, // Custom argument
					'field_name'			=> ASENHA_SLUG_U . '['. $field_id .'][' . $role_slug . ']', // Custom argument
					'field_label'			=> $role_label, // Custom argument
					'class'					=> 'asenha-checkbox asenha-hide-th asenha-half admin-interface ' . $field_slug . ' ' . $role_slug, // Custom class for the <tr> element
				)
			);

		}
	}

	// Customize Admin Menu

	$field_id = 'customize_admin_menu';
	$field_slug = 'customize-admin-menu';

	add_settings_field(
		$field_id, // Field ID
		'Admin Menu Organizer', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Customize the order of the admin menu and optionally hide some items.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'custom_menu_order';
	$field_slug = 'custom-menu-order';

	add_settings_field(
		$field_id, // Field ID
		'', // Field title
		'asenha_render_field_sortable_menu', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_type'			=> 'sortable-menu', // Custom argument
			'field_description'		=> '', // Custom argument
			'class'					=> 'asenha-sortable asenha-hide-th admin-interface ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Change Login URL

	$field_id = 'change_login_url';
	$field_slug = 'change-login-url';

	add_settings_field(
		$field_id, // Field ID
		'Change Login URL', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Default is ' . get_site_url() . '/wp-admin/', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle security ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'custom_login_slug';
	$field_slug = 'custom-login-slug';

	add_settings_field(
		$field_id, // Field ID
		'New URL:', // Field title
		'asenha_render_field_text_subfield', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_type'			=> 'with-prefix-suffix', // Custom argument
			'field_prefix'			=> get_site_url() . '/', // Custom argument
			'field_suffix'			=> '/', // Custom argument
			'field_description'		=> '', // Custom argument
			'class'					=> 'asenha-text with-prefix-suffix security ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Obfuscate Author Slugs

	$field_id = 'obfuscate_author_slugs';
	$field_slug = 'obfuscate-author-slugs';

	add_settings_field(
		$field_id, // Field ID
		'Obfuscate Author Slugs', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Obfuscate publicly exposed author page URLs that shows the user slugs / usernames, e.g. <em>sitename.com/author/username1/</em> into <em>sitename.com/author/a6r5b8ytu9gp34bv/</em>, and output 404 errors for the original URLs. Also obfuscates in /wp-json/wp/v2/users/ REST API endpoint.', // Custom argument
			'field_options_wrapper'	=> false, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle security ' . $field_slug, // Custom class for the <tr> element
		)
	);

	// Redirect After Login

	$field_id = 'redirect_after_login';
	$field_slug = 'redirect-after-login';

	add_settings_field(
		$field_id, // Field ID
		'Redirect After Login', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Set custom redirect URL for all or some user roles after login.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle utilities ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'redirect_after_login_to_slug';
	$field_slug = 'redirect-after-login-to-slug';

	add_settings_field(
		$field_id, // Field ID
		'Redirect to:', // Field title
		'asenha_render_field_text_subfield', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_type'			=> 'with-prefix-suffix', // Custom argument
			'field_prefix'			=> get_site_url() . '/', // Custom argument
			'field_suffix'			=> '/ for:', // Custom argument
			'field_description'		=> '', // Custom argument
			'class'					=> 'asenha-text with-prefix-suffix utilities ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'redirect_after_login_for';
	$field_slug = 'redirect-after-login-for';

	if ( is_array( $roles ) ) {
		foreach ( $roles as $role_slug => $role_label ) { // e.g. $role_slug is administrator, $role_label is Administrator

			add_settings_field(
				$field_id . '_' . $role_slug, // Field ID
				'', // Field title
				'asenha_render_field_checkbox_subfield', // Callback to render field with custom arguments in the array below
				ASENHA_SLUG, // Settings page slug
				'main-section', // Section ID
				array(
					'parent_field_id'		=> $field_id, // Custom argument
					'field_id'				=> $role_slug, // Custom argument
					'field_name'			=> ASENHA_SLUG_U . '['. $field_id .'][' . $role_slug . ']', // Custom argument
					'field_label'			=> $role_label, // Custom argument
					'class'					=> 'asenha-checkbox asenha-hide-th asenha-half utilities ' . $field_slug . ' ' . $role_slug, // Custom class for the <tr> element
				)
			);

		}
	}

	// Redirect After Logout

	$field_id = 'redirect_after_logout';
	$field_slug = 'redirect-after-logout';

	add_settings_field(
		$field_id, // Field ID
		'Redirect After Logout', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Set custom redirect URL for all or some user roles after logout.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle utilities ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'redirect_after_logout_to_slug';
	$field_slug = 'redirect-after-logout-to-slug';

	add_settings_field(
		$field_id, // Field ID
		'Redirect to:', // Field title
		'asenha_render_field_text_subfield', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_type'			=> 'with-prefix-suffix', // Custom argument
			'field_prefix'			=> get_site_url() . '/', // Custom argument
			'field_suffix'			=> '/ for:', // Custom argument
			'field_description'		=> '', // Custom argument
			'class'					=> 'asenha-text with-prefix-suffix utilities ' . $field_slug, // Custom class for the <tr> element
		)
	);

	$field_id = 'redirect_after_logout_for';
	$field_slug = 'redirect-after-logout-for';

	if ( is_array( $roles ) ) {
		foreach ( $roles as $role_slug => $role_label ) { // e.g. $role_slug is administrator, $role_label is Administrator

			add_settings_field(
				$field_id . '_' . $role_slug, // Field ID
				'', // Field title
				'asenha_render_field_checkbox_subfield', // Callback to render field with custom arguments in the array below
				ASENHA_SLUG, // Settings page slug
				'main-section', // Section ID
				array(
					'parent_field_id'		=> $field_id, // Custom argument
					'field_id'				=> $role_slug, // Custom argument
					'field_name'			=> ASENHA_SLUG_U . '['. $field_id .'][' . $role_slug . ']', // Custom argument
					'field_label'			=> $role_label, // Custom argument
					'class'					=> 'asenha-checkbox asenha-hide-th asenha-half utilities ' . $field_slug . ' ' . $role_slug, // Custom class for the <tr> element
				)
			);

		}
	}

	// Redirect 404 to Homepage

	$field_id = 'redirect_404_to_homepage';
	$field_slug = 'redirect-404-to-homepage';

	add_settings_field(
		$field_id, // Field ID
		'Redirect 404 to Homepage', // Field title
		'asenha_render_field_checkbox_toggle', // Callback to render field with custom arguments in the array below
		ASENHA_SLUG, // Settings page slug
		'main-section', // Section ID
		array(
			'field_id'				=> $field_id, // Custom argument
			'field_name'			=> ASENHA_SLUG_U . '['. $field_id .']', // Custom argument
			'field_description'		=> 'Perform 301 (permanent) redirect to the homepage for all 404 (not found) pages.', // Custom argument
			'field_options_wrapper'	=> true, // Custom argument. Add container for additional options
			'class'					=> 'asenha-toggle utilities ' . $field_slug, // Custom class for the <tr> element
		)
	);

}

/**
 * Sanitize options
 *
 * @since 1.0.0
 */
function asenha_sanitize_options( $options ) {

	// Call WordPress globals required for validating the fields	
	global $wp_roles;
	$roles = $wp_roles->get_names();

	// Content Management features

	// Enable Page and Post Duplication
	if ( ! isset( $options['enable_duplication'] ) ) $options['enable_duplication'] = false;
	$options['enable_duplication'] = ( 'on' == $options['enable_duplication'] ? true : false );

	// Enable Media Replacement
	if ( ! isset( $options['enable_media_replacement'] ) ) $options['enable_media_replacement'] = false;
	$options['enable_media_replacement'] = ( 'on' == $options['enable_media_replacement'] ? true : false );

	// Enhance List Tables
	if ( ! isset( $options['enhance_list_tables'] ) ) $options['enhance_list_tables'] = false;
	$options['enhance_list_tables'] = ( 'on' == $options['enhance_list_tables'] ? true : false );

	// Show Featured Image Column
	if ( ! isset( $options['show_featured_image_column'] ) ) $options['show_featured_image_column'] = false;
	$options['show_featured_image_column'] = ( 'on' == $options['show_featured_image_column'] ? true : false );

	// Show Excerpt Column
	if ( ! isset( $options['show_excerpt_column'] ) ) $options['show_excerpt_column'] = false;
	$options['show_excerpt_column'] = ( 'on' == $options['show_excerpt_column'] ? true : false );

	// Show ID Column
	if ( ! isset( $options['show_id_column'] ) ) $options['show_id_column'] = false;
	$options['show_id_column'] = ( 'on' == $options['show_id_column'] ? true : false );

	// Hide Comments Column
	if ( ! isset( $options['hide_comments_column'] ) ) $options['hide_comments_column'] = false;
	$options['hide_comments_column'] = ( 'on' == $options['hide_comments_column'] ? true : false );

	// Hide Post Tags Column
	if ( ! isset( $options['hide_post_tags_column'] ) ) $options['hide_post_tags_column'] = false;
	$options['hide_post_tags_column'] = ( 'on' == $options['hide_post_tags_column'] ? true : false );

	// Show Custom Taxonomy Filters
	if ( ! isset( $options['show_custom_taxonomy_filters'] ) ) $options['show_custom_taxonomy_filters'] = false;
	$options['show_custom_taxonomy_filters'] = ( 'on' == $options['show_custom_taxonomy_filters'] ? true : false );

	// Admin Interface features

	// Hide Admin Notices
	if ( ! isset( $options['hide_admin_notices'] ) ) $options['hide_admin_notices'] = false;
	$options['hide_admin_notices'] = ( 'on' == $options['hide_admin_notices'] ? true : false );

	// Hide Admin Bar
	if ( ! isset( $options['hide_admin_bar'] ) ) $options['hide_admin_bar'] = false;
	$options['hide_admin_bar'] = ( 'on' == $options['hide_admin_bar'] ? true : false );

	if ( is_array( $roles ) ) {
		foreach ( $roles as $role_slug => $role_label ) { // e.g. $role_slug is administrator, $role_label is Administrator
			if ( ! isset( $options['hide_admin_bar_for'][$role_slug] ) ) $options['hide_admin_bar_for'][$role_slug] = false;
			$options['hide_admin_bar_for'][$role_slug] = ( 'on' == $options['hide_admin_bar_for'][$role_slug] ? true : false );
		}
	}

	// View Admin as Role
	if ( ! isset( $options['view_admin_as_role'] ) ) $options['view_admin_as_role'] = false;
	$options['view_admin_as_role'] = ( 'on' == $options['view_admin_as_role'] ? true : false );

	// Hide or Modify Elements

	if ( ! isset( $options['hide_modify_elements'] ) ) $options['hide_modify_elements'] = false;
	$options['hide_modify_elements'] = ( 'on' == $options['hide_modify_elements'] ? true : false );

	if ( ! isset( $options['hide_ab_wp_logo_menu'] ) ) $options['hide_ab_wp_logo_menu'] = false;
	$options['hide_ab_wp_logo_menu'] = ( 'on' == $options['hide_ab_wp_logo_menu'] ? true : false );

	if ( ! isset( $options['hide_ab_customize_menu'] ) ) $options['hide_ab_customize_menu'] = false;
	$options['hide_ab_customize_menu'] = ( 'on' == $options['hide_ab_customize_menu'] ? true : false );

	if ( ! isset( $options['hide_ab_comments_menu'] ) ) $options['hide_ab_comments_menu'] = false;
	$options['hide_ab_comments_menu'] = ( 'on' == $options['hide_ab_comments_menu'] ? true : false );

	if ( ! isset( $options['hide_ab_updates_menu'] ) ) $options['hide_ab_updates_menu'] = false;
	$options['hide_ab_updates_menu'] = ( 'on' == $options['hide_ab_updates_menu'] ? true : false );

	if ( ! isset( $options['hide_ab_new_content_menu'] ) ) $options['hide_ab_new_content_menu'] = false;
	$options['hide_ab_new_content_menu'] = ( 'on' == $options['hide_ab_new_content_menu'] ? true : false );

	if ( ! isset( $options['hide_ab_howdy'] ) ) $options['hide_ab_howdy'] = false;
	$options['hide_ab_howdy'] = ( 'on' == $options['hide_ab_howdy'] ? true : false );

	// Customize Admin Menu

	if ( ! isset( $options['customize_admin_menu'] ) ) $options['customize_admin_menu'] = false;
	$options['customize_admin_menu'] = ( 'on' == $options['customize_admin_menu'] ? true : false );

	if ( ! isset( $options['custom_menu_order'] ) ) $options['custom_menu_order'] = '';
	if ( ! isset( $options['custom_menu_hidden'] ) ) $options['custom_menu_hidden'] = '';

	// Security features

	// Change Login URL
	if ( ! isset( $options['change_login_url'] ) ) $options['change_login_url'] = false;
	$options['change_login_url'] = ( 'on' == $options['change_login_url'] ? true : false );

	if ( ! isset( $options['custom_login_slug'] ) ) $options['custom_login_slug'] = 'backend';
	$options['custom_login_slug'] = ( ! empty( $options['custom_login_slug'] ) ) ? sanitize_text_field( $options['custom_login_slug'] ) : 'backend';
	
	// Obfuscate Author Slugs
	if ( ! isset( $options['obfuscate_author_slugs'] ) ) $options['obfuscate_author_slugs'] = false;
	$options['obfuscate_author_slugs'] = ( 'on' == $options['obfuscate_author_slugs'] ? true : false );

	// Utilities features

	// Redirect After Login
	if ( ! isset( $options['redirect_after_login'] ) ) $options['redirect_after_login'] = false;
	$options['redirect_after_login'] = ( 'on' == $options['redirect_after_login'] ? true : false );

	if ( ! isset( $options['redirect_after_login_to_slug'] ) ) $options['redirect_after_login_to_slug'] = '';
	$options['redirect_after_login_to_slug'] = ( ! empty( $options['redirect_after_login_to_slug'] ) ) ? sanitize_text_field( $options['redirect_after_login_to_slug'] ) : '';

	if ( is_array( $roles ) ) {
		foreach ( $roles as $role_slug => $role_label ) { // e.g. $role_slug is administrator, $role_label is Administrator
			if ( ! isset( $options['redirect_after_login_for'][$role_slug] ) ) $options['redirect_after_login_for'][$role_slug] = false;
			$options['redirect_after_login_for'][$role_slug] = ( 'on' == $options['redirect_after_login_for'][$role_slug] ? true : false );
		}
	}

	// Redirect After Logout
	if ( ! isset( $options['redirect_after_logout'] ) ) $options['redirect_after_logout'] = false;
	$options['redirect_after_logout'] = ( 'on' == $options['redirect_after_logout'] ? true : false );

	if ( ! isset( $options['redirect_after_logout_to_slug'] ) ) $options['redirect_after_logout_to_slug'] = '';
	$options['redirect_after_logout_to_slug'] = ( ! empty( $options['redirect_after_logout_to_slug'] ) ) ? sanitize_text_field( $options['redirect_after_logout_to_slug'] ) : '';

	if ( is_array( $roles ) ) {
		foreach ( $roles as $role_slug => $role_label ) { // e.g. $role_slug is administrator, $role_label is Administrator
			if ( ! isset( $options['redirect_after_logout_for'][$role_slug] ) ) $options['redirect_after_logout_for'][$role_slug] = false;
			$options['redirect_after_logout_for'][$role_slug] = ( 'on' == $options['redirect_after_logout_for'][$role_slug] ? true : false );
		}
	}

	// Redirect 404 to Homepage
	if ( ! isset( $options['redirect_404_to_homepage'] ) ) $options['redirect_404_to_homepage'] = false;
	$options['redirect_404_to_homepage'] = ( 'on' == $options['redirect_404_to_homepage'] ? true : false );

	return $options;

}

/**
 * Sanitize checkbox field. For reference purpose. Not currently in use.
 *
 * @since 1.0.0
 */
function asenha_sanitize_checkbox_field( $value ) {

	// A checked checkbox field will originally be saved as an 'on' value in the option. We transform that into true (shown as 1) or false (shown as empty value)
	return 'on' === $value ? true : false;

}

/**
 * Render checkbox field as a toggle/switcher
 *
 * @since 1.0.0
 */
function asenha_render_field_checkbox_toggle( $args ) {

	$options = get_option( ASENHA_SLUG_U );

	$field_name = $args['field_name'];
	$field_description = $args['field_description'];
	$field_option_value = ( array_key_exists( $args['field_id'], $options ) ) ? $options[$args['field_id']] : false;

	echo '<input type="checkbox" id="' . esc_attr( $field_name ) . '" class="asenha-field-checkbox" name="' . esc_attr( $field_name ) . '" ' . checked( $field_option_value, true, false ) . '>';
	echo '<label for="' . esc_attr( $field_name ) . '"></label>';

	// For field with additional options / sub-fields, we add a wrapper to enclose field descriptions
	if ( array_key_exists( 'field_options_wrapper', $args ) && $args['field_options_wrapper'] ) {
		echo '<div class="asenha-field-with-options">';
	}

	echo '<div class="asenha-field-description">' . wp_kses_post( $field_description ) . '</div>';

	// For field with additional options / sub-fields, we add wrapper for them
	if ( array_key_exists( 'field_options_wrapper', $args ) && $args['field_options_wrapper'] ) {
		echo '<div class="asenha-subfields" style="display:none"></div></div>';
	}

}

/**
 * Render checkbox field as sub-field of a toggle/switcher checkbox
 *
 * @since 1.9.0
 */
function asenha_render_field_checkbox_plain( $args ) {

	$options = get_option( ASENHA_SLUG_U );

	$field_name = $args['field_name'];
	$field_label = $args['field_label'];
	$field_option_value = ( isset( $options[$args['field_id']] ) ) ? $options[$args['field_id']] : false;

	echo '<input type="checkbox" id="' . esc_attr( $field_name ) . '" class="asenha-subfield-checkbox" name="' . esc_attr( $field_name ) . '" ' . checked( $field_option_value, true, false ) . '>';
	echo '<label for="' . esc_attr( $field_name ) . '" class="asenha-subfield-checkbox-label">' . wp_kses_post( $field_label ) . '</label>';

}

/**
 * Render checkbox field as sub-field of a toggle/switcher checkbox
 *
 * @since 1.3.0
 */
function asenha_render_field_checkbox_subfield( $args ) {

	$options = get_option( ASENHA_SLUG_U );

	$field_name = $args['field_name'];
	$field_label = $args['field_label'];
	$field_option_value = ( isset( $options[$args['parent_field_id']][$args['field_id']] ) ) ? $options[$args['parent_field_id']][$args['field_id']] : false;

	echo '<input type="checkbox" id="' . esc_attr( $field_name ) . '" class="asenha-subfield-checkbox" name="' . esc_attr( $field_name ) . '" ' . checked( $field_option_value, true, false ) . '>';
	echo '<label for="' . esc_attr( $field_name ) . '" class="asenha-subfield-checkbox-label">' . wp_kses_post( $field_label ) . '</label>';

}

/**
 * Render text field as sub-field of a toggle/switcher checkbox
 *
 * @since 1.4.0
 */
function asenha_render_field_text_subfield( $args ) {

	$options = get_option( ASENHA_SLUG_U );

	$field_id = $args['field_id'];
	$field_name = $args['field_name'];
	$field_type = $args['field_type'];
	$field_prefix = $args['field_prefix'];
	$field_suffix = $args['field_suffix'];
	$field_description = $args['field_description'];
	$field_option_value = ( isset( $options[$args['field_id']] ) ) ? $options[$args['field_id']] : '';

	if ( $field_id == 'custom_login_slug' ) {
		$placeholder = 'e.g. backend';
	} elseif ( $field_id == 'redirect_after_login_to_slug' ) {
		$placeholder = 'e.g. my-account';
	} elseif ( $field_id == 'redirect_after_logout_to_slug' ) {
		$placeholder = 'e.g. come-visit-again';
	} else {}

	echo $field_prefix . '<input type="text" id="' . esc_attr( $field_name ) . '" class="asenha-subfield-text" name="' . esc_attr( $field_name ) . '" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $field_option_value ) . '">' . $field_suffix;
	echo '<label for="' . esc_attr( $field_name ) . '" class="asenha-subfield-checkbox-label">' . esc_html( $field_description ) . '</label>';

}

/**
 * Render sortable menu field
 *
 * @since 2.0.0
 */
function asenha_render_field_sortable_menu( $args ) {

	?>
	<div class="subfield-description">Drag and drop menu items to the desired position. Click on the checkbox to hide it on page load. Hidden menu items can be shown by clicking on "Show All" at the bottom of the admin menu.</div>
	<ul id="custom-admin-menu" class="menu ui-sortable">
	<?php

	global $menu;
	global $submenu;
	$options = get_option( ASENHA_SLUG_U );

	// Get hidden menu items
	if ( array_key_exists( 'custom_menu_hidden', $options ) ) {
		$hidden_menu = $options['custom_menu_hidden'];
		$hidden_menu = explode( ',', $hidden_menu );
	} else {
		$hidden_menu = array();
	}

	$i = 1;

	// Check if there's an existing custom menu order data stored in options

	if ( array_key_exists( 'custom_menu_order', $options ) ) {

		$custom_menu = $options['custom_menu_order'];
		$custom_menu = explode( ',', $custom_menu );

		// Render sortables with data in custom menu order

		foreach ( $custom_menu as $custom_menu_item ) {

			foreach ( $menu as $menu_key => $menu_info ) {

				if ( false !== strpos( $menu_info[4], 'wp-menu-separator' ) ) {
					$menu_item_id = $menu_info[2];
				} else {
					$menu_item_id = $menu_info[5];
				}

				if ( $custom_menu_item == $menu_item_id ) {

					?>
					<li id="<?php echo wp_kses_post( $menu_item_id ); ?>" class="menu-item menu-item-depth-0">
						<div class="menu-item-bar">
							<div class="menu-item-handle ui-sortable-handle">
								<div class="item-title">
									<span class="menu-item-title">
					<?php

					if ( false !== strpos( $menu_info[4], 'wp-menu-separator' ) ) {
						$separator_name = $menu_info[2];
						$separator_name = str_replace( 'separator', 'Separator-', $separator_name );
						$separator_name = str_replace( '--last', '-Last', $separator_name );
						echo '~~ ' . wp_kses_post( $separator_name ) . ' ~~';
					} else {
						echo wp_kses_post( $menu_info[0] );
					}

					?>
									</span>
									<label class="menu-item-checkbox-label">
										<?php
											if ( in_array( $custom_menu_item, $hidden_menu ) ) {
											?>
										<input type="checkbox" class="menu-item-checkbox" data-menu-item-id="<?php echo wp_kses_post( $menu_item_id ); ?>" checked>
										<span>Hide</span>
											<?php
											} else {
											?>
										<input type="checkbox" class="menu-item-checkbox" data-menu-item-id="<?php echo wp_kses_post( $menu_item_id ); ?>">
										<span>Hide</span>
											<?php
											}
										?>
									</label>
								</div>
							</div>
						</div>
					<?php

					$i = 1;

					if ( array_key_exists( $menu_info[2], $submenu ) && @is_countable( $submenu[$menu_info[2]] ) && @sizeof( $submenu[$menu_info[2]] ) > 0 ) {
						?>
						<div class="menu-item-settings wp-clearfix" style="display:none;">
						<?php

						foreach ( $submenu[$menu_info[2]] as $submenu_item ) {

							$i++;

							// echo $submenu_item[0];

						}
						?>
						</div>
						<?php

					}
					?>
					</li>

					<?php

				}

			}

		}

	} else {

		// Render sortables with existing items in the admin menu

		foreach ( $menu as $menu_key => $menu_info ) {

			if ( false !== strpos( $menu_info[4], 'wp-menu-separator' ) ) {
				$menu_item_id = $menu_info[2];
			} else {
				$menu_item_id = $menu_info[5];
			}

			?>
			<li id="<?php echo wp_kses_post( $menu_item_id ); ?>" class="menu-item menu-item-depth-0">
				<div class="menu-item-bar">
					<div class="menu-item-handle ui-sortable-handle">
						<div class="item-title">
							<span class="menu-item-title">
			<?php

			if ( false !== strpos( $menu_info[4], 'wp-menu-separator' ) ) {
				$separator_name = $menu_info[2];
				$separator_name = str_replace( 'separator', 'Separator-', $separator_name );
				$separator_name = str_replace( '--last', '-Last', $separator_name );
				echo '~~ ' . wp_kses_post( $separator_name ) . ' ~~';
			} else {
				echo wp_kses_post( $menu_info[0] );
			}

			?>
							</span>
							<label class="menu-item-checkbox-label">
								<input type="checkbox" class="menu-item-checkbox" data-menu-item-id="<?php echo wp_kses_post( $menu_item_id ); ?>">
								<span>Hide</span>
							</label>
						</div>
					</div>
				</div>
			<?php

			$i = 1;

			if ( array_key_exists( $menu_info[2], $submenu ) && @is_countable( $submenu[$menu_info[2]] ) && @sizeof( $submenu[$menu_info[2]] ) > 0 ) {
				?>
				<div class="menu-item-settings wp-clearfix" style="display:none;">
				<?php

				foreach ( $submenu[$menu_info[2]] as $submenu_item ) {

					$i++;

					// echo $submenu_item[0];

				}
				?>
				</div>
				<?php

			}
			?>
			</li>

			<?php

		}


	}


	?>
	</ul>
	<?php

	$field_id = $args['field_id'];
	$field_name = $args['field_name'];
	$field_description = $args['field_description'];
	$field_option_value = ( isset( $options[$args['field_id']] ) ) ? $options[$args['field_id']] : '';

	// Hidden input field to store custom menu order (from options as is, or sortupdate) upon clicking Save Changes. 
	echo '<input type="hidden" id="' . esc_attr( $field_name ) . '" class="asenha-subfield-text" name="' . esc_attr( $field_name ) . '" value="' . esc_attr( $field_option_value ) . '">';

	$field_id = 'custom_menu_hidden';
	$field_name = ASENHA_SLUG_U . '['. $field_id .']';
	$field_option_value = ( isset( $options[$field_id] ) ) ? $options[$field_id] : '';

	// Hidden input field to store hidden menu itmes (from options as is, or 'Hide' checkbox clicks) upon clicking Save Changes.
	echo '<input type="hidden" id="' . esc_attr( $field_name ) . '" class="asenha-subfield-text" name="' . esc_attr( $field_name ) . '" value="' . esc_attr( $field_option_value ) . '">';

}

/**
 * Suppress all notices, then add notice for successful settings update
 *
 * @since 1.1.0
 */
function asenha_notices() {

	global $plugin_page;

	// Suppress all notices

	if ( ASENHA_SLUG === $plugin_page ) {

		remove_all_actions( 'admin_notices' );

	}

	// Add notice for successful settings update

	if (
		isset( $_GET[ 'page' ] ) 
		&& ASENHA_SLUG == $_GET[ 'page' ]
		&& isset( $_GET[ 'settings-updated' ] ) 
		&& true == $_GET[ 'settings-updated' ]
	) {
		?>
			<script>
				jQuery(document).ready( function() {
					jQuery('.asenha-changes-saved').fadeIn(400).delay(2500).fadeOut(400);
				});
			</script>

		<?php
	}
}

/**
 * Enqueue admin scripts
 *
 * @since 1.0.0
 */
function asenha_admin_scripts( $hook_suffix ) {

	$current_screen = get_current_screen();

	// Get all WP Enhancements options, default to empty array in case it's not been created yet
	$options = get_option( 'admin_site_enhancements', array() );

	// For main page of this plugin

	if ( is_asenha() ) {
		wp_enqueue_style( 'asenha-jbox', ASENHA_URL . 'assets/css/jBox.all.min.css', array(), ASENHA_VERSION );
		wp_enqueue_script( 'asenha-jbox', ASENHA_URL . 'assets/js/jBox.all.min.js', array(), ASENHA_VERSION, false );
		wp_enqueue_script( 'asenha-jsticky', ASENHA_URL . 'assets/js/jquery.jsticky.mod.min.js', array( 'jquery' ), ASENHA_VERSION, false );
		wp_enqueue_style( 'asenha-admin-page', ASENHA_URL . 'assets/css/admin-page.css', array( 'asenha-jbox' ), ASENHA_VERSION );
		wp_enqueue_script( 'asenha-admin-page', ASENHA_URL . 'assets/js/admin-page.js', array( 'asenha-jsticky', 'asenha-jbox' ), ASENHA_VERSION, false );
	}

	// Enqueue on all wp-admin

	wp_enqueue_style( 'asenha-wp-admin', ASENHA_URL . 'assets/css/wp-admin.css', array(), ASENHA_VERSION );

	// Content Management >> Show IDs, for list tables in wp-admin, e.g. All Posts page

	if ( ( false !== strpos( $current_screen->base, 'edit' ) ) // List tables for pages, posts, taxonomies
		|| ( false !== strpos( $current_screen->base, 'users' ) ) // Users list table
		|| ( false !== strpos( $current_screen->base, 'upload' ) ) // Media list table
	) {
		wp_enqueue_style( 'asenha-list-table', ASENHA_URL . 'assets/css/list-table.css', array(), ASENHA_VERSION );
	}

	// Content Management >> Enable Media Replacement
	
	if ( ( $current_screen->base == 'upload' ) // Media list table
		|| ( $current_screen->id == 'attachment' ) // Media edit page
	) {
		// wp_enqueue_style( 'asenha-jbox', ASENHA_URL . 'assets/css/jBox.all.min.css', array(), ASENHA_VERSION );
		// wp_enqueue_script( 'asenha-jbox', ASENHA_URL . 'assets/js/jBox.all.min.js', array(), ASENHA_VERSION, false );
		wp_enqueue_style( 'asenha-media-replace', ASENHA_URL . 'assets/css/media-replace.css', array(), ASENHA_VERSION );
		wp_enqueue_script( 'asenha-media-replace', ASENHA_URL . 'assets/js/media-replace.js', array(), ASENHA_VERSION, false );
	}

	// Content Management >> Hide Admin Notices
	if ( array_key_exists( 'hide_admin_notices', $options ) && $options['hide_admin_notices'] ) {
		wp_enqueue_style( 'asenha-jbox', ASENHA_URL . 'assets/css/jBox.all.min.css', array(), ASENHA_VERSION );
		wp_enqueue_script( 'asenha-jbox', ASENHA_URL . 'assets/js/jBox.all.min.js', array(), ASENHA_VERSION, false );
		wp_enqueue_style( 'asenha-hide-admin-notices', ASENHA_URL . 'assets/css/hide-admin-notices.css', array(), ASENHA_VERSION );
		wp_enqueue_script( 'asenha-hide-admin-notices', ASENHA_URL . 'assets/js/hide-admin-notices.js', array( 'asenha-jbox' ), ASENHA_VERSION, false );
	}

}

/**
 * Add 'Access now' plugin action link.
 *
 * @since    1.0.0
 */

function asenha_plugin_action_links( $links ) {

	$settings_link = '<a href="tools.php?page=' . ASENHA_SLUG . '">Access now</a>';

	array_unshift($links, $settings_link); 

	return $links; 

}

/**
 * Modify footer text
 *
 * @since 1.0.0
 */
function asenha_footer_text() {

	if ( is_asenha() ) {
		?>
		<a href="https://wordpress.org/plugins/admin-site-enhancements/" target="_blank">Admin Site Enhancements</a> is on <a href="https://github.com/qriouslad/admin-site-enhancements" target="_blank">github</a>.
		<?php
	}

}

/**
 * Check if current screen is this plugin's main page
 *
 * @since 1.0.0
 */
function is_asenha() {

	$request_uri = sanitize_text_field( $_SERVER['REQUEST_URI'] ); // e.g. /wp-admin/index.php?page=page-slug

	if ( strpos( $request_uri, 'page=' . ASENHA_SLUG ) !== false ) {
		return true; // Yes, this is the plugin's main page
	} else {
		return false; // Nope, this is NOT the plugin's page
	}

}