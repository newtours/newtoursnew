<?php
$dir = "stars/data_ny2010";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $file_names_ny[] = $filename;
}

sort($file_names_ny);

//print_r($files);

//rsort($files);

//print_r($files);


$tour_names_data_ny=array();
for ($i=0;$i<(count($file_names_ny)-2);$i++)
{
  $m=$i+1;
  include("stars/data_ny2010/description"."_".$m."."."php");
  $tour_names_data_ny[$i]["tour_name"]=$star_tour_name;
  $tour_names_data_ny[$i]["tour_days"]=$star_tour_days;
  $tour_names_data_ny[$i]["tour_days_remark"]=$star_tour_days_remark;
  $tour_names_data_ny[$i]["tour_days_remark1"]=$star_tour_days_remark1;

  $tour_names_data_ny[$i]["tour_price"]=$star_tour_price;
  $tour_names_data_ny[$i]["tour_price_remark"]=$star_tour_price_remark;
  $tour_names_data_ny[$i]["tour_price_remark1"]=$star_tour_price_remark1;
  $tour_names_data_ny[$i]["tour_header"]=$star_tour_header;
  $tour_names_data_ny[$i]["tour_direction"]=$star_tour_direction;
  $tour_names_data_ny[$i]["tour_id"]=$m;
  $tour_names_data_ny[$i]["tour_bg"]=$bg_color;
  $tour_names_data_ny[$i]["tour_rowid"]=$tour_rowid;
  $tour_names_data_ny[$i]["tour_date"]=$star_tour_date[0];
}




print ("<table border=\"1\" cellspacing=\"0\" width=\"600\" id=\"$star_tour_days\" align=\"center\"
style=\"FONT-WEIGHT: bold; FONT-SIZE: 14px; FONT-FAMILY: arial;BORDER: #000080 3px solid; font-color:#000080;margin-top:5px;margin-left:5px;margin-bottom:5px\">");

for($i=0;$i<count($tour_names_data_ny);$i++)
{
  $tour_rowid=$tour_names_data_ny[$i]["tour_rowid"];
  $bg_color=$tour_names_data_ny[$i]["tour_bg"];
  $name=$tour_names_data_ny[$i]["tour_name"];
  $days=$tour_names_data_ny[$i]["tour_days"];
  $tour_price=$tour_names_data_ny[$i]["tour_price"];
  $header=$tour_names_data_ny[$i]["tour_header"];
  $direction= $tour_names_data_ny[$i]["tour_direction"];
  $id=$tour_names_data_ny[$i]["tour_id"];
  $days_remark= $tour_names_data_ny[$i]["tour_days_remark"];
  $days_remark1= $tour_names_data_ny[$i]["tour_days_remark1"];
  $price_remark=  $tour_names_data_ny[$i]["tour_price_remark"];
  $price_remark1= $tour_names_data_ny[$i]["tour_price_remark1"];
  $tour_date=$tour_names_data_ny[$i]["tour_date"];
  $price='<span style=\"font-size:11px\">'.$price_remark.'</span>'.'<span style=\"font-size:13px\">'.' $'.$tour_price.'</span>'.' '.'<span style=\"font:11px\">'.$price_remark1.'</span>';
  print ("<tr  style=\"font-color:#000080;BACKGROUND:$bg_color\">
  <td style=\"padding-left:5px\"><a  href=\"stars_newyear.php?tour_id=$tour_rowid#ezine-abstracts\" title=\"Описание тура\">$name</a></td>
  <td style=\"text-align:center;color:#000080;font-size:12px\">$days дней $days_remark</a></td>
  <td style=\"padding-left:5px\"><a class=\"sublnk\" href=\"stars_newyear.php?tour_id=$tour_rowid#ezine-abstracts\" style=\"font-size:13px;font-weight:bold\" title=\"Описание тура\">$direction<br/><span style=\"color:red\">$tour_date</span></a></td>
  <td style=\"text-align:center;color:#000080\"><span style=\"font-size:11px\">$price_remark</span> $$tour_price<span style=\"font-size:11px\"> $price_remark1</span></td>
  <td><a class=\"sublnk\" href=\"../new-tours/order_tour.php?ord_tour=$tour_rowid\" >Заказать</a></td></tr>");


}



print ("</table>");
$star_tour_descr=array();
$star_tour_include= array();
$star_tour_exclude= array();
print ("<span style=\"color:#000099\">");
include("stars/stars_main_page_data.php");
print ("</span>");
?>




