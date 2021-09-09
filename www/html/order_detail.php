<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 汎用関数ファイルを読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'item.php';
// cartデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'cart.php';
// orderデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'order.php';

// セッションを開始する
session_start();

// ログインチェック用関数の利用
if(is_logined() === false){
  // ログインしていない場合はログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

// GETデータの取得
$order_id = (int)get_get('order_id');
$created = get_get('created');
$sum_price = get_get('sum_price');

// PDOの取得
$db = get_db_connect();
// PDOを利用してログインユーザーデータの取得
$user = get_login_user($db);

// PDOを利用して購入明細データの取得
$detail = get_order_detail($db, $user['type'], USER_TYPE_ADMIN, $user['user_id'], $order_id);
// HTMLエンティティに変換
$detail = entity_assoc_array($detail);

// iframeでの読み込みを禁止する
header("X-FRAME-OPTIONS: DENY");

// ビューの読み込み
include_once VIEW_PATH . 'order_detail_view.php'; 