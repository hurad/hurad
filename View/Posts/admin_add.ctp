<?php $this->Html->script(array('admin/Posts/posts'), array('block' => 'scriptHeader')); ?>

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
    <div class="span8">
        <div class="control-group">
            <div class="controls">
                <?php echo $this->Form->input('title', array('type' => 'text', 'class' => 'span12 postTitle', 'placeholder' => __('Enter title here'))); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="row-fluid">
                    <?php echo $this->Form->input('slug', array('type' => 'text', 'class' => 'span12 postSlug', 'placeholder' => __('Enter slug here'))); ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo $this->Form->input('content', array('class' => 'editor', 'type' => 'textarea')); ?>
            </div>
        </div>

        <div class="column">
            <div class="portlet">
                <div class="portlet-header"><?php echo __('Excerpt'); ?></div>
                <div class="portlet-content">
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $this->Form->input('excerpt', array('class' => 'span12', 'type' => 'textarea')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="column">
            <div class="portlet">
                <div class="portlet-header"><?php echo __('Publish'); ?></div>
                <div class="portlet-content publish-widget">
                    <ul class="unstyled">
                        <li>    
                            <?php echo $this->Form->label('status', __('Post Status:'), array('class' => 'hr-control-label')); ?>
                            <div class="hr-control">
                                <?php
                                echo $this->Form->input('status', array(
                                    'class' => 'input-medium',
                                    'options' => array(
                                        'publish' => __('Publish'),
                                        'draft' => __('Draft')
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
                                        'open' => __('Open'),
                                        'close' => __('Close'),
                                        'disable' => __('Disable')
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
                            <?php echo $this->Form->month('created', array('empty' => false, 'class' => 'input-small', 'value' => date('m'))); ?>
                            <?php echo $this->Form->day('created', array('empty' => false, 'class' => 'input-mini', 'value' => date('d'))); ?>
                        </li>
                        <li class="text-center">
                            <?php echo $this->Html->tag('span', __('Hour: '), array('class' => 'hr-control-label')); ?>
                            <?php
                            echo $this->Form->hour('created', TRUE, array(
                                'empty' => false,
                                'class' => 'input-mini',
                                'value' => $this->Time->format('G', 'Now', TRUE, Configure::read('General.timezone'))
                                    )
                            );
                            ?>
                            <?php echo '<b> : </b>'; ?>
                            <?php
                            echo $this->Form->minute('created', array(
                                'empty' => false,
                                'class' => 'input-mini',
                                'value' => $this->Time->format('i', 'Now', TRUE, Configure::read('General.timezone'))
                                    )
                            );
                            ?>
                            <?php echo $this->Html->tag('span', __('Minute'), array('class' => 'hr-control-label-minute')); ?>
                        </li>
                        <li class="divider"></li>
                    </ul>
                    <div class="hr-form-actions">
                        <?php echo $this->Form->button(__('Publish'), array('type' => 'submit', 'class' => 'btn btn-primary')) ?>
                    </div>
                </div>
            </div>
            <div class="portlet">
                <div class="portlet-header"><?php echo __('Categories'); ?></div>
                <div class="portlet-content">
                    <?php echo $this->Form->input('Category', array('multiple' => 'checkbox')); ?>
                </div>
            </div>
            <div class="portlet">
                <div class="portlet-header"><?php echo __('Tags'); ?></div>
                <div class="portlet-content">
                    <?php echo $this->Form->input('Post.tags', array('class' => 'input-block-level')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->Form->end(null); ?>