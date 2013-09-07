<?php $this->Html->script(array('admin/checkbox'), array('block' => 'scriptHeader')); ?>

    <div class="page-header">
        <h2><?php echo $title_for_layout; ?></h2>
    </div>

<?php
echo $this->Form->create(
    'User',
    array(
        'url' => array(
            'admin' => true,
            'controller' => 'users',
            'action' => 'process'
        ),
        'class' => 'form-inline',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

    <table class="table table-striped">
        <thead>
        <?php
        echo $this->Html->tableHeaders(
            array(
                array(
                    $this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                    array(
                        'id' => 'cb',
                        'class' => 'column-cb check-column column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('username', __d('hurad', 'Username')) => array(
                        'id' => 'username',
                        'class' => 'column-username column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('firstname', __d('hurad', 'Name')) => array(
                        'id' => 'name',
                        'class' => 'column-name column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('email', __d('hurad', 'e-Mail')) => array(
                        'id' => 'email',
                        'class' => 'column-email column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('role', __d('hurad', 'Role')) => array(
                        'id' => 'role',
                        'class' => 'column-role column-manage',
                        'scope' => 'col'
                    )
                )
            )
        );
        ?>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <?php $this->Author->setAuthor($user['User']['id']); ?>
            <?php
            echo $this->Html->tableCells(
                array(
                    array(
                        array(
                            $this->Form->checkbox('User.' . $user['User']['id'] . '.id'),
                            array(
                                'class' => 'check-column',
                                'scope' => 'row'
                            )
                        ),
                        array(
                            $this->Gravatar->image(
                                $this->Author->getTheAuthorMeta('email'),
                                array('size' => '32', 'default' => 'mm', 'echo' => false)
                            ) . $this->Html->link(
                                '<strong>' . $this->Author->getTheAuthorMeta('username') . '</strong>',
                                array(
                                    'admin' => true,
                                    'controller' => 'users',
                                    'action' => 'profile',
                                    $user['User']['id']
                                ),
                                array('escape' => false)
                            ) . $this->element('admin/Users/row_actions', array('user' => $user)),
                            array(
                                'class' => 'column-username'
                            )
                        ),
                        array(
                            $this->Html->link(
                                $this->Author->getTheAuthor(),
                                array(
                                    'admin' => true,
                                    'controller' => 'users',
                                    'action' => 'profile',
                                    $user['User']['id']
                                )
                            ),
                            array(
                                'class' => 'column-name'
                            )
                        ),
                        array(
                            $this->Html->link(
                                $this->Author->getTheAuthorMeta('email'),
                                'mailto:' . $this->Author->getTheAuthorMeta('email')
                            ),
                            array(
                                'class' => 'column-email'
                            )
                        ),
                        array(
                            $this->AdminLayout->userRole(h($user['User']['role'])),
                            array(
                                'class' => 'column-role'
                            )
                        )
                    ),
                ),
                array(
                    'id' => 'user-' . $user['User']['id']
                ),
                array(
                    'id' => 'user-' . $user['User']['id']
                )
            );
            ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <?php
        echo $this->Html->tableHeaders(
            array(
                array(
                    $this->Form->checkbox('', array('class' => 'check-all', 'name' => false, 'hiddenField' => false)) =>
                    array(
                        'id' => 'cb',
                        'class' => 'column-cb check-column column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('username', __d('hurad', 'Username')) => array(
                        'id' => 'username',
                        'class' => 'column-username column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('firstname', __d('hurad', 'Name')) => array(
                        'id' => 'name',
                        'class' => 'column-name column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('email', __d('hurad', 'e-Mail')) => array(
                        'id' => 'email',
                        'class' => 'column-email column-manage',
                        'scope' => 'col'
                    )
                ),
                array(
                    $this->Paginator->sort('role', __d('hurad', 'Role')) => array(
                        'id' => 'role',
                        'class' => 'column-role column-manage',
                        'scope' => 'col'
                    )
                )
            )
        );
        ?>
        </tfoot>
    </table>

    <section class="bottom-table">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?php
                    echo $this->Form->input(
                        'User.action',
                        array(
                            'label' => false,
                            'options' => array(
                                'delete' => __d('hurad', 'Delete')
                            ),
                            'empty' => __d('hurad', 'Bulk Actions'),
                            'class' => 'form-control'
                        )
                    );
                    ?>
                </div>
                <?php
                echo $this->Form->submit(
                    __d('hurad', 'Apply'),
                    array('type' => 'submit', 'class' => 'btn btn-info', 'div' => false)
                );
                ?>
            </div>
            <div class="col-md-8"><?php echo $this->element('admin/paginator'); ?></div>
        </div>
    </section>

<?php echo $this->Form->end(null); ?>