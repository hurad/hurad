<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(__('Add New'), '/admin/linkcats/add', array('class' => 'btn btn-mini')); ?>
    </h2>
</div>

<?php
echo $this->Form->create('Linkcat', array(
    'url' => array(
        'admin' => TRUE,
        'controller' => 'linkcats',
        'action' => 'process'
    ),
    'class' => 'form-inline',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<table class="table table-striped">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            array($this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('name', __('Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('slug', __('Slug')) => array(
                    'id' => 'slug',
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('description', __('Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('link_count', __('Links')) => array(
                    'id' => 'posts',
                    'class' => 'column-link_count column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </thead>
    <tbody>
        <?php foreach ($linkcats as $linkcat): ?>
            <?php
            echo $this->Html->tableCells(array(
                array(
                    array($this->Form->checkbox('Category.' . $linkcat['Linkcat']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row')
                    ),
                    array($this->Html->link(h($linkcat['Linkcat']['name']), array('admin' => TRUE, 'controller' => 'linkcats', 'action' => 'edit', $linkcat['Linkcat']['id'])) . $this->element('admin/Linkcats/row_actions', array('linkcat' => $linkcat)),
                        array(
                            'class' => 'column-path'
                        )
                    ),
                    array(h($linkcat['Linkcat']['slug']),
                        array(
                            'class' => 'column-slug'
                        )
                    ),
                    array(h($linkcat['Linkcat']['description']),
                        array(
                            'class' => 'column-description'
                        )
                    ),
                    array(h($linkcat['Linkcat']['link_count']),
                        array(
                            'class' => 'column-link_count'
                        )
                    )
                ),
                    ), array(
                'id' => 'linkcat-' . $linkcat['Linkcat']['id']
                    ), array(
                'id' => 'linkcat-' . $linkcat['Linkcat']['id']
                    )
            );
            ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <?php
        echo $this->Html->tableHeaders(array(
            array($this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('name', __('Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('slug', __('Slug')) => array(
                    'id' => 'slug',
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('description', __('Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('link_count', __('Links')) => array(
                    'id' => 'posts',
                    'class' => 'column-link_count column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </tfoot>
</table>

<section>
    <?php
    echo $this->Form->input('Linkcat.action', array(
        'label' => false,
        'options' => array(
            'delete' => __('Delete'),
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->button(__('Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>