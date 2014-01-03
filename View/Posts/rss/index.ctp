<?php

App::uses('Sanitize', 'Utility');

Configure::write('debug', 0);

$this->set(
    'documentData',
    [
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'
    ]
);

$this->set(
    'channelData',
    [
        'title' => __d('hurad', 'My Recent Posts'),
        'link' => Configure::read('General.site_url'),
        'description' => (!Configure::read('General.site_description') ? ' ' : ''),
        'language' => 'en-us',
        'copyright' => date('Y') . ' ' . Configure::read('General.site_name'),
        'atom:link' => [
            'attrib' => [
                'href' => Configure::read('General.site_url') . '/feed.rss',
                'rel' => 'self',
                'type' => 'application/rss+xml'
            ]
        ]
    ]
);

foreach ($posts as $post) {
    $this->Content->setContent($post, 'post');

    // You should import Sanitize
    // This is the part where we clean the body text for output as the description 
    // of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $post['Post']['content']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate(
        $bodyText,
        400,
        [
            'ending' => '...',
            'exact' => true,
            'html' => true,
        ]
    );

    echo $this->Rss->item(
        [],
        [
            'title' => $this->Content->getTitle(),
            'link' => $this->Content->getPermalink(),
            'guid' => ['url' => $this->Content->getPermalink(), 'isPermaLink' => 'true'],
            'description' => $bodyText,
            'author' => $post['User']['email'] . ' (' . $post['User']['username'] . ')',
            'pubDate' => $this->Time->toRSS($post['Post']['created'])
        ]
    );
}
