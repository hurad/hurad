<?php

App::uses('HttpSocket', 'Network/Http');

/**
 * Class Akismet
 */
class Akismet
{

    const SCHEMA = 'http://';
    const HOST = 'rest.akismet.com';
    const API_VERSION = '1.1';

    public static function isVerifyAPIKey($data)
    {
        $result = self::postRequest($data, null, 'verify-key');
        if ($result['body'] == 'valid') {
            return true;
        }

        return false;
    }

    public static function isSpam($data, $key)
    {
        $result = self::postRequest($data, $key, 'comment-check');
        if ($result['body'] == 'true') {
            return true;
        }

        return false;
    }

    public static function submitSpam($data, $key)
    {
        $result = self::postRequest($data, $key, 'submit-spam');
        if (strlen($result['body']) == 41) {
            return true;
        }

        return false;
    }

    public static function submitHam($data, $key)
    {
        $result = self::postRequest($data, $key, 'submit-ham');
        if (strlen($result['body']) == 41) {
            return true;
        }

        return false;
    }

    protected static function postRequest($data, $key = null, $type = null)
    {
        $HttpSocket = new HttpSocket();

        switch ($type) {
            case 'verify-key':
                $requestURI = self::SCHEMA . self::HOST . '/' . self::API_VERSION . "/$type";
                break;
            case 'comment-check':
            case 'submit-spam':
            case 'submit-ham':
                $requestURI = self::SCHEMA . $key . '.' . self::HOST . '/' . self::API_VERSION . "/$type";
                break;
            default:
                $requestURI = '';
                break;
        }

        return $HttpSocket->post($requestURI, $data);
    }
}
