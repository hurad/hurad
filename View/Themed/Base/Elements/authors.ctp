<section class="widget">
    <h4 class="widgettitle"><?php echo $data['title']; ?></h4>
    <ul>
        <?php $this->Author->hrListAuthors(array('show_fullname' => TRUE)); ?>
    </ul>
</section>