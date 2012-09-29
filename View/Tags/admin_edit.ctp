<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Tag', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div id="wrap-body">
    <div id="wrap-body-content">
        <?php echo $this->Form->input('id'); ?>
        <table class="form-table">
            <tbody>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('name', __('Name')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('name', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('slug', __('Slug')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('slug', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('description', __('Description')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('description'); ?></td>
                </tr>
            </tbody>
        </table>
        <?php echo $this->Form->input(__('Save Changes'), array('type' => 'submit', 'class' => 'add_button')); ?>
    </div>
</div>