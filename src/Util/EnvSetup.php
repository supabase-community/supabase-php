<?php

namespace Supabase\Util;

use Dotenv\Dotenv;

class EnvSetup
{
	public static function env($path): array
	{
		// If the env vars are set and not empty use them
		$apiKey = getenv('API_KEY');
		$refId = getenv('REFERENCE_ID');

		// else check try to load the .env file in the $path
		if (empty($apiKey) || empty($refId)) {
			$loaded = Dotenv::createArrayBacked($path)->safeLoad();
			if (key_exists('API_KEY', $loaded)) {
				$apiKey = $loaded['API_KEY'];
			}

			if (key_exists('REFERENCE_ID', $loaded)) {
				$refId = $loaded['REFERENCE_ID'];
			}
		}

		if (empty($apiKey)) {
			throw new \Exception('Could not load API_KEY');
		}

		if (empty($refId)) {
			throw new \Exception('Could not load REFERENCE_ID');
		}

		return [
			'API_KEY' => $apiKey,
			'REFERENCE_ID' => $refId,
		];
	}
}
