<p></p>
<p>
    <?php
    $info = [];

    if (array_key_exists('version', $plugin)) {
        $info[] = __d('hurad', 'Version %s', $plugin['version']);
    }

    if (array_key_exists('author', $plugin) && is_array($plugin['author'])) {
        if (array_key_exists('name', $plugin['author']) && array_key_exists('url', $plugin['author'])) {
            $info[] = __d('hurad', 'By %s', $this->Html->link($plugin['author']['name'], $plugin['author']['url']));
        } elseif (array_key_exists('name', $plugin['author']) && !array_key_exists('url', $plugin['author'])) {
            $info[] = __d('hurad', 'By %s', $plugin['author']['name']);
        }
    }

    if (array_key_exists('url', $plugin)) {
        $info[] = $this->Html->link(__d('hurad', 'Visit plugin home page'), $plugin['url']);
    }

    echo implode(' | ', $info);
    ?>
</p>
