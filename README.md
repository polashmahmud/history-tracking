# History Tracking System - Laravel Package

History Tracking System is a Laravel package that provides history tracking functionality for your Eloquent models.
Easily add and manage history for your models with this simple and flexible package.

## Features

- **History Tracking**: Associate history with your Eloquent models.
- **History Tracking Trait**: Easily make your models history trackable using the HistoryTracking trait.

## Installation

To install History Tracking System, simply run:

```bash
composer require polashmahmud/history
```

Then, migrate your database:

```bash
php artisan migrate
```

## Usage

### History Tracking Models

To make a model history trackable, use the `Polashmahmud\History\Historyable` trait on the model:

```php
use Polashmahmud\History\Historyable;

class Post extends Model
{
    use Historyable;
}
```

that's it! Now your model is history trackable. When a model is updated, a history record will be created for it. The
history record will contain the model's previous and new values. The history record will also contain the user who made
the change. If the user is not logged in, the history record will contain the user's IP address.

### Retrieving History

To retrieve the history of a model, use the `history` method:

```php
$post = Post::find(1);

$history = $post->history;
```

The `history` method will return a collection of history records. Each history record will contain the model's previous
and new values, the user who made the change, and the date and time the change was made.

Query with `changedBy` method to get the history records that were made by a specific user:

```php
$history = $post->history()->with('changedBy')->get();
```

### History Tracking Ignore Columns

By default, `updated_at`, `password`, `remember_token` and `email_verified_at` columns are ignored from history
tracking. If you want to ignore more columns, you can use `ignoreHistoryColumns` function in your model.

```php
use Polashmahmud\History\Historyable;

class Post extends Model
{
    use Historyable;
    
    public function ignoreHistoryColumns()
    {
        return [
            // 'column_name',
        ];
    }
}
```

### History Tracking Scopes

History Tracking System provides some useful scopes to help you retrieve history records.

`Coming soon...`

## Contributing

Thank you for considering contributing to History Tracking ! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

History Tracking is open-sourced software licensed under the [MIT license](LICENSE.md).





