<div class="menus view">
    <h2><?php echo __d('hurad', 'Menu'); ?></h2>
    <dl>
        <dt><?php echo __d('hurad', 'Id'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('hurad', 'Name'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('hurad', 'Alias'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['alias']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('hurad', 'Description'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['description']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('hurad', 'Created'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('hurad', 'Modified'); ?></dt>
        <dd>
            <?php echo h($menu['Menu']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __d('hurad', 'Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__d('hurad', 'Edit Menu'), array('action' => 'edit', $menu['Menu']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(
                __d('hurad', 'Delete Menu'),
                array('action' => 'delete', $menu['Menu']['id']),
                null,
                __d('hurad', 'Are you sure you want to delete # %s?', $menu['Menu']['id'])
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'List Menus'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New Menu'), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Links'),
                array('controller' => 'links', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
    </ul>
</div>
<div class="related">
    <h3><?php echo __d('hurad', 'Related Links'); ?></h3>
    <?php if (!empty($menu['Link'])): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo __d('hurad', 'Id'); ?></th>
                <th><?php echo __d('hurad', 'Parent Id'); ?></th>
                <th><?php echo __d('hurad', 'Menu Id'); ?></th>
                <th><?php echo __d('hurad', 'Name'); ?></th>
                <th><?php echo __d('hurad', 'Description'); ?></th>
                <th><?php echo __d('hurad', 'Url'); ?></th>
                <th><?php echo __d('hurad', 'Target'); ?></th>
                <th><?php echo __d('hurad', 'Rel'); ?></th>
                <th><?php echo __d('hurad', 'Visible'); ?></th>
                <th><?php echo __d('hurad', 'Rating'); ?></th>
                <th><?php echo __d('hurad', 'Created'); ?></th>
                <th><?php echo __d('hurad', 'Modified'); ?></th>
                <th class="actions"><?php echo __d('hurad', 'Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($menu['Link'] as $link): ?>
                <tr>
                    <td><?php echo $link['id']; ?></td>
                    <td><?php echo $link['parent_id']; ?></td>
                    <td><?php echo $link['menu_id']; ?></td>
                    <td><?php echo $link['name']; ?></td>
                    <td><?php echo $link['description']; ?></td>
                    <td><?php echo $link['url']; ?></td>
                    <td><?php echo $link['target']; ?></td>
                    <td><?php echo $link['rel']; ?></td>
                    <td><?php echo $link['visible']; ?></td>
                    <td><?php echo $link['rating']; ?></td>
                    <td><?php echo $link['created']; ?></td>
                    <td><?php echo $link['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(
                            __d('hurad', 'View'),
                            array('controller' => 'links', 'action' => 'view', $link['id'])
                        ); ?>
                        <?php echo $this->Html->link(
                            __d('hurad', 'Edit'),
                            array('controller' => 'links', 'action' => 'edit', $link['id'])
                        ); ?>
                        <?php echo $this->Form->postLink(
                            __d('hurad', 'Delete'),
                            array('controller' => 'links', 'action' => 'delete', $link['id']),
                            null,
                            __d('hurad', 'Are you sure you want to delete # %s?', $link['id'])
                        ); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(
                    __d('hurad', 'New Link'),
                    array('controller' => 'links', 'action' => 'add')
                ); ?> </li>
        </ul>
    </div>
</div>
