<div id="post-<?php $this->Post->theID(); ?>" <?php $this->Post->postClass('row-fluid'); ?>>
    <div class="span12">
        <div class="row-fluid">
            <div class="span12">
                <h4><strong><a href="<?php $this->Post->thePermalink(); ?>" title="<?php printf(__('Permalink to %s'), $this->Post->theTitleAttribute('echo=0')); ?>"><?php $this->Post->theTitle(); ?></a></strong></h4>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">      
                <?php $this->Post->theContent('Read More ...'); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <p></p>
                <p>
                    <i class="icon-user"></i> <?php echo __('by'); ?> <?php echo $this->Html->link($this->Author->getTheAuthor(), $this->Author->getAuthorPostsUrl()); ?> 
                    | <i class="icon-calendar"></i> <?php $this->Post->theDate(); ?>
                    | <i class="icon-comment"></i> <?php $this->Comment->commentsPopupLink(__('Leave a comment'), __('1 Comment'), __('% Comments')); ?>
                    | <i class="icon-share"></i> <?php $this->Post->the_category(); ?>
                    | <i class="icon-tags"></i> Tags : <?php $this->Post->tag(); ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php $this->Comment->comments_template(); ?>
    </div>
</div>