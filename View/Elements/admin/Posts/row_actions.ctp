<div class="row-actions">
    <span class="action-view">
        <?php echo $this->Html->link(__('View'), $this->Post->getPermalink(), array('title' => __('View “%s”', $this->Post->getTheTitle()), 'rel' => 'permalink')); ?> | 
    </span>
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'posts', 'action' => 'edit', $this->Post->getTheID()), array('title' => __('Edit this item'))); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', $this->Post->getTheID()), array('title' => __('Delete this item')), __('Are you sure you want to delete "%s"?', $this->Post->getTheTitle())); ?>
    </span>
</div>