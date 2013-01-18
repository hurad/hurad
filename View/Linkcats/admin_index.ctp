<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php echo $this->Html->script('checkbox', array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Linkcat', array('url' =>
    array('admin' => TRUE, 'controller' => 'linkcats', 'action' => 'process'),
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
            <th id="description" class="column-description column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('description', __('Description')); ?>
            </th>
            <th id="link_count" class="column-link_count column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('link_count', __('Links')); ?>
            </th>
        </tr>
    </thead>
    <?php foreach ($linkcats as $linkcat): ?>
        <tr id="<?php echo h($linkcat['Linkcat']['id']); ?>" class="linkcat-<?php echo h($linkcat['Linkcat']['id']); ?>">
            <td class="check-column" scope="row">
                <?php echo $this->Form->checkbox('Linkcat.' . $linkcat['Linkcat']['id'] . '.id'); ?>
            </td>
            <td class="column-name">
                <?php echo $this->Html->link(h($linkcat['Linkcat']['name']), array('admin' => TRUE, 'controller' => 'linkcats', 'action' => 'edit', $linkcat['Linkcat']['id'])); ?>
                <div class="row-actions">
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'linkcats', 'action' => 'edit', $linkcat['Linkcat']['id'])); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'linkcats', 'action' => 'delete', $linkcat['Linkcat']['id']), null, __('Are you sure you want to delete " %s " ?', $linkcat['Linkcat']['name'])); ?>
                    </span>
                </div>
            </td>
            <td class="column-slug">
                <?php echo h($linkcat['Linkcat']['slug']); ?>
            </td>
            <td class="column-description">
                <?php echo h($linkcat['Linkcat']['description']); ?>&nbsp;
            </td>
            <td class="column-link_count">
                <?php echo h($linkcat['Linkcat']['link_count']); ?>
            </td>
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
            <th class="column-description column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('description', __('Description')); ?>
            </th>
            <th class="column-link_count column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('link_count', __('Links')); ?>
            </th>
        </tr>
    </tfoot>
</table>
<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Linkcat.action', array(
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
