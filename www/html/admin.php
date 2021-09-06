<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 汎用関数ファイルを読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'item.php';

// ログインチェックを行うため、セッションを開始する
session_start();

// ログインチェック用関数を利用
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// PDOを取得
$db = get_db_connect();

// PDOを利用してログインユーザーのデータを取得
$user = get_login_user($db);

// 管理ユーザーチェック用関数を利用
if(is_admin($user) === false){
  // 管理ユーザーでない場合はログインページへリダイレクト
  redirect_to(LOGIN_URL);
}

// PDOを利用して商品のデータを取得
$items = get_all_items($db);

// 特殊文字をHTMLエンティティに変換する(2次元配列)
$items = entity_assoc_array($items);

// トークン生成
$token = get_csrf_token();

// iframeの読み込みを禁止する
header("X-FRAME-OPTIONS: DENY");

// ビューの読み込み
include_once VIEW_PATH . '/admin_view.php';
