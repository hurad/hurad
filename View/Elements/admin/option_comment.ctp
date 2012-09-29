<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Option', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false),
    'url' => array(
        'controller' => 'options',
        'action' => 'prefix',
        $prefix,
        )));
?>
<table class="form-table">
    <tbody>
        <tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('Comment-akismet_api_key', __('Akismet API Key')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td>
                <?php echo $this->Form->input('Comment-akismet_api_key', array('type' => 'text')); ?>
                <?php echo $this->AdminLayout->optionAkismetKey($isKeyValid); ?>
            </td>
        </tr>
        <tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('Comment-akismet_blog_url', __('Akismet Blog URL')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td><?php echo $this->Form->input('Comment-akismet_blog_url', array('type' => 'text')); ?></td>
        </tr>
    </tbody>
</table>
<h3><?php echo __('Avatars'); ?></h3>
<p><?php echo __('An avatar is an image that follows you from weblog to weblog appearing beside your name when you comment on avatar enabled sites. Here you can enable the display of avatars for people who comment on your site.'); ?></p>
<table class="form-table">
    <tbody>
        <tr valign="top">
            <th scope="row"><?php echo __('Avatar Display'); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php echo __('Avatar Display'); ?></span>
                    </legend>
                    <?php
                    echo $this->Form->radio('Comment-show_avatars', array(
                        '0' => __('Don’t show Avatars'),
                        '1' => __('Show Avatars')), array(
                        'legend' => FALSE,
                        'separator' => '<br />'
                    ));
                    ?>
                </fieldset>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php echo __('Maximum Rating'); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php echo __('Maximum Rating'); ?></span>
                    </legend>
                    <?php
                    echo $this->Form->radio('Comment-avatar_rating', array(
                        'G' => __('G &mdash; Suitable for all audiences'),
                        'PG' => __('PG &mdash; Possibly offensive, usually for audiences 13 and above'),
                        'R' => __('R &mdash; Intended for adult audiences above 17'),
                        'X' => __('X &mdash; Even more mature than above')), array(
                        'legend' => FALSE,
                        'separator' => '<br />'
                    ));
                    ?>
                </fieldset>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php echo __('Default Avatar'); ?></th>
            <td class="defaultavatarpicker">
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php echo __('Default Avatar'); ?></span>
                    </legend>

                    <?php echo __('For users without a custom avatar of their own, you can either display a generic logo or a generated one based on their e-mail address.'); ?><br>

                    <?php
                    echo $this->Form->input('Comment-avatar_default', array('options' => array('mystery' => ''), 'type' => 'radio', 'label' => FALSE, 'hiddenField' => false));
                    echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D32&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                    echo $this->Form->label('Comment-avatar_defaultMystery', __(' Mystery Man'));
                    ?>
                    <br>
                    <?php
                    echo $this->Form->input('Comment-avatar_default', array('options' => array('blank' => ''), 'type' => 'radio', 'label' => FALSE, 'hiddenField' => false));
                    echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=http%3A%2F%2Fdemo.opensourcecms.com%2Fwordpress%2Fwp-includes%2Fimages%2Fblank.gif&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                    echo $this->Form->label('Comment-avatar_defaultBlank', __(' Blank'));
                    ?>
                    <br>
                    <?php
                    echo $this->Form->input('Comment-avatar_default', array('options' => array('gravatar_default' => ''), 'type' => 'radio', 'label' => FALSE, 'hiddenField' => false));
                    echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                    echo $this->Form->label('Comment-avatar_defaultGravatarDefault', __(' Gravatar Logo'));
                    ?>                    
                    <br>
                    <?php
                    echo $this->Form->input('Comment-avatar_default', array('options' => array('identicon' => ''), 'type' => 'radio', 'label' => FALSE, 'hiddenField' => false));
                    echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=identicon&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                    echo $this->Form->label('Comment-avatar_defaultIdenticon', __(' Identicon (Generated)'));
                    ?>
                    <br>
                    <?php
                    echo $this->Form->input('Comment-avatar_default', array('options' => array('wavatar' => ''), 'type' => 'radio', 'label' => FALSE, 'hiddenField' => false));
                    echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=wavatar&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                    echo $this->Form->label('Comment-avatar_defaultWavatar', __(' Wavatar (Generated)'));
                    ?>                    
                    <br>
                    <?php
                    echo $this->Form->input('Comment-avatar_default', array('options' => array('monsterid' => ''), 'type' => 'radio', 'label' => FALSE, 'hiddenField' => false));
                    echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=monsterid&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                    echo $this->Form->label('Comment-avatar_defaultMonsterid', __(' MonsterID (Generated)'));
                    ?>                     
                    <br>
                    <?php
                    echo $this->Form->input('Comment-avatar_default', array('options' => array('retro' => ''), 'type' => 'radio', 'label' => FALSE, 'hiddenField' => false));
                    echo '&nbsp;' . $this->Html->image('http://0.gravatar.com/avatar/8237ab7e8f668d10f29da4210e1c6b2f?s=32&amp;d=retro&amp;r=G&amp;forcedefault=1', array('width' => '32', 'height' => '32', 'class' => 'avatar avatar-32 photo'));
                    echo $this->Form->label('Comment-avatar_defaultRetro', __(' Retro (Generated)'));
                    ?>                     
                </fieldset>
            </td>
        </tr>
    </tbody>
</table>

<?php echo $this->Form->input(__('Update'), array('type' => 'submit', 'class' => 'add_button')); ?>


