<?php
$g=1 ;
$d=8 ;

//$dscr_off=0;

//$tour_rowid=143;
//$newYearDate = '26*, 27*, 28*, 29*, 30* �������<br/><span style="color:#ff0000;font-size:11px">����� ���, �������:<br/>���������</span>';

$tour_rowid=64;

$star_tour_id=1;

$bg_color="#ffffcc";

$star_tour_price=1890;

$star_tour_price_remark="";

$star_tour_price_remark1="";

$star_tour_days=8;

$star_tour_days_remark="";

$star_tour_price_remark1='<span class="novice">������� ������ ���� � ����������  �Spy Gala</span>';

$show_nextYear=1;

$star_tour_date[0] ="���������";

$star_tour_direction = '���������';

$star_tour_header='��������� - ��� <br/>���-����   - ���������� �������� (���) �  ���������<span style="color:#990000;font-size:11px"></span>';

$star_tour_name= '��������� - ���';

$additionalPriceInfo = '$1450'; // Explicit show with $ sign, due possible insert direct remark here 
$newYearDate = array(
                    '11'=>array(25,26,27,28,29),

                    );


$star_tour_description_header[0]="";

$dscTour[0] = array(
                'info'=>array('date'=>'','header'=>'26, 27, 28, 29, 30 ������� '),
                'dcrsb'=>array(
                    array(
                        'day'=>'1 ','dsc'=>'	�������� � ���-����. ���������� � ���������. (��������*). ��������� �����. ���� � ���-�����
                                        '),
                    array(
                        'day'=>'2 ','dsc'=>'  ���-����. �������� ���������� ���������, � ������� �������� �������� ��������������������� ������: ��������, �������-����, ����-�����, �������� 11 ��������, �������� ������, ���, ���������-�����, ����� �����, �������, ��������-�����, ����� ������������ � ��. ����������������� 6-7 �����.
                                        '),
                    array(
                        'day'=>'3 ','dsc'=>'  ������� � ����������� �������� - ������ �� ������� ��������� ����� ����� (��������� �� ���������). ������������ ������� ���� �������. ���������� �������, ����� ������, ��������� ��������, ����� �� ���� �������, ��� ��������* (�� �������, �� ������). ������ �������. ���� � �������-�����.
                                        '),
                    array(
                        'day'=>'4 ','dsc'=>'  ���������� ��������. �������� ������ � ������������� ���������� ���� � ���������, ������� ���� ������, ���������� ���� ���������� ������: ����, �����, ������, �������� � ��� ���������� �������. ����������� � ���-���� �� ���������� ������ ����� ���� ��� ����, ��������� � ������ �������, ����, �����; ���� � ���-�����
                                        '),
                    array(
                        'day'=>'5 ','dsc'=>' ���-����. ��������� ����
                                        '),
                    array(
                        'day'=>'6 ','dsc'=>' ����� �� ���-�����. ������ � ���������, �� ����� ������� �� �������� ������������� ���������� �� ��������������� ����������������� ����. �� ������� � ��������� - ��������� �� ������, � ����������� � ����� ���������� � ����� ��������. ���������� � ���������. �������, �����, ���������� � ��������� ���������. ����� �� �������� ����� 8:30 ������. 
														<br/>
														<span style="color:#990000">
														��������� ��� - ����� ���������� ��������� ����������. ����������� � ����� - �� ��������� ���������. 
														��������! ��� ����� � ������ � ��� �� 21 ���� ������  ����� ������������ ������ ������� ������� ������ ����, 
														��� �������, � ������� ������ ��������������� �������� - ������������� � ��� � �����-����,
														���������� ���� ����������� � ��������� � 7 ����� ������.
														</span>
                                        '),
                    array(
                        'day'=>'7 ','dsc'=>' ���������. ����� ��������� ������ � �������� ��������, ����������� ���������� � �����������. ����������� � ���-����.
                                        '),
                    array(
                        'day'=>'8 ','dsc'=>' ���-����. ��������� ���� (�������� ����� ��� ����������� ����
                                        '),


                    )
            );





$star_tour_description_n=count($star_tour_description_header);



$star_tour_include[]='��������� ����������� ������, �� ����� ����������, ����������� ������;';

$star_tour_include[]='��� �������� (���������������);';

$star_tour_include[]='�������� � ��������������� ����������;';

$star_tour_include[]='��� ��������� �� ��������� � ������������� �����;';

$star_tour_include[]='����������� �� ��� ��������� - �� ��������� (��������� �� ��� ��������� ��������)';

$star_tour_include[]='������� ������ �������� �������� ����;';

$star_tour_include[]='������;';



$star_tour_exclude[0]='������ ������ � ����������;';

$star_tour_exclude[1]='������ ��������� � ����� (������������� �� $2 � �������� � ���� �������)s;';

$star_tour_exclude[2]='���������, �� ����������� ����������;';

$star_tour_exclude[3]='�������������� ���� � ������� ';



$star_tour_term[0]="";

$star_tour_term[1]="<a href=\"#service_include\" style=\"text-decoration: underline; color:#000080\">��� ������ � ���� ����� ����� ����� ��������� </a><br/>

<a href=\"#service_exclude\" style=\"text-decoration: underline; color:#000080\">��� �� ������ � ���� ����</a><br/>

<a href=\"#terms\" style=\"text-decoration: underline; color:#000080\">������� ���������� � ����������</a><br/>

<a href=\"#terms\" style=\"text-decoration: underline; color:#000080\">����-�����</a><br/>

";

$star_tour_term[2]='<b>����������</b>:  ������ � 2-��������, ��������������� ����������� ��� 3-������� ������;

<br/>������� �� ����� - $65 � ����.

<br/>�������� ��������� ��������� ���������:

<br/>������� � �������� ���� ���� �� 4* ��������� $75 � �������� � ����, �� 5* - $120-180 � ���./ ����.

<br/><br/><b>��������!</b>

<br/>���������� ������������� ��������� �������������.

<br/><b>� ������ �����, � ����� �� �������,</b>  �������� ������ ���� � ���������� �������� �� ��� � ������.

<br/>New Tours ����������� ���������� ������������� ��������� �� ���� ������������� � ����������, �������� ����� �� ���-�����, ����� ���: ��������� � 2 ���, ������ � 2 ���, ������� ��� � 2 ���, �������� ��������� �� ���-�����, ������ 5-6 ���� � ��. ��������������� ���������� �� �������� � ��������� � ������ ������� ���� � � ��������� - ����� ���������, � ��� ���������. ��� ���������� ��� ����� ���������� ����������.

<br/><br/>�� �������� ���� �������� ��������� � ����������� ���������� ���������.

<br/>�� ������� �������, ��� ����� ���� �������.';

$star_tour_term[3]='*�������� ���������� ��� ������ �� 6 ���., ����������� ������������';



?>

