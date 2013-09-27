<div class="form-group">
    <?php $this->Widget->label('title', __d('hurad', 'Title:')); ?>
    <?php $this->Widget->input('title', $data); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('text', __d('hurad', 'Text:')); ?>
    <?php $this->Widget->input('text', $data, array('type' => 'textarea')); ?>
</div>