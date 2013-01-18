<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php echo $this->Html->script(array('pages', 'checkbox'), array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>

<div class="table-filter-search">
    <?php echo $this->element('admin/pages_filter'); ?>
    <?php echo $this->element('admin/pages_search'); ?>
</div>

<?php
echo $this->Form->create('Page', array('url' =>
    array('admin' => TRUE, 'controller' => 'pages', 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>
<table class="list-table">
    <thead>
        <tr>
            <th id="cb" class="column-cb column-manage" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="title" class="column-plugin column-manage" scope="col">
                <?php echo __('Plugin'); ?>
            </th>
            <th id="author" class="column-description column-manage" scope="col">
                <?php echo __('Description'); ?>
            </th>
        </tr>
    </thead>
    <?php foreach ($plugins as $pluginAlias => $plugin): ?>
        <?php
        if ($plugin['active']) {
            $toggleText = __('Deactivate');
        } else {
            $toggleText = __('Activate');
        }
        ?>
        <tr id="<?php echo $plugin['name']; ?>" class="post-<?php echo $plugin['name']; ?>">
            <td class="check-column" scope="row">
                <?php echo $this->Form->checkbox('Plugin..id'); ?>
            </td>
            <td class="column-title">
                <?php echo $plugin['name']; ?>&nbsp;
                <div class="row-actions">
                    <span class="action-activate">
                        <?php echo $this->Html->Link($toggleText, array('admin' => TRUE, 'controller' => 'plugins', 'action' => 'toggle', $pluginAlias)); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', 21), null, __('Are you sure you want to delete "%s"?', 21)); ?>
                    </span>
                </div>
            </td>
            <td class="column-author">
                <?php echo $plugin['description']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="title" class="column-plugin column-manage" scope="col">
                <?php echo __('Plugin'); ?>
            </th>
            <th id="author" class="column-description column-manage" scope="col">
                <?php echo __('Description'); ?>
            </th>
        </tr>
    </tfoot>
</table>
<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Plugin.action', array(
            'label' => false,
            'options' => array(
                'activate' => __('Activate'),
                'deactivate' => __('Deactivate'),
                'delete' => __('Delete'),
            ),
            'empty' => __('Bulk Actions'),
        ));
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
</div>

