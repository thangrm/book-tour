<?php

namespace App\Libraries;

class Notification
{
    const INFO = "info";
    const SUCCESS = "success";
    const WARNING = "warning";
    const ERROR = "error";

    public $message;
    public $type;

    public function __construct()
    {
        $this->type = Notification::INFO;
    }

    public function isInfo()
    {
        return $this->type == Notification::INFO;
    }

    public function isSucces()
    {
        return $this->type == Notification::SUCCESS;
    }

    public function isWarning()
    {
        return $this->type == Notification::WARNING;
    }

    public function isError()
    {
        return $this->type == Notification::ERROR;
    }

    public function setMessage($message, $type = Notification::INFO)
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function getMessage()
    {
        return array(
            'message' => $this->message,
            'alert-type' => $this->type,
        );
    }
}
