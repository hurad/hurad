<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<section class="top-table">
    <div class="row">
        <div class="col-md-6"><!-- Filter --></div>
        <div class="col-md-6"><!-- Search --></div>
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
                $this->Paginator->sort('link_count', __d('hurad', 'Link Count')) => array(
                    'id' => 'link-count',
                    'class' => 'column-link-count column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('description', __d('hurad', 'Description')) => array(
                    'id' => 'description',
                    'class' => 'column-description column-manage',
                    'scope' => 'col'
                )
            )
        )
    );
    ?>
    </thead>
    <tbody>
    <?php
    if (count($menus) > 0) {
        foreach ($menus as $menu) {
            echo $this->Html->tableCells(
                array(
                    array(
                        array(
                            $this->Html->link(
                                '<strong>' . h($menu['Menu']['name']) . '</strong>',
                                array('action' => 'edit', $menu['Menu']['id']),
                                array('title' => __d('hurad', 'Edit “%s”', $menu['Menu']['name']), 'escape' => false)
                            ) . $this->element('admin/Menus/row_actions', array('menu' => $menu)),
                            array(
                                'class' => 'column-name'
                            )
                        ),
                        array(
                            $menu['Menu']['slug'],
                            array(
                                'class' => 'column-slug'
                            )
                        ),
                        array(
                            $menu['Menu']['link_count'],
                            array(
                                'class' => 'column-link-count'
                            )
                        ),
                        array(
                            $menu['Menu']['description'],
                            array(
                                'class' => 'column-visible'
                            )
                        )
                    ),
                ),
                array(
                    'id' => 'menu-' . $menu['Menu']['id']
                ),
                array(
                    'id' => 'menu-' . $menu['Menu']['id']
                )
            );
        }
    } else {
        echo $this->Html->tag(
            'tr',
            $this->Html->tag(
                'td',
                __d('hurad', 'No menus were found'),
                array('colspan' => '5', 'style' => 'text-align:center;')
            ),
            array('id' => 'menu-0')
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
                $this->Paginator->sort('link_count', __d('hurad', 'Link Count')) => array(
                    'class' => 'column-link-count column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Paginator->sort('description', __d('hurad', 'Description')) => array(
                    'class' => 'column-description column-manage',
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
