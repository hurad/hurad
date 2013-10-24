<?php $this->Html->css(array('admin/Posts/posts'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/Posts/posts', 'admin/checkbox'), array('block' => 'scriptHeader')); ?>

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

<?php
echo $this->Form->create(
    'Post',
    array(
        'url' => array(
            'admin' => true,
            'action' => 'process'
        ),
        'class' => 'form-inline',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

<table class="table table-striped">
<thead>
<?php
echo $this->Html->tableHeaders(
    array(
        array(
            $this->Form->checkbox('Post.tcheckbox', array('class' => 'check-all', 'hiddenField' => false)) =>
            array(
                'id' => 'cb',
                'class' => 'column-cb check-column column-manage',
                'scope' => 'col'
            )
        ),
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
        $this->Post->setPost($post);
        echo $this->Html->tableCells(
            array(
                array(
                    array(
                        $this->Form->checkbox('Post.' . $this->Post->getTheID() . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row'
                        )
                    ),
                    array(
                        $this->Html->link(
                            '<strong>' . h($this->Post->getTheTitle()) . '</strong>',
                            array(
                                'action' => 'edit',
                                $this->Post->getTheID()
                            ),
                            array(
                                'title' => __d('hurad', 'Edit “%s”', $this->Post->getTheTitle()),
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
                        $this->Post->the_category('', false),
                        array(
                            'class' => 'column-categories'
                        )
                    ),
                    array(
                        $this->Post->getTags(),
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
                            $this->Post->getTheDate(),
                            array('title' => $post['Post']['created'])
                        ) . '<br>' . $this->AdminLayout->postStatus($post['Post']['status']),
                        array(
                            'class' => 'column-date'
                        )
                    )
                ),
            ),
            array(
                'id' => 'post-' . $this->Post->getTheID()
            ),
            array(
                'id' => 'post-' . $this->Post->getTheID()
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
            $this->Form->checkbox('Post.bcheckbox', array('class' => 'check-all', 'hiddenField' => false)) =>
            array(
                'id' => 'cb',
                'class' => 'column-cb check-column column-manage',
                'scope' => 'col'
            )
        ),
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
</tfoot>
</table>

<section class="bottom-table">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input(
                    'Post.action',
                    array(
                        'label' => false,
                        'options' => array(
                            'publish' => __d('hurad', 'Publish'),
                            'draft' => __d('hurad', 'Draft'),
                            'delete' => __d('hurad', 'Delete'),
                            'trash' => __d('hurad', 'Move to Trash'),
                        ),
                        'empty' => __d('hurad', 'Bulk Actions'),
                        'class' => 'form-control'
                    )
                );
                ?>
            </div>
            <?php
            echo $this->Form->submit(
                __d('hurad', 'Apply'),
                array('type' => 'submit', 'class' => 'btn btn-info', 'div' => false)
            );
            ?>
        </div>
        <div class="col-md-8"><?php echo $this->element('admin/paginator'); ?></div>
    </div>
</section>

<?php echo $this->Form->end(null); ?>
