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
                $clients->replyMessage([
                    'replyToken' => $event['replyToken'],
                    'messages' => [
                        ['type' => 'text', 'text' => "[" . $message['text'] . "だな]"]
                     ]
                ]);
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