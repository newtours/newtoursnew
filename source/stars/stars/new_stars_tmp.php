<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns=3D"http://www.w3.org/1999/xhtml">
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name="keywords" content="NEW TOURS, tours, Hershey's, Amish Country, Hudson valley, Liliya Gelfand, ����, �����������, ���, ������, ������, �� ������� �����, ���������, ��� ����, ���������, �������, ���������� ��������, ����� ���, Nevele Grande, Pocono, ������, ������ ������, Russian Tours, Russia, Russian New York, ����������, �������, ����������� ����, ������������ ����, ������, ���������� ����, ���� � �������������, tours, ��� ����, ������� ���, ������� �� ���, ���������, ������, �������, google, yahoo, com, ebay.com, ������������� �������, ����� ���, NY, ��� �������, Christmas, New Year, search,  California, Niagara, �������, ���������, Washington, ���������� ����, NEW TOURS - russian tours USA CANADA �������� ��� ���� ��������� ������� ������ ���������� ������ bus tours group tours New York tours �������������� � ��������� ���� ��������������� �������� ������� ��� new tours travelling agency ��������� ������ ���� �� ������� ������� ������ ����� ������ ������ ������� ������� �������� ���������� ������������� ���������� ��������� � ���� russkie ekskursii puteshestviya razvlecheniya dosug 1-2-3 days tours 4-6 days tours ������ ������-������ ������ ������� 1-718-934-7644 ���� �� �������� ������� ��� 307 Brighton Beach Avenue 
Washington ���� �� ��� �� ������� ����� ���� � �������� ������ ������ ������ �������� ������ ������ ���������� ��������� escorted tours  ">
<meta name="description" content="���� �� ��� � ������ � ������� ����� ���������� ��� ���� ������ ������ ������ ���������� ��� ������ ������ �������� ������ ������ ��������� � �������������� ���� �� �������� New Tours ������������� �������� ������� ��� ���� ������� ����������� �� ������� � ������ ����� �� �������� ������� ������ ����������">

<title>����� ������ ��������� ��� ���������� ������ ������� ��������</title>

 <link rel="stylesheet" type="text/css" href="css/stars.css" />


<script src="/new-tours/js/jquery/jquery-1.4.2.min.js" type="text/javascript"></script>

<style type="text/css">
#stars-menu a:link {
        PADDING-LEFT: 20px; FONT-WEIGHT: normal;  COLOR: red;
        TEXT-DECORATION: none
}
</style>
 </head>


<body bgcolor="#ffffff" onload="Carousel()">
 <div class="pg-container">

  <div class="mastad" id="mh"><a href="http://www.newtours.us" target="_blank">

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="468" height="160" id="logo_up_center" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="flash/logo_up_center.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="flash/logo_up_center.swf" quality="high" bgcolor="#ffffff" width="468" height="160" name="logo_up_center" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></a></div>
<div id="site-header"><img src="images/logo.jpg" width="196" height="128px" class="logo" alt="Russian Tour in USA and Canada" id="companylogo" border=0 />  
<div id ="rekvizit" style='width:270px'>307 Brighton Beach Ave, Brooklyn, NY 11235</div>
<div id ="rekvizit1">Tel: 718-934-7644, 718-934-6400 </div>
<div id ="rekvizit2">Email: newtoursusa@yahoo.com</div>
   <div id="navbar" border=2>
    <ul >
     <li><a href="http://www.newtours.us"><b>�������</b></a></li>
     <li><a href="http://www.newtours.us/new-tours/calendar.php"><b>���������</b></a></li>
     <li><a href="http://www.newtours.us/new-tours/week_tour.php?w_m=2"><b>�� ���� ������</b></a></li>


    </ul>
   </div>
  </div>
   
<div id="main-content">
 
    <div class="q_main_top" style="position:relative;float:left;margin-top:10px;PADDING-TOP: 0px;PADDING-BOTTOM: 0px; height:auto; margin-left:4px;width:610px;BORDER: #000080 1px solid">
   <h3 class="q_head_top" style="color:#fff;height:auto;text-align:center;padding-top:2px;FONT-SIZE: 24px; background:#000080">����� ����� "������ ���������"<br/><span style="FONT-SIZE: 11pt; text-align:center">��������� ���������,
�������� ���������,
������, �������</span></h3>
<p class="q_letter_blue" style="text-align:center;color:#000080;margin-top:5px;margin-bottom:5px;font-size:11px;font-style:arial normal"> ����� "������ ���������" - ��� ��������� ������� ���� � �������������� ������.
   <br/> � ���� ����� ����� �������������� �������������� �������.<br/><span style='font-size:13px'> � ���� �������� ���������� � ����������, �� 1-�� �� ���������� ��� ����. </span></p>

