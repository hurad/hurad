<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create('Tag', array(
    'class' => 'form-horizontal',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div class="control-group <?php echo $this->Form->isFieldError('name') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('name', __('Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('name', array(
            'error' => array(
                'nameRule-1' => __('This field cannot be left blank.'), //notEmpty rule message
                'attributes' => array(
                    'wrap' => 'span',
                    'class' => 'help-inline'
                )
            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text')
        );
        ?>
        <span class="help-block <?php echo $this->Form->isFieldError('name') ? 'hr-help-block' : ''; ?>">
            <?php echo __('The name is how it appears on your site.'); ?>
        </span>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('slug') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('slug', __('Slug'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('slug', array(
            'error' => array(
                'slugRule-1' => __('This field cannot be left blank.'), //notEmpty rule message
                'slugRule-2' => __('This slug has already exist.'), //isUnique rule message
                'attributes' => array(
                    'wrap' => 'span',
                    'class' => 'help-inline'
                )
            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text')
        );
        ?>
        <span class="help-block <?php echo $this->Form->isFieldError('slug') ? 'hr-help-block' : ''; ?>">
            <?php echo __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'); ?>
        </span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('description', __('Description'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('description', array('class' => 'span5')); ?>
        <span class="help-block">
            <?php echo __('The description is not prominent by default; however, some themes may show it.'); ?>
        </span>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->button(__('Add Tag'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>