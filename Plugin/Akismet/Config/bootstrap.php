<?php

App::uses('Akismet', 'Akismet.Lib');

HrNav::add(
    'options',
    array(
        'child' => array(
            'akismet' => array(
                'title' => __('Akismet Configuration'),
                'url' => array('admin' => true, 'plugin' => 'akismet', 'controller' => 'akismet'),
                'weight' => 5,
            ),
        ),
    )
);

Hurad::applyBehavior('Comment', 'Akismet.Akismet');