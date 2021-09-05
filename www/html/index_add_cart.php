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
  // 不正リクエストの場合商品一覧ページへリダイレクト
  set_error('不正なリクエストです');
  redirect_to(HOME_URL);
}

// PDOの取得
$db = get_db_connect();
// PDOを利用してログインユーザーのデータ取得
$user = get_login_user($db);

// POSTデータの取得
$item_id = get_post('item_id');

// カートへ追加
if(add_cart($db,$user['user_id'], $item_id)){
  set_message('カートに商品を追加しました。');
} else {
  set_error('カートの更新に失敗しました。');
}

// トークンの再生成
$token = get_csrf_token();

// 商品一覧ページへリダイレクト
redirect_to(HOME_URL);