<?php foreach ($posts as $post): ?>
    <?php $this->Post->setPost($post); ?>
    <div id="post-<?php $this->Post->theID(); ?>" <?php $this->Post->postClass('row'); ?>>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h4><strong><a href="<?php $this->Post->thePermalink(); ?>" title="<?php printf(
                                __('Permalink to %s'),
                                $this->Post->theTitleAttribute('echo=0')
                            ); ?>"><?php $this->Post->theTitle(); ?></a></strong></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php $this->Post->theContent('Read More ...'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p></p>

                    <p>
                        <i class="glyphicon glyphicon-user"></i> <?php echo __('by'); ?> <?php echo $this->Html->link(
                            $this->Author->getTheAuthor(),
                            $this->Author->getAuthorPostsUrl()
                        ); ?>
                        | <i class="glyphicon glyphicon-calendar"></i> <?php $this->Post->theDate(); ?>
                        | <i class="glyphicon glyphicon-comment"></i> <?php $this->Comment->commentsPopupLink(
                            __('Leave a comment'),
                            __('1 Comment'),
                            __('% Comments')
                        ); ?>
                        | <i class="glyphicon glyphicon-share"></i> <?php $this->Post->the_category(); ?>
                        | <i class="glyphicon glyphicon-tags"></i> Tags : <?php $this->Post->tag(); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>