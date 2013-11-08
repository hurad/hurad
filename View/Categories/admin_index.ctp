<?php $this->Html->css(array('admin/Categories/categories'), null, array('inline' => false)); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(
            __d('hurad', 'Add New'),
            '/admin/categories/add',
            array('class' => 'btn btn-default btn-xs')
        ); ?>
    </h2>
</div>

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
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
    <?php foreach ($categories AS $i => $category): ?>
        <?php
        echo $this->Html->tableCells(
            array(
                array(
                    array(
                        $this->Html->link(
                            '<strong>' . h($category['Category']['path']) . '</strong>',
                            array(
                                'action' => 'edit',
                                $category['Category']['id']
                            ),
                            array(
                                'title' => __d('hurad', 'Edit “%s”', $category['Category']['path']),
                                'escape' => false
                            )
                        ) . $this->element('admin/Categories/row_actions', array('category' => $category)),
                        array(
                            'class' => 'column-path'
                        )
                    ),
                    array(
                        h($category['Category']['description']),
                        array(
                            'class' => 'column-description'
                        )
                    ),
                    array(
                        h($category['Category']['slug']),
                        array(
                            'class' => 'column-slug'
                        )
                    ),
                    array(
                        $this->Html->link(
                            $category['Category']['post_count'],
                            array(
                                'admin' => true,
                                'controller' => 'posts',
                                'action' => 'listBycategory',
                                $category['Category']['id']
                            )
                        ),
                        array(
                            'class' => 'column-posts'
                        )
                    )
                ),
            ),
            array(
                'id' => 'category-' . $category['Category']['id']
            ),
            array(
                'id' => 'category-' . $category['Category']['id']
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
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('description', __d('hurad', 'Description')) => array(
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('slug', __d('hurad', 'Slug')) => array(
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('post_count', __d('hurad', 'Posts')) => array(
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
    <div class="row">
        <div class="col-md-4">
            <!-- Bulk Actions -->
        </div>
        <div class="col-md-8"><?php echo $this->element('admin/paginator'); ?></div>
    </div>
</section>

<div class="form-wrap">
    <p>
        <strong><?php echo __d('hurad', 'Note:'); ?></strong>
        <br>
        <?php echo __(
            'Deleting a category does not delete the posts in that category. Instead, posts that were only assigned to the deleted category are set to the category <strong>Uncategorized</strong>.'
        ); ?>
    </p>
</div>