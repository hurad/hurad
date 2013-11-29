<div class="form-group">
    <?php $this->Widget->label('title', __d('hurad', 'Title:')); ?>
    <?php $this->Widget->input('title', $data); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('full_name', __d('hurad', 'Show full name:')); ?>
    <?php echo $this->Widget->radio(
        'full_name',
        $data,
        [__d('hurad', 'No'), __d('hurad', 'Yes')],
        ['show-type' => 'btn-group']
    ); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('hide_empty', __d('hurad', 'Hide empty:')); ?>
    <?php echo $this->Widget->radio(
        'hide_empty',
        $data,
        [__d('hurad', 'No'), __d('hurad', 'Yes')],
        ['show-type' => 'btn-group']
    ); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('exclude_admin', __d('hurad', 'Exclude admin:')); ?>
    <?php echo $this->Widget->radio(
        'exclude_admin',
        $data,
        [__d('hurad', 'No'), __d('hurad', 'Yes')],
        ['show-type' => 'btn-group']
    ); ?>
</div>
