<div class="paging">
    <?php
    if ($this->Paginator->numbers()) {
        echo $this->Paginator->prev('« ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('Next') . ' »', array(), null, array('class' => 'next disabled'));
    }
    ?>
</div>
<div class="pageing_counter">
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total')
    ));
    ?>	
</div>