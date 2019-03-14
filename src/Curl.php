<?php
namespace Radish\network;

/**
* @author Radish
*/
class Curl 
{
    protected static $curl = null;

    public static function init(array $options)
    {
        self::$curl = curl_init();

        if (isset($options['header'])) {
            $header = $options['header'];
            unset($options['header']);
            curl_setopt(self::$curl, CURLOPT_HTTPHEADER, $header);
        }
        $timeout = 10;
        if (isset($options['timeout'])) {
            $timeout = $options['timeout'];
            unset($options['timeout']);
        }
        if ($timeout >= 1) {
            curl_setopt(self::$curl, CURLOPT_TIMEOUT, $timeout);
        } else {
            curl_setopt(self::$curl, CURLOPT_TIMEOUT_MS, $timeout * 1000);
        }
        curl_setopt(self::$curl, CURLOPT_HEADER, false);
        curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt_array(self::$curl, $options);
    }

    protected static function end()
    {
        curl_close(self::$curl);
    }

    public static function get($url, $options = [])
    {
        static::init($options);

        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt(self::$curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(self::$curl, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec(self::$curl);

        static::end();

        return $result;
    }

    public static function post($url, $data, $options = [])
    {
        static::init($options);

        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt(self::$curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec(self::$curl);

        static::end();

        return $result;
    }

    public static function put($url, $data, $options = [])
    {
        static::init($options);

        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt(self::$curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec(self::$curl);

        static::end();

        return $result;
    }

    public static function delete($url, $options = [])
    {
        static::init($options);

        curl_setopt(self::$curl, CURLOPT_URL, $url);
        curl_setopt(self::$curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $result = curl_exec(self::$curl);

        static::end();

        return $result;
    }

    //待定
    public static function error()
    {
        return curl_error(self::$curl);
    }
}