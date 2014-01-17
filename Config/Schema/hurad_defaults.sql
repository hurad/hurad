INSERT INTO `$[prefix]categories`(`id`, `parent_id`, `name`, `slug`, `lft`, `rght`, `description`, `post_count`, `path`, `created`, `modified`) VALUES
     (1, NULL, 'Uncategorized', 'uncategorized', 1, 2, 'Default Description', 1, 'Uncategorized', '$[created]', '$[modified]');

INSERT INTO `$[prefix]posts`(`id`, `parent_id`, `user_id`, `title`, `slug`, `content`, `excerpt`, `status`, `comment_status`, `comment_count`, `type`, `lft`, `rght`, `created`, `modified`) VALUES
     (1, NULL, 1, 'Sample Post', 'sample-post', 'Sample Post', '', 3, 2, 1, 'post', 1, 2, '$[created]', '$[modified]');

INSERT INTO `$[prefix]categories_posts`(`category_id`, `post_id`) VALUES
     (1, 1);

INSERT INTO `$[prefix]comments`(`id`, `parent_id`, `post_id`, `user_id`, `author`, `author_email`, `author_url`, `author_ip`, `content`, `status`, `agent`, `lft`, `rght`, `created`, `modified`) VALUES
     (1, NULL, 1, 1, '$[username]', '$[email]', '', '$[client_ip]', 'This comment has been sent for testing, you can delete it', 3, '$[user_agent]', 1, 2, '$[created]', '$[modified]');

INSERT INTO `$[prefix]users`(`id`, `username`, `password`, `email`, `url`, `role`, `status`, `created`, `modified`) VALUES
     (1, '$[username]', '$[password]', '$[email]', '', 'administrator', 0, '$[created]', '$[modified]');

INSERT INTO `$[prefix]user_meta` (`id`, `user_id`, `meta_key`, `meta_value`) VALUES
    (1, 1, 'nickname', '$[username]'),
    (2, 1, 'display_name', '$[username]');

INSERT INTO `$[prefix]options` (`id`, `name`, `value`) VALUES
    (1, 'General.site_url', '$[site_url]'),
    (2, 'General.site_name', '$[title]'),
    (3, 'General.site_description', ''),
    (4, 'General.admin_email', '$[email]'),
    (5, 'General.users_can_register', '0'),
    (6, 'General.default_role', 'user'),
    (7, 'General.timezone', 'Asia/Tehran'),
    (8, 'General.time_format', 'g:i A'),
    (9, 'General.date_format', 'F j, Y'),
    (10, 'Read.show_posts_per_page', '5'),
    (11, 'Comment.show_avatars', '1'),
    (12, 'Comment.avatar_rating', 'G'),
    (13, 'Comment.avatar_default', 'mystery'),
    (14, 'decimal_point', '.'),
    (15, 'thousands_sep', ','),
    (16, 'template', 'Hurad2013'),
    (17, 'site_charset', 'UTF-8'),
    (18, 'Permalink.common', 'default');