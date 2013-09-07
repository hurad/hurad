<div class="well installer">
    <?php echo $this->element('Installer/header', array('message' => __("Database configuration"))); ?>
    <div class="container">
        <div class="row">
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
            <div class="control-group">
                <?php echo $this->Form->label('database', __d('hurad', 'Database name'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('database', array('placeholder' => __d('hurad', 'Database name'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('login', __d('hurad', 'Database username'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('login', array('placeholder' => __d('hurad', 'Database username'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label(
                    'password',
                    __d('hurad', 'Database password'),
                    array('class' => 'control-label')
                ); ?>
                <div class="controls">
                    <?php echo $this->Form->input('password', array('placeholder' => __d('hurad', 'Database password'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('host', __d('hurad', 'Database host'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $this->Form->input(
                        'host',
                        array(
                            'placeholder' => __d('hurad', 'Database host'),
                            'value' => 'localhost'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('prefix', __d('hurad', 'Tables prefix'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $this->Form->input(
                        'prefix',
                        array(
                            'placeholder' => __d('hurad', 'Tables prefix'),
                            'value' => 'hr_'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $this->Form->button(
                        __d('hurad', 'Install Database'),
                        array('type' => 'submit', 'class' => 'btn btn-primary')
                    ); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>