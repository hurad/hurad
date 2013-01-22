<?php
$allcomments = ClassRegistry::init('Comment')->count_comments();
$moderatedcomments = ClassRegistry::init('Comment')->count_comments('moderated');
$approvedcomments = ClassRegistry::init('Comment')->count_comments('approved');
$spamcomments = ClassRegistry::init('Comment')->count_comments('spam');
$trashcomments = ClassRegistry::init('Comment')->count_comments('trash');
?>
<div class="filter">
    <ul class="sub-filter">
        <li>
            <?php
            if ($url == "admin/comments" || $url == "admin/comments/filter") {
                echo $this->Html->link(__('All ') . $this->Html->tag('span', '(' . $allcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'index'), array('class' => 'current', 'escape' => false));
            } else {
                echo $this->Html->link(__('All ') . $this->Html->tag('span', '(' . $allcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'index'), array('escape' => false));
            }
            ?>
        </li>
        <?php
        if ($moderatedcomments) {
            ?>
            |
            <li>
                <?php
                if (stripos($url, "admin/comments/filter/moderated") !== false) {
                    echo $this->Html->link(__('Pending ') . $this->Html->tag('span', '(' . $moderatedcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'moderated'), array('class' => 'current', 'escape' => false));
                } else {
                    echo $this->Html->link(__('Pending ') . $this->Html->tag('span', '(' . $moderatedcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'moderated'), array('escape' => false));
                }
                ?>
            </li>
            <?php
        }
        ?>
        <?php
        if ($approvedcomments) {
            ?>
            |
            <li>
                <?php
                if (stripos($url, "admin/comments/filter/approved") !== false) {
                    echo $this->Html->link(__('Approved ') . $this->Html->tag('span', '(' . $approvedcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'approved'), array('class' => 'current', 'escape' => false));
                } else {
                    echo $this->Html->link(__('Approved ') . $this->Html->tag('span', '(' . $approvedcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'approved'), array('escape' => false));
                }
                ?>
            </li>
            <?php
        }
        ?>
        <?php
        if ($spamcomments) {
            ?>
            |
            <li>
                <?php
                if (stripos($url, "admin/comments/filter/spam") !== false) {
                    echo $this->Html->link(__('Spam ') . $this->Html->tag('span', '(' . $spamcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'spam'), array('class' => 'current', 'escape' => false));
                } else {
                    echo $this->Html->link(__('Spam ') . $this->Html->tag('span', '(' . $spamcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'spam'), array('escape' => false));
                }
                ?>
            </li>
            <?php
        }
        ?>
        <?php
        if ($trashcomments) {
            ?>
            |
            <li>
                <?php
                if (stripos($url, "admin/comments/filter/trash") !== false) {
                    echo $this->Html->link(__('Trash ') . $this->Html->tag('span', '(' . $trashcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'trash'), array('class' => 'current', 'escape' => false));
                } else {
                    echo $this->Html->link(__('Trash ') . $this->Html->tag('span', '(' . $trashcomments . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'trash'), array('escape' => false));
                }
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
</div>