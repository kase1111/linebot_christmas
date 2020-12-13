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
                            "title" => "クリスマスはいかが過ごしたいですか？",
                            "text" => "Please select",
                            "actions" => [
                                [
                                    "type" => "postback",
                                    "label" => "デートスポット",
                                    "data" => "action=buy&itemid=123",
                                    "displayText" => "デートスポット"
                                ],
                                [
                                    "type" => "postback",
                                    "label" => "映画",
                                    "data" => "action=add&itemid=123",
                                    "displayText" => "映画"
                                ],
                                [
                                    "type" => "postback",
                                    "label" => "プレゼント",
                                    "data" => "action=add&itemid=123",
                                    "displayText" => "プレゼント"
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
        }
    } else {
        error_log('Unsupported event type:' . $event['type']);
        break;
    }
};
?>