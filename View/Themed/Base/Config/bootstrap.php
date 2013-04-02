<?php

HuradWidget::registerSidebar(array('name' => __('Right Sidebar')));
HuradWidget::registerSidebar(array('name' => __('Left Sidebar')));

HuradWidget::registerWidget(array(
    'title' => __('Authors'),
    'element' => 'authors',
        )
);
HuradWidget::registerWidget(array(
    'title' => __('Categories'),
    'element' => 'categories',
        )
);
HuradWidget::registerWidget(array(
    'title' => __('Recent Posts'),
    'element' => 'recent_posts',
        )
);
HuradWidget::registerWidget(array(
    'title' => __('Pages'),
    'element' => 'pages',
        )
);