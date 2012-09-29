<div class="links index">
	<h2><?php echo __('Links');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('menu_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('url');?></th>
			<th><?php echo $this->Paginator->sort('target');?></th>
			<th><?php echo $this->Paginator->sort('rel');?></th>
			<th><?php echo $this->Paginator->sort('visible');?></th>
			<th><?php echo $this->Paginator->sort('rating');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($links as $link): ?>
	<tr>
		<td><?php echo h($link['Link']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($link['ParentLink']['name'], array('controller' => 'links', 'action' => 'view', $link['ParentLink']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($link['Menu']['name'], array('controller' => 'menus', 'action' => 'view', $link['Menu']['id'])); ?>
		</td>
		<td><?php echo h($link['Link']['name']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['description']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['url']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['target']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['rel']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['visible']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['rating']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['created']); ?>&nbsp;</td>
		<td><?php echo h($link['Link']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $link['Link']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $link['Link']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $link['Link']['id']), null, __('Are you sure you want to delete # %s?', $link['Link']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Link'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Links'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Menus'), array('controller' => 'menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Menu'), array('controller' => 'menus', 'action' => 'add')); ?> </li>
	</ul>
</div>
