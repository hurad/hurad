<div class="menus form">
    <?php echo $this->Form->create('Menu'); ?>
    <fieldset>
        <legend><?php echo __('Add Menu'); ?></legend>
        <?php
        echo $this->Form->input('name');
        echo $this->Form->input('alias');
        echo $this->Form->input('description');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>

        <li><?php echo $this->Html->link(__('List Menus'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(
                __('List Links'),
                array('controller' => 'links', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
    </ul>
</div>
