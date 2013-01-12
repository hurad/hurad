<div class="search-box">
    <?php
    $query = '';
    if (isset($this->params['named']['q'])) {
        $query = $this->params['named']['q'];
    }

    echo $this->Form->create('Post', array(
        'url' => array('admin' => TRUE, 'action' => 'index'),
        'inputDefaults' => array(
            'label' => false,
            'div' => FALSE,
        ),
        'id' => 'AdminSearchForm'
    ));
    echo $this->Form->input('Post.q', array('value' => $query));
    echo $this->Form->submit(__('Search'), array('div' => false));
    echo $this->Form->end();
    ?>
</div>