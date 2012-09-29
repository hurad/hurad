<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Link', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>
<table class="form-table">
    <tbody>
        <tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('menu_id', __('Select Menu')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td><?php echo $this->Form->select('menu_id', $linkcats, array('selected' => $menu_id, 'empty' => FALSE)); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('name', __('Name')); ?></th>
            <td><?php echo $this->Form->input('name'); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('description', __('Description')); ?></th>
            <td><?php echo $this->Form->input('description', array('type' => 'textarea')); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('url', __('Web Address')); ?></th>
            <td><?php echo $this->Form->input('url'); ?></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('target', __('Target')); ?></th>
            <td>
                <?php
                echo $this->Form->input('target', array('options' =>
                    array(
                        '_blank' => __('New window or tab. (_blank)'),
                        '_top' => __('Current window or tab, with no frames. (_top)'),
                        '_none' => __('Same window or tab. (_none)')
                        )));
                ?>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('visible', __('Visible')); ?></th>
            <td>
                <?php
                echo $this->Form->input('visible', array('options' =>
                    array(
                        'Y' => __('Yes'),
                        'N' => __('No')
                        )));
                ?>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('rating', __('Rating')); ?></th>
            <td>
                <?php
                echo $this->Form->input('rating', array(
                    'options' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
                    'empty' => __('(Choose one)')
                ));
                ?>
            </td>
        </tr>
    </tbody>
</table>
<?php echo $this->Form->input(__('Update Link'), array('type' => 'submit', 'class' => 'add_button')); ?>
