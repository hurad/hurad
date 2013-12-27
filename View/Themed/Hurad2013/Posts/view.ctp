<div id="post-<?= $this->Content->getId(); ?>" class="<?= $this->Content->getClass('row'); ?>">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h3>
                    <strong>
                        <a href="<?php $this->Content->getPermalink(); ?>" title="<?php printf(
                            __('Permalink to %s'),
                            $this->Content->getTitle()
                        ); ?>"><?= $this->Content->getTitle(); ?></a>
                    </strong>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Content->getContent('Read More ...'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="well well-sm">
                    <span class="glyphicon glyphicon-pencil"></span> <?php echo $this->Html->link(
                        $this->Author->getAuthor(),
                        $this->Author->getAuthorPostsUrl()
                    ); ?>
                    &nbsp;&nbsp;
                    <span class="glyphicon glyphicon-time"></span> <?= $this->Content->getDate(); ?>
                    &nbsp;&nbsp;
                    <span class="glyphicon glyphicon-comment"></span>
                    <?=
                    $this->Comment->getCommentsLink(
                        __('Leave a comment'),
                        __('1 Comment'),
                        __('% Comments')
                    ); ?>
                    &nbsp;&nbsp;
                    <span class="glyphicon glyphicon-folder-open"></span>&nbsp;
                    <?= $this->Content->getCategories() ?>
                    <?php if ($this->Content->hasTags()): ?>
                        &nbsp;&nbsp;
                        <span class="glyphicon glyphicon-tags"></span>&nbsp;
                        <?=
                        $this->Content->getTags(
                            '</span><span class="label label-info">',
                            '<span class="label label-default">',
                            '</span>'
                        ); ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        echo $this->Comment->template();
        ?>
    </div>
</div>