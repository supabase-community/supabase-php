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
}
