<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Supabase\Util\EnvSetup;

final class SupabaseClientIntTest extends TestCase
{
	private $client;
	private $storage;

	public function uploadFile($public = true, $file_path = null): array
	{
		$path = 'testFile-'.uniqid().'.png';
		$file_path = $file_path ? $file_path : __DIR__.'/../fixtures/test-file.png';
		$result = $this->storage->upload($path, $file_path, ['public' => $public]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
		$this->assertJsonStringEqualsJsonString('{"Key":"test-bucket/'.$path.'"}', (string) $result->getBody());

		return [
			$result,
			$path,
		];
	}

	private function deleteFile($file): void
	{
		$result = $this->storage->remove([$file]);
		$this->assertEquals('200', $result->getStatusCode());
		$this->assertEquals('OK', $result->getReasonPhrase());
	}

	/**
	 * The setUp runs for each fuction.
	 */
	public function setup(): void
	{
		parent::setUp();
		$keys = EnvSetup::env(__DIR__.'/../');
		$api_key = $keys['API_KEY'];
		$reference_id = $keys['REFERENCE_ID'];

		$this->client = new \Supabase\CreateClient($api_key, $reference_id);
		$this->storage = $this->client->storage->from('test-bucket');
	}

	/**
	 * Test uploads a file to an existing bucket.
	 */
	public function testStorage(): void
	{
		// Upload from URL
		$file_path = 'https://images.squarespace-cdn.com/content/v1/6351e8dab3ca291bb37a18fb/c097a247-cbdf-4e92-a5bf-6b52573df920/1666314646844.png?format=1500w';
		[ $result, $path ] = $this->uploadFile(true, $file_path);
		$this->deleteFile($path);

		// Upload from local fixture
		[ $result, $path ] = $this->uploadFile();
		$this->deleteFile($path);
	}

	/**
	 * Test edge functions.
	 */
	public function testEdgeFunctions(): void
	{

		$response = $this->client->functions->invoke('hello-world', ['name'=>'Supabase']);
		$this->assertEquals('Hello Players!', $response->{'message'});
	}
}
