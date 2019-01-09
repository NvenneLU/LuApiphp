<?php namespace NvenneLU\LuApiphp;
use Exception;

/**
*  ApiConnect
*
*  Creates a connection to a given api server to simplify the execution of the curl command.
*
*  @author Nvenne
*/
class ApiConnect {


   /**  @var string $apikey api key for the call */
   private $apikey = '';
   /**  @var string $apihost Hostname of the api server */
   private $apihost = '';

   /**  @var string $ch Curl instance object */
   private $ch = '';

   /**  @var string $method HTTP request method */
   private $method = '';
   /**  @var string $params HTTP body parameters */
   private $params = '';
   /**  @var string $path URL pathname */
   private $path = '';

   function __construct($key, $host) {
     $this->apikey = $key;
     $this->apihost = $host;
     echo 'construct';


     $this->ch = curl_init();
     curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('X-api-key: ' . $this->apikey));
     curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

   }

   function __destruct() {
     curl_close($this->ch);
   }


   /**
   * setMethod
   *
   * Set a given http method to the current call.
   *
   * @param string $method The HTTP request method, (GET,POST,PUT,DELETE)
   *
   */
   public function setMethod($method) {
     $method = strtoupper($method);
     if (!in_array($method, array('GET', 'POST', 'PUT', 'DELETE'))) {
       throw new Exception($method . ' is not supported');
     }
     $this->method = $method;
     curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->method);
   }


   /**
   * Call
   *
   * Executes the given path to the api server after the http method has been set and
   * given optional parameters
   *
   * @param object $path The api path or url pathname to execute to the server
   *
   * @return object Returns an object containing the api result of the given path.
   *
   */
   public function call($path) {
     if($this->method === '') {
       throw new Exception("Method not set");
     }
     if($this->method !== 'GET' && $this->params === '') {
       throw new Exception("Body parameters expected but none binded, use bind(params)");
     }

     $error = '';
     curl_setopt($this->ch, CURLOPT_URL, $this->apihost . $path);
     $response = curl_exec($this->ch);
     $error = curl_error($this->ch);
     $errno = curl_errno($this->ch);
     if (0 !== $errno) {
       throw new Exception($error . " " . $errno);
     }

     return json_decode($response);

   }

   /**
   * Bind Parameters
   *
   * Binds the given parameters to the call, parameters are given as objects,
   * objects can consist of arrays or strings. it is then coverted to url encoded.
   *
   * @param object $params An object containing key->value pairs that will be encdoded into url.
   *
   */
   public function bind($params) {
     if (is_object($params) || is_array($params))  {
       $this->params = http_build_query($params);
       curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->params);
     } else {
       throw new Exception("Invalid params sent");
     }
   }

}
