<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Class PostHelper
 */
class ContentHelper extends AppHelper
{

    /**
     * Other helpers used by this helper.
     *
     * @var array
     * @access public
     */
    public $helpers = ['Html', 'Time', 'General', 'Link', 'Hook', 'Author', 'Comment'];

    /**
     * Current content array.
     *
     * @var array
     * @access public
     */
    public $content = [];

    /**
     * Content model.
     */
    public $contentModel = null;

    /**
     * Content type
     */
    public $contentType = null;

    /**
     * Constructor method
     *
     * @param View $View
     * @param array $settings
     */
    public function __construct(\View $View, $settings = [])
    {
        parent::__construct($View, $settings);
        $this->init();
    }

    /**
     * Initialize post helper
     *
     * @return bool
     */
    protected function init()
    {
        if ($this->_View->viewPath == 'Posts') {
            if ($this->_View->view == 'view' || $this->_View->view == 'viewByid') {
                $this->setContent($this->_View->get('post'), 'post');
                $this->Link->setModel('Post');
                $this->Link->content = $this->General->content = $this->Comment->content = $this->post = $this->_View->get(
                    'post'
                );
            }
        } elseif ($this->_View->viewPath == 'Pages') {
            if ($this->_View->view == 'view' || $this->_View->view == 'viewByid') {
                $this->setContent($this->_View->get('page'), 'page');
                $this->Link->setModel('Page');
                $this->Link->content = $this->General->content = $this->Comment->content = $this->content = $this->_View->get(
                    'page'
                );
            }
        }
    }

    /**
     * Set post in loop
     *
     * @param array $content
     * @param string $type Content type, post or page
     *
     * @internal param array $post
     */
    public function setContent(array $content, $type)
    {
        $this->content = $content;
        $this->contentModel = ucfirst($type);
        $this->contentType = $type;

        $this->General->content = $content;

        $this->Link->content = $this->Comment->content = $content;
        $this->Link->setModel($this->contentModel);

        $this->Author->setAuthor(
            $this->content[$this->contentModel]['user_id'],
            $this->content[$this->contentModel]['id']
        );
    }

    /**
     * Get content data
     *
     * @param $contentId Content id
     * @param array $query Find query
     */
    public function getContentData($contentId, array $query = [])
    {
        if (!is_null($contentId)) {
            if ($post = ClassRegistry::init('Post')->getPost($contentId, $query)) {
                $this->content = $post;
                $this->contentModel = ucfirst($post['Post']['type']);
                $this->contentType = $post['Post']['type'];
            } elseif ($page = ClassRegistry::init('Page')->getPage($contentId, $query)) {
                $this->content = $page;
                $this->contentModel = ucfirst($page['Page']['type']);
                $this->contentType = $page['Page']['type'];
            }
        }
    }

    /**
     * Retrieve the ID of the current item in the Loop.
     *
     * @return int
     */
    public function getId()
    {
        return $this->Hook->applyFilters(
            "Helper.{$this->contentModel}.getId",
            $this->content[$this->contentModel]['id']
        );
    }

    /**
     * Retrieve post title.
     *
     * @param int $postId Post id
     *
     * @return string
     */
    public function getTitle($postId = null)
    {
        $this->getContentData($postId);

        $title = isset($this->content[$this->contentModel]['title']) ? $this->content[$this->contentModel]['title'] : '';

        return $this->Hook->applyFilters("Helper.{$this->contentModel}.getTitle", $title);
    }

    /**
     * Retrieve the post content.
     *
     * @param int $contentId Post or Page id
     * @param string $moreLinkText Optional. Content for when there is more text.
     *
     * @return string
     */
    public function getContent($moreLinkText = null, $contentId = null)
    {
        $this->getContentData($contentId);

        if (null === $moreLinkText) {
            $moreLinkText = __d('hurad', '(more...)');
        }

        $more = false;
        $output = '';
        $content = $this->content[$this->contentModel]['content'];

        if (preg_match('/<!--more(.*?)?-->/', $content, $matches)) {
            $more = true;
            $content = explode($matches[0], $content, 2);
            if (!empty($matches[1]) && !empty($moreLinkText)) {
                $moreLinkText = strip_tags(trim($matches[1]));
            }
        } else {
            $content = [$content];
        }

        $teaser = $content[0];
        $output .= $teaser;

        if (count($content) > 1) {
            if ($more && $this->_View->view == 'view') {
                $output .= $this->Html->tag('span', null, ['id' => 'more-' . $this->getId()]) . $content[1];
            } else {
                if (!empty($moreLinkText)) {
                    $moreLink = $this->Html->link(
                        $moreLinkText,
                        $this->getPermalink($contentId) . '#more-' . $this->getId(),
                        ['class' => 'more-link']
                    );
                    $output .= $this->Hook->applyFilters(
                        "Helper.{$this->contentModel}.getContent.moreLink",
                        $moreLink,
                        $moreLinkText
                    );
                }
            }
        }

        return $this->Hook->applyFilters("Helper.{$this->contentModel}.getContent", $output);
    }

