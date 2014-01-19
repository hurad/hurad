<ul>
    <?php
    try {
        if (!isset($data['rssUrl'])) {
            throw new Exception(__d('hurad', 'Rss url is not set.'));
        }

        if (!isset($data['count']) || empty($data['count'])) {
            $data['count'] = 5;
        }

        $xml = Xml::build($data['rssUrl']);
        $items = Xml::toArray($xml)['rss']['channel']['item'];
        $countItems = count($items);

        if ($countItems > 0) {
            $index = 0;
            foreach ($items as $item) {
                $index++;
                echo '<li>' . $this->Html->link($item['title'], $item['link']) . '</li>';

                if ($index == $data['count']) {
                    break;
                }
            }
        } else {
            echo '<li>' . __d('hurad', 'No comments were found') . '</li>';
        }
    } catch (Exception $e) {
        echo '<li>' . $e->getMessage() . '</li>';
    }
    ?>
</ul>
