<div class="row-actions">
    <span class="action-view">
        <?php echo $this->Html->link(__('View'), $this->Post->get_permalink(), array('title' => __('View “%s”', $post['Post']['title']), 'rel' => 'permalink')); ?> | 
    </span>
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'posts', 'action' => 'edit', $post['Post']['id']), array('title' => __('Edit this item'))); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', $post['Post']['id']), array('title' => __('Delete this item')), __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
    </span>
</div>