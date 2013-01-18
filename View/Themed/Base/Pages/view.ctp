<article id="post-<?php $this->Page->the_ID(); ?>" class="post-<?php $this->Page->the_ID(); ?> post type-post status-publish format-standard hentry category-motion-design tag-home tag-motion-design post clearfix ">

    <time datetime="<?php echo h($page['Page']['created']); ?>" class="post-date" pubdate><?php echo $this->Time->format('F jS, Y', $page['Page']['created'], null, Configure::read('General-timezone')); ?></time>
    <h1 class="post-title"><?php echo $this->Html->link($this->Page->get_the_title(), $this->Page->get_permalink()); ?></h1>
    <p class="post-meta"> 
        <span class="post-author"><?php echo $this->Html->link(h($page['User']['username']), array('controller' => 'users', 'action' => 'view', $page['User']['id'])); ?></span>				
        <span class="post-comment"><?php $this->Comment->comments_popup_link(__('Leave a comment'), __('1 Comment'), __('% Comments')); ?></span>
    </p>

    <?php echo $page['Page']['content']; ?>

</article>

<div class="post-nav clearfix">
    <span class="prev">
        <a rel="prev" href="http://www.truethemes.org/demo/this-would-be-yet-another-testing-post.php">
            <span class="arrow">&laquo;</span>
            Just Another Test Post
        </a>
    </span>
</div>

<div id="comments" class="commentwrap">
    <?php $this->Comment->comments_template(); ?>
</div>
