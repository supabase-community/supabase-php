<?php

namespace Supabase;

use Supabase\Functions\FunctionsClient;
use Supabase\Storage\StorageClient;
use Supabase\Postgrest\PostgrestClient;
use Supabase\GoTrue\GoTrueClient;

class CreateClient 
{
	private mixed $domain;
	private mixed $scheme;
	private mixed $api_key;
	private mixed $reference_id;
	private mixed $global_opts;

	private mixed $functions = null;
	private mixed $auth = null;
	private mixed $query = null;
	private mixed $realtime = null;
	private mixed $storage = null;

	/**
	 * StorageClient constructor.
	 *
	 * @param  string  $api_key  The anon or service role key
	 * @param  string  $reference_id  Reference ID
	 * @param  array   $global_opts Options overides 
	 * @param  string  $domain  The domain pointing to api
	 * @param  string  $scheme  The api sheme
	 *
	 * @throws Exception
	 */
	public function __construct($api_key, $reference_id, $global_opts = [], $domain = 'supabase.co', $scheme = 'https')
	{
		$this->domain = $domain;
		$this->scheme = $scheme;
		$this->api_key = $api_key;
		$this->reference_id = $reference_id;
		$this->global_opts = $global_opts;
	}

	/**
	 * Caller to present a user-friendly interface for the libraries.
	 *
	 *
	 * @param  string  $method Name of the method requested
	 * @param  array $args Arguments passed to the method call 
	 *
	 * @throws \BadMethodCallException If the method does not exist
	 */
	public function __call($method, $args) : mixed
	{
		switch ($method) {
			case 'rpc':
				$this->__getQuery();
				return $this->query->rpc(...$args);
				break;	
			case 'from':
				$this->__getQuery();
				return $this->query->from(...$args);
				break;	
			default:
				throw new \BadMethodCallException(
					sprintf('Call to undefined method %s::%s()', static::class, $method)
				);
		}
	}

	/**
	 * Getter to present a user-friendly interface for the libraries.
	 *
	 *
	 * @param  string  $prop Name of the property requested 
	 *
	 * @throws \LogicException If the requested library is not supported yet
	 */
	public function __get($prop) : mixed
	{
		switch ($prop) {
			case 'functions':
				return $this->__getFunctions();
				break;	
			case 'auth':
				return $this->__getAuth();
				break;	
			case 'query':
				return $this->__getQuery();
				break;	
			case 'realtime':
				throw new \LogicException('Realtime is not supported yet.');
			case 'storage':
				return $this->__getStorage();
				break;	
			default:
				trigger_error(
					sprintf('Undefined property: %s::$%s', static::class, $prop),
					E_USER_WARNING
				);

				return null;
		}
	}

	public function __getFunctions()
	{
		if(empty($this->functions)){
			$this->functions = new FunctionsClient(
				$this->reference_id,
				$this->api_key,
				$this->domain,
				$this->scheme,
			);
		}
		return $this->functions;
	}

	public function __getStorage()
	{
		if(empty($this->storage)){
			$this->storage = new StorageClient(
				$this->api_key,
				$this->reference_id,
				$this->domain,
				$this->scheme,
// @TODO $path?? $global_opts
			);
		}
		return $this->storage;
	}

	public function __getQuery()
	{
		if(empty($this->query)){
			$this->query = new PostgrestClient(
				$this->reference_id,
				$this->api_key,
				[], // @TODO pass in opts
				$this->domain,
				$this->scheme,
// @TODO $path?? $global_opts
			);
		}
		return $this->query;
	}

	public function __getAuth()
	{
		if(empty($this->auth)){
			$this->auth = new GoTrueClient(
				$this->reference_id,
				$this->api_key,
				[], // @TODO pass in opts
				$this->domain,
				$this->scheme,
// @TODO $path?? $global_opts
			);
		}
		return $this->auth;
	}
}