<?php
//include ("stars/new_stars_main_menu.php");
include "../new-tours/templates/banner_div_stars.php";
#main table of tour list
#
#
#
print "<div style='margin-left:30px'><ol style='color:#000099;font-size:1.2em;font-weight:bold'>";
$direction_id=1;
foreach ($stars->array_groups as $key2=>$star_list) {
$group_count=count($star_list);
         for ($i=0;$i<$group_count;$i++)
         {
           $m=$i+1;
           include($stars->data_source.'/'.$star_list[$m]);
                        if ($i==0) {

                        $left_menu_arr[]=$star_tour_direction;
                        $direction_link='stars'.$direction_id;
                        print "<li><a href=\"#$direction_link\"><b>".strip_tags($star_tour_direction,'<span>')."</b></a></li>";
                        $direction_id++;
                        }
                        //print_r($left_menu_arr);
           
         }
}
print "</div></ol>";
print ("<table border=\"1\" cellspacing=\"0\" width=\"600\" id=\"$star_tour_days\" align=\"center\"
style=\"FONT-WEIGHT: bold; FONT-SIZE: 14px; FONT-FAMILY: arial;BORDER: #000080 3px solid;color:#000099;margin-top:5px;margin-left:5px;margin-bottom:5px\">
<tr style=\"color:#FFFFFF;background:#000099;\">
<td style=\"text-align:center;font-size:12px\">�����</td>
<td style=\"text-align:center;font-size:12px\">�������� ����</td>
<td style=\"text-align:center;font-size:12px\">���.<br/>����</td>
<td style=\"text-align:center;font-size:12px\">����������</td>
<td style=\"text-align:center;font-size:12px\">���� �� 1 ��� ��� 2-������� ����������</td>
<td>&nbsp</td>
</tr>");
$direction_id=1;
foreach ($stars->array_groups as $key2=>$star_list) {

        $group_count=count($star_list);


         for ($i=0;$i<$group_count;$i++)
         {
           $m=$i+1;
           $f_descriptor=substr(strstr($star_list[$m],'_'),0,3);

           $tour_descriptor=substr(strstr($star_list[$m],'_'),1,2);
           $tour_descriptor=strtr($tour_descriptor,'.',' ');
           include($stars->data_source.'/'.$star_list[$m]);

           if (isset($dscr_off) and $dscr_off==0) {
           $description_link="#$f_descriptor";
           unset($dscr_off);
           unset($ext_link);

           }
           elseif (isset($ext_link)) {
           $description_link="$ext_link";
           unset($ext_link);
           unset($dscr_off);
           }
           else {

            $key = array_search($tour_descriptor, $link_trans);
            if($key)
                $description_link="?tour=".$key;
            else  $description_link="?tour_id=$tour_descriptor";
            unset($dscr_off);
            unset($ext_link);

            }

                 if ($i==0) {
                 $direction_link='stars'.$direction_id;
                 print ("<tr  id='$direction_link' style=\"font-color:#000080;BACKGROUND:$bg_color\">
                 <td style=\"padding-left:5px;color:#000099;text-shadow: #FFFFFF.1em 0.1em 0.0em;font-size:1.3em;font-weight:bold\" width='25%' align='center' rowspan=$group_count>$star_tour_direction
                 </td>");
                 //$left_menu_arr[]=$star_tour_direction;
                 $direction_id++;
                 }

           $short_desc=substr(strstr($star_tour_header,"<br/>"),5);
           $price='<span style=\"font-size:11px\">'.$star_price_remark.'</span>'.'<span style=\"font-size:13px\">'.' $'.$star_tour_price.'</span>'.' '.'<span style=\"font:11px\">'.$star_price_remark1.'</span>';
           if($i<>0) print "<tr id ='$f_descriptor' style=\"font-color:#000080;BACKGROUND:$bg_color\">";
           print ("
           <td  style=\"padding-left:5px\" width='35%' align='center'><a  href=\"$description_link\" title=\"�������� ����\">$star_tour_name</a></td>
           <td style=\"text-align:center;color:#000080;font-size:12px\">$star_tour_days ���� $star_tour_days_remark</a></td>
           <td style=\"padding-left:5px\" width='45%' ><a class=\"sublnk\" href=\"$description_link\" style=\"font-size:11px;font-weight:bold\" title=\"�������� ����\">$short_desc</a></td>
           <td style=\"text-align:center;color:#000080\"><span style=\"font-size:11px\">$star_tour_price_remark</span> $$star_tour_price<span style=\"font-size:11px\"><br/> $star_tour_price_remark1</span></td>
           <td><a class=\"sublnk\" href=\"../new-tours/order_tour.php?ord_tour=$tour_rowid\" style='text-decoration:underline;font-size:12px;color:#990000'>��������</a></td>
           </tr>");

         }

}
print ("</table>");
#End of main table
#

print "<p style=\"margin-left:15px;margin-top:0px;margin-bottom:5px\"><br/><a href=\"#service_include\" style=\"text-decoration: underline; color:#000080; font-size:14px\">��� ������ � ���� ����� ����� ����� ��������� </a><br/>
        <a href=\"#service_exclude\" style=\"text-decoration: underline; color:#000080; font-size:14px\">��� �� ������ � ���� ����</a><br/>
        <a href=\"#service_terms\" style=\"text-decoration: underline; color:#000080; font-size:14px\">������� ���������� � ����������</a><br/>
        <a href=\"#service_terms\" style=\"text-decoration: underline; color:#000080; font-size:14px\">����-�����</a><br/></p>";

?>
</div>



<div id="ezine-abstracts">

<span class="q_letter_blue"></span>



<div  class="q_main" style="position:relative;float:left;margin-top:10px; height:auto;padding-bottom:10px; text-align:center">
<h3 id="service_include" class="q_head" style="color:#0000BB; FONT-SIZE: 150%; FONT-WEIGHT: BOLD;text-align:center"> � ��������� ����� "������ ���������" ��������</h3>
<?php

$star_tour_include1[0]='��������� ����������� ������, �� ����� ����������, ����������� ������;';
$star_tour_include1[1]='��� �������� (���������������) (��� ������������� ������������ ������� - �������� �����������);';
$star_tour_include1[2]='�������� � ��������������� ����������;';
$star_tour_include1[3]='��� ��������� �� ��������� � ������������� �����;';
$star_tour_include1[4]='����������� �� ��� ��������� - �� ��������� (��������� �� ��� ��������� ��������)';
$star_tour_include1[5]='������� ������ �������� �������� ����;';
$star_tour_include1[6]='������;';



$star_tour_exclude1[0]='������ ������ � ����������;';
$star_tour_exclude1[1]='������ ��������� � ����� (������������� �� $2 � �������� � ���� �������);';
$star_tour_exclude1[2]='���������, �� ����������� ����������;';
$star_tour_exclude1[3]='�������������� ���� � ������� ';



print $stars->stars_tour_include($star_tour_include1,$star_tour_exclude1);
//print $stars->print_terms($star_tour_term[0]);
//print $stars->print_terms($star_tour_term[2]);
print ("<br/><b>");
print $stars->print_terms($star_tour_term[3]);
print ("</b>");
?>
</div>
  
    <div class="q_main" style="position:relative;float:left;margin-top:10px; height:auto;padding-bottom:10px; text-align:center">
    <h3 class="q_head" style="color:blue; FONT-SIZE: 130%; FONT-WEIGHT: BOLD; text-align:center;color:#0000BB">��������! </h3>
        <ul class="st-hd_ul">
                <li class="st-hd2" style="width:570px; text-align:center; font-size:12pt;color:#000080"><b>���� ����� <span style=" color:#cc0000">������� ��������Ȼ</span>
                <br/>����� ����������� � ����, �� ��������� <br/>� ��������� �����.<br/>���������� ������  �� <a href="mailto:newtoursusa@yahoo.com">Email: newtoursusa@yahoo.com </a>
                <br/>��� �� ��������� <span style=" font-size:14px"><br/> 718 9347644, 718 9978687, 718 9346400</span>
                </li>
    </ul>
    </div>


 </div>
<br clear="both" />
<br clear="left" />
</div>
        


<div id="leftColumn" style="margin-top: 43px">


<div id="channeltree">
<?php

include "stars/stars_left_menu_main.html";
?>
</div>
<div style="align:left;margin-left: 2px">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="130" height="200" id="matreshka" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="/new-tours/flash/matreshka_130x200.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="/new-tours/flash/matreshka_130x200.swf" quality="high" bgcolor="#ffffff" width="131" height="200" name="��������" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>
<div style="align:left;margin-left: 0px;margin-top: 0px"><img src="../new-tours/images/tour_pict/icons/9.jpg" width="131" height="105" align="left" style="margin-left:2px;margin-top:2px" /></div>
<div style="align:left;margin-left: 0px;margin-top: 107px"><img src="../new-tours/images/tour_pict/icons/2.jpg" width="131" height="105" align="left" style="margin-left:2px;margin-top:2px" /></div>
<div style="align:left;margin-left: 0px;margin-top: 214px"><img src="../new-tours/images/tour_pict/icons/21.jpg" width="131" height="105" align="left" style="margin-left:2px;margin-top:2px" /></div>
<div style="align:left;margin-left: 0px;margin-top: 321px"><img src="../new-tours/images/tour_pict/icons/57.jpg" width="131" height="105" align="left" style="margin-left:2px;margin-top:2px" /></div>


</div>
<div id="site-footer">
<?php
include "stars/down_menu.php";
?>
</div>

<!-- end pgcontainer -->

<!-- Start Quantcast tag -->
</div>
</body>
</html>


