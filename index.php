<?php
/*
    SevenStudio https://zhangqi6627.github.io/
    CopyRight 2013 www.fangbei.org  All Rights Reserved
*/
header('Content-type:text');
define("TOKEN", "helloworld");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
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
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $msgeType = $postObj->MsgType;
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            if($msgeType == "text"){
                if($keyword == "?" || $keyword == "？")
                {
                    $msgType = "text";
                    $contentStr = date("Y-m-d H:i:s",time());
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                elseif($keyword == "你好")
                {
                    $msgType = "text";
                    $contentStr = "hello";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                elseif($keyword == "hello")
                {
                    $msgType = "text";
                    $contentStr = "hello world";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                elseif($keyword == "爱" || $keyword == "我爱你")
                {
                    $msgType = "text";
                    $contentStr = "宝宝，我也爱你！";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                elseif($keyword == "不爱" || $keyword == "我不爱你")
                {
                    $msgType = "text";
                    $contentStr = "不可以！";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                elseif($keyword == "谁" || $keyword == "你是谁")
                {
                    $msgType = "text";
                    $contentStr = "我是你爹";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                elseif($keyword == "网络" || $keyword == "天气")
                {
                    $msgType = "text";
                    $contentStr = "我是你爹";
                    $url = 'http://www.baidu.com/';
                    $html = file_get_contents($url);
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                elseif($keyword == "图片")
                {
                    $msgType = "image";
$imageTpl = "
<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[%s]]></MsgType>
    <PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz/L4qjYtOibummHn90t1mnaibYiaR8ljyicF3MW7XX3BLp1qZgUb7CtZ0DxqYFI4uAQH1FWs3hUicpibjF0pOqLEQyDMlg/0]]></PicUrl>
    <Image><MediaId><![CDATA[DBVFRIj29LB2hxuYpc0R6VLyxwgyCHZPbRj_IIs6YaGhutyXUKtFSDcSCPeoqUYr]]></MediaId></Image>
</xml>";
                    $resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $msgType);
                    echo $resultStr;
                }
                else
                {
                    $msgType = "text";
                    $contentStr = "你爱我吗？";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
            }
            elseif($msgeType == "image")
            {
                $msgType = "text";
            }
        }else{
            echo "";
            exit;
        }
    }
}
?>
