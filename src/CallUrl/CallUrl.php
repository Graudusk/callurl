<?php
/**
 * Showing off a standard class with methods and properties.
 */
namespace Erjh17\CallUrl;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * CallUrl
 */
class CallUrl implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Fetches information from a foreign API.
     *
     * @param string $urlHost   The base url for the API website.
     * @param array  $query     The query string for the API call.
     *
     * @return [json] The result data from the API call.
     */
    public function fetch($urlHost, $query)
    {
        $queryString = "?" . http_build_query($query);
        $apiGet = curl_init($urlHost.$queryString);

        curl_setopt($apiGet, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($apiGet);

        curl_close($apiGet);

        $apiResult = json_decode($json, true);

        return $apiResult;
    }


    /**
     * [buildUrl description]
     *
     * @param  [type] $url     [description]
     * @param  [type] $params  [description]
     * @param  [type] $queries [description]
     * @return [type]          [description]
     */
    public function buildUrl($url, $params, $queries)
    {
        $returnUrl = $url;
        if ($params) {
            $returnUrl .= implode("/", $params);
        }

        if ($queries) {
            $returnUrl .= "?" . http_build_query($queries);
        }

        return $returnUrl;
    }

    /**
     * Fetch multiple
     *
     * @param [array] $urls    [description]
     * @param [array] $params  [description]
     * @param [array] $queries [description]
     *
     * @return [type]          [description]
     */
    public function fetchConcurrently($urls, $params, $queries)
    {
        $cache = $this->di->get("cache");
        $hour = date('YMDH');
        $latLonDay = explode(",", $params[0][1]);
        $lat = $latLonDay[0];
        $lon = $latLonDay[1];
        $cookieName = $lat . $lon . $hour;
        $weatherCache = $cache->get($cookieName);

        if ($weatherCache) {
            // $timeValue = $weatherCache[0]["currently"]["time"];  // assume seconds
            // $date = date('YMDH', $timeValue);  // convert time value to milliseconds
            // $cookieCall = $weatherCache[0]["latitude"] . $weatherCache[0]["longitude"] . $date;
            return $weatherCache;
        } else {
            $nodes = array();
            $results = array();

            for ($i=0; $i < sizeof($urls); $i++) {
                $url = $this->buildUrl($urls[$i], $params[$i], $queries[$i]);
                array_push($nodes, $url);
            }

            // $json = json_decode(file_get_contents(__DIR__ . '/getjson.json'), true);
            // return $json;
            $nodeCount = count($nodes);

            $curlArray = array();
            $master = curl_multi_init();

            for ($i = 0; $i < $nodeCount; $i++) {
                $url = $nodes[$i];
                $curlArray[$i] = curl_init($url);
                curl_setopt($curlArray[$i], CURLOPT_RETURNTRANSFER, true);
                curl_multi_add_handle($master, $curlArray[$i]);
            }

            do {
                curl_multi_exec($master, $running);
            } while ($running > 0);

            for ($i = 0; $i < $nodeCount; $i++) {
                $results[] = json_decode(curl_multi_getcontent($curlArray[$i]), true);
            }
            $cache->set($cookieName, $results);

            return $results;
        }
    }
}
