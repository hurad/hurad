<div class="posts index">
    <h2><?php echo __d('hurad', 'Posts'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('title'); ?></th>
            <th><?php echo $this->Paginator->sort('slug'); ?></th>
            <th><?php echo $this->Paginator->sort('content'); ?></th>
            <th><?php echo $this->Paginator->sort('excerpt'); ?></th>
            <th><?php echo $this->Paginator->sort('status'); ?></th>
            <th><?php echo $this->Paginator->sort('comment_status'); ?></th>
            <th><?php echo $this->Paginator->sort('comment_count'); ?></th>
            <th><?php echo $this->Paginator->sort('type'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?php echo __d('hurad', 'Actions'); ?></th>
        </tr>
        <?php
        foreach ($posts as $post): ?>
            <tr>
                <td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link(
                        $post['User']['username'],
                        array('controller' => 'users', 'action' => 'view', $post['User']['id'])
                    ); ?>
                </td>
                <td><?php echo h($post['Post']['title']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['slug']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['content']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['excerpt']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['status']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['comment_status']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['comment_count']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['type']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
                <td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('hurad', 'View'), array('action' => 'view', $post['Post']['id'])); ?>
                    <?php echo $this->Html->link(__d('hurad', 'Edit'), array('action' => 'edit', $post['Post']['id'])); ?>
                    <?php echo $this->Form->postLink(
                        __d('hurad', 'Delete'),
                        array('action' => 'delete', $post['Post']['id']),
                        null,
                        __d('hurad', 'Are you sure you want to delete # %s?', $post['Post']['id'])
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
        <li><?php echo $this->Html->link(__d('hurad', 'New Post'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Users'),
                array('controller' => 'users', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Comments'),
                array('controller' => 'comments', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'New Comment'),
                array('controller' => 'comments', 'action' => 'add')
            ); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Categories'),
                array('controller' => 'categories', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'New Category'),
                array('controller' => 'categories', 'action' => 'add')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
    </ul>
</div>
