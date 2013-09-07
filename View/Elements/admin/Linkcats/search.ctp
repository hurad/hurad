<?php

$query = '';
if (isset($this->params['named']['q'])) {
    $query = $this->params['named']['q'];
}

echo $this->Form->create(
    'Linkcat',
    array(
        'url' => array('admin' => true, 'action' => 'index'),
        'class' => 'form-inline',
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
        ),
        'id' => 'AdminSearchForm'
    )
);
echo $this->Html->div('form-group pull-right');
echo $this->Html->div('input-group');
echo $this->Form->input(
    'Linkcat.q',
    array('value' => $query, 'class' => 'form-control', 'placeholder' => __d('hurad', 'Link category name'))
);
echo $this->Html->tag('span', null, array('class' => 'input-group-btn'));
echo $this->Form->button(
    __d('hurad', 'Search'),
    array('type' => 'button', 'class' => 'btn btn-primary', 'div' => false)
);
echo '</span>';
echo '</div>';
echo '</div>';
echo $this->Form->end();