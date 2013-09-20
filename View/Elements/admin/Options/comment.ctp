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
    <div class="form-group">
        <label class="control-label col-lg-2">
            <?php echo __d('hurad', 'Avatar Display'); ?>
        </label>

        <div class="col-lg-4">
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'show_avatars',
                        array(
                            '0' => __d('hurad', 'Don’t show Avatars'),
                        ),
                        array(
                            'label' => false
                        )
                    );
                    ?>
                </label>

            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'show_avatars',
                        array(
                            '1' => __d('hurad', 'Show Avatars')
                        ),
                        array(
                            'label' => false
                        )
                    );
                    ?>
                </label>
            </div>
        </div>
    </div>
</fieldset>
<fieldset>
    <div class="form-group">
        <label class="control-label col-lg-2">
            <?php echo __d('hurad', 'Maximum Rating'); ?>
        </label>

        <div class="col-lg-6">
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_rating',
                        array(
                            'G' => __d('hurad', 'G &mdash; Suitable for all audiences')
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_rating',
                        array(
                            'PG' => __d('hurad', 'PG &mdash; Possibly offensive, usually for audiences 13 and above')
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_rating',
                        array(
                            'R' => __d('hurad', 'R &mdash; Intended for adult audiences above 17')
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_rating',
                        array(
                            'X' => __d('hurad', 'X &mdash; Even more mature than above')
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    ?>
                </label>
            </div>
        </div>
    </div>
</fieldset>
<fieldset>
    <div class="form-group">
        <label class="control-label col-lg-2">
            <?php echo __d('hurad', 'Default Avatar'); ?>
        </label>

        <div class="col-lg-4">
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_default',
                        array(
                            'mystery' => ''
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    echo $this->Html->image(
                        'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&f=y&s=32',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                    echo '&nbsp;' . __d('hurad', 'Mystery Man');
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_default',
                        array(
                            'blank' => ''
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    echo $this->Html->image(
                        'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=blank&f=y&s=32',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                    echo '&nbsp;' . __d('hurad', 'Blank');
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_default',
                        array(
                            'gravatar_default' => ''
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    echo $this->Html->image(
                        'http://www.gravatar.com/avatar/00000000000000000000000000000000?f=y&s=32',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                    echo '&nbsp;' . __d('hurad', 'Gravatar Logo');
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_default',
                        array(
                            'identicon' => ''
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    echo $this->Html->image(
                        'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=identicon&f=y&s=32',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                    echo '&nbsp;' . __d('hurad', 'Identicon (Generated)');
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_default',
                        array(
                            'wavatar' => ''
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    echo $this->Html->image(
                        'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=wavatar&f=y&s=32',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                    echo '&nbsp;' . __d('hurad', 'Wavatar (Generated)');
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_default',
                        array(
                            'monsterid' => ''
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    echo $this->Html->image(
                        'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=monsterid&f=y&s=32',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                    echo '&nbsp;' . __d('hurad', 'MonsterID (Generated)');
                    ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php
                    echo $this->Form->radio(
                        'avatar_default',
                        array(
                            'retro' => ''
                        ),
                        array(
                            'label' => false,
                        )
                    );
                    echo $this->Html->image(
                        'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=retro&f=y&s=32',
                        array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo')
                    );
                    echo '&nbsp;' . __d('hurad', 'Retro (Generated)');
                    ?>
                </label>
            </div>
        </div>
    </div>
</fieldset>

<?php echo $this->Form->button(__d('hurad', 'Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>

<?php echo $this->Form->end(); ?>