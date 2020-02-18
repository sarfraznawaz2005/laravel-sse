[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

# Laravel SSE

Laravel package to provide Server Sent Events functionality for your app. You can use this package to show instant notifications to your users without them having to refresh their pages.

## Requirements

 - PHP >= 7
 - Laravel 5

## Installation

Via Composer

``` bash
$ composer require sarfraznawaz2005/laravel-sse
```

For Laravel < 5.5:

Add Service Provider to `config/app.php` in `providers` section
```php
Sarfraznawaz2005\SSE\ServiceProvider::class,
```

Add Facade to `config/app.php` in `aliases` section
```php
'SSE' => Sarfraznawaz2005\SSE\Facades\SSEFacade::class,
```


---

Publish package's config, migration and view files by running below command:

```bash
$ php artisan vendor:publish --provider="Sarfraznawaz2005\SSE\ServiceProvider"
```
Run `php artisan migrate` to create `sselogs` table.

## Setup SSE

Setup config options in `config/sse.php` file and then add this in your view/layout file:

```php
@include('sse::view')
```

## Usage

Syntax:
```php
/**
 * @param string $message : notification message
 * @param string $type : alert, success, error, warning, info
 * @param string $event : Type of event such as "EmailSent", "UserLoggedIn", etc
 */
SSEFacade::notify($message, $type = 'info', $event = 'message')
```

To show popup notifications on the screen, in your controllers/event classes, you can  do:

```php
use Sarfraznawaz2005\SSE\Facades\SSEFacade;

public function myMethod()
{
    SSEFacade::notify('hello world....');
    
    // or via helper
    sse_notify('hi there');
}
```

## Customizing Notification Library

By default, package uses [noty](https://github.com/needim/noty) for showing notifications. You can customize this by modifying code in `resources/views/vendor/sse/view.blade.php` file.

## Customizing SSE Events

By default, pacakge uses `message` event type for streaming response:


```php
SSEFacade::notify($message, $type = 'info', $event = 'message')
```

Notice `$event = 'message'`. You can customize this, let's say you want to use `UserLoggedIn` as SSE event type:

```php
use Sarfraznawaz2005\SSE\Facades\SSEFacade;

public function myMethod()
{
    SSEFacade::notify('hello world....', 'info', 'UserLoggedIn');
    
    // or via helper
    sse_notify('hi there', 'info', 'UserLoggedIn');
}
```

Then you need to handle this in your view yourself like this:

```javascript
<script>
var es = new EventSource("{{route('__sse_stream__')}}");

es.addEventListener("UserLoggedIn", function (e) {
    var data = JSON.parse(e.data);
    alert(data.message);
}, false);

</script>
```

## Credits

- [Sarfraz Ahmed][link-author]
- [All Contributors][link-contributors]

## License

Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sarfraznawaz2005/laravel-sse.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sarfraznawaz2005/laravel-sse.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sarfraznawaz2005/laravel-sse
[link-downloads]: https://packagist.org/packages/sarfraznawaz2005/laravel-sse
[link-author]: https://github.com/sarfraznawaz2005
[link-contributors]: https://github.com/sarfraznawaz2005/laravel-sse/graphs/contributors
