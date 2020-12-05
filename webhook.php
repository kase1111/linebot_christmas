<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = 'Lpm434bCKVMXwPrWzzXBwlYs9RCFtSVREK4NOCk0MgcJ+yH2dYr0CjGYbdiJNSJ7PvcfENA8cYDHa68/6DI77yuA47wWBLPoxbfWyyB9WpdVwmIY+ZptXxi3azGC1SPmZ7mOEq3X37Kr8V/Ecu3NewdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'c70215b39f1d8d6919dee4819b40a2f7';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
function replyMessage($client, $reply_token, $messages) {
    return $client->replyMessage([
        'replyToken' => $reply_token,
        'messages' => $messages
    ]);
}
foreach ($client->parseEvents() as $event) {
    if ($event['type'] == 'message') {
        $message = $event['message'];
        switch ($message['type']) {
            case 'location':
                $lat = $message['latitude'];
                $lon = $message['longitude'];
                $uri = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
                $hotkey = '2a60a96fb9488110';
                $count = 5;
                $range = 3;
                $url = $uri . '?key=' . $hotkey . '&latitude=' . $lat . '&longitude=' . $lon . '&range=' . $range . '&count' . $count;
                $conn = curl_init();
                curl_setopt($conn, CURLOPT_URL, $url);
                curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
                $res = curl_exec($conn);
                $obj = json_decode($res, true);
                curl_close($conn);
                $columns = array();
                foreach ($obj->shop as $restaurant) {
                    $columns[] = array(
                        'thumbnailImageUrl' => $restaurant->logo_image,
                        'title' => $restaurant->name,
                        'text' => $restaurant->address,
                        'actions' => array(
                            array(
                                'type' => 'uri',
                                'label' => '詳細を見る',
                                'uri' => $restaurant->urls,
                            )
                        )
                    );
                }
                if ($columns !== null) {
                    $messages = [
                        [
                            'type' => 'template',
                            'altText' => '周辺のラーメン屋情報',
                            'template' => [
                                'type' => 'carousel',
                                'columns' => [
                                    [
                                        'imageBackgroundColor' => '#FFFFFF',
                                        'title' => $columns[0][title],
                                        'text' => $columns[0][text],
                                        'actions' => [
                                            [
                                                'type' => 'uri',
                                                'label' => 'ホットペッパーサイトへ',
                                                'uri' => $columns[0]['actions'][0]['uri'],
                                            ]
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ];
                    replyMessage($client, $event['replyToken'], $messages);
                    break;
                } else {
                    $messages = [
                        [
                            'type' => 'text',
                            'text' => '近くにないです'
                        ]
                    ];
                    replyMessage($client, $event['replyToken'], $messages);
                    break;
                }
            }
    } else {
        error_log('Unsupported event type:' . $event['type']);
        break;
    }
};
?>