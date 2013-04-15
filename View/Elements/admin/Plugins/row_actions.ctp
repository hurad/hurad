<?php
if (HuradPlugin::isActive($alias)) {
    $toggleText = __('Deactivate');
} else {
    $toggleText = __('Activate');
}
?>
<div class="row-actions">
    <span class="action-activate">
        <?php echo $this->Html->Link($toggleText, array('admin' => TRUE, 'controller' => 'plugins', 'action' => 'toggle', $alias)); ?> | 
    </span>                 
    <span class="action-delete">
        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', 21), null, __('Are you sure you want to delete "%s"?', 21)); ?>
    </span>
</div>