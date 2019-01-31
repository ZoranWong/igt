<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:38 AM
 */

namespace Zoran\IGt\IGetui\Utils;


class ApsUtils
{

    /**
     * @param $locKey
     * @param $locArgs
     * @param $message
     * @param $actionLocKey
     * @param $launchImage
     * @param $badge
     * @param $sound
     * @param $payload
     * @param $contentAvailable
     * @return integer
     * @throws
     * */
    public  static function validatePayloadLength($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload, $contentAvailable)
    {
        $json = ApsUtils :: processPayload($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload,$contentAvailable);
        return strlen($json);
    }

    /**
     * @param $locKey
     * @param $locArgs
     * @param $message
     * @param $actionLocKey
     * @param $launchImage
     * @param $badge
     * @param $sound
     * @param $payload
     * @param $contentAvailable
     * @return string|Payload
     * @throws
     * */
    public  static function processPayload($locKey, $locArgs, $message, $actionLocKey, $launchImage, $badge, $sound, $payload, $contentAvailable)
    {
        $isValid = false;
        $pb = new Payload();
        if ($locKey != null && strlen($locKey) > 0) {
            // loc-key
            $pb->alertLocKey = $locKey;
            // loc-args
            if ($locArgs != null && strlen($locArgs) > 0) {
                $pb->alertLocArgs = explode(',',($locArgs));
            }
            $isValid = true;
        }

        // body
        if ($message != null && strlen($message) > 0) {
            $pb->alertBody = ($message);
            $isValid = true;
        }

        // action-loc-key
        if ($actionLocKey!=null && strlen($actionLocKey) > 0) {
            $pb->alertActionLocKey = ($actionLocKey);
        }

        // launch-image
        if ($launchImage!=null && strlen($launchImage) > 0) {
            $pb->alertLaunchImage = ($launchImage);
        }

        // badge
        $badgeNum = -1;
        if(is_numeric($badge)){
            $badgeNum = (int)$badge;
        }
        if ($badgeNum >= 0) {
            $pb->badge = ($badgeNum);
            $isValid = true;
        }

        // sound
        if ($sound != null && strlen($sound) > 0) {
            $pb->sound = ($sound);
        } else {
            $pb->sound = ("default");
        }

        //contentAvailable
        if ($contentAvailable == 1) {
            $pb->contentAvailable = (1);
            $isValid = true;
        }

        // payload
        if ($payload != null && strlen($payload) > 0) {
            $pb->addParam("payload", ($payload));
        }

        if($isValid == false){
            throw new \Exception("one of the params(locKey,message,badge) must not be null or contentAvailable must be 1");
        }
        return $pb;
    }
}
