<?php foreach ($posts as $post): ?>
    <?php $this->Post->setPost($post); ?>
    <div id="post-<?php $this->Post->theID(); ?>" <?php $this->Post->postClass('row'); ?>>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h4><strong><a href="<?= $this->Post->getPermalink(); ?>" title="<?php printf(
                                __d('hurad', 'Permalink to %s'),
                                $this->Post->theTitleAttribute('echo=0')
                            ); ?>"><?php $this->Post->theTitle(); ?></a></strong></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?php $this->Post->theContent(__d('hurad', 'Read More ...')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <span class="glyphicon glyphicon-pencil"></span> <?php echo $this->Html->link(
                            $this->Author->getTheAuthor(),
                            $this->Author->getAuthorPostsUrl()
                        ); ?>
                        &nbsp;&nbsp;
                        <span class="glyphicon glyphicon-time"></span> <?= $this->Post->getDate(); ?>
                        &nbsp;&nbsp;
                        <span class="glyphicon glyphicon-comment"></span>
                        <?php $this->Comment->commentsPopupLink(
                            __('Leave a comment'),
                            __('1 Comment'),
                            __('% Comments')
                        ); ?>
                        &nbsp;&nbsp;
                        <span class="glyphicon glyphicon-folder-open"></span>&nbsp;
                        <?= $this->Post->the_category(', ', false) ?>
                        &nbsp;&nbsp;
                        <span class="glyphicon glyphicon-tags"></span>&nbsp;
                        <?=
                        $this->Post->getTags(
                            '</span><span class="label label-info">',
                            '<span class="label label-default">',
                            '</span>'
                        ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>