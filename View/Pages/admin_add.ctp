<?php $this->Html->css('admin-side-widget', null, array('inline' => false)); ?>

<h2><?php echo $title_for_layout; ?></h2>

<?php
echo $this->Form->create('Page', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));
?>
<div id="poststuff" class="metabox-holder">
    <?php echo $this->Form->input('id'); ?>
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
                        <li class="top-side-menu"><?php echo __("Page Attributes"); ?></li>
                        <li>
                            <ul class="sub-side-menu">
                                <li>
                                    <p>
                                        <strong>
                                            <?php echo __("Parent"); ?>
                                        </strong>
                                    </p>
                                    <span>
                                        <?php echo $this->Form->select('parent_id', $parentPages, array('empty' => __('(No Parent)'))); ?>
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
                        <td><?php echo $this->Form->input('title', array('type' => 'text', 'class' => 'postTitle')); ?></td>
                    </tr>
                    <tr class="form-field form-required">
                        <th scope="row"><?php echo $this->Form->label('slug', 'Slug'); ?> <span class="description"><?php echo __("(Required)"); ?></span></th>
                        <td><?php echo $this->Form->input('slug', array('type' => 'text', 'class' => 'postSlug')); ?></td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row"><?php echo $this->Form->label('content', 'Content'); ?></th>
                        <td><?php echo $this->Form->input('content'); ?></td>
                <script type="text/javascript">
                    //<![CDATA[

                    CKEDITOR.replace( 'data[Page][content]',
                    {
                        customConfig : 'ckeditor_config.js'
                    });

                    //]]>
                </script> 
                </tr>
                </tbody>
            </table>
            <?php //echo $this->Form->end(__('Submit'));  ?>
        </div>
    </div>
</div>
