<?php
$url = filter_input(INPUT_POST, 'url', FILTER_DEFAULT);

if (empty($url)) {
    echo 0;
    return;
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . addslashes($url) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
$curl_results = curl_exec($curl);
curl_close($curl);
$json = json_decode($curl_results, true);
$count = 0;
if (is_array($json) && isset($json[0]['result']['metadata']['globalCounts']['count'])) {
    $count = intval($json[0]['result']['metadata']['globalCounts']['count']);
}
echo $count;