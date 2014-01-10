<div class="row-actions">
    <?php
    if (Router::getParam('action') == 'admin_browse') {
        $funcNum = Router::getRequest()->query['CKEditorFuncNum'];
        $useMediaLink = $this->Html->link(
            __d('hurad', 'Use this media'),
            '#',
            ['onclick' => "sendUrl('{$funcNum}', '{$file['Media']['web_path']}'); return false;"]
        );
        HuradRowActions::addAction('use_media', $useMediaLink, 'manage_media');

        $deleteLink = $this->Form->postLink(
            __d('hurad', 'Delete'),
            ['action' => 'delete', $file['Media']['id']],
            null,
            __d('hurad', 'Are you sure you want to delete “%s”?', $file['Media']['name'])
        );
        HuradRowActions::addAction('delete', $deleteLink, 'manage_media');

        $actions = HuradHook::apply_filters('media_browse_row_actions', HuradRowActions::getActions(), $file);
    } else {
        $editLink = $this->Html->link(
            __d('hurad', 'Edit'),
            ['action' => 'edit', $file['Media']['id']]
        );
        HuradRowActions::addAction('edit', $editLink, 'manage_media');

        $downloadLink = $this->Html->link(
            __d('hurad', 'Download'),
            ['action' => 'download', $file['Media']['id']]
        );
        HuradRowActions::addAction('download', $downloadLink, 'manage_media');

        $directLink = $this->Html->link(
            __d('hurad', 'Direct link'),
            $file['Media']['web_path'],
            ['target' => '_blank']
        );
        HuradRowActions::addAction('direct_link', $directLink, 'manage_media');

        $deleteLink = $this->Form->postLink(
            __d('hurad', 'Delete'),
            ['action' => 'delete', $file['Media']['id']],
            null,
            __d('hurad', 'Are you sure you want to delete “%s”?', $file['Media']['name'])
        );
        HuradRowActions::addAction('delete', $deleteLink, 'manage_media');

        $actions = HuradHook::apply_filters('media_row_actions', HuradRowActions::getActions(), $file);
    }

    echo $this->AdminLayout->rowActions($actions);
    ?>
</div>
