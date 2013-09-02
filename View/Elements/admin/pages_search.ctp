<div class="search-box">
    <?php
    $filterSearch = '';
    if (isset($this->params['named']['q'])) {
        $filterSearch = $this->params['named']['q'];
    }

    echo $this->Form->create(
        'Page',
        array(
            'url' => array('admin' => TRUE, 'action' => 'index'),
            'inputDefaults' => array(
                'label' => false,
                'div' => FALSE,
            )
        )
    );
    echo $this->Form->input('Page.q', array('value' => $filterSearch));
    echo $this->Form->submit(__('Search'), array('div' => false));
    echo $this->Form->end();
    ?>
</div>