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

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
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
            $this->Content->setContent($page, 'page');
            echo $this->Html->tableCells(
                array(
                    array(
                        array(
                            $this->Html->link(
                                '<strong>' . h($this->Content->getTitle()) . '</strong>',
                                array(
                                    'action' => 'edit',
                                    $this->Content->getId()
                                ),
                                array(
                                    'title' => __d('hurad', 'Edit “%s”', $this->Content->getTitle()),
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
                                array('controller' => 'pages', 'action' => 'listByauthor', $this->Content->getId())
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
                                $this->Content->getDate(),
                                array('title' => $page['Page']['created'])
                            ) . '<br>' . $this->AdminLayout->postStatus($page['Page']['status']),
                            array(
                                'class' => 'column-date'
                            )
                        )
                    ),
                ),
                array(
                    'id' => 'page-' . $this->Content->getId()
                ),
                array(
                    'id' => 'page-' . $this->Content->getId()
                )
            );
        }
    } else {
        echo $this->Html->tag(
            'tr',
            $this->Html->tag(
                'td',
                __d('hurad', 'No pages were found'),
                ['colspan' => '4', 'style' => 'text-align:center;']
            ),
            ['id' => 'page-0']
        );
    }
    ?>
    </tbody>
    <tfoot>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Paginator->sort('title', __d('hurad', 'Title')) => array(
                    'class' => 'column-title column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('User.username', __d('hurad', 'Author')) => array(
                    'class' => 'column-author column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('comment_count', __d('hurad', 'Comments')) => array(
                    'class' => 'column-comments column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('created', __d('hurad', 'Date')) => array(
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
            <!-- Bulk Actions -->
        </div>
        <div class="col-md-8"><?php echo $this->element('admin/paginator'); ?></div>
    </div>
</section>