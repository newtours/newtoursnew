<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
/**
 * Pay attention that
 * 'base_request_url' => 'qilsdevv.admin.root.queenslibrary.org:9081/rest/'
 * last slash is important !!!
 */

return array(
    'chamolib' => [
        //'config_data_path' =>  dirname(__DIR__) . '/data/chamo-data.php',
        'config_data_path' =>  dirname(__DIR__) . '/config/chamo-source.config.php',
        'localhost'=>[
            'main_server'=>'dp8',
            'cipher'=>[
                'email_salt_key'=>9721549,
                'cipher'=>'AES-128-CBC',
            ],
            //'array_mapper_path' => 'data/chamolib.php',
            //'array_mapper_path' =>  dirname(__DIR__) . '/data/chamo-data.php',
            //'config_data_path' =>  dirname(__DIR__) . '/data/chamo-data.php',
            /* New Configuration at July 30, 2018 */
            'base_request_url' =>'172.16.105.14:8081/rest/', // New One Dev by ip
            //'base_request_url' =>'chamodev.queenslibrary.org:8081/rest/',
            //'base_request_url' =>'chamoqa.queenslibrary.org:8081/rest/', // NEW QA July 30,2018
            'base_request_url' => '172.16.103.14:8081/rest/', // NEW QA by IP
            //'base_request_url' => 'qilsdevv.admin.root.queenslibrary.org:9081/rest/', //172.16.100.104 Old DEV
            //'base_request_url' => 'qilsrddevv.admin.root.queenslibrary.org:8081/rest/', //172.16.100.104 qilsrddevv
            //'base_request_url' => 'qilsqacv.admin.root.queenslibrary.org:8081/rest/', //QA
            //'base_request_url' => 'qils:8081/rest/',// PRODUCTION !!!!!
             //'base_request_url' =>'qils.admin.root.queenslibrary.org:8081/rest/', // PRODUCTION wth full name
             //'base_request_url' => '172.16.100.106:8081/rest/', // production updated
            'patron_request_url' => 'patrons/',
            'items_request_url' => 'items/',
            'requests_request_url' => 'requests/',
            'bibs_request_url' => 'bibs/',
            'parameters_request_url' => 'parameters/',
            'lists_request_url' => 'patrons/',
            'locations_request_url' => 'parameters/locations/',
            'patron_type_request_url' => 'parameters/patronTypes/',
            'base_credential_login' => 'chamouser',
            'base_credential_passw' => 'userchamo',
            'syndetics_request_url' => '',
            'ebsco_request_url' => '',
            'ldap' => ['ldap_host' => "172.16.100.51:389", 'domain' => 'admin.root.queenslibrary.org'],
            'smtp' => ['name'=> 'localhost','host' => '207.159.192.48','port' => 25],
            'oracle_host'=>'qilsdevv',
            'oracle_host'=>'qilsqacv', // QA
            //'oracle_host'=>'qils', // Production qils
            'oracle_server_name'=>'vtls01',
            'oracle_port'=>'1521',
            'oracle_user'=>'dbadmin',//'dbadmin',
            'oracle_pass'=> 'dbadmin' ,
            'revalidate_days'=>1825, // Five Years
        ],
        'dev' => [
            'main_server'=>'dev.qbpl.org',
            'cipher'=>[
                'email_salt_key'=>9721549,
                'cipher'=>'AES-128-CBC',
            ],
            //'base_request_url' => 'qilsrddevv.admin.root.queenslibrary.org:8081/rest/', //172.16.100.104 qilsrddevv
            //'base_request_url' => 'qilsqacv.admin.root.queenslibrary.org:8081/rest/', new ip http://172.16.103.14:8081/rest
            /* */
            //'base_request_url' =>'172.16.105.14:8081/rest/', // New One Dev
            'base_request_url' =>'chamodev.queenslibrary.org:8081/rest/',
            //'base_request_url' => 'qilsdevv.admin.root.queenslibrary.org:9081/rest/', //172.16.100.104
            'patron_request_url' => 'patrons/',
            'items_request_url' => 'items/',
            'requests_request_url' => 'requests/',
            'bibs_request_url' => 'bibs/',
            'parameters_request_url' => 'parameters/',
            'lists_request_url' => 'patrons/',
            'locations_request_url' => 'parameters/locations/',
            'patron_type_request_url' => 'parameters/patronTypes/',
            'base_credential_login' => 'chamouser',
            'base_credential_passw' => 'userchamo',
            'syndetics_request_url' => '',
            'ebsco_request_url' => '',
            'ldap' => ['ldap_host' => "172.16.100.51:389", 'domain' => 'admin.root.queenslibrary.org'],
            'smtp' => ['name'=> 'localhost','host' => '207.159.192.48','port' => 26],
            'oracle_host'=>'qilsdevv',
            'oracle_server_name'=>'vtls01',
            'oracle_port'=>'1521',
            'oracle_user'=>'dbadmin',
            'oracle_pass'=> 'dbadmin' ,
            'revalidate_days'=>1825, // Five Years

            ],
        'qa' => [
            'main_server'=>'qa.qbpl.org',
            'cipher'=>[
                'email_salt_key'=>9721549,
                'cipher'=>'AES-128-CBC',
            ],
            //'base_request_url' => 'qilsqacv.admin.root.queenslibrary.org:8081/rest/', // new ip http://172.16.103.14:8081/rest
            //'base_request_url' => '172.16.103.14:8081/rest/',
            'base_request_url' =>'chamoqa.queenslibrary.org:8081/rest/', // NEW QA
            'patron_request_url' => 'patrons/',
            'items_request_url' => 'items/',
            'requests_request_url' => 'requests/',
            'bibs_request_url' => 'bibs/',
            'parameters_request_url' => 'parameters/',
            'locations_request_url' => 'parameters/locations/',
            'patron_type_request_url' => 'parameters/patronTypes/',
            'base_credential_login' => 'chamouser',
            'base_credential_passw' => 'userchamo',
            'syndetics_request_url' => '',
            'ebsco_request_url' => '',
            'ldap' => ['ldap_host' => "172.16.100.51:389", 'domain' => 'admin.root.queenslibrary.org'],
            'smtp' => ['name'=> 'localhost','host' => '207.159.192.48','port' => 26],
            'oracle_host'=>'qilsqacv',
            'oracle_server_name'=>'vtls01',
            'oracle_port'=>'1521',
            'oracle_user'=>'dbadmin',
            'oracle_pass'=> 'dbadmin' ,
            'revalidate_days'=>1825, // Five Years
        ],
        'prod'=>[
            'main_server'=>'qbpl.org',
            'cipher'=>[
                'email_salt_key'=>9721549,
                'cipher'=>'AES-128-CBC',
            ],
            //'base_request_url' => 'qils:8081/rest',
            'base_request_url' => '172.16.100.106:8081/rest/', // production updated
            //'base_request_url' =>'qils.admin.root.queenslibrary.org:8081/rest/', // PRODUCTION wth full name
            'base_credential_login' => 'chamouser',   // need clarify
            'base_credential_passw' => 'userchamo',  // Need clarify
            'oracle_host'=> '10.10.157.17' , //'qils',
            'oracle_server_name'=>'vtls01',
            'oracle_port'=>'1521',
            'oracle_user'=>'dbadmin', //'chamo',
            'oracle_pass'=> 'dbadmin' , //'uxchamokk01',
            'revalidate_days'=>1825,
            'ldap' => ['ldap_host' => "172.16.100.51:389", 'domain' => 'admin.root.queenslibrary.org'],
            'smtp' => ['name'=> 'localhost','host' => '207.159.192.48','port' => 25], // Need change now this is QA
            'patron_request_url' => 'patrons/',
            'items_request_url' => 'items/',
            'requests_request_url' => 'requests/',
            'bibs_request_url' => 'bibs/',
            'parameters_request_url' => 'parameters/',
            'locations_request_url' => 'parameters/locations/',
            'patron_type_request_url' => 'parameters/patronTypes/',

            'syndetics_request_url' => '',
            'ebsco_request_url' => '',
        ]
    ],

    'service_manager' => array(
        'aliases' => array(
            //'ChamoLib\Mapper' => 'ChamoLib\ArrayMapper',
            //'ChamoLib\MapperMessages' => 'ChamoLib\ArrayMapperMessages',
            'ChamoLib\Connector' => 'ChamoLib\ConnectorAdapter',
            //'ChamoLib\Patron\Patron' => 'ChamoLib\Patron\Patron',
        ),
        'factories' => array(
            //'ChamoLib\ArrayMapper'                => 'ChamoLib\ArrayMapperFactory',
            'ChamoLib\Patron\Lists\Lists'           => 'ChamoLib\ChamoFactory',
            'ChamoLib\Parameters\Parameters'        => 'ChamoLib\ChamoFactory',
            'ChamoLib\Syndetics\Syndetics'          => 'ChamoLib\ChamoFactory',
            'ChamoLib\Ebsco\Ebsco'                  => 'ChamoLib\ChamoFactory',
            'ChamoLib\Patron\Patron'                => 'ChamoLib\ChamoFactory',
            'ChamoLib\Patron\Messages\Messages'     => 'ChamoLib\ChamoFactory',
            'ChamoLib\Patron\Fines\Fines'           => 'ChamoLib\ChamoFactory',
            'ChamoLib\Patron\Checkouts\Checkouts'   => 'ChamoLib\ChamoFactory',
            'ChamoLib\Requests\Requests'            => 'ChamoLib\ChamoFactory',
            'ChamoLib\Items\Items'                  => 'ChamoLib\ChamoFactory',
            'ChamoLib\Bibs\Bibs'                    => 'ChamoLib\ChamoFactory',
            'ChamoLib\ConnectorAdapter'             => 'ChamoLib\ConnectorAdapterFactory',
            'ChamoLib\TableGatewayMapper'           => 'ChamoLib\TableGatewayMapperFactory',
            'ChamoLib\TableGateway'                 => 'ChamoLib\TableGatewayFactory',
        ),
    ),
);
