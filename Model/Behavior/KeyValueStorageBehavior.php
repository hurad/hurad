<?php
/**
 * Key Value Storage behavior
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
 * Class KeyValueStorageBehavior
 */
class KeyValueStorageBehavior extends ModelBehavior
{
    /**
     * Contains configuration settings for use with individual model objects. This
     * is used because if multiple models use this Behavior, each will use the same
     * object instance. Individual model settings should be stored as an
     * associative array, keyed off of the model name.
     *
     * @var array
     */
    public $settings = [
        'key' => '__meta_key__',
        'value' => '__meta_value__',
        'foreign_key' => '__user_id__'
    ];

    /**
     * Setup this behavior with the specified configuration settings.
     *
     * @param Model $model  Model using this behavior
     * @param array $config Configuration settings for $model
     *
     * @return void
     */
    public function setup(Model $model, $config = [])
    {
        $this->settings[$model->alias] = Hash::merge($this->settings, $config);
    }

    /**
     * After find callback. Can be used to modify any results returned by find.
     *
     * @param Model   $model   Model using this behavior
     * @param mixed   $results The results of the find operation
     * @param boolean $primary Whether this model is being queried directly (vs. being queried as an association)
     *
     * @return mixed An array value will replace the value of $results - any other value will be ignored.
     */
    public function afterFind(Model $model, $results, $primary = false)
    {
        parent::afterFind($model, $results, $primary);

        if ($primary && array_key_exists($model->alias, $results[0])) {
            $arrObj = new ArrayObject($results);
            $iterator = $arrObj->getIterator();

            while ($iterator->valid()) {
                $result = [];
                if (isset($iterator->current()[$model->alias]) && count($iterator->current()[$model->alias]) > 0) {
                    $key = "{$model->alias}.{$this->settings[$model->alias]['key']}";
                    $value = "{$model->alias}.{$this->settings[$model->alias]['value']}";

                    $result = Hash::combine($iterator->current(), $key, $value);
                }

                if (!array_key_exists(
                        $this->settings[$model->alias]['key'],
                        $iterator->current()[$model->alias]
                    ) && !array_key_exists($this->settings[$model->alias]['value'], $iterator->current()[$model->alias])
                ) {
                    $results[$iterator->key()][$model->alias] = Hash::merge(
                        $iterator->current()[$model->alias],
                        $result
                    );
                } else {
                    $results[$iterator->key()][$model->alias] = $result;
                }

                $iterator->next();
            }
        } elseif (array_key_exists($model->alias, $results)) {
            $key = "{n}.{$model->alias}.{$this->settings[$model->alias]['key']}";
            $value = "{n}.{$model->alias}.{$this->settings[$model->alias]['value']}";

            $output = Hash::combine($results, $key, $value);
            $results[$model->alias] = $output;
        }

        return $results;
    }

    /**
     * Save data
     *
     * @param Model $model
     * @param array $data
     *
     * @throws CakeException
     * @return bool
     */
    public function saveData(Model $model, array $data)
    {
        if (!array_key_exists($model->alias, $data)) {
            return true;
        }

        $model->set($data);
        $keys = array_keys($data[$model->alias]);

        if (in_array($this->settings[$model->alias]['key'], $keys) && in_array(
                $this->settings[$model->alias]['value'],
                $keys
            )
        ) {
            return true;
        }

        if (isset($data[$model->alias]) && !empty($data[$model->alias])) {
            $dataTemplate = array($model->alias => array());

            if (isset($model->{$this->settings[$model->alias]['foreign_key']})) {
                $dataTemplate[$model->alias][$this->settings[$model->alias]['foreign_key']] = $model->{$this->settings[$model->alias]['foreign_key']};
            } elseif (array_key_exists($this->settings[$model->alias]['foreign_key'], $data[$model->alias])) {
                $dataTemplate[$model->alias][$this->settings[$model->alias]['foreign_key']] = $data[$model->alias][$this->settings[$model->alias]['foreign_key']];
            } elseif ($this->settings[$model->alias]['foreign_key'] != false) {
                throw new CakeException(__d(
                    'hurad',
                    'You should set foreign_key "%s"',
                    $this->settings[$model->alias]['foreign_key']
                ));
            }

            $list = $model->find(
                'list',
                [
                    'fields' => ["{$model->alias}.{$this->settings[$model->alias]['key']}", "{$model->alias}.id"],
                    'conditions' => ["{$model->alias}.{$this->settings[$model->alias]['foreign_key']}" => $model->{$this->settings[$model->alias]['foreign_key']}]
                ]
            );

            $arrObj = new ArrayObject($data[$model->alias]);
            $iterator = $arrObj->getIterator();

            while ($iterator->valid()) {
                $insert = $dataTemplate;

                $insert[$model->alias][$this->settings[$model->alias]['key']] = $iterator->key();
                $insert[$model->alias][$this->settings[$model->alias]['value']] = $iterator->current();

                if (array_key_exists($insert[$model->alias][$this->settings[$model->alias]['key']], $list)) {
                    $insert[$model->alias]['id'] = $list[$insert[$model->alias][$this->settings[$model->alias]['key']]];
                }

                $model->create();

                if (false === $model->save($insert)) {
                    return false;
                }

                $iterator->next();
            }
        }

        return true;
    }

    public function getData(Model $model, $foreignKey = null)
    {
        if (!$foreignKey) {
            $foreignKey = $model->{$this->settings[$model->alias]['foreign_key']};
        }

        $dataList[$model->alias] = $model->find(
            'list',
            [
                'fields' => [
                    "{$model->alias}.{$this->settings[$model->alias]['key']}",
                    "{$model->alias}.{$this->settings[$model->alias]['value']}"
                ],
                'conditions' => ["{$model->alias}.{$this->settings[$model->alias]['foreign_key']}" => $foreignKey],
                'callbacks' => false
            ]
        );

        if ($dataList[$model->alias]) {
            return $dataList;
        } else {
            return [];
        }
    }
}
