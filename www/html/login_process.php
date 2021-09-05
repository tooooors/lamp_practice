<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'user.php';

// ログインチェックを行うためセッションを開始する
session_start();

// ログインチェック関数の利用
if(is_logined() === true){
  // ログインしている場合商品一覧ページへリダイレクト
  redirect_to(HOME_URL);
}

// トークンのチェック
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  // 不正リクエストの場合ログインページへリダイレクト
  set_error('不正なリクエストです');
  redirect_to(LOGIN_URL);
}

// POSTデータの取得
$name = get_post('name');
$password = get_post('password');

// PDOの取得
$db = get_db_connect();

// ログイン関数の利用
$user = login_as($db, $name, $password);
// ログイン失敗の場合ログインページへリダイレクト
if( $user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

set_message('ログインしました。');

// トークンの再生成
$token = get_csrf_token();

// 管理ユーザーの場合商品管理ページへリダイレクト
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(ADMIN_URL);
}

// 商品一覧ページへリダイレクト
redirect_to(HOME_URL);