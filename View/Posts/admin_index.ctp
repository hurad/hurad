<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/Posts/posts', 'admin/checkbox'), array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>

<div class="table-filter-search">
    <?php echo $this->element('admin/Posts/filter'); ?>
    <?php echo $this->element('admin/Posts/search'); ?>
</div>

<?php
echo $this->Form->create('Post', array('url' =>
    array('admin' => TRUE, 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>

<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Post.action.top', array(
            'label' => false,
            'options' => array(
                'publish' => __('Publish'),
                'draft' => __('Draft'),
                'delete' => __('Delete'),
                'trash' => __('Move to Trash'),
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
                    'class' => 'column-cb column-manage',
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
                    'id' => 'comment_count',
                    'class' => 'column-comment_count column-manage',
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
                array($this->Html->link(h($post['Post']['title']), array('action' => 'edit', $post['Post']['id']), array('title' => __('Edit “%s”', $post['Post']['title']))) . $this->element('admin/Posts/row_actions', array('post' => $post)),
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
                array($post['Post']['comment_count'],
                    array(
                        'class' => 'column-comment_count'
                    )
                ),
                array($this->Html->tag('abbr', $post['Post']['created'], array('title' => $post['Post']['created'])) . '<br>' . $this->AdminLayout->postStatus($post['Post']['status']),
                    array(
                        'class' => 'column-comment_count'
                    )
                )
            ),
                ), array(
            'id' => 'post-' . $post['Post']['id'],
            'class' => 'alternate'
                ), array(
            'id' => 'post-' . $post['Post']['id']
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
                    'class' => 'column-cb column-manage',
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
                    'id' => 'comment_count',
                    'class' => 'column-comment_count column-manage',
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

<div class="tablenav">
    <div class="actions">
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
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
    <?php echo $this->element('admin/paginator'); ?>
</div>

