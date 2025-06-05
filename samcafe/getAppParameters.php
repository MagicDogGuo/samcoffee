<?php

// --- Environment Detection ---
// Detect if running on a local server (like localhost or 127.0.0.1)
$is_local = false;
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    // Check if host starts with localhost or 127.0.0.1
    if (strpos($host, 'localhost') === 0 || strpos($host, '127.0.0.1') === 0) {
        $is_local = true;
    }
}

if ($is_local) {
    // --- LOCAL DATABASE CONFIGURATION ---
    // Running on a local machine, use hardcoded parameters.
    // Please fill in your local database details below.

    $showServerInfo = "true";
    $timeZone = "UTC"; // Or your local timezone, e.g., "Asia/Taipei"
    $currency = "USD"; // Or TWD, etc.
    $db_url = "127.0.0.1"; // Or "localhost"
    $db_name = "your_database_name"; // The name of the database you import from db.zip
    $db_user = "your_username"; // Your database username, often "root" for local setups
    $db_password = "your_password"; // Your database password

} else {
    // --- AWS CONFIGURATION ---
    // Not on localhost, so assume running on AWS and fetch parameters from SSM.
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
}

?>
