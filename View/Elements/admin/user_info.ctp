<?php if ($logged_in): ?>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php echo $this->AdminLayout->currentUser(); ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><?php echo $this->Html->link(
                        $this->Html->tag('i', null, array('class' => 'glyphicon glyphicon-user')) . '</i>' . ' ' . __d(
                            'hurad',
                            'Profile'
                        ),
                        array(
                            'admin' => true,
                            'controller' => 'users',
                            'action' => 'profile',
                            $this->AdminLayout->currentUser('id')
                        ),
                        array('escape' => false)
                    ); ?>
                </li>
                <li class="divider"></li>
                <li><?php echo $this->Html->link(
                        $this->Html->tag('i', null, array('class' => 'glyphicon glyphicon-off')) . '</i>' . ' ' . __d(
                            'hurad',
                            'Logout'
                        ),
                        array('plugin' => null, 'admin' => false, 'controller' => 'users', 'action' => 'logout'),
                        array('escape' => false)
                    ); ?>
                </li>
            </ul>
    </ul>
<?php else: ?>
    <?php // ?>
<?php endif; ?>
