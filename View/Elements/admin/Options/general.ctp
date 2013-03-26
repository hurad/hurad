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
    <tbody><tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('General-site_name', __('Site Name')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td><?php echo $this->Form->input('General-site_name', array('type' => 'text')); ?></td>
        </tr>
        <tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('General-site_url', __('Site URL')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td><?php echo $this->Form->input('General-site_url', array('type' => 'text')); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('General-site_description', __('Site Description')); ?></th>
            <td>
                <?php echo $this->Form->input('General-site_description', array('type' => 'text')); ?>
                <span class="description"><?php echo __('In a few words, explain what this site is about.') ?></span>
            </td>
        </tr>
        <tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('General-admin_email', __('Admin Email')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td>
                <?php echo $this->Form->input('General-admin_email', array('type' => 'text')); ?>
                <span class="description"><?php echo __('This address is used for admin purposes, like new user notification.') ?></span>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('General-users_can_register', __('Membership')); ?></th>
            <td>
                <?php echo $this->Form->input('General-users_can_register', array('type' => 'checkbox')); ?>
                <span class="description"><?php echo __('Anyone can register') ?></span>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('General-default_role', __('Default Role')); ?></th>
            <td>
                <?php
                echo $this->Form->input('General-default_role', array(
                    'options' => array(
                        'user' => __('User'),
                        'author' => __('Author'),
                        'editor' => __('Editor'),
                        'adminstrator' => __('Adminstrator'),
                    ),
                        )
                );
                ?>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('General-timezone', __('Timezone')); ?></th>
            <td>
                <?php echo $this->Form->select('General-timezone', $this->Time->listTimezones()); ?>
                <p><?php echo __('Choose a city in the same timezone as you.'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">Date Format</th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span>Date Format</span>
                    </legend>
                    <label title="F j, Y">
                        <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'F j, Y'); ?> value="F j, Y" name="date_format">
                        <?php echo $this->Time->format('F j, Y', time(), null, Configure::read('General-timezone')); ?>
                    </label>
                    <br>
                    <label title="Y/m/d">
                        <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'Y/m/d'); ?> value="Y/m/d" name="date_format">
                        <?php echo $this->Time->format('Y/m/d', time(), null, Configure::read('General-timezone')); ?>
                    </label>
                    <br>
                    <label title="m/d/Y">
                        <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'm/d/Y'); ?> value="m/d/Y" name="date_format">
                        <?php echo $this->Time->format('m/d/Y', time(), null, Configure::read('General-timezone')); ?>
                    </label>
                    <br>
                    <label title="d/m/Y">
                        <input type="radio" <?php $this->AdminLayout->optionDateFormat(Configure::read('General-date_format'), 'd/m/Y'); ?> value="d/m/Y" name="date_format">
                        <?php echo $this->Time->format('d/m/Y', time(), null, Configure::read('General-timezone')); ?>
                    </label>
                    <br>
                    <label>
                        <input id="date_format_custom_radio" <?php $this->AdminLayout->optionDateCustom(Configure::read('General-date_format')); ?> type="radio" value="\c\u\s\t\o\m" name="date_format">
                        Custom:
                    </label>
                    <?php echo $this->Form->input('General-date_format', array('options' => array(Configure::read('General-date_format') => ''), 'type' => 'text', 'label' => FALSE, 'hiddenField' => false)); ?>
<!--                    <input class="small-text" type="text" value="F j, Y" name="date_format_custom">-->
                    <?php echo $this->Time->format(Configure::read('General-date_format'), time(), null, Configure::read('General-timezone')); ?>
                    <p>
                        <?php echo $this->Html->link(__('Documentation on date formatting. ', "http://www.php.net/manual/en/function.date.php", array())); ?>
                            <?php echo __('Click &ldquo;Save Changes&rdquo; to update sample output.') ?>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo __('Time Format'); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php echo __('Time Format'); ?></span>
                    </legend>
                    <label title="g:i a">    
                        <input type="radio" <?php $this->AdminLayout->optionTimeFormat(Configure::read('General-time_format'), 'g:i a'); ?> value="g:i a" name="time_format">
                        <?php echo $this->Time->format('g:i a', time(), null, Configure::read('General-timezone')); ?>
                    </label>
                    <br>
                    <label title="g:i A">
                        <input type="radio" <?php $this->AdminLayout->optionTimeFormat(Configure::read('General-time_format'), 'g:i A'); ?> value="g:i A" name="time_format">
                        <?php echo $this->Time->format('g:i A', time(), null, Configure::read('General-timezone')); ?>
                    </label>
                    <br>
                    <label title="H:i">
                        <input type="radio" <?php $this->AdminLayout->optionTimeFormat(Configure::read('General-time_format'), 'H:i'); ?> value="H:i" name="time_format">
                        <?php echo $this->Time->format('H:i', time(), null, Configure::read('General-timezone')); ?>
                    </label>
                    <br>
                    <label>                    
                        <input id="time_format_custom_radio" <?php $this->AdminLayout->optionTimeCustom(Configure::read('General-time_format')); ?> type="radio" value="\c\u\s\t\o\m" name="time_format">
                        <?php echo __('Custom:'); ?>
                    </label>
                    <?php echo $this->Form->input('General-time_format', array('options' => array(Configure::read('General-time_format') => ''), 'type' => 'text', 'label' => FALSE, 'hiddenField' => false)); ?>
                    <?php echo $this->Time->format(Configure::read('General-time_format'), time(), null, Configure::read('General-timezone')); ?>
                </fieldset>
            </td>
        </tr>
    </tbody>
</table>
<?php echo $this->Form->input(__('Update'), array('type' => 'submit', 'class' => 'add_button')); ?>
<script type="text/javascript">

    jQuery(document).ready(function($){
        $("input[name='date_format']").click(function(){
            if ( "date_format_custom_radio" != $(this).attr("id") )
                $("input[name='data[Option][General-date_format]']").val( $(this).val() );
        });
        $("input[name='data[Option][General-date_format]']").focus(function(){
            $("#date_format_custom_radio").attr("checked", "checked");
        });

        $("input[name='time_format']").click(function(){
            if ( "time_format_custom_radio" != $(this).attr("id") )
                $("input[name='data[Option][General-time_format]']").val( $(this).val() );
        });
        $("input[name='data[Option][General-time_format]']").focus(function(){
            $("#time_format_custom_radio").attr("checked", "checked");
        });
    });

</script>


