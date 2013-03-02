<?php $this->Html->css(array('admin/Tags/tags'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(__('Add New'), '/admin/tags/add', array('class' => 'btn btn-mini')); ?>
    </h2>
</div>

<?php
echo $this->Form->create('Tag', array('url' =>
    array('admin' => TRUE, 'controller' => 'tags', 'action' => 'process'),
    'class' => 'form-inline',
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
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
    <tbody>
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
                    array($this->Html->link($this->Html->tag('span', $tag['Tag']['post_count'], array('class' => 'badge')), array('admin' => TRUE, 'controller' => 'posts', 'action' => 'listBytag', $tag['Tag']['id']), array('escape' => FALSE)),
                        array(
                            'class' => 'column-posts'
                        )
                    )
                ),
                    ), array(
                'id' => 'tag-' . $tag['Tag']['id']
                    ), array(
                'id' => 'tag-' . $tag['Tag']['id']
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

<section>
    <?php
    echo $this->Form->input('Tag.action.bot', array(
        'label' => false,
        'options' => array(
            'delete' => __('Delete'),
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->button(__('Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>