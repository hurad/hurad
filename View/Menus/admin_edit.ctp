<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Menu', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>
<?php echo $this->Form->input('id'); ?>
<div id="wrap-body">
    <div id="wrap-body-content">
        <table class="form-table">
            <tbody><tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('name', 'Name'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('name', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('alias', 'Alias'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('alias', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('description', 'Description'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                    <td><?php echo $this->Form->input('description', array('type' => 'text')); ?></td>
                </tr>
            </tbody>
        </table>
        <?php echo $this->Form->end(__('Submit')); ?>
    </div>
</div>


