<?php echo $this->Html->script('admin/Options/general', array('block' => 'scriptHeader')); ?>

<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create('Option', array(
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
));
?>

<div class="control-group">
    <?php echo $this->Form->label('General.site_name', __('Site Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General.site_name', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.site_url', __('Site URL'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General.site_url', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.site_description', __('Site Description'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General.site_description', array('type' => 'text')); ?>
        <span class="help-inline"><?php echo __('In a few words, explain what this site is about.') ?></span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.admin_email', __('Admin Email'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General.admin_email', array('type' => 'text')); ?>
        <span class="help-inline"><?php echo __('This address is used for admin purposes, like new user notification.') ?></span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.users_can_register', __('Membership'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General.users_can_register', array('type' => 'checkbox')); ?>
        <span class="help-inline"><?php echo __('Anyone can register') ?></span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.default_role', __('Default Role'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('General.default_role', array(
            'options' => array(
                'user' => __('User'),
                'author' => __('Author'),
                'editor' => __('Editor'),
                'adminstrator' => __('Adminstrator'),
            ),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.timezone', __('Timezone'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->select('General.timezone', $this->Time->listTimezones()); ?>
        <span class="help-inline"><?php echo __('Choose a city in the same timezone as you.'); ?></span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.date_format', __('Date Format'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('General.date_format', array(
            'options' => array(
                'F j, Y' => $this->Time->format('F j, Y', time(), null, Configure::read('General.timezone')),
                'Y/m/d' => $this->Time->format('Y/m/d', time(), null, Configure::read('General.timezone')),
                'm/d/Y' => $this->Time->format('m/d/Y', time(), null, Configure::read('General.timezone')),
                'd/m/Y' => $this->Time->format('d/m/Y', time(), null, Configure::read('General.timezone'))
            ),
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General.time_format', __('Time Format'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('General.time_format', array(
            'options' => array(
                'g:i a' => $this->Time->format('g:i a', time(), null, Configure::read('General.timezone')),
                'g:i A' => $this->Time->format('g:i A', time(), null, Configure::read('General.timezone')),
                'H:i' => $this->Time->format('H:i', time(), null, Configure::read('General.timezone'))
            ),
        ));
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->button(__('Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>