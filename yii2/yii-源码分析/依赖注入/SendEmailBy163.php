<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/9/25
 * Time: 11:37
 */

class SendEmailBy163 implements SendEmail
{

    public $name;
    public function __construct($name = '')
    {
        $this->name = $name;

    }

    public function send()
    {
        // TODO: Implement send() method.
        var_dump('send success:'.$this->name);
    }

}