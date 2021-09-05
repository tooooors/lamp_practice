<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'item.php';

// ログインチェックのためセッションを開始する
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

// 管理ユーザーの場合管理ページへリダイレクト
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

// POSTデータの取得
$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');
// 画像ファイルデータの取得
$image = get_file('image');
// 商品の登録
if(regist_item($db, $name, $price, $stock, $status, $image)){
  set_message('商品を登録しました。');
}else {
  set_error('商品の登録に失敗しました。');
}

// トークンの再生成
$token = get_csrf_token();

redirect_to(ADMIN_URL);