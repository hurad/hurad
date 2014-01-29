<div class="form-group">
    <?php $this->Widget->label('title', __d('hurad', 'Title:')); ?>
    <?php $this->Widget->input('title', $data); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('direction', __d('hurad', 'Select Category:')); ?>
    <?php $this->Widget->select(
        'category',
        $data,
        ClassRegistry::init('Linkcat')->find(
            'list',
            array(
                'fields' => array('Linkcat.id', 'Linkcat.name'),
                'conditions' => array('Linkcat.type' => 'link_category'),
                'recursive' => -1
            )
        )
    ); ?>
</div>
