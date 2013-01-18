<?php $this->Html->css('list-table', null, array('inline' => false)); ?>
<?php echo $this->Html->script('checkbox', array('block' => 'headerScript')); ?>

<h2>
    <?php echo $title_for_layout; ?>
    <?php echo $this->Html->link(__('Add New'), '/admin/categories/add', array('class' => 'add_button')); ?>
</h2>

<table class="list-table">
    <thead>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="name" class="column-name column-manage check-column" scope="col">
                <?php echo __('Name'); ?>
            </th>
            <th id="parentName">
                <?php echo __('Slug'); ?>
            </th>
            <th id="slug" class="column-slug column-manage check-column" scope="col">
                <?php echo __('Description'); ?>
            </th>
            <th id="slug" class="column-slug column-manage check-column" scope="col">
                <?php echo __('Posts'); ?>
            </th>
        </tr>
    </thead>
    <?php //debug($categories); ?>
    <?php foreach ($categories AS $i => $category): ?>
        <?php //echo $i.'<br>'; ?>
        <tr id="<?php echo h($category['Category']['id']); ?>" class="menu-<?php echo h($category['Category']['id']); ?>">
            <td class="check-column" scope="row"><input type=checkbox name=checkbox[<?php echo h($category['Category']['id']); ?>] value=<?php echo h($category['Category']['id']); ?>></td>
            <td class="column-name">
                <?php echo $this->Html->link($category['Category']['path'], array('admin' => TRUE, 'controller' => 'categories', 'action' => 'edit', $category['Category']['id'])); ?>
                <div class="row-actions">
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'categories', 'action' => 'edit', $category['Category']['id'])); ?> | 
                    </span>
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'categories', 'action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['name'])); ?>
                    </span>
                </div>
            </td>           
            <td class="column-slug">
                <?php echo h($category['Category']['slug']); ?>
            </td>
            <td class="column-description">
                <?php echo h($category['Category']['description']); ?>&nbsp;
            </td>
            <td class="column-post_count">
                <?php echo h($category['Category']['post_count']); ?>&nbsp;
            </td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th class="column-name column-manage check-column" scope="col">
                <?php echo __('Name'); ?>
            </th>
            <th class="column-name column-manage check-column">
                <?php echo __('Slug'); ?>
            </th>
            <th class="column-slug column-manage check-column" scope="col">
                <?php echo __('Description'); ?>
            </th>
            <th class="column-slug column-manage check-column" scope="col">
                <?php echo __('Posts'); ?>
            </th>    
        </tr>
    </tfoot>
</table>


