<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <h1>購入明細</h1>
    <ul>
        <li>注文番号: <?php print $order_id; ?></li>
        <li>購入日時: <?php print $created; ?></li>
        <li>合計金額: <?php print $sum_price; ?>円</li>
    </ul>
    <?php if (count($detail) === 0) { ?>
        <p>購入明細を取得できませんでした。</p>
    <?php } else { ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">商品名</th>
                <th scope="col">価格</th>
                <th scope="col">購入数</th>
                <th scope="col">小計</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $read) { ?>
            <tr>
                <td><?php print $read['name']; ?></td>
                <td><?php print $read['price']; ?></td>
                <td><?php print $read['amount']; ?></td>
                <td><?php print $read['price'] * $read['amount']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</body>
</html>
