<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_order_history($db, $user_type, $admin_type, $user_id) {
    $params = array($user_type, $admin_type, $user_id);
    $sql = "
        SELECT
            order_history.order_id,
            order_history.created,
            SUM(price)
        FROM
            order_history
        INNER JOIN
            order_details
        ON
            order_history.order_id = order_details.order_id
        WHERE
            CASE
                WHEN ? = ?
                THEN 0 = 0
                ELSE order_history.user_id = ?
            END
        GROUP BY
            order_history.order_id
        ";
    return fetch_all_query($db, $sql, $params);
}

function get_order_detail($db, $user_type, $admin_type, $user_id, $order_id) {
    $params = array($user_type, $admin_type, $user_id, $order_id);
    $sql = "
        SELECT
            items.name,
            order_details.price,
            order_details.amount,
            order_history.created
        FROM
            order_details
        INNER JOIN
            items
        ON
            items.item_id = order_details.item_id
        INNER JOIN
            order_history
        ON
            order_history.order_id = order_details.order_id
        WHERE
        order_history.user_id =
        CASE
            WHEN ? = ?
            THEN order_history.user_id
            ELSE ?
        END
        AND
            order_details.order_id = ?
        ";
    return fetch_all_query($db, $sql, $params);
}

function get_sum_price($array) {
    foreach ($array as $read) {
        $sum_price += $read['price'];
    }
    return $sum_price;
}