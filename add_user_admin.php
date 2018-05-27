<?php
header("Access-Control-Allow-Origin: *");
include("admin/conn.php");

$json_str = file_get_contents('php://input');
$data = json_decode($json_str, true);

$utype = (int)$data['userType'];
$uid = $data['uname'];
$pwd = $data['passwd'];
$email = $data['email'];
$fn = $data['fname'];
$ln = $data['lname'];

if($utype > 0 && $uid != null && $uid != "" && $pwd != null && $pwd != "" && $email != null && $email != "") {
	$sql = "INSERT INTO delvrt.users (utypeid, uname, passwd, salt, fname, lname, email) VALUES ($utype, '$uid', '$pwd', '', '$fn', '$ln', '$email')";
	$result = pg_query($conn, $sql);

	if ($result) {
	        $list = array('status' => true);
	        echo json_encode($list);
	} else {
	        $list = array('status' => false);
	        echo json_encode($list);
	}
} else {
        $list = array('status' => false);
        echo json_encode($list);
}
?>
