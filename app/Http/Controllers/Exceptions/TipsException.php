<?php

namespace App\Http\Controllers\Exceptions;

use Exception;

class TipsException extends Exception
{

    protected $links;
    protected $view;

    public function __construct($code, $message, $links = [], $view = 'errors.tips')
    {
        $this->message = $message;
        $this->links   = $links;
        $this->code    = $code;
        $this->view    = $view;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function ajaxReturn()
    {
        return [
            'code'  => $this->code,
            'msg'   => $this->message,
            'links' => $this->links,
        ];
    }

    public function get_view()
    {
        return $this->view;
    }
}
