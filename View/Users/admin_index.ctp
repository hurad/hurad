<?php $this->Html->script(array('admin/checkbox'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create('User', array(
    'url' => array(
        'admin' => TRUE,
        'controller' => 'users',
        'action' => 'process'
    ),
    'class' => 'form-inline',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<table class="table table-stripede">
    <thead>
        <?php
        echo $this->Html->tableHeaders(array(
            array($this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('username', __('Username')) => array(
                    'id' => 'username',
                    'class' => 'column-username column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('firstname', __('Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('email', __('e-Mail')) => array(
                    'id' => 'email',
                    'class' => 'column-email column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('role', __('Role')) => array(
                    'id' => 'role',
                    'class' => 'column-role column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </thead>
    <?php foreach ($users as $user): ?>
        <?php $this->Author->setAuthor($user['User']['id']); ?>
        <tbody>
            <?php
            echo $this->Html->tableCells(array(
                array(
                    array($this->Form->checkbox('Link.' . $user['User']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row')
                    ),
                    array($this->Gravatar->image($this->Author->getTheAuthorMeta('email'), array('size' => '32', 'default' => 'mm')) . $this->Html->link('<strong>' . $this->Author->getTheAuthorMeta('username') . '</strong>', array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $user['User']['id']), array('escape' => FALSE)) . $this->element('admin/Users/row_actions', array('user' => $user)),
                        array(
                            'class' => 'column-username'
                        )
                    ),
                    array($this->Html->link($this->Author->getTheAuthor(), array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $user['User']['id'])),
                        array(
                            'class' => 'column-name'
                        )
                    ),
                    array($this->Html->link($this->Author->getTheAuthorMeta('email'), 'mailto:' . $this->Author->getTheAuthorMeta('email')),
                        array(
                            'class' => 'column-email'
                        )
                    ),
                    array($this->AdminLayout->userRole(h($user['User']['role'])),
                        array(
                            'class' => 'column-role'
                        )
                    )
                ),
                    ), array(
                'id' => 'user-' . $user['User']['id']
                    ), array(
                'id' => 'user-' . $user['User']['id']
                    )
            );
            ?>
        </tbody>
    <?php endforeach; ?>
    <tfoot>
        <?php
        echo $this->Html->tableHeaders(array(
            array($this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                array(
                    'id' => 'cb',
                    'class' => 'column-cb check-column column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('username', __('Username')) => array(
                    'id' => 'username',
                    'class' => 'column-username column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('firstname', __('Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('email', __('e-Mail')) => array(
                    'id' => 'email',
                    'class' => 'column-email column-manage',
                    'scope' => 'col'
                )
            ),
            array($this->Paginator->sort('role', __('Role')) => array(
                    'id' => 'role',
                    'class' => 'column-role column-manage',
                    'scope' => 'col'
                )
            )
        ));
        ?>
    </tfoot>
</table>

<section>
    <?php
    echo $this->Form->input('User.action', array(
        'label' => false,
        'options' => array(
            'delete' => __('Delete')
        ),
        'empty' => __('Bulk Actions'),
    ));
    echo $this->Form->button(__('Apply'), array('type' => 'submit', 'class' => 'btn btn-info', 'div' => FALSE));
    ?>
</section>