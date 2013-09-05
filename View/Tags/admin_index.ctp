<?php $this->Html->css(array('admin/Tags/tags'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(__d('hurad', 'Add New'), '/admin/tags/add', array('class' => 'btn btn-mini')); ?>
    </h2>
</div>

<?php
echo $this->Form->create(
    'Tag',
    array(
        'url' =>
        array('admin' => true, 'controller' => 'tags', 'action' => 'process'),
        'class' => 'form-inline',
        'inputDefaults' =>
        array('label' => false, 'div' => false)
    )
);
?>

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('description', __d('hurad', 'Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('slug', __d('hurad', 'Slug')) => array(
                    'id' => 'slug',
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('post_count', __d('hurad', 'Posts')) => array(
                    'id' => 'posts',
                    'class' => 'column-posts column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </thead>
    <tbody>
    <?php foreach ($tags AS $tag): ?>
        <?php
        echo $this->Html->tableCells(
            array(
                array(
                    array(
                        $this->Form->checkbox('Tag.' . $tag['Tag']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row'
                        )
                    ),
                    array(
                        $this->Html->link(
                            '<strong>' . h($tag['Tag']['name']) . '</strong>',
                            array('action' => 'edit', $tag['Tag']['id']),
                            array('title' => __d('hurad', 'Edit “%s”', $tag['Tag']['name']), 'escape' => false)
                        ) . $this->element('admin/Tags/row_actions', array('tag' => $tag)),
                        array(
                            'class' => 'column-name'
                        )
                    ),
                    array(
                        h($tag['Tag']['description']),
                        array(
                            'class' => 'column-description'
                        )
                    ),
                    array(
                        h($tag['Tag']['slug']),
                        array(
                            'class' => 'column-slug'
                        )
                    ),
                    array(
                        $this->Html->link(
                            $this->Html->tag('span', $tag['Tag']['post_count'], array('class' => 'badge')),
                            array('admin' => true, 'controller' => 'posts', 'action' => 'listBytag', $tag['Tag']['id']),
                            array('escape' => false)
                        ),
                        array(
                            'class' => 'column-posts'
                        )
                    )
                ),
            ),
            array(
                'id' => 'tag-' . $tag['Tag']['id']
            ),
            array(
                'id' => 'tag-' . $tag['Tag']['id']
            )
        );
        ?>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('description', __d('hurad', 'Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('slug', __d('hurad', 'Slug')) => array(
                    'id' => 'slug',
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('post_count', __d('hurad', 'Posts')) => array(
                    'id' => 'posts',
                    'class' => 'column-posts column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </tfoot>
</table>

<section class="bottom-table">
    <?php
    echo $this->Form->input(
        'Tag.action.bot',
        array(
            'label' => false,
            'options' => array(
                'delete' => __d('hurad', 'Delete'),
            ),
            'empty' => __d('hurad', 'Bulk Actions'),
        )
    );
    echo $this->Form->button(__d('hurad', 'Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => false));
    ?>

    <div class="pagination pull-right">
        <ul>
            <?php
            if ($this->Paginator->numbers()) {
                echo $this->Paginator->prev(
                    '« ' . __d('hurad', 'Previous'),
                    array('tag' => 'li'),
                    null,
                    array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')
                );
                echo $this->Paginator->numbers(
                    array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a')
                );
                echo $this->Paginator->next(
                    __d('hurad', 'Next') . ' »',
                    array('tag' => 'li'),
                    null,
                    array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'disabled')
                );
            }
            ?>
        </ul>
    </div>
</section>