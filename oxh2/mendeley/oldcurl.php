<?php
$API_KEY = 'MSwxNTExNjg2NzQxNTU4LDUwNDUwMzkxMSwxMDI4LGFsbCwsLDc3YWMxYjA3MmUwNjQxNGI2YzE5OTUxOGI0YjVmOGQ2ZTM2Nmd4cnFiLGM5NjVhNzExLTI2NGQtMzk3OS1hOGNkLTUzYzM0MDIwOWIzYSxTeVJELVNlN0VhT0RIeDdqX3gwSEpvMU9RRzg';

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
