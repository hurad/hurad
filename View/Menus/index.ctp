<div class="menus index">
    <h2><?php echo __d('hurad', 'Menus'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('alias'); ?></th>
            <th><?php echo $this->Paginator->sort('description'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?php echo __d('hurad', 'Actions'); ?></th>
        </tr>
        <?php
        foreach ($menus as $menu): ?>
            <tr>
                <td><?php echo h($menu['Menu']['id']); ?>&nbsp;</td>
                <td><?php echo h($menu['Menu']['name']); ?>&nbsp;</td>
                <td><?php echo h($menu['Menu']['alias']); ?>&nbsp;</td>
                <td><?php echo h($menu['Menu']['description']); ?>&nbsp;</td>
                <td><?php echo h($menu['Menu']['created']); ?>&nbsp;</td>
                <td><?php echo h($menu['Menu']['modified']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('hurad', 'View'), array('action' => 'view', $menu['Menu']['id'])); ?>
                    <?php echo $this->Html->link(__d('hurad', 'Edit'), array('action' => 'edit', $menu['Menu']['id'])); ?>
                    <?php echo $this->Form->postLink(
                        __d('hurad', 'Delete'),
                        array('action' => 'delete', $menu['Menu']['id']),
                        null,
                        __d('hurad', 'Are you sure you want to delete # %s?', $menu['Menu']['id'])
                    ); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(
            array(
                'format' => __(
                    'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'
                )
            )
        );
        ?>    </p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __d('hurad', 'previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__d('hurad', 'next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>
<div class="actions">
    <h3><?php echo __d('hurad', 'Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__d('hurad', 'New Menu'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Links'),
                array('controller' => 'links', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
    </ul>
</div>
