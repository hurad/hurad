<?php echo $this->Form->create(
    'Comment',
    array(
        'url' => array(
            'controller' => 'comments',
            'action' => 'reply',
            Router::getParam('pass')[0]
        ),
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
); ?>
    <fieldset>
        <?php if ($loggedIn) { ?>
            <legend><?php echo __d('hurad', 'Reply'); ?></legend>
            <div class="form-group">
                <?php echo $this->Form->label(
                    'content',
                    __d('hurad', 'Comment'),
                    array('class' => 'control-label col-lg-2')
                ); ?>
                <div class="col-lg-4">
                    <?php echo $this->Form->input('content', array('class' => 'form-control')); ?>
                </div>
            </div>
        <?php } else { ?>
            <legend><?php echo __d('hurad', 'Add Comment'); ?></legend>
            <div class="form-group">
                <?php echo $this->Form->label(
                    'author',
                    __d('hurad', 'Author'),
                    array('class' => 'control-label col-lg-2')
                ); ?>
                <div class="col-lg-4">
                    <?php echo $this->Form->input('author', array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $this->Form->label(
                    'author_email',
                    __d('hurad', 'Email'),
                    array('class' => 'control-label col-lg-2')
                ); ?>
                <div class="col-lg-4">
                    <?php echo $this->Form->input('author_email', array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $this->Form->label(
                    'author_url',
                    __d('hurad', 'Url'),
                    array('class' => 'control-label col-lg-2')
                ); ?>
                <div class="col-lg-4">
                    <?php echo $this->Form->input('author_url', array('class' => 'form-control')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $this->Form->label(
                    'content',
                    __d('hurad', 'Comment'),
                    array('class' => 'control-label col-lg-2')
                ); ?>
                <div class="col-lg-4">
                    <?php echo $this->Form->input('content', array('class' => 'form-control')); ?>
                </div>
            </div>
        <?php } ?>
    </fieldset>
<?php
echo $this->Form->button(
    __d('hurad', 'Submit reply'),
    array('type' => 'submit', 'class' => 'btn btn-primary')
);
echo $this->Form->end();
?>