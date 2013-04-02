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

<div class="control-group">
    <?php echo $this->Form->label('General-site_name', __('Site Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General-site_name', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General-site_url', __('Site URL'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General-site_url', array('type' => 'text')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General-site_description', __('Site Description'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General-site_description', array('type' => 'text')); ?>
        <span class="help-inline"><?php echo __('In a few words, explain what this site is about.') ?></span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General-admin_email', __('Admin Email'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General-admin_email', array('type' => 'text')); ?>
        <span class="help-inline"><?php echo __('This address is used for admin purposes, like new user notification.') ?></span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General-users_can_register', __('Membership'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('General-users_can_register', array('type' => 'checkbox')); ?>
        <span class="help-inline"><?php echo __('Anyone can register') ?></span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('General-default_role', __('Default Role'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('General-default_role', array(
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
    <?php echo $this->Form->label('General-timezone', __('Timezone'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->select('General-timezone', $this->Time->listTimezones()); ?>
        <span class="help-inline"><?php echo __('Choose a city in the same timezone as you.'); ?></span>
    </div>
</div>
<fieldset>
    <legend><?php echo __('Date Format'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio" title="F j, Y">
                <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'F j, Y'); ?>  value="F j, Y" name="date_format">
                <?php echo $this->Time->format('F j, Y', time(), null, Configure::read('General-timezone')); ?>
            </label>
            <label class="radio" title="Y/m/d">
                <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'Y/m/d'); ?> value="Y/m/d" name="date_format">
                <?php echo $this->Time->format('Y/m/d', time(), null, Configure::read('General-timezone')); ?>
            </label>
            <label class="radio" title="m/d/Y">
                <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'm/d/Y'); ?> value="m/d/Y" name="date_format">
                <?php echo $this->Time->format('m/d/Y', time(), null, Configure::read('General-timezone')); ?>
            </label>
            <label class="radio" title="d/m/Y">
                <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'd/m/Y'); ?> value="d/m/Y" name="date_format">
                <?php echo $this->Time->format('d/m/Y', time(), null, Configure::read('General-timezone')); ?>
            </label>
            <label class="radio">
                <input id="date_format_custom_radio" <?php $this->AdminLayout->optionDateCustom(Configure::read('General-date_format')); ?> type="radio" value="\c\u\s\t\o\m" name="date_format">
                <?php echo __('Custom:'); ?>
                <?php echo $this->Form->input('General-date_format', array('options' => array(Configure::read('General-date_format') => ''), 'type' => 'text', 'label' => FALSE, 'hiddenField' => false)); ?>
                <?php echo $this->Time->format(Configure::read('General-date_format'), time(), null, Configure::read('General-timezone')); ?>
                <p>
                    <?php echo $this->Html->link(__('Documentation on date formatting. '), 'http://www.php.net/manual/en/function.date.php'); ?>
                    <?php echo __('Click &ldquo;Update&rdquo; to update sample output.') ?>
                </p>
            </label>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo __('Time Format'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio" title="g:i a">    
                <input type="radio" <?php $this->AdminLayout->optionTimeFormat(Configure::read('General-time_format'), 'g:i a'); ?> value="g:i a" name="time_format">
                <?php echo $this->Time->format('g:i a', time(), null, Configure::read('General-timezone')); ?>
            </label>
            <label class="radio" title="g:i A">
                <input type="radio" <?php $this->AdminLayout->optionTimeFormat(Configure::read('General-time_format'), 'g:i A'); ?> value="g:i A" name="time_format">
                <?php echo $this->Time->format('g:i A', time(), null, Configure::read('General-timezone')); ?>
            </label>
            <label class="radio" title="H:i">
                <input type="radio" <?php $this->AdminLayout->optionTimeFormat(Configure::read('General-time_format'), 'H:i'); ?> value="H:i" name="time_format">
                <?php echo $this->Time->format('H:i', time(), null, Configure::read('General-timezone')); ?>
            </label>
            <label class="radio">                    
                <input id="time_format_custom_radio" <?php $this->AdminLayout->optionTimeCustom(Configure::read('General-time_format')); ?> type="radio" value="\c\u\s\t\o\m" name="time_format">
                <?php echo __('Custom:'); ?>
                <?php echo $this->Form->input('General-time_format', array('options' => array(Configure::read('General-time_format') => ''), 'type' => 'text', 'label' => FALSE, 'hiddenField' => false)); ?>
                <?php echo $this->Time->format(Configure::read('General-time_format'), time(), null, Configure::read('General-timezone')); ?>
            </label>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <?php echo $this->Form->button(__('Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($) {
        $("input[name='date_format']").click(function() {
            if ("date_format_custom_radio" != $(this).attr("id"))
                $("input[name='data[Option][General-date_format]']").val($(this).val());
        });
        $("input[name='data[Option][General-date_format]']").focus(function() {
            $("#date_format_custom_radio").attr("checked", "checked");
        });

        $("input[name='time_format']").click(function() {
            if ("time_format_custom_radio" != $(this).attr("id"))
                $("input[name='data[Option][General-time_format]']").val($(this).val());
        });
        $("input[name='data[Option][General-time_format]']").focus(function() {
            $("#time_format_custom_radio").attr("checked", "checked");
        });
    });

</script>