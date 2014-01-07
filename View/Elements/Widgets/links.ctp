<?php if (array_key_exists('category', $data)) { ?>
    <ul>
        <?php
        $links = ClassRegistry::init('Link')->find(
            'all',
            [
                'conditions' => ['Link.menu_id' => $data['category']],
                'recursive' => -1
            ]
        );

        foreach ($links as $link) {
            if ($link['Link']['visible'] == 'Y') {
                echo $this->Html->tag(
                    'li',
                    $this->Html->link(
                        $link['Link']['name'],
                        $link['Link']['url'],
                        ['target' => $link['Link']['target'], 'rel' => $link['Link']['rel']]
                    )
                );
            }
        }
        ?>
    </ul>
<?php
} else {
    echo __d('hurad', 'Link category not found.');
} ?>