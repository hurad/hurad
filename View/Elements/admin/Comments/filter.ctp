<ul class="nav nav-pills">
    <?php
    if ($url == "admin/comments") {
        echo $this->Html->tag('li', NULL, array('class' => 'active'));
        echo $this->Html->link(
            __d('hurad', 'All ') . $this->Html->tag('span', $count['all'], array('class' => 'badge')),
            array('admin' => TRUE, 'action' => 'index'),
            array('escape' => false)
        );
    } else {
        echo $this->Html->tag('li', NULL);
        echo $this->Html->link(
            __d('hurad', 'All ') . $this->Html->tag('span', $count['all'], array('class' => 'badge')),
            array('admin' => TRUE, 'action' => 'index'),
            array('escape' => false)
        );
    }

    if ($count['disapproved']) {
        if (stripos($url, "admin/comments/index/disapproved") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(
                __d('hurad', 'Pending ') . $this->Html->tag(
                    'span',
                    $count['disapproved'],
                    array('class' => 'badge badge-info')
                ),
                array('admin' => TRUE, 'action' => 'index', 'moderated'),
                array('escape' => false)
            );
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(
                __d('hurad', 'Pending ') . $this->Html->tag(
                    'span',
                    $count['disapproved'],
                    array('class' => 'badge badge-info')
                ),
                array('admin' => TRUE, 'action' => 'index', 'disapproved'),
                array('escape' => false)
            );
        }
    }

    if ($count['approved']) {
        if (stripos($url, "admin/comments/index/approved") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(
                __d('hurad', 'Approved ') . $this->Html->tag(
                    'span',
                    $count['approved'],
                    array('class' => 'badge badge-success')
                ),
                array('admin' => TRUE, 'action' => 'index', 'approved'),
                array('escape' => false)
            );
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(
                __d('hurad', 'Approved ') . $this->Html->tag(
                    'span',
                    $count['approved'],
                    array('class' => 'badge badge-success')
                ),
                array('admin' => TRUE, 'action' => 'index', 'approved'),
                array('escape' => false)
            );
        }
    }

    if ($count['spam']) {
        if (stripos($url, "admin/comments/index/spam") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(
                __d('hurad', 'Spam ') . $this->Html->tag(
                    'span',
                    $count['spam'],
                    array('class' => 'badge badge-warning')
                ),
                array('admin' => TRUE, 'action' => 'index', 'spam'),
                array('class' => 'current', 'escape' => false)
            );
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(
                __d('hurad', 'Spam ') . $this->Html->tag(
                    'span',
                    $count['spam'],
                    array('class' => 'badge badge-warning')
                ),
                array('admin' => TRUE, 'action' => 'index', 'spam'),
                array('escape' => false)
            );
        }
    }

    if ($count['trash']) {
        if (stripos($url, "admin/comments/index/trash") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(
                __d('hurad', 'Trash ') . $this->Html->tag(
                    'span',
                    $count['trash'],
                    array('class' => 'badge badge-important')
                ),
                array('admin' => TRUE, 'action' => 'index', 'trash'),
                array('class' => 'current', 'escape' => false)
            );
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(
                __d('hurad', 'Trash ') . $this->Html->tag(
                    'span',
                    $count['trash'],
                    array('class' => 'badge badge-important')
                ),
                array('admin' => TRUE, 'action' => 'index', 'trash'),
                array('escape' => false)
            );
        }
    }
    ?>
</ul>