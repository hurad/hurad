<?php $latestPosts = ClassRegistry::init('Post')->getLatestPosts($data['count']); ?>

<ul class="list-unstyled">
    <?php
    if (count($latestPosts) > 0) {
        foreach ($latestPosts as $post) {
            $this->Content->setContent($post, 'post');
            echo '<li>' . $this->Html->link(
                    $this->Content->getTitle(),
                    $this->Content->getPermalink(),
                    [
                        'title' => __d('hurad', 'Permalink to %s', $this->Content->getTitle()),
                        'escape' => false
                    ]
                ) . '</li>';
        }
    } else {
        echo '<li>' . __d('hurad', 'No posts were found') . '</li>';
    }
    ?>
</ul>
