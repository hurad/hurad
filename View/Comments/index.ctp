<div class="comments index">
    <h2><?php echo __d('hurad', 'Comments'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('parent_id'); ?></th>
            <th><?php echo $this->Paginator->sort('post_id'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('author'); ?></th>
            <th><?php echo $this->Paginator->sort('author_email'); ?></th>
            <th><?php echo $this->Paginator->sort('author_url'); ?></th>
            <th><?php echo $this->Paginator->sort('author_ip'); ?></th>
            <th><?php echo $this->Paginator->sort('content'); ?></th>
            <th><?php echo $this->Paginator->sort('approved'); ?></th>
            <th><?php echo $this->Paginator->sort('agent'); ?></th>
            <th><?php echo $this->Paginator->sort('lft'); ?></th>
            <th><?php echo $this->Paginator->sort('rght'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?php echo __d('hurad', 'Actions'); ?></th>
        </tr>
        <?php
        foreach ($comments as $comment): ?>
            <tr>
                <td><?php echo h($comment['Comment']['id']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link(
                        $comment['ParentComment']['content'],
                        array('controller' => 'comments', 'action' => 'view', $comment['ParentComment']['id'])
                    ); ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        $comment['Post']['title'],
                        array('controller' => 'posts', 'action' => 'view', $comment['Post']['id'])
                    ); ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        $comment['User']['username'],
                        array('controller' => 'users', 'action' => 'view', $comment['User']['id'])
                    ); ?>
                </td>
                <td><?php echo h($comment['Comment']['author']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['author_email']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['author_url']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['author_ip']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['content']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['approved']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['agent']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['lft']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['rght']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['created']); ?>&nbsp;</td>
                <td><?php echo h($comment['Comment']['modified']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('hurad', 'View'), array('action' => 'view', $comment['Comment']['id'])); ?>
                    <?php echo $this->Html->link(__d('hurad', 'Edit'), array('action' => 'edit', $comment['Comment']['id'])); ?>
                    <?php echo $this->Form->postLink(
                        __d('hurad', 'Delete'),
                        array('action' => 'delete', $comment['Comment']['id']),
                        null,
                        __d('hurad', 'Are you sure you want to delete # %s?', $comment['Comment']['id'])
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
        <li><?php echo $this->Html->link(__d('hurad', 'New Comment'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Comments'),
                array('controller' => 'comments', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'New Parent Comment'),
                array('controller' => 'comments', 'action' => 'add')
            ); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Posts'),
                array('controller' => 'posts', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(
                __d('hurad', 'List Users'),
                array('controller' => 'users', 'action' => 'index')
            ); ?> </li>
        <li><?php echo $this->Html->link(__d('hurad', 'New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
    </ul>
</div>
