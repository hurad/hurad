<?php
/**
 * This is Hurad Schema file
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */

/**
 * Class HuradSchema
 */
class HuradSchema extends CakeSchema
{

    public function before($event = array())
    {
        return true;
    }

    public function after($event = array())
    {
    }

    public $categories = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'parent_id' => array('type' => 'biginteger', 'null' => true, 'default' => null),
        'name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 200,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'slug' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'key' => 'unique',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'lft' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'rght' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'description' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'post_count' => array('type' => 'integer', 'null' => false, 'default' => null),
        'path' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 250,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'CATEGORIES_SLUG_UNIQUE' => array('column' => 'slug', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $categories_posts = array(
        'category_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'post_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'indexes' => array(
            'PRIMARY' => array('column' => array('category_id', 'post_id'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $comments = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'parent_id' => array('type' => 'biginteger', 'null' => true, 'default' => null),
        'post_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'user_id' => array('type' => 'biginteger', 'null' => false, 'default' => '0'),
        'author' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'author_email' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'author_url' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 200,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'author_ip' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'content' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'status' => array(
            'type' => 'integer',
            'null' => false,
            'default' => '2',
            'length' => 2,
            'comment' => 'trash, spam, pending, approved'
        ),
        'agent' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'lft' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'rght' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $links = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'parent_id' => array('type' => 'biginteger', 'null' => true, 'default' => null),
        'menu_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'description' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'url' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'target' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'rel' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'visible' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
        'rating' => array('type' => 'integer', 'null' => true, 'default' => null),
        'lft' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'rght' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $media = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'user_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'title' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'description' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'Generated name with extension',
            'charset' => 'utf8'
        ),
        'original_name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'Original name with extension',
            'charset' => 'utf8'
        ),
        'mime_type' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'size' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'extension' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 5,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'path' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 12,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'web_path' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $menus = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'slug' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'key' => 'unique',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'description' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'type' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 50,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'link_count' => array('type' => 'integer', 'null' => false, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'MENUS_SLUG_UNIQUE' => array('column' => 'slug', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $options = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'key' => 'unique',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'value' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'OPTIONS_NAME_UNIQUE' => array('column' => 'name', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $post_meta = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'post_id' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'key' => 'index'),
        'meta_key' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'meta_value' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'POST_META_POST_ID_META_KEY_UNIQUE' => array('column' => array('post_id', 'meta_key'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $posts = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'parent_id' => array('type' => 'biginteger', 'null' => true, 'default' => null),
        'user_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'title' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'slug' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'key' => 'unique',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'content' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'excerpt' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'status' => array(
            'type' => 'integer',
            'null' => false,
            'default' => '3',
            'length' => 2,
            'comment' => 'trash, draft, pending, publish'
        ),
        'comment_status' => array(
            'type' => 'integer',
            'null' => false,
            'default' => '2',
            'length' => 2,
            'comment' => 'disable, close, open'
        ),
        'comment_count' => array('type' => 'integer', 'null' => false, 'default' => null),
        'type' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 20,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'sticky' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'lft' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'rght' => array('type' => 'biginteger', 'null' => false, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'POSTS_SLUG_UNIQUE' => array('column' => 'slug', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $posts_tags = array(
        'post_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'tag_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'indexes' => array(
            'PRIMARY' => array('column' => array('post_id', 'tag_id'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $tags = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'name' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'slug' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'key' => 'unique',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'description' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'post_count' => array('type' => 'integer', 'null' => false, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'TAGS_SLUG_UNIQUE' => array('column' => 'slug', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $user_meta = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'user_id' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'key' => 'index'),
        'meta_key' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'meta_value' => array(
            'type' => 'text',
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'USER_META_USER_ID_META_KEY_UNIQUE' => array('column' => array('user_id', 'meta_key'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $users = array(
        'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
        'username' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 60,
            'key' => 'unique',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'password' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 64,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'email' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'key' => 'unique',
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'url' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 100,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'role' => array(
            'type' => 'string',
            'null' => false,
            'default' => null,
            'length' => 20,
            'collate' => 'utf8_general_ci',
            'charset' => 'utf8'
        ),
        'status' => array('type' => 'integer', 'null' => false, 'default' => null),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'USERS_USERNAME_UNIQUE' => array('column' => 'username', 'unique' => 1),
            'USERS_EMAIL_UNIQUE' => array('column' => 'email', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
}
