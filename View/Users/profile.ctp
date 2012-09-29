<div class="users view">
    <h2><?php echo __('User'); ?></h2>
    <dl>
        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($user['User']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Avatar'); ?></dt>
        <dd><?php echo $this->Gravatar->image($user['User']['email']); ?>
        </dd>
        <dt><?php echo __('Username'); ?></dt>
        <dd>
            <?php echo h($user['User']['username']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Password'); ?></dt>
        <dd>
            <?php echo h($user['User']['password']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Firstname'); ?></dt>
        <dd>
            <?php echo h($user['User']['firstname']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Lastname'); ?></dt>
        <dd>
            <?php echo h($user['User']['lastname']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Nicename'); ?></dt>
        <dd>
            <?php echo h($user['User']['nicename']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Display Name'); ?></dt>
        <dd>
            <?php echo h($user['User']['display_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Email'); ?></dt>
        <dd>
            <?php echo h($user['User']['email']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Url'); ?></dt>
        <dd>
            <?php echo h($user['User']['url']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Role'); ?></dt>
        <dd>
            <?php echo h($user['User']['role']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($user['User']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($user['User']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
    </ul>
</div>
<div class="related">
    <h3><?php echo __('Related Comments'); ?></h3>
    <?php if (!empty($user['Comment'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('Parent Id'); ?></th>
                <th><?php echo __('Post Id'); ?></th>
                <th><?php echo __('User Id'); ?></th>
                <th><?php echo __('Author'); ?></th>
                <th><?php echo __('Author Email'); ?></th>
                <th><?php echo __('Author Url'); ?></th>
                <th><?php echo __('Author Ip'); ?></th>
                <th><?php echo __('Content'); ?></th>
                <th><?php echo __('Approved'); ?></th>
                <th><?php echo __('Agent'); ?></th>
                <th><?php echo __('Lft'); ?></th>
                <th><?php echo __('Rght'); ?></th>
                <th><?php echo __('Created'); ?></th>
                <th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($user['Comment'] as $comment):
                ?>
                <tr>
                    <td><?php echo $comment['id']; ?></td>
                    <td><?php echo $comment['parent_id']; ?></td>
                    <td><?php echo $comment['post_id']; ?></td>
                    <td><?php echo $comment['user_id']; ?></td>
                    <td><?php echo $comment['author']; ?></td>
                    <td><?php echo $comment['author_email']; ?></td>
                    <td><?php echo $comment['author_url']; ?></td>
                    <td><?php echo $comment['author_ip']; ?></td>
                    <td><?php echo $comment['content']; ?></td>
                    <td><?php echo $comment['approved']; ?></td>
                    <td><?php echo $comment['agent']; ?></td>
                    <td><?php echo $comment['lft']; ?></td>
                    <td><?php echo $comment['rght']; ?></td>
                    <td><?php echo $comment['created']; ?></td>
                    <td><?php echo $comment['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('controller' => 'comments', 'action' => 'view', $comment['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'comments', 'action' => 'edit', $comment['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['id']), null, __('Are you sure you want to delete # %s?', $comment['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Related Posts'); ?></h3>
    <?php if (!empty($user['Post'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('User Id'); ?></th>
                <th><?php echo __('Title'); ?></th>
                <th><?php echo __('Slug'); ?></th>
                <th><?php echo __('Content'); ?></th>
                <th><?php echo __('Excerpt'); ?></th>
                <th><?php echo __('Status'); ?></th>
                <th><?php echo __('Comment Status'); ?></th>
                <th><?php echo __('Comment Count'); ?></th>
                <th><?php echo __('Type'); ?></th>
                <th><?php echo __('Created'); ?></th>
                <th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($user['Post'] as $post):
                ?>
                <tr>
                    <td><?php echo $post['id']; ?></td>
                    <td><?php echo $post['user_id']; ?></td>
                    <td><?php echo $post['title']; ?></td>
                    <td><?php echo $post['slug']; ?></td>
                    <td><?php echo $post['content']; ?></td>
                    <td><?php echo $post['excerpt']; ?></td>
                    <td><?php echo $post['status']; ?></td>
                    <td><?php echo $post['comment_status']; ?></td>
                    <td><?php echo $post['comment_count']; ?></td>
                    <td><?php echo $post['type']; ?></td>
                    <td><?php echo $post['created']; ?></td>
                    <td><?php echo $post['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $post['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $post['id']), null, __('Are you sure you want to delete # %s?', $post['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>
