<?php
/**
 * Showing off a standard class with methods and properties.
 */
namespace Erjh17\CallUrlModel;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class CallUrlModel implements ContainerInjectableInterface
{
    use IpModelTrait;
    use GeoModelTrait;
    use WeatherModelTrait;
    use ContainerInjectableTrait;

    /**
     * Constructor to set the IpAddress.
     *
     * @param string $ipAddress The ip address to be stored.
     */
    public function __construct(string $ipAddress = null)
    {
        $this->setIpAddress($ipAddress);
        $this->errorMsg = "";
    }

    /**
     * [setDarkskyKey description]
     *
     * @param string $key [description]
     */
    public function setIpstackKey($key)
    {
        $this->ipstackkey = $key;
    }

    /**
     * [setIpAddress description]
     *
     * @param string|null $ipAddress [description]
     */
    public function setIpAddress(string $ipAddress = null)
    {
        $this->ipAddress = trim($ipAddress);
    }
}
