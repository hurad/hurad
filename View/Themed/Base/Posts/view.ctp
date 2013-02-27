<article id="post-<?php $this->Post->the_ID(); ?>" <?php $this->Post->post_class(); ?>>

    <time datetime="<?php $this->Post->the_date('Y-m-d H:i:s'); ?>" class="post-date"><?php $this->Post->the_date(); ?></time>
    <h1 class="post-title"><a href="<?php $this->Post->the_permalink(); ?>" title="<?php printf(__('Permalink to %s'), $this->Post->the_title_attribute('echo=0')); ?>" rel="bookmark"><?php $this->Post->the_title(); ?></a></h1>
    <p class="post-meta"> 
        <span class="post-author"><?php echo $this->Html->link(h($post['User']['username']), array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?></span>
        <span class="post-category"><?php $this->Post->the_category(); ?></span>
        <span class="post-tag"><?php $this->Post->tag(); ?></span>					
        <span class="post-comment"><?php $this->Comment->comments_popup_link(__('Leave a comment'), __('1 Comment'), __('% Comments')); ?></span>
    </p>

    <?php $this->Post->the_content(); ?>

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

<?php //echo $this->element('comment_form'); ?>
<?php //echo $this->element('comment_list'); ?>
