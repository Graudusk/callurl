<?php
/**
 * Showing off a standard class with methods and properties.
 */
namespace Erjh17\CallUrlModel;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

trait IpModelTrait
{
    // use GeoModelTrait;
    // use WeatherModelTrait;
    // use ContainerInjectableTrait;
    /**
     * @var string     $ipAddress  The ip address.
     * @var string     $message  The message.
     * @var boolean    $valid  If the ip address is valid.
     * @var string     $host  The ip adress' host.
     */

    private $ipAddress;
    private $message;
    private $valid;
    private $host;
    private $errorMsg;
    private $ipstackkey;

    /**
     * [isValidIp description]
     *
     * @return boolean [description]
     */
    public function isValidIp()
    {
        return $this->valid;
    }

    /**
     * Returns the data of the IpModel.
     *
     * @return array array of info.
     */
    public function getInfo()
    {
        return array(
            'ip' => $this->ipAddress,
            'host' => $this->host,
            'message' => $this->message,
            'valid' => $this->valid,
            'errorMsg' => $this->errorMsg
        );
    }

    public function fillInfo($result, $keys)
    {
        foreach ($keys as $value) {
            if (array_key_exists($value, $result)) {
                $this->$value = $result[$value];
            }
        }
    }

    /**
     * [pushInfo description]
     *
     * @param  array $result [description]
     * @param  array $keys   [description]
     *
     * @return array         [description]
     */
    public function pushInfo($result, $keys)
    {
        $retArray = [];
        foreach ($keys as $value) {
            if (array_key_exists($value, $result)) {
                $retArray[$value] = $result[$value];
            }
        }
        return $retArray;
    }

    /**
     * Validates the ip address stored in the Class instance.
     *
     * @return array Array with data
     */
    public function validateIp()
    {
        if ($this->ipAddress) {
            if (filter_var($this->ipAddress, FILTER_VALIDATE_IP)) {
                $this->valid = true;
                if (filter_var($this->ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $this->message = "$this->ipAddress är en giltig IPv4 adress";
                    $this->host = gethostbyaddr($this->ipAddress);
                } elseif (filter_var($this->ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $this->message = "$this->ipAddress är en giltig IPv6 adress";
                }
            } else {
                $this->message = "$this->ipAddress är inte en giltig IP adress";
            }
        }
        return $this->getInfo();
    }
}
