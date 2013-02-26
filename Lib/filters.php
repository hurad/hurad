<?php

//$HuradHook->add_filter('the_title', 'Formatting::wptexturize');
$HuradHook->add_filter('the_title', 'Formatting::convert_chars');
$HuradHook->add_filter('the_title', 'trim');

//$HuradHook->add_filter('the_content', 'post_formats_compat', 7);
//$HuradHook->add_filter('the_content', 'wptexturize');
//$HuradHook->add_filter('the_content', 'convert_smilies');
$HuradHook->add_filter('the_content', 'Formatting::convert_chars');
//$HuradHook->add_filter('the_content', 'wpautop');
//$HuradHook->add_filter('the_content', 'shortcode_unautop');
//$HuradHook->add_filter('the_content', 'prepend_attachment');

//foreach (array('the_content', 'the_title') as $filter) {
//    $HuradHook->add_filter($filter, 'capital_P_dangit', 11);
//}
    
