<div class="row-actions">
    <span class="action-edit">
        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'categories', 'action' => 'edit', $category['Category']['id'])); ?> | 
    </span>
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'categories', 'action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['name'])); ?>
    </span>
</div>