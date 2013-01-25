<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php echo $this->Html->script('checkbox', array('block' => 'headerScript')); ?>

<h2>
    <?php echo $title_for_layout; ?>
    <?php echo $this->Html->link(__('Add New'), '/admin/tags/add', array('class' => 'add_button')); ?>
</h2>

<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Tag.action.top', array(
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
            <th id="slug">
                <?php echo $this->Paginator->sort('slug', __('Slug')); ?>
            </th>
            <th id="description" class="column-description column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('description', __('Description')); ?>
            </th>
        </tr>
    </thead>
    <?php foreach ($tags AS $tag): ?>
        <tr id="<?php echo h($tag['Tag']['id']); ?>" class="menu-<?php echo h($tag['Tag']['id']); ?>">
            <td class="check-column" scope="row"><?php echo $this->Form->checkbox('Tag.' . $tag['Tag']['id'] . '.id'); ?></td>
            <td class="column-name">
                <?php echo h($tag['Tag']['name']); ?>
                <div class="row-actions">
                    <span class="action-view">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $tag['Tag']['id'])); ?> | 
                    </span>
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'Tags', 'action' => 'edit', $tag['Tag']['id'])); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tag['Tag']['id']), null, __('Are you sure you want to delete %s?', $tag['Tag']['name'])); ?>
                    </span>
                </div>
            </td>           
            <td class="column-slug">
                <?php echo h($tag['Tag']['slug']); ?>
            </td>
            <td class="column-description">
                <?php echo h($tag['Tag']['description']); ?>&nbsp;
            </td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th class="column-name column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('name', __('Name')); ?>
            </th>
            <th class="column-slug column-manage check-column">
                <?php echo $this->Paginator->sort('slug', __('Slug')); ?>
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
        echo $this->Form->input('Tag.action.bot', array(
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