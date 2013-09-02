<div class="posts view">
    <?php $this->Layout->setPost($post); ?>
    <h2><?php echo h($post['Post']['title']); ?></h2>

    <?php echo h($post['Post']['id']); ?>
    <?php echo $this->Html->link(
        $post['User']['username'],
        array('controller' => 'users', 'action' => 'view', $post['User']['id'])
    ); ?>
    <?php echo h($post['Post']['title']); ?>

    <?php echo h($post['Post']['slug']); ?>

    <?php echo h($post['Post']['content']); ?>


    <?php echo h($post['Post']['excerpt']); ?>

    <?php echo h($post['Post']['status']); ?>

    <?php echo h($post['Post']['comment_status']); ?>


    <?php echo h($post['Post']['comment_count']); ?>

    <?php echo h($post['Post']['type']); ?>

    <?php echo h($post['Post']['created']); ?>

    <?php echo h($post['Post']['modified']); ?>

</div>
<?php echo $this->element('comment_form'); ?>

<div class="related">
    <?php echo $this->element('comment_list'); ?>

</div>

<div class="related">
    <h3><?php echo __('Related Tags'); ?></h3>
    <?php if (!empty($post['Tag'])): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Slug'); ?></th>
                <th><?php echo __('Created'); ?></th>
                <th><?php echo __('Modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($post['Tag'] as $tag): ?>
                <tr>
                    <td><?php echo $tag['id']; ?></td>
                    <td><?php echo $tag['name']; ?></td>
                    <td><?php echo $tag['slug']; ?></td>
                    <td><?php echo $tag['created']; ?></td>
                    <td><?php echo $tag['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(
                            __('View'),
                            array('controller' => 'tags', 'action' => 'view', $tag['id'])
                        ); ?>
                        <?php echo $this->Html->link(
                            __('Edit'),
                            array('controller' => 'tags', 'action' => 'edit', $tag['id'])
                        ); ?>
                        <?php echo $this->Form->postLink(
                            __('Delete'),
                            array('controller' => 'tags', 'action' => 'delete', $tag['id']),
                            null,
                            __('Are you sure you want to delete # %s?', $tag['id'])
                        ); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>

<p><?php $this->Layout->category(); ?></p>