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
  // ログインしている場合は商品一覧ページへリダイレクト
  redirect_to(HOME_URL);
}

// トークンの照合
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  // 不正なリクエストの場合ログインページへリダイレクト
  set_error('不正なリクエストです');
  redirect_to(LOGIN_URL);
}

// POSTデータの取得
$name = get_post('name');
$password = get_post('password');
$password_confirmation = get_post('password_confirmation');

// PDOの取得
$db = get_db_connect();

try{
  $result = regist_user($db, $name, $password, $password_confirmation);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}

set_message('ユーザー登録が完了しました。');

// トークンの再生成
$token = get_csrf_token();

login_as($db, $name, $password);
redirect_to(HOME_URL);