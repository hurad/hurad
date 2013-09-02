<?php

//HuradHook::add_filter('the_title', 'Formatting::wptexturize');
HuradHook::add_filter('the_title', 'Formatting::convert_chars');
HuradHook::add_filter('the_title', 'trim');

//HuradHook::add_filter('the_content', 'post_formats_compat', 7);
//HuradHook::add_filter('the_content', 'wptexturize');
//HuradHook::add_filter('the_content', 'convert_smilies');
HuradHook::add_filter('the_content', 'Formatting::convert_chars');
//HuradHook::add_filter('the_content', 'wpautop');
//HuradHook::add_filter('the_content', 'shortcode_unautop');
//HuradHook::add_filter('the_content', 'prepend_attachment');

//HuradHook::add_filter( 'comment_text', 'wptexturize' );
HuradHook::add_filter('comment_text', 'Formatting::convert_chars');
HuradHook::add_filter('comment_text', 'Formatting::make_clickable', 9);
HuradHook::add_filter('comment_text', 'Formatting::force_balance_tags', 25);
//HuradHook::add_filter( 'comment_text', 'convert_smilies', 20 );
HuradHook::add_filter('comment_text', 'Formatting::hrautop', 30);

HuradHook::add_filter('editable_slug', 'urldecode');
HuradHook::add_filter('editable_slug', 'Formatting::esc_textarea');
HuradHook::add_filter('sanitize_title', 'Formatting::sanitize_title_with_dashes', 10, 3);

//HuradHook::add_filter( 'the_excerpt', 'wptexturize' );
//HuradHook::add_filter( 'the_excerpt', 'convert_smilies' );
HuradHook::add_filter('the_excerpt', 'Formatting::convert_chars');
HuradHook::add_filter('the_excerpt', 'Formatting::hrautop');
//HuradHook::add_filter( 'the_excerpt', 'shortcode_unautop');
//HuradHook::add_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
