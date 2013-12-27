<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Paginator->sort('username', __d('hurad', 'Username')) => array(
                    'id' => 'username',
                    'class' => 'column-username column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('first_name', __d('hurad', 'Name')) => array(
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
                        $this->Gravatar->image(
                            $this->Author->getAuthorMeta('email'),
                            array('size' => '32', 'default' => 'mm', 'echo' => false)
                        ) . $this->Html->link(
                            '<strong>' . $this->Author->getAuthorMeta('username') . '</strong>',
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
                            $this->Author->getAuthor(),
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
                            $this->Author->getAuthorMeta('email'),
                            'mailto:' . $this->Author->getAuthorMeta('email')
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
                $this->Paginator->sort('username', __d('hurad', 'Username')) => array(
                    'class' => 'column-username column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('first_name', __d('hurad', 'Name')) => array(
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('email', __d('hurad', 'e-Mail')) => array(
                    'class' => 'column-email column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('role', __d('hurad', 'Role')) => array(
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
            <!-- Bulk Actions -->
        </div>
        <div class="col-md-8"><?php echo $this->element('admin/paginator'); ?></div>
    </div>
</section>
