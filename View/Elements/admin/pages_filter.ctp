<?php
$allpages = ClassRegistry::init('Page')->count_pages();
$publishpages = ClassRegistry::init('Page')->count_pages('publish');
$draftpages = ClassRegistry::init('Page')->count_pages('draft');
$trashpages = ClassRegistry::init('Page')->count_pages('trash');
?>
<div class="filter">
    <ul class="sub-filter">
        <li>
            <?php
            if ($url == "admin/pages" || $url == "admin/pages/filter") {
                echo $this->Html->link(__('All ') . $this->Html->tag('span', '(' . $allpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'index'), array('class' => 'current', 'escape' => false));
            } else {
                echo $this->Html->link(__('All ') . $this->Html->tag('span', '(' . $allpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'index'), array('escape' => false));
            }
            ?>
        </li>
        <?php
        if ($publishpages) {
            ?>
            |
            <li>
                <?php
                if (stripos($url, "admin/pages/filter/publish") !== false) {
                    echo $this->Html->link(__('Published ') . $this->Html->tag('span', '(' . $publishpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'publish'), array('class' => 'current', 'escape' => false));
                } else {
                    echo $this->Html->link(__('Published ') . $this->Html->tag('span', '(' . $publishpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'publish'), array('escape' => false));
                }
                ?>
            </li>
            <?php
        }
        ?>
        <?php
        if ($draftpages) {
            ?>
            |
            <li>
                <?php
                if (stripos($url, "admin/pages/filter/draft") !== false) {
                    echo $this->Html->link(__('Draft ') . $this->Html->tag('span', '(' . $draftpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'draft'), array('class' => 'current', 'escape' => false));
                } else {
                    echo $this->Html->link(__('Draft ') . $this->Html->tag('span', '(' . $draftpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'draft'), array('escape' => false));
                }
                ?>
            </li>
            <?php
        }
        ?>
        <?php
        if ($trashpages) {
            ?>
            |
            <li>
                <?php
                if (stripos($url, "admin/pages/filter/trash") !== false) {
                    echo $this->Html->link(__('Trash ') . $this->Html->tag('span', '(' . $trashpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'trash'), array('class' => 'current', 'escape' => false));
                } else {
                    echo $this->Html->link(__('Trash ') . $this->Html->tag('span', '(' . $trashpages . ')', array('class' => 'count')), array('admin' => TRUE, 'action' => 'filter', 'trash'), array('escape' => false));
                }
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
</div>