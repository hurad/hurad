<?php $this->Html->css('admin-side-widget', null, array('inline' => false)); ?>
<?php echo $this->Html->script('slug', array('block' => 'headerScript')); ?>

<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Form->create('Post', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>
<div id="poststuff" class="metabox-holder">
    <div id="admin-side-column">
        <div id="side-sortables">
            <ul id="side-column">
                <li class="side-widget">
                    <ul class="side-menu">
                        <li class="top-side-menu"><?php echo __("Publish"); ?></li>
                        <li>
                            <ul class="sub-side-menu">
                                <li><?php echo __("Status: "); ?>
                                    <span>
                                        <?php
                                        echo $this->Form->input('status', array('options' =>
                                            array(
                                                'publish' => 'Publish',
                                                'draft' => 'Draft'
                                                )));
                                        ?>
                                    </span>
                                </li>
                                <li><?php echo __("Publish on: "); ?>
                                    <span class="date_published">
                                        <span class="label_published"><?php echo __("Date:"); ?></span>
                                        <?php
                                        echo $this->Form->input('created', array(
                                            'type' => 'date',
                                            'dateFormat' => 'MDY',
                                            'class' => 'date_select')
                                        );
                                        ?>
                                    </span>                                   
                                    <span class="time_published">
                                        <span class="label_published"><?php echo __("Time:"); ?></span>
                                        <?php
                                        echo $this->Form->input('created', array(
                                            'type' => 'time',
                                            'timeFormat' => 12,
                                            'class' => 'time_select')
                                        );
                                        ?>
                                    </span>                                    
                                </li>
                                <li><?php echo __("Comment Status:"); ?>
                                    <span>
                                        <?php
                                        echo $this->Form->input('comment_status', array('options' =>
                                            array(
                                                'open' => 'Open',
                                                'close' => 'Close'
                                                )));
                                        ?>    
                                    </span>
                                </li>
                                <li class="last-item">
                                    <?php echo $this->Form->submit('Publish', array('div' => false, 'name' => 'publish', 'class' => 'publish-button')); ?>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="side-widget">
                    <ul class="side-menu">
                        <li class="top-side-menu">
                            <?php echo __("Categories"); ?>
                        </li>
                        <li>
                            <ul class="sub-side-menu">
                                <li>
                                    <?php echo $this->Form->input('Category', array('multiple' => 'checkbox')); ?>
                                    <span>
                                        <?php echo $this->Html->link(__('Add New Category'), array('admin' => TRUE, 'controller' => 'categories', 'action' => 'add')); ?>
                                    </span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="side-widget">
                    <ul class="side-menu">
                        <li class="top-side-menu">
                            <?php echo __("Post Tags"); ?></li>
                        <li>
                            <ul class="sub-side-menu">
                                <li>
                                    <span>
                                        <?php echo $this->Form->input('Post.tags'); ?>   
                                    </span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div id="wrap-body">
        <div id="wrap-body-content">
            <table class="form-table">
                <tbody><tr class="form-field form-required">
                        <th scope="row"><?php echo $this->Form->label('title', 'Title'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                        <td><?php echo $this->Form->input('title', array('type' => 'text', 'class' => 'postTitle', 'placeholder' => __('Enter title here'))); ?></td>
                    </tr>
                    <tr class="form-field form-required">
                        <th scope="row"><?php echo $this->Form->label('slug', 'Slug'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                        <td>
                            <p style="display: inline;"><?php echo Configure::read('General-site_url') . '/'; ?></p>
                            <?php echo $this->Form->input('slug', array('type' => 'text', 'class' => 'postSlug')); ?>
                            <?php echo $this->Form->button(__('Edit'), array('id' => 'perma_edit', 'type' => 'button', 'class' => 'add_button')); ?>
                            <?php //echo $this->Form->button(__('OK'), array('id' => 'perma_ok', 'type' => 'button', 'class' => 'add_button', 'style' => 'display:none;')); ?>
                        </td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row"><?php echo $this->Form->label('content', 'Content'); ?></th>
                        <td><?php echo $this->Form->input('content'); ?></td>
                <script type="text/javascript">
                    //<![CDATA[

                    CKEDITOR.replace( 'data[Post][content]',
                    {
                        customConfig : 'ckeditor_config.js'
                    });

                    //]]>
                </script> 
                </tr>
                <tr class="form-field">
                    <th scope="row"><?php echo $this->Form->label('excerpt', 'Excerpt'); ?></th>
                    <td><?php echo $this->Form->input('excerpt'); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>