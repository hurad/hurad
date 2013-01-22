<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php echo $this->Html->script('checkbox', array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>

<div class="table-filter-search">
    <?php echo $this->element('admin/Comments/filter'); ?>
</div>

<?php
echo $this->Form->create('Comment', array('url' =>
    array('admin' => TRUE, 'controller' => 'comments', 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>

<table class="list-table">
    <thead>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="author" class="column-author column-manage" scope="col">
                <?php echo $this->Paginator->sort('author', __('Author')); ?>
            </th>
            <th id="content" class="column-content column-manage" scope="col">
                <?php echo $this->Paginator->sort('content', __('Content')); ?>
            </th>
            <th id="replyto" class="column-replyto column-manage" scope="col">
                <?php echo $this->Paginator->sort('Post.title', __('Reply to')); ?>             
            </th>
        </tr>
    </thead>
    <?php foreach ($comments as $comment): ?>
        <?php $this->Comment->setComment($comment['Comment']) ?>
        <tr id="<?php echo $this->Comment->comment_ID(); ?>" class="comment-<?php echo $this->Comment->comment_ID(); ?>">
            <td class="check-column" scope="row">
                <?php echo $this->Form->checkbox('Comment.' . $this->Comment->get_comment_ID() . '.id'); ?>
            </td>
            <td class="column-author">
                <?php echo $this->Gravatar->image($this->Comment->get_comment_author_email(), array('size' => '32', 'default' => 'mm')); ?>
                <?php $this->Comment->comment_author(); ?>
                <div class="row-actions">
                    <span class="action-approved">
                        <?php echo $this->AdminLayout->approveLink($comment['Comment']['approved'], $this->Comment->get_comment_ID()); ?> |
                    </span>
                    <span class="action-view">
                        <?php echo $this->Html->link(__('View'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'view', $this->Comment->get_comment_ID())); ?> | 
                    </span>
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'edit', $this->Comment->get_comment_ID())); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'delete', $this->Comment->get_comment_ID()), null, __('Are you sure you want to delete # %s?', $this->Comment->get_comment_ID())); ?>
                    </span>
                </div>
            </td>
            <td class="column-name">
                <?php $this->Comment->comment_excerpt(); ?>
            </td>
            <td class="column-replyto">
                <?php echo $this->Html->link($comment['Post']['title'], array('controller' => 'posts', 'action' => 'edit', $comment['Post']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="author" class="column-author column-manage" scope="col">
                <?php echo $this->Paginator->sort('author', __('Author')); ?>
            </th>
            <th id="content" class="column-content column-manage" scope="col">
                <?php echo $this->Paginator->sort('content', __('Content')); ?>
            </th>
            <th id="replyto" class="column-replyto column-manage" scope="col">
                <?php echo $this->Paginator->sort('Post.title', __('Reply to')); ?>             
            </th>
        </tr>
    </tfoot>
</table>
<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Comment.action', array(
            'label' => false,
            'options' => array(
                'approve' => __('Approve'),
                'disapprove' => __('Disapprove'),
                'delete' => __('Delete'),
            ),
            'empty' => __('Bulk Actions'),
        ));
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
    <div class="paging">
        <?php
        if ($this->Paginator->numbers()) {
            echo $this->Paginator->prev('« ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('Next') . ' »', array(), null, array('class' => 'next disabled'));
        }
        ?>
    </div>
    <div class="pageing_counter">
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total')
        ));
        ?>	
    </div>
</div>
