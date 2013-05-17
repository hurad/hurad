<ul class="nav nav-pills">
    <?php
    if ($url == "admin/comments") {
        echo $this->Html->tag('li', NULL, array('class' => 'active'));
        echo $this->Html->link(__('All ') . $this->Html->tag('span', $countComments['all'], array('class' => 'badge')), array('admin' => TRUE, 'action' => 'index'), array('escape' => false));
    } else {
        echo $this->Html->tag('li', NULL);
        echo $this->Html->link(__('All ') . $this->Html->tag('span', $countComments['all'], array('class' => 'badge')), array('admin' => TRUE, 'action' => 'index'), array('escape' => false));
    }

    if ($countComments['moderated']) {
        if (stripos($url, "admin/comments/index/moderated") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(__('Pending ') . $this->Html->tag('span', $countComments['moderated'], array('class' => 'badge badge-info')), array('admin' => TRUE, 'action' => 'index', 'moderated'), array('escape' => false));
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(__('Pending ') . $this->Html->tag('span', $countComments['moderated'], array('class' => 'badge badge-info')), array('admin' => TRUE, 'action' => 'index', 'moderated'), array('escape' => false));
        }
    }

    if ($countComments['approved']) {
        if (stripos($url, "admin/comments/index/approved") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(__('Approved ') . $this->Html->tag('span', $countComments['approved'], array('class' => 'badge badge-success')), array('admin' => TRUE, 'action' => 'index', 'approved'), array('escape' => false));
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(__('Approved ') . $this->Html->tag('span', $countComments['approved'], array('class' => 'badge badge-success')), array('admin' => TRUE, 'action' => 'index', 'approved'), array('escape' => false));
        }
    }

    if ($countComments['spam']) {
        if (stripos($url, "admin/comments/index/spam") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(__('Spam ') . $this->Html->tag('span', $countComments['spam'], array('class' => 'badge badge-warning')), array('admin' => TRUE, 'action' => 'index', 'spam'), array('class' => 'current', 'escape' => false));
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(__('Spam ') . $this->Html->tag('span', $countComments['spam'], array('class' => 'badge badge-warning')), array('admin' => TRUE, 'action' => 'index', 'spam'), array('escape' => false));
        }
    }

    if ($countComments['trash']) {
        if (stripos($url, "admin/comments/index/trash") !== false) {
            echo $this->Html->tag('li', NULL, array('class' => 'active'));
            echo $this->Html->link(__('Trash ') . $this->Html->tag('span', $countComments['trash'], array('class' => 'label label-important')), array('admin' => TRUE, 'action' => 'index', 'trash'), array('class' => 'current', 'escape' => false));
        } else {
            echo $this->Html->tag('li', NULL);
            echo $this->Html->link(__('Trash ') . $this->Html->tag('span', $countComments['trash'], array('class' => 'label label-important')), array('admin' => TRUE, 'action' => 'index', 'trash'), array('escape' => false));
        }
    }
    ?>
</ul>