<?php foreach ($pages as $page): ?>
    <?php $this->Page->setPage($page); ?>
    <article id="post-<?php $this->Page->the_ID(); ?>" class="post-<?php $this->Page->the_ID(
    ); ?> post type-post status-publish format-standard hentry category-motion-design tag-home tag-motion-design post clearfix ">

        <time datetime="<?php $this->Page->the_date('Y-m-d H:i:s'); ?>" class="post-date"><?php $this->Page->the_date(
            ); ?></time>
        <h1 class="post-title"><a href="<?php $this->Page->the_permalink(); ?>" title="<?php printf(
                __('Permalink to %s'),
                $this->Page->the_title_attribute('echo=0')
            ); ?>" rel="bookmark"><?php $this->Page->the_title(); ?></a></h1>

        <p class="post-meta">
            <span class="post-author"><?php echo $this->Html->link(
                    h($page['User']['username']),
                    array('controller' => 'users', 'action' => 'view', $page['User']['id'])
                ); ?></span>
            <span class="post-comment"><?php $this->Comment->comments_popup_link(
                    __('Leave a comment'),
                    __('1 Comment'),
                    __('% Comments')
                ); ?></span>
        </p>

        <?php echo $page['Page']['content']; ?>

    </article>
<?php endforeach; ?>


<div class="pagenav clearfix"><span class="number current">1</span> <a href="http://www.truethemes.org/demo/page/2"
                                                                       class="number">2</a> <a
        href="http://www.truethemes.org/demo/page/3" class="number">3</a> <a
        href="http://www.truethemes.org/demo/page/4" class="number">4</a> <a
        href="http://www.truethemes.org/demo/page/5" class="number">5</a> <a
        href="http://www.truethemes.org/demo/page/6" class="number">6</a> <a
        href="http://www.truethemes.org/demo/page/7" class="number">7</a> <a
        href="http://www.truethemes.org/demo/page/8" class="number">8</a> <a
        href="http://www.truethemes.org/demo/page/10" title="&raquo;" class="number">&raquo;</a></div>

Post
