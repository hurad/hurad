<?php
//debug($sort);
//$pages = $this->requestAction('/posts/pageIndex/sort:'.$sort.'/direction:asc/limit:10');
$pages = $this->requestAction('/posts/pageIndex');

echo $this->Layout->page_tree_render($pages);

