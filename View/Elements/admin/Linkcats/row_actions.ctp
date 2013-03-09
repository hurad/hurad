<div class="row-actions">
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'linkcats', 'action' => 'edit', $linkcat['Linkcat']['id'])); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'linkcats', 'action' => 'delete', $linkcat['Linkcat']['id']), null, __('Are you sure you want to delete " %s " ?', $linkcat['Linkcat']['name'])); ?>
    </span>
</div>