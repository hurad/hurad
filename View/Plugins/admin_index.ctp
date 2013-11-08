<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
    </h2>
</div>

<table class="table table-striped">
    <thead>
    <?php
    echo $this->Html->tableHeaders(
        array(
            array(
                $this->Html->Link(__d('hurad', 'Name'), '#') => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Html->Link(__d('hurad', 'Description'), '#') => array(
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
    <?php foreach ($plugins as $alias => $plugin): ?>
        <?php
        echo $this->Html->tableCells(
            array(
                array(
                    array(
                        $plugin['name'] . $this->element('admin/Plugins/row_actions', array('alias' => $alias)),
                        array(
                            'class' => 'column-name'
                        )
                    ),
                    array(
                        $plugin['description'],
                        array(
                            'class' => 'column-description'
                        )
                    )
                ),
            ),
            array(
                'id' => 'plugin-' . $alias
            ),
            array(
                'id' => 'plugin-' . $alias
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
                $this->Html->Link(__d('hurad', 'Name'), '#') => array(
                    'class' => 'column-name column-manage',
                    'scope' => 'col'
                )
            ),
            array(
                $this->Html->Link(__d('hurad', 'Description'), '#') => array(
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
        <div class="col-md-8"><!-- --></div>
    </div>
</section>
