<?php
require_once('./LINEBotTiny.php');
$channelAccessToken = 'VXAu/vpj3M5WrcfasKd8+GsWwUjccHBLKRxN3mEg4VKzqbjSe+dJHBmdENpfY3z79kvA63eVRFYnF0YkS9SQcKZEWYzyD+xbq/vIL5spzzdSv2NaRSDnm2/mnfU1Y5YgucKEe4fq0u6Zm4Npp2td/AdB04t89/1O/w1cDnyilFU=';
$channelSecret = '6c467bf7a3b8ba71de2575038e27c522';

require __DIR__ . '/vendor/autoload.php';
if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
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
                        'type' => 'text',
                        'text' => '位置情報を送れ',

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