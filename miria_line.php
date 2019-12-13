<?php
mb_language("ja");
mb_internal_encoding("UTF-8");

include 'miria_token.php';
$accessToken = $token;

include 'miria_param.php';

//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

$replyToken = $json_object->{"events"}[0]->{"replyToken"};
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};
$message_text = $json_object->{"events"}[0]->{"message"}->{"text"};

//メッセージタイプがtext以外のときは終了
if($message_type != "text") exit;

//テキスト返信
if(preg_match("/やって/",$message_text)){
  $return_message_text = "みりあもやるー！！";
}else if(preg_match("/^(?=.*みりあ)(?=.*自己紹介).*$/",$message_text)){
  $return_message_text = "赤城みりあですっ♪　かわいいもの、だーい好き！アイドルってカワイイ服着られて、カワイイ歌とかダンス、やらせてもらえるんだよね？わーいっ！はやくアイドルになって、楽しいこと見つけたいな！";
}else if(preg_match("/^(?=.*みりあ)(?=.*指名).*$/",$message_text)){
  $return_message_text = selSpeaker($message_text,$member_name);
}else if(preg_match("/^(?=.*みりあ)(?=.*ロガー).*$/",$message_text)){
  $return_message_text = selLogger($message_text,$member_name);
}else if(preg_match("/^みりあ(.|([0-9]|[1-9][0-9]{1,11}|1000000000000)(\.[0-9]+)?)(味鮮|鮮味)$/",$message_text)){
  $return_message_text = selmisen($message_text,$hyakumi_menu);
}else if(preg_match("/^みりあ\.rand\(([1-9]?[0-9]|100)\)$/",$message_text)){
    $return_message_text = randmiria($message_text);
}else if(preg_match("/みりあ/",$message_text)){
     $return_message_text = $message_text . "やんないよ";
}
sending_messages($accessToken, $replyToken, $message_type, $return_message_text);

//メッセージの送信
function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
    $response_format_text = [
        "type" => $message_type,
        "text" => $return_message_text
    ];
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}

//指名
function selSpeaker($message_text,$member_name){

    $name = $member_name;
	$key = array_rand($name);

	return "じゃあ……".$name[$key]."！！";
}
//ロガー
function selLogger($message_text,$member_name){

    $name = $member_name;
	$key = array_rand($name);

	return "きょうのログをとってくれるプロデューサーさんは、".$name[$key]."だよっ！";
}
//n味鮮
function selmisen($message_text,$hyakumi_menu){

    $name = $hyakumi_menu;
	$key = array_rand($name);

	return "うんとね、みりあののおすすめは".$name[$key]."だよっ！";
}
//みりあ.rand()
function randmiria($message_text){
    $num = mb_substr(rtrim($message_text, ')'),9);
    return "じゃあ……".rand(0, $num)."！！";
}
