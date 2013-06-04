<div class="well installer">
    <?php echo $this->element('Installer/header', array('message' => __("Hurad configuration"))); ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            echo $this->Form->create('Installer', array(
                'class' => 'form-horizontal',
                'inputDefaults' => array(
                    'div' => false,
                    'label' => false
                )
            ));
            ?>
            <div class="control-group">
                <?php echo $this->Form->label('title', __('Weblog Title'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('title', array('placeholder' => __('Weblog Title'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('username', __('Admin Username'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('username', array('placeholder' => __('Admin Username'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('password', __('Password'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('password', array('placeholder' => __('Password'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('confirm_password', __('Confirm Password'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('confirm_password', array('type' => 'password', 'placeholder' => __('Confirm Password'))); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $this->Form->label('email', __('Email'), array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $this->Form->input('email', array('placeholder' => __('Email'))); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $this->Form->button(__('Finish :)'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>