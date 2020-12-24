<?php
//==========================================================================
//  外部ファイル読み込み
//==========================================================================

//==========================================================================
//  Class SpreadSheetAPI
//==========================================================================
class SpreadSheetAPI {

    public $client;
    public $sheet;
    public $sheet_id;

    function __construct($id) {
	// サービスキー設定
	$key = './civic-beaker-297813-b199bc75c38e.json';

        // Googleクライアントインスタンス作成
        $client = new Google_Client();

        // Google SpreadSheetとGoogle Driveをどちらも使用できるよう設定
        $client->setScopes([
            \Google_Service_Sheets::SPREADSHEETS,
            \Google_Service_Sheets::DRIVE,
        ]);

        //サービスキーセット
        $client->setAuthConfig($key);
        $this->sheet = new Google_Service_Sheets($client);
        $this->sheet_id = $id;
    }

    function getSpreadSheetData($range) {

        // 対象のスプレッドシート・範囲から値を取得
        $response = $this->sheet->spreadsheets_values->get($this->sheet_id, $range);
        $values = $response->getValues();

        return $values;
    }

    function getLastRow($sheet_name) {
        $range = $sheet_name . '!A1:A1';
        $response = $this->sheet->spreadsheets_values->get($this->sheet_id, $range);
        $values = $response->getValues();

        return $values[0][0] + 2;
    }

    function getMaxCol($sheet_name) {
        $range = $sheet_name . '!A2:O2';
        $response = $this->sheet->spreadsheets_values->get($this->sheet_id, $range);
        $values = $response->getValues();

        return count($values[0]);
    }

    function conversionColName($col) {
        $col_name = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
            5 => 'E',
            6 => 'F',
            7 => 'G',
            8 => 'H',
            9 => 'I',
            10 => 'J',
            11 => 'K',
            12 => 'L',
            13 => 'M',
            14 => 'N',
            15 => 'O',
            16 => 'P',
            17 => 'Q',
            18 => 'R',
            19 => 'S',
            20 => 'T',
            21 => 'U',
            22 => 'V',
            23 => 'W',
            24 => 'X',
            25 => 'Y',
            26 => 'Z',
        ];

        return $col_name[$col];
    }

    function getAllData($sheet_name, $last_row, $max_col) {
        $col_name = SpreadSheetAPI::conversionColName($max_col);
        $range = $sheet_name . '!' . 'A2:' . $col_name . $last_row;
        $response = $this->sheet->spreadsheets_values->get($this->sheet_id, $range);
        $values = $response->getValues();

        return $values;
    }

    function searchData($sheet_name, $search_type, $search_category) {

        // 行数・列数・全データ取得
        $last_row = SpreadSheetAPI::getLastRow($sheet_name);
        $max_col = SpreadSheetAPI::getMaxCol($sheet_name);
        $all_data = SpreadSheetAPI::getAllData($sheet_name, $last_row, $max_col);

        for ($i = 0; $i < $max_col; $i++) {
            if ($all_data[0][$i] == $search_type) {
                $target_col = $i;
                break;
            }
        }

        for ($i = 0; $i < $last_row; $i++) {
            if ($all_data[$i][$target_col] == $search_category) {
                return $all_data[$i];
            }
        }
    }
    function searchData3($sheet_name, $search_type, $search_category) {

        // 返値用配列
        $return_data = [];
        $data_cnt = 0;

        // 行数・列数・全データ取得
        $last_row = SpreadSheetAPI::getLastRow($sheet_name);
        $max_col = SpreadSheetAPI::getMaxCol($sheet_name);
        $all_data = SpreadSheetAPI::getAllData($sheet_name, $last_row, $max_col);

        for ($i = 0; $i < $max_col; $i++) {
            if ($all_data[0][$i] == $search_type) {
                $target_col = $i;
                break;
            }
        }

        for ($i = 0; $i < $last_row; $i++) {
            if ($data_cnt != 3) {
                if ($all_data[$i][$target_col] == $search_category) {
                    array_push($return_data, $all_data[$i]);
                    $data_cnt++;
                }
            } else {
                break;
            }
        }

        return $return_data;
    }

    function searchDataAll($sheet_name, $search_type, $search_category) {

        // 返値用配列
        $return_data = [];

        // 行数・列数・全データ取得
        $last_row = SpreadSheetAPI::getLastRow($sheet_name);
        $max_col = SpreadSheetAPI::getMaxCol($sheet_name);
        $all_data = SpreadSheetAPI::getAllData($sheet_name, $last_row, $max_col);

        for ($i = 0; $i < $max_col; $i++) {
            if ($all_data[0][$i] == $search_type) {
                $target_col = $i;
                break;
            }
        }

        for ($i = 0; $i < $last_row; $i++) {
            if ($all_data[$i][$target_col] == $search_category) {
                array_push($return_data, $all_data[$i]);
                $data_cnt++;
            }
        }

        return $return_data;
    }
    function getRandNum3($min, $max) {
        $rand = [];
        for ($i = 0; $i < 3; $i++) {
            array_push($rand, mt_rand($min, $max));
        }

        return $rand;
    }

    function getRandNum5($min, $max) {
        $rand = [];
        for ($i = 0; $i < 5; $i++) {
            array_push($rand, mt_rand($min, $max));
        }

        return $rand;
    }

    function getRandNum7($min, $max) {
        $rand = [];
        for ($i = 0; $i < 7; $i++) {
            array_push($rand, mt_rand($min, $max));
        }

        return $rand;
    }
}

