<?php echo $this->element('Installer/header', array('message' => __("Database configuration"))); ?>
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
        <?php if (empty($contentFile)) { ?>
            <div class="form-group<?php echo $this->Form->isFieldError('database') ? ' has-error' : ''; ?>">
                <?php echo $this->Form->label(
                    'database',
                    __d('hurad', 'Database name'),
                    ['class' => 'control-label col-lg-3']
                ); ?>
                <div class="col-lg-6">
                    <?php echo $this->Form->input(
                        'database',
                        [
                            'error' => [
                                'attributes' => [
                                    'wrap' => 'span',
                                    'class' => 'help-block'
                                ]
                            ],
                            'placeholder' => __d('hurad', 'Database name'),
                            'class' => 'form-control',
                            'required' => false
                        ]
                    ); ?>
                </div>
            </div>
            <div class="form-group<?php echo $this->Form->isFieldError('login') ? ' has-error' : ''; ?>">
                <?php echo $this->Form->label(
                    'login',
                    __d('hurad', 'Database username'),
                    ['class' => 'control-label col-lg-3']
                ); ?>
                <div class="col-lg-6">
                    <?php echo $this->Form->input(
                        'login',
                        [
                            'error' => [
                                'attributes' => [
                                    'wrap' => 'span',
                                    'class' => 'help-block'
                                ]
                            ],
                            'placeholder' => __d('hurad', 'Database username'),
                            'class' => 'form-control',
                            'required' => false
                        ]
                    ); ?>
                </div>
            </div>
            <div class="form-group<?php echo $this->Form->isFieldError('password') ? ' has-error' : ''; ?>">
                <?php echo $this->Form->label(
                    'password',
                    __d('hurad', 'Database password'),
                    ['class' => 'control-label col-lg-3']
                ); ?>
                <div class="col-lg-6">
                    <?php echo $this->Form->input(
                        'password',
                        [
                            'error' => [
                                'attributes' => [
                                    'wrap' => 'span',
                                    'class' => 'help-block'
                                ]
                            ],
                            'placeholder' => __d('hurad', 'Database password'),
                            'class' => 'form-control',
                            'required' => false
                        ]
                    ); ?>
                </div>
            </div>
            <div class="form-group<?php echo $this->Form->isFieldError('host') ? ' has-error' : ''; ?>">
                <?php echo $this->Form->label(
                    'host',
                    __d('hurad', 'Database host'),
                    ['class' => 'control-label col-lg-3']
                ); ?>
                <div class="col-lg-6">
                    <?php
                    echo $this->Form->input(
                        'host',
                        [
                            'error' => [
                                'attributes' => [
                                    'wrap' => 'span',
                                    'class' => 'help-block'
                                ]
                            ],
                            'placeholder' => __d('hurad', 'Database host'),
                            'value' => 'localhost',
                            'class' => 'form-control',
                            'required' => false
                        ]
                    );
                    ?>
                </div>
            </div>
            <div class="form-group<?php echo $this->Form->isFieldError('prefix') ? ' has-error' : ''; ?>">
                <?php echo $this->Form->label(
                    'prefix',
                    __d('hurad', 'Tables prefix'),
                    ['class' => 'control-label col-lg-3']
                ); ?>
                <div class="col-lg-6">
                    <?php
                    echo $this->Form->input(
                        'prefix',
                        [
                            'error' => [
                                'attributes' => [
                                    'wrap' => 'span',
                                    'class' => 'help-block'
                                ]
                            ],
                            'placeholder' => __d('hurad', 'Tables prefix'),
                            'value' => 'hr_',
                            'class' => 'form-control',
                            'required' => false
                        ]
                    );
                    ?>
                </div>
            </div>
        <?php } else { ?>
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
        <?php } ?>
        <?php echo $this->Form->button(
            __d('hurad', 'Install Database'),
            ['type' => 'submit', 'class' => 'btn btn-primary']
        ); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>