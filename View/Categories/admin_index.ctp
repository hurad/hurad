<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<h2>
    <?php echo $title_for_layout; ?>
    <?php echo $this->Html->link(__('Add New'), '/admin/categories/add', array('class' => 'add_button')); ?>
</h2>

<?php
echo $this->Form->create('Category', array('url' =>
    array('admin' => TRUE, 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>

<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Category.action.top', array(
            'label' => false,
            'options' => array(
                'delete' => __('Delete'),
            ),
            'empty' => __('Bulk Actions'),
        ));
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
    <div class="paging">
        <?php
        if ($this->Paginator->numbers()) {
            echo $this->Paginator->prev('« ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('Next') . ' »', array(), null, array('class' => 'next disabled'));
        }
        ?>
    </div>
    <div class="pageing_counter">
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total')
        ));
        ?>	
    </div>
</div>

<table class="list-table">
    <thead>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="name" class="column-name column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('name', __('Name')); ?>
            </th>
            <th id="parentName">
                <?php echo $this->Paginator->sort('slug', __('Slug')); ?>
            </th>
            <th id="slug" class="column-slug column-manage check-column" scope="col">
                <?php echo __('Description'); ?>
            </th>
            <th id="slug" class="column-slug column-manage check-column" scope="col">
                <?php echo __('Posts'); ?>
            </th>
        </tr>
    </thead>
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

<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Category.action.bot', array(
            'label' => false,
            'options' => array(
                'delete' => __('Delete'),
            ),
            'empty' => __('Bulk Actions'),
        ));
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
    <div class="paging">
        <?php
        if ($this->Paginator->numbers()) {
            echo $this->Paginator->prev('« ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('Next') . ' »', array(), null, array('class' => 'next disabled'));
        }
        ?>
    </div>
    <div class="pageing_counter">
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total')
        ));
        ?>	
    </div>
</div>