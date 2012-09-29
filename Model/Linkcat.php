<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 * @property Link $Link
 */
class Linkcat extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        
        public $useTable = 'menus';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Link' => array(
			'className' => 'Link',
			'foreignKey' => 'menu_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
