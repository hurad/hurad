<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>

<?php
echo $this->Form->create('User', array('url' =>
    array('admin' => TRUE, 'controller' => 'users', 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>

<table class="list-table">
    <thead>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="name" class="column-name column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('name', __('Name')); ?>
            </th>
            <th id="slug" class="column-slug column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('slug', __('Slug')); ?>
            </th>
            <th id="link_count" class="column-link_count column-manage" scope="col">
                <?php echo $this->Paginator->sort('link_count', __('Link Count')); ?>
            </th>
            <th id="description" class="column-description column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('description', __('Description')); ?>
            </th>
        </tr>
    </thead>
    <?php foreach ($menus as $menu): ?>
        <tr id="<?php echo h($menu['Menu']['id']); ?>" class="menu-<?php echo h($menu['Menu']['id']); ?>">
            <td class="check-column" scope="row"><input type=checkbox name=checkbox[<?php echo h($menu['Menu']['id']); ?>] value=<?php echo h($menu['Menu']['id']); ?>></td>
            <td class="column-name">
                <?php echo h($menu['Menu']['name']); ?>
                <div class="row-actions">
                    <span class="action-add_link">
                        <?php echo $this->Html->link(__('Add new link'), array('admin' => TRUE, 'controller' => 'links', 'action' => 'add', $menu['Menu']['id'])); ?> | 
                    </span>
                    <span class="action-view_links">
                        <?php echo $this->Html->link(__('View Links'), array('admin' => TRUE, 'controller' => 'links', 'action' => 'indexBymenu', $menu['Menu']['id'])); ?> | 
                    </span>                 
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'menus', 'action' => 'edit', $menu['Menu']['id'])); ?> |
                    </span>
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'menus', 'action' => 'delete', $menu['Menu']['id']), null, __('Are you sure you want to delete # %s?', $menu['Menu']['id'])); ?>
                    </span>
                </div>
            </td>
            <td class="column-slug"><?php echo h($menu['Menu']['slug']); ?>&nbsp;</td>
            <td class="column-link_count"><?php echo h($menu['Menu']['link_count']); ?>&nbsp;</td>
            <td class="column-description"><?php echo h($menu['Menu']['description']); ?>&nbsp;</td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th class="column-name column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('name', __('Name')); ?>
            </th>
            <th class="column-slug column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('slug', __('Slug')); ?>
            </th>
            <th id="link_count" class="column-link_count column-manage" scope="col">
                <?php echo $this->Paginator->sort('link_count', __('Link Count')); ?>
            </th>
            <th class="column-description column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('description', __('Description')); ?>
            </th>
        </tr>
    </tfoot>
</table>
<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('User.action', array(
            'label' => false,
            'options' => array(
                'delete' => __('Delete')
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
