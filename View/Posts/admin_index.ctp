<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>

<h2><?php echo $title_for_layout; ?></h2>

<?php
echo $this->Form->create('Post', array('url' =>
    array('admin' => TRUE, 'controller' => 'posts', 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>

<table class="list-table">
    <thead>
        <tr>
            <th id="cb" class="column-cb column-manage" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="title" class="column-title column-manage" scope="col">
                <?php echo $this->Paginator->sort('title'); ?>
            </th>
            <th id="author" class="column-author column-manage" scope="col">
                <?php echo $this->Paginator->sort('User.username', 'Author'); ?>
            </th>
            <th id="status" class="column-status column-manage" scope="col">
                <?php echo $this->Paginator->sort('status'); ?>
            </th>
            <th id="comment_count" class="column-comment_count column-manage" scope="col">
                <?php echo $this->Paginator->sort('comment_count'); ?>
            </th>
            <th id="date" class="column-date column-manage" scope="col">
                <?php echo $this->Paginator->sort('created'); ?>
            </th>
        </tr>
    </thead>
    <?php foreach ($posts as $post): ?>
        <tr id="<?php echo h($post['Post']['id']); ?>" class="post-<?php echo h($post['Post']['id']); ?>">
            <td class="check-column" scope="row">
                <?php echo $this->Form->checkbox('Post.' . $post['Post']['id'] . '.id'); ?>
            </td>
            <td class="column-title">
                <?php echo $this->Html->link(h($post['Post']['title']), array('action' => 'edit', $post['Post']['id'])); ?>&nbsp;
                <div class="row-actions">
                    <span class="action-view">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?> | 
                    </span>
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'posts', 'action' => 'edit', $post['Post']['id'])); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
                    </span>
                </div>
            </td>
            <td class="column-author">
                <?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?>
            </td>
            <td class="column-status">
                <?php echo $this->AdminLayout->postStatus($post['Post']['status']); ?>&nbsp;
            </td>
            <td class="column-comment_count">
                <?php echo h($post['Post']['comment_count']); ?>&nbsp;
            </td>
            <td class="column-date">
                <?php echo h($post['Post']['created']); ?>&nbsp;
            </td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="title" class="column-title column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('title'); ?>
            </th>
            <th id="author" class="column-author column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('User.username', 'Author'); ?>
            </th>
            <th id="status" class="column-status column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('status'); ?>
            </th>
            <th id="comment_count" class="column-comment_count column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('comment_count'); ?>
            </th>
            <th id="date" class="column-date column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('created'); ?>
            </th>
        </tr>
    </tfoot>
</table>
<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Post.action', array(
            'label' => false,
            'options' => array(
                'publish' => __('Publish'),
                'draft' => __('Draft'),
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

