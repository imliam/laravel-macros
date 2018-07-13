# Macros

Here there are a number of custom methods defined that extend other classes through the use of macros.

## Collection Macros

### `sortByDate`

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

### `sortByDateDesc`

This method has the same signature as the `sortByDate` method, but will sort the collection in the opposite order.
