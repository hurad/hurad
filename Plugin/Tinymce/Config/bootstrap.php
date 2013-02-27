<?php

Configure::write('Tinymce.actions', array(
    'Posts/admin_add' => array(
        array(
            'elements' => 'NodeBody',
        ),
    ),
    'Posts/admin_edit' => array(
        array(
            'elements' => 'NodeBody',
        ),
    )
));

/**
 * Hook helper
 */
foreach (Configure::read('Tinymce.actions') as $action => $settings) {
    $actionE = explode('/', $action);
    Hurad::hookHelper($actionE['0'], 'Tinymce.Tinymce');
}