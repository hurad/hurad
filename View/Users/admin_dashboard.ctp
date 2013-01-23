<?php $this->Html->css(array('admin/Users/dashboard'), null, array('inline' => FALSE)); ?>
<?php $this->Html->script(array('admin/Users/dashboard'), array('block' => 'headerScript')); ?>

<h2><?php echo __('Dashboard'); ?></h2>

<div id="dashboard-widgets-wrap">

    <div id="dashboard-widgets" class="metabox-holder">

        <div class="column column-1">
            <div id="normal-sortables" class="meta-box-sortables">
                <div id="dashboard_recent_comments" class="portlet">
                    <div class="portlet-header">
                        <h3><?php echo __('Recent Comment'); ?></h3>
                    </div>
                    <div class="portlet-content">
                        <?php $this->Dashboard->dashboard_recent_comments(); ?>
                        <p class="textright" style="padding: 0 15px;">
                            <?php echo $this->Html->link(__('View all'), '/admin/comments', array('class' => 'add_button')); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="column column-2">
            <div id="normal-sortables" class="meta-box-sortables">
                <div  id="dashboard_right_now" class="portlet">
                    <div class="portlet-header">
                        <h3><?php echo __('Right Now'); ?></h3>
                    </div>
                    <div class="portlet-content">
                        <div class="inside">
                            <?php $this->Dashboard->dashboard_right_now(); ?>
                            <div class="versions">
                                <br class="clear">
                                <span id="wp-version-message">You are using <span style="font-weight: bold;">Hurad 1.0.0</span></span>
                                <br class="clear">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>