<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
    <p><?php echo __('This can improve the aesthetics, usability, and forward-compatibility of your links.'); ?></p>
</div>

<?php
echo $this->Form->create('Option', array(
    'class' => 'form-horizontal',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    ),
    'url' => array(
        'controller' => 'options',
        'action' => 'prefix',
        $prefix,
    )
));
?>

<fieldset>
    <legend><?php echo __('Common settings'); ?></legend>
    <div class="control-group">
        <div class="controls">
            <label class="radio">
                <?php
                echo $this->Form->input('Permalink-common', array(
                    'options' => array(
                        'default' => __('Default')
                    ),
                    'type' => 'radio',
                    'hiddenField' => FALSE
                        )
                );
                ?>
                <?php echo __('<code>' . $this->Link->getHomeUrl() . '/p/123</code>'); ?>
            </label>
            <label class="radio">
                <?php
                echo $this->Form->input('Permalink-common', array(
                    'options' => array(
                        'day_name' => __('Day and name')
                    ),
                    'type' => 'radio',
                    'hiddenField' => FALSE)
                );
                ?>
                <?php echo __('<code>' . $this->Link->getHomeUrl() . '/2012/09/16/sample-post/</code>'); ?>
            </label>
            <label class="radio">
                <?php
                echo $this->Form->input('Permalink-common', array(
                    'options' => array(
                        'month_name' => __('Month and name')
                    ),
                    'type' => 'radio',
                    'hiddenField' => FALSE)
                );
                ?>
                <?php echo __('<code>' . $this->Link->getHomeUrl() . '/2012/09/sample-post/</code>'); ?>
            </label>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <?php echo $this->Form->button(__('Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>