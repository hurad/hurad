<section class="widget">
    <h4 class="widgettitle"><?php echo $data['title']; ?></h4>
    <ul>
        <?php $this->Post->list_categories(array('direction' => $data['direction'], 'sort' => $data['sort'])); ?>
    </ul>
</section>
