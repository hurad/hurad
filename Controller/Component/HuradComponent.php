<?php
/**
 * Hurad Component
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */
App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Class HuradComponent
 */
class HuradComponent extends Component
{
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
     * Get content data
     *
     * @param       $contentId Content id
     * @param array $query     Find query
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

    public function sendEmail(
        $to,
        $subject,
        $template = 'default',
        $content = null,
        $viewVars = [],
        $options = []
    ) {
        $defaults = [
            'emailFormat' => 'html'
        ];

        $options = array_merge($defaults, $options);

        $email = new CakeEmail();
        $email->config('smtp');
        $email->config(['from' => ['info@hurad.org' => Configure::read('General.site_name')]]);
        $email->to($to);
        $email->setHeaders(['X-Mailer' => "Hurad Mail"]);
        $email->emailFormat($options['emailFormat']);
        $email->template($template);
        $email->viewVars($viewVars);
        $email->subject($subject);
        $email->send($content);
    }

    public function dateParse($date)
    {
        $dateArr = date_parse($date);
        $output = [
            'year' => $dateArr['year'],
            'month' => $dateArr['month'],
            'day' => $dateArr['day'],
            'hour' => $dateArr['hour'],
            'min' => $dateArr['minute'],
            'sec' => $dateArr['second']
        ];

        return $output;
    }

    /**
     * Retrieve full permalink for current content.
     *
     * @param int $contentId Post or Page id
     *
     * @return string
     */
    public function getPermalink($contentId)
    {
        $this->getContentData($contentId);

        $year = CakeTime::format('Y', $this->content[$this->contentModel]['created']);
        $month = CakeTime::format('m', $this->content[$this->contentModel]['created']);
        $day = CakeTime::format('d', $this->content[$this->contentModel]['created']);

        if ($this->contentType == 'post') {
            switch (Configure::read('Permalink.common')) {
                case 'default':
                    $permalink = Router::url("/p/" . $this->content[$this->contentModel]['id'], true);
                    break;

                case 'day_name':
                    $permalink = Router::url(
                        '/' . $year . "/" . $month . "/" . $day . "/" . $this->content[$this->contentModel]['slug'],
                        true
                    );
                    break;

                case 'month_name':
                    $permalink = Router::url(
                        '/' . $year . "/" . $month . "/" . $this->content[$this->contentModel]['slug'],
                        true
                    );
                    break;

                default:
                    break;
            }
        } elseif ($this->contentType == 'page') {
            if (Configure::read('Permalink.common') == 'default') {
                $permalink = Router::url(
                    "/page/" . $this->content[$this->contentModel]['id'],
                    true
                );
            } else {
                $permalink = Router::url(
                    "/page/" . $this->content[$this->contentModel]['slug'],
                    true
                );
            }
        }

        return $permalink;
    }
}
