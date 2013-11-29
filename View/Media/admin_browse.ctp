<?php $this->Html->script(array('admin/Media/media'), array('block' => 'scriptHeader')); ?>

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
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'id' => 'name',
                    'class' => 'column-name column-manage',
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
                $this->Paginator->sort('User.username', __d('hurad', 'User')) => array(
                    'id' => 'user',
                    'class' => 'column-user column-manage',
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
    <?php foreach ($media AS $file): ?>
        <?php
        echo $this->Html->tableCells(
            array(
                array(
                    array(
                        $this->Html->link(
                            '<strong>' . h($file['Media']['original_name']) . '</strong>',
                            array(
                                'action' => 'edit',
                                $file['Media']['id']
                            ),
                            array(
                                'title' => __d('hurad', 'Edit “%s”', $file['Media']['original_name']),
                                'escape' => false
                            )
                        ) . $this->element('admin/Media/row_actions', array('file' => $file)),
                        array(
                            'class' => 'column-name'
                        )
                    ),
                    array(
                        h($file['Media']['description']),
                        array(
                            'class' => 'column-description'
                        )
                    ),
                    array(
                        $file['User']['username'],
                        array(
                            'class' => 'column-user'
                        )
                    ),
                    array(
                        $file['Media']['created'],
                        array(
                            'class' => 'column-date'
                        )
                    )
                ),
            ),
            array(
                'id' => 'file-' . $file['Media']['id']
            ),
            array(
                'id' => 'file-' . $file['Media']['id']
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
                $this->Paginator->sort('name', __d('hurad', 'Name')) => array(
                    'class' => 'column-name column-manage',
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
                $this->Paginator->sort('User.username', __d('hurad', 'User')) => array(
                    'class' => 'column-user column-manage',
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
