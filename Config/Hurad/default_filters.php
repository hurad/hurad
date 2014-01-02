<?php
/**
 * Default filters
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

HuradHook::add_filter('the_title', 'trim');

HuradHook::add_filter('commentText', 'HuradFormatting::clickAbleLink', 9);
HuradHook::add_filter('commentText', 'HuradFormatting::convertEmoticons', 20);

HuradHook::add_filter('editable_slug', 'urldecode');
HuradHook::add_filter('editable_slug', 'HuradSanitize::textarea');