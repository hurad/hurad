<div class="form-group">
    <?php $this->Widget->label('title', __d('hurad', 'Title:')); ?>
    <?php $this->Widget->input('title', $data); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('direction', __d('hurad', 'Direction:')); ?>
    <?php $this->Widget->select(
        'direction',
        $data,
        array('asc' => __d('hurad', 'Ascending'), 'desc' => __d('hurad', 'Descending'))
    ); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('sort', __d('hurad', 'Sort By:')); ?>
    <?php $this->Widget->select(
        'sort',
        $data,
        array('id' => __d('hurad', 'ID'), 'name' => __d('hurad', 'Name'), 'slug' => __d('hurad', 'Slug'))
    ); ?>
</div>