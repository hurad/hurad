<style>
    .key-valid{
        padding: .5em;
        background-color: #2d2;
        color: #fff;
        font-weight: bold;
        width: 206px;
        border-radius: 4px;
        margin-top: 10px;
    }
    .key-invalid{
        padding: .5em;
        background-color: #ff0000;
        color: #000;
        font-weight: bold;
        width: 206px;
        border-radius: 4px;
        margin-top: 10px;
    }

</style>
<?php App::uses('Akismet', 'Akismet.Lib'); ?>

<div class="page-header">
    <h2><?php echo __('Akismet Configuration'); ?></h2>
</div>

<?php
echo $this->Form->create('Akismet', array(
    'class' => 'form-horizontal',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div class="control-group">
    <?php echo $this->Form->label('api_key', __('Akismet API Key'), array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $this->Form->input('Akismet.api_key'); ?>
        <?php
        $apiKey = Configure::read('Akismet.api_key');
        if (Configure::check('Akismet.api_key') && !empty($apiKey)) {
            if (isset($isValid) && $isValid) {
                echo '<p class="key-valid">This key is valid.</p>';
            } elseif (!$isValid) {
                echo '<p class="key-invalid">This key is invalid.</p>';
            }
        }
        ?>
    </div>

</div>



<div class="form-actions">
    <?php echo $this->Form->button(__('Update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
</div>

<?php echo $this->Form->end(); ?>