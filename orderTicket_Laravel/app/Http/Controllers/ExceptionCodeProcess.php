<?php

namespace App\Http\Controllers;

use Exception;

class ExceptionCodeProcess extends Controller
{
    protected $message = "";
    protected $href = "";

    public function __construct(Exception $e)
    {
        $this->message = "({$e->getCode()}) {$e->getMessage()}，如有疑問請聯絡系統管理員。";
        $this->href = "";

        switch ($e->getCode()) {
            case 11101: //'You DidNot Login.'
            case 11102: //"Wrong Input"
            case 11103: //"Can't Find Ticket"
            case 11104: //"Wrong GUID"
                $this->href = "/";
                break;
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getHref()
    {
        return $this->href;
    }
}
