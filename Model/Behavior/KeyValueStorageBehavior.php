<?php
/**
 * Class KeyValueStorageBehavior
 */
class KeyValueStorageBehavior extends ModelBehavior
{
    /**
     * Settings
     *
     * @var array
     */
    public $settings = [];

    /**
     * Default settings
     *
     * @var array
     */
    protected $defaults = [
        'key' => '__meta_key__',
        'value' => '__meta_value__',
        'foreign_key' => '__user_id__'
    ];

    /**
     * Initiate behavior for the model using specified settings.
     *
     * @param Model $model
     * @param array $settings
     *
     * @return void
     */
    public function setup(Model $model, $settings = [])
    {
        $this->settings[$model->alias] = Hash::merge($this->defaults, $settings);
    }

    /**
     * Before save method. Called before all saves
     *
     * @param Model $model
     * @param $data
     *
     * @return bool
     */
    public function saveData(Model $model, $data)
    {
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
            }

            $list = $model->find(
                'list',
                [
                    'fields' => ["{$model->alias}.{$this->settings[$model->alias]['key']}", "{$model->alias}.id"],
                    'conditions' => ["{$model->alias}.{$this->settings[$model->alias]['foreign_key']}" => $model->{$this->settings[$model->alias]['foreign_key']}]
                ]
            );

            $index = 0;

            $arrObj = new ArrayObject($data[$model->alias]);
            $iterator = $arrObj->getIterator();

            while ($iterator->valid()) {
                $index++;
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

    public function getData(Model $model)
    {
        $dataList = $model->find(
            'list',
            [
                'fields' => [
                    "{$model->alias}.{$this->settings[$model->alias]['key']}",
                    "{$model->alias}.{$this->settings[$model->alias]['value']}"
                ],
                'conditions' => ["{$model->alias}.{$this->settings[$model->alias]['foreign_key']}" => $model->{$this->settings[$model->alias]['foreign_key']}]
            ]
        );

        return $dataList;
    }
}
