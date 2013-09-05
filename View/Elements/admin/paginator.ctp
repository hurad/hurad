<div class="paging">
    <?php
    if ($this->Paginator->numbers()) {
        echo $this->Paginator->prev('« ' . __d('hurad', 'Previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__d('hurad', 'Next') . ' »', array(), null, array('class' => 'next disabled'));
    }
    ?>
</div>
<div class="pageing_counter">
    <?php
    echo $this->Paginator->counter(
        array(
            'format' => __d('hurad', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total')
        )
    );
    ?>
</div>