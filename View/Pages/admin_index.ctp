<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => FALSE)); ?>

<h2><?php echo $title_for_layout; ?></h2>

<?php
$allpages = ClassRegistry::init('Page')->count_pages();
$publishpages = ClassRegistry::init('Page')->count_pages('publish');
$draftpages = ClassRegistry::init('Page')->count_pages('draft');
$trashpages = ClassRegistry::init('Page')->count_pages('trash');
?>
<div class="table-filter-search">
    <div class="filter">
        <ul class="subsubsub">
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

    <div class="search-box">
        <?php echo $this->element('admin/search_pages'); ?>
    </div>
</div>


<?php
echo $this->Form->create('Page', array('url' =>
    array('admin' => TRUE, 'controller' => 'pages', 'action' => 'process'),
    'inputDefaults' =>
    array('label' => false, 'div' => false)));
?>
<table class="list-table">
    <thead>
        <tr>
            <th id="cb" class="column-cb column-manage" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="title" class="column-title column-manage" scope="col">
                <?php echo $this->Paginator->sort('title'); ?>
            </th>
            <th id="author" class="column-author column-manage" scope="col">
                <?php echo $this->Paginator->sort('User.username', 'Author'); ?>
            </th>
            <th id="status" class="column-status column-manage" scope="col">
                <?php echo $this->Paginator->sort('status'); ?>
            </th>
            <th id="comment_count" class="column-comment_count column-manage" scope="col">
                <?php echo $this->Paginator->sort('comment_count'); ?>
            </th>
            <th id="date" class="column-date column-manage" scope="col">
                <?php echo $this->Paginator->sort('created'); ?>
            </th>
        </tr>
    </thead>
    <?php foreach ($pages as $page): ?>
        <tr id="<?php echo h($page['Page']['id']); ?>" class="post-<?php echo h($page['Page']['id']); ?>">
            <td class="check-column" scope="row">
                <?php echo $this->Form->checkbox('Page.' . $page['Page']['id'] . '.id'); ?>
            </td>
            <td class="column-title">
                <?php echo $this->Html->link(h($page['Page']['title']), array('action' => 'edit', $page['Page']['id'])); ?>&nbsp;
                <div class="row-actions">
                    <span class="action-view">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $page['Page']['id'])); ?> | 
                    </span>
                    <span class="action-edit">
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'action' => 'edit', $page['Page']['id'])); ?> | 
                    </span>                 
                    <span class="action-delete">
                        <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', $page['Page']['id']), null, __('Are you sure you want to delete "%s"?', $page['Page']['title'])); ?>
                    </span>
                </div>
            </td>
            <td class="column-author">
                <?php echo $this->Html->link($page['User']['username'], array('controller' => 'users', 'action' => 'view', $page['User']['id'])); ?>
            </td>
            <td class="column-status">
                <?php echo $this->AdminLayout->postStatus($page['Page']['status']); ?>&nbsp;
            </td>
            <td class="column-comment_count">
                <?php echo h($page['Page']['comment_count']); ?>&nbsp;
            </td>
            <td class="column-date">
                <?php echo h($page['Page']['created']); ?>&nbsp;
            </td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
        <tr>
            <th id="cb" class="column-cb column-manage check-column" scope="col">
                <?php echo $this->Form->checkbox('', array('onclick' => 'toggleChecked(this.checked)', 'name' => false, 'hiddenField' => false)); ?>
            </th>
            <th id="title" class="column-title column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('title'); ?>
            </th>
            <th id="author" class="column-author column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('User.username', 'Author'); ?>
            </th>
            <th id="status" class="column-status column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('status'); ?>
            </th>
            <th id="comment_count" class="column-comment_count column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('comment_count'); ?>
            </th>
            <th id="date" class="column-date column-manage check-column" scope="col">
                <?php echo $this->Paginator->sort('created'); ?>
            </th>
        </tr>
    </tfoot>
</table>
<div class="tablenav">
    <div class="actions">
        <?php
        echo $this->Form->input('Page.action', array(
            'label' => false,
            'options' => array(
                'publish' => __('Publish'),
                'draft' => __('Draft'),
                'delete' => __('Delete'),
                'trash' => __('Move to Trash'),
            ),
            'empty' => __('Bulk Actions'),
        ));
        echo $this->Form->submit(__('Apply'), array('class' => 'action_button', 'div' => FALSE));
        ?>
    </div>
    <div class="paging">
        <?php
        if ($this->Paginator->numbers()) {
            echo $this->Paginator->prev('« ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('Next') . ' »', array(), null, array('class' => 'next disabled'));
        }
        ?>
    </div>
    <div class="pageing_counter">
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total')
        ));
        ?>	
    </div>
</div>

