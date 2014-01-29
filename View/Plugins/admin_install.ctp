<div class="page-header">
    <h2>
        <?php echo $title_for_layout; ?>
    </h2>
</div>

<?php
echo $this->Form->create(
    'Plugins',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        ),
        'type' => 'file'
    )
);
?>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <?php echo $this->Form->file(
                'plugin',
                array(
                    'class' => 'form-control',
                    'placeholder' => __d('hurad', 'Select a plugin in zip Format')
                )
            ); ?>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <?php echo $this->Form->button(
                __d('hurad', 'Upload'),
                array('type' => 'submit', 'class' => 'btn btn-primary')
            ); ?>
        </div>
    </div>
</div>

<?php echo $this->Form->end(null); ?>

<section class="bottom-table">
    <div class="row">
        <div class="col-md-4">
            <!-- Bulk Actions -->
        </div>
        <div class="col-md-8"><!-- --></div>
    </div>
</section>
