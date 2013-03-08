<div class="row-actions">
    <span class="action-visit_link">
        <?php echo $this->Html->link(__('Visit Link'), $link['Link']['url'], array('target' => '_blank')); ?> | 
    </span>
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'links', 'action' => 'edit', $link['Link']['id'])); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'links', 'action' => 'delete', $link['Link']['id']), null, __('Are you sure you want to delete " %s " ?', $link['Link']['name'])); ?>
    </span>
</div>