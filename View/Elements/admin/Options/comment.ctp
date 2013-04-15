<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create('Option', array(
    'class' => 'form-horizontal',
    'inputDefaults' => array(
        'label' => false,
        'div' => false),
    'url' => array(
        'controller' => 'options',
        'action' => 'prefix',
        $prefix,
)));
?>

<fieldset>
    <legend><?php echo __('Avatar Display'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio">
            <?php
            echo $this->Form->radio('show_avatars', array(
                '0' => __('Don’t show Avatars'),
                '1' => __('Show Avatars')), array(
                'legend' => FALSE,
                        //'label' => FALSE
            ));
            ?>
            </label>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo __('Maximum Rating'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingG">
                <?php
                echo $this->Form->input('avatar_rating', array(
                    'options' => array(
                        'G' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo __('G &mdash; Suitable for all audiences');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingPG">
                <?php
                echo $this->Form->input('avatar_rating', array(
                    'options' => array(
                        'PG' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo __('PG &mdash; Possibly offensive, usually for audiences 13 and above');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingR">
                <?php
                echo $this->Form->input('avatar_rating', array(
                    'options' => array(
                        'R' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo __('R &mdash; Intended for adult audiences above 17');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarRatingX">
                <?php
                echo $this->Form->input('avatar_rating', array(
                    'options' => array(
                        'X' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo __('X &mdash; Even more mature than above');
                ?>
            </label>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend><?php echo __('Default Avatar'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultMystery">
                <?php
                echo $this->Form->input('avatar_default', array(
                    'options' => array(
                        'mystery' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D32&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                echo '&nbsp;' . __('Mystery Man');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultBlank">
                <?php
                echo $this->Form->input('avatar_default', array(
                    'options' => array(
                        'blank' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=http%3A%2F%2Fdemo.opensourcecms.com%2Fwordpress%2Fwp-includes%2Fimages%2Fblank.gif&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                echo '&nbsp;' . __('Blank');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultGravatarDefault">
                <?php
                echo $this->Form->input('avatar_default', array(
                    'options' => array(
                        'gravatar_default' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                echo '&nbsp;' . __('Gravatar Logo');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultIdenticon">
                <?php
                echo $this->Form->input('avatar_default', array(
                    'options' => array(
                        'identicon' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=identicon&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                echo '&nbsp;' . __('Identicon (Generated)');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultWavatar">
                <?php
                echo $this->Form->input('avatar_default', array(
                    'options' => array(
                        'wavatar' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=wavatar&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                echo '&nbsp;' . __('Wavatar (Generated)');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultMonsterid">
                <?php
                echo $this->Form->input('avatar_default', array(
                    'options' => array(
                        'monsterid' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=monsterid&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                echo '&nbsp;' . __('MonsterID (Generated)');
                ?>
            </label>
        </div>
        <div class="controls">
            <label class="radio" for="OptionAvatarDefaultRetro">
                <?php
                echo $this->Form->input('avatar_default', array(
                    'options' => array(
                        'retro' => ''
                    ),
                    'type' => 'radio',
                    'label' => FALSE,
                    'hiddenField' => false
                        )
                );
                echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=retro&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                echo '&nbsp;' . __('Retro (Generated)');
                ?>
            </label>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <?php echo $this->Form->button(__('Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>