<?php $this->Html->script(array('admin/Linkcats/linkcats', 'admin/checkbox'), array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
        <?php echo $this->Html->link(
            __d('hurad', 'Add New'),
            '/admin/linkcats/add',
            array('class' => 'btn btn-default btn-xs')
        ); ?>
    </h2>
</div>

<section class="top-table">
    <div class="row">
        <div class="col-md-8"><!-- --></div>
        <div class="col-md-4"><?php echo $this->element('admin/Linkcats/search'); ?></div>
    </div>
</section>

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('slug', __d('hurad', 'Slug')) => array(
                    'id' => 'slug',
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('description', __d('hurad', 'Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('link_count', __d('hurad', 'Links')) => array(
                    'id' => 'posts',
                    'class' => 'column-link_count column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </thead>
    <tbody>
    <?php
    if ($linkcats) {
        foreach ($linkcats as $linkcat):
            echo $this->Html->tableCells(
                array(
                    array(
                        array(
                            $this->Html->link(
                                h($linkcat['Linkcat']['name']),
                                array(
                                    'admin' => true,
                                    'controller' => 'linkcats',
                                    'action' => 'edit',
                                    $linkcat['Linkcat']['id']
                                )
                            ) . $this->element('admin/Linkcats/row_actions', array('linkcat' => $linkcat)),
                            array(
                                'class' => 'column-path'
                            )
                        ),
                        array(
                            h($linkcat['Linkcat']['slug']),
                            array(
                                'class' => 'column-slug'
                            )
                        ),
                        array(
                            h($linkcat['Linkcat']['description']),
                            array(
                                'class' => 'column-description'
                            )
                        ),
                        array(
                            h($linkcat['Linkcat']['link_count']),
                            array(
                                'class' => 'column-link_count'
                            )
                        )
                    ),
                ),
                array(
                    'id' => 'linkcat-' . $linkcat['Linkcat']['id']
                ),
                array(
                    'id' => 'linkcat-' . $linkcat['Linkcat']['id']
                )
            );
        endforeach;
    } else {
        echo $this->Html->tag(
            'tr',
            $this->Html->tag(
                'td',
                __d('hurad', 'No link category were found.'),
                ['colspan' => '4', 'style' => 'text-align:center;']
            ),
            ['id' => 'linkcat-0']
        );
    }
    ?>
    </tbody>
    <tfoot>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('slug', __d('hurad', 'Slug')) => array(
                    'class' => 'column-slug column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('description', __d('hurad', 'Description')) => array(
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('link_count', __d('hurad', 'Links')) => array(
                    'class' => 'column-link_count column-manage',
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
