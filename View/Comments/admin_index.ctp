<?php $this->Html->script(array('admin/Comments/comments'), array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<section class="top-table">
    <div class="row">
        <div class="col-md-8"><?php echo $this->element(
                'admin/Comments/filter',
                array('count' => $count)
            ); ?></div>
        <div class="col-md-4"><?php echo $this->element('admin/Comments/search'); ?></div>
    </div>
</section>

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
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
    <?php
    if (count($comments) > 0) {
        foreach ($comments as $comment) {
            $this->Comment->setComment($comment);
            echo $this->Html->tableCells(
                array(
                    array(
                        array(
                            $this->Gravatar->image(
                                $this->Comment->getAuthorEmail(),
                                array('size' => '32', 'default' => 'mm', 'echo' => false)
                            ) . $this->Comment->getAuthor() . $this->element(
                                'admin/Comments/row_actions',
                                array('comment' => $comment)
                            ),
                            array(
                                'class' => 'column-author'
                            )
                        ),
                        array(
                            $this->Comment->getExcerpt(),
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
                    'class' => $this->AdminLayout->commentClass($comment['Comment']['status'])
                ),
                array(
                    'id' => 'comment-' . $comment['Comment']['id'],
                    'class' => $this->AdminLayout->commentClass($comment['Comment']['status'])
                )
            );
        }
    } else {
        echo $this->Html->tag(
            'tr',
            $this->Html->tag(
                'td',
                __d('hurad', 'No comments were found'),
                array('colspan' => '4', 'style' => 'text-align:center;')
            ),
            array('id' => 'comment-0')
        );
    }
    ?>
    </tbody>
    <tfoot>
    <?php
    echo $this->Html->tableHeaders(
        array(
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
            <!-- Bulk Actions -->
        </div>
        <div class="col-md-8"><?php echo $this->element('admin/paginator'); ?></div>
    </div>
</section>
