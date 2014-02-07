<?php

$query = '';
if (isset($this->params['named']['q'])) {
    $query = $this->params['named']['q'];
}

echo $this->Form->create(
    'Page',
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
    'Page.q',
    array('value' => $query, 'class' => 'form-control')
);
echo $this->Html->tag('span', null, array('class' => 'input-group-btn'));
echo $this->Form->button(
    __d('hurad', 'Search'),
    array('type' => 'submit', 'class' => 'btn btn-primary', 'div' => false)
);
echo '</span>';
echo '</div>';
echo '</div>';
echo $this->Form->end();