<?php echo $this->element('Installer/header', array('message' => __("Database configuration"))); ?>
<div class="row">
    <div class="col-lg-12">
        <?php
        echo $this->Form->create(
            'Installer',
            array(
                'class' => 'form-horizontal',
                'inputDefaults' => array(
                    'div' => false,
                    'label' => false
                )
            )
        );
        ?>
        <div class="form-group">
            <?php echo $this->Form->label(
                'database',
                __d('hurad', 'Database name'),
                array('class' => 'control-label col-lg-3')
            ); ?>
            <div class="col-lg-6">
                <?php echo $this->Form->input(
                    'database',
                    array('placeholder' => __d('hurad', 'Database name'), 'class' => 'form-control')
                ); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $this->Form->label(
                'login',
                __d('hurad', 'Database username'),
                array('class' => 'control-label col-lg-3')
            ); ?>
            <div class="col-lg-6">
                <?php echo $this->Form->input(
                    'login',
                    array('placeholder' => __d('hurad', 'Database username'), 'class' => 'form-control')
                ); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $this->Form->label(
                'password',
                __d('hurad', 'Database password'),
                array('class' => 'control-label col-lg-3')
            ); ?>
            <div class="col-lg-6">
                <?php echo $this->Form->input(
                    'password',
                    array('placeholder' => __d('hurad', 'Database password'), 'class' => 'form-control')
                ); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $this->Form->label(
                'host',
                __d('hurad', 'Database host'),
                array('class' => 'control-label col-lg-3')
            ); ?>
            <div class="col-lg-6">
                <?php
                echo $this->Form->input(
                    'host',
                    array(
                        'placeholder' => __d('hurad', 'Database host'),
                        'value' => 'localhost',
                        'class' => 'form-control'
                    )
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $this->Form->label(
                'prefix',
                __d('hurad', 'Tables prefix'),
                array('class' => 'control-label col-lg-3')
            ); ?>
            <div class="col-lg-6">
                <?php
                echo $this->Form->input(
                    'prefix',
                    array(
                        'placeholder' => __d('hurad', 'Tables prefix'),
                        'value' => 'hr_',
                        'class' => 'form-control'
                    )
                );
                ?>
            </div>
        </div>
        <?php echo $this->Form->button(
            __d('hurad', 'Install Database'),
            array('type' => 'submit', 'class' => 'btn btn-primary')
        ); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>