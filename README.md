# Laravel Macros

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imliam/laravel-macros.svg)](https://packagist.org/packages/imliam/laravel-macros)
[![Total Downloads](https://img.shields.io/packagist/dt/imliam/laravel-macros.svg)](https://packagist.org/packages/imliam/laravel-macros)
[![License](https://img.shields.io/github/license/imliam/laravel-macros.svg)](LICENSE.md)

A collection of miscellaneous methods to extend some of Laravel's core classes through the use of [macros and mixins](https://tighten.co/blog/the-magic-of-laravel-macros).

<!-- TOC -->

- [Laravel Macros](#laravel-macros)
    - [Installation](#installation)
    - [Usage](#usage)
        - [Illuminate\Support\Collection](#illuminate\support\collection)
            - [`Collection@sortByDate($key = null)`](#collectionsortbydatekey--null)
            - [`Collection@sortByDateDesc($key = null)`](#collectionsortbydatedesckey--null)
            - [`Collection@keysToValues()`](#collectionkeystovalues)
            - [`Collection@valuesToKeys()`](#collectionvaluestokeys)
        - [Illuminate\Database\Query\Builder](#illuminate\database\query\builder)
            - [`Builder@if($condition, $column, $operator, $value)`](#builderifcondition-column-operator-value)
        - [Illuminate\Http\Request](#illuminate\http\request)
            - [`Request@replace($key, $value)`](#requestreplacekey-value)
        - [Illuminate\Support\Facades\Route](#illuminate\support\facades\route)
            - [`Route@viewDir($path, $viewDirectory = '', $data = [])`](#routeviewdirpath-viewdirectory---data--)
    - [Testing](#testing)
    - [Changelog](#changelog)
    - [Contributing](#contributing)
        - [Security](#security)
    - [Credits](#credits)
    - [License](#license)

<!-- /TOC -->

## Installation

You can install the package with [Composer](https://getcomposer.org/) using the following command:

```bash
composer require imliam/laravel-macros:^0.1.0
```

## Usage

Once installed, all macros will automatically be registered and methods will immediately be available for use.

### Illuminate\Support\Collection

#### `Collection@sortByDate($key = null)`

Sort the values in a collection by a datetime value.

To sort a simple list of dates, call the method without passing any arguments to it.

```php
collect(['2018-01-04', '1995-07-15', '2000-01-01'])->sortByDate();
// return collect(['1995-07-15', '2000-01-01', '2018-01-04'])
```

To sort a collection where the date is in a specific key, pass the key name when calling the method.

```php
collect([
    ['date' => '2018-01-04', 'name' => 'Banana'],
    ['date' => '1995-07-15', 'name' => 'Apple'],
    ['date' => '2000-01-01', 'name' => 'Orange']
])->sortByDate('date')
  ->all();

// [
//    ['date' => '1995-07-15', 'name' => 'Apple'],
//    ['date' => '2000-01-01', 'name' => 'Orange'],
//    ['date' => '2018-01-04', 'name' => 'Banana']
// ]
```

Additionally, you can pass a callback to the method to choose more precisely what is sorted.

```php
$users = User::all();

$users->sortByDate(function(User $user) {
    return $user->created_at;
})->toArray();

// [
//    ['id' => 12, 'username' => 'spatie', 'created_at' => '1995-07-15'],
//    ['id' => 15, 'username' => 'taylor', 'created_at' => '2000-01-01'],
//    ['id' => 2, 'username' => 'jeffrey', 'created_at' => '2018-01-04']
// ]
```

#### `Collection@sortByDateDesc($key = null)`

This method has the same signature as the `sortByDate` method, but will sort the collection in the opposite order.

#### `Collection@keysToValues()`

Change the collection so that all values are equal to the corresponding key.

```php
collect(['a' => 'b', 'c' => 'd'])->keysToValues();
// ['a' => 'a', 'c' => 'c']
```

#### `Collection@valuesToKeys()`

Change the collection so that all keys are equal to their corresponding value.

```php
collect(['a' => 'b', 'c' => 'd'])->valuesToKeys();
// ['b' => 'b', 'd' => 'd']
```

### Illuminate\Database\Query\Builder

#### `Builder@if($condition, $column, $operator, $value)`

Conditionally add where clause to the query builder. [See Mohamed Said's blog post for more information.](https://themsaid.com/laravel-query-conditions-20160425)

Keep chaining methods onto a query being built without having to break it up. Take code like this:

```php
$results = DB::table('orders')
    ->where('branch_id', Auth::user()->branch_id);

if($request->customer_id){
    $results->where('customer_id', $request->customer_id);
}

$results = $results->get();
```

And clean it up into this:

```php
$results = DB::table('orders')
    ->where('branch_id', Auth::user()->branch_id)
    ->if($request->customer_id, 'customer_id', '=', $request->customer_id)
    ->get();
```

### Illuminate\Http\Request

#### `Request@replace($key, $value)`

Manipulate the request object by replacing a value, or even adding a new one.

```php
class Middleware
{
    public function handle($request, \Closure $next)
    {
        $request->replace('key', 'value');

        return $next($request);
    }
}
```

### Illuminate\Support\Facades\Route

#### `Route@viewDir($path, $viewDirectory = '', $data = [])`

Mimics the functionality offered by Route::view() method but extends it by rerouting requested the URI at any number of sub-levels to match a view directory in the code base.

This makes it possible to create views with static content and not need to worry about updating routes to match them or using a CMS-style solution to manage them.

For an example, to see how it works, imagine the following route definition:

```php
Route::viewDir('/pages', 'pages');
```

And the following directory structure for the views:

```
views/
├── auth/
├── errors/
├── layouts/
├── pages/
│   ├── about-us.blade.php
│   ├── faq.blade.php
│   ├── privacy-policy.blade.php
│   ├── team/
│   │   ├── developers.blade.php
│   │   ├── index.blade.php
│   │   ├── management.blade.php
│   │   └── marketing.blade.php
│   └── terms-of-service.blade.php
└── partials/
```

The following routes will be generated to match each of the views in the given directory:

```
/pages/about-us
/pages/faq
/pages/privacy-policy
/pages/team
/pages/team/developers
/pages/team/management
/pages/team/marketing
/pages/terms-of-service
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email liam@liamhammett.com instead of using the issue tracker.

## Credits

- [Liam Hammett](https://github.com/imliam)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
