<div class="comments view">
<h2><?php  echo __('Comment');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Comment'); ?></dt>
		<dd>
			<?php echo $this->Html->link($comment['ParentComment']['content'], array('controller' => 'comments', 'action' => 'view', $comment['ParentComment']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post'); ?></dt>
		<dd>
			<?php echo $this->Html->link($comment['Post']['title'], array('controller' => 'posts', 'action' => 'view', $comment['Post']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($comment['User']['username'], array('controller' => 'users', 'action' => 'view', $comment['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['author']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author Email'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['author_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author Url'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['author_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author Ip'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['author_ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Approved'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['approved']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Agent'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['agent']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lft'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rght'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['rght']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($comment['Comment']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Comment'), array('action' => 'edit', $comment['Comment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Comment'), array('action' => 'delete', $comment['Comment']['id']), null, __('Are you sure you want to delete # %s?', $comment['Comment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Comments');?></h3>
	<?php if (!empty($comment['ChildComment'])):?>
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
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($comment['ChildComment'] as $childComment): ?>
		<tr>
			<td><?php echo $childComment['id'];?></td>
			<td><?php echo $childComment['parent_id'];?></td>
			<td><?php echo $childComment['post_id'];?></td>
			<td><?php echo $childComment['user_id'];?></td>
			<td><?php echo $childComment['author'];?></td>
			<td><?php echo $childComment['author_email'];?></td>
			<td><?php echo $childComment['author_url'];?></td>
			<td><?php echo $childComment['author_ip'];?></td>
			<td><?php echo $childComment['content'];?></td>
			<td><?php echo $childComment['approved'];?></td>
			<td><?php echo $childComment['agent'];?></td>
			<td><?php echo $childComment['lft'];?></td>
			<td><?php echo $childComment['rght'];?></td>
			<td><?php echo $childComment['created'];?></td>
			<td><?php echo $childComment['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'comments', 'action' => 'view', $childComment['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'comments', 'action' => 'edit', $childComment['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'comments', 'action' => 'delete', $childComment['id']), null, __('Are you sure you want to delete # %s?', $childComment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Comment'), array('controller' => 'comments', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
