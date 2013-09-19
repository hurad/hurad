<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Tag',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

<div class="form-group<?php echo $this->Form->isFieldError('name') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label('name', __d('hurad', 'Name'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'name',
            array(
                'error' => array(
                    'nameRule-1' => __d('hurad', 'This field cannot be left blank.'), //notEmpty rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-block'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'text',
                'class' => 'form-control'
            )
        );
        ?>
    </div>
    <span class="help-block">
            <?php echo __d('hurad', 'The name is how it appears on your site.'); ?>
    </span>
</div>
<div class="form-group<?php echo $this->Form->isFieldError('slug') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label('slug', __d('hurad', 'Slug'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'slug',
            array(
                'error' => array(
                    'slugRule-1' => __d('hurad', 'This field cannot be left blank.'), //notEmpty rule message
                    'slugRule-2' => __d('hurad', 'This slug has already exist.'), //isUnique rule message
                    'attributes' => array(
                        'wrap' => 'span',
                        'class' => 'help-block'
                    )
                ),
                'required' => false, //For disable HTML5 validation
                'type' => 'text',
                'class' => 'form-control'
            )
        );
        ?>
    </div>
    <span class="help-block">
        <?php echo __(
            'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'
        ); ?>
    </span>
</div>
<div class="form-group">
    <?php echo $this->Form->label('description', __d('hurad', 'Description'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
    </div>
    <span class="help-block">
        <?php echo __d(
            'hurad',
            'The description is not prominent by default; however, some themes may show it.'
        ); ?>
    </span>
</div>

<?php echo $this->Form->button(__d('hurad', 'Add Tag'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>

<?php echo $this->Form->end(); ?>