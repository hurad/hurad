<?php
App::uses('Formatting', 'Lib');
//App::import('Lib', 'Functions');


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardHelper
 *
 * @author mohammad
 */
class DashboardHelper extends AppHelper {

    public $helpers = array('Comment', 'Gravatar', 'Js', 'Html', 'Link');

    public function dashboard_recent_comments() {

//global $wpdb;
        // Select all comment types and filter out spam later for better query performance.
        $comments = $this->_View->viewVars['comments'];
        //$start = 0;
//        $widgets = get_option('dashboard_widget_options');
//        $total_items = isset($widgets['dashboard_recent_comments']) && isset($widgets['dashboard_recent_comments']['items']) ? absint($widgets['dashboard_recent_comments']['items']) : 5;
//
//        $comments_query = array('number' => $total_items * 5, 'offset' => 0);
//        if (!current_user_can('edit_posts'))
//            $comments_query['status'] = 'approve';
//        while (count($comments) < $total_items && $possible = get_comments($comments_query)) {
//            foreach ($possible as $comment) {
//                if (!current_user_can('read_post', $comment->comment_post_ID))
//                    continue;
//                $comments[] = $comment;
//                if (count($comments) == $total_items)
//                    break 2;
//            }
//            $comments_query['offset'] += $comments_query['number'];
//            $comments_query['number'] = $total_items * 10;
//        }

        if ($comments) {
            echo '<div id="the-comment-list" class="list:comment">';
            foreach ($comments as $comment)
                $this->_dashboard_recent_comments_row($comment);
            echo '</div>';

//            if (current_user_can('edit_posts'))
//                _get_list_table('WP_Comments_List_Table')->views();
//
//            wp_comment_reply(-1, false, 'dashboard', false);
//            wp_comment_trashnotice();
        } else {
            echo '<p>' . __('No comments yet.') . '</p>';
        }
    }

