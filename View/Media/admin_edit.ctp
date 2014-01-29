<div class="page-header">
    <h2><?= $title_for_layout; ?></h2>
</div>

<?=
$this->Form->create(
    'Media',
    [
        'class' => 'form-horizontal',
        'inputDefaults' => [
            'label' => false,
            'div' => false
        ]
    ]
);
?>

<div class="form-group">
    <?=
    $this->Form->label(
        'title',
        __d('hurad', 'Tile'),
        ['class' => 'control-label col-lg-2']
    ); ?>
    <div class="col-lg-4">
        <?=
        $this->Form->input(
            'title',
            [
                'required' => false, //For disable HTML5 validation
                'class' => 'form-control'
            ]
        );
        ?>
    </div>
</div>

<div class="form-group">
    <?=
    $this->Form->label(
        'mime_type',
        __d('hurad', 'Mime type'),
        ['class' => 'control-label col-lg-2']
    ); ?>
    <div class="col-lg-4">
        <p class="form-control-static"><?= $this->data['Media']['mime_type'] ?></p>
    </div>
</div>

<div class="form-group">
    <?=
    $this->Form->label(
        'web_path',
        __d('hurad', 'Web address'),
        ['class' => 'control-label col-lg-2']
    ); ?>
    <div class="col-lg-4">
        <p class="form-control-static"><?=
            $this->Html->link(
                $this->data['Media']['original_name'],
                $this->data['Media']['web_path']
            ) ?></p>
    </div>
</div>

<div class="form-group">
    <?=
    $this->Form->label(
        'size',
        __d('hurad', 'File size'),
        ['class' => 'control-label col-lg-2']
    ); ?>
    <div class="col-lg-4">
        <p class="form-control-static"><?= CakeNumber::toReadableSize($this->data['Media']['size']) ?></p>
    </div>
</div>

<div class="form-group">
    <?=
    $this->Form->label(
        'description',
        __d('hurad', 'Description'),
        ['class' => 'control-label col-lg-2']
    ); ?>
    <div class="col-lg-4">
        <?=
        $this->Form->input(
            'description',
            [
                'required' => false, //For disable HTML5 validation
                'class' => 'form-control'
            ]
        );
        ?>
    </div>
</div>

<?= $this->Form->button(__d('hurad', 'Update'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

<?= $this->Form->end(); ?>