<?php 

include __DIR__.'/header.php';

use Supabase\CreateClient;;


$client = new CreateClient($api_key, $reference_id);
$response = $client->functions->invoke('hello-world', ['name'=>'Supabase']);
print_r($response);
