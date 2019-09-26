<?php

function stars_tour_days($star_tour_days,$star_tour_descr,$i)
{
$description_numbers=count ($star_tour_descr[$i]);
for ($k=0;$k< $description_numbers;$k++)
        {
        $a= $star_tour_descr;

        //print ($star_tour_descr[$i][$k]);
        if ($description_numbers>$star_tour_days)
        {
        $m=$k;   //first day will be -DAY 0-
        }
        else
        {
        $m=$k+1;
        }
        print ("<li class=\"st-hd2\" style=\"width:560px\"><p  style=\"FONT: 14px arial;text-align:justify\">
        <span class=\"q_letter\" style=\"font-family: arial\">Д</span><span class=\"q_letter_blue\" style=\"color:#000080\">ень&nbsp;$m.</span><span style=\"text-align:justify\">&nbsp;");
        print($star_tour_descr[$i][$k]);
        print(" </span></p></li>");
        }
}
function stars_tour_header($star_tour_header,$star_tour_price,$star_tour_days,$star_tour_price_remark, $star_tour_price_remark1)
{

 print ("<h3 class=\"q_head_top\" style=\"color:#fff;height:auto;text-align:center;padding-top:2px;FONT-SIZE: 18px; background:#000080;width:610\">
$star_tour_header<br/>$star_tour_days дней<br/>Цена тура: $star_tour_price_remark $$star_tour_price $star_tour_price_remark1 </h3>");
}
function stars_tour_include($star_tour_include,$star_tour_exclude,$star_tour_incl_excl=null)
{

$incl=count($star_tour_include);
$excl=count($star_tour_exclude);
print ("<ul class=\"st-hd_ul\">");
for ($i=0;$i<$incl;$i++)
     {
     print ("<li class=\"st-hd2\" style=\"width:560px; font: 13px arial\">- $star_tour_include[$i]</li>");
     }
print ("</ul>");
if (isset($star_tour_incl_excl))
print ("<p  id=\"service_excl_incl\" style=\"text-align:center;font: 16px arial;color:#cc0000;margin-top:2px\">$star_tour_incl_excl</p>");
print ("<p  id=\"service_exclude\" style=\"text-align:center;font: 16px arial;color:#cc0000\"><b>НЕ ВКЛЮЧЕНЫ: </b></p>");
for ($m=0;$m<$excl;$m++)
     {
      print ("<ul class=\"st-hd_ul\"><li class=\"st-hd2\" style=\"width:560px; font: 13px arial\">- $star_tour_exclude[$m]</li></ul>");
     }
}
function print_terms($terms)
{

print ("<p id=\"service_terms\" align=\"left\" style=\"color:#000;text-align:justify;padding-top:2px;FONT-SIZE:13px;padding-left:20px;padding-right:10px\">$terms</p>");

}
function stars_tour_date($star_tour_date, $year=2009)
{

        print ("<br/><table border=\"1\" cellspacing=\"1\" width=\"600\" id=\"$star_tour_days\" align=\"center\">
        <tr>
        <td colspan='12' style=\"color:#990000;font-size:16px;text-align:center\">$year</td>
        </tr>
        <tr>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Янв.</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Фев.</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Март</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Апр.</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Май</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Июнь</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Июль</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Авг.</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Сент.</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Окт.</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Нояб.</font></b></td>
        <td width=\"50\" align=\"center\" bgcolor=\"#FFFF00\" height=\"14\"><b><font size=\"2\">Дек.</font></b></td>
          </tr><tr>");
        if ($star_tour_date[0]=="")
        {
        for ($i=1;$i<13;$i++)
            {
            print ("<td width=\"50\" align=\"center\" height=\"14\" ><font size=\"2\"  ><b>&nbsp;$star_tour_date[$i]</b></font></td>");

            }
        }
        else
        {
         print ("<td width=\"600\" align=\"center\" height=\"14\" colspan=\"12\"><font size=\"3\" ><b>$star_tour_date[0]</b></font></td>");
        }
        


        print ("</tr></table>");

}
?>
