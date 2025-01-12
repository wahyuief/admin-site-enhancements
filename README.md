# Admin and Site Enhancements

Contributors: qriouslad  
Donate link: https://paypal.me/qriouslad  
Tags: enhancements, tweaks, optimizations, tools  
Requires at least: 4.6  
Tested up to: 6.1  
Stable tag: 2.1.0  
Requires PHP: 5.6  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

![](.wordpress-org/banner-772x250.png)

Duplicate page / post, replace media, hide login, hide admin notices, hide admin bar, login / logout / 404 redirect, and more in a single plugin.

## Description

Admin and Site Enhancements helps you to easily enhance various admin workflows and site aspects while replacing multiple plugins doing it. 

### Content Management

* **Enable Page and Post Duplication**. Enable one-click duplication of pages, posts and custom posts. The corresponding taxonomy terms and post meta will also be duplicated.
* **Enable Media Replacement**. Easily replace any type of media file with a new one while retaining the existing media ID, publish date and file name. So, no existing links will break.
* **Enhance List Tables**. Improve the usefulness of listing pages of various post types by adding / removing columns and elements.
  * _Show the featured image column_: in the list tables for pages and post types that support featured images.
  * _Show the excerpt column_: in the list tables for pages and post types that support excerpt.
  * _Show the ID column_: in the list tables for pages, all post types, all taxonomies, media, users and comments.
  * _Remove the comments column_: in in the list tables for pages, post types that support comments, and alse media/attachments.
  * _Remove the post tags column_: in the list table for posts.
  * _Show custom taxonomy dropdown filter(s)_: on the list tables of all post types for taxonomies that are hierarchical like post categories.

### Admin Interface

* **Hide Admin Notices**. Clean up admin pages by moving notices into a separate panel easily accessible via the admin bar.
* **View Admin as Role**. View admin pages and the site (logged-in) as one of the non-administrator user roles.
* **Admin Menu Organizer**. Customize the order of the admin menu and optionally hide some items.
* **Clean Up Admin Bar**. Remove various elements from the admin bar.
  * Remove WordPress logo/menu
  * Remove customize menu/link
  * Remove updates counter/link
  * Remove comments counter/link
  * Remove new content menu
  * Remove 'Howdy' text
* **Hide Admin Bar**. Hide it on the front end for all or some user roles.

### Security

* **Change Login URL**. Improve site security by using a custom login URL, e.g. www.example.com/backend 
* **Obfuscate Author Slugs**. Obfuscate publicly exposed author page URLs that shows the user slugs / usernames, e.g. _sitename.com/author/username1/_ into _sitename.com/author/a6r5b8ytu9gp34bv/_, and output 404 errors for the original URLs. Also obfuscates in _/wp-json/wp/v2/users/_ REST API endpoint.

### Utilities

* **Redirect After Login / Logout**. Set custom redirect URL for all or some user roles after login / logout.
* **Redirect 404 to Homepage**. Perform 301 (permanent) redirect to the homepage for all 404 (not found) pages.

Admin and Site Enhancements will include more enhancements, tweaks and useful features in future versions. Please [give feedback](https://wordpress.org/support/plugin/admin-site-enhancements/) on must-have plugins or code snippets you enable on sites that you manage, and the functionalities will be considered for inclusion as well.

### Give Back

* [A nice review](https://wordpress.org/plugins/admin-site-enhancements/#reviews) would be great!
* [Give feedback](https://wordpress.org/support/plugin/admin-site-enhancements/) and help improve future versions.
* [Github repo](https://github.com/qriouslad/admin-site-enhancements) to contribute code.
* [Donate](https://paypal.me/qriouslad) and support my work.

### Check These Out Too

* [System Dashboard](https://wordpress.org/plugins/system-dashboard/): Central dashboard to monitor various WordPress components, processes and data, including the server.
* [Debug Log Manager](https://wordpress.org/plugins/debug-log-manager/): Log PHP, database and JavaScript errors via WP_DEBUG with one click. Conveniently create, view, filter and clear the debug.log file.
* [Variable Inspector](https://wordpress.org/plugins/variable-inspector/): Inspect PHP variables on a central dashboard in wp-admin for convenient debugging.
* [Code Explorer](https://wordpress.org/plugins/code-explorer/): Fast directory explorer and file/code viewer with syntax highlighting.

## Screenshots

1. Content Management
   ![Content Management](.wordpress-org/screenshot-1.png)
2. Admin Interface
   ![Admin Interface](.wordpress-org/screenshot-2.png)
3. Security
   ![Security](.wordpress-org/screenshot-3.png)
4. Utilities
   ![Utilities](.wordpress-org/screenshot-4.png)

## Frequently Asked Questions

### Why build this plugin?

Hoping that this is useful in reducing the number of plugins we install the first time we set up a site.

## Changelog

### 2.1.0 (2022.11.08)

* **[ADDED] Security >> Obfuscate Author Slugs**: Obfuscate publicly exposed author page URLs that shows the user slugs / usernames, e.g. _sitename.com/author/username1/_ into _sitename.com/author/a6r5b8ytu9gp34bv/_, and output 404 errors for the original URLs. Also obfuscates in _/wp-json/wp/v2/users/_ REST API endpoint. Props to [pull request](https://github.com/qriouslad/admin-site-enhancements/pull/1) from [Wahyu Arief @wahyuief](https://github.com/wahyuief) and [functions](https://plugins.trac.wordpress.org/browser/smart-user-slug-hider/tags/4.0.2/inc/class-smart-user-slug-hider.php) from [Smart User Slug Hider
](https://wordpress.org/plugins/smart-user-slug-hider/).

### 2.0.0 (2022.11.06)

* **[ADDED] Admin Interface >> Admin Menu Organizer**: Customize the order of the admin menu and optionally hide some items.

### 1.9.0 (2022.11.03)

* **[ADDED] Admin Interface >> Hide or Modify Elements**: Easily simplify or customize various admin UI elements, starting with the admin bar.
* **[CHANGED] Content Management >> Enhance List Tables**: this combines previously separate features related to list tables for various post types.

### 1.8.0 (2022.11.03)

* **[ADDED] Admin Interface >> View Admin as Role**: View admin pages and the site (logged-in) as one of the non-administrator user roles.

### 1.7.0 (2022.10.31)

* **[ADDED] Utilities >> Redirect 404 to Homepage**: Perform 301 (permanent) redirect to the homepage for all 404 (not found) pages.

### 1.6.0 (2022.10.31)

* **[ADDED] Utilities >> Redirect After Logout**: Set custom redirect URL for all or some user roles after logout.

### 1.5.0 (2022.10.30)

* **[ADDED] Utilities >> Redirect After Login**: Set custom redirect URL for all or some user roles after login.

### 1.4.0 (2022.10.30)

* **[ADDED] Security >> Change Login URL**: allow for setting a custom login URL to improve site security.

### 1.3.0 (2022.10.29)

* **[ADDED] Admin Interface >> Hide Admin Bar**: Hide it on the front end for all or some user roles.


### 1.2.0 (2022.10.28)

* **[ADDED] Admin Interface >> Hide Admin Notices**: Clean up admin pages by moving notices into a separate panel easily accessible via the admin bar.

### 1.1.0 (2022.10.22)

* **[ADDED] Content Management >> Enable Media Replacement**: Enable easy replacement of any type of media file with a new one while retaining the existing media ID and file name.

### 1.0.0 (2022.10.17)

* Initial stable release. 