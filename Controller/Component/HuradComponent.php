<?php

App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Description of Hurad
 *
 * @author mohammad
 */
class HuradComponent extends Component
{

    public function sendEmail(
        $to,
        $subject,
        $template = 'default',
        $content = null,
        $viewVars = array(),
        $options = array()
    ) {
        $defaults = array(
            'config' => 'smtp',
            'emailFormat' => 'html'
        );

        $options = array_merge($defaults, $options);

        $email = new CakeEmail();
        $email->config($options['config']);
        $email->from('info@hurad.org', Configure::read('General.site_name'));
        $email->to($to);
        $email->setHeaders(array('X-Mailer' => "Hurad Mail"));
        $email->emailFormat($options['emailFormat']);
        $email->template($template);
        $email->viewVars($viewVars);
        $email->subject($subject);
        $email->send($content);
    }

    public function dateParse($date)
    {
        $output = array();
        $dateArr = date_parse($date);
        $output = array(
            'year' => $dateArr['year'],
            'month' => $dateArr['month'],
            'day' => $dateArr['day'],
            'hour' => $dateArr['hour'],
            'min' => $dateArr['minute'],
            'sec' => $dateArr['second']
        );

        return $output;
    }

}