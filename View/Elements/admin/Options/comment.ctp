<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Option',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        ),
        'url' => array(
            'controller' => 'options',
            'action' => 'prefix',
            $prefix,
        )
    )
);
?>

<fieldset>
    <legend><?php echo __d('hurad', 'Avatar Display'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio">
                <?php
                echo $this->Form->radio(
                    'show_avatars',
                    array(
                        '0' => __d('hurad', 'Don’t show Avatars'),
                        '1' => __d('hurad', 'Show Avatars')
                    ),
                    array(
                        'legend' => false,
                        //'label' => FALSE
                    )
                );
                ?>
            </label>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo __d('hurad', 'Maximum Rating'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingG">
                <?php
                echo $this->Form->input(
                    'avatar_rating',
                    array(
                        'options' => array(
                            'G' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo __d('hurad', 'G &mdash; Suitable for all audiences');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingPG">
                <?php
                echo $this->Form->input(
                    'avatar_rating',
                    array(
                        'options' => array(
                            'PG' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo __d('hurad', 'PG &mdash; Possibly offensive, usually for audiences 13 and above');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingR">
                <?php
                echo $this->Form->input(
                    'avatar_rating',
                    array(
                        'options' => array(
                            'R' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo __d('hurad', 'R &mdash; Intended for adult audiences above 17');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingX">
                <?php
                echo $this->Form->input(
                    'avatar_rating',
                    array(
                        'options' => array(
                            'X' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo __d('hurad', 'X &mdash; Even more mature than above');
                ?>
            </label>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend><?php echo __d('hurad', 'Default Avatar'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultMystery">
                <?php
                echo $this->Form->input(
                    'avatar_default',
                    array(
                        'options' => array(
                            'mystery' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo '&nbsp;' . $this->Html->image(
                        'http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D32&amp;r=G&amp;forcedefault=1',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                echo '&nbsp;' . __d('hurad', 'Mystery Man');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultBlank">
                <?php
                echo $this->Form->input(
                    'avatar_default',
                    array(
                        'options' => array(
                            'blank' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo '&nbsp;' . $this->Html->image(
                        'http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=http%3A%2F%2Fdemo.opensourcecms.com%2Fwordpress%2Fwp-includes%2Fimages%2Fblank.gif&amp;r=G&amp;forcedefault=1',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                echo '&nbsp;' . __d('hurad', 'Blank');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultGravatarDefault">
                <?php
                echo $this->Form->input(
                    'avatar_default',
                    array(
                        'options' => array(
                            'gravatar_default' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo '&nbsp;' . $this->Html->image(
                        'http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=&amp;r=G&amp;forcedefault=1',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                echo '&nbsp;' . __d('hurad', 'Gravatar Logo');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultIdenticon">
                <?php
                echo $this->Form->input(
                    'avatar_default',
                    array(
                        'options' => array(
                            'identicon' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo '&nbsp;' . $this->Html->image(
                        'http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=identicon&amp;r=G&amp;forcedefault=1',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                echo '&nbsp;' . __d('hurad', 'Identicon (Generated)');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultWavatar">
                <?php
                echo $this->Form->input(
                    'avatar_default',
                    array(
                        'options' => array(
                            'wavatar' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo '&nbsp;' . $this->Html->image(
                        'http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=wavatar&amp;r=G&amp;forcedefault=1',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                echo '&nbsp;' . __d('hurad', 'Wavatar (Generated)');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultMonsterid">
                <?php
                echo $this->Form->input(
                    'avatar_default',
                    array(
                        'options' => array(
                            'monsterid' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo '&nbsp;' . $this->Html->image(
                        'http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=monsterid&amp;r=G&amp;forcedefault=1',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                echo '&nbsp;' . __d('hurad', 'MonsterID (Generated)');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultRetro">
                <?php
                echo $this->Form->input(
                    'avatar_default',
                    array(
                        'options' => array(
                            'retro' => ''
                        ),
                        'type' => 'radio',
                        'label' => false,
                        'hiddenField' => false
                    )
                );
                echo '&nbsp;' . $this->Html->image(
                        'http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=retro&amp;r=G&amp;forcedefault=1',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                echo '&nbsp;' . __d('hurad', 'Retro (Generated)');
                ?>
            </label>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <?php echo $this->Form->button(__d('hurad', 'Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>