# change Config
- [x] app/Config/CURLRequest.php
- [ ] app/Config/Database.php
- [ ] app/Config/Events.php
- [ ] app/Config/Filters.php
- [ ] app/Config/Routing.php
- [ ] app/Config/Toolbar.php
- [ ] ================
- [ ] public/index.php
- [ ] app/Config/App.php
- [ ] app/Config/Routes.php
- [ ] app/Config/Cookie.php
- [ ] app/Config/Exceptions.php
- [ ] spark

## command
```bash
composer update
cp vendor/codeigniter4/framework/public/index.php public/index.php
cp vendor/codeigniter4/framework/spark spark
```
## Route (Route.php)
```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
```
## cookie (app.php)
```php
//..
public string $cookiePrefix = '';
// !update ke 4.4.0 hapus yang di atas
// public string $cookieSameSite = '';
//..
```

## security (app.php)
```php
// ..
public string $CSRFTokenName = 'csrf_test_name';
// !update ke 4.4.0 hapus yang di atas
//..
```

## session (app.php)
```php
//..
public string $sessionDriver = FileHandler::class;
// !update ke 4.4.0 hapus yang di atas
//..
```

## exceptions (exceptions.php)
``` php
 //...
 /*
     * DEFINE THE HANDLERS USED
     * --------------------------------------------------------------------------
     * Given the HTTP status code, returns exception handler that
     * should be used to deal with this error. By default, it will run CodeIgniter's
     * default handler and display the error information in the expected format
     * for CLI, HTTP, or AJAX requests, as determined by is_cli() and the expected
     * response format.
     *
     * Custom handlers can be returned if you want to handle one or more specific
     * error codes yourself like:
     *
     *      if (in_array($statusCode, [400, 404, 500])) {
     *          return new \App\Libraries\MyExceptionHandler();
     *      }
     *      if ($exception instanceOf PageNotFoundException) {
     *          return new \App\Libraries\MyExceptionHandler();
     *      }
     */
    public function handler(int $statusCode, Throwable $exception): ExceptionHandlerInterface
    {
        return new ExceptionHandler($this);
    }
```

### validasi data (Xcontroller.php)
```php
//...
// In Controller.

if (! $this->validate([
    'username' => 'required',
    'password' => 'required|min_length[10]',
])) {
    // The validation failed.
    return view('login', [
        'errors' => $this->validator->getErrors(),
    ]);
}

// The validation was successful.

// Get the validated data.
$validData = $this->validator->getValidated();
// !new fungsion
//...
```