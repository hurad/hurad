<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('pages', 'admin/checkbox'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
    </h2>
</div>

<?php
echo $this->Form->create('Plugin', array(
    'url' => array(
        'admin' => TRUE,
        'controller' => 'plugins',
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
            array(__('Name') => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(__('Description') => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </thead>
    <tbody>
        <?php foreach ($plugins as $alias => $plugin): ?>
            <?php
            echo $this->Html->tableCells(array(
                array(
                    array($this->Form->checkbox('Plugin.' . $alias . '.alias'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row')
                    ),
                    array($plugin['name'] . $this->element('admin/Plugins/row_actions', array('alias' => $alias)),
                        array(
                            'class' => 'column-name'
                        )
                    ),
                    array($plugin['description'],
                        array(
                            'class' => 'column-description'
                        )
                    )
                ),
                    ), array(
                'id' => 'plugin-' . $alias
                    ), array(
                'id' => 'plugin-' . $alias
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
            array(__('Name') => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(__('Description') => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </tfoot>
</table>

<section>
    <?php
    echo $this->Form->input('Plugin.action', array(
        'label' => false,
        'options' => array(
            'activate' => __('Activate'),
            'deactivate' => __('Deactivate'),
            'delete' => __('Delete'),
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->button(__('Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>