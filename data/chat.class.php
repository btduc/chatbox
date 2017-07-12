<?php
/**
 *		[HoaKhuya] (C)2010-2099 Hacking simple source Orzg.
 *		Drark license payto BitcoinAddress: 1HikvH2jnMNg4rDJHykMMk31gpyr2qrhU4
 *		Coders : develop@execs.com;yuna.elin@yandex.ru;tonghua@dr.com;
 *
 *		$Id: chat.class.php [BuildDB.155478522] 13/07/2017 4:21 SA $
	
*/


#_________________________________________________________________________________________
class chat_plugin {
		function __construct($line) {
		$this->fol = $line;
		$this->conf = $line.'/chat_db/';
		$this->dl = $this->conf.'dl/data.gb';
		}
#_________________________________________________________________________________________
	function chat_hash($c)
	{
		$rand = substr(md5(rand(0,9).rand(0,9).rand(0,9).rand(0,9)),4,8);
		if ($c=="change") { $_SESSION['chat_hash'] = $rand; return $rand;}
		else {return $_SESSION['chat_hash'];} 
	}
#_________________________________________________________________________________________
	function check_mess()
	{
		$thistime = time()-$_SESSION['accesstime'];
		if ($thistime<=2) { return 'NOPE';}
		if ($_POST['hash'] != $this->chat_hash('0') OR !$_POST['hash']) { return '403';}
		$load_db = file_get_contents ($this->dl);
		$tach = explode ("\n",$load_db);
		$soluong = count($tach)-2;
		if ($_SESSION['lastline']>$soluong) {$_SESSION['lastline']=$soluong; return '<script type="text/javascript" charset="utf-8">
		$.post("'.$this->fol.'/return.php?nope=nope",{hash: "'.$this->chat_hash('0').'",},function(data,status){ $("#result").html(data);})</script>';}
		
		if ($_SESSION['lastline']==$soluong) {$_SESSION['accesstime'] = time();return 'NOPE';}
		else {
		$hr = '<hr style="border-bottom-width: 1px;border-top-width: 1px;margin-bottom: 1px;margin-top: 8px;padding-top: 4px;padding-bottom: 4px;">';
		
			for ($i=$_SESSION['lastline']+1; $i <=$soluong ; $i++) { 
			$xuly = explode("|",$tach[$i]);
			$hash = $xuly[1];
			$thoigian =  date('h:i A',$xuly[2]);
			$name = $xuly[3];
			$noidung = $this->emotion($this->bbcode_format(base64_decode($xuly[4])));
			
			$diy .=' <strong style="color:#FF0000;">'.$name.'</strong> : '.$noidung.' <span class="pull-right"><small>'.$thoigian.'</small></span>'.$hr;

			}
		$_SESSION['lastline']=$soluong;
		$_SESSION['accesstime'] = time();
		return $diy;

		}
		
	}
#_________________________________________________________________________________________

	function returns ()
	{
		$thistime = time()-$_SESSION['accesstime'];
		if ($thistime<=2) { return 'NOPE';}
		if ($_POST['hash'] != $this->chat_hash('0') OR !$_POST['hash']) { return '403';}
		$load_db = file_get_contents ($this->dl);
		$tach = explode ("\n",$load_db);
		$soluong = count($tach)-2;
		$_SESSION['lastline'] = $soluong;
		if ($soluong>=51) {$min = $soluong-50;}else { $min = 0;}
		$hr = '<hr style="border-bottom-width: 1px;border-top-width: 1px;margin-bottom: 1px;margin-top: 8px;padding-top: 4px;padding-bottom: 4px;">';
		if ($soluong <= 0 ) { return "Lịch sử chat đã được xoá, gõ <code>help</code> để được trợ giúp.".$hr;}
		for ($i=$min; $i <=$soluong ; $i++) { 
			$xuly = explode("|",$tach[$i]);
			$hash = $xuly[1];
			$thoigian = date('h:i A',$xuly[2]);
			$name = $xuly[3];
			$noidung = $this->emotion($this->bbcode_format(base64_decode($xuly[4])));
			
			$diy .=' <strong style="color:#FF0000;">'.$name.'</strong> : '.$noidung.' <span class="pull-right"><small>'.$thoigian.'</small></span>'.$hr;
		}
		return $diy;
	}

#_________________________________________________________________________________________
	function mahoa ($str)
	{
		return base64_encode($str);
	}
#_________________________________________________________________________________________
function bbcode_format($str){
   // Convert all special HTML characters into entities to display literally
  // $str = htmlentities($str);
   // The array of regex patterns to look for
   $format_search =  array(
      '#\&amp;#is', // Bold ([b]text[/b]
      '#\[b\](.*?)\[/b\]#is', // Bold ([b]text[/b]
      '#\[i\](.*?)\[/i\]#is', // Italics ([i]text[/i]
      '#\[u\](.*?)\[/u\]#is', // Underline ([u]text[/u])
      '#\[s\](.*?)\[/s\]#is', // Strikethrough ([s]text[/s])
      '#\[quote\](.*?)\[/quote\]#is', // Quote ([quote]text[/quote])
      '#Y::([a-zA-Z0-9_-]+)#is', // Quote ([quote]text[/quote])
      '#D::([a-zA-Z0-9_-]+)#is', // Quote ([quote]text[/quote])
       '#\%3A#is', // Bold ([b]text[/b]
     ); 
   // The matching array of strings to replace matches with
   $format_replace = array(
      '&',
      '<strong>$1</strong>',
      '<em>$1</em>',
      '<span style="text-decoration: underline;">$1</span>',
      '<span style="text-decoration: line-through;">$1</span>',
      '<blockquote>$1</blockquote>',
      '<iframe style="max-width:300px" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
      '<iframe style="max-width:300px" src="https://youtube.googleapis.com/embed/?status=ok&hl=en&allow_embed=0&ps=docs&partnerid=30&autoplay=0&docid=$1" frameborder="0" allowfullscreen></iframe>',
      ':',
   );
   // Perform the actual conversion
   $str = preg_replace($format_search, $format_replace, $str);
   // Convert line breaks in the <br /> tag
  // $str = nl2br($str);
   return $str;
}
#_________________________________________________________________________________________
      function emotion($text) {
      	  $width = "24"; 
      	  $widthyh = "30"; // 
           $icons = array(
                         ':D'    =>  '<img src="emo/4.gif" style="max-width:'.$widthyh.'px;"/>',
                         ';;)'    =>  '<img src="emo/5.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':x'    =>  '<img src="emo/8.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':&quot;&gt;'    =>  '<img src="emo/9.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':-s'    =>  '<img src="emo/17.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':(('    =>  '<img src="emo/20.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':))'    =>  '<img src="emo/21.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':|'    =>  '<img src="emo/22.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':-?'    =>  '<img src="emo/39.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':-w'    =>  '<img src="emo/45.gif" style="max-width:'.$widthyh.'px;"/>',
                         '=))'    =>  '<img src="emo/24.gif" style="max-width:'.$widthyh.'px;"/>',
                         ':-h'    =>  '<img src="emo/103.gif" style="max-width:'.$widthyh.'px;"/>',
                         '&gt;.&lt;'    =>  '<img src="emo/angry_emoticon.png" style="max-width:'.$width.'px;"/>',
                         'o.O'    =>  '<img src="emo/confused.png" style="max-width:'.$width.'px;"/>',
                         ':('    =>  '<img src="emo/facebook-frown-emoticon.png" style="max-width:'.$width.'px;"/>',
                         ':v'    =>  '<img src="emo/pacman.png" style="max-width:'.$width.'px;"/>',
                         '^_^'    =>  '<img src="emo/dasdr.png" style="max-width:'.$width.'px;"/>',
                         '@@'    =>  '<img src="emo/43.gif" style="max-width:'.$width.'px;"/>',
                        '-.-'    =>  '<img src="emo/squinting-emoticon.png" style="max-width:'.$width.'px;"/>',
                         ':)'    =>  '<img src="emo/fun.png" style="max-width:'.$width.'px;"/>',
                         ':('    =>  '<img src="emo/sad.png" style="max-width:'.$width.'px;"/>',
                         ':3'    =>  '<img src="emo/curly-lips-smiley.png" style="max-width:'.$width.'px;"/>',
                         ':\'('    =>  '<img src="emo/crying-facebook-emoticon.png" style="max-width:'.$width.'px;"/>',
                         ':P'    =>  '<img src="emo/tongue-out-facebook-emoticon.png" style="max-width:'.$width.'px;"/>',
                         ':*'    =>  '<img src="emo/kiss-emoji.png" style="max-width:'.$width.'px;"/>',
                         '^^'    =>  '<img src="emo/blushing-smiley.png" style="max-width:'.$width.'px;"/>',
                         '=.='    =>  '<img src="emo/expressionless-face_1f611.png" style="max-width:'.$width.'px;"/>',
                         ':/'    =>  '<img src="emo/unsure-emoticon.png" style="max-width:'.$width.'px;"/>',
                         '&lt;3'    =>  '<img src="emo/facebook-heart-emoticon.png" style="max-width:'.$width.'px;"/>',
                         ':poop:'    =>  '<img src="emo/facebook-poop-emoticon.png" style="max-width:'.$width.'px;"/>',
                     );   
            $text = " ".$text." ";       
            foreach ($icons as $search => $replace){
             $text = str_replace(" ".$search." ", " ".$replace." ", $text);
            }
           return trim($text);
      }

#_________________________________________________________________________________________
	function postcontent ()
	{
		$hash = htmlentities($_POST['hash']);
		$noidung = base64_encode(htmlentities($_POST['noidungchat']));
		$now = time();
		$hashcheck = $this->chat_hash('0');
		$kytu = strlen ($_POST['noidungchat']);
		if ($kytu>=300) { return '403';}
		if ( $hash !=$hashcheck ){ return '403';}
		$name = $_SESSION['c_name'];
		$mysig = $_SESSION['username'];
		if (!$name OR !$mysig) { return '403';}
		$data = "|$mysig|$now|$name|$noidung |\n";
		if ($mysig == admin && $_POST['noidungchat']=="cls") {file_put_contents($this->dl,"");}
		elseif (preg_match('/(help)/',$_POST['noidungchat'])) {file_put_contents($this->dl,$data."|aa0014|$now|BOT|".$this->mahoa('
		<br><center><span class="badge badge-success">Lệnh chức năng</span></center>
		<code>Y%3A%3AID_YOUTUBE</code> chèn video từ youtube , ví dụ: <code>Y%3A%3A0yE4wEi8CFM</code></center>
		<br><code>D%3A%3AID_GOOGLE-DRIVE</code> chèn video từ Google Drive , ví dụ: <code>D%3A%3A0Bw4JX8VRHjijSm1VaUNkbHFrOFk</code>

		
		')."|\n",FILE_APPEND);}
		
		elseif(preg_match( '/(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$_POST['noidungchat'])){
		file_put_contents($this->dl,"|aa0014|$now|BOT|".$this->mahoa('<strong>'.$name.'</strong>, bạn không thể post link trên này, bạn sẽ bị khoá tài khoản nếu quảng cáo')."|\n",FILE_APPEND);}
		
		else {file_put_contents($this->dl,$data,FILE_APPEND);}
		return '';
	
		
		
	}
#_________________________________________________________________________________________
		function theme()
	{
		$_SESSION['accesstime']= time();
		return '

<div class="ibox float-e-margins"><div class="ibox-title" style="padding-bottom: 5px;"><h5>Chat Box</h5><div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div></div>
<div class="ibox-content" style="padding-top: 5px;padding-bottom: 5px;padding-left: 5px;padding-right: 5px;">

			
<div class="inset-box" id="contents" style="height: 300px; overflow: auto; margin-top: 10px;"><div style="font-size: 12px;"><div id="result">
<div style="text-align: center;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><h1>Tải dữ liệu phòng chat</h1></div>
</div></div></div>
	
<div class="input-group"><input id="noidungchat" placeholder="Nội dung" required="" type="text" name="datatitle" class="form-control"><span class="input-group-btn"> <button type="button" id="sent" class="btn btn-primary">Gửi </button> </span></div>


</div></div>
	
<script type="text/javascript" charset="utf-8">
$("#sent").click(function () {adc();})

$("#noidungchat").on(\'keypress\', function (e) {if(e.which === 13){adc();}	})



function adc ()
{
var noidungchat = document.getElementById("noidungchat").value;var hash = "'.$this->chat_hash('change').'";var objDiv = document.getElementById("contents");
if (noidungchat && hash){
$.post("'.$this->fol.'/return.php?fal=true",{hash: hash,noidungchat: noidungchat,},function(data,status){document.getElementById("noidungchat").value="";objDiv.scrollTop = objDiv.scrollHeight;});
}else {
swal("Chưa đúng nội dung", "Nội dung chat không thể để trống", "error");
}}
	
	
setTimeout(function(){
	
		var objDiv = document.getElementById("contents");
		$.post("'.$this->fol.'/return.php?nope=true",{hash: "'.$this->chat_hash('0').'",},function(data,status){ $("#result").html(data);objDiv.scrollTop = objDiv.scrollHeight;});

		var refreshIntervalId = setInterval(function(){	
		$.post("'.$this->fol.'/return.php?check=mess",{hash: "'.$this->chat_hash('0').'",},function(data,status){ 
		if (!data.match(/(NOPE)/) && !data.match(/(403)/)){$("#result").append(data);objDiv.scrollTop = objDiv.scrollHeight;}
		else if(data.match(/(403)/)){
			
			$("#result").html("<strong>Phòng chat đã tự động khoá lại do bạn mở cùng lúc nhiều cửa sổ, hãy tải lại trang để mở lại phòng chat.</strong>");
			clearInterval(refreshIntervalId);
		}
		else {
		
		 return false;
		}
		
		});
		
		}, 3000);

},3000);

</script>
		
		
		
		
		
		
		


    
    










		
		
		
		
		
		';
	}
#_________________________________________________________________________________________

	function display ()
	{
//	$data = file_get_contents ($this->dl);
	return $this->theme();
	}
	
#_________________________________________________________________________________________











	
}
	
?>