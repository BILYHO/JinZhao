<?php
/**
 * Created by PhpStorm.
 * User: bilyho
 * Date: 17/8/12
 * Time: 22:27
 */
include_once "wxBizMsgCrypt.php";
include_once "send_templet.php";// 消息回复模板
include_once "log.php";

define("TOKEN", "bilyho123");
define("AppID", "wx7cf9e5466edfa6ce");
define("EncodingAESKey", "y94ezEBFwUOPt0Sbhe12kJch8rjrSretPQethOryIo0");

$wechatObj = new wechatCallbackapiTest();

//以下是微信的自动回复
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
} else {
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function __construct()
    {

    }

    //验证签名
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        //安全模式需要用到

        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
    public function responseMsg()
    {
        # Log对象 (调试日志)
        $log = Log::getInstance();

        //$log->LogMessage('test', Log::INFO, "Line:61");

        /**
            PHP7.0 已经废除了HTTP_RAW_POST_DATA
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
         */
        $postStr = file_get_contents("php://input");

        $timestamp = empty($_GET["timestamp"]) ? "" : trim($_GET["timestamp"]);
        $nonce = empty($_GET["nonce"]) ? "" : trim($_GET["nonce"]);
        $msg_sign = empty($_GET["msg_signature"]) ? "" : trim($_GET["msg_signature"]);

        # 收到消息后,先进行解密;

        /** 加密解密对象 */
            $pc = new WXBizMsgCrypt(TOKEN, EncodingAESKey, AppID);
            $xml_tree = new DOMDocument();
            $xml_tree->LoadXML($postStr);
            $array_e = $xml_tree->getElementsByTagName('Encrypt');
            $encrypt = $array_e->item(0)->nodeValue;

            $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
            $from_xml = sprintf($format, $encrypt);
            $msg = "";
            $errCode = $pc->decryptMsg($msg_sign, $timestamp, $nonce, $from_xml, $msg); // 解密消息
            //$log->LogMessage($errCode, Log::INFO, "Line:92");
        /** 加密解密对象 */

        $postObj = simplexml_load_string($msg, 'SimpleXMLElement', LIBXML_NOCDATA);

        //当前用户的openid
        $fromUsername = $postObj->FromUserName;

        //gh_77c477b3f1bb 公众号的原始ID
        $toUsername = $postObj->ToUserName;

        //用户发送给公众号的内容
        $content= trim($postObj->Content);

        //用户发送到公众号的消息类型(text\image\...)
        $msgType = trim($postObj->MsgType);

        $time = time();

        //不为0 表示解密不成功

        if ($errCode != 0){
            $contentStr = "系统正在维护请稍后尝试";
            $resultStr = sprintf(textTpl, $fromUsername, $toUsername, $time, $contentStr);
            echo $resultStr;
            return;
        }
        if ($msgType == 'text'){
            $contentStr = "欢迎~欢迎~热烈欢迎";
            $resultStr = sprintf(textTpl, $fromUsername, $toUsername, $time, $contentStr);
            echo $resultStr;
        }else{
            $contentStr = "客官~此功能还没开放呢";
            $resultStr = sprintf(textTpl, $fromUsername, $toUsername, $time, $contentStr);
            echo $resultStr;
        }
//        switch ($content != ''){
//            case  :
//
//
//                break;
//
//            default :
//
//        }
//
        echo '';
        exit;
    }

}