<?php echo $this->Html->script(array('admin/Posts/posts'), array('block' => 'headerScript')); ?>

<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>

<?php
echo $this->Form->create('Post', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>

<div class="row-fluid">
    <div class="span9">
        <div class="control-group">
            <div class="controls">
                <?php echo $this->Form->input('title', array('type' => 'text', 'class' => 'span12 postTitle', 'placeholder' => __('Enter title here'))); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <p style="display: inline;"><?php echo Configure::read('General-site_url') . '/'; ?></p>
                <?php echo $this->Form->input('slug', array('type' => 'text', 'class' => 'postSlug')); ?>
                <?php echo $this->Form->button(__('Edit'), array('id' => 'perma_edit', 'type' => 'button', 'class' => 'add_button')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo $this->Form->input('content', array('class' => 'editor')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo $this->Form->input('excerpt', array('class' => 'span12')); ?>
            </div>
        </div>

    </div>
    <div class="span3">
        <div class="column">
            <div class="portlet">
                <div class="portlet-header">Publish</div>
                <div class="portlet-content publish-widget">
                    <ul class="unstyled">
                        <li>    
                            <?php echo $this->Form->label('status', __('Post Status:'), array('class' => 'hr-control-label')); ?>
                            <div class="hr-control">
                                <?php
                                echo $this->Form->input('status', array(
                                    'class' => 'input-medium',
                                    'options' => array(
                                        'publish' => 'Publish',
                                        'draft' => 'Draft'
                                    )
                                ));
                                ?>
                            </div>
                        </li>
                        <li>
                            <?php echo $this->Form->label('comment_status', __('Comment Status:'), array('class' => 'hr-control-label')); ?>
                            <div class="hr-control">
                                <?php
                                echo $this->Form->input('comment_status', array(
                                    'class' => 'input-medium',
                                    'options' => array(
                                        'open' => 'Open',
                                        'close' => 'Close'
                                    )
                                ));
                                ?>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li  class="text-right">
                            <?php echo $this->Html->tag('span', __('Date: '), array('class' => 'hr-control-label')); ?>
                            <?php
                            echo $this->Form->year('created', date('Y'), date('Y', strtotime('+20 Years'))
                                    , array(
                                'class' => 'input-small',
                                'orderYear' => 'asc',
                                'empty' => false
                                    )
                            );
                            ?>
                            <?php echo $this->Form->month('created', array('empty' => false, 'class' => 'input-small')); ?>
                            <?php echo $this->Form->day('created', array('empty' => false, 'class' => 'input-mini')); ?>
                        </li>
                        <li class="text-center">
                            <?php echo $this->Html->tag('span', __('Hour: '), array('class' => 'hr-control-label')); ?> <?php echo $this->Form->hour('created', TRUE, array('empty' => false, 'class' => 'input-mini', 'value' => $this->Time->format('G', 'Now', TRUE, Configure::read('General-timezone')))); ?>
                            <?php echo '<b> : </b>'; ?>
                            <?php echo $this->Form->minute('created', array('empty' => false, 'class' => 'input-mini', 'value' => $this->Time->format('i', 'Now', TRUE, Configure::read('General-timezone')))); ?><?php echo $this->Html->tag('span', __('Minute'), array('class' => 'hr-control-label-minute')); ?>
                        </li>
                        <li class="divider"></li>
                    </ul>
                    <div class="hr-form-actions">
                        <?php echo $this->Form->button(__('Publish'), array('type' => 'submit', 'class' => 'btn btn-primary')) ?>
                    </div>
                </div>
            </div>
            <div class="portlet">
                <div class="portlet-header">Categories</div>
                <div class="portlet-content">
                    <?php echo $this->Form->input('Category', array('multiple' => 'checkbox')); ?>
                </div>
            </div>
            <div class="portlet">
                <div class="portlet-header">Tags</div>
                <div class="portlet-content">
                    <?php echo $this->Form->input('Post.tags'); ?>
                </div>
            </div>
        </div>
    </div>
</div>