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
            //メッセージタイプがスタンプの場合
            case 'sticker':
                $messages = [
                    [
                        'type' => 'sticker',
                        'packageId' => 11537,
                        'stickerId' => 52002739,
                    ]
                ];
                replyMessage($client, $event['replyToken'], $messages);
                break;
            //メッセージタイプが位置情報の場合
            case 'location':
                // 受信した位置情報からの情報
                $lat = $message['latitude'];
                $lng = $message['longitude'];
                // ぐるなびapiURL
                $uri = 'https://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
                // ぐるなびアクセスキー
                $gnaviaccesskey = '2a60a96fb9488110';
                // ラーメン屋さんを意味するぐるなびのコード(小業態マスタ取得APIをコールして調査)
                // つけ麺屋さんを意味するぐるなびのコード(小業態マスタ取得APIをコールして調査)
                // 3件抽出
                //範囲
                $range = 3;
                //URL組み立て
                $url  = $uri . '?key=' . $gnaviaccesskey . '&lat=' . $lat . '&lng=' . $lng . '&range=' . $range;
                //ぐるなびapiの情報取得
                $conn = curl_init();
                curl_setopt($conn, CURLOPT_URL, $url);
                curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
                $res = curl_exec($conn);
                $results = json_decode($res);
                curl_close($conn);
                // 店舗情報を取得
                $columns = array();
                    $messages = [
                        [
                            'type' => 'text',
                            'text' => $url
                        ]
                    ];
                    replyMessage($client, $event['replyToken'], $messages);
                    break;
                foreach ($results->shop as $restaurant) {
                    $columns[] = array(
                        'thumbnailImageUrl' => $restaurant->logo_image,
                        'title' => $restaurant->name,
                        'text' => $restaurant->address,
                        'actions' => array(
                            array(
                                'type' => 'uri',
                                'label' => '詳細を見る',
                                'uri' => $restaurant->urls
                            )
                        )
                    );
                }
                if ($columns !== null) {
                } else {
                        $messages = [
                            [
                                'type' => 'text',
                                'text' => '残念ですが近くにラーメン屋が見つかりませんでした。'
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