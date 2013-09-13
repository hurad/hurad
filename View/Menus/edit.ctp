<div class="menus form">
    <?php echo $this->Form->create('Menu'); ?>
    <fieldset>
        <legend><?php echo __d('hurad', 'Edit Menu'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('name');
        echo $this->Form->input('alias');
        echo $this->Form->input('description');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('hurad', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('hurad', 'Actions'); ?></h3>
    <ul>

        <li><?php echo $this->Form->postLink(
                __d('hurad', 'Delete'),
                array('action' => 'delete', $this->Form->value('Menu.id')),
                null,
                __d('hurad', 'Are you sure you want to delete # %s?', $this->Form->value('Menu.id'))
            ); ?></li>
        <li><?php echo $this->Html->link(__d('hurad', 'List Menus'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Links'),
                array('controller' => 'links', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
    </ul>
</div>
