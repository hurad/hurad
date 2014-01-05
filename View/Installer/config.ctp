<?php echo $this->element('Installer/header', array('message' => __d('hurad', 'Save database Configuration'))); ?>
<div class="row">
    <div class="col-lg-12">
        <?php
        echo $this->Form->create(
            'Installer',
            [
                'class' => 'form-horizontal',
                'inputDefaults' => [
                    'div' => false,
                    'label' => false
                ]
            ]
        );
        ?>
        <div class="form-group">
            <div class="col-lg-12">
                <?php echo $this->Form->input(
                    'content',
                    [
                        'class' => 'form-control',
                        'type' => 'textarea',
                        'rows' => '15',
                        'value' => $contentFile,
                    ]
                ); ?>
            </div>
        </div>
        <?php echo $this->Form->button(
            __d('hurad', 'Continue'),
            ['type' => 'submit', 'class' => 'btn btn-primary']
        ); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>