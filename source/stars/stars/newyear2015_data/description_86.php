<?php
$g=2 ;
$d=11;



$tour_rowid=259;

$star_tour_descr=array();

$star_tour_include= array();

$star_tour_exclude= array();

$star_tour_id=1;

$bg_color="#d9f8f9";

$star_tour_price = 2500;

$star_tour_price_remark="";

$star_tour_price_remark1="<br/>������� �������";

$star_tour_days=12;

$star_tour_days_remark="";

$star_tour_days_remark1="";

// ###########

//$dscr_off = 0;           // if is not correct desription bellow

//$ext_link="#stars2";

// ##################







$show_nextYear=1;





$add_file='group2_price.php';

$price_singl = '$65  � ����';

$price_up_category ='4* �� $75<br/> 5* �� $100';

$price_room_discount ='$165';

$price_without_flight ='$2100';
$newYearDate = array(
                    '11'=>array(24,28),

                    );

$dscTour[0] = array(
                'info'=>array('date'=>'12-24','header'=>'24 �������<br/>���-���� - ���������� �������� - ���-�������� - ���-����� - ���-���������'),
                'dcrsb'=>array(
                    array(
                        'day'=>'1 <br/>  24 ������� ','dsc'=>'       �������� � ���-����. �������� (�� �������)* � ���������� � ���������. ��������� �����.
                                        '),
                    array(
                        'day'=>'2 <br/>  25 ������� ','dsc'=>'       ���-����. �������� ���������� ���������, � ������� �������� �������� ��������������������� ������: ��������, �������-����, ����-�����, �������� 11 ��������, �������� ������, ���, ���������-�����, ����� �����, �������, ��������-�����, �����-����� � ��. ����������������� 6-7 �����.
                                        '),
                    array(
                        'day'=>'3 <br/>  26 ������� ','dsc'=>'       ��������� ���� � ���-�����.
                                        '),
                    array(
                        'day'=>'4 <br/>  27 ������� ','dsc'=>'       ����� �� ���������� ��������, 2-������� ���.
                                        '),
                    array(
                        'day'=>'5 <br/>  28 ������� ','dsc'=>'       ���������� ��������. ����������� � ���-����.
                                        '),
                    array(
                        'day'=>'6 <br/>  29 ������� ','dsc'=>'       ��������� ���� � ���-�����.
                                        '),
                    array(
                        'day'=>'7 <br/>  30 ������� ','dsc'=>'       ������ � ���-�������. ������ ���������� � �������. ��������. ���������� � ���������.
                                        '),
                    array(
                        'day'=>'8 <br/>  31 ������� ','dsc'=>'       ����� �� ��������� � ���-�����. ��������������������� ���-�����. ���������� ���������. ����������� ���� ������� � ���� ����.
                                        '),
                    array(
                        'day'=>'9 <br/>  1 ������ ','dsc'=>'         ���-�������. �������� ��������� �� ������. �����-������. ��������. ���������� "����� �����". ������� �����. ��������. ������� � �����-�������. ���������� � �������. ���� � ���������.
                                        '),
                    array(
                        'day'=>'10 <br/>  2 ������ ','dsc'=>'        ���-�������. ������� � ������� ������� �������. ������ �� ���������. ������ � ���-���������. ���������� � ���������.
                                        '),
                    array(
                        'day'=>'11<br/> 3 ������ ','dsc'=>'          ���-���������. ������ �������� ��������� �� ������: ���������� �����, �����, ���������, ������, �������� � ��������������������� ������.
                                        '),
                    array(
                        'day'=>'12<br/> 4 ������ ','dsc'=>'          ���-���������. ��������� �����. ��������� ����. �������� ����������� ����: ����� �� �������, � ������� ��� ������.
                                        '),

                    )
            );

$dscTour[1] = array(
                'info'=>array('date'=>'12-28','header'=>' 28 �������<br/>���-���� - ���������� �������� - ���-��������� - ���-�����'),
                'dcrsb'=>array(
                    array(
                        'day'=>'1 <br/> 28  ������� ','dsc'=>' �������� � ���-����. �������� (�� �������)* � ���������� � ���������. ��������� �����.
                                        '),
                    array(
                        'day'=>'2 <br/>  29 ������� ','dsc'=>' ���-����. �������� ���������� ���������, � ������� �������� �������� ��������������������� ������: ��������, �������-����, ����-�����, �������� 11 ��������, �������� ������, ���, ���������-�����, ����� �����, �������, ��������-�����, �����-����� � ��. ����������������� 6-7 �����.
                                        '),
                    array(
                        'day'=>'3 <br/>  30 ������� ','dsc'=>' ��������� ���� � ���-�����.
                                        '),
                    array(
                        'day'=>'4 <br/>  31 ������� ','dsc'=>' ����� �� ���������� ��������, 2-������� ���.
                                        '),
                    array(
                        'day'=>'5 <br/>  1 ������ ','dsc'=>' ���������� ��������. ����������� � ���-����.
                                        '),
                    array(
                        'day'=>'6 <br/>  2 ������ ','dsc'=>' ������ � ���-���������. ���������� � ���������. ��������� �����.
                                        '),
                    array(
                        'day'=>'7 <br/>  3 ������ ','dsc'=>' ���-���������. ������ �������� ��������� �� ������: ���������� �����, �����, ���������, ������, �������� � ��������������������� ������.
                                        '),
                    array(
                        'day'=>'8 <br/>  4 ������ ','dsc'=>' ���-���������. ����������� ���������� � �������. ����� �� ���-��������� � ������� ���-������. ������ � ���������.
                                        '),
                    array(
                        'day'=>'9 <br/>  5 ������ ','dsc'=>' ������ � ���-�����. ��������� �� ������. ���� �����, ��������� � ��������. ���������� "�����", ��������� �� ������������������� ������, ������ ������ ������, �����������. �������� ���-�����. ���������� �������� �������� ���. �� �������, ������������ ��������� ������������ (���-����������) ��� � ����� �� ������ (�������������� ������).
                                        '),
                    array(
                        'day'=>'10 <br/>  6 ������ ','dsc'=>' ����� �� ���-������. ������� � ���� ���. ������������ ����� � ����� ������ � �����-������. ����������� ������� �������. ������ � ������ ����� ������.
                                        '),
                    array(
                        'day'=>'11<br/> 7 ������ ','dsc'=>' ������ � ������������ ���� �����-������. ������ �����������, ������ �� ��������� "����� �����", ������������� ��� �������� �������� �������. ������ � ���-�����. �������� ���� ���-������. ������.
                                        '),
                    array(
                        'day'=>'12<br/> 8 ������ ','dsc'=>' ���-�����. ��������� �����. ��������� ����
                                        '),
                    )

            );






$star_tour_direction='���-���� - ���������� �������� - ���-����� - ���-���������';

$star_tour_header = '���-���� - ���������� �������� - ���-����� - ���-��������� <br/>���-���� - ���������� �������� - ���-����� - ��������* - ���-���������';

$star_tour_name= '���������� ���<br/>���-���� - ���������� �������� - ���-����� - ���-���������<br/>(������� 12-3)';

$starTourHeaderSplit = true;







$star_tour_description_n=count($star_tour_description_header);



$star_tour_include[]='���������� ������� ���-���� - ���-�������, ���-����� - ���-����; (�������� ����� ���� � ��������� � ���� ����� ��� ��� ��������, � ����� � ���������� ��������� �� ������ �������*);';

$star_tour_include[]='�������� �� ���������� ������� � ���-�����;';

$star_tour_include[]='��� ��������� �� ��������� � ������������� �����;';

$star_tour_include[]='����������� �� ��� ��������� - �� ��������� (��������� �� ��� ��������� ��������);';

$star_tour_include[]='���������� � ���������� �� �������� - 11 �����, �� ��� 4 ���� � ���-�����;';

$star_tour_include[]='��������� ����������� ������, �� ����� ����������, ����������� ������;';

$star_tour_include[]='��� �������� (���������������);';

$star_tour_include[]='�������� � ��������������� ����������;';

$star_tour_include[]='������� ������ �������� �������� ����;';

$star_tour_include[]='������.';



$star_tour_exclude[0]='������ ������ � ����������;';

$star_tour_exclude[1]='������ ��������� � ����� (������������� �� $2 � �������� � ���� �������);';

$star_tour_exclude[2]='���������, �� ����������� ����������;';

$star_tour_exclude[3]='�������������� ���� � ������� ';



$star_tour_term[0]="";

$star_tour_term[1]="<a href=\"#service_include\" style=\"text-decoration: underline; color:#000080\">��� ������ � ���� ����� ����� ����� ��������� </a><br/>

<a href=\"#price_addition\" style=\"text-decoration: underline; color:#000080; font-size:12px\">�������� �� ��� ������� - \"�� ������ �� ������\"</a><br/>

<a href=\"#service_exclude\" style=\"text-decoration: underline; color:#000080\">��� �� ������ � ���� ����</a><br/>

<a href=\"#terms\" style=\"text-decoration: underline; color:#000080\">������� ���������� � ����������</a><br/>

<a href=\"#terms\" style=\"text-decoration: underline; color:#000080\">����-�����</a><br/>

";

$star_tour_term[2]='<b>����������</b>:  ������ � 2-��������, ��������������� ����������� ��� 3-������� ������;

<br/>������� �� ����� - $65 � ����.

<br/><br/>�������� ��������� ��������� ��������� <span style="cursor:pointer;text-decoration:underline" onclick="javascript:window.location.href=\'#price_addition\'">��. �����</span>



<br/><b>��������!</b>

<br/>���������� ������������� ��������� �������������.

<br/>New Tours ����������� ���������� ������������� ��������� �� ���� ������������� � ����������, �������� ����� �� ���-�����. ��������������� ���������� �� �������� � ��������� � ������ ������� ���� � � ��������� - ����� ���������, � ��� ���������. ��� ���������� ��� ����� ���������� ����������.

<br/><br/>�� �������� ���� �������� ��������� � ����������� ���������� ���������.

<br/>�� ������� �������, ��� ����� ���� �������.';

$star_tour_term[3]='* � ������ � ��������� ���� ����!  �������� ���������� ��� ������ �� 6 ���., ����������� ������������';



$star_tour_term[5]="<span style='padding-left:10px;padding-right:10px;color:#990000;font-size:15px'><b>��������</b> !

<br/>

�������� ���������� ���� ��� ����������� �������� <br/>��� � ��������� � ���� �����.</span>";






/*
$star_tour_term_table_old[0]="

<p id='price_addition' style=\"font-size:16px;color:#fff;text-align:center;margin-top:3px;margin-bottom:0px;color:#000099;padding:0px 0px 0px 10px\">

<b>�������� �� ���</b><br/>

</p>

<p  style=\"font-size:14px;color:#fff;text-align:left;margin-top:3px;margin-bottom:0px;color:#000099;padding:0px 0px 0px 10px;font-weight:normal\">

 - ���� ���� $1990 � �������� ��� 2-������� ����������<br/>

 - ���� ���� ��� �������� $1690 � �������� ��� 2-������� ����������<br/>

 - ���� ���� � ��������� � ���� ����� $1610 � �������� ��� 2-������� ����������<br/>

 - ������� �� ����� ���������� $65 � ����<br/>

 - ������ � 3-�� � 4-�� �������� ��� 3-� ��� 4-������� ���������� $200 � �������� (� ����������� ������ ��������� 2 ����������� �������). ������� �� �������������� ������� - $25 � ����</p>

 <p style='text-align:center;font-size:15px;color:#000099;padding:5px;margin:1px'><span style='color:red'>�������� ! �������� ��������� ��������� ��������</span><br/>

 ��� ���������� � ���������� ������ ���� (4*) � ���-����� (3 ����) � ���-������ (4 ����) <br/>

 ������� $380 � ��������, ��� ���������� � 2-������� ������<br/>

 ������� $700 � ��������, ��� ���������� � 1-������� ������</p>";

*/

























