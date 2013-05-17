<div class="row-actions">
    <span class="action-approved">
        <?php echo $this->AdminLayout->approveLink($comment['Comment']['approved'], $this->Comment->getCommentID()); ?> |
    </span>
    <span class="action-view">
        <?php echo $this->Html->link(__('View'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'view', $this->Comment->getCommentID())); ?> | 
    </span>
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'edit', $this->Comment->getCommentID())); ?> | 
    </span>
    <span class="action-spam">
        <?php echo $this->Html->link(__('Spam'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'action', 'spam', $this->Comment->getCommentID())); ?> | 
    </span>  
    <span class="action-trash">
        <?php echo $this->Html->link(__('Trash'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'action', 'trash', $this->Comment->getCommentID())); ?> | 
    </span> 
</div>