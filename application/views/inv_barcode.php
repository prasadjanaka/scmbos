<?php
date_default_timezone_set("Asia/Colombo"); 
foreach ( $pallet_code as $row) {
	$q= $row->pallet_code; 

    $text = $q; 
    $size = (isset($_GET["size"]) ? $_GET["size"] : "40");
    $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal"); 
    $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "Code128"); 
    $code_string = "";

    if (strtolower($code_type) == "code128") {
        $chksum = 104;
        $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ($X = 1; $X <= strlen($text); $X++) {
            $activeKey = substr($text, ($X - 1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum = ($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
        $code_string = "211214" . $code_string . "2331112";
    }
// Pad the edges of the barcode
    $code_length = 20;
    for ($i = 1; $i <= strlen($code_string); $i++)
        $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));
    if (strtolower($orientation) == "horizontal") {
        $img_width = $code_length;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length;
    }
    $image = imagecreate($img_width, $img_height);
    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $white);
    $location = 10;
    for ($position = 1; $position <= strlen($code_string); $position++) {
        $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
        if (strtolower($orientation) == "horizontal")
            imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
        else
            imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
        $location = $cur_size;
    }

    $path = 'barcode_image/';
	$image_file_name = $path . $q . '.png';
    imagepng($image, $path . $q . '.png');

	
	$image_data =  base64_encode(file_get_contents($image_file_name));
	$src = 'data: '.mime_content_type($image_file_name).';base64,'.$image_data;
	
	imagedestroy($image);

?>
<html>


<table align="center" border="0">
 
  <tr>
    <td>
   
      
      <table align="center" style="width:455px">
      <tr>
      <td height="20" style="text-align:center" > <div style="font-size: 20px;text-align: center;font-weight:bold">
        <?php echo $q; ?>
      </div></td>
      </tr>
      
      </table>
      
      </td>
     
  </tr>
  <tr>
    <td ><div style=""> <img src="<?php echo $src ?>" width="467" style="height:100px; width:450px; "/> </div></td>
  </tr>
  <tr>
    <td style="padding-left: 20px;float: left">
     <table width="419" style="width:400px">
      <tr>
       <td width=""  style="width:auto">
       
    <tr>
       <td style="text-align:left;font-size:20px;font-weight:bold;">&nbsp;</td>
       <td style="text-align:right;font-size:20px;font-weight:bold">LOCATION: <?php echo $row->location;  ?>&nbsp;&nbsp;</td>
       
       </tr>
       
      
       
        </td>
       
        <tr>  
        <td height="10">
       <table align=left style="padding-top:-10px" width="100" height="43">
       <tr>
       <td height="18" style="text-align:left;font-size:16px;font-weight:bold">Q<?php echo  ceil(date('n', strtotime($row->datetime))/3);  ?></td>
       <td style="text-align:left;font-size:18px;font-weight:bold"><?php echo strtoupper(date("Y",strtotime($row->datetime)));  ?></td>
       </tr>
       
           <tr>
       <td style="text-align:left;font-size:18px;font-weight:bold;"><?php echo "AQ/PPS"; ?></td>
       <td style="text-align:left;font-size:18px;font-weight:bold;">......./<?php echo sprintf("%04d", $row->handling_quantity);?></td>
       </tr>
       </table>
 </td></tr>
     
      <td width="200" height="28" align="right" style="width:260px;font-size:18px;font-weight:bold">
	  
	  <table style="padding-top:-10px">
      <tr>
     
       <td><div style="font-size:48px;font-weight:bold"><?php   echo "ZONE ".sprintf("%02d", $row->zone_id);  ?></div></td>
      </tr>
      
      </table>
      </td>
         </tr>
      
      </table>
    <table  width="403" style="width: 400px;padding-top:-10px">
        <tr>
          <td width="197" height="20" style="text-align: left;font-size: 30px;width: 200px;font-weight: bold">
          <?php echo $row->product_id?>
          </td>
          <td width="194" style="text-align: right;width: 150px;text-align: right;font-size: 12px;font-weight:bold"><?php echo date("Y/m/d")." - ".date('H:i:s', time());?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php   
unlink($image_file_name);	
} 

?>
