<?php $this->Html->script(array('holder'), array('block' => 'scriptHeader')); ?>
<h3><?php echo __('Current Theme'); ?></h3>
<style>
    ul.thumbnails li.span4:nth-child(3n + 4) {
        margin-left: 0px;
    }

    ul.thumbnails li.span3:nth-child(4n + 5) {
        margin-left: 0px;
    }

    ul.thumbnails li.span12 + li {
        margin-left: 0px;
    }

    .description {
        margin-bottom: 20px;
    }
</style>
<div class="current-theme">
    <ul class="thumbnails">
        <li class="span4">
            <div class="thumbnail">
                <?php
                $viewPath = App::path('View');
                if (file_exists(
                    $viewPath[0] . 'Themed' . DS . Configure::read(
                        'template'
                    ) . DS . 'webroot' . DS . 'img' . DS . 'screenshot.png'
                )
                ) {
                    echo $this->Html->image('screenshot.png', array('alt' => $currentTheme['name']));
                } else {
                    echo $this->Html->image('/holder.js/300x225');
                }
                ?>
                <div class="caption">
                    <h3><?php echo $currentTheme['name']; ?></h3>

                    <div class="description">
                        <span>
                            <?php
                            if (isset($currentTheme['theme_url']) && !empty($currentTheme['theme_url'])) {
                                $name = $this->Html->link(
                                    $currentTheme['name'],
                                    $currentTheme['theme_url'],
                                    array('title' => __('Visit theme url'))
                                );
                            } else {
                                $name = $currentTheme['name'];
                            }

                            if (isset($currentTheme['author_url']) && !empty($currentTheme['author_url'])) {
                                $author = $this->Html->link(
                                    $currentTheme['author'],
                                    $currentTheme['author_url'],
                                    array('title' => __('Visit author url'))
                                );
                            } else {
                                $author = $currentTheme['author'];
                            }
                            echo $name . ' ' . $currentTheme['version'] . ' ' . __('by') . ' ' . $author;
                            ?>
                        </span>
                    </div>
                    <?php if (isset($currentTheme['description']) && !empty($currentTheme['description'])) { ?>
                        <p><?php echo $currentTheme['description']; ?></p>
                    <?php } ?>
                    <?php if (isset($currentTheme['tags']) && !empty($currentTheme['tags'])) { ?>
                        <p><?php echo __('Tags: ') . $currentTheme['tags']; ?></p>
                    <?php } ?>
                </div>
            </div>
        </li>
    </ul>
</div>
<h3><?php echo __('Available Themes') ?></h3>
<div class="available-theme">
    <ul class="thumbnails">
        <?php foreach ($themes as $alias => $theme) { ?>
            <?php
            if ($alias == Configure::read('template')) {
                continue;
            }
            ?>
            <li class="span4">
                <div class="thumbnail">
                    <?php
                    $viewPath = App::path('View');
                    if (file_exists(
                        $viewPath[0] . 'Themed' . DS . $alias . DS . 'webroot' . DS . 'img' . DS . 'screenshot.png'
                    )
                    ) {
                        echo $this->Html->image(
                            '/theme/' . $alias . DS . 'img' . DS . 'screenshot.png',
                            array('alt' => $theme['name'])
                        );
                    } else {
                        echo $this->Html->image('/holder.js/300x225');
                    }
                    ?>
                    <div class="caption">
                        <h3><?php echo $theme['name']; ?></h3>

                        <div class="description">
                            <span>
                                <?php
                                if (isset($theme['theme_url']) && !empty($theme['theme_url'])) {
                                    $name = $this->Html->link(
                                        $theme['name'],
                                        $theme['theme_url'],
                                        array('title' => __('Visit theme url'))
                                    );
                                } else {
                                    $name = $theme['name'];
                                }

                                if (isset($theme['author_url']) && !empty($theme['author_url'])) {
                                    $author = $this->Html->link(
                                        $theme['author'],
                                        $theme['author_url'],
                                        array('title' => __('Visit author url'))
                                    );
                                } else {
                                    $author = $theme['author'];
                                }
                                echo $name . ' ' . $theme['version'] . ' ' . __('by') . ' ' . $author;
                                ?>
                            </span>
                        </div>
                        <?php if (isset($theme['description']) && !empty($theme['description'])) { ?>
                            <p><?php echo $theme['description']; ?></p>
                        <?php } ?>
                        <?php if (isset($theme['tags']) && !empty($theme['tags'])) { ?>
                            <p><?php echo __('Tags: ') . $theme['tags']; ?></p>
                        <?php } ?>
                        <p>
                            <?php echo $this->Form->postLink(
                                __('Activate'),
                                array('admin' => true, 'action' => 'activate', $alias),
                                array('title' => __('Activate "%s"', $theme['name']), 'class' => 'btn btn-success')
                            ); ?>
                            <?php echo $this->Form->postLink(
                                __('Delete'),
                                array('admin' => true, 'action' => 'delete', $alias),
                                array('title' => __('Delete "%s"', $theme['name']), 'class' => 'btn btn-danger'),
                                __('Are you sure delete "%s"', $theme['name'])
                            ); ?>
                        </p>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>