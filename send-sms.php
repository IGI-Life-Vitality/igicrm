<?php
error_reporting(0);
require_once('lib/nusoap.php');

/*$msg    = argv[1];
$msisdn =argv[2];*/
 $msg    = $_GET['msg'];
 $msisdn = $_GET['msisdn'];

//$msg    = 'hello';
//$msisdn = '923422744880';

//$url = 'http://61.5.156.99:7230/WebService_4_0.asmx?wsdl';
$url = 'http://61.5.156.102/GenericService/WebService_4_0.asmx?wsdl';
$client = new nusoap_client($url, array('wsdl'));
$params = array(
    'UserId' => 'sms@igilife',
    'Password' => '99321587-ztpo2-95tr',
    'MobileNo' => $msisdn,
    'MsgId' =>'123',
    'SMS' => $msg ,
    'MsgHeader'=> '9460'
);

$result = $client->call('SendSMS',$params);
// echo "<pre>";
// print_r($result);
// echo "</pre>";
?>