    function _dashboard_recent_comments_row($comment) {
        $this->Comment->setComment($comment['Comment']);
        ?>

        <div id="comment-<?php $this->Comment->comment_ID(); ?>" <?php $this->Comment->comment_class(array('comment-item', $this->Comment->get_comment_status($comment['Comment']['approved']))); ?>>
            <?php echo $this->Gravatar->image($this->Comment->get_comment_author_email(), array('size' => '50', 'default' => 'mm')); ?>
            <div class="dashboard-comment-wrap">
                <h4 class="comment-meta">
                    <?php echo __('From'); ?>
                    <cite class="comment-author">
                        <?php echo $this->Html->link($this->Comment->get_comment_author(), Formatting::esc_url($this->Comment->get_comment_author_url()), array('class' => 'url', 'rel' => 'external nofollow')); ?>
                    </cite>
                    <?php echo __('on'); ?>
                    <a href="http://localhost/wp3en/wp-admin/post.php?post=1&action=edit"><?php echo $comment['Post']['title']; ?></a>
                    <a class="comment-link" href="http://localhost/wp3en/?p=1#comment-3">#</a>
                    <span class="approve" <?php echo ($comment['Comment']['approved']) ? 'style="display: none;"' : 'style=""'; ?>><?php echo __('[Pending]'); ?></span>
                </h4>
                <blockquote>
                    <p><?php $this->Comment->comment_excerpt(); ?></p>
                </blockquote>

                <p class="row-actions">
                    <span class="approve" <?php echo ($comment['Comment']['approved']) ? 'style="display: none;"' : 'style=""'; ?>>
                        <?php
                        echo $this->Js->link(__('Approve'), array('controller' => 'comments', 'action' => 'admin_approve', $this->Comment->get_comment_ID()), array(
                            //'update' => '#the-comment-list',
                            'success' => '
                                $(\'#comment-' . $this->Comment->get_comment_ID() . '\').removeClass("unapproved",{duration:10000}).addClass("approved", {duration:10000});
                                $(\'#comment-' . $this->Comment->get_comment_ID() . ' span.approve\').css("display", "none",{duration:10000});
                                $(\'#comment-' . $this->Comment->get_comment_ID() . ' span.unapprove\').css("display", "",{duration:10000});
                                $(\'#dashboard_right_now\').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");'
                                )
                        );
                        ?>
                    </span>
                    <span class="unapprove" <?php echo ($comment['Comment']['approved']) ? 'style=""' : 'style="display: none;"'; ?>>
                        <?php
                        echo $this->Js->link(__('Unapprove'), array('controller' => 'comments', 'action' => 'admin_disapprove', $this->Comment->get_comment_ID()), array(
                            //'update' => '#the-comment-list',
                            'success' => '
                                $(\'#comment-' . $this->Comment->get_comment_ID() . '\').removeClass("approved",{duration:10000}).addClass("unapproved",{duration:10000});
                                $(\'#comment-' . $this->Comment->get_comment_ID() . ' span.unapprove\').css("display", "none",{duration:10000});
                                $(\'#comment-' . $this->Comment->get_comment_ID() . ' span.approve\').css("display", "",{duration:10000});
                                $(\'#dashboard_right_now\').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");'
                                )
                        );
                        ?>
                    </span>
        <!--                    <span class="reply hide-if-no-js">
                        |
                        <a class="vim-r hide-if-no-js" href="#" title="Reply to this comment" onclick="commentReply.open('3','1');return false;">Reply</a>
                    </span>-->
                    <span class="edit">
                        |
                        <?php echo $this->Html->link(__('Edit'), array('admin' => TRUE, 'controller' => 'comments', 'action' => 'edit', $this->Comment->get_comment_ID()), array('title' => 'Edit comment')); ?>
                    </span>
                    <span class="spam">
                        |
                        <a class="delete:the-comment-list:comment-3::spam=1 vim-s vim-destructive" title="Mark this comment as spam" href="comment.php?action=spamcomment&p=1&c=3&_wpnonce=9b8bfb7464">Spam</a>
                    </span>
                    <span class="trash">
                        |
                        <a class="delete:the-comment-list:comment-3::trash=1 delete vim-d vim-destructive" title="Move this comment to the trash" href="comment.php?action=trashcomment&p=1&c=3&_wpnonce=9b8bfb7464">Trash</a>
                    </span>
                </p>
            </div>
        </div>
        <?php
    }

    public function dashboard_right_now() {
        $num_posts = ClassRegistry::init('Post')->count_posts();
        $num_pages = ClassRegistry::init('Page')->count_pages();
        $num_cats = ClassRegistry::init('Category')->count_cats();
        $num_tags = ClassRegistry::init('Tag')->count_tags();
        $num_all_comment = ClassRegistry::init('Comment')->count_comments('all');
        $num_approved_comment = ClassRegistry::init('Comment')->count_comments('approved');
        $num_pending_comment = ClassRegistry::init('Comment')->count_comments('moderated');
        $num_spam_comment = ClassRegistry::init('Comment')->count_comments('spam');
        ?>
        <div class="table table_content">
            <p class="sub">Content</p>
            <table>
                <tbody>
                    <tr class="first">
                        <td class="first b b-posts">
                            <a href="edit.php"><?php echo $num_posts; ?></a>
                        </td>
                        <td class="t posts">
                            <a href="edit.php">Post</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="first b b_pages">
                            <a href="edit.php?post_type=page"><?php echo $num_pages; ?></a>
                        </td>
                        <td class="t pages">
                            <a href="edit.php?post_type=page">Page</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="first b b-cats">
                            <a href="edit-tags.php?taxonomy=category"><?php echo $num_cats; ?></a>
                        </td>
                        <td class="t cats">
                            <a href="edit-tags.php?taxonomy=category">Category</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="first b b-tags">
                            <a href="edit-tags.php"><?php echo $num_tags; ?></a>
                        </td>
                        <td class="t tags">
                            <a href="edit-tags.php">Tags</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table table_discussion">
            <p class="sub">Discussion</p>
            <table>
                <tbody>
                    <tr class="first">
                        <td class="b b-comments">
                            <a href="edit-comments.php">
                                <span class="total-count"><?php echo $num_all_comment; ?></span>
                            </a>
                        </td>
                        <td class="last t comments">
                            <a href="edit-comments.php">Comments</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="b b_approved">
                            <a href="edit-comments.php?comment_status=approved">
                                <span class="approved-count"><?php echo $num_approved_comment; ?></span>
                            </a>
                        </td>
                        <td class="last t">
                            <a href="edit-comments.php?comment_status=approved" class="approved">Approved</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="b b-waiting">
                            <a href="edit-comments.php?comment_status=moderated">
                                <span class="pending-count"><?php echo $num_pending_comment; ?></span>
                            </a>
                        </td>
                        <td class="last t">
                            <a href="edit-comments.php?comment_status=moderated" class="waiting">Pending</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="b b-spam">
                            <a href="edit-comments.php?comment_status=spam">
                                <span class="spam-count"><?php echo $num_spam_comment; ?></span>
                            </a>
                        </td>
                        <td class="last t">
                            <a href="edit-comments.php?comment_status=spam" class="spam">Spam</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

}
?>
