<?php

HuradHook::add_filter('the_title', 'trim');

HuradHook::add_filter('commentText', 'HuradFormatting::clickAbleLink', 9);
HuradHook::add_filter('commentText', 'HuradFormatting::convertEmoticons', 20);

HuradHook::add_filter('editable_slug', 'urldecode');
HuradHook::add_filter('editable_slug', 'HuradSanitize::textarea');