<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Description of DashboardHelper
 *
 * @author mohammad
 */
class DashboardHelper extends AppHelper {

    public $helpers = array('Comment', 'Gravatar', 'Js', 'Html', 'Link');

    public function dashboard_recent_comments() {
        $comments = $this->_View->viewVars['comments'];

        if ($comments) {
            echo '<div id="the-comment-list" class="list:comment">';
            foreach ($comments as $comment)
                $this->_dashboard_recent_comments_row($comment);
            echo '</div>';
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
                        echo $this->Js->link(__('Approve'), array('controller' => 'comments', 'action' => 'action', 'approved', $this->Comment->get_comment_ID()), array(
                            'success' => 'cApprove(' . $this->Comment->get_comment_ID() . ')'
                                )
                        );
                        ?>
                    </span>
                    <span class="unapprove" <?php echo ($comment['Comment']['approved']) ? 'style=""' : 'style="display: none;"'; ?>>
                        <?php
                        echo $this->Js->link(__('Unapprove'), array('controller' => 'comments', 'action' => 'action', 'disapproved', $this->Comment->get_comment_ID()), array(
                            'success' => 'cUnapprove(' . $this->Comment->get_comment_ID() . ')'
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
                        <?php
                        echo $this->Js->link(__('Spam'), array('controller' => 'comments', 'action' => 'action', 'spam', $this->Comment->get_comment_ID()), array(
                            'success' => 'cSpam(' . $this->Comment->get_comment_ID() . ')'
                                )
                        );
                        ?>
                    </span>
                    <span class="trash">
                        |
                        <?php
                        echo $this->Js->link(__('Trash'), array('controller' => 'comments', 'action' => 'action', 'trash', $this->Comment->get_comment_ID()), array(
                            'success' => 'cTrash(' . $this->Comment->get_comment_ID() . ')'
                                )
                        );
                        ?>
                    </span>
                </p>
            </div>
        </div>
        <?php
    }

    public function dashboard_right_now() {
        $num_posts = ClassRegistry::init('Post')->countPosts();
        $num_pages = ClassRegistry::init('Page')->count_pages();
        $num_cats = ClassRegistry::init('Category')->count_cats();
        $num_tags = ClassRegistry::init('Tag')->count_tags();
        $num_all_comment = ClassRegistry::init('Comment')->count_comments('all');
        $num_approved_comment = ClassRegistry::init('Comment')->count_comments('approved');
        $num_pending_comment = ClassRegistry::init('Comment')->count_comments('moderated');
        $num_spam_comment = ClassRegistry::init('Comment')->count_comments('spam');
        ?>
        <div class="table table_content">
            <p class="sub"><?php echo __('Content'); ?></p>
            <table>
                <tbody>
                    <tr class="first">
                        <td class="first b b-posts">
                            <?php echo $this->Html->link($num_posts, array('controller' => 'posts', 'action' => 'index')); ?>
                        </td>
                        <td class="t posts">
                            <?php echo $this->Html->link(__('Post'), array('controller' => 'posts', 'action' => 'index')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first b b_pages">
                            <?php echo $this->Html->link($num_pages, array('controller' => 'pages', 'action' => 'index')); ?>
                        </td>
                        <td class="t pages">
                            <?php echo $this->Html->link(__('Page'), array('controller' => 'pages', 'action' => 'index')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first b b-cats">
                            <?php echo $this->Html->link($num_cats, array('controller' => 'categories', 'action' => 'index')); ?>
                        </td>
                        <td class="t cats">
                            <?php echo $this->Html->link(__('Category'), array('controller' => 'categories', 'action' => 'index')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first b b-tags">
                            <?php echo $this->Html->link($num_tags, array('controller' => 'tags', 'action' => 'index')); ?>
                        </td>
                        <td class="t tags">
                            <?php echo $this->Html->link(__('Tags'), array('controller' => 'tags', 'action' => 'index')); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table table_discussion">
            <p class="sub"><?php echo __('Discussion'); ?></p>
            <table>
                <tbody>
                    <tr class="first">
                        <td class="b b-comments">
                            <?php
                            echo $this->Html->link(
                                    $this->Html->tag('span', $num_all_comment, array('class' => 'total-count')), array('controller' => 'comments', 'action' => 'index'), array('escape' => FALSE)
                            );
                            ?>
                        </td>
                        <td class="last t comments">
                            <?php echo $this->Html->link(__('Comments'), array('controller' => 'comments', 'action' => 'index')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="b b_approved">
                            <?php
                            echo $this->Html->link(
                                    $this->Html->tag('span', $num_approved_comment, array('class' => 'approved-count')), array('controller' => 'comments', 'action' => 'filter', 'approved'), array('escape' => FALSE)
                            );
                            ?>
                        </td>
                        <td class="last t">
                            <?php echo $this->Html->link(__('Approved'), array('controller' => 'comments', 'action' => 'filter', 'approved'), array('class' => 'approved')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="b b-waiting">
                            <?php
                            echo $this->Html->link(
                                    $this->Html->tag('span', $num_pending_comment, array('class' => 'pending-count')), array('controller' => 'comments', 'action' => 'filter', 'moderated'), array('escape' => FALSE)
                            );
                            ?>
                        </td>
                        <td class="last t">
                            <?php echo $this->Html->link(__('Pending'), array('controller' => 'comments', 'action' => 'filter', 'moderated'), array('class' => 'waiting')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="b b-spam">
                            <?php
                            echo $this->Html->link(
                                    $this->Html->tag('span', $num_spam_comment, array('class' => 'spam-count')), array('controller' => 'comments', 'action' => 'filter', 'spam'), array('escape' => FALSE)
                            );
                            ?>
                        </td>
                        <td class="last t">
                            <?php echo $this->Html->link(__('Spam'), array('controller' => 'comments', 'action' => 'filter', 'spam'), array('class' => 'spam')); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

}