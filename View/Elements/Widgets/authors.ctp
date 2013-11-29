<ul class="list-unstyled">
    <?php echo $this->Author->getListAuthors(
        [
            'show_fullname' => $data['full_name'],
            'hide_empty' => $data['hide_empty'],
            'exclude_admin' => $data['exclude_admin']
        ]
    ); ?>
</ul>
