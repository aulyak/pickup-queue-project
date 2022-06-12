<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PushNotification
{
  /**
   * Write code on Method
   *
   * @return response()
   */
  public static function sendNotification($device_token, $title, $body)
  {
    $type = !is_array($device_token) ? "to" : "registration_ids";

    if (is_array($device_token)) {
      $tokens = array_map(function ($array_item) {
        return $array_item['firebase_token'];
      }, $device_token);
      json_encode($tokens);
      $device_token = $tokens;
    }

    $message = array(
      "title" => $title,
      "body" => $body
    );

    $SERVER_API_KEY = config('app.firebase_server_key');

    $data = [
      $type => $device_token,
      "notification" => $message
    ];

    $dataString = json_encode($data);

    $headers = [
      'Authorization: key=' . $SERVER_API_KEY,
      'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);

    curl_close($ch);

    return $response;
  }
}