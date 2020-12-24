<?php
require_once('./LINEBotTiny.php');
require __DIR__ . '/vendor/autoload.php';
require_once('./spreadsheet_api.php');

function getClient() {
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
$spreadsheet_api = new SpreadSheetAPI($spreadsheetId);
$channelAccessToken = 'Z4h+9g1PuYIYBQRv7racpi28U8EsOgP2EBgJ2+er9Vv5kaR80pXelqof2+TZN1qJvZTEmiFf3zxniQNwve+/C6HWuWHKQX4AYLfIR44rlks6ewkL0aAE2WAm0+02E5YZeu/ifqhpdh+PRdhNYGC/OQdB04t89/1O/w1cDnyilFU=';
$channelSecret = '4e0861ca23fe1ae236322455fa423e3a';
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
                                //"title" => "クリスマスの過ごしかた",
                                "text" => "ひとりまったり♪",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => "クリスマスソングを聞く",
                                        "data" => "christmassong",
                                        "displayText" => "クリスマスソングを聞く"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => "映画を見る",
                                        "data" => "movie",
                                        "displayText" => "映画を見る"
                                    ],
                                ]
                            ]
                        ]
                    ];
                    replyMessage($clients, $event['replyToken'], $messages);
                    break;
                } elseif ($message['text'] == "カップル・恋人" || $message['text'] == "二人" || $message['text'] == "彼氏" || $message['text'] == "彼女" || $message['text'] == "恋人") {
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
                                //"title" => "クリスマスの過ごしかた",
                                "text" => "ハッピーな時間❤️",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => "デートスポットを探す",
                                        "data" => "ills",
                                        "displayText" => "デートスポットを探す"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => "プレゼントを送る",
                                        "data" => "present",
                                        "displayText" => "プレゼントを送る"
                                    ],
                                    [
                                        "type" => "postback",
                                        "label" => "オススメのカクテル",
                                        "data" => "cocktail",
                                        "displayText" => "オススメのカクテル"
                                    ]
                                ]
                            ]
                        ]
                    ];
                    replyMessage($clients, $event['replyToken'], $messages);
                    break;
                } elseif ($message['text'] == "家族・友達" || $message['text'] == "家族" || $message['text'] == "友人" || $message['text'] == "友だち" || $message['text'] == "みんな") {
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
                                //"title" => "クリスマスの過ごしかた",
                                "text" => "楽しくワイワイ‼️",
                                "actions" => [
                                    [
                                        "type" => "postback",
                                        "label" => "料理を作る",
                                        "data" => "cock",
                                        "displayText" => "料理を作る"
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
                } elseif ($message['text'] == "アニメ" || $message['text'] == "ラブロマンス" || $message['text'] == "コメディ" || $message['text'] == "ファンタジー" || $message['text'] == "ヒューマン" || $message['text'] == "ドラマ") {
                    $start_cel = 'A2';
                    $end_cel = 'K104';
                    $range = 'movie!' . $start_cel . ':' . $end_cel;
                    $sheet = $service->spreadsheets_values->get($spreadsheetId, $range);
                    $values = $sheet->getValues();
                    $return_data = [];
                    $target_col = 3;
                    for ($i = 0; $i < 34; $i++) {
                        if ($values[$i][$target_col] == $message['text']) {
                            array_push($return_data, $values[$i]);
                        }
                    }
                    shuffle($return_data);
                    file_put_contents(__DIR__ . "/log.txt", print_r($return_data, true) . PHP_EOL, FILE_APPEND);
                                $messages = [
                                    [
                                        "type" => "template",
                                        "altText" => "This is a buttons template",
                                        "template" => [
                                            "type" => "carousel",
                                            "columns" => [
                                                [
                                                    "thumbnailImageUrl" => $return_data[0][9],
                                                    "imageBackgroundColor" => "#FFFFFF",
                                                    "title" => $return_data[0][1],
                                                    "text" => $return_data[0][8],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[0][7]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "thumbnailImageUrl" => $return_data[1][9],
                                                    "imageBackgroundColor" => "#FFFFFF",
                                                    "title" => $return_data[1][1],
                                                    "text" => $return_data[1][8],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[1][7]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "thumbnailImageUrl" => $return_data[2][9],
                                                    "title" => $return_data[2][1],
                                                    "text" => $return_data[2][8],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[2][7]
                                                        ]
                                                    ]
                                                ],
                                                // [
                                                //     // "thumbnailImageUrl" => "https://56emon-cafe.com/wp-content/uploads/2018/11/happychristmas-e1542467819826.jpg",
                                                //     // "thumbnailImageUrl" => "https://56emon-cafe.com/wp-content/uploads/2018/11/happychristmas-e1542467819826.jpg", "imageBackgroundColor" => "#FFFFFF",
                                                //     "thumbnailImageUrl" => $return_data[3][9],
                                                //     "title" => $return_data[3][1],
                                                //     "text" => $return_data[3][8],
                                                //     "actions" => [
                                                //         [
                                                //             "type" => "uri",
                                                //             "label" => 'リンクに飛ぶ',
                                                //             "uri" => $return_data[3][7]
                                                //         ]
                                                //     ]
                                                // ],
                                            ]
                                        ]
                                    ]
                                ];
                   replyMessage($clients, $event['replyToken'], $messages);
                   break;
                } elseif ($message['text'] == "爽やか" || $message['text'] == "すっきり" || $message['text'] == "さっぱり" || $message['text'] == "甘め" || $message['text'] == "辛め" || $message['text'] == "ラム" || $message['text'] == "ジン" ||  $message['text'] == "ヴェルモット") {
                    $start_cel = 'A2';
                    $end_cel = 'L36';
                    $range = 'cocktail!' . $start_cel . ':' . $end_cel;
                    $sheet = $service->spreadsheets_values->get($spreadsheetId, $range);
                    $values = $sheet->getValues();
                    $return_data = [];
                    if ($message['text'] == "爽やか" || $message['text'] == "すっきり" || $message['text'] == "さっぱり") {
                        $target_col = 3;
                    } elseif ($message['text'] == "甘め" || $message['text'] == "辛め") {
                        $target_col = 7;
                    } elseif ($message['text'] == "ラム" || $message['text'] == "ウィスキー" || $message['text'] == "ジン" || $message['text'] == "リキュール"|| $message['text'] == "ヴェルモット") {
                        $target_col = 6;
                    }
                    for ($i = 0; $i < 34; $i++) {
                        if ($values[$i][$target_col] == $message['text']) {
                            array_push($return_data, $values[$i]);
                        }
                    }
                    shuffle($return_data);
                    file_put_contents(__DIR__ . "/log.txt", print_r($return_data, true) . PHP_EOL, FILE_APPEND);
                                $messages = [
                                    [
                                        "type" => "template",
                                        "altText" => "This is a buttons template",
                                        "template" => [
                                            "type" => "carousel",
                                            "columns" => [
                                                [
                                                    "thumbnailImageUrl" => $return_data[0][11],
                                                    "imageBackgroundColor" => "#FFFFFF",
                                                    "title" => $return_data[0][1],
                                                    "text" => $return_data[0][10],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[0][9]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "thumbnailImageUrl" => $return_data[2][11],
                                                    "imageBackgroundColor" => "#FFFFFF",
                                                    "title" => $return_data[1][1],
                                                    "text" => $return_data[1][10],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[1][9]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "thumbnailImageUrl" => $return_data[2][11],
                                                    "title" => $return_data[2][1],
                                                    "text" => $return_data[2][10],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[2][9]
                                                        ]
                                                    ]
                                                ],
                                            ]
                                        ]
                                    ]
                                ];
                   replyMessage($clients, $event['replyToken'], $messages);
                   break;
                } elseif ($message['text'] == "東北" || $message['text'] == "関東" || $message['text'] == "中部" || $message['text'] == "関西" || $message['text'] == "中国" || $message['text'] == "四国" || $message['text'] == "九州") {
                    $start_cel = 'A2';
                    $end_cel = 'K102';
                    $target = 'area';
                    $range = 'couple!' . $start_cel . ':' . $end_cel;
                    $sheet = $service->spreadsheets_values->get($spreadsheetId, $range);
                    $values = $sheet->getValues();
                    $return_data = [];
                    for ($i = 0; $i < 8; $i++) {
                        if ($values[0][$i] == $target) {
                            $target_col = $i;
                            break;
                        }
                    }
                    for ($i = 0; $i < 100; $i++) {
                        if ($values[$i][$target_col] == $message['text']) {
                            array_push($return_data, $values[$i]);
                        }
                    }
                    shuffle($return_data);
                    file_put_contents(__DIR__ . "/log.txt", print_r($return_data, true) . PHP_EOL, FILE_APPEND);
                                $messages = [
                                    [
                                        "type" => "template",
                                        "altText" => "This is a buttons template",
                                        "template" => [
                                            "type" => "carousel",
                                            "columns" => [
                                                [
                                                    "thumbnailImageUrl" => $return_data[0][8],
                                                    "imageBackgroundColor" => "#FFFFFF",
                                                    "title" => $return_data[0][3],
                                                    "text" => $return_data[0][1],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[0][6]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "thumbnailImageUrl" => $return_data[1][8],
                                                    "imageBackgroundColor" => "#FFFFFF",
                                                    "title" => $return_data[1][3],
                                                    "text" => $return_data[1][1],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[1][6]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "thumbnailImageUrl" => $return_data[2][8],
                                                    "title" => $return_data[2][3],
                                                    "text" => $return_data[2][1],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[2][6]
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    "thumbnailImageUrl" => $return_data[3][8],
                                                    "title" => $return_data[3][3],
                                                    "text" => $return_data[3][1],
                                                    "actions" => [
                                                        [
                                                            "type" => "uri",
                                                            "label" => 'リンクに飛ぶ',
                                                            "uri" => $return_data[3][6]
                                                        ]
                                                    ]
                                                ],
                                            ]
                                        ]
                                    ]
                                ];
                   replyMessage($clients, $event['replyToken'], $messages);
                   break;
                } elseif ($message['text'] == "メイン" || $message['text'] == "一品" || $message['text'] == "スイーツ") {
                    $start_cel = 'A2';
                    $end_cel = 'F323';
                    $range = 'recipe!' . $start_cel . ':' . $end_cel;
                    $sheet = $service->spreadsheets_values->get($spreadsheetId, $range);
                    $values = $sheet->getValues();
                    $return_data = [];
                    $target_col = 3;//genre
                    for ($i = 0; $i < 100; $i++) {
                        if ($values[$i][$target_col] == $message['text']) {
                            array_push($return_data, $values[$i]);
                        }
                    }
                    shuffle($return_data);
                    file_put_contents(__DIR__ . "/log.txt", print_r($return_data, true) . PHP_EOL, FILE_APPEND);
                    $messages = [
                        [
                            "type" => "template",
                            "altText" => "This is a buttons template",
                            "template" => [
                                "type" => "carousel",
                                "columns" => [
                                    [
                                        "thumbnailImageUrl" => $return_data[1][5], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $return_data[1][1],
                                        "text" => $return_data[1][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $return_data[1][4]
                                            ]
                                        ]
                                    ],
                                    [
                                        "thumbnailImageUrl" => $return_data[2][5], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $return_data[2][1],
                                        "text" => $return_data[2][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $return_data[2][4]
                                            ]
                                        ]
                                    ],
                                    [
                                        "thumbnailImageUrl" => $return_data[3][5], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $return_data[3][1],
                                        "text" => $return_data[3][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $return_data[3][4]
                                            ]
                                        ]
                                    ],
                                    [
                                        "thumbnailImageUrl" => $return_data[4][5], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $return_data[4][1],
                                        "text" => $return_data[4][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $return_data[4][4]
                                            ]
                                        ]
                                    ],
                                ]
                            ]
                        ]
                            ];
                replyMessage($clients, $event['replyToken'], $messages);
                break;       
                } else { //(($message['text'] == "使い方")) {
                    $clients->replyMessage([
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            ['type' => 'text',
                             'text' => "こちらでは、クリスマスにちょっと役立つプランをご紹介します$\n\n" . "貴方はXmas誰と過ごしますか$\n\n" . "一人でもカップルでも家族でも皆様に優しい聖夜が訪れるお手伝いします$",
                             'emojis' => [
                                 [
                                 "index" => 29,
                                 "productId" => "5ac1bfd5040ab15980c9b435",
                                 "emojiId" => "219"
                                ],
                                [
                                 "index" => 47,
                                 "productId" => "5ac1bfd5040ab15980c9b435",
                                 "emojiId" => "159"
                                ],
                                [
                                 "index" => 83,
                                 "productId" => "5ac21184040ab15980c9b43a",
                                 "emojiId" => "195"
                                ]
                             ]
                            ]
                        ]
                    ]);
                    break;
                }
            case 'sticker':
                $x = 1;
                $messages = [
                    [
                        'type' => 'text',
                        'text' => 'クリスマスは誰と過ごしますか',
                    ]
                ];
                replyMessage($clients, $event['replyToken'], $messages);
        }
    } elseif ($event['postback']['data'] == 'movie') {
        $messages = [
            [
                'type' => 'text',
                'text' => 'ジャンルを選んでください',
                'quickReply' => [
                    'items' => [
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'アニメ',
                                'text' =>'アニメ'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'コメディ',
                                'text' =>'コメディ'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'ヒューマン',
                                'text' =>'ヒューマン'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'ファンタジー',
                                'text' =>'ファンタジー'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'ラブロマンス',
                                'text' =>'ラブロマンス'
                            ]
                        ],
                        // [
                        //     'type' => "action",
                        //     'action' => [
                        //         'type' => "message",
                        //         'label' => 'SF',
                        //         'text' =>'SF'
                        //     ]
                        // ],
                        // [
                        //     'type' => "action",
                        //     'action' => [
                        //         'type' => "message",
                        //         'label' => 'ホラー',
                        //         'text' =>'ホラー'
                        //     ]
                        // ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'ドラマ',
                                'text' =>'ドラマ'
                            ]
                        ],
                    ]
                ]
            ]
        ];
        replyMessage($clients, $event['replyToken'], $messages);
    break;
    
    } elseif ($event['postback']['data'] == 'cock') {
        $messages = [
            [
                'type' => 'text',
                'text' => 'カテゴリを選んでください',
                'quickReply' => [
                    'items' => [
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'メイン',
                                'text' =>'メイン'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '一品',
                                'text' =>'一品'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'スイーツ',
                                'text' =>'スイーツ'
                            ]
                        ],
                    ]
                ]
            ]
        ];
        replyMessage($clients, $event['replyToken'], $messages);
    break;
    
    } elseif ($event['postback']['data'] == 'present') {
        $presentrange = 'present!A2:F24';
        $present = $service->spreadsheets_values->get($spreadsheetId, $presentrange);
        $presents = $present->getValues();
        $return_data = [];
        // file_put_contents(__DIR__ . "/log.txt", print_r($return_data, true) . PHP_EOL, FILE_APPEND);
        $x = range(1,21);
          shuffle($x);
         file_put_contents(__DIR__ . "/log.txt", print_r($presents[$x[1]][5], true) . PHP_EOL, FILE_APPEND);
                    $messages = [
                        [
                            "type" => "template",
                            "altText" => "This is a buttons template",
                            "template" => [
                                "type" => "carousel",
                                "columns" => [
                                    [
                                         "thumbnailImageUrl" => $presents[$x[1]][5], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                         "title" => $presents[$x[1]][3],
                                         "text" => $presents[$x[1]][1],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $presents[$x[1]][4]
                                            ]
                                        ]
                                    ],
                                    [
                                         "thumbnailImageUrl" => $presents[$x[2]][5], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                         "title" => $presents[$x[2]][3],
                                         "text" => $presents[$x[2]][1],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $presents[$x[2]][4]
                                            ]
                                        ]
                                    ],
                                    [
                                         "thumbnailImageUrl" => $presents[$x[3]][5], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                         "title" => $presents[$x[3]][3],
                                         "text" => $presents[$x[3]][1],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $presents[$x[3]][4]
                                            ]
                                        ]
                                    ],
                                    [
                                         "thumbnailImageUrl" => $presents[$x[4]][5], 
                                         "title" => $presents[$x[4]][3],
                                         "text" => $presents[$x[4]][1],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $presents[$x[4]][4]
                                            ]
                                        ]
                                    ],
                                ]
                            ]
                        ]
                            ];
       replyMessage($clients, $event['replyToken'], $messages);
       break;
    } elseif ($event['postback']['data'] == 'cocktail') {
        $messages = [
            [
                'type' => 'text',
                'text' => '飲みたい気分のカクテルを選んでください',
                'quickReply' => [
                    'items' => [
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '爽やか',
                                'text' =>'爽やか'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'すっきり',
                                'text' =>'すっきり'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'さっぱり',
                                'text' =>'さっぱり'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '甘め',
                                'text' =>'甘め'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '辛め',
                                'text' =>'辛め'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'ラム',
                                'text' =>'ラム'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'ヴェルモット',
                                'text' =>'ヴェルモット'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => 'ジン',
                                'text' =>'ジン'
                            ]
                        ],
                    ]
                ]
            ]
        ];
        replyMessage($clients, $event['replyToken'], $messages);
    break;
    } elseif ($event['postback']['data'] == 'christmassong') {
        $christmassongrange = 'christmassong!A2:H76';
        $christmassong = $service->spreadsheets_values->get($spreadsheetId, $christmassongrange);
        $christmassong = $christmassong->getValues();
        $x = range(1,70);
          shuffle($x);
        //  file_put_contents(__DIR__ . "/log.txt", print_r($search_data, true) . PHP_EOL, FILE_APPEND);
                    $messages = [
                        [
                            "type" => "template",
                            "altText" => "This is a buttons template",
                            "template" => [
                                "type" => "carousel",
                                "columns" => [
                                    [
                                        "thumbnailImageUrl" => $christmassong[$x[1]][7], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $christmassong[$x[1]][1],
                                        "text" => $christmassong[$x[1]][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $christmassong[$x[1]][5]
                                            ]
                                        ]
                                    ],
                                    [
                                        "thumbnailImageUrl" => $christmassong[$x[2]][7], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $christmassong[$x[2]][1],
                                        "text" => $christmassong[$x[2]][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $christmassong[$x[2]][5]
                                            ]
                                        ]
                                    ],
                                    [
                                        "thumbnailImageUrl" => $christmassong[$x[3]][7], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $christmassong[$x[3]][1],
                                        "text" => $christmassong[$x[3]][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $christmassong[$x[3]][5]
                                            ]
                                        ]
                                    ],
                                    [
                                        "thumbnailImageUrl" => $christmassong[$x[4]][7], 
                                        "imageBackgroundColor" => "#FFFFFF",
                                        "title" => $christmassong[$x[4]][1],
                                        "text" => $christmassong[$x[4]][3],
                                        "actions" => [
                                            [
                                                "type" => "uri",
                                                "label" => 'リンクに飛ぶ',
                                                "uri" => $christmassong[$x[4]][5]
                                            ]
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ];
       replyMessage($clients, $event['replyToken'], $messages);
       break;
    } elseif ($event['postback']['data'] == 'ills') {
        $messages = [
            [
                'type' => 'text',
                'text' => '地域を選んでください',
                'quickReply' => [
                    'items' => [
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '東北',
                                'text' =>'東北'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '関東',
                                'text' =>'関東'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '中部',
                                'text' =>'中部'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '関西',
                                'text' =>'関西'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '中国',
                                'text' =>'中国'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '四国',
                                'text' =>'四国'
                            ]
                        ],
                        [
                            'type' => "action",
                            'action' => [
                                'type' => "message",
                                'label' => '九州',
                                'text' =>'九州'
                            ]
                        ],
                    ]
                ]
            ]
        ];
        replyMessage($clients, $event['replyToken'], $messages);
        break;
    } else {
        error_log('Unsupported event type:' . $event['type']);
        break;
    }
};
?>
