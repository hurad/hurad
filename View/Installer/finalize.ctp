<?php echo $this->element('Installer/header', array('message' => __("Hurad configuration"))); ?>
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
    <?php echo $this->Form->label('title', __d('hurad', 'Weblog Title'), array('class' => 'control-label col-lg-3')); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'title',
            array('placeholder' => __d('hurad', 'Weblog Title'), 'class' => 'form-control')
        ); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->label(
        'username',
        __d('hurad', 'Admin Username'),
        array('class' => 'control-label col-lg-3')
    ); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'username',
            array('placeholder' => __d('hurad', 'Admin Username'), 'class' => 'form-control')
        ); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->label('password', __d('hurad', 'Password'), array('class' => 'control-label col-lg-3')); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'password',
            array('placeholder' => __d('hurad', 'Password'), 'class' => 'form-control')
        ); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->label(
        'confirm_password',
        __d('hurad', 'Confirm Password'),
        array('class' => 'control-label col-lg-3')
    ); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'confirm_password',
            array('type' => 'password', 'placeholder' => __d('hurad', 'Confirm Password'), 'class' => 'form-control')
        ); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->label('email', __d('hurad', 'Email'), array('class' => 'control-label col-lg-3')); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'email',
            array('placeholder' => __d('hurad', 'Email'), 'class' => 'form-control')
        ); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-lg-6">
        <?php echo $this->Form->button(
            __d('hurad', 'Finish :)'),
            array('type' => 'submit', 'class' => 'btn btn-primary')
        ); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
