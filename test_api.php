<?php
$key = 'AIzaSyBaXKXOXX3xIx6v1izn7kkp_rl8BeXnh0U';
$ch = curl_init('https://generativelanguage.googleapis.com/v1beta/models?key=' . $key);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($ch);
curl_close($ch);
$decoded = json_decode($res, true);
$models = [];
foreach ($decoded['models'] ?? [] as $m) {
    if (in_array('generateContent', $m['supportedGenerationMethods'] ?? [])) {
        $models[] = $m['name'];
    }
}
// Write as simple text
file_put_contents(__DIR__ . '/models_list.txt', implode("\n", $models));
echo count($models) . " models found. See models_list.txt\n";
// Also echo first 20
foreach (array_slice($models, 0, 20) as $m) {
    echo $m . "\n";
}
