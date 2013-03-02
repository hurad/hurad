<?php $this->Html->css(array('admin/Posts/posts'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/Posts/posts', 'admin/checkbox'), array('block' => 'headerScript')); ?>

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
echo $this->Form->create('Post', array('url' =>
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
        <?php foreach ($posts as $post): ?>
            <?php $this->Post->setPost($post); ?>
            <?php
            echo $this->Html->tableCells(array(
                array(
                    array($this->Form->checkbox('Post.' . $post['Post']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row')
                    ),
                    array($this->Html->link('<strong>' . h($post['Post']['title']) . '</strong>', array('action' => 'edit', $post['Post']['id']), array('title' => __('Edit “%s”', $post['Post']['title']), 'escape' => FALSE)) . $this->element('admin/Posts/row_actions', array('post' => $post)),
                        array(
                            'class' => 'column-title'
                        )
                    ),
                    array($this->Html->link($post['User']['username'], array('controller' => 'posts', 'action' => 'listByauthor', $post['User']['id'])),
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
                    array($this->Html->tag('abbr', $this->Post->get_the_date(), array('title' => $post['Post']['created'])) . '<br>' . $this->AdminLayout->postStatus($post['Post']['status']),
                        array(
                            'class' => 'column-date'
                        )
                    )
                ),
                    ), array(
                'id' => 'post-' . $post['Post']['id']
                    ), array(
                'id' => 'post-' . $post['Post']['id']
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
    echo $this->Form->input('Post.action.bot', array(
        'label' => false,
        'options' => array(
            'publish' => __('Publish'),
            'draft' => __('Draft'),
            'delete' => __('Delete'),
            'trash' => __('Move to Trash'),
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->button(__('Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>

