<?php
/**
 *		[HoaKhuya] (C)2010-2099 Hacking simple source Orzg.
 *		Drark license payto BitcoinAddress: 1HikvH2jnMNg4rDJHykMMk31gpyr2qrhU4
 *		Coders : develop@execs.com;yuna.elin@yandex.ru;tonghua@dr.com;
 *
 *		$Id: return.php [BuildDB.155478522] 13/07/2017 4:21 SA $
	
*/

session_start();ob_start();

error_reporting(0);

include 'chat.class.php';
$R = new chat_plugin(".");


if ($_GET['nope']){echo $R->returns ();}
if ($_GET['check']){echo $R->check_mess ();}
if ($_GET['fal']){echo $R->postcontent ();}
?>












