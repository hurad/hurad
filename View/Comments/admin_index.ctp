<?php //$this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE));           ?>
<?php $this->Html->script(array('admin/checkbox', 'admin/Comments/comments'), array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<section class="top-table">
    <div class="row">
        <div class="col-md-8"><?php echo $this->element(
                'admin/Comments/filter',
                array('countComments' => $countComments)
            ); ?></div>
        <div class="col-md-4"><?php echo $this->element('admin/Comments/search'); ?></div>
    </div>
</section>

<?php
echo $this->Form->create(
    'Comment',
    array(
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
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('author', __d('hurad', 'Author')) => array(
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('content', __d('hurad', 'Content')) => array(
                    'class' => 'column-content column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Post.title', __d('hurad', 'Reply to')) => array(
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </thead>
    <tbody>
    <?php foreach ($comments as $comment): ?>
        <?php $this->Comment->setComment($comment['Comment']) ?>
        <?php
        echo $this->Html->tableCells(
            array(
                array(
                    array(
                        $this->Form->checkbox('Comment.' . $comment['Comment']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row'
                        )
                    ),
                    array(
                        $this->Gravatar->image(
                            $this->Comment->getCommentAuthorEmail(),
                            array('size' => '32', 'default' => 'mm', 'echo' => false)
                        ) . $this->Comment->getCommentAuthor() . $this->element(
                            'admin/Comments/row_actions',
                            array('comment' => $comment)
                        ),
                        array(
                            'class' => 'column-author'
                        )
                    ),
                    array(
                        $this->Comment->getCommentExcerpt(),
                        array(
                            'class' => 'column-content'
                        )
                    ),
                    array(
                        $this->Html->link(
                            $comment['Post']['title'],
                            array('controller' => 'posts', 'action' => 'edit', $comment['Post']['id'])
                        ),
                        array(
                            'class' => 'column-replyto'
                        )
                    )
                ),
            ),
            array(
                'id' => 'comment-' . $comment['Comment']['id'],
                'class' => $this->AdminLayout->commentClass($comment['Comment']['approved'])
            ),
            array(
                'id' => 'comment-' . $comment['Comment']['id'],
                'class' => $this->AdminLayout->commentClass($comment['Comment']['approved'])
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
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('author', __d('hurad', 'Author')) => array(
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('content', __d('hurad', 'Content')) => array(
                    'class' => 'column-content column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Post.title', __d('hurad', 'Reply to')) => array(
                    'class' => 'column-description column-manage',
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
                    'Comment.action',
                    array(
                        'label' => false,
                        'options' => array(
                            'approve' => __d('hurad', 'Approve'),
                            'disapprove' => __d('hurad', 'Disapprove'),
                            'delete' => __d('hurad', 'Delete'),
                            'spam' => __d('hurad', 'Spam'),
                            'trash' => __d('hurad', 'Move to trash'),
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