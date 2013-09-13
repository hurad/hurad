<?php

App::uses('HttpSocket', 'Network/Http');

/**
 * Description of Akismet
 *
 * @author mohammad
 */
class Akismet
{

    public static $protocol = 'http://';
    public static $host = 'rest.akismet.com';
    public static $apiVersion = '1.1';

    public function isVerifyAPIKey($data)
    {
        $result = self::_postRequest($data, null, 'verify-key');
        if ($result['body'] == 'valid') {
            return true;
        }
        return false;
    }

    public function isSpam($data, $key)
    {
        $result = self::_postRequest($data, $key, 'comment-check');
        if ($result['body'] == 'true') {
            return true;
        }
        return false;
    }

    public function submitSpam($data, $key)
    {
        $result = self::_postRequest($data, $key, 'submit-spam');
        if (strlen($result['body']) == 41) {
            return true;
        }
        return false;
    }

    public function submitHam($data, $key)
    {
        $result = self::_postRequest($data, $key, 'submit-ham');
        if (strlen($result['body']) == 41) {
            return true;
        }
        return false;
    }

    private function _postRequest($data, $key = null, $type = null)
    {
        $HttpSocket = new HttpSocket();

        if ($type == 'verify-key') {
            $requestURI = self::$protocol . self::$host . '/' . self::$apiVersion . '/verify-key';
        } elseif ($type == 'comment-check') {
            $requestURI = self::$protocol . $key . '.' . self::$host . '/' . self::$apiVersion . '/comment-check';
        } elseif ($type == 'submit-spam') {
            $requestURI = self::$protocol . $key . '.' . self::$host . '/' . self::$apiVersion . '/submit-spam';
        } elseif ($type == 'submit-ham') {
            $requestURI = self::$protocol . $key . '.' . self::$host . '/' . self::$apiVersion . '/submit-ham';
        } else {
            return false;
        }

        return $HttpSocket->post($requestURI, $data);
    }

}