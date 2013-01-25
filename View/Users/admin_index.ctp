<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>

<div class="tablenav">
    <div class="paging">
        <?php
        if ($this->Paginator->numbers()) {
            echo $this->Paginator->prev('« ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('Next') . ' »', array(), null, array('class' => 'next disabled'));
        }
        ?>
    </div>
</div>

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
            <th id="username" class="column-username column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('username'); ?>
            </th>
            <th id="name" class="column-name column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('firstname', 'Name'); ?>
            </th>
            <th id="email" class="column-email column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('email'); ?>
            </th>
            <th id="role" class="column-role column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('role'); ?>
            </th>
        </tr>
    </thead>
    <?php foreach ($users as $user): ?>
        <tr id="<?php echo h($user['User']['id']); ?>" class="user-<?php echo h($user['User']['id']); ?>">
            <td class="check-column" scope="row">
                <?php echo $this->Form->checkbox('User.' . $user['User']['id'] . '.id'); ?>
            </td>
            <td class="column-username">
                <?php echo $this->Gravatar->image($user['User']['email'], array('size' => '32', 'default' => 'mm')); ?>
                <strong><?php echo $this->Html->link(h($user['User']['username']), array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $user['User']['id'])); ?></strong>
                <div class="row-actions">
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $user['User']['id'])); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'controller' => 'users', 'action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
                    </span>
                </div>
            </td>
            <td class="column-name">
                <?php echo $this->Html->link($user['User']['firstname'], array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $user['User']['id'])); ?>
            </td>
            <td class="column-email">
                <?php echo $this->Html->link($user['User']['email'], 'mailto:' . $user['User']['email']); ?>
            </td>
            <td class="column-role">
                <?php echo $this->AdminLayout->userRole(h($user['User']['role'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="username" class="column-username column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('username'); ?>
            </th>
            <th id="name" class="column-name column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('firstname', 'Name'); ?>
            </th>
            <th id="email" class="column-email column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('email'); ?>
            </th>
            <th id="role" class="column-role column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('role'); ?>
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