class LineFunctions {

    private function replyMessage($message, $channel_access_token) {
        $header = array(
            "Content-Type: application/json",
            'Authorization: Bearer ' . $channel_access_token,
        );
        $context = stream_context_create(array(
            "http" => array(
                "method" => "POST",
                "header" => implode("\r\n", $header),
                "content" => json_encode($message),
                "ignore_errors" => true,
            ),
        ));
        $response = file_get_contents('https://api.line.me/v2/bot/message/reply', false, $context);
        if (strpos($http_response_header[0], '200') === false) {
            http_response_code(500);
        }

        return $response;
    }


    function replyMessageText($reply_token, $send_messages, $channel_access_token){
        $reply_message = array(
            'replyToken' => $reply_token,
            'messages' => $send_messages
        );

        return $this->replyMessage($reply_message, $channel_access_token);
    }


    function createQuickReplyBodyProto(){
        $send_messages = array(
            'type' => 'text',
            'text' => '選択してください。',
            'quickReply' => array(
                'items' => array(
                    array(
                        'type' => 'action',
                        'action' => array(
                            'type' => 'postback',
                            'label' => 'Data Send',
                            'data' => 'PostBackData',
                            'displayText' => 'ポストバックデータを送ります。',
                        )
                    ),
                    array(
                        'type' => 'action',
                        'action' => array(
                            'type' => 'message',
                            'label' => 'Message Send',
                            'text' => 'テキストを送信します。',
                        )
                    ),
                    array(
                        'type' => 'action',
                        'action' => array(
                            'type' => 'datetimepicker',
                            'label' => 'Datetime Send',
                            'data' => 'DateTimeData',
                            'mode' => 'datetime',
                            'initial' => '2018-12-19t00:00',
                            'max' => '2020-12-31t23:59',
                            'min' => '2015-01-01t00:00',
                        )
                    ),
                    array(
                        'type' => 'action',
                        'action' => array(
                            'type' => 'camera',
                            'label' => 'Camera Start',
                        )
                    ),
                    array(
                        'type' => 'action',
                        'action' => array(
                            'type' => 'cameraRoll',
                            'label' => 'CameraRoll Start',
                        )
                    ),
                    array(
                        'type' => 'action',
                        'action' => array(
                            'type' => 'location',
                            'label' => 'Location Send',
                        )
                    ),
                )
            )
        );

        return $send_messages;
    }

}