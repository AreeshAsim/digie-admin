
<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Reference implementation for Kraken's REST API.
 *
 * See https://www.kraken.com/help/api for more info.
 *
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Payward, Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class KrakenAPIException extends \ErrorException {};

class Kraken
{
    protected $key;     // API key
    protected $secret;  // API secret
    protected $url;     // API base URL
    protected $version; // API version
    protected $curl;    // curl handle

    /**
     * Constructor for KrakenAPI
     *
     * @param string $key API key
     * @param string $secret API secret
     * @param string $url base URL for Kraken API
     * @param string $version API version
     * @param bool $sslverify enable/disable SSL peer verification.  disable if using beta.api.kraken.com
     */
    function __construct($key = [], $url='https://api.kraken.com', $version='0', $sslverify=true){
        $this->key = $key[0]['api_key'];//'eDaOkQPPapWpWJt+15bTHibelo8t6Q2Q0aCQFvHrE7+aUFOkgkC4h3e7';
        $this->secret = $key[0]['api_securet'];//'MXOEkLGRIfXAHdkPsN9kKO4NSaNhVkKo1p2D1AAcdeFNsHyQqd6L+PUERPVkZiv4JbZZYPW07A5MQxN7ce58RQ==';
        $this->url = $url;
        $this->version = $version;
        $this->curl = curl_init();

        curl_setopt_array($this->curl, array(
            CURLOPT_SSL_VERIFYPEER => $sslverify,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_USERAGENT => 'Kraken PHP API Agent',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true)
        );
        echo $this->key ;
    }

    function __destruct()
    {
        curl_close($this->curl);
    }

    public function get_api($admin_id=null){
        // $CI = &get_instance();
        // if(!empty($admin_id)){

        //     $CI->mongo_db->where(array('user_id' => (string)$admin_id));
        //     $get_settings = $CI->mongo_db->get('kraken_credentials');
        //     $settings_arr = iterator_to_array($get_settings);
        //     return $settings_arr;
        // }
    }


    /**
     * Query public methods
     *
     * @param string $method method name
     * @param array $request request parameters
     * @return array request result on success
     * @throws KrakenAPIException
     */
    function QueryPublic($method, array $request = array()){
        // build the POST data string
        $postdata = http_build_query($request, '', '&');

        // make request
        curl_setopt($this->curl, CURLOPT_URL, $this->url . '/' . $this->version . '/public/' . $method);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array());
        $result = curl_exec($this->curl);
        if($result===false)
            throw new KrakenAPIException('CURL error: ' . curl_error($this->curl));

        // decode results
        $result = json_decode($result, true);
        if(!is_array($result))
            throw new KrakenAPIException('JSON decode error');

        return $result;
    }

    /**
     * Query private methods
     *
     * @param string $method method path
     * @param array $request request parameters
     * @return array request result on success
     * @throws KrakenAPIException
     */
    function QueryPrivate($method, array $request = array()){
        // echo "<pre>";
        if(!isset($request['nonce'])) {
            // generate a 64 bit nonce using a timestamp at microsecond resolution
            // string functions are used to avoid problems on 32 bit systems
            $nonce = explode(' ', microtime());
            $request['nonce'] = $nonce[1] . str_pad(substr($nonce[0], 2, 6), 6, '0');            
        }

        // build the POST data string
        $postdata = http_build_query($request, '', '&');
        

        // set API key and sign the message
        $path = '/' . $this->version . '/private/' . $method;

        $sign = hash_hmac('sha512', $path . hash('sha256', $request['nonce'] . $postdata, true), base64_decode($this->secret), true);
        $headers = array(
            'API-Key: ' . 'CBVUM6PnrAx8xNNSLWB9nJCC2m3dCA7tyiQi8Eo02/P43SOld6S3LS6N',
            'API-Sign: ' . base64_encode($sign),
        );

        curl_setopt($this->curl, CURLOPT_URL, $this->url.$path);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($this->curl);
        if($result===false)
            throw new KrakenAPIException('CURL error: ' . curl_error($this->curl));

        // decode results
        $result = json_decode($result, true);
        if(!is_array($result))
            throw new KrakenAPIException('JSON decode error');

        return $result;
    }
}