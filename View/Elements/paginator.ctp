<div class="pull-right">
    <div class="row">
        <ul class="pagination">
            <?php
            if ($this->Paginator->numbers()) {
                echo $this->Paginator->prev(
                    '« ' . __d('hurad', 'Previous'),
                    array('tag' => 'li'),
                    null,
                    array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a')
                );
                echo $this->Paginator->numbers(
                    array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a')
                );
                echo $this->Paginator->next(
                    __d('hurad', 'Next') . ' »',
                    array('tag' => 'li'),
                    null,
                    array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a')
                );
            }
            ?>
        </ul>
    </div>
</div>