<?php foreach ($posts as $post): ?>
    <?php $this->Post->setPost($post); ?>
    <div id="post-<?php $this->Post->theID(); ?>" <?php $this->Post->postClass('row'); ?>>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h4><strong><a href="<?php $this->Post->thePermalink(); ?>" title="<?php printf(
                                __('Permalink to %s'),
                                $this->Post->theTitleAttribute('echo=0')
                            ); ?>"><?php $this->Post->theTitle(); ?></a></strong></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?php $this->Post->theContent('Read More ...'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p></p>

                    <p>
                        <?php echo __d('hurad', 'Posted by'); ?> <?php echo $this->Html->link(
                            $this->Author->getTheAuthor(),
                            $this->Author->getAuthorPostsUrl()
                        ); ?>
                        | <?php $this->Post->theDate(); ?>
                        | <?php $this->Comment->commentsPopupLink(
                            __('Leave a comment'),
                            __('1 Comment'),
                            __('% Comments')
                        ); ?>
                        <?php $cat = $this->Post->the_category(', ', false) ?>
                        <?php echo isset($cat) ? '| ' . $cat : '' ?>
                        <?php $tag = $this->Post->tag(', ', false) ?>
                        <?php echo isset($tag) ? '| ' . __d('hurad', 'Tags: ') . $tag : '' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>