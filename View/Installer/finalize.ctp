<?php echo $this->element('Installer/header', ['message' => __d('hurad', 'Hurad configuration')]); ?>
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
<div class="form-group<?php echo $this->Form->isFieldError('site_title') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label(
        'site_title',
        __d('hurad', 'Weblog Title'),
        ['class' => 'control-label col-lg-3']
    ); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'site_title',
            [
                'error' => [
                    'attributes' => [
                        'wrap' => 'span',
                        'class' => 'help-block'
                    ]
                ],
                'placeholder' => __d('hurad', 'Weblog Title'),
                'class' => 'form-control',
                'required' => false
            ]
        ); ?>
    </div>
</div>
<div class="form-group<?php echo $this->Form->isFieldError('site_username') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label(
        'site_username',
        __d('hurad', 'Admin Username'),
        ['class' => 'control-label col-lg-3']
    ); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'site_username',
            [
                'error' => [
                    'attributes' => [
                        'wrap' => 'span',
                        'class' => 'help-block'
                    ]
                ],
                'placeholder' => __d('hurad', 'Admin Username'),
                'class' => 'form-control',
                'required' => false
            ]
        ); ?>
    </div>
</div>
<div class="form-group<?php echo $this->Form->isFieldError('site_password') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label(
        'site_password',
        __d('hurad', 'Password'),
        ['class' => 'control-label col-lg-3']
    ); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'site_password',
            [
                'error' => [
                    'attributes' => [
                        'wrap' => 'span',
                        'class' => 'help-block'
                    ]
                ],
				'type' => 'password',
                'placeholder' => __d('hurad', 'Password'),
                'class' => 'form-control',
                'required' => false
            ]
        ); ?>
    </div>
</div>
<div class="form-group<?php echo $this->Form->isFieldError('site_confirm_password') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label(
        'site_confirm_password',
        __d('hurad', 'Confirm Password'),
        ['class' => 'control-label col-lg-3']
    ); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'site_confirm_password',
            [
                'error' => [
                    'attributes' => [
                        'wrap' => 'span',
                        'class' => 'help-block'
                    ]
                ],
                'type' => 'password',
                'placeholder' => __d('hurad', 'Confirm Password'),
                'class' => 'form-control',
                'required' => false
            ]
        ); ?>
    </div>
</div>
<div class="form-group<?php echo $this->Form->isFieldError('email') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label('email', __d('hurad', 'Email'), ['class' => 'control-label col-lg-3']); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->input(
            'email',
            [
                'error' => [
                    'attributes' => [
                        'wrap' => 'span',
                        'class' => 'help-block'
                    ]
                ],
                'placeholder' => __d('hurad', 'Email'),
                'class' => 'form-control',
                'type' => 'text',
                'required' => false
            ]
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
