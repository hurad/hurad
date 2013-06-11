<?php $this->Html->css(array('admin/Posts/posts'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/Posts/posts', 'admin/checkbox'), array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(__('Add New'), '/admin/posts/add', array('class' => 'btn btn-mini')); ?>
    </h2>
</div>

<section class="top-table">
    <?php echo $this->element('admin/Posts/filter'); ?>
    <?php echo $this->element('admin/Posts/search'); ?>
</section>

<?php
echo $this->Form->create('Post', array(
    'url' => array(
        'admin' => TRUE,
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
            array($this->Form->checkbox('Post.tcheckbox', array('class' => 'check-all', 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('title', __('Title')) => array(
                    'id' => 'title',
                    'class' => 'column-title column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('User.username', __('Author')) => array(
                    'id' => 'author',
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('Category.name', __('Categories')) => array(
                    'id' => 'categories',
                    'class' => 'column-categories column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('Tag.name', __('Tags')) => array(
                    'id' => 'tags',
                    'class' => 'column-tags column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('comment_count', __('Comments')) => array(
                    'id' => 'comments',
                    'class' => 'column-comments column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('created', __('Date')) => array(
                    'id' => 'date',
                    'class' => 'column-date column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </thead>
    <tbody>
        <?php
        if (count($posts) > 0) {
            foreach ($posts as $post) {
                $this->Post->setPost($post);
                echo $this->Html->tableCells(array(
                    array(
                        array($this->Form->checkbox('Post.' . $this->Post->getTheID() . '.id'),
                            array(
                                'class' => 'check-column',
                                'scope' => 'row')
                        ),
                        array($this->Html->link('<strong>' . h($this->Post->getTheTitle()) . '</strong>', array('action' => 'edit', $this->Post->getTheID()), array('title' => __('Edit “%s”', $this->Post->getTheTitle()), 'escape' => FALSE)) . $this->element('admin/Posts/row_actions', array('post' => $post)),
                            array(
                                'class' => 'column-title'
                            )
                        ),
                        array($this->Html->link($post['User']['username'], array('controller' => 'posts', 'action' => 'listByauthor', $this->Post->getTheID())),
                            array(
                                'class' => 'column-author'
                            )
                        ),
                        array($this->Post->the_category('', FALSE),
                            array(
                                'class' => 'column-categories'
                            )
                        ),
                        array($this->Post->tag('', FALSE),
                            array(
                                'class' => 'column-tags'
                            )
                        ),
                        array($this->Html->tag('span', $post['Post']['comment_count'], array('class' => 'badge')),
                            array(
                                'class' => 'column-comments'
                            )
                        ),
                        array($this->Html->tag('abbr', $this->Post->getTheDate(), array('title' => $post['Post']['created'])) . '<br>' . $this->AdminLayout->postStatus($post['Post']['status']),
                            array(
                                'class' => 'column-date'
                            )
                        )
                    ),
                        ), array(
                    'id' => 'post-' . $this->Post->getTheID()
                        ), array(
                    'id' => 'post-' . $this->Post->getTheID()
                        )
                );
            }
        } else {
            echo $this->Html->tag('tr', $this->Html->tag('td', __('No posts were found'), array('colspan' => '7', 'style' => 'text-align:center;')), array('id' => 'post-0'));
        }
        ?>
    </tbody>
    <tfoot>
        <?php
        echo $this->Html->tableHeaders(array(
            array($this->Form->checkbox('Post.bcheckbox', array('class' => 'check-all', 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('title', __('Title')) => array(
                    'id' => 'title',
                    'class' => 'column-title column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('User.username', __('Author')) => array(
                    'id' => 'author',
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('Category.name', __('Categories')) => array(
                    'id' => 'categories',
                    'class' => 'column-categories column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('Tag.name', __('Tags')) => array(
                    'id' => 'tags',
                    'class' => 'column-tags column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('comment_count', __('Comments')) => array(
                    'id' => 'comments',
                    'class' => 'column-comments column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('created', __('Date')) => array(
                    'id' => 'date',
                    'class' => 'column-date column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </tfoot>
</table>

<section>
    <?php
    echo $this->Form->input('Post.action', array(
        'label' => false,
        'options' => array(
            'publish' => __('Publish'),
            'draft' => __('Draft'),
            'delete' => __('Delete'),
            'trash' => __('Move to Trash'),
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->submit(__('Apply'), array('class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>

<?php echo $this->Form->end(null); ?>
