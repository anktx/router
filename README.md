
# Anktx Router

Anktx Router is a simple PHP router for dispatching HTTP requests to the appropriate route handlers based on the request method and URL. It supports multiple HTTP methods and path parameters, providing a clean and intuitive way to handle routing in PHP applications.

## Installation

To use Anktx Router in your project, simply user the following command:

```shell
composer require anktx/router
```

## Usage Example

Here's a basic example of how to use the `Router` and `Route` classes to handle HTTP requests:

### 1. Create Routes

You can define routes using the static methods provided in the `Route` class.

```php
use Anktx\Router\Route;

$route1 = Route::get('/home', fn() => 'Welcome to the homepage!');
$route2 = Route::post('/submit', fn() => 'Form submitted!');
$route3 = Route::get('/profile/<id:\d+>', fn ($id) => "Profile ID: $id");
$route4 = Route::get('/user/<name:\w+>', fn ($name) => "User name: $name");
```

### 2. Create a Locator

Next, create a `ManualLocator` that contains all the routes you defined.

```php
use Anktx\Router\Locator\ManualLocator;

$locator = new ManualLocator($route1, $route2, $route3, $route4);
```

### 3. Dispatch the Request

Once you have your routes set up and the locator created, you can instantiate the `Router` and dispatch requests based on method and URL.

```php
use Anktx\Router\Router;
use Anktx\Router\Result\RouteFound;
use Anktx\Router\Result\RouteNotFound;
use Anktx\Router\Result\MethodNotAllowed;

$router = new Router($locator);

// Example 1: Dispatching a GET request
$response = $router->dispatch('GET', '/home');
handleResponse($response);

// Example 2: Dispatching a POST request
$response = $router->dispatch('POST', '/submit');
handleResponse($response);

// Example 3: Dispatching a GET request with a path parameter
$response = $router->dispatch('GET', '/user/123');
handleResponse($response);

function handleResponse(RouteFound|RouteNotFound|MethodNotAllowed $response): void
{
    if ($response instanceof RouteFound) {
        echo "Route found, handler: " . $response->handler() . "\n";
    } elseif ($response instanceof RouteNotFound) {
        echo "Route not found.\n";
    } elseif ($response instanceof MethodNotAllowed) {
        echo "Method not allowed. Allowed methods: " . implode(', ', $response->allowedMethods()) . "\n";
    }
}
```

### 4. Handling the Response

The `dispatch` method will return an instance of one of the following:

- `RouteFound`: If the route is found and the method is allowed, the handler will be called.
- `RouteNotFound`: If no matching route is found.
- `MethodNotAllowed`: If a route is found, but the method is not allowed (e.g., trying to `POST` to a `GET` route).

Each response type provides useful information, such as the allowed methods in case of a `MethodNotAllowed` response.

### 5. Using Path Parameters

In the example above, the route `/user/<id:\d+>` uses a path parameter. You can access the matched parameters in the handler.

```php
// This will match the URL `/user/123`
// The handler will receive $id = 123
$route3 = Route::get('/user/<id:\d+>', fn ($id) => "User ID: $id");
```

### 6. Additional Methods

You can define additional HTTP methods such as `PUT`, `DELETE`, `PATCH`, etc., using similar syntax.

```php
Route::put('/update', fn() => 'Update successful');
Route::delete('/delete', fn() => 'Delete successful');
Route::patch('/modify', fn() => 'Modification successful');
```

### Error Handling

If no route matches, or if the method is not allowed, appropriate responses will be returned as shown above. You can also customize these responses based on your application’s needs.

## License

This package is open-source software, licensed under the MIT License.
