<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';

// ログインチェックを行うためセッションを開始する
session_start();

// ログインチェック用の関数の利用
if(is_logined() === true){
  // ログインしている場合商品一覧ページへリダイレクト
  redirect_to(HOME_URL);
}

// トークンの生成
$token = get_csrf_token();

// ビューの読み込み
include_once VIEW_PATH . 'login_view.php';