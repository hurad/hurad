<p>
<!--    <label for="title"><?php //echo __('Title:'); ?></label>-->
    <?php $this->Widget->label('title', __('Title:')); ?>
    <?php $this->Widget->input('title', $data); ?>

    <label for="direction"><?php echo __('Direction:'); ?></label>
    <?php $this->Widget->select('direction', $data, array('asc' => __('Ascending'), 'desc' => __('Descending'))); ?>

    <label for="sort"><?php echo __('Sort By:'); ?></label>
    <?php $this->Widget->select('sort', $data, array('id' => __('ID'), 'name' => __('Name'), 'slug' => __('Slug'))); ?>
</p>