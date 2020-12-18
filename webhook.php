<?php
require_once('./LINEBotTiny.php');
require __DIR__ . '/vendor/autoload.php';
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1RObht-7A9jEDU_a8z_8tcboIEVi-aWD0Wjacih3G1ZM';
$illrange = 'couple!A2:H112';
$illumination = $service->spreadsheets_values->get($spreadsheetId, $illrange);
$ills = $illumination->getValues();
$movierange = 'movie!A2:I102';
$movie = $service->spreadsheets_values->get($spreadsheetId, $movierange);
$movies = $movie->getValues();
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
                                "thumbnailImageUrl" => "https://56emon-cafe.com/wp-content/uploads/2018/11/happychristmas-e1542467819826.jpg",
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
                                "thumbnailImageUrl" => "https://56emon-cafe.com/wp-content/uploads/2018/11/happychristmas-e1542467819826.jpg",
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
                                "thumbnailImageUrl" => "https://56emon-cafe.com/wp-content/uploads/2018/11/happychristmas-e1542467819826.jpg",
                                "imageAspectRatio" => "rectangle",
                                "imageSize" => "cover",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "クリスマスの過ごしかた",
                                "text" => "Please select",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => "映画を見る",
                                        "data" => "movie",
                                        "displayText" => "映画を見る"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => "プレゼントを送る",
                                        "data" => "present",
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
        }
    } elseif ($event['postback']['data'] == 'movie') {
        $x = mt_rand(1,100);
        $num = shuffle($x);
            $title = $movies[$num][1];
                    $messages = [
                        [
                            "type" => "template",
                            "altText" => "This is a buttons template",
                            "template" => [
                                "type" => "carousel",
                                "columns" => [
                                [
                                "thumbnailImageUrl" => "https://56emon-cafe.com/wp-content/uploads/2018/11/happychristmas-e1542467819826.jpg",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => $title,
                                "text" => "Please select",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => $movies[$x][3],
                                        "data" => "movie",
                                        "displayText" => "映画を見る"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => $movies[$x][4],
                                        "data" => "present",
                                        "displayText" => "プレゼントを送る"
                                    ]
                                ]
                                    ],
                                [
                                "thumbnailImageUrl" => "https://56emon-cafe.com/wp-content/uploads/2018/11/happychristmas-e1542467819826.jpg",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => $title,
                                "text" => "Please select",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => $movies[$x][3],
                                        "data" => "movie",
                                        "displayText" => "映画を見る"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => $movies[$x][4],
                                        "data" => "present",
                                        "displayText" => "プレゼントを送る"
                                    ]
                                ]
                                ]
                            ]
                        ]
                                    ]
                                ];
       replyMessage($clients, $event['replyToken'], $messages);
       break;
    } elseif ($event['postback']['data'] == 'present') {
        $messages = [
            [
                'type' => 'text',
                'text' => 'プレゼント',

            ]
        ];
       replyMessage($clients, $event['replyToken'], $messages);
       break;
    } else {
        error_log('Unsupported event type:' . $event['type']);
        break;
    }
    // foreach ($clients->parseEvents() as $event) [
    //     if ($event['type'] == 'postback') {
    //         $postback = $event['postback'];
    //             if ($postback['data'] == 'action=add&itemid=123') {
    //                 $messages = array(
    //                     'type' => 'text',
    //                     'text' => 'テスト' 
    //                 );
    //             replyMessage($clients, $event['replyToken'], $messages);
    //             break;
    //         }
    //     }
    // }
};
?>