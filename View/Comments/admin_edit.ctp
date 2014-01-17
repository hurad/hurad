<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create(
    'Comment',
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
    <?php echo $this->Form->label('post_id', __d('hurad', 'Post Title'), array('class' => 'control-label col-lg-2')); ?>
    <div class="col-lg-6">
        <p class="form-control-static"><?= $comment['Post']['title']; ?></p>
    </div>
</div>

<?php if ($comment['Comment']['user_id']) { ?>
    <div class="form-group">
        <?php echo $this->Form->label(
            'user_id',
            __d('hurad', 'Author Username'),
            array('class' => 'control-label col-lg-2')
        ); ?>
        <div class="col-lg-6">
            <p class="form-control-static"><?=
                $this->Html->Link(
                    $user['User']['username'],
                    array('controller' => 'users', 'action' => 'profile', $comment['Comment']['user_id'])
                ); ?></p>
        </div>
    </div>
<?php } else { ?>
    <div class="form-group">
        <?php echo $this->Form->label(
            'author',
            __d('hurad', 'Author name'),
            array('class' => 'control-label col-lg-2')
        ); ?>
        <div class="col-lg-6">
            <p class="form-control-static"><?= $comment['Comment']['author']; ?></p>
        </div>
    </div>
<?php } ?>

<div class="form-group">
    <?php echo $this->Form->label(
        'author_email',
        __d('hurad', 'Author Email'),
        array('class' => 'control-label col-lg-2')
    ); ?>
    <div class="col-lg-6">
        <p class="form-control-static"><?= $comment['Comment']['author_email']; ?></p>
    </div>
</div>

<div class="form-group">
    <?php echo $this->Form->label(
        'author_url',
        __d('hurad', 'Author Url'),
        array('class' => 'control-label col-lg-2')
    ); ?>
    <div class="col-lg-6">
        <p class="form-control-static"><?= $comment['Comment']['author_url']; ?></p>
    </div>
</div>

<div class="form-group">
    <?php echo $this->Form->label(
        'content',
        __d('hurad', 'Content'),
        array('class' => 'control-label col-lg-2')
    ); ?>
    <div class="col-lg-6">
        <?php echo $this->Form->textarea(
            'content',
            array('rows' => '15', 'cols' => '20', 'class' => 'form-control')
        ); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $this->Form->label(
        'status',
        __d('hurad', 'Status'),
        array('class' => 'control-label col-lg-2')
    ); ?>
    <div class="col-lg-4">
        <?php echo $this->Form->select(
            'status',
            Comment::getStatus(),
            array('class' => 'form-control', 'empty' => false)
        ); ?>
    </div>
</div>

<?php echo $this->Form->button(
    __d('hurad', 'Update Comment'),
    array('type' => 'submit', 'class' => 'btn btn-primary')
); ?>

<?php echo $this->Form->end(); ?>