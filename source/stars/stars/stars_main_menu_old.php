<?php
$dir = "stars/data";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $file_names[] = $filename;
}

sort($file_names);

//print_r($files);

//rsort($files);

//print_r($files);


$tour_names_data=array();
for ($i=0;$i<(count($file_names)-2);$i++)
{
  $m=$i+1;
  include("stars/data/description"."_".$m."."."php");
  $tour_names_data[$i]["tour_name"]=$star_tour_name;
  $tour_names_data[$i]["tour_days"]=$star_tour_days;
  $tour_names_data[$i]["tour_days_remark"]=$star_tour_days_remark;
  $tour_names_data[$i]["tour_days_remark1"]=$star_tour_days_remark1;

  $tour_names_data[$i]["tour_price"]=$star_tour_price;
  $tour_names_data[$i]["tour_price_remark"]=$star_tour_price_remark;
  $tour_names_data[$i]["tour_price_remark1"]=$star_tour_price_remark1;
  $tour_names_data[$i]["tour_header"]=$star_tour_header;
  $tour_names_data[$i]["tour_direction"]=$star_tour_direction;
  $tour_names_data[$i]["tour_id"]=$m;
  $tour_names_data[$i]["tour_bg"]=$bg_color;
}




print ("<table border=\"1\" cellspacing=\"0\" width=\"600\" id=\"$star_tour_days\" align=\"center\"
style=\"FONT-WEIGHT: bold; FONT-SIZE: 14px; FONT-FAMILY: arial;BORDER: #000080 3px solid; font-color:#000080;margin-top:5px\">");

for($i=0;$i<count($tour_names_data);$i++)
{
  $bg_color=$tour_names_data[$i]["tour_bg"];
  $name=$tour_names_data[$i]["tour_name"];
  $days=$tour_names_data[$i]["tour_days"];
  $tour_price=$tour_names_data[$i]["tour_price"];
  $header=$tour_names_data[$i]["tour_header"];
  $direction= $tour_names_data[$i]["tour_direction"];
  $id=$tour_names_data[$i]["tour_id"];
  $days_remark= $tour_names_data[$i]["tour_days_remark"];
  $days_remark1= $tour_names_data[$i]["tour_days_remark1"];
  $price_remark=  $tour_names_data[$i]["tour_price_remark"];
  $price_remark1= $tour_names_data[$i]["tour_price_remark1"];
  $price='<span style=\"font-size:11px\">'.$price_remark.'</span>'.'<span style=\"font-size:13px\">'.' $'.$tour_price.'</span>'.' '.'<span style=\"font:11px\">'.$price_remark1.'</span>';
  print ("<tr  style=\"font-color:#000080;BACKGROUND:$bg_color\">
  <td style=\"padding-left:5px\"><a  href=\"stars.php?tour_id=$id#ezine-abstracts\" title=\"Описание тура\">$name</a></td>
  <td style=\"text-align:center;color:#000080;font-size:12px\">$days дней $days_remark</a></td>
  <td style=\"padding-left:5px\"><a class=\"sublnk\" href=\"stars.php?tour_id=$id#ezine-abstracts\" style=\"font-size:13px;font-weight:bold\" title=\"Описание тура\">$direction</a></td>
  <td style=\"text-align:center;color:#000080\"><span style=\"font-size:11px\">$price_remark</span> $$tour_price<span style=\"font-size:11px\"> $price_remark1</span></td>
  <td><a class=\"sublnk\" href=\"reservation/myform.html\" >Заказать</a></td></tr>");


}
  print ("<tr  style=\"font-color:#000080;BACKGROUND:BACKGROUND:#ffffcc\">
  <td style=\"padding-left:5px\"><a  href=\"/new-tours/regular.php?reg_id=95\" title=\"Описание тура\">ВСЯ КАНАДА – ОТ ОКЕАНА ДО ОКЕАНА <br/>(Тур без заезда в США)</a></td>
  <td style=\"text-align:center;color:#000080;font-size:12px\">16 дней</a></td>
  <td style=\"padding-left:5px\"><a class=\"sublnk\" href=\"/new-tours/regular.php?reg_id=95\" style=\"font-size:13px;font-weight:bold\" title=\"Описание тура\">Монреаль, Квебек, Торонто, Тысяча Островов, Ниагарские Водопады, Скалистые горы, Британская Колумбия, Альберта, Джаспер, Банф, Калгари, Эдмонтон, горы, озера, ледники, горячие источники, водопады, глетчеры....
</a></td>
  <td style=\"text-align:center;color:#000080\"> $2120<span style=\"font-size:11px\"><br/>Плюс внутренний перелет Торонто-Эдмонтон</span></td>
  <td><a class=\"sublnk\" href=\"reservation/myform.html\" >Заказать</a></td></tr>");

  print ("<tr  style=\"font-color:#000080;BACKGROUND:BACKGROUND:#ffffcc\">
  <td style=\"padding-left:5px\"><a  href=\"/new-tours/regular.php?reg_id=96\" title=\"Описание тура\">ВСЯ КАНАДА – ОТ ОКЕАНА ДО ОКЕАНА <br/>(с заездом  в США - Нью-Йорк)</a></td>
  <td style=\"text-align:center;color:#000080;font-size:12px\">18 дней</a></td>
  <td style=\"padding-left:5px\"><a class=\"sublnk\" href=\"/new-tours/regular.php?reg_id=96\" style=\"font-size:13px;font-weight:bold\" title=\"Описание тура\">Скалистые горы, Британская Колумбия, Альберта, Джаспер, Банф, Калгари, Эдмонтон, горы, озера, ледники, горячие источники, глетчеры. Нью-Йорк, Монреаль, Квебек, Торонто, Тысяча Островов, Ниагарские Водопады

</a></td>
  <td style=\"text-align:center;color:#000080\"> $2860<span style=\"font-size:11px\"><br/>включает внутренний перелет из <br/>Нью-Йорка и обратно <br/>в Нью-Йорк</span></td>
  <td><a class=\"sublnk\" href=\"reservation/myform.html\" >Заказать</a></td></tr>");

  print ("<tr  style=\"font-color:#000080;BACKGROUND:BACKGROUND:#ffffcc\">
  <td style=\"padding-left:5px\"><a  href=\"/new-tours/regular.php?reg_id=97\" title=\"Описание тура\">ВСЯ КАНАДА – ОТ ОКЕАНА ДО ОКЕАНА <br/>(с заездом  в США - Нью-Йорк - Сиэтл)</a></td>
  <td style=\"text-align:center;color:#000080;font-size:12px\">19 дней</a></td>
  <td style=\"padding-left:5px\"><a class=\"sublnk\" href=\"/new-tours/regular.php?reg_id=97\" style=\"font-size:13px;font-weight:bold\" title=\"Описание тура\">Скалистые горы, Британская Колумбия, Альберта, Джаспер, Банф, Калгари, Эдмонтон, горы, озера, ледники, горячие источники, глетчеры, Сиэтл, Нью-Йорк, Монреаль, Квебек, Торонто, Тысяча Островов, Ниагарские Водопады

</a></td>
  <td style=\"text-align:center;color:#000080\"> $2980<span style=\"font-size:11px\"><br/>включает внутренний перелет из <br/>Нью-Йорка и обратно <br/>в Нью-Йорк</span></td>
  <td><a class=\"sublnk\" href=\"reservation/myform.html\" >Заказать</a></td></tr>");


print ("</table>");
$star_tour_descr=array();
$star_tour_include= array();
$star_tour_exclude= array();
include("stars/stars_main_page_data.php");
?>




