<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Tag', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<table class="form-table">
    <tbody>
        <tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('name', __('Name')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td>
                <?php echo $this->Form->input('name', array('type' => 'text')); ?>
                <p><?php echo __('The name is how it appears on your site.'); ?></p>
            </td>
        </tr>
        <tr class="form-field form-required">
            <th scope="row"><?php echo $this->Form->label('slug', __('Slug')); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
            <td>
                <?php echo $this->Form->input('slug', array('type' => 'text')); ?>
                <p><?php echo __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'); ?></p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php echo $this->Form->label('description', __('Description')); ?></th>
            <td>
                <?php echo $this->Form->input('description'); ?>
                <p><?php echo __('The description is not prominent by default; however, some themes may show it.'); ?></p>
            </td>
        </tr>
    </tbody>
</table>
<?php echo $this->Form->input(__('Add Tag'), array('type' => 'submit', 'class' => 'add_button')); ?>
