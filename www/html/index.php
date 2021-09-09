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

// ログインチェック用関数の利用
if(is_logined() === false){
  // ログインしていない場合はログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

// PDOを取得
$db = get_db_connect();
// PDOを利用してログインユーザーのデータを取得
$user = get_login_user($db);

// 商品一覧用の商品データを取得
$items = get_open_items($db);
// 特殊文字をHTMLエンティティに変換する(2次元配列)
$items = entity_assoc_array($items);

// 人気ランキング用の商品データを取得
$popular_items = get_popular_items($db);
// 特殊文字をHTMLエンティティに変換する(2次元配列)
$popular_items = entity_assoc_array($popular_items);

// トークン生成
$token = get_csrf_token();

// iframeでの読み込みを禁止する
header("X-FRAME-OPTIONS: DENY");

// ビューの読み込み
include_once VIEW_PATH . 'index_view.php';