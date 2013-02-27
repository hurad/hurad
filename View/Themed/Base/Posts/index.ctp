<?php foreach ($posts as $post): ?>
    <?php $this->Post->setPost($post); ?>
    <article id="post-<?php $this->Post->the_ID(); ?>" <?php $this->Post->post_class(); ?>>

        <time datetime="<?php $this->Post->the_date('Y-m-d H:i:s'); ?>" class="post-date"><?php $this->Post->the_date(); ?></time>
        <h1 class="post-title"><a href="<?php $this->Post->the_permalink(); ?>" title="<?php printf(__( 'Permalink to %s' ), $this->Post->the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php $this->Post->the_title(); ?></a></h1>
        <p class="post-meta"> 
            <span class="post-author"><?php echo $this->Html->link(h($post['User']['username']), array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?></span>
            <span class="post-category"><?php $this->Post->the_category(); ?></span>
            <span class="post-tag"><?php $this->Post->tag(); ?></span>					
            <span class="post-comment"><?php $this->Comment->comments_popup_link(__('Leave a comment'), __('1 Comment'), __('% Comments')); ?></span>
        </p>

        <?php $this->Post->the_content('Read More ...'); ?>

    </article>
<?php endforeach; ?>                   


<div class="pagenav clearfix"> <span class="number current">1</span>  <a href="http://www.truethemes.org/demo/page/2" class="number">2</a>  <a href="http://www.truethemes.org/demo/page/3" class="number">3</a>  <a href="http://www.truethemes.org/demo/page/4" class="number">4</a>  <a href="http://www.truethemes.org/demo/page/5" class="number">5</a>  <a href="http://www.truethemes.org/demo/page/6" class="number">6</a>  <a href="http://www.truethemes.org/demo/page/7" class="number">7</a>  <a href="http://www.truethemes.org/demo/page/8" class="number">8</a> <a href="http://www.truethemes.org/demo/page/10" title="&raquo;" class="number">&raquo;</a></div>