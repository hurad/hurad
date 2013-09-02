<div class="navbar navbar-fixed-bottom">
    <div class="navbar-inner">
        <div class="container-fluid">
            <p class="navbar-text"><?php echo __d(
                    'hurad',
                    'Powered by %s <small>(%s)</small>',
                    $this->Html->link(__d('hurad', 'Hurad'), "http://hurad.org"),
                    Configure::read("Hurad.version")
                ); ?></p>
        </div>
    </div>
</div>