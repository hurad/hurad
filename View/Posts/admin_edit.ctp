<?php $this->Html->script(array('admin/Posts/posts'), array('block' => 'scriptHeader')); ?>

    <div class="page-header">
        <h2><?php echo $title_for_layout; ?></h2>
    </div>

<?php
echo $this->Form->create(
    'Post',
    array(
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    )
);
?>

    <div class="row">
        <div class="col-md-8">
            <div class="control-group">
                <div class="controls">
                    <?php echo $this->Form->input('id'); ?>
                    <?php echo $this->Form->input(
                        'title',
                        array('type' => 'text', 'class' => 'col-md-12 postTitle', 'placeholder' => __d('hurad', 'Enter title here'))
                    ); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php
                    echo $this->Form->input(
                        'slug',
                        array(
                            'type' => 'text',
                            'class' => 'postSlug col-md-12',
                            'value' => Formatting::esc_attr(
                                $this->Hook->applyFilters('editable_slug', $post['Post']['slug'])
                            ),
                            'placeholder' => __d('hurad', 'Enter slug here')
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $this->Form->input('content', array('class' => 'editor')); ?>
                </div>
            </div>
            <div class="column">
                <div class="portlet">
                    <div class="portlet-header"><?php echo __d('hurad', 'Excerpt'); ?></div>
                    <div class="portlet-content">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $this->Form->input(
                                    'excerpt',
                                    array('class' => 'col-md-12', 'type' => 'textarea')
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="column">
                <div class="portlet">
                    <div class="portlet-header">Publish</div>
                    <div class="portlet-content publish-widget">
                        <ul class="unstyled">
                            <li>
                                <?php echo $this->Form->label(
                                    'status',
                                    __d('hurad', 'Post Status:'),
                                    array('class' => 'hr-control-label')
                                ); ?>
                                <div class="hr-control">
                                    <?php
                                    echo $this->Form->input(
                                        'status',
                                        array(
                                            'class' => 'input-medium',
                                            'options' => array(
                                                'publish' => 'Publish',
                                                'draft' => 'Draft'
                                            )
                                        )
                                    );
                                    ?>
                                </div>
                            </li>
                            <li>
                                <?php echo $this->Form->label(
                                    'comment_status',
                                    __d('hurad', 'Comment Status:'),
                                    array('class' => 'hr-control-label')
                                ); ?>
                                <div class="hr-control">
                                    <?php
                                    echo $this->Form->input(
                                        'comment_status',
                                        array(
                                            'class' => 'input-medium',
                                            'options' => array(
                                                'open' => 'Open',
                                                'close' => 'Close'
                                            )
                                        )
                                    );
                                    ?>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="text-right">
                                <?php echo $this->Html->tag(
                                    'span',
                                    __d('hurad', 'Date: '),
                                    array('class' => 'hr-control-label')
                                ); ?>
                                <?php
                                echo $this->Form->year(
                                    'created',
                                    date('Y'),
                                    date('Y', strtotime('+20 Years'))
                                    ,
                                    array(
                                        'class' => 'input-sm',
                                        'orderYear' => 'asc',
                                        'empty' => false
                                    )
                                );
                                ?>
                                <?php echo $this->Form->month(
                                    'created',
                                    array('empty' => false, 'class' => 'input-sm')
                                ); ?>
                                <?php echo $this->Form->day(
                                    'created',
                                    array('empty' => false, 'class' => 'input-mini')
                                ); ?>
                            </li>
                            <li class="text-center">
                                <?php echo $this->Html->tag(
                                    'span',
                                    __d('hurad', 'Hour: '),
                                    array('class' => 'hr-control-label')
                                ); ?> <?php echo $this->Form->hour(
                                    'created',
                                    true,
                                    array('empty' => false, 'class' => 'input-mini')
                                ); ?>
                                <?php echo '<b> : </b>'; ?>
                                <?php echo $this->Form->minute(
                                    'created',
                                    array('empty' => false, 'class' => 'input-mini')
                                ); ?><?php echo $this->Html->tag(
                                    'span',
                                    __d('hurad', 'Minute'),
                                    array('class' => 'hr-control-label-minute')
                                ); ?>
                            </li>
                            <li class="divider"></li>
                        </ul>
                        <div class="hr-form-actions">
                            <?php echo $this->Form->button(
                                __d('hurad', 'Update'),
                                array('type' => 'submit', 'class' => 'btn btn-primary')
                            ) ?>
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
                        <?php echo $this->Form->input('Post.tags', array('class' => 'input-block-level')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php echo $this->Form->end(null); ?>