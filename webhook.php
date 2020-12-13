<?php
require_once('./LINEBotTiny.php');
$channelAccessToken = 'vmHip9gH5zZrT3EDp5FXM2P4bum8MrrsJC9LHmgwIMDvzaF23dtJ57u1wyTcT86mnUM4Bi3QdvekJCO/s9njAnbv/BRGc/D6utFsYhvM3RnDSW3EzMu+3jAqWhyvtgsL/YYrXN8Gc5jnFGgk6ke8/QdB04t89/1O/w1cDnyilFU=';
$channelSecret = '1d45ac84e0c412bb43fd023ecaa88ed0';
$clients = new LINEBotTiny($channelAccessToken, $channelSecret);
function replyMessage($clients, $reply_token, $messages) {
    return $clients->replyMessage([
        'replyToken' => $reply_token,
        'messages' => $messages
    ]);
}
foreach ($clients->parseEvents() as $event) {
    if ($event['type'] == 'message') {
        $message = $event['message'];
        switch ($message['type']) {
            case 'text':
                $messages = [
                    [
                        "type" => "template",
                        "altText" => "This is a buttons template",
                        "template" => [
                            "type" => "buttons",
                            "thumbnailImageUrl" => "https://profile.line-scdn.net/0m0201800c7251db82f85e7e2f9dec6ae822521f83cae0",
                            "imageAspectRatio" => "rectangle",
                            "imageSize" => "cover",
                            "imageBackgroundColor" => "#FFFFFF",
                            "title" => "Menu",
                            "text" => "Please select",
                            "defaultAction" => [
                                "type" => "uri",
                                "label" => "View detail",
                                "uri" => "http://example.com/page/123"
                            ],
                            "actions" => [
                                [
                                    "type" => "postback",
                                    "label" => "Buy",
                                    "data" => "action=buy&itemid=123"
                                ],
                                [
                                    "type" => "postback",
                                    "label" => "Add to cart",
                                    "data" => "action=add&itemid=123"
                                ],
                                [
                                    "type" => "uri",
                                    "label" => "View detail",
                                    "uri" => "http://example.com/page/123"
                                ]
                            ]
                        ]
                    ]
                ];
                replyMessage($clients, $event['replyToken'], $messages);
                break;
            case 'sticker':
                $messages = [
                    [
                        'type' => 'text',
                        'text' => '位置情報を送ってください',

                    ]
                ];
                replyMessage($clients, $event['replyToken'], $messages);
                break;
            case 'location':
                $lat = $message['latitude'];
                $lng = $message['longitude'];
                $uri = 'https://webservice.recruit.co.jp/hotpepper/gourmet/v1/';
                $accesskey = '2a60a96fb9488110';
                $url  = $uri . '?key=' . $accesskey . '&lat=' . $lat . '&lng=' . $lng . '&format=json';
                $conn = curl_init();
                curl_setopt($conn, CURLOPT_URL, $url);
                curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
                $res = curl_exec($conn);
                $results = json_decode($res);
                curl_close($conn);
                $columns = array();
                foreach ($results->results->shop as $restaurant) {
                    $columns[] = array(
                        'thumbnailImageUrl' => $restaurant->logo_image,
                        'title' => $restaurant->name,
                        'text' => $restaurant->address,
                        'actions' => array(
                            array(
                                'type' => 'uri',
                                'label' => '詳細を見る',
                                'uri' => $restaurant->urls->pc
                            )
                        )
                    );
                }
                if ($columns !== null) {
                    $messages = [
                        [
                            'type' => 'template',
                            'altText' => '近くのお店情報',
                            'template' => [
                                'type' => 'carousel',
                                'columns' => [
                                    [
                                        'thumbnailImageUrl' => $columns[0][thumbnailImageUrl] ,
                                        'imageBackgroundColor' => '#FFFFFF',
                                        'title' => $columns[0][title],
                                        'text' => $columns[0][text],
                                        'actions' => [
                                            [
                                                'type' => 'uri',
                                                'label' => 'ホットペッパーサイトへ',
                                                'uri'=>$columns[0]['actions'][0]['uri'],
                                            ]
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ];
                    replyMessage($clients, $event['replyToken'], $messages);
                    break;
                } else {
                        $messages = [
                            [
                                'type' => 'text',
                                'text' => '近くにお店が見つかりませんでした。'
                            ]
                    ];
                    replyMessage($clients, $event['replyToken'], $messages);
                    break;
                }
        }
    } else {
        error_log('Unsupported event type:' . $event['type']);
        break;
    }
};
?>