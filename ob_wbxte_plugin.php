<?php

/**
 * 
 * Byteworks Webex Plugin V1 WRAPPER FOR CISCO WEBEX TEAMS API V1
 * @author Ryan Huff <rhuff@byteworks.com>
 * @website http://byteworks.com
 * @version 1.0.1
 * 
 */

class byteworksWebexPlugin {
    
    //BOT ACCESS TOKEN
    var $accessToken = 'PUT_YOUR_USER_OR_BOT_ACCESS_TOKEN_HERE';
   
    //ALERT SPACE IN WEBEX TEAMS
    var $roomId = 'PUT_YOUR_ROOM_ID_HERE';
    
    //WEBEX TEAMS API URL FOR POSTING MESSAGES
    var $messageUrl = 'https://api.ciscospark.com/v1/messages';
    
    function httpHeader($data) {
        
        //FORMAT THE HEADER FOR THE JSON POST INTO CISCO WEBEX TEAMS
        return array(
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        );
    }
    
    function formatAlertNotification($data) {
        
        //FORMAT THE ALERT MESSAGE THE WAY IT WILL APPEAR IN CISCO WEBEX TEAMS
        return $data['TITLE'] . "\nConditions: " . $data['CONDITIONS'] . "\nMetrics: " . $data['METRICS'] . "\nDuration: " . $data['DURATION'] . "\nLatest Recorded Uptime: " . $data['DEVICE_UPTIME'] . "\nLast Recorded Reboot: " . $data['DEVICE_REBOOTED'] . "\nDevice: http://byteworksmonitor.agromerchants.com/device/device=" . $data['DEVICE_ID'];

    }
            
    function receiveObsAlert() {
        
        //DECODE THE JSON POST FROM OBSERVIUM NOTIFICATIONS
        $decoded = json_decode(file_get_contents('php://input'), true);
        
        //POST TO CISCO WEBEX TEAMS
        $this->postMessage($this->formatAlertNotification($decoded));

    }
    
    function postMessage($message) {
        
        //USE CURL TO POST INTO CISCO WEBEX TEAMS
        $data = json_encode(
                    array (
                        "roomId" => $this->roomId,
                        "text" => $message
                    )
                );
        
        $ch = curl_init($this->messageUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHeader($data));
        var_dump(curl_exec($ch));
    }
    
    
}

$bwt = new byteworksWebexPlugin();

$bwt->receiveObsAlert();

?>