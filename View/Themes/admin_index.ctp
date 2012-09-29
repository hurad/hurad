<h3><?php echo __('Current Theme'); ?></h3>
<div id="current-theme">
    <?php if (isset($currentTheme['screenshot'])) { ?>
        <?php echo $this->Html->image($currentTheme['screenshot'], array('alt' => __('Current theme preview'))); ?>
    <?php } ?>
    <h4><?php echo (isset($currentTheme['name'])) ? $currentTheme['name'] : ''; ?> <?php echo (isset($currentTheme['version'])) ? $currentTheme['version'] : ''; ?> by <?php echo (isset($currentTheme['author'])) ? $currentTheme['author'] : ''; ?></h4>
    <p class="theme-description"><?php echo (isset($currentTheme['description'])) ? $currentTheme['description'] : ''; ?></p>
    <p>
        <?php echo __('All of this theme’s files are located in'); ?>
        <code>
            <?php if (count($themes) >= 1) { ?>
                /View/Themed/<?php echo Configure::read('template'); ?>
            <?php } ?>
        </code>
        .
    </p>
    <?php if (isset($currentTheme['tags'])) { ?>
        <p><?php echo __('Tags:'); ?> <?php echo $currentTheme['tags']; ?></p>
    <?php } ?>
</div>
<div class="clear"></div>
<h3><?php echo __('Available Themes') ?></h3>
<div class="clear"></div>
<?php if (count($themes) > 1) { ?>
    <table id="availablethemes" cellspacing="0" cellpadding="0">
        <tbody>
            <?php
            $theme_folders = array_keys($themes);
            natcasesort($theme_folders);
            $table = array();
            $rows = ceil(count($theme_folders) / 3);

            for ($row = 1; $row <= $rows; $row++)
                for ($col = 1; $col <= 3; $col++)
                    $table[$row][$col] = array_shift($theme_folders);
            foreach ($table as $row => $cols) {
                ?>
                <tr>
                    <?php
                    foreach ($cols as $col => $theme_folder) {
                        $class = array('available-theme');
                        if ($row == 1)
                            $class[] = 'top';
                        if ($col == 1)
                            $class[] = 'left';
                        if ($row == $rows)
                            $class[] = 'bottom';
                        if ($col == 3)
                            $class[] = 'right';
                        ?>
                        <td class="<?php echo join(' ', $class); ?>">
                            <?php if (!empty($theme_folder)) { ?>
<!--                                <a class="thickbox thickbox-preview screenshot" href="#">-->
                                    <?php echo $this->Html->image('/theme/' . $theme_folder . DS . 'img' . DS . $themesData[$theme_folder]['screenshot'], array('alt' => __('Theme preview'))); ?>
<!--                                </a>-->
                                <h3>
                                    <?php echo $themesData[$theme_folder]['name']; ?> <?php echo $themesData[$theme_folder]['version']; ?> by
                                    <?php echo $this->Html->link($themesData[$theme_folder]['author'], $themesData[$theme_folder]['authorUrl'],array('title' => __('Visit author homepage'))); ?>
                                </h3>
                                <p class="description"><?php echo $themesData[$theme_folder]['description']; ?></p>
                                <span class="action-links">        
                                    <?php echo $this->Form->postLink(__('Activate'), array('title' => 'Activate “Green Theme”', 'class' => 'activatelink', 'action' => 'activate', $theme_folder,)) ?>
                                    |
                                    <?php echo $this->Form->postLink(__('Delete'), array('admin' => TRUE, 'action' => 'delete', $theme_folder), null, __('You are about to delete this theme \'%s\'\n \'Cancel\' to stop, \'OK\' to delete.', $themesData[$theme_folder]['name'])); ?>
                                </span>
                                <p>
                                    <?php echo __('All of this theme’s files are located in'); ?>
                                    <code>/View/Themed/<?php echo $theme_folder; ?></code>
                                    .
                                </p>
                                <?php if ($themesData[$theme_folder]['tags']) { ?>
                                    <p><?php echo __('Tags:'); ?> <?php echo $themesData[$theme_folder]['tags']; ?></p>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } elseif (count($themes) <= 0) { ?>
    <p></p>
<?php } else { ?>
    <p>
        <?php echo __('You only have one theme installed right now.') ?>
    </p>
<?php } ?>
<br class="clear">
<br class="clear">