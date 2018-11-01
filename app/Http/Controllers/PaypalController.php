<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use Session;
use Redirect;

class PaypalController extends Controller
{
    /**
     * Last error message(s)
     * @var array
     */
    protected $_errors = array();
    /**
     * API Credentials
     * Use the correct credentials for the environment in use (Live / Sandbox)
     * @var array
     */
    protected $_credentials = array(
        'USER' => "vvv123_api1.gmail.com",
        'PWD' => 'JVW7W89FTNPAHSUJ',
        'SIGNATURE' => 'AB6wLAXTA.-8tz.DucaQANbfKZV7ADp4zSYplHsDGsWnozdLkrxJvTse'
    );
    /**
     * API endpoint
     * Live - https://api-3t.paypal.com/nvp
     * Sandbox - https://api-3t.sandbox.paypal.com/nvp
     * @var string
     */
    protected $_endPoint = 'https://api-3t.sandbox.paypal.com/nvp';
    /**
     * API Version
     * @var string
     */
    protected $_version = '86.0';
    /**
     * Make API request
     *
     * @param string $method string API method to request
     * @param array $params Additional request parameters
     * @return array / boolean Response array / boolean false on failure
     */
     public function __construct()
    {   
    }

   
    public function index(Request $request)
    {
        return view('paymentwithinstamojo');
    }

    public function request($method,$params = array()) {
        $this -> _errors = array();
        if( empty($method) ) { //Check if API method is not empty
            $this -> _errors = array('API method is missing');
            return false;
        }
        //Our request parameters
        $requestParams = array(
            'METHOD' => $method,
            'VERSION' => $this -> _version
        ) + $this -> _credentials;
        //Building our NVP string

        $request = http_build_query($requestParams + $params);
       

        //cURL settings
        $curlOptions = array (
            CURLOPT_URL => $this -> _endPoint,
            CURLOPT_VERBOSE => 1,
            /*
             * If you are using API Signature rather then certificates, leave the code below commented out
             */
          //  CURLOPT_SSL_VERIFYPEER => true,
          //  CURLOPT_SSL_VERIFYHOST => 2,
           // CURLOPT_CAINFO => dirname(__FILE__) . '/cacert.pem', //CA cert file
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $request
        );
        $ch = curl_init();
        curl_setopt_array($ch,$curlOptions);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        //  Skip peer certificate verification   - Comment this if you are using Certificates instead of API Signature
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);        // Skip host certificate verification    - Comment this as well if you are using Certificates instead of API Signature
        //Sending our request - $response will hold the API response
        $response = curl_exec($ch);
       
        //Checking for cURL errors
        if (curl_errno($ch)) {
            $this -> _errors = curl_error($ch);
            curl_close($ch);
            return false;
            //Handle errors
        } else  {
            curl_close($ch);
            $responseArray = array();
            parse_str($response,$responseArray); // Break the NVP string to an array

            echo "<pre>";
            print_r($responseArray);
            exit;
            return $responseArray;
        }
    }
   
    public function payment(Request $request)
   {

        $this->validate($request, [
            'card_type' => 'required',
            'exp_date' => 'required',
            'card_no' => 'required',
        ]);
         $card_type = strtolower($request->get('card_type'));
         $card_no = $request->get('card_no');
         $exp_date = $request->get('exp_date');
        
         $requestParams = array(
                            'IPADDRESS' => $_SERVER['REMOTE_ADDR'],          // Get our IP Address
                            'PAYMENTACTION' => 'Sale'
                        );
        $creditCardDetails = array(
            'CREDITCARDTYPE' => $card_type,
            'ACCT' => $card_no,
            'EXPDATE' => $exp_date,          // Make sure this is without slashes (NOT in the format 07/2017 or 07-2017)
            'CVV2' => 123
        );
        $payerDetails = array(
            'FIRSTNAME' => '',
            'LASTNAME' => ''
        );
        $orderParams = array(
            'AMT' => 10,               // This should be equal to ITEMAMT + SHIPPINGAMT
            'ITEMAMT' => 10,
            'SHIPPINGAMT' => '0',
            'CURRENCYCODE' => 'USD'       // USD for US Dollars
        );       
                       

        $response = $this->request('DoDirectPayment',
        $requestParams + $creditCardDetails + $payerDetails + $orderParams);

    }

}   