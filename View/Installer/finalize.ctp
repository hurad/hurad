<div class="well installer">
    <?php echo $this->element('Installer/header', array('message' => __("Hurad configuration"))); ?>
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
                <?php echo $this->Form->label('title', __d('hurad', 'Weblog Title'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('title', array('placeholder' => __d('hurad', 'Weblog Title'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('username', __d('hurad', 'Admin Username'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('username', array('placeholder' => __d('hurad', 'Admin Username'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('password', __d('hurad', 'Password'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('password', array('placeholder' => __d('hurad', 'Password'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label(
                    'confirm_password',
                    __d('hurad', 'Confirm Password'),
                    array('class' => 'control-label')
                ); ?>
                <div class="controls">
                    <?php echo $this->Form->input(
                        'confirm_password',
                        array('type' => 'password', 'placeholder' => __d('hurad', 'Confirm Password'))
                    ); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('email', __d('hurad', 'Email'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('email', array('placeholder' => __d('hurad', 'Email'))); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $this->Form->button(
                        __d('hurad', 'Finish :)'),
                        array('type' => 'submit', 'class' => 'btn btn-primary')
                    ); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>