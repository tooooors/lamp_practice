<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'item.php';

// セッションを開始する
session_start();
// ログインチェック関数の利用
if(is_logined() === false){
  // ログインされていない場合ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}

// トークンの照合
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  // 不正リクエストの場合ログインページへリダイレクト
  set_error('不正なリクエストです');
  redirect_to(LOGIN_URL);
}

// PDOの取得
$db = get_db_connect();
// PDOを利用してログインユーザーのデータ取得
$user = get_login_user($db);

// 管理ユーザーでない場合ログインページへリダイレクト
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

// POSTデータの取得
$item_id = get_post('item_id');
$changes_to = get_post('changes_to');

// ステータスの変更
if($changes_to === 'open'){
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  set_message('ステータスを変更しました。');
}else if($changes_to === 'close'){
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  set_message('ステータスを変更しました。');
}else {
  set_error('不正なリクエストです。');
}

// トークンの再生成
$token = get_csrf_token();

// 商品一覧ページへリダイレクト
redirect_to(ADMIN_URL);