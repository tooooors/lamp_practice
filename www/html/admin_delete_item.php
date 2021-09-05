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
  // ログインしていない場合ログインページへリダイレクト
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

// 管理ユーザー出ない場合ログインページへリダイレクト
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

// POSTデータの取得
$item_id = get_post('item_id');

// 商品削除関数の利用
if(destroy_item($db, $item_id) === true){
  set_message('商品を削除しました。');
} else {
  set_error('商品削除に失敗しました。');
}

// トークンの再生成
$token = get_csrf_token();

// 管理ページへリダイレクト
redirect_to(ADMIN_URL);