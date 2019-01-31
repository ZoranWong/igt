<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 7:57 PM
 */

namespace Zoran\IGt;

use Zoran\IGt\IGetui\Target;
use Zoran\IGt\IGetui\Utils\ApiUrlRespectUtils;
use Zoran\IGt\IGetui\Utils\GTConfig;
use Zoran\IGt\IGetui\Utils\HttpManager;
use Zoran\IGt\IGetui\Utils;
use Zoran\IGt\IGetui\Message;
Class Push
{
    var $appKey; //第三方 标识
    var $masterSecret; //第三方 密钥
    var $format = "json"; //默认为 json 格式
    var $host ="";
    var $needDetails = false;
    static $appKeyUrlList = array();
    var $domainUrlList =  array();
    var $useSSL = NULL; //是否使用https连接 以该标志为准
    var $authToken;

    /**
     * @param $domainUrl
     * @param $appKey
     * @param $masterSecret
     * @param null $ssl
     * @throws \Exception
     */
    public function __construct($domainUrl, $appKey, $masterSecret, $ssl = NULL)
    {
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;

        $domainUrl = trim($domainUrl);
        if ($ssl == NULL && $domainUrl != NULL && strpos(strtolower($domainUrl), "https:") === 0) {
            $ssl = true;
        }

        $this->useSSL = ($ssl == NULL ? false : $ssl);


        if ($domainUrl == NULL || strlen($domainUrl) == 0) {
            $this->domainUrlList =  Utils\GTConfig::getDefaultDomainUrl($this->useSSL);
        } else {
            $this->domainUrlList = array($domainUrl);
        }
        $this->initOSDomain(null);
    }

    /**
     * @param array $hosts
     * @return mixed|string
     * @throws \Exception
     */
    private function initOSDomain($hosts)
    {
        if($hosts == null || count($hosts) == 0) {
            $hosts = isset(Push::$appKeyUrlList[$this->appKey]) ? Push::$appKeyUrlList[$this->appKey] : null;
            if($hosts == null || count($hosts) == 0) {
                $hosts = $this->getOSPushDomainUrlList($this->domainUrlList,$this->appKey);
                Push::$appKeyUrlList[$this->appKey] = $hosts;
            }
        } else {
            Push::$appKeyUrlList[$this->appKey] = $hosts;
        }
        $this->host = ApiUrlRespectUtils::getFastest($this->appKey, $hosts);
        return $this->host;
    }

    /**
     * @param $domainUrlList
     * @param $appKey
     * @return null
     * @throws \Exception
     */
    public function getOSPushDomainUrlList($domainUrlList, $appKey)
    {
        $urlList = null;
        $postData = array();
        $postData['action']='getOSPushDomainUrlListAction';
        $postData['appKey'] = $appKey;
        $ex = null;
        foreach($domainUrlList as $url) {
            try {
                $response = $this->httpPostJSON($url, $postData);
                $urlList =  isset($response["osList"]) ? $response["osList"] : null;
                if($urlList != null && count($urlList) > 0) {
                    break;
                }
            } catch (\Exception $e) {
                $ex = $e;
            }
        }

        if($urlList == null || count($urlList) <= 0) {
            $h = implode(',', $domainUrlList);
            throw new \Exception("Can not get hosts from ". $h. "|error:" . $ex);
        }
        return $urlList;
    }

    /**
     * @param $url
     * @param $data
     * @param bool $gzip
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    function httpPostJSON($url, $data, $gzip=false)
    {
        $data['version'] = GTConfig::getSDKVersion();
        $data['authToken'] = $this->authToken;
        if($url == null){
            $url = $this->host;
        }
        $rep = HttpManager::httpPost($url, $data, $gzip);
        if($rep != null) {
            if ( 'sign_error' == $rep['result']) {
                try {
                    if ($this->connect()) {
                        $data['authToken'] = $this->authToken;
                        $rep = HttpManager::httpPost($url, $data, $gzip);
                    }
                } catch (\Exception $e) {
                    throw new \Exception("连接异常".$e);
                }
            } else if('domain_error' == $rep['result']) {
                $this->initOSDomain(isset($rep["osList"]) ? $rep["osList"] : null);
                $rep = HttpManager::httpPost($url, $data, $gzip);
            }
        }
        return $rep;
    }

    /**
     * @throws
     * */
    public  function connect()
    {
        $timeStamp = $this->microTime();
        // 计算sign值
        $sign = md5($this->appKey . $timeStamp . $this->masterSecret);
        $params = array();

        $params["action"] = "connect";
        $params["appKey"] = $this->appKey;
        $params["timeStamp"] = $timeStamp;
        $params["sign"] = $sign;
        $params["version"] = GTConfig::getSDKVersion();
        $rep = HttpManager::httpPost($this->host,$params,false);
        if ('success' == $rep['result']) {
            if($rep["authtoken"] != null){
                $this->authToken = $rep["authtoken"];
            }
            return true;
        }
        throw new \Exception("appKey Or masterSecret is Auth Failed");
    }

    public function close()
    {
        $params = array();
        $params["action"] = "close";
        $params["appKey"] = $this->appKey;
        $params["version"] = GTConfig::getSDKVersion();
        $params["authtoken"] = $this->authToken;
        HttpManager::httpPost($this->host,$params,false);
    }

    /**
     *  指定用户推送消息
     * @param $message
     * @param $target
     * @param null $requestId
     * @return Array {result:successed_offline,taskId:xxx}  || {result:successed_online,taskId:xxx} || {result:error}
     *
     * @throws \Exception
     */
    public function pushMessageToSingle($message, $target, $requestId = null)
    {
        if($requestId == null || trim($requestId) == "")
        {
            $requestId = Utils\LangUtils::randomUUID();
        }
        $params = $this->getSingleMessagePostData($message, $target, $requestId);
        return $this->httpPostJSON($this->host,$params);
    }


    function getSingleMessagePostData(Message\BaseMessage $message, Target $target, $requestId = null){
        $params = array();
        $params["action"] = "pushMessageToSingleAction";
        $params["appKey"] = $this -> appKey;
        if($requestId != null)
        {
            $params["requestId"] = $requestId;
        }

        $params["clientData"] = base64_encode($message->data->transparent);
        $params["transmissionContent"] = $message->data->transmissionContent;
        $params["isOffline"] = $message->isOffline;
        $params["offlineExpireTime"] = $message->offlineExpireTime;
        // 增加pushNetWorkType参数(0:不限;1:wifi;2:4G/3G/2G)
        $params["pushNetWorkType"] = $message->pushNetWorkType;

        //
        $params["appId"] = $target->appId;
        $params["clientId"] = $target->clientId;
        $params["alias"] = $target->alias;
        // 默认都为消息
        $params["type"] = 2;
        $params["pushType"] = $message->data->pushType;
        return $params;
    }


    /**
     * @param Message\BaseMessage $message
     * @param null|string $taskGroupName
     * @return string
     * @throws \Exception
     */
    public function getContentId($message, $taskGroupName = null)
    {
        return $this->getListAppContentId($message,$taskGroupName);
    }

    /**
     *  取消消息
     * @param  String  contentId
     * @return boolean
     *
     * @throws \Exception
     */
    public function cancelContentId($contentId)
    {
        $params = array();
        $params["action"] = "cancleContentIdAction";
        $params["appKey"] = $this->appKey;
        $params["contentId"] = $contentId;
        $rep = $this->httpPostJSON($this->host, $params);
        return $rep['result'] == 'ok' ? true : false;
    }

    /**
     * 用户黑名单接口
     * @param $appId
     * @param $cidList
     * @param $optType
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    private function blackCidList($appId, $cidList, $optType){
        $params = array();
        $limit = GTConfig::getMaxLenOfBlackCidList();
        if($limit < count($cidList)){
            throw new \Exception("cid size:".count($cidList)." beyond the limit:".$limit);
        }
        $params["action"] = "blackCidAction";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["cidList"] = $cidList;
        $params["optType"] = $optType;
        return $this->httpPostJSON($this->host, $params);
    }

    /**
     * @param $appId
     * @param $cidList
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function  addCidListToBlk($appId, $cidList){

        return $this->blackCidList($appId, $cidList, 1);

    }

    /**
     * @param $appId
     * @param $cidList
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function  restoreCidListFromBlk($appId, $cidList){

        return $this->blackCidList($appId, $cidList, 2);

    }

    /**
     *  批量推送信息
     * @param $contentId
     * @param Target[] $targetList
     * @return Array {result:successed_offline,taskId:xxx}  || {result:successed_online,taskId:xxx} || {result:error}
     *
     * @throws \Exception
     */
    public function pushMessageToList($contentId, $targetList)
    {
        $params = array();
        $params["action"] = "pushMessageToListAction";
        $params["appKey"] = $this->appKey;//?
        $params["contentId"] = $contentId;
        $needDetails = GTConfig::isPushListNeedDetails();
        $params["needDetails"] = $needDetails;
        $async = GTConfig::isPushListAsync();
        $params["async"] = $async;
        if($async && (!$needDetails))
        {
            $limit = GTConfig::getAsyncListLimit();
        }
        else
        {
            $limit = GTConfig::getSyncListLimit();
        }
        if(count($targetList) > $limit)
        {
            throw new \Exception("target size:" . count($targetList) . " beyond the limit:" . $limit);
        }
        $clientIdList = array();
        $aliasList= array();
        $appId = null;
        foreach($targetList as $target)
        {
            $targetCid = $target->clientId;
            $targetAlias = $target->alias;
            if($targetCid != null) {
                array_push($clientIdList, $targetCid);
            } elseif ($targetAlias != null) {
                array_push($aliasList, $targetAlias);
            }

            if($appId == null) {
                $appId = $target->appId;
            }
        }
        $params["appId"] = $appId;
        $params["clientIdList"] = $clientIdList;
        $params["aliasList"] = $aliasList;
        $params["type"] = 2;
        return $this->httpPostJSON($this->host,$params,true);
    }

    /**
     * @param
     * @return bool
     * @throws \Exception
     */
    public function stop($contentId)
    {
        $params = array();
        $params["action"] = "stopTaskAction";
        $params["appKey"] = $this->appKey;
        $params["contentId"] = $contentId;
        $rep = $this->httpPostJSON($this->host, $params);
        if ("ok" == $rep["result"]) {
            return true;
        }
        return false;
    }


    /**
     * @param $appId
     * @param $clientId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function getClientIdStatus($appId, $clientId)
    {
        $params = array();
        $params["action"] = "getClientIdStatusAction";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["clientId"] = $clientId;
        return $this->httpPostJSON($this->host, $params);
    }

    /**
     * @param $appId
     * @param $clientId
     * @param $tags
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public  function setClientTag($appId, $clientId, $tags)
    {
        $params = array();
        $params["action"] = "setTagAction";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["clientId"] = $clientId;
        $params["tagList"] = $tags;
        return $this->httpPostJSON($this->host, $params);
    }

    /**
     * 设置 iphone Badge
     * @param $badge
     * @param $appId
     * @param $deviceTokenList
     * @param $cidList
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */

    private function setBadge($badge, $appId, $deviceTokenList, $cidList){
        $params = array();
        $params["action"] = "setBadgeAction";
        $params["appKey"] = $this->appKey;
        $params["badge"] = $badge;
        $params["appId"] = $appId;
        $params["deviceToken"] = $deviceTokenList;
        $params["cid"] = $cidList;
        return $this->httpPostJSON($this->host, $params);

    }

    /**
     * @param $badge
     * @param $appid
     * @param $cidList
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function setBadgeForCID($badge, $appid, $cidList){

        return $this->setBadge($badge, $appid, array(), $cidList);

    }

    /**
     * @param $badge
     * @param $appid
     * @param $deviceTokenList
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function setBadgeForDeviceToken($badge, $appid, $deviceTokenList){

        return $this->setBadge($badge, $appid, $deviceTokenList, array());

    }

    /**
     * @param $message
     * @param null $taskGroupName
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function pushMessageToApp($message, $taskGroupName = null)
    {
        $contentId = $this->getListAppContentId($message, $taskGroupName);
        $params = array();
        $params["action"] = "pushMessageToAppAction";
        $params["appKey"] = $this->appKey;
        $params["contentId"] = $contentId;
        $params["type"] = 2;
        return $this->httpPostJSON($this->host,$params);
    }

    /**
     * @param Message\BaseMessage|Message\ListMessage|Message\AppMessage $message
     * @param null|string $taskGroupName
     * @return string
     * @throws \Exception
     */
    private function getListAppContentId($message, $taskGroupName = null)
    {
        $params = array();
        if (!is_null($taskGroupName) && trim($taskGroupName) != ""){
            if(strlen($taskGroupName) > 40){
                throw new \Exception("TaskGroupName is OverLimit 40");
            }
            $params["taskGroupName"] = $taskGroupName;
        }
        $params["action"] = "getContentIdAction";
        $params["appKey"] = $this->appKey;
        $params["clientData"] = base64_encode($message->data->transparent);
        $params["transmissionContent"] = $message->data->transmissionContent;
        $params["isOffline"] = $message->isOffline;
        $params["offlineExpireTime"] = $message->offlineExpireTime;
        // 增加pushNetWorkType参数(0:不限;1:wifi;2:4G/3G/2G)
        $params["pushNetWorkType"] = $message->pushNetWorkType;
        $params["pushType"] = $message->data->pushType;
        $params["type"] = 2;
        //contentType 1是appMessage，2是listMessage
        if ($message instanceof Message\ListMessage){
            $params["contentType"] = 1;
        } else {
            $params["contentType"] = 2;
            $params["appIdList"] = $message->appIdList;
            $params["speed"] = $message->speed;
            //定时时间
            if($message->pushTime !== null && !empty($message->pushTime)){
                $params["pushTime"] = $message->pushTime;
            }
            if($message->conditions == null) {
                $params["phoneTypeList"] = $message->phoneTypeList;
                $params["provinceList"] = $message->provinceList;
                $params["tagList"] = $message->tagList;
            } else {
                $conditions = $message->conditions;
                $params["conditions"] = $conditions->condition;
            }
        }
        $rep = $this->httpPostJSON($this->host, $params);
        if($rep['result'] == 'ok')
        {
            return $rep['contentId'];
        }else{
            throw new \Exception("host:[".$this->host."]" + "获取contentId失败:" . $rep);
        }
    }

    public function getBatch()
    {
        return new Batch($this->appKey, $this);
    }

    /**
     * @param $appId
     * @param $deviceToken
     * @param Message\BaseMessage $message
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function pushAPNMessageToSingle($appId, $deviceToken,  $message)
    {
        $params = array();
        $params['action'] = 'apnPushToSingleAction';
        $params['appId'] = $appId;
        $params['appKey'] = $this->appKey;
        $params['DT'] = $deviceToken;
        $params['PI'] = base64_encode($message->data->pushInfo->serializeToString());
        return $this->httpPostJSON($this->host,$params);
    }

    /**
     * 根据deviceTokenList群推
     * @param $appId
     * @param $contentId
     * @param $deviceTokenList
     * @return mixed
     * @throws \Exception
     */
    public function pushAPNMessageToList($appId, $contentId, $deviceTokenList)
    {
        $params = array();
        $params["action"] = "apnPushToListAction";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["contentId"] = $contentId;
        $params["DTL"] = $deviceTokenList;
        $needDetails = GTConfig::isPushListNeedDetails();
        $params["needDetails"]=$needDetails;
        return $this->httpPostJSON($this->host,$params);
    }

    /**
     * 获取apn contentId
     * @param $appId
     * @param $message
     * @return string
     * @throws \Exception
     */
    public function getAPNContentId($appId, $message)
    {
        $params = array();
        $params["action"] = "apnGetContentIdAction";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["PI"] = base64_encode($message->data->pushInfo->serializeToString());
        $rep = $this->httpPostJSON($this->host,$params);
        if($rep['result'] == 'ok'){
            return $rep['contentId'];
        }else{
            throw new \Exception("host:[".$this->host."]" + "获取contentId失败:".$rep);
        }
    }

    /**
     * @param $appId
     * @param $alias
     * @param $clientId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function bindAlias($appId, $alias, $clientId)
    {
        $params = array();
        $params["action"] = "alias_bind";
        $params["appKey"] = $this->appKey;
        $params["appid"] = $appId;
        $params["alias"] = $alias;;
        $params["cid"] = $clientId;
        return $this->httpPostJSON($this->host, $params);
    }

    /**
     * @param $appId
     * @param Target[] $targetList
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function bindAliasBatch($appId, $targetList)
    {
        $params = array();
        $aliasList = array();
        foreach($targetList as  $target) {
            $user = array();
            $user["cid"] = $target->clientId;
            $user["alias"] = $target->alias;
            array_push($aliasList, $user);
        }
        $params["action"] = "alias_bind_list";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["aliasList"] = $aliasList;
        return $this->httpPostJSON($this->host,$params);
    }

    /**
     * @param $appId
     * @param $alias
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function queryClientId($appId, $alias)
    {
        $params = array();
        $params["action"] = "alias_query";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["alias"] = $alias;;
        return $this->httpPostJSON($this->host, $params);
    }

    public function queryAlias($appId, $clientId)
    {
        $params = array();
        $params["action"] = "alias_query";
        $params["appKey"] = $this->appKey;
        $params["appid"] = $appId;
        $params["cid"] = $clientId;
        return $this->httpPostJSON($this->host, $params);
    }

    public function unBindAlias($appId, $alias, $clientId=null)
    {
        $params = array();
        $params["action"] = "alias_unbind";
        $params["appKey"] = $this->appKey;
        $params["appid"] = $appId;
        $params["alias"] = $alias;
        if (!is_null($clientId) && trim($clientId) != "") {
            $params["cid"] = $clientId;
        }
        return $this->httpPostJSON($this->host, $params);
    }

    public function unBindAliasAll($appId, $alias)
    {
        return $this->unBindAlias($appId, $alias);
    }

    public function getPushResult( $taskId) {
        $params = array();
        $params["action"] = "getPushMsgResult";
        $params["appKey"] = $this->appKey;
        $params["taskId"] = $taskId;
        return $this->httpPostJson($this->host, $params);
    }

    public function getPushResultByGroupName($appId, $groupName){
        $params = array();
        $params["action"] = "getPushResultByGroupName";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["groupName"] = $groupName;
        return $this->httpPostJSON($this->host, $params);
    }

    public function getLast24HoursOnlineUserStatistics($appId){
        $params = array();
        $params["action"] = "getLast24HoursOnlineUser";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;

        return $this->httpPostJSON($this->host, $params);

    }
    public function getPushResultByTaskIdList( $taskIdList) {
        return $this->getPushActionResultByTaskids($taskIdList, null);
    }

    public function getPushActionResultByTaskIds( $taskIdList, $actionIdList) {
        $params = array();
        $params["action"] = "getPushMsgResultByTaskidList";
        $params["appKey"] = $this->appKey;
        $params["taskIdList"] = $taskIdList;
        $params["actionIdList"] = $actionIdList;
        return $this->httpPostJson($this->host, $params);
    }

    public function getUserTags($appId, $clientId) {
        $params = array();
        $params["action"] = "getUserTags";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["clientId"] = $clientId;
        return $this->httpPostJson($this->host, $params);
    }

    public function getUserCountByTags($appId, $tagList) {
        $params = array();
        $params["action"] = "getUserCountByTags";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["tagList"] = $tagList;
        $limit = GTConfig::getTagListLimit();
        if(count($tagList) > $limit) {
            throw new \Exception("tagList size:".count($tagList)." beyond the limit:".$limit);
        }
        return $this->httpPostJSON($this->host, $params);
    }

    public function getPersonaTags($appId) {
        $params = array();
        $params["action"] = "getPersonaTags";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;

        return $this->httpPostJSON($this->host, $params);
    }

    public function queryAppPushDataByDate($appId, $date){
        if(!Utils\LangUtils::validateDate($date)){
            throw new \Exception("DateError|".$date);
        }
        $params = array();
        $params["action"] = "queryAppPushData";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["date"] = $date;
        return $this->httpPostJson($this->host, $params);
    }

    public function queryAppUserDataByDate($appId, $date){
        if(!Utils\LangUtils::validateDate($date)){
            throw new \Exception("DateError|".$date);
        }
        $params = array();
        $params["action"] = "queryAppUserData";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        $params["date"] = $date;
        return $this->httpPostJson($this->host, $params);
    }

    public function queryUserCount($appId, $appConditions) {
        $params = array();
        $params["action"] = "queryUserCount";
        $params["appKey"] = $this->appKey;
        $params["appId"] = $appId;
        if(!is_null($appConditions)) {
            $params["conditions"] = $appConditions->condition;
        }
        return $this->httpPostJson($this->host, $params);
    }

    public function pushTagMessage($message, $requestId = null) {
        if($message instanceof Message\TagMessage) {
            if($requestId == null  || trim($requestId) == "") {
                $requestId = Utils\LangUtils::randomUUID();
            }

            $params = array();
            $params["action"] = "pushMessageByTagAction";
            $params["appKey"] = $this->appKey;
            $params["clientData"] = base64_encode($message->data->transparent);
            $params["transmissionContent"] = $message->data->transmissionContent;
            $params["isOffline"] = $message->isOffline;
            $params["offlineExpireTime"] = $message->offlineExpireTime;
            $params["pushNetWorkType"] = $message->pushNetWorkType;
            $params["appIdList"] = $message->appIdList;
            $params["speed"] = $message->speed;
            $params["requestId"] = $requestId;
            $params["tag"] = $message->tag;
            return $this->httpPostJSON($this->host, $params);
        } else {
            return $this->getResult("MsgTypeError");
        }
    }

    public function pushTagMessageRetry($message) {
        return $this->pushTagMessage($message,null);
    }
    public function getScheduleTask($taskId,$appId){
        $params = array();
        $params["action"] = "getScheduleTaskAction";
        $params["appId"] = $appId;
        $params["appKey"] = $this->appKey;
        $params["taskId"] = $taskId;
        var_dump($this->host);

        return $this->httpPostJSON($this->host, $params);

    }

    public function delScheduleTask($taskId,$appId){
        $params = array();
        $params["action"] = "delScheduleTaskAction";
        $params["appId"] = $appId;
        $params["appKey"] = $this->appKey;
        $params["taskId"] = $taskId;

        return $this->httpPostJSON($this->host, $params);

    }

    public function bindCidPn($appId,$cidAndPn){
        $params = array();
        $params["action"] = "bind_cid_pn";
        $params["appId"] = $appId;
        $params["appKey"] = $this->appKey;
        $params["cidpnlist"] = $cidAndPn;

        return $this->httpPostJSON($this->host,$params);
    }

    public function unbindCidPn($appId,$cid){
        $params = array();
        $params["action"] = "unbind_cid_pn";
        $params["appId"] = $appId;
        $params["appKey"] = $this->appKey;
        $params["cids"] = $cid;

        return $this->httpPostJSON($this->host,$params);
    }

    public function queryCidPn($appId,$cid){
        $params = array();
        $params["action"] = "query_cid_pn";
        $params["appId"] = $appId;
        $params["appKey"] = $this->appKey;
        $params["cids"] = $cid;

        return  $this->httpPostJSON($this->host,$params);
    }

    public function stopSendSms($appId,$taskId){
        $params = array();
        $params["action"] = "stop_sms";
        $params["appId"] = $appId;
        $params["appKey"] = $this->appKey;
        $params["taskId"] = $taskId;
        return  $this->httpPostJSON($this->host,$params);

    }

    private function getResult($info) {
        $ret = array();
        $ret["result"] = $info;
        return $ret;
    }

    private function microTime()
    {
        list($usec, $sec) = explode(" ", microtime());
        $time = ($sec . substr($usec, 2, 3));
        return $time;
    }
}
