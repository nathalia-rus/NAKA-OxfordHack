<?php
$API_KEY = 'MSwxNTExNjU3NTIyMDA0LDUwNDUwMzkxMSwxMDI4LGFsbCwsLGU3YjRhZTQxMzYxYmU2NGJhNjhhMjhiNmYzZjRhNTcxOTRlNWd4cnFiLGM5NjVhNzExLTI2NGQtMzk3OS1hOGNkLTUzYzM0MDIwOWIzYSw2aWctNHdKTG5mOGp3aURBaS0yZGgxNklKM2c';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.mendeley.com/search/catalog?limit=10&type=journal&title=tumor");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'Authorization: Bearer '.$API_KEY,
    'Accept: application/vnd.mendeley-document.1+json'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);
curl_close ($ch);

echo "<pre>";
echo print_r(json_decode($server_output));
echo "</pre>";

?>
