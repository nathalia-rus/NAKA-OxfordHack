<?php
$disease = $_GET['d'];

$url = "https://wsearch.nlm.nih.gov/ws/query?db=healthTopics&term=".$disease;
$xml = simplexml_load_file($url);

echo "<pre>";
echo print_r((array)($xml));
echo "</pre>";


//echo "<pre>";
//echo print_r($xml);
//echo "</pre>";
?>
