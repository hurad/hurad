<?php
$allposts = ClassRegistry::init('Page')->countPages();
$publishposts = ClassRegistry::init('Page')->countPages('publish');
$draftposts = ClassRegistry::init('Page')->countPages('draft');
$trashposts = ClassRegistry::init('Page')->countPages('trash');
?>

<ul class="nav nav-pills">
    <?php
    if ($url == "admin/posts" || $url == "admin/pages/filter") {
        echo $this->Html->tag('li', null, array('class' => 'active'));
        echo $this->Html->link(
            __d('hurad', 'All ') . $this->Html->tag('span', $allposts, array('class' => 'badge')),
            array('admin' => true, 'action' => 'index'),
            array('escape' => false)
        );
    } else {
        echo $this->Html->tag('li', null);
        echo $this->Html->link(
            __d('hurad', 'All ') . $this->Html->tag('span', $allposts, array('class' => 'badge')),
            array('admin' => true, 'action' => 'index'),
            array('escape' => false)
        );
    }
    ?>
    </li>
    <?php
    if ($publishposts) {
        ?>
        <?php
        if (stripos($url, "admin/pages/filter/publish") !== false) {
            echo $this->Html->tag('li', null, array('class' => 'active'));
            echo $this->Html->link(
                __d('hurad', 'Published ') . $this->Html->tag('span', $publishposts, array('class' => 'badge badge-success')),
                array('admin' => true, 'action' => 'filter', 'publish'),
                array('escape' => false)
            );
        } else {
            echo $this->Html->tag('li', null);
            echo $this->Html->link(
                __d('hurad', 'Published ') . $this->Html->tag('span', $publishposts, array('class' => 'badge badge-success')),
                array('admin' => true, 'action' => 'filter', 'publish'),
                array('escape' => false)
            );
        }
        ?>
        </li>
    <?php
    }
    ?>
    <?php
    if ($draftposts) {
        ?>
        <?php
        if (stripos($url, "admin/pages/filter/draft") !== false) {
            echo $this->Html->tag('li', null, array('class' => 'active'));
            echo $this->Html->link(
                __d('hurad', 'Draft ') . $this->Html->tag('span', $draftposts, array('class' => 'badge badge-warning')),
                array('admin' => true, 'action' => 'filter', 'draft'),
                array('escape' => false)
            );
        } else {
            echo $this->Html->tag('li', null);
            echo $this->Html->link(
                __d('hurad', 'Draft ') . $this->Html->tag('span', $draftposts, array('class' => 'badge badge-warning')),
                array('admin' => true, 'action' => 'filter', 'draft'),
                array('escape' => false)
            );
        }
        ?>
        </li>
    <?php
    }
    ?>
    <?php
    if ($trashposts) {
        ?>
        <li>
            <?php
            if (stripos($url, "admin/pages/filter/trash") !== false) {
                echo $this->Html->tag('li', null, array('class' => 'active'));
                echo $this->Html->link(
                    __d('hurad', 'Trash ') . $this->Html->tag('span', $trashposts, array('class' => 'badge badge-important')),
                    array('admin' => true, 'action' => 'filter', 'trash'),
                    array('escape' => false)
                );
            } else {
                echo $this->Html->tag('li', null);
                echo $this->Html->link(
                    __d('hurad', 'Trash ') . $this->Html->tag('span', $trashposts, array('class' => 'badge badge-important')),
                    array('admin' => true, 'action' => 'filter', 'trash'),
                    array('escape' => false)
                );
            }
            ?>
        </li>
    <?php
    }
    ?>
</ul>