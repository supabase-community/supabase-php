<?php

namespace Supabase;

use Supabase\Functions\FunctionsClient;
use Supabase\Storage\StorageClient;

class CreateClient 
{
	private mixed $domain;
	private mixed $scheme;
	private mixed $api_key;
	private mixed $reference_id;
	private mixed $global_opts;

	private mixed $functions = null;
	private mixed $auth = null;
	private mixed $from = null;
	private mixed $rpc = null;
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
	 * Getter to present a user-friendly interface for the libraries.
	 *
	 *
	 * @param  string  $prop Name of the property requested 
	 *
	 * @throws Exception
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
			case 'from':
				return $this->__getFrom();
				break;	
			case 'rpc':
				return $this->__getRpc();
				break;	
			case 'realtime':
				return $this->__getRealtime();
				break;	
			case 'storage':
				return $this->__getStorage();
				break;	
			default:	
				return $this->{$name};
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
}
