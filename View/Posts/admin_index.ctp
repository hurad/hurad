<?php $this->Html->css(array('admin/Posts/posts'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/Posts/posts'), array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(
            __d('hurad', 'Add New'),
            '/admin/posts/add',
            array('class' => 'btn btn-default btn-xs')
        ); ?>
    </h2>
</div>

<section class="top-table">
    <div class="row">
        <div class="col-md-8"><?php echo $this->element('admin/Posts/filter'); ?></div>
        <div class="col-md-4"><?php echo $this->element('admin/Posts/search'); ?></div>
    </div>
</section>

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Paginator->sort('title', __d('hurad', 'Title')) => array(
                    'id' => 'title',
                    'class' => 'column-title column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('User.username', __d('hurad', 'Author')) => array(
                    'id' => 'author',
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Category.name', __d('hurad', 'Categories')) => array(
                    'id' => 'categories',
                    'class' => 'column-categories column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Tag.name', __d('hurad', 'Tags')) => array(
                    'id' => 'tags',
                    'class' => 'column-tags column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('comment_count', __d('hurad', 'Comments')) => array(
                    'id' => 'comments',
                    'class' => 'column-comments column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('created', __d('hurad', 'Date')) => array(
                    'id' => 'date',
                    'class' => 'column-date column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </thead>
    <tbody>
    <?php
    if (count($posts) > 0) {
        foreach ($posts as $post) {
            $this->Content->setContent($post, 'post');
            echo $this->Html->tableCells(
                array(
                    array(
                        array(
                            $this->Html->link(
                                '<strong>' . h($this->Content->getTitle()) . '</strong>',
                                array(
                                    'action' => 'edit',
                                    $this->Content->getId()
                                ),
                                array(
                                    'title' => __d('hurad', 'Edit “%s”', $this->Content->getTitle()),
                                    'escape' => false
                                )
                            ) . $this->element('admin/Posts/row_actions', array('post' => $post)),
                            array(
                                'class' => 'column-title'
                            )
                        ),
                        array(
                            $this->Html->link(
                                $post['User']['username'],
                                array('controller' => 'posts', 'action' => 'listByAuthor', $post['Post']['user_id'])
                            ),
                            array(
                                'class' => 'column-author'
                            )
                        ),
                        array(
                            $this->Content->getCategories('', false),
                            array(
                                'class' => 'column-categories'
                            )
                        ),
                        array(
                            $this->Content->getTags(),
                            array(
                                'class' => 'column-tags'
                            )
                        ),
                        array(
                            $this->Html->tag('span', $post['Post']['comment_count'], array('class' => 'badge')),
                            array(
                                'class' => 'column-comments'
                            )
                        ),
                        array(
                            $this->Html->tag(
                                'abbr',
                                $this->Content->getDate(),
                                array('title' => $post['Post']['created'])
                            ) . '<br>' . $this->AdminLayout->postStatus($post['Post']['status']),
                            array(
                                'class' => 'column-date'
                            )
                        )
                    ),
                ),
                array(
                    'id' => 'post-' . $this->Content->getId()
                ),
                array(
                    'id' => 'post-' . $this->Content->getId()
                )
            );
        }
    } else {
        echo $this->Html->tag(
            'tr',
            $this->Html->tag(
                'td',
                __d('hurad', 'No posts were found'),
                array('colspan' => '7', 'style' => 'text-align:center;')
            ),
            array('id' => 'post-0')
        );
    }
    ?>
    </tbody>
    <tfoot>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Paginator->sort('title', __d('hurad', 'Title')) => array(
                    'class' => 'column-title column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('User.username', __d('hurad', 'Author')) => array(
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Category.name', __d('hurad', 'Categories')) => array(
                    'class' => 'column-categories column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Tag.name', __d('hurad', 'Tags')) => array(
                    'class' => 'column-tags column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('comment_count', __d('hurad', 'Comments')) => array(
                    'class' => 'column-comments column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('created', __d('hurad', 'Date')) => array(
                    'class' => 'column-date column-manage',
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
