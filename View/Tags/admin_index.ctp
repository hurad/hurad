<?php $this->Html->css(array('admin/Tags/tags'), null, array('inline' => false)); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(
            __d('hurad', 'Add New'),
            '/admin/tags/add',
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
    <?php foreach ($tags AS $tag): ?>
        <?php
        echo $this->Html->tableCells(
            array(
                array(
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
