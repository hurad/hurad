<?php

//$HuradHook = Configure::read('HuradHook.obj');
HrNav::add(
    'dashboard',
    array(
        'child' => array(
            'test' => array(
                'title' => __('Hello World'),
                'url' => array('admin' => true, 'plugin' => 'hello_world', 'controller' => 'hello'),
                'weight' => 1,
            ),
        ),
    )
);
//$title .= 'Mohammad ';
//HuradHook::add_filter('the_title', function($title) {
//            return 'Mohammad ' . $title;
//        });

//function test() {
//
//    echo 'Salam';
//}

//$HuradHook->add_filter('the_date', 'test');
//debug($HuradHook);
//HuradHook::add_action('test', 'test');
//debug($HuradHook);
