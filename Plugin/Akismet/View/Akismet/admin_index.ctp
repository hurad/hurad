<?php App::uses('Akismet', 'Akismet.Lib'); ?>
<?php $this->Html->css(['Akismet.akismet.css'], null, ['inline' => false]); ?>

    <div class="page-header">
        <h2><?php echo __d('akismet', 'Akismet Configuration'); ?></h2>
    </div>

<?php
echo $this->Form->create(
    'Akismet',
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
            'api_key',
            __d('akismet', 'Akismet API Key'),
            array('class' => 'control-label col-lg-2')
        ); ?>

        <div class="col-lg-4">
            <?php echo $this->Form->input('Akismet.api_key', ['class' => 'form-control']); ?>
        </div>
        <?php
        $apiKey = Configure::read('Akismet.api_key');
        if (Configure::check('Akismet.api_key') && !empty($apiKey)) {
            if (isset($isValid) && $isValid) {
                echo $this->Html->tag('span', __d('akismet', 'This key is valid.'), ['class' => 'help-block key-valid']);
            } elseif (!$isValid) {
                echo $this->Html->tag('span', __d('akismet', 'This key is invalid.'), ['class' => 'help-block key-invalid']);
            }
        }
        ?>
    </div>

<?php echo $this->Form->button(
    __d('akismet', 'Update'),
    array('type' => 'submit', 'class' => 'btn btn-primary')
); ?>

<?php echo $this->Form->end(); ?>