# Supabase PHP Client `supabase-php`

PHP Client library to interact with Supabase.

> **Note:** This repository is in Alpha and is not ready for production usage. API's will change as it progresses to initial release.

### TODO

- [x] Integrate `storage-php`
- [x] Integrate `functions-php`
- [ ] Integrate `gotrue-php`
- [ ] Integrate `postgrest-php`
- [ ] Integrate `realtime-php`
- [ ] Support for PHP 7.4


## Quick Start Guide

### Installing the module

```bash
composer require supabase/supabase-php
```

### Getting started with the client 

```php

use Supabase\CreateClient;

$client = new CreateClient($reference_id, $api_key);
```
