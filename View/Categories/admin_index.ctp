<?php $this->Html->css(array('admin/Categories/categories'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(__('Add New'), '/admin/categories/add', array('class' => 'btn btn-mini')); ?>
    </h2>
</div>

<?php
echo $this->Form->create('Category', array('url' =>
    array('admin' => TRUE, 'action' => 'process'),
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
        <?php foreach ($categories AS $i => $category): ?>
            <?php
            echo $this->Html->tableCells(array(
                array(
                    array($this->Form->checkbox('Category.' . $category['Category']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row')
                    ),
                    array($this->Html->link('<strong>' . h($category['Category']['path']) . '</strong>', array('action' => 'edit', $category['Category']['id']), array('title' => __('Edit “%s”', $category['Category']['path']), 'escape' => FALSE)) . $this->element('admin/Categories/row_actions', array('category' => $category)),
                        array(
                            'class' => 'column-path'
                        )
                    ),
                    array(h($category['Category']['description']),
                        array(
                            'class' => 'column-description'
                        )
                    ),
                    array(h($category['Category']['slug']),
                        array(
                            'class' => 'column-slug'
                        )
                    ),
                    array($this->Html->link($category['Category']['post_count'], array('admin' => TRUE, 'controller' => 'posts', 'action' => 'listBycategory', $category['Category']['id'])),
                        array(
                            'class' => 'column-posts'
                        )
                    )
                ),
                    ), array(
                'id' => 'category-' . $category['Category']['id']
                    ), array(
                'id' => 'category-' . $category['Category']['id']
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
    echo $this->Form->input('Category.action.bot', array(
        'label' => false,
        'options' => array(
            'delete' => __('Delete'),
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->button(__('Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>

<div class="form-wrap">
    <p>
        <strong><?php echo __('Note:'); ?></strong>
        <br>
        <?php echo __('Deleting a category does not delete the posts in that category. Instead, posts that were only assigned to the deleted category are set to the category <strong>Uncategorized</strong>.'); ?>
    </p>
</div>