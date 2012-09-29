<?php

App::uses('Sanitize', 'Utility');

Configure::write('debug', 0);
$homeUrl = $this->Html->url('/', true);
$this->set('channel', array(
    'title' => __('My Recent Posts'),
    'link' => $homeUrl,
    'description' => 'Hurad CMS',
    'language' => 'en-us',
    'copyright' => ((date('Y') > 2012) ? '2012-' . date('Y') : '2012' ) . 'Hurad CMS',
    'atom:link' => array(
        'attrib' => array(
            'href' => 'http://localhost/hurad/posts/index.rss',
            'rel' => 'self',
            'type' => 'application/rss+xml'))
));

foreach ($posts as $post) {
    $postTime = strtotime($post['Post']['created']);

    $postLink = array(
        'controller' => 'posts',
        'action' => 'view',
        'year' => date('Y', $postTime),
        'month' => date('m', $postTime),
        'day' => date('d', $postTime),
        $post['Post']['id']);
    // $post['Post']['slug']);
    // You should import Sanitize
    // This is the part where we clean the body text for output as the description 
    // of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $post['Post']['content']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate($bodyText, 120, '...', true, true);

    echo $this->Rss->item(array(), array(
        'title' => $post['Post']['title'],
        'link' => $postLink,
        'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        //'dc:author' => $post['Post']['user_id'],
        'pubDate' => $post['Post']['created']));
}
?>