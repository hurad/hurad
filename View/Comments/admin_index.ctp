<?php //$this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE));           ?>
<?php $this->Html->script(array('admin/checkbox', 'admin/Comments/comments'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<section class="top-table">
    <div class="row-fluid">
        <div class="span6"><?php echo $this->element('admin/Comments/filter', array('countComments' => $countComments)); ?></div>
        <div class="span6"><?php echo $this->element('admin/Comments/search'); ?></div>
    </div>
</section>

<?php
echo $this->Form->create('Comment', array(
    'url' => array(
        'admin' => true,
        'controller' => 'comments',
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
            array($this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                array(
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('author', __('Author')) => array(
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('content', __('Content')) => array(
                    'class' => 'column-content column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('Post.title', __('Reply to')) => array(
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </thead>
    <tbody>
        <?php foreach ($comments as $comment): ?>
            <?php $this->Comment->setComment($comment['Comment']) ?>
            <?php
            echo $this->Html->tableCells(array(
                array(
                    array($this->Form->checkbox('Comment.' . $comment['Comment']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row')
                    ),
                    array($this->Gravatar->image($this->Comment->getCommentAuthorEmail(), array('size' => '32', 'default' => 'mm', 'echo' => false)) . $this->Comment->getCommentAuthor() . $this->element('admin/Comments/row_actions', array('comment' => $comment)),
                        array(
                            'class' => 'column-author'
                        )
                    ),
                    array($this->Comment->getCommentExcerpt(),
                        array(
                            'class' => 'column-content'
                        )
                    ),
                    array($this->Html->link($comment['Post']['title'], array('controller' => 'posts', 'action' => 'edit', $comment['Post']['id'])),
                        array(
                            'class' => 'column-replyto'
                        )
                    )
                ),
                    ), array(
                'id' => 'comment-' . $comment['Comment']['id'],
                'class' => $this->AdminLayout->commentClass($comment['Comment']['approved'])
                    ), array(
                'id' => 'comment-' . $comment['Comment']['id'],
                'class' => $this->AdminLayout->commentClass($comment['Comment']['approved'])
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
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('author', __('Author')) => array(
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('content', __('Content')) => array(
                    'class' => 'column-content column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('Post.title', __('Reply to')) => array(
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </tfoot>
</table>

<section>
    <?php
    echo $this->Form->input('Comment.action', array(
        'label' => false,
        'options' => array(
            'approve' => __('Approve'),
            'disapprove' => __('Disapprove'),
            'delete' => __('Delete'),
            'spam' => __('Spam'),
            'trash' => __('Move to trash'),
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->button(__('Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>