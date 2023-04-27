<?php

use Supabase\Util\EnvSetup;

include __DIR__.'/../vendor/autoload.php';

$keys = EnvSetup::env(__DIR__);
$api_key = $keys['API_KEY'];
$reference_id = $keys['REFERENCE_ID'];
