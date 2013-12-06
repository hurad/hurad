<?php
if (!isset($documentData)) {
    $documentData = [];
}

if (!isset($channelData)) {
    $channelData = [];
}

if (!isset($channelData['title'])) {
    $channelData['title'] = $title_for_layout;
}

$channel = $this->Rss->channel([], $channelData, $content_for_layout);
echo $this->Rss->document($documentData, $channel);
