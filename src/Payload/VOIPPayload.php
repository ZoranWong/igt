<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 10:51 PM
 */

namespace Zoran\IGt\Payload;


/**
 * @property-read string $payload
 * @property-write array|string $voIPPayload
 * */
class VOIPPayload implements PayloadInterface
{
    protected $voIPPayload = null;
    /**
     * @return  string
     * */
    public function getPayload()
    {
        // TODO: Implement getPayload() method.
        $payload = $this->voIPPayload;
        if($payload === null && empty($payload)) {
            throw new \RuntimeException("payload connot be empty");
        }

        $params = [];
        if($payload !== null) {
            $params['payload'] = $payload;
        }
        $params['isVoIP'] = 1;
        return json_encode($params);
    }

    public function setVoIPPayload($voIPPayload){
        $this->voIPPayload = $voIPPayload;
    }
}
