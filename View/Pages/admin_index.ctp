<?php $this->Html->css(array('admin/Pages/pages'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/Pages/pages', 'admin/checkbox'), array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(
            __d('hurad', 'Add New'),
            '/admin/pages/add',
            array('class' => 'btn btn-default btn-xs')
        ); ?>
    </h2>
</div>

<section class="top-table">
    <div class="row">
        <div class="col-md-8"><?php echo $this->element('admin/Pages/filter'); ?></div>
        <div class="col-md-4"><?php echo $this->element('admin/Pages/search'); ?></div>
    </div>
</section>

<?php
echo $this->Form->create(
    'Page',
    array(
        'url' => array(
            'admin' => true,
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
                $this->Paginator->sort('title', __d('hurad', 'Title')) => array(
                    'id' => 'title',
                    'class' => 'column-title column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('User.username', __d('hurad', 'Author')) => array(
                    'id' => 'author',
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('comment_count', __d('hurad', 'Comments')) => array(
                    'id' => 'comments',
                    'class' => 'column-comments column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('created', __d('hurad', 'Date')) => array(
                    'id' => 'date',
                    'class' => 'column-date column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </thead>
    <tbody>
    <?php
    if (count($pages) > 0) {
        foreach ($pages as $page) {
            $this->Page->setPage($page);
            echo $this->Html->tableCells(
                array(
                    array(
                        array(
                            $this->Form->checkbox('Page.' . $this->Page->getTheID() . '.id'),
                            array(
                                'class' => 'check-column',
                                'scope' => 'row'
                            )
                        ),
                        array(
                            $this->Html->link(
                                '<strong>' . h($this->Page->getTheTitle()) . '</strong>',
                                array(
                                    'action' => 'edit',
                                    $this->Page->getTheID()
                                ),
                                array(
                                    'title' => __d('hurad', 'Edit “%s”', $this->Page->getTheTitle()),
                                    'escape' => false
                                )
                            ) . $this->element('admin/Pages/row_actions', array('page' => $page)),
                            array(
                                'class' => 'column-title'
                            )
                        ),
                        array(
                            $this->Html->link(
                                $page['User']['username'],
                                array('controller' => 'pages', 'action' => 'listByauthor', $this->Page->getTheID())
                            ),
                            array(
                                'class' => 'column-author'
                            )
                        ),
                        array(
                            $this->Html->tag('span', $page['Page']['comment_count'], array('class' => 'badge')),
                            array(
                                'class' => 'column-comments'
                            )
                        ),
                        array(
                            $this->Html->tag(
                                'abbr',
                                $this->Page->getTheDate(),
                                array('title' => $page['Page']['created'])
                            ) . '<br>' . $this->AdminLayout->postStatus($page['Page']['status']),
                            array(
                                'class' => 'column-date'
                            )
                        )
                    ),
                ),
                array(
                    'id' => 'page-' . $this->Page->getTheID()
                ),
                array(
                    'id' => 'page-' . $this->Page->getTheID()
                )
            );
        }
    } else {
        echo $this->Html->tag(
            'tr',
            $this->Html->tag(
                'td',
                __d('hurad', 'No pages were found'),
                array('colspan' => '5', 'style' => 'text-align:center;')
            ),
            array('id' => 'post-0')
        );
    }
    ?>
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
                $this->Paginator->sort('title', __d('hurad', 'Title')) => array(
                    'id' => 'title',
                    'class' => 'column-title column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('User.username', __d('hurad', 'Author')) => array(
                    'id' => 'author',
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('comment_count', __d('hurad', 'Comments')) => array(
                    'id' => 'comments',
                    'class' => 'column-comments column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('created', __d('hurad', 'Date')) => array(
                    'id' => 'date',
                    'class' => 'column-date column-manage',
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
                    'Page.action.bot',
                    array(
                        'label' => false,
                        'options' => array(
                            'publish' => __d('hurad', 'Publish'),
                            'draft' => __d('hurad', 'Draft'),
                            'delete' => __d('hurad', 'Delete'),
                            'trash' => __d('hurad', 'Move to Trash'),
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