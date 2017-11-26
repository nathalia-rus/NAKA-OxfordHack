<?php
$number = $_GET['number']+10;
$words = $_GET['words'];
$miny = $_GET['miny'];
$maxy = $_GET['maxy'];

$API_KEY = 'MSwxNTExNzAyOTAyNzU1LDUwNDUwMzkxMSwxMDI4LGFsbCwsLDQxN2NlOWE2NzFhYmEzNDk4MTlhN2QxLWVhZjQwMTZkNzM2OWd4cnFiLGM5NjVhNzExLTI2NGQtMzk3OS1hOGNkLTUzYzM0MDIwOWIzYSxFdGVYR3BNVDE4RXJ4RGxMdHZ2dkxSeXRwRG8';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.mendeley.com/search/catalog?limit=".$number."&type=journal&title=".str_replace(',','+',$words)."+treatment&min_year=".$miny."&max_year=".$maxy."&keywords=medicine");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'Authorization: Bearer '.$API_KEY,
    'Accept: application/vnd.mendeley-document.1+json'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);
curl_close ($ch);

//echo "<pre>";
//echo print_r(json_decode($server_output));
//echo "</pre>";

/*
    Mendeley API returns JSON encoded string
    decoding and treating as an array
*/
$output = json_decode($server_output);
 
/* 
    Stop executing if no result obtained
*/
if (count($output) == 0)
    return;

/*
    Building a JSON encoded array with the relevant data 
    to be passed to the application
*/
$j = 0;
for($i=0; $i<count($output); $i++)
{   if (isset($output[$i]->title) && isset($output[$i]->abstract) && isset($output[$i]->link)) {
    $data[$j]['title'] = isset($output[$i]->title) ? $output[$i]->title : "";
    $data[$j]['abstract'] = isset($output[$i]->abstract) ? $output[$i]->abstract : "";
    $data[$j]['link'] = isset($output[$i]->link) ? $output[$i]->link : "";
$j++;
}
}

echo json_encode($data);
?>
