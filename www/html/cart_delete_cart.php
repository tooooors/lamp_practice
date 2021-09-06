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
  // 不正リクエストの場合カートページへリダイレクト
  set_error('不正なリクエストです');
  redirect_to(CART_URL);
}

// PDOの取得
$db = get_db_connect();
// PDOを利用してログインユーザーのデータ取得
$user = get_login_user($db);

// POSTデータの取得
$cart_id = get_post('cart_id');

// カートから商品を削除する
if(delete_cart($db, $cart_id)){
  set_message('カートを削除しました。');
} else {
  set_error('カートの削除に失敗しました。');
}

// トークンの再生成
$token = get_csrf_token();

// カートページへリダイレクト
redirect_to(CART_URL);