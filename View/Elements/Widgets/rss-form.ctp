<div class="form-group">
    <?php $this->Widget->label('title', __d('hurad', 'Title:')); ?>
    <?php $this->Widget->input('title', $data); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('rssUrl', __d('hurad', 'URL:')); ?>
    <?php $this->Widget->input('rssUrl', $data); ?>
</div>

<div class="form-group">
    <?php $this->Widget->label('count', __d('hurad', 'Number:')); ?>
    <?php $this->Widget->input('count', $data); ?>
</div>