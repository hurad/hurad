<?php
/**
 * Application model
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
App::uses('Model', 'Model');

/**
 * Application model
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 */
class AppModel extends Model
{
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);

        App::uses('Hurad', 'Lib');
        Hurad::applyProperty('behavior', $this);
    }
}
