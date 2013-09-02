<?php
/**
 * Add default roles
 */
HuradRole::addRole('administrator', __('Administrator'));
HuradRole::addRole('editor', __('Editor'));
HuradRole::addRole('author', __('Author'));
HuradRole::addRole('user', __('User'));

/*
 * Administrator Capabilities
 */

/*
 * Administrator Posts Capability
 */
HuradRole::addCap('administrator', 'manage_posts');
HuradRole::addCap('administrator', 'publish_posts');
HuradRole::addCap('administrator', 'edit_published_posts');
HuradRole::addCap('administrator', 'edit_others_posts');
HuradRole::addCap('administrator', 'delete_posts');
HuradRole::addCap('administrator', 'delete_published_posts');
HuradRole::addCap('administrator', 'delete_others_posts');

/*
 * Administrator Categories Capability
 */
HuradRole::addCap('administrator', 'manage_categories');

/*
 * Administrator Tags Capability
 */
HuradRole::addCap('administrator', 'manage_tags');

/*
 * Administrator Links Capability
 */
HuradRole::addCap('administrator', 'manage_links');

/*
 * Administrator Pages Capability
 */
HuradRole::addCap('administrator', 'manage_pages');
HuradRole::addCap('administrator', 'publish_pages');
HuradRole::addCap('administrator', 'edit_published_pages');
HuradRole::addCap('administrator', 'edit_others_pages');
HuradRole::addCap('administrator', 'delete_pages');
HuradRole::addCap('administrator', 'delete_published_pages');
HuradRole::addCap('administrator', 'delete_others_pages');

/*
 * Administrator Comments Capability
 */
HuradRole::addCap('administrator', 'manage_comments');

/*
 * Administrator Appearance Capability
 */
HuradRole::addCap('administrator', 'manage_themes');
HuradRole::addCap('administrator', 'switch_themes');
HuradRole::addCap('administrator', 'delete_themes');
HuradRole::addCap('administrator', 'manage_menus');

/*
 * Administrator Plugins Capability
 */
HuradRole::addCap('administrator', 'manage_plugins');
HuradRole::addCap('administrator', 'activate_plugins');
HuradRole::addCap('administrator', 'delete_plugins');

/*
 * Administrator Users Capability
 */
HuradRole::addCap('administrator', 'manage_users');
HuradRole::addCap('administrator', 'edit_users');

/*
 * Administrator Options Capability
 */
HuradRole::addCap('administrator', 'manage_options');

/*
 * Administrator Etc Capability
 */
HuradRole::addCap('administrator', 'read');
HuradRole::addCap('administrator', 'index');


/*
 * Editor Capabilities
 */

/*
 * Editor Posts Capability
 */
HuradRole::addCap('editor', 'manage_posts');
HuradRole::addCap('editor', 'all_posts');
HuradRole::addCap('editor', 'add_posts');
HuradRole::addCap('editor', 'publish_posts');
HuradRole::addCap('editor', 'edit_published_posts');
HuradRole::addCap('editor', 'edit_others_posts');
HuradRole::addCap('editor', 'delete_posts');
HuradRole::addCap('editor', 'delete_published_posts');
HuradRole::addCap('editor', 'delete_others_posts');

/*
 * Editor Categories Capability
 */
HuradRole::addCap('editor', 'manage_categories');

/*
 * Editor Tags Capability
 */
HuradRole::addCap('editor', 'manage_tags');

/*
 * Editor Links Capability
 */
HuradRole::addCap('editor', 'manage_links');

/*
 * Editor Pages Capability
 */
HuradRole::addCap('editor', 'manage_pages');
HuradRole::addCap('editor', 'publish_pages');
HuradRole::addCap('editor', 'edit_published_pages');
HuradRole::addCap('editor', 'edit_others_pages');
HuradRole::addCap('editor', 'delete_pages');
HuradRole::addCap('editor', 'delete_published_pages');
HuradRole::addCap('editor', 'delete_others_pages');

/*
 * Editor Comments Capability
 */
HuradRole::addCap('editor', 'manage_comments');

/*
 * Editor Users Capability
 */
HuradRole::addCap('editor', 'manage_users');

/*
 * Editor Etc Capability
 */
HuradRole::addCap('editor', 'read');
HuradRole::addCap('editor', 'index');


/*
 * Author Capabilities
 */

/*
 * Author Posts Capability
 */
HuradRole::addCap('author', 'manage_posts');
HuradRole::addCap('author', 'all_posts');
HuradRole::addCap('author', 'add_posts');
HuradRole::addCap('author', 'publish_posts');

/*
 * Author Users Capability
 */
HuradRole::addCap('author', 'manage_users');

/*
 * Author Etc Capability
 */
HuradRole::addCap('author', 'read');
HuradRole::addCap('author', 'index');


/*
 * User Capabilities
 */

/*
 * User Users Capability
 */
HuradRole::addCap('user', 'manage_users');

/*
 * User Etc Capability
 */
HuradRole::addCap('user', 'read');
HuradRole::addCap('user', 'index');