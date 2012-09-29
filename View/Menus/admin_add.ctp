<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Menu', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div id="wrap-body">
    <div id="wrap-body-content">
        <table class="form-table">
            <tbody><tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('name', __('Name')); ?> <span class="description"><?php echo __('(Required)'); ?></span></th>
                    <td><?php echo $this->Form->input('name', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field form-required">
                    <th scope="row"><?php echo $this->Form->label('alias', __('Alias')); ?> <span class="description"><?php echo __('(Required)'); ?></span></th>
                    <td><?php echo $this->Form->input('alias', array('type' => 'text')); ?></td>
                </tr>
                <tr class="form-field">
                    <th scope="row"><?php echo $this->Form->label('description', __('Description')); ?></th>
                    <td><?php echo $this->Form->input('description', array('type' => 'text')); ?></td>
                </tr>
            </tbody>
        </table>
        <?php echo $this->Form->input(__('Add menu'), array('type' => 'submit', 'class' => 'add_button')); ?>
    </div>
</div>


