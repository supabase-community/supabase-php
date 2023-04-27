<?php 

include __DIR__.'/header.php';

use Supabase\CreateClient;;

$bucket_id = 'test-bucket';
$testFile = 'file'.uniqid().'.png';
$sourceFile = 'https://gpdefvsxamnscceccczu.supabase.co/storage/v1/object/public/examples-bucket/supabase-logo.png';

$client = new CreateClient($api_key, $reference_id);
$result = $client->storage
		->from($bucket_id)
		->upload($testFile, $sourceFile, ['public' => false]);

$output = json_decode($result->getBody(), true);
print_r($output);
