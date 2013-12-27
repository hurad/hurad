<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Description of DashboardHelper
 *
 * @author mohammad
 */
class DashboardHelper extends AppHelper
{

    public $helpers = array('Comment', 'Gravatar', 'Js', 'Html', 'Link');

    public function dashboard_recent_comments()
    {
        $comments = $this->_View->viewVars['comments'];

        if ($comments) {
            echo '<div id="the-comment-list" class="list:comment">';
            foreach ($comments as $comment) {
                $this->_dashboard_recent_comments_row($comment);
            }
            echo '</div>';
        } else {
            echo '<p>' . __d('hurad', 'No comments yet.') . '</p>';
        }
    }

    function _dashboard_recent_comments_row($comment)
    {
        $this->Comment->setComment($comment['Comment']);
        ?>

        <div id="comment-<?php $this->Comment->commentID(); ?>" <?php $this->Comment->commentClass(
            array('comment-item', $this->Comment->getCommentStatus($comment['Comment']['status']))
        ); ?>>
            <?php echo $this->Gravatar->image($this->Comment->getCommentAuthorEmail(), array('size' => '50')); ?>
            <div class="dashboard-comment-wrap">
                <h4 class="comment-meta">
                    <?php echo __d('hurad', 'From'); ?>
                    <cite class="comment-author">
                        <?php echo $this->Html->link(
                            $this->Comment->getCommentAuthor(),
                            HuradSanitize::url($this->Comment->getCommentAuthorUrl()),
                            array('class' => 'url', 'rel' => 'external nofollow')
                        ); ?>
                    </cite>
                    <?php echo __d('hurad', 'on'); ?>
                    <a href="http://localhost/wp3en/wp-admin/post.php?post=1&action=edit"><?php echo $comment['Post']['title']; ?></a>
                    <a class="comment-link" href="http://localhost/wp3en/?p=1#comment-3">#</a>
                    <span
                        class="approve" <?php echo ($comment['Comment']['status']) ? 'style="display: none;"' : 'style=""'; ?>><?php echo __(
                            '[Pending]'
                        ); ?></span>
                </h4>
                <blockquote>
                    <p><?php $this->Comment->commentExcerpt(); ?></p>
                </blockquote>

                <p class="row-actions">
                    <span
                        class="approve" <?php echo ($comment['Comment']['status']) ? 'style="display: none;"' : 'style=""'; ?>>
                        <?php
                        echo $this->Js->link(
                            __d('hurad', 'Approve'),
                            array(
                                'controller' => 'comments',
                                'action' => 'action',
                                'approved',
                                $this->Comment->getCommentID()
                            ),
                            array(
                                'success' => 'cApprove(' . $this->Comment->getCommentID() . ')'
                            )
                        );
                        ?>
                    </span>
                    <span
                        class="unapprove" <?php echo ($comment['Comment']['status']) ? 'style=""' : 'style="display: none;"'; ?>>
                        <?php
                        echo $this->Js->link(
                            __d('hurad', 'Unapprove'),
                            array(
                                'controller' => 'comments',
                                'action' => 'action',
                                'disapproved',
                                $this->Comment->getCommentID()
                            ),
                            array(
                                'success' => 'cUnapprove(' . $this->Comment->getCommentID() . ')'
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
                        <?php echo $this->Html->link(
                            __d('hurad', 'Edit'),
                            array(
                                'admin' => true,
                                'controller' => 'comments',
                                'action' => 'edit',
                                $this->Comment->getCommentID()
                            ),
                            array('title' => 'Edit comment')
                        ); ?>
                    </span>
                    <span class="spam">
                        |
                        <?php
                        echo $this->Js->link(
                            __d('hurad', 'Spam'),
                            array(
                                'controller' => 'comments',
                                'action' => 'action',
                                'spam',
                                $this->Comment->getCommentID()
                            ),
                            array(
                                'success' => 'cSpam(' . $this->Comment->getCommentID() . ')'
                            )
                        );
                        ?>
                    </span>
                    <span class="trash">
                        |
                        <?php
                        echo $this->Js->link(
                            __d('hurad', 'Trash'),
                            array(
                                'controller' => 'comments',
                                'action' => 'action',
                                'trash',
                                $this->Comment->getCommentID()
                            ),
                            array(
                                'success' => 'cTrash(' . $this->Comment->getCommentID() . ')'
                            )
                        );
                        ?>
                    </span>
                </p>
            </div>
        </div>
    <?php
    }

    public function dashboard_right_now()
    {
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
            <p class="sub"><?php echo __d('hurad', 'Content'); ?></p>
            <table>
                <tbody>
                <tr class="first">
                    <td class="first b b-posts">
                        <?php echo $this->Html->link(
                            $num_posts,
                            array('controller' => 'posts', 'action' => 'index')
                        ); ?>
                    </td>
                    <td class="t posts">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Post'),
                            array('controller' => 'posts', 'action' => 'index')
                        ); ?>
                    </td>
                </tr>
                <tr>
                    <td class="first b b_pages">
                        <?php echo $this->Html->link(
                            $num_pages,
                            array('controller' => 'pages', 'action' => 'index')
                        ); ?>
                    </td>
                    <td class="t pages">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Page'),
                            array('controller' => 'pages', 'action' => 'index')
                        ); ?>
                    </td>
                </tr>
                <tr>
                    <td class="first b b-cats">
                        <?php echo $this->Html->link(
                            $num_cats,
                            array('controller' => 'categories', 'action' => 'index')
                        ); ?>
                    </td>
                    <td class="t cats">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Category'),
                            array('controller' => 'categories', 'action' => 'index')
                        ); ?>
                    </td>
                </tr>
                <tr>
                    <td class="first b b-tags">
                        <?php echo $this->Html->link($num_tags, array('controller' => 'tags', 'action' => 'index')); ?>
                    </td>
                    <td class="t tags">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Tags'),
                            array('controller' => 'tags', 'action' => 'index')
                        ); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="table table_discussion">
            <p class="sub"><?php echo __d('hurad', 'Discussion'); ?></p>
            <table>
                <tbody>
                <tr class="first">
                    <td class="b b-comments">
                        <?php
                        echo $this->Html->link(
                            $this->Html->tag('span', $num_all_comment, array('class' => 'total-count')),
                            array('controller' => 'comments', 'action' => 'index'),
                            array('escape' => false)
                        );
                        ?>
                    </td>
                    <td class="last t comments">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Comments'),
                            array('controller' => 'comments', 'action' => 'index')
                        ); ?>
                    </td>
                </tr>
                <tr>
                    <td class="b b_approved">
                        <?php
                        echo $this->Html->link(
                            $this->Html->tag('span', $num_approved_comment, array('class' => 'approved-count')),
                            array('controller' => 'comments', 'action' => 'filter', 'approved'),
                            array('escape' => false)
                        );
                        ?>
                    </td>
                    <td class="last t">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Approved'),
                            array('controller' => 'comments', 'action' => 'filter', 'approved'),
                            array('class' => 'approved')
                        ); ?>
                    </td>
                </tr>
                <tr>
                    <td class="b b-waiting">
                        <?php
                        echo $this->Html->link(
                            $this->Html->tag('span', $num_pending_comment, array('class' => 'pending-count')),
                            array('controller' => 'comments', 'action' => 'filter', 'moderated'),
                            array('escape' => false)
                        );
                        ?>
                    </td>
                    <td class="last t">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Pending'),
                            array('controller' => 'comments', 'action' => 'filter', 'moderated'),
                            array('class' => 'waiting')
                        ); ?>
                    </td>
                </tr>
                <tr>
                    <td class="b b-spam">
                        <?php
                        echo $this->Html->link(
                            $this->Html->tag('span', $num_spam_comment, array('class' => 'spam-count')),
                            array('controller' => 'comments', 'action' => 'filter', 'spam'),
                            array('escape' => false)
                        );
                        ?>
                    </td>
                    <td class="last t">
                        <?php echo $this->Html->link(
                            __d('hurad', 'Spam'),
                            array('controller' => 'comments', 'action' => 'filter', 'spam'),
                            array('class' => 'spam')
                        ); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php
    }

}