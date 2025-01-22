<?php

require 'AWSSDK/aws.phar';

//Get the application environment parameters from the Parameter Store.

// $az = 'us-west-1c'; // 手動設定可用區
$region = 'us-west-1'; // 從可用區名稱中提取區域名稱

$ssm_client = new Aws\Ssm\SsmClient([
    'version' => 'latest',
    'region'  => $region
]);

$result = $ssm_client->GetParametersByPath(['Path' => '/cafe']);


$showServerInfo = "";
$timeZone = "";
$currency = "";
$db_url = "";
$db_name = "";
$db_user = "";
$db_password = "";

foreach($result['Parameters'] as $p) {
    if ($p['Name'] == '/cafe/showServerInfo') $showServerInfo = $p['Value'];
	if ($p['Name'] == '/cafe/timeZone') $timeZone = $p['Value'];
    if ($p['Name'] == '/cafe/currency') $currency = $p['Value'];
    if ($p['Name'] == '/cafe/dbUrl') $db_url = $p['Value'];
    if ($p['Name'] == '/cafe/dbName') $db_name = $p['Value'];
    if ($p['Name'] == '/cafe/dbUser') $db_user = $p['Value'];
    if ($p['Name'] == '/cafe/dbPassword') $db_password = $p['Value'];
}

?>
