<?php
/**
 * Application level View Helper
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
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 *
 * @property HtmlHelper        $Html
 * @property AdminLayoutHelper $AdminLayout
 * @property AuthorHelper      $Author
 * @property CommentHelper     $Comment
 * @property DashboardHelper   $Dashboard
 * @property EditorHelper      $Editor
 * @property GeneralHelper     $General
 * @property GravatarHelper    $Gravatar
 * @property HookHelper        $Hook
 * @property LinkHelper        $Link
 * @property ContentHelper     $Content
 * @property RoleHelper        $Role
 * @property WidgetHelper      $Widget
 */
class AppHelper extends Helper
{
    /**
     * Check in PHP file use FormHelper or not
     *
     * @param string $fileContent PHP file content
     *
     * @return bool
     */
    public function hasFormHelper($fileContent)
    {
        $arrayObject = new ArrayObject(token_get_all($fileContent));
        $iterator = $arrayObject->getIterator();

        $hasFormHelper = [];
        $index = 0;
        while ($iterator->valid()) {
            if (is_array($iterator->current()) && ($iterator->current()[1] == 'Form' || $iterator->current(
                    )[1] == 'form')
            ) {
                $iterator->seek(($index + 1));

                if ($iterator->current()[0] == 359) {
                    $hasFormHelper[] = $index;
                }
            }
            $index++;
            $iterator->next();
        }

        return (bool)count($hasFormHelper);
    }
}
