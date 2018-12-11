<?php
class upyun{
    const END_POINT = "http://p0.api.upyun.com/pretreatment/";
    private $bucketname;
    private $username;
    private $password;
    private $ctimeout;

    public function __construct($bucketname, $username, $password, $ctimeout){

        $this->bucketname = $bucketname;
        $this->username = $username;
        $this->password = $password;
        $this->ctimeout = $ctimeout;

    }

    public function restupload($localpath, $savepath){

        $uri = "/pretreatment/";
        $date = gmdate('D, d M Y H:i:s \G\M\T');


        $accept="json";
        $service="{$this->bucketname}" ;
        $notify_url="https://hooks.upyun.com/S1cBduMkE";
        $source="/upyun/zlw.mp4" ;
        $task=array(
            array(
            "type"=> "thumbnail",
           "avopts"=>"/o/true/ss/00:00:02",
            "return_info"=>true,
            "save_as"=>"/upyun/ceshi.png"
        )
        );

      $tasks = base64_encode((json_encode($task)));
        $signature = base64_encode(hash_hmac("sha1", "POST&$uri&$date", md5("{$this->password}"), true));


        $header = array( "Authorization: UPYUN {$this->username}:$signature", "Date:$date");
        $body=array( "accrpt=$accept","service=$service", "notify_url=$notify_url","source=$source","tasks=$tasks" );
       $bodys=implode("&",$body);
        $ch=curl_init(self::END_POINT);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $bodys);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_exec($ch);
        $rsp_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo $rsp_code;

    }
}

$upyun = new upyun("", "", "", 36000);
$upyun->restupload("D:\\demo\\suol.png", "/a/suol.png");





?>
