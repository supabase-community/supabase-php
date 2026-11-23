<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Supabase\CreateClient;

class CreateClientTest extends TestCase
{
	/**
	 * Test new CreateClient().
	 *
	 * @return void
	 */
	public function testNewStorageClient()
	{
		$client = new  CreateClient('somekey', 'some_ref_id');
		$this->assertEquals(get_class($client), 'Supabase\CreateClient');
	}

	/**
	 * Test functions exists.
	 *
	 * @return void
	 */
	public function testFunctionsExists()
	{
		$client = new  CreateClient('somekey', 'some_ref_id');
		$this->assertEquals(get_class($client->functions), 'Supabase\Functions\FunctionsClient');
	}


	/**
	 * Test storage exists.
	 *
	 * @return void
	 */
	public function testStorageExists()
	{
		$client = new  CreateClient('somekey', 'some_ref_id');
		$this->assertEquals(get_class($client->storage), 'Supabase\Storage\StorageClient');
	}

	/**
	 * Test postgrest exists.
	 *
	 * @return void
	 */
	public function testPostgrestExists()
	{
		$client = new  CreateClient('somekey', 'some_ref_id');
		$this->assertEquals(get_class($client->query), 'Supabase\Postgrest\PostgrestClient');
	}

	/**
	 * Test go-true/auth exists.
	 *
	 * @return void
	 */
	public function testGoTrueExists()
	{
		$client = new  CreateClient('somekey', 'some_ref_id');
		$this->assertEquals(get_class($client->auth), 'Supabase\GoTrue\GoTrueClient');
	}

	/**
	 * Test realtime throws instead of recursing forever.
	 *
	 * @return void
	 */
	public function testRealtimeThrowsNotSupported()
	{
		$client = new CreateClient('somekey', 'some_ref_id');
		$this->expectException(\LogicException::class);
		$this->expectExceptionMessage('Realtime is not supported yet.');
		$client->realtime;
	}

	/**
	 * Test an unknown method throws instead of recursing forever.
	 *
	 * @return void
	 */
	public function testUnknownMethodThrows()
	{
		$client = new CreateClient('somekey', 'some_ref_id');
		$this->expectException(\BadMethodCallException::class);
		$this->expectExceptionMessage('Call to undefined method Supabase\CreateClient::doesNotExist()');
		$client->doesNotExist();
	}

	/**
	 * Test an unknown property warns and returns null without exposing private state.
	 *
	 * @return void
	 */
	public function testUnknownPropertyWarnsAndReturnsNull()
	{
		$client = new CreateClient('somekey', 'some_ref_id');
		$warnings = [];
		set_error_handler(function ($errno, $errstr) use (&$warnings) {
			$warnings[] = $errstr;

			return true;
		}, E_WARNING | E_USER_WARNING);

		try {
			$unknown = $client->doesNotExist;
			$apiKey = $client->api_key;
		} finally {
			restore_error_handler();
		}

		$this->assertNull($unknown);
		$this->assertNull($apiKey);
		$this->assertSame([
			'Undefined property: Supabase\CreateClient::$doesNotExist',
			'Undefined property: Supabase\CreateClient::$api_key',
		], $warnings);
	}
}
