<head>
<script src="js/jquery-3.1.1.min.js"></script>
<link href="js/style.css" rel="stylesheet">
<link href="js/bootstrap.min.css" rel="stylesheet">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php
session_start();ob_start();error_reporting(0); // error_reporting để tắt các báo cáo php.
#_________________________________________________________________________________________

/*
		Thiết lập tên người chat qua $_SESSION['c_name']
		Nếu có diễn đàn hay website bạn có thể tìm tên _SESSION của username để thay đổi và hoạt động
		#
		$_SESSION['username'] là thiết lập giá trị tên username của người dùng, giá trị này không hiển thị , nhưng sẽ lưu vào db chat.
		
*/

if (!$_SESSION['c_name']) { $_SESSION['c_name'] = "Tên ".rand(0,9).rand(0,9);}
if (!$_SESSION['username']) { $_SESSION['username'] = "USER-".rand(0,9).rand(0,9);}

define ("admin","admin"); // đặt tên admin phòng để có thể xoá phòng chat (cls)

if ($_GET['adm']=="998") {$_SESSION['username']="admin";}
## END
#_________________________________________________________________________________________

require_once ("data/chat.class.php");
$cbox = new chat_plugin("data"); // Gọi chatbox 'data' là tên thư mục chứa class chatbox
echo $cbox->display();	// hiển thị chatbox

?>

