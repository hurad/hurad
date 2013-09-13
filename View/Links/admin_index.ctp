<?php $this->Html->css(array('list-table', 'paging'), null, array('inline' => false)); ?>
<?php $this->Html->script(array('admin/Links/links', 'admin/checkbox'), array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<section class="top-table">
    <div class="row">
        <div class="col-md-8"><!-- --></div>
        <div class="col-md-4"><?php echo $this->element('admin/Links/search'); ?></div>
    </div>
</section>

<?php
echo $this->Form->create(
    'Link',
    array(
        'url' => array(
            'admin' => true,
            'controller' => 'links',
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
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'id' => 'title',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('url', __d('hurad', 'URL')) => array(
                    'id' => 'author',
                    'class' => 'column-url column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Menu.name', __d('hurad', 'Category')) => array(
                    'id' => 'menu',
                    'class' => 'column-menu column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('visible', __d('hurad', 'Visible')) => array(
                    'id' => 'visible',
                    'class' => 'column-visible column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('rating', __d('hurad', 'Rating')) => array(
                    'id' => 'rating',
                    'class' => 'column-rating column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </thead>
    <tbody>
    <?php global $link; ?>
    <?php foreach ($links as $link): ?>
        <?php
        echo $this->Html->tableCells(
            array(
                array(
                    array(
                        $this->Form->checkbox('Link.' . $link['Link']['id'] . '.id'),
                        array(
                            'class' => 'check-column',
                            'scope' => 'row'
                        )
                    ),
                    array(
                        $this->Html->link(
                            '<strong>' . h($link['Link']['name']) . '</strong>',
                            array('action' => 'edit', $link['Link']['id']),
                            array('title' => __d('hurad', 'Edit “%s”', $link['Link']['name']), 'escape' => false)
                        ) . $this->element('admin/Links/row_actions', array('link' => $link)),
                        array(
                            'class' => 'column-name'
                        )
                    ),
                    array(
                        $this->Html->link(
                            $this->AdminLayout->linkUrl($link['Link']['url']),
                            $link['Link']['url'],
                            array('target' => '_blank', 'title' => __d('hurad', 'Visit %s', $link['Link']['name']))
                        ),
                        array(
                            'class' => 'column-url'
                        )
                    ),
                    array(
                        $this->Html->link(
                            h($link['Menu']['name']),
                            array(
                                'admin' => true,
                                'controller' => 'links',
                                'action' => 'indexBymenu',
                                $link['Menu']['id']
                            )
                        ),
                        array(
                            'class' => 'column-menu'
                        )
                    ),
                    array(
                        $this->AdminLayout->linkVisible($link['Link']['visible']),
                        array(
                            'class' => 'column-visible'
                        )
                    ),
                    array(
                        $link['Link']['rating'],
                        array(
                            'class' => 'column-rating'
                        )
                    )
                ),
            ),
            array(
                'id' => 'link-' . $link['Link']['id']
            ),
            array(
                'id' => 'link-' . $link['Link']['id']
            )
        );
        ?>
    <?php endforeach; ?>
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
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'id' => 'title',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('url', __d('hurad', 'URL')) => array(
                    'id' => 'author',
                    'class' => 'column-url column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('Menu.name', __d('hurad', 'Category')) => array(
                    'id' => 'menu',
                    'class' => 'column-menu column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('visible', __d('hurad', 'Visible')) => array(
                    'id' => 'visible',
                    'class' => 'column-visible column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('rating', __d('hurad', 'Rating')) => array(
                    'id' => 'rating',
                    'class' => 'column-rating column-manage',
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
                    'Link.action.bot',
                    array(
                        'label' => false,
                        'options' => array(
                            'visible' => __d('hurad', 'Visible'),
                            'invisible' => __d('hurad', 'Invisible'),
                            'delete' => __d('hurad', 'Delete'),
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