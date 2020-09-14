

<?php

class PushyAPI
{
    static public function sendPushNotification( $data, $ids )
    {
        // Your Pushy API key
        $apiKey = '269e67887b4a3e8392a464652e9577f0a8c3ae856b901100b9d31da0e391c9ab';
        $apiKey = 'cc866548df9327ff1c7746086982d580e6cd01d544f5064d38e3af8a619988d5'; //staging.fooddudes

        // Define URL to Pushy endpoint
        $url = 'https://api.pushy.me/push?api_key=' . $apiKey;

        // Set post variables
        $post = array
        (
            'registration_ids'  => $ids,
            'data'              => $data,
        );

        // Set Content-Type since we're sending JSON
        $headers = array
        (
            'Content-Type: application/json'
        );

        // Initialize curl handle
        $ch = curl_init();

        // Set URL to Pushy endpoint
        curl_setopt( $ch, CURLOPT_URL, $url );

        // Set request method to POST
        curl_setopt( $ch, CURLOPT_POST, true );

        // Set our custom headers
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

        // Get the response back as string instead of printing it
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        // Set post data as JSON
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

        // Actually send the push
        $result = curl_exec( $ch );

        // Display errors
        if ( curl_errno( $ch ) )
        {
            echo curl_error( $ch );
        }

        // Close curl handle
        curl_close( $ch );
		print_r($result);
        // Debug API response
        //echo $result;
    }
}
$send_data = array('statusReport'=>$_GET['playSound']=='true' ? true :false);
$data = array( 'json_link' => json_encode($send_data) );

// The recipient device registration IDs
$ids = array( 'cde5d6d9db987f68d5114c' );

// Send it via Pushy API
PushyAPI::sendPushNotification( $data, $ids );
//echo date('Y-m-d H:i:s');
?>