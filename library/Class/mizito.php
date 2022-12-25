<?php
class mizito
{
    public function __construct()
    {
    }
    public function add($classId, $classTitle, $profPhone, $profFirstName, $profLastName, $profPassword, $phone, $firstNam, $lastName, $password, $isClassAdmin)
    {
        $workspace = $profLastName . ' ' . $profFirstName;
        $postData = array(
            'workspaceTitle' => $workspace,
            'classId' => $classId,
            'classTitle' => $classTitle,
            'profPhone' => $profPhone,
            'profFirstName' => $profFirstName,
            'profLastName' => $profLastName,
            'profPassword' => $profPassword,
            'adminPhone' => '09153203817',
            'member' => array('phone' => $phone, 'firstName' => $firstNam, 'lastName' => $lastName, 'password' => $password, 'isClassAdmin' => $isClassAdmin), // مشخصات زبان آموز
        );
        $curl = curl_init('https://mizito.hafez-li.com/ws/wapi/workspace/hafezClassAddMember');

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, false );
        curl_setopt( $curl, CURLOPT_FAILONERROR, true );
        curl_setopt( $curl, CURLOPT_HEADER, true );
        curl_setopt( $curl, CURLINFO_HEADER_OUT, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 20 );
        curl_setopt( $curl, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $curl, CURLOPT_USERAGENT, 'Mozilla/5.0' );
        curl_setopt( $curl, CURLOPT_MAXREDIRS, 10 );
        curl_setopt( $curl, CURLOPT_ENCODING, '' );

        /* enhanced debug */
        curl_setopt( $curl, CURLOPT_VERBOSE, true );
        curl_setopt( $curl, CURLOPT_NOPROGRESS, true );


        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array (
            'Authorization: 58bbe9e5fe2317b024a80f21',
            'Content-Type: application/json',
        ));


        // Send the request
        $response = curl_exec($curl);
        // Check for errors
        if ($response === false) {
            die(curl_error($curl));
        }
        // Decode the response
        $responseData = json_decode($response, true);
        // Close the cURL handler
        curl_close($curl);
    }
    public function remove($classId, $profPhone, $phone)
    {
        // Your ID and token
        $authToken = '58bbe9e5fe2317b024a80f21';
        // The data to send to the API
        $postData = array(
            'classId' => $classId, // شناسه کلاس
            'profPhone' => $profPhone, // شماره همراه استاد
            'memberPhone' => $phone, // شماره همراه زبان آموز
        );
        // Setup cURL
        $curl = curl_init('https://mizito.hafez-li.com/ws/wapi/workspace/hafezClassRemoveMember');
        curl_setopt_array($curl, array(
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $authToken,
                'Content-Type: application/json',
            ),
            CURLOPT_POSTFIELDS => json_encode($postData),
        ));
        // Send the request
        $response = curl_exec($curl);
        // Check for errors
        if ($response === false) {
            die(curl_error($curl));
        }
        // Decode the response
        $responseData = json_decode($response, true);
        // Close the cURL handler
        curl_close($curl);
        // Print the date from the response
        echo $responseData;
    }
    public function login($phone)
    {
        // Your ID and token
        $authToken = '58bbe9e5fe2317b024a80f21';
        // The data to send to the API
        $postData = array(
            "phone" => $phone,
        );
        // Setup cURL
        $curl = curl_init('https://mizito.hafez-li.com/ws/wapi/workspace/hafezCreateLoginLink');
        curl_setopt_array($curl, array(
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $authToken,
                'Content-Type: application/json',
            ),
            CURLOPT_POSTFIELDS => json_encode($postData),
        ));
        // Send the request
        $response = curl_exec($curl);
        // Check for errors
        if ($response === false) {
            die(curl_error($curl));
        }
        // Decode the response
        $responseData = json_decode($response, true);
        // Close the cURL handler
        curl_close($curl);
        // Print the date from the response
        return $responseData;
    }
}