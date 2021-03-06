<?php
$allposts = ClassRegistry::init('Post')->countPosts();
$publishposts = ClassRegistry::init('Post')->countPosts('publish');
$draftposts = ClassRegistry::init('Post')->countPosts('draft');
$trashposts = ClassRegistry::init('Post')->countPosts('trash');
?>

<ul class="nav nav-pills">
    <?php
    if ($url == "admin/posts" || $url == "admin/posts/filter") {
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
        if (stripos($url, "admin/posts/filter/publish") !== false) {
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
        if (stripos($url, "admin/posts/filter/draft") !== false) {
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
            if (stripos($url, "admin/posts/filter/trash") !== false) {
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