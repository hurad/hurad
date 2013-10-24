<?php

HuradWidget::registerSidebar(
    array(
        'name' => __('Right Sidebar'),
        'id' => 'right-sidebar',
        'before_widget' => '<div class="panel panel-default">',
        'after_widget' => '</div></div>',
        'before_title' => '<div class="panel-heading">',
        'after_title' => '</div><div class="panel-body">',
    )
);