<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';

// ログインチェックを行うためセッションを開始する
session_start();
// ログインチェック用の関数を利用
if(is_logined() === true){
  // ログインしている場合は商品一覧ページにリダイレクト
  redirect_to(HOME_URL);
}

// トークンの生成
$token = get_csrf_token();

// iframeの読み込みを禁止する
header("X-FRAME-OPTIONS: DENY");

// ビューの読み込み
include_once VIEW_PATH . 'signup_view.php';



