<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create('Link', array(
    'class' => 'form-horizontal',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div class="control-group">
    <?php echo $this->Form->label('menu_id', __('Select Category')); ?>
    <div class="controls">
        <?php echo $this->Form->select('menu_id', $linkcats, array('empty' => FALSE)); ?>
        <span class="help-block">
            <?php echo __('The description is not prominent by default; however, some themes may show it.'); ?>
        </span>
    </div>
</div>
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
            <?php echo __('Example: Nifty blogging software'); ?>
        </span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('description', __('Description'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('description', array('class' => 'span5')); ?>
        <span class="help-block">
            <?php echo __('This will be shown when someone hovers over the link in the blogroll, or optionally below the link.'); ?>
        </span>
    </div>
</div>
<div class="control-group <?php echo $this->Form->isFieldError('url') ? 'error' : ''; ?>">
    <?php echo $this->Form->label('url', __('Web Address'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('url', array(
            'error' => array(
                'urlRule-1' => __('This field cannot be left blank.'), //notEmpty rule message
                'urlRule-2' => __('This URL not valid.'), //url rule message
                'attributes' => array(
                    'wrap' => 'span',
                    'class' => 'help-inline'
                )
            ),
            'required' => FALSE, //For disable HTML5 validation
            'type' => 'text')
        );
        ?>
        <span class="help-block <?php echo $this->Form->isFieldError('url') ? 'hr-help-block' : ''; ?>">
            <?php echo __('Example: <code>http://magzilla.org/</code> &mdash; don’t forget the <code>http://</code>'); ?>
        </span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('target', __('Target'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('target', array(
            'options' => array(
                '_blank' => __('New window or tab. (_blank)'),
                '_top' => __('Current window or tab, with no frames. (_top)'),
                '_none' => __('Same window or tab. (_none)')
            )
        ));
        ?>
        <span class="help-block">
            <?php echo __('Choose the target frame for your link.'); ?>
        </span>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('visible', __('Visible'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('visible', array(
            'options' => array(
                'Y' => __('Yes'),
                'N' => __('No'),
            )
        ));
        ?>
    </div>
</div>
<div class="control-group">
    <?php echo $this->Form->label('rating', __('Rating'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $this->Form->input('rating', array(
            'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'empty' => __('(Choose one)')
        ));
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo $this->Form->button(__('Add Link'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>