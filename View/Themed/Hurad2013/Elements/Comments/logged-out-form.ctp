<div id="respond">
    <h3 id="reply-title"><?= __d('hurad', 'Leave a Reply'); ?></h3>
    <?php
    echo $this->Form->create(
        'Comment',
        array(
            'action' => 'add',
            'inputDefaults' => array(
                'label' => false,
                'div' => false
            ),
            'class' => 'form-horizontal'
        )
    );
    ?>
    <div class="form-group">
        <?php echo $this->Form->label('author', __d('hurad', 'Name (Required)'), array('class' => 'control-label')); ?>
        <div class="col-lg-4">
            <?php echo $this->Form->input('author', array('class' => 'form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $this->Form->label(
            'author_email',
            __d('hurad', 'eMail (Required)'),
            array('class' => 'control-label')
        ); ?>
        <div class="col-lg-4">
            <?php echo $this->Form->input('author_email', array('class' => 'form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $this->Form->label('author_url', __d('hurad', 'URL'), array('class' => 'control-label')); ?>
        <div class="col-lg-4">
            <?php echo $this->Form->input('author_url', array('class' => 'form-control')); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-6">
            <?php echo $this->Form->input(
                'content',
                array('class' => 'form-control')
            ); ?>
        </div>
    </div>

    <p style="display: none;">
        <?php echo $this->Form->input(
            'post_id',
            ['type' => 'hidden', 'value' => $this->Content->content[$this->Content->contentModel]['id']]
        ); ?>
    </p>

    <?php echo $this->Form->end(
        array('label' => __d('hurad', 'Submit Comment'), 'class' => 'btn btn-primary')
    ); ?>
</div>