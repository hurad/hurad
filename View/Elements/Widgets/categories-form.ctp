<p>
    <!--    <label for="title"><?php //echo __d('hurad', 'Title:'); ?></label>-->
    <?php $this->Widget->label('title', __d('hurad', 'Title:')); ?>
    <?php $this->Widget->input('title', $data); ?>

    <label for="direction"><?php echo __d('hurad', 'Direction:'); ?></label>
    <?php $this->Widget->select('direction', $data, array('asc' => __d('hurad', 'Ascending'), 'desc' => __d('hurad', 'Descending'))); ?>

    <label for="sort"><?php echo __d('hurad', 'Sort By:'); ?></label>
    <?php $this->Widget->select('sort', $data, array('id' => __d('hurad', 'ID'), 'name' => __d('hurad', 'Name'), 'slug' => __d('hurad', 'Slug'))); ?>
</p>