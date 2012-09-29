<ul id="adminmenu">
    <li class="widget dashboard-widget">
        <ul class="menu dashboard-menu">
            <?php $dashboard_menu = array("admin"); ?>
            <li class="top-menu dashboard-top-menu <?php if (in_array($url, $dashboard_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('home.png', array('alt' => 'Links', 'class' => 'menu-img')); ?>
                <?php echo __("Dashboard"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($url, $dashboard_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">

                    <li <?php if ($url == 'admin') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Home'), '/admin'); ?>
                    </li>

                </ul>
            </li>
        </ul>
    </li>
    <li class="widget posts-widget">
        <ul class="menu posts-menu">
            <?php $posts_menu = array("admin/posts", "admin/posts/add", "admin/categories", "admin/tags", "admin/tags/add"); ?>
            <li class="top-menu posts-top-menu <?php if (in_array($url, $posts_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('pin.png', array('alt' => 'Posts', 'class' => 'menu-img')); ?>
                <?php echo __("Posts"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($url, $posts_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">
                    <li <?php if ($url == 'admin/posts') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Posts'), '/admin/posts'); ?>
                    </li>
                    <li <?php if ($url == 'admin/posts/add') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Add New'), '/admin/posts/add'); ?>
                    </li>
                    <li <?php if ($url == 'admin/categories') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Categories'), '/admin/categories'); ?>
                    </li>
                    <li <?php if ($url == 'admin/tags') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Tags'), '/admin/tags'); ?>
                    </li>                                  
                </ul>
            </li>
        </ul>
    </li>
    <li class="widget links-widget">
        <ul class="menu links-menu">
            <?php $links_menu = array("links", "linkcats"); ?>
            <li class="top-menu links-top-menu <?php if (in_array($controller, $links_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('chain.png', array('alt' => 'Links', 'class' => 'menu-img')); ?>
                <?php echo __("Links"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($controller, $links_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">
                    <li <?php if ($url == 'admin/links') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('All Links'), '/admin/links'); ?>
                    </li>
                    <li <?php if ($url == 'admin/links/add') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Add Link'), '/admin/links/add'); ?>
                    </li>
                    <li <?php if ($url == 'admin/linkcats') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Link Categories'), '/admin/linkcats'); ?>
                    </li>
                    <li <?php if ($url == 'admin/linkcats/add') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Add Link Categories'), '/admin/linkcats/add'); ?>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="widget pages-widget">
        <ul class="menu pages-menu">
            <?php $pages_menu = array("admin/pages", "admin/pages/add"); ?>
            <li class="top-menu pages-top-menu <?php if (in_array($url, $pages_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('report-paper.png', array('alt' => 'Pages', 'class' => 'menu-img')); ?>
                <?php echo __("Pages"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($url, $pages_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">
                    <li <?php if ($url == 'admin/pages') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('All Pages'), '/admin/pages'); ?>
                    </li>
                    <li <?php if ($url == 'admin/pages/add') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Add New'), '/admin/pages/add'); ?>
                    </li>  
                </ul>
            </li>
        </ul>
    </li>
    <li class="widget comments-widget">
        <ul class="menu comments-menu">
            <?php $comments_menu = array("comments"); ?>
            <li class="top-menu comments-top-menu <?php if (in_array($controller, $comments_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('sticky-notes-pin.png', array('alt' => 'Links', 'class' => 'menu-img')); ?>
                <?php echo __("Comments"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($controller, $comments_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">
                    <li <?php if ($url == 'admin/comments') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('All Comments'), '/admin/comments'); ?>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="widget appearance-widget">
        <ul class="menu appearance-menu">
            <?php $appearance_menu = array("menus", "themes"); ?>
            <li class="top-menu appearance-top-menu <?php if (in_array($controller, $appearance_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('application-blog.png', array('alt' => 'Appearance', 'class' => 'menu-img')); ?>
                <?php echo __("Appearance"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($controller, $appearance_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">
                    <li <?php if ($url == 'admin/themes') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Themes'), '/admin/themes'); ?>
                    </li>
                    <li <?php if ($url == 'admin/menus') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('All Menus'), '/admin/menus'); ?>
                    </li>
                    <li <?php if ($url == 'admin/menus/add') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Add Menu'), '/admin/menus/add'); ?>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="widget users-widget">
        <ul class="menu users-menu">
            <?php $users_menu = array("users"); ?>
            <li class="top-menu users-top-menu <?php if (in_array($controller, $users_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('users.png', array('alt' => 'Links', 'class' => 'menu-img')); ?>
                <?php echo __("Users"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($controller, $users_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">
                    <li <?php if ($url == 'admin/users') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('All Users'), '/admin/users'); ?>
                    </li>
                    <li <?php if ($url == 'admin/users/add') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Add New'), '/admin/users/add'); ?>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="widget options-widget">
        <ul class="menu options-menu">
            <?php $options_menu = array("options"); ?>
            <li class="top-menu options-top-menu <?php if (in_array($controller, $options_menu)) echo 'active'; ?>">
                <?php echo $this->Html->image('toolbox.png', array('alt' => 'Links', 'class' => 'menu-img')); ?>
                <?php echo __("Options"); ?>
                <?php echo $this->Html->image('menu-arrow.gif', array('class' => 'arrow-def')); ?>
            </li>
            <li class="sb" <?php if (in_array($controller, $options_menu)) echo 'style="display: list-item;"'; ?>>
                <ul class="submenu">
                    <li <?php if ($url == 'admin/options/prefix/general') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('General'), '/admin/options/prefix/general'); ?>
                    </li>
                    <li <?php if ($url == 'admin/options/prefix/comment') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Comment'), '/admin/options/prefix/comment'); ?>
                    </li>
                    <li <?php if ($url == 'admin/options/prefix/permalink') echo 'class="current"'; ?>>
                        <?php echo $this->Html->link(__('Permalinks'), '/admin/options/prefix/permalink'); ?>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>