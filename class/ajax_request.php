<?php
require 'include/dbconfig.php';
require 'include/Common.php';
require 'include/sendNotification.php';

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'Order Pending Prev') {
        if (isset($_POST['order_id'])) {
            $order_id = $_POST['order_id'];
            $order = $mysqli->query("SELECT * FROM tbl_order where id = $order_id");
            if ($order->num_rows > 0) {
                $row = $order->fetch_assoc();

                //get user details
                $user_id = $row['uid'];
                $user = $mysqli->query("SELECT * FROM tbl_user WHERE id=$user_id AND is_deleted = '0'");
                if ($user->num_rows > 0) {
                    $user = $user->fetch_assoc();
                    $user_arr = array('status' => true, 'name' => $user['name'], 'email' => $user['email'], 'phone' => $user['mobile']);
                } else {
                    $user_arr = array('status' => false, 'message' => 'User Data Not Found!');
                }

                // get category details
                $categoryid = $row['cid'];
                $category = $mysqli->query("SELECT * FROM category WHERE id=$categoryid");
                $catname = '';
                if ($category->num_rows > 0) {
                    $category = $category->fetch_assoc();
                    $catname = $category['cat_name'];
                    $category_arr = array('status' => true, 'catname' => $category['cat_name']);
                } else {
                    $category_arr = array('status' => false, 'message' => 'Category Data Not Found');
                }

                // get order product data
                $order_product = $mysqli->query("SELECT * FROM tbl_order_product WHERE `oid`=$order_id");
                if ($order_product->num_rows > 0) {
                    // $order_product = $order_product->fetch_assoc();
                    $ord_prod = [];
                    while ($r = $order_product->fetch_assoc()) {
                        $r_obj['qty'] = $r['pquantity'];
                        $r_obj['title'] = $r['ptitle'];
                        $r_obj['discount'] = $r['pdiscount'];
                        $r_obj['price'] = $r['pprice'];
                        $r_obj['add_on'] = $r['add_on'];
                        $r_obj['add_per_price'] = $r['add_on'];
                        $ord_prod[] = $r_obj;
                    }

                    $order_product_data_arr = array('status' => true, 'order_product' => $ord_prod);
                    // $order_product_data_arr = array('status' => true, 'qty' => $order_product['pquantity'], 'title' => $order_product['ptitle'], 'discount' => $order_product['pdiscount'], 'price' => $order_product['pprice'], 'add_on' => $order_product['add_on'], 'add_per_price' => $order_product['add_on']);
                } else {
                    $order_product_data_arr = array('status' => false, 'message' => 'Product Data Not Found!');
                }

                $otp_ver = $mysqli->query("SELECT * FROM sms_check_work WHERE `order_id` = " . $order_id . " AND `verified_status` = 1 AND `status` = 0 ");
                if ($otp_ver->num_rows != 0) {
                    $start_order_otp = "1";
                } else {
                    $start_order_otp = "0";
                }
                $order_otp = !empty($row['otp']) ? $row['otp'] : '';

                $data = array(
                    'order_uid' => $row['order_uid'],
                    'add_on' => $row['add_on'],
                    'add_per_price' => $row['add_per_price'],
                    'user_data' => $user_arr,
                    'category' => $category_arr,
                    'order_date' => $row['odate'],
                    'address' => $row['address'],
                    'order_total' => $row['o_total'],
                    'sub_total' => $row['subtotal'],

                    'order_time' => date("g:i a", strtotime($row['otime'])),
                    'service_date' => $row['date'],
                    'service_time' => date("g:i a", strtotime($row['time'])),
                    'lat' => $row['lats'],
                    'longs' => $row['longs'],
                    'order_product' => $order_product_data_arr,
                    'catsname' => $catname,
                    'start_order_otp' => $start_order_otp,
                    'order_otp' => $order_otp,
                );

                $response = array('status' => true, 'message' => 'Order Data Found', 'data' => $data);
            } else {
                $response = array('status' => false, 'message' => 'Order Data Not Found!');
            }
        } else {
            $response = array('status' => false, 'message' => 'Order ID are required!');
        }
    }
} else {
    $response = array('status' => false, 'message' => 'Action Empty');
}
echo json_encode($response);
return;
