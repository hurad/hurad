<div class="well installer">
    <?php echo $this->element('Installer/header', array('message' => __("Database configuration"))); ?>
    <div class="container-fluid">
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
                <?php echo $this->Form->label('database', __('Database name'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('database', array('placeholder' => __('Database name'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('login', __('Database username'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('login', array('placeholder' => __('Database username'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label(
                    'password',
                    __('Database password'),
                    array('class' => 'control-label')
                ); ?>
                <div class="controls">
                    <?php echo $this->Form->input('password', array('placeholder' => __('Database password'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('host', __('Database host'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $this->Form->input(
                        'host',
                        array(
                            'placeholder' => __('Database host'),
                            'value' => 'localhost'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('prefix', __('Tables prefix'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $this->Form->input(
                        'prefix',
                        array(
                            'placeholder' => __('Tables prefix'),
                            'value' => 'hr_'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $this->Form->button(
                        __('Install Database'),
                        array('type' => 'submit', 'class' => 'btn btn-primary')
                    ); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>