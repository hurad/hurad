<div class="row-actions">
    <span class="action-view">
        <?php echo $this->Html->link(__('View'), $this->Page->getPermalink(), array('title' => __('View “%s”', $this->Page->getTheTitle()), 'rel' => 'permalink')); ?> | 
    </span>
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'pages', 'action' => 'edit', $this->Page->getTheID()), array('title' => __('Edit this item'))); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', $this->Page->getTheID()), array('title' => __('Delete this item')), __('Are you sure you want to delete "%s"?', $this->Page->getTheTitle())); ?>
    </span>
</div>