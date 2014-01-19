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

/**
 * Authors widget
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Authors'),
        'element' => 'authors',
    ]
);

/**
 * Categories widget
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Categories'),
        'element' => 'categories',
    ]
);

/**
 * Recent Posts widgets
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Recent Posts'),
        'element' => 'recent-posts',
    ]
);

/**
 * Recent Comments widgets
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Recent Comments'),
        'element' => 'recent-comments',
    ]
);

/**
 * Pages widget
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Pages'),
        'element' => 'pages',
    ]
);

/**
 * Text widget
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Text'),
        'element' => 'text',
    ]
);

/**
 * Links widget
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'Links'),
        'element' => 'links',
    ]
);

/**
 * RSS widget
 */
HuradWidget::registerWidget(
    [
        'title' => __d('hurad', 'RSS'),
        'element' => 'rss',
    ]
);
