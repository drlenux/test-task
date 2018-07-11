<?php

require "vendor/predis/predis/autoload.php";

Predis\Autoloader::register();

class RedisAdapter
{
    /**
     * @var \Predis\Client
     */
    static private $redisClient;

    private function __construct()
    {
    }

    /**
     * @return \Predis\Client
     */
    static public function instance()
    {
        if (self::$redisClient === null) {
            $config = require "config.php";
            self::$redisClient = new Predis\Client($config['redis']['connect']);
        }
        return self::$redisClient;
    }
}

function clear()
{
    RedisAdapter::instance()->flushall();
}

/**
 * @param array $user
 * @return string
 * @throws \app\UserExistsException
 */
function create_user(array $user)
{
    $db = RedisAdapter::instance();
    if (count($db->hgetall($user['email']))) {
        throw new \app\UserExistsException();
    }

    $id = time() . mt_rand();
    $db->hmset($user['email'], $user);
    $db->hset($user['email'],'id', $id);
    return $id;

}

/**
 * @param $email
 * @param $password_hash
 * @return null|string
 */
function authorize_user($email, $password_hash) {
    $db = RedisAdapter::instance();
    $res = $db->hgetall($email);
    if (count($res) && ($res['password_hash'] === $password_hash)) {
        return $res['id'];
    }
    return null;
}

$user = [
    'name' => 'test',
    'email' => 'test@localhost',
    'password_hash' => md5('test')
];

clear();
var_dump(create_user($user));
var_dump(authorize_user($user['email'], $user['password_hash']));