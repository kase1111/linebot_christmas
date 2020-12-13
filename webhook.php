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
                if ($message['text'] == "独身" || $message['text'] == "一人") {
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
                                "title" => "クリスマスの過ごしかた",
                                "text" => "Please select",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => "出かける",
                                        "data" => "action=buy&itemid=123",
                                        "displayText" => "出かける"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => "映画を見る",
                                        "data" => "action=add&itemid=123",
                                        "displayText" => "映画を見る"
                                    ],
                                ]
                            ]
                        ]
                    ];
                    replyMessage($clients, $event['replyToken'], $messages);
                    break;
                } elseif ($message['text'] == "カップル" || $message['text'] == "二人" || $message['text'] == "彼氏" || $message['text'] == "彼女") {
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
                                "title" => "クリスマスの過ごしかた",
                                "text" => "Please select",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => "デートスポットを探す",
                                        "data" => "action=buy&itemid=123",
                                        "displayText" => "デートスポットを探す"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => "プレゼントを送る",
                                        "data" => "action=add&itemid=123",
                                        "displayText" => "プレゼントを送る"
                                    ]
                                ]
                            ]
                        ]
                    ];
                    replyMessage($clients, $event['replyToken'], $messages);
                    break;
                } elseif ($message['text'] == "家族") {
                    $messages = [
                        [
                            "type" => "template",
                            "altText" => "This is a buttons template",
                            "template" => [
                                "type" => "buttons",
                                "thumbnailImageUrl" => "",
                                "imageAspectRatio" => "rectangle",
                                "imageSize" => "cover",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "クリスマスの過ごしかた",
                                "text" => "Please select",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => "映画を見る",
                                        "data" => "action=add&itemid=123",
                                        "displayText" => "映画を見る"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => "プレゼントを送る",
                                        "data" => "action=add&itemid=123",
                                        "displayText" => "プレゼントを送る"
                                    ]
                                ]
                            ]
                        ]
                    ];
                    replyMessage($clients, $event['replyToken'], $messages);
                    break;
                } else {
                    $clients->replyMessage([
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            ['type' => 'text', 'text' => "クリスマスは誰と過ごしますか"]
                        ]
                    ]);
                    break;
                }
            case 'sticker':
                $messages = [
                    [
                        'type' => 'text',
                        'text' => '位置情報を送ってください',

                    ]
                ];
                replyMessage($clients, $event['replyToken'], $messages);
                break;
        }
    } else {
        error_log('Unsupported event type:' . $event['type']);
        break;
    }
};
?>