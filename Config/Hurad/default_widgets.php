<?php
/**
 * Register default widgets
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

HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Authors'),
        'element' => 'authors',
    ]
);

HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Categories'),
        'element' => 'categories',
    ]
);

HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Recent Posts'),
        'element' => 'recent-posts',
    ]
);

HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Recent Comments'),
        'element' => 'recent-comments',
    ]
);

HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Pages'),
        'element' => 'pages',
    ]
);

HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Text'),
        'element' => 'text',
    ]
);
