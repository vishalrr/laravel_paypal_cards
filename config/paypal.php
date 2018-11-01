<?php 
return [ 
    
	'client_id' =>'AbOwwR2_LXnX2nKee6LvCpA1bNvqKQeYrcieFSfQiPBbAqOpr01tOyoBzp5ZB_cQN1JwU7uMALF0e0gc',
	'secret' => 'ELf9rnJBoAEKDwaiElhlMtYyLK3hbZXsJdlAEsHJ1cci4z6Y5yZglLzKEXxMfQR2D_SDR_prkRdyAYuF',
	/**
	* SDK configuration 
	*/
	'settings' => array(
		/**
		* Available option 'sandbox' or 'live'
		*/
		'mode' => 'sandbox',
		/**
		* Specify the max request time in seconds
		*/
		'http.ConnectionTimeOut' => 1000,
		/**
		* Whether want to log to a file
		*/
		'log.LogEnabled' => true,
		/**
		* Specify the file that want to write on
		*/
		'log.FileName' => storage_path() . '/logs/paypal.log',
		/**
		* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
		*
		* Logging is most verbose in the 'FINE' level and decreases as you
		* proceed towards ERROR
		*/
		'log.LogLevel' => 'FINE'
		),
];