<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'item.php';
// cartデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'cart.php';

// ログインチェックを行うためセッションを開始する
session_start();

// ログインチェック用の関数を使用
if(is_logined() === false){
  // ログインしていない場合ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}

// PDOを取得
$db = get_db_connect();
// PDOを利用してログインユーザーのデータを取得
$user = get_login_user($db);
// PDOを利用してログインユーザーのカートのデータを取得
$carts = get_user_carts($db, $user['user_id']);
// 合計金額の取得
$total_price = sum_carts($carts);
// HTMLエンティティに変換する
$carts = entity_assoc_array($carts);

// トークン生成
$token = get_csrf_token();

// ビューの読み込み
include_once VIEW_PATH . 'cart_view.php';