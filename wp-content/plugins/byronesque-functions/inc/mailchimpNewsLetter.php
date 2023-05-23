<?php 

/**
 * Add Remove Mailchimp Newsletter FUNCTION
 * THIS IS ONLY INTENTED FOR BYRONEQUE 
 * 
 * Add a subscriber to Mailchimp using API key and list ID.
 *
 * @param string $email The email address of the subscriber.
 * @param string $apiKey The Mailchimp API key.
 * @param string $listId The ID of the Mailchimp list.
 */
function add_or_remove_subscriber_to_mailchimp() {
    $apiKey = MAILCHIMPAPI;
    $listId = MAILCHIMPLIST;
    $datacenter = substr($apiKey, strpos($apiKey, '-') + 1);

    $email = $_GET['email'];
    $action = $_GET['getAction'];
    
    $subscriber_hash = md5(strtolower($email));

    $endpoint = 'https://' . $datacenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members';

    // Subscriber data
    $data = array(
        'email_address' => $email,
        'status' => $action,
    );

    // Request headers
    $headers = array(
        'Authorization' => 'Basic ' . base64_encode('apikey:' . $apiKey),
    );



    $response;

    $checkEmailStatus = checkEmailStatus($endpoint, $headers, $subscriber_hash);


    // Send the request
    if ($action == 'subscribed') {

        $data = array(
            'email_address' => $email,
            'status' => $action,
        );

        // var_dump($checkEmailStatus);
        if ($checkEmailStatus['status'] == "unsubscribed") {
            // echo "update";
            $response = wp_remote_request($endpoint . '/' . $subscriber_hash, array(
                'method' => 'PUT',
                'headers' => $headers,
                'body' => wp_json_encode($data),
            ));
        } else {
            // echo "add". $checkEmailStatus['status'];
            $response = wp_remote_post($endpoint, array(
                'headers' => $headers,
                'body' => json_encode($data),
            ));
        }
        
    } else {
        $data = array(
            'status' => 'unsubscribed',
        );

            // Request headers
        $headers = array(
            'Authorization' => 'Basic ' . base64_encode('apikey:' . $apiKey),
        );

        $response = wp_remote_request($endpoint . '/' . $subscriber_hash, array(
            'method' => 'PATCH',
            'headers' => $headers,
            'body' => wp_json_encode($data),
        ));
    }
    

    

    // Handle the response
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        // Success: the subscriber was added
        // echo 'Request added successfully.';
    } else {
        // Error: failed to add the subscriber
        $error_message = is_wp_error($response) ? $response->get_error_message() : 'An error occurred.';
        // echo 'Failed to process request: ' . $error_message;
    }

    echo wp_json_encode($response);

    die();
}

add_action( 'wp_ajax_add_or_remove_subscriber_to_mailchimp', 'add_or_remove_subscriber_to_mailchimp' );
add_action( 'wp_ajax_nopriv_add_or_remove_subscriber_to_mailchimp', 'add_or_remove_subscriber_to_mailchimp' );


function check_email_subscription_status($email, $listId = MAILCHIMPLIST) {

    $user = wp_get_current_user();

    $apiKey = MAILCHIMPAPI;
    // Mailchimp API endpoint
    $datacenter = substr($apiKey, strpos($apiKey, '-') + 1);
    $endpoint = 'https://' . $datacenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members';

    // Subscriber data
    $subscriber_hash = md5(strtolower($email));

    // Request headers
    $headers = array(
        'Authorization' => 'Basic ' . base64_encode('apikey:' . $apiKey),
    );

    // Send the request
    $response = wp_remote_get($endpoint . '/' . $subscriber_hash, array(
        'headers' => $headers,
    ));

    // Handle the response
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $data = json_decode(wp_remote_retrieve_body($response), true);
        $subscription_status = $data['status'];

        if ($subscription_status === 'subscribed') {
            // Email is subscribed
            echo "<p>You have signed in to received our newsletters <span class='txt-right stopStartNewsletterSubscription' data-action='unsubscribed'data-email='$email' style='cursor:pointer'>Stop our emails</span></p>";
        } elseif ($subscription_status === 'unsubscribed') {
            // Email is unsubscribed
            echo "<p>You have unsubscribed to our newsletters.</p>";
        } else {
            // Other status
            echo "<p>You haven't signed in to our newsletters <span class='txt-right stopStartNewsletterSubscription' data-action='unsubscribed' data-email='$email' style='cursor:pointer'>Subscribe to our emails</span></p>";
        }
    } else {
        // Error: failed to fetch email status
        $error_message = is_wp_error($response) ? $response->get_error_message() : 'An error occurred.';
        echo 'Failed to fetch email status: ' . $error_message;
    }
}


function checkEmailStatus($endpoint, $headers, $subscriber_hash) {
    // Send the request to check email if exist
    $response = wp_remote_get($endpoint . '/' . $subscriber_hash, array(
        'headers' => $headers,
    ));

    $status='';
    $resp = wp_remote_retrieve_response_code($response);

    // Handle the response
    if (!is_wp_error($response) && $resp === 200) {
        $data = json_decode(wp_remote_retrieve_body($response), true);
        $status = $data['status'];
        $resp = 200;
    }

    return [
        "status" => $status,
        "response" => $resp,
    ];

}



