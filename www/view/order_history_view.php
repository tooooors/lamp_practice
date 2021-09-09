<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <h1>購入履歴</h1>
    <?php if(count($history) === 0) { ?>
        <p>購入履歴がありません</p>
    <?php }else{ ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">注文番号</th>
                <th scope="col">購入日時</th>
                <th scope="col">合計金額</th>
                <th scope="col">　</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $read) { ?>
            <tr>
                <td><?php print $read['order_id']; ?></td>
                <td><?php print $read['created']; ?></td>
                <td><?php print $read['SUM(price)']; ?></td>
                <td>
                    <form method="get" action="order_detail.php">
                        <input type="hidden" name="order_id" value="<?php print $read['order_id']; ?>">
                        <input type="hidden" name="created" value="<?php print $read['created']; ?>">
                        <input type="hidden" name="sum_price" value="<?php print $read['SUM(price)']; ?>">
                        <input class="btn btn-secondary" type="submit" value="購入明細表示">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</body>
</html>
