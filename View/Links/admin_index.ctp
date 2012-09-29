<?php $this->Html->css('list-table', null, array('inline' => false)); ?>
<h2><?php echo $title_for_layout; ?></h2>

<?php
echo $this->Form->create('Link', array('url' =>
    array('admin' => TRUE, 'controller' => 'links', 'action' => 'process'),
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
            <th id="url" class="column-url column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('url', __('URL')); ?>
            </th>
            <th id="menu" class="column-menu column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('Menu.name', __('Category')); ?>
            </th>
            <th id="visible" class="column-visible column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('visible', __('Visible')); ?>
            </th>
            <th id="rating" class="column-rating column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('rating', __('Rating')); ?>
            </th>            
        </tr>
    </thead>
    <?php foreach ($links as $link): ?>
        <tr id="<?php echo h($link['Link']['id']); ?>" class="link-<?php echo h($link['Link']['id']); ?>">
            <td class="check-column" scope="row">
                <?php echo $this->Form->checkbox('Link.' . $link['Link']['id'] . '.id'); ?>
            </td>
            <td class="column-name">
                <?php echo $this->Html->link(h($link['Link']['name']), array('admin' => TRUE, 'controller' => 'links', 'action' => 'edit', $link['Link']['id']), array('title' => __('Edit "%s"', $link['Link']['name']))); ?>
                <div class="row-actions">
                    <span class="action-view">
                        <?php echo $this->Html->link(__('Visit Link'), $link['Link']['url'], array('target' => '_blank')); ?> | 
                    </span>
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'links', 'action' => 'edit', $link['Link']['id'])); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'links', 'action' => 'delete', $link['Link']['id']), null, __('Are you sure you want to delete " %s " ?', $link['Link']['name'])); ?>
                    </span>
                </div>
            </td>
            <td class="column-url">
                <?php echo $this->Html->link($this->AdminLayout->linkUrl($link['Link']['url']), $link['Link']['url'], array('target' => '_blank', 'title' => __('Visit %s', $link['Link']['name']))); ?>&nbsp;
            </td>
            <td class="column-menu">
                <?php echo $this->Html->link(h($link['Menu']['name']), array('admin' => TRUE, 'controller' => 'links', 'action' => 'catIndex', $link['Menu']['id'])); ?>&nbsp;
            </td>
            <td class="column-visible">
                <?php echo $this->AdminLayout->linkVisible($link['Link']['visible']); ?>&nbsp;
            </td>
            <td class="column-rating">
                <?php echo h($link['Link']['rating']); ?>&nbsp;
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
            <th class="column-url column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('url', __('URL')); ?>
            </th>
            <th class="column-menu column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('Menu.name', __('Category')); ?>
            </th>
            <th class="column-visible column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('visible', __('Visible')); ?>
            </th>
            <th class="column-rating column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('rating', __('Rating')); ?>
            </th>            
        </tr>
    </tfoot>
</table>
<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Link.action', array(
            'label' => false,
            'options' => array(
                'visible' => __('Visible'),
                'invisible' => __('Invisible'),
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
