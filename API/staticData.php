<?php

/**
 * 預設格式
 * {
 *      code: 200 //狀態碼
 *      msg: "回傳成功" //狀態訊息
 *      data: {
 *          //content
 *      }
 * }
 */

class staticData
{
    public static function jsFormat($code, $msg = "", $data = array())
    {
        if (!is_numeric($code)) {
            return "Error";
        }

        $result = array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        );

        return json_encode($result);
    }
}