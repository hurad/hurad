<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Linkcat',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

<div class="control-group <?php echo $this->Form->isFieldError('name') ? 'error' : ''; ?>">
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Form->label('name', __d('hurad', 'Name'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input(
            'name',
            array(
                'error' => array(
                    'nameRule-1' => __d('hurad', 'This field cannot be left blank.'), //notEmpty rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-inline'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'text'
            )
        );
        ?>
        <span class="help-block <?php echo $this->Form->isFieldError('name') ? 'hr-help-block' : ''; ?>">
            <?php echo __d('hurad', 'The name is how it appears on your site.'); ?>
        </span>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('slug') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('slug', __d('hurad', 'Slug'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input(
            'slug',
            array(
                'error' => array(
                    'slugRule-1' => __d('hurad', 'This field cannot be left blank.'), //notEmpty rule message
                    'slugRule-2' => __d('hurad', 'This slug has already exist.'), //isUnique rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-inline'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'text'
            )
        );
        ?>
        <span class="help-block <?php echo $this->Form->isFieldError('slug') ? 'hr-help-block' : ''; ?>">
            <?php echo __(
                'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'
            ); ?>
        </span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('description', __d('hurad', 'Description'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('description', array('class' => 'span5')); ?>
        <span class="help-block">
            <?php echo __d('hurad', 'The description is not prominent by default; however, some themes may show it.'); ?>
        </span>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->button(__d('hurad', 'Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>