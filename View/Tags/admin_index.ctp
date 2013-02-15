<?php $this->Html->css(array('admin/list-table', 'admin/paging', 'admin/Tags/tags'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<h2>
    <?php echo $title_for_layout; ?>
    <?php echo $this->Html->link(__('Add New'), '/admin/tags/add', array('class' => 'add_button')); ?>
</h2>

<?php
echo $this->Form->create('Tag', array('url' =>
    array('admin' => TRUE, 'controller' => 'tags', 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>

<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Tag.action.top', array(
            'label' => false,
            'options' => array(
                'delete' => __('Delete'),
            ),
            'empty' => __('Bulk Actions'),
        ));
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
    <?php echo $this->element('admin/paginator'); ?>
</div>

<table class="list-table">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            array($this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)) =>
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
            array($this->Paginator->sort('description', __('Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('slug', __('Slug')) => array(
                    'id' => 'slug',
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('post_count', __('Posts')) => array(
                    'id' => 'posts',
                    'class' => 'column-posts column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </thead>
    <?php foreach ($tags AS $tag): ?>
        <?php
        echo $this->Html->tableCells(array(
            array(
                array($this->Form->checkbox('Tag.' . $tag['Tag']['id'] . '.id'),
                    array(
                        'class' => 'check-column',
                        'scope' => 'row')
                ),
                array($this->Html->link('<strong>' . h($tag['Tag']['name']) . '</strong>', array('action' => 'edit', $tag['Tag']['id']), array('title' => __('Edit “%s”', $tag['Tag']['name']), 'escape' => FALSE)) . $this->element('admin/Tags/row_actions', array('tag' => $tag)),
                    array(
                        'class' => 'column-name'
                    )
                ),
                array(h($tag['Tag']['description']),
                    array(
                        'class' => 'column-description'
                    )
                ),
                array(h($tag['Tag']['slug']),
                    array(
                        'class' => 'column-slug'
                    )
                ),
                array($this->Html->link($tag['Tag']['post_count'], array('admin' => TRUE, 'controller' => 'posts', 'action' => 'listBytag', $tag['Tag']['id'])),
                    array(
                        'class' => 'column-posts'
                    )
                )
            ),
                ), array(
            'id' => 'tag-' . $tag['Tag']['id']
                ), array(
            'id' => 'tag-' . $tag['Tag']['id'],
            'class' => 'alternate'
                )
        );
        ?>
    <?php endforeach; ?>
    <tfoot>
        <?php
        echo $this->Html->tableHeaders(array(
            array($this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)) =>
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
            array($this->Paginator->sort('description', __('Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('slug', __('Slug')) => array(
                    'id' => 'slug',
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('post_count', __('Posts')) => array(
                    'id' => 'posts',
                    'class' => 'column-posts column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </tfoot>
</table>

<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Tag.action.bot', array(
            'label' => false,
            'options' => array(
                'delete' => __('Delete'),
            ),
            'empty' => __('Bulk Actions'),
        ));
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
    <?php echo $this->element('admin/paginator'); ?>
</div>