    /**
     * Retrieve the post excerpt.
     *
     * @param int $contentId Post or Page id
     *
     * @return string
     */
    public function getExcerpt($contentId = null)
    {
        $this->getContentData($contentId);

        return $this->Hook->applyFilters(
            "Helper.{$this->contentModel}.getExcerpt",
            $this->content[$this->contentModel]['excerpt']
        );
    }

    /**
     * Whether post has excerpt.
     *
     * @param int $contentId Post or Page id
     *
     * @return bool
     */
    public function hasExcerpt($contentId = null)
    {
        $this->getContentData($contentId);

        return $this->Hook->applyFilters(
            "Helper.{$this->contentModel}.hasExcerpt",
            (!empty($this->content[$this->contentModel]['excerpt']))
        );
    }

    /**
     * Retrieve the classes for the post div as an string.
     *
     * @param string|array $class One or more classes to add to the class list.
     * @param int $contentId Post or Page id
     *
     * @return array Array of classes.
     */
    public function getClass($class = '', $contentId = null)
    {
        $this->getContentData($contentId);
        $classes = [];

        if (!HuradFunctions::isAdmin()) {
            $classes[] = $this->content[$this->contentModel]['type'];
        }

        $classes[] = $this->contentType . '-' . $this->content[$this->contentModel]['id'];
        $classes[] = 'type-' . $this->content[$this->contentModel]['type'];
        $classes[] = 'status-' . $this->content[$this->contentModel]['status'];

        if (!empty($class)) {
            if (!is_array($class)) {
                $class = preg_split('#\s+#', $class);
            }
            $classes = array_merge($classes, $class);
        }

        $classes = array_map('HuradSanitize::htmlClass', $classes);
        $classes = implode(' ', $classes);

        return $this->Hook->applyFilters("Helper.{$this->contentModel}.getClass", $classes, $class);
    }

    /**
     * Retrieve the post categories.
     *
     * @param string $separator Categories separator
     * @param int $contentId Post or Page id
     *
     * @return string
     */
    public function getCategories($separator = ', ', $contentId = null)
    {
        $this->getContentData($contentId, ["recursive" => 1]);
        $cat = [];

        foreach ($this->content['Category'] as $category) {
            if (isset($this->request->params['admin'])) {
                $cat[] = $this->Html->link(
                    $category['name'],
                    ['admin' => true, 'controller' => 'posts', 'action' => 'listBycategory', $category['id']],
                    ['title' => __d('hurad', 'View all posts in %s', $category['name']), 'rel' => 'category']
                );
            } else {
                $cat[] = $this->Html->link(
                    $category['name'],
                    $this->Link->siteUrl('/') . 'category/' . $category['slug'],
                    ['title' => __d('hurad', 'View all posts in %s', $category['name']), 'rel' => 'category']
                );
            }
        }

        if ($separator == '') {
            $separator = ', ';
        }

        $catStr = implode($separator, $cat);

        return $this->Hook->applyFilters("Helper.Post.getCategory", $catStr, $cat);
    }

    /**
     * Retrieve the post tags.
     *
     * @param string $separator Tags separator
     * @param string $before Before tags
     * @param string $after After tags
     * @param int $contentId Post or Page id
     *
     * @return string
     */
    public function getTags($separator = ', ', $before = null, $after = null, $contentId = null)
    {
        $this->getContentData($contentId, ["recursive" => 1]);
        $term = [];

        if ($before) {
            $term[] = $before;
        }

        foreach ($this->content['Tag'] as $tag) {
            if (isset($this->request->params['admin'])) {
                $term[] = $this->Html->link(
                    $tag['name'],
                    ['admin' => true, 'controller' => 'posts', 'action' => 'listByTag', $tag['id']],
                    ['title' => __d('hurad', 'View all posts in %s', $tag['name']), 'rel' => 'tag']
                );
            } else {
                $term[] = $this->Html->link(
                    $tag['name'],
                    $this->Link->siteUrl('/') . 'tag/' . $tag['slug'],
                    ['title' => __d('hurad', 'View all posts in %s', $tag['name']), 'rel' => 'tag']
                );
            }
        }

        if ($after) {
            $term[] = $after;
        }

        if ($separator == '') {
            $separator = ', ';
        }

        $termStr = implode($separator, $term);

        return $this->Hook->applyFilters("Helper.Post.getTags", $termStr, $term);
    }

    /**
     * Whether post has excerpt.
     *
     * @param int $contentId Post or Page id
     *
     * @return bool
     */
    public function hasTags($contentId = null)
    {
        $this->getContentData($contentId);

        return $this->Hook->applyFilters(
            "Helper.{$this->contentModel}.hasTags",
            (!empty($this->content['Tag']))
        );
    }

    /**
     * Retrieve full permalink for current content.
     *
     * @param int $contentId Post or Page id
     *
     * @return string
     */
    public function getPermalink($contentId = null)
    {
        $this->getContentData($contentId);

        $year = $this->Time->format('Y', $this->content[$this->contentModel]['created']);
        $month = $this->Time->format('m', $this->content[$this->contentModel]['created']);
        $day = $this->Time->format('d', $this->content[$this->contentModel]['created']);

        if ($this->contentType == 'post') {
            switch (Configure::read('Permalink.common')) {
                case 'default':
                    $permalink = $this->Html->url(
                        $this->Link->siteUrl('/') . "p/" . $this->content[$this->contentModel]['id']
                    );
                    break;
                case 'day_name':
                    $permalink = $this->Html->url(
                        $this->Link->siteUrl(
                            '/'
                        ) . $year . "/" . $month . "/" . $day . "/" . $this->content[$this->contentModel]['slug']
                    );
                    break;
                case 'month_name':
                    $permalink = $this->Html->url(
                        $this->Link->siteUrl(
                            '/'
                        ) . $year . "/" . $month . "/" . $this->content[$this->contentModel]['slug']
                    );
                    break;
                default:
                    break;
            }
        } elseif ($this->contentType == 'page') {
            if (Configure::read('Permalink.common') == 'default') {
                $permalink = $this->Html->url(
                    $this->Link->siteUrl('/') . "page/" . $this->content[$this->contentModel]['id']
                );
            } else {
                $permalink = $this->Html->url(
                    $this->Link->siteUrl('/') . "page/" . $this->content[$this->contentModel]['slug']
                );
            }
        }

        return $this->Hook->applyFilters("Helper.{$this->contentModel}.getPermalink", $permalink);
    }

    /**
     * Retrieve the date the current $post was written.
     *
     * @param string $format Optional. PHP date format defaults to the date_format option if not specified.
     *
     * @return string|null Null if displaying, string if retrieving.
     */
    public function getDate($format = '')
    {
        return $this->General->getTheDate($format);
    }

    public function listCategories(array $args = [])
    {
        $defaults = [
            'direction' => 'asc',
            'sort' => 'name'
        ];

        $requestParams = Hash::merge($defaults, $args);
        $cats = $this->requestAction(
            '/categories/index/sort:' . $requestParams['sort'] . '/direction:' . $requestParams['direction']
        );

        $output = $this->categoryTreeRender($cats);

        return $this->Hook->applyFilters('Helper.Post.listCategories', $output, $cats, $args);
    }

    /**
     * Returns a category nested list for data generated by find('threaded')
     *
     * @param array $cats Data generated by find('threaded')
     *
     * @return string HTML for nested list
     * */
    public function categoryTreeRender(array $cats)
    {
        $out = null;

        foreach ($cats as $cat) {
            $out .= '<li class="cat-item cat-item-' . $cat['Category']['id'] . '">';
            $out .= $this->Html->link(
                $cat['Category']['name'],
                $this->Link->siteUrl('/') . 'category/' . $cat['Category']['slug']
            );
            $out .= ' (' . $cat['Category']['post_count'] . ')';

            if (isset($cat['children']) && !empty($cat['children'])) {
                $out .= '<ul class="children">';
                $out .= $this->categoryTreeRender($cat['children']);
                $out .= '</ul>';
            }
            $out .= '</li>';
        }

        return $out;
    }

    public function listPages($args = '')
    {
        $defaults = array(
            'direction' => 'asc',
            'sort' => 'title',
            'echo' => 1,
            'link_before' => '',
            'link_after' => '',
        );

        $mixedArgs = HuradFunctions::parseArgs($args, $defaults);
        $pages = $this->requestAction(
            '/pages/pageIndex/sort:' . $mixedArgs['sort'] . '/direction:' . $mixedArgs['direction']
        );

        if (count($pages) > 0) {
            $output = $this->pageTreeRender($pages);
        } else {
            $output = __d('hurad', 'No pages were found');
        }

        return $this->Hook->applyFilters('Helper.Page.listPages', $output, $pages, $mixedArgs);
    }

    /**
     * Returns a page nested list for data generated by find('threaded')
     *
     * @param $pages array Data generated by find('threaded')
     *
     * @return string HTML for nested list
     */
    public function pageTreeRender($pages)
    {
        $out = null;
        foreach ($pages as $page) {
            $this->setContent($page, 'page');
            $out .= '<li class="page_item page-item-' . $page['Page']['id'] . '">';
            $out .= $this->Html->link($page['Page']['title'], $this->getPermalink($page['Page']['id']));
            if (isset($page['children']) && !empty($page['children'])) {
                $out .= '<ul class="children">';
                $out .= $this->pageTreeRender($page['children']);
                $out .= '</ul>';
            }
            $out .= '</li>';
        }

        return $out;
    }
}
