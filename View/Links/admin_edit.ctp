<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Link',
    array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

<div class="form-group">
    <?php echo $this->Form->label(
        'menuId',
        __d('hurad', 'Select Category'),
        array('class' => 'control-label col-lg-2')
    ); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->select('menuId', $linkCats, array('empty' => false, 'class' => 'form-control')); ?>
    </div>
    <span class="help-block">
        <?php echo __d(
            'hurad',
            'The description is not prominent by default; however, some themes may show it.'
        ); ?>
    </span>
</div>
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
        <?php echo __d('hurad', 'Example: Nifty blogging software'); ?>
    </span>
</div>
<div class="form-group">
    <?php echo $this->Form->label(
        'description',
        __d('hurad', 'Description'),
        array('class' => 'control-label col-lg-2')
    ); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->input('description', array('type' => 'textarea', 'class' => 'form-control')); ?>
    </div>
    <span class="help-block">
        <?php echo __(
            'This will be shown when someone hovers over the link in the blogroll, or optionally below the link.'
        ); ?>
    </span>
</div>
<div class="form-group<?php echo $this->Form->isFieldError('url') ? ' has-error' : ''; ?>">
    <?php echo $this->Form->label('url', __d('hurad', 'Web Address'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'url',
            array(
                'error' => array(
                    'urlRule-1' => __d('hurad', 'This field cannot be left blank.'), //notEmpty rule message
                    'urlRule-2' => __d('hurad', 'This URL not valid.'), //url rule message
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
            'Example: <code>http://hurad.org/</code> &mdash; don’t forget the <code>http://</code>'
        ); ?>
    </span>
</div>
<div class="form-group">
    <?php echo $this->Form->label('target', __d('hurad', 'Target'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'target',
            array(
                'options' => array(
                    '_blank' => __d('hurad', 'New window or tab. (_blank)'),
                    '_top' => __d('hurad', 'Current window or tab, with no frames. (_top)'),
                    '_none' => __d('hurad', 'Same window or tab. (_none)')
                ),
                'class' => 'form-control'
            )
        );
        ?>
    </div>
    <span class="help-block">
        <?php echo __d('hurad', 'Choose the target frame for your link.'); ?>
    </span>
</div>
<div class="form-group">
    <?php echo $this->Form->label('visible', __d('hurad', 'Visible'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'visible',
            array(
                'options' => array(
                    'Y' => __d('hurad', 'Yes'),
                    'N' => __d('hurad', 'No'),
                ),
                'class' => 'form-control'
            )
        );
        ?>
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->label('rating', __d('hurad', 'Rating'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'rating',
            array(
                'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
                'empty' => __d('hurad', '(Choose one)'),
                'class' => 'form-control'
            )
        );
        ?>
    </div>
</div>

<?php echo $this->Form->button(
    __d('hurad', 'Update'),
    array('type' => 'submit', 'class' => 'btn btn-primary')
); ?>

<?php echo $this->Form->end(); ?>