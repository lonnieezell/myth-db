# Basic Usage

## Model-Free Queries

The core of Myth:DB is the ability to run queries without the need for a model, but without losing the features you would expect to have from a Model. Whenever you need to query a table you can use the `db()->map()` method:

```php
$users = db()->map('users')->findAll();
```

This uses the new `db()` helper method to return an instance of the `Myth\DB\DB` class, which adds several convenience methods to the base database connection class. This should be used in place of `db_connect()` when you want to take advantage of what Myth:db has to offer.

The `map()` method takes the name of the table you want to query and returns a Mapper class that is a generic model that represents the table. The Mapper class extends `CodeIgniter\Model` so all of the normal methods and features that you expect can be used.

The Mapper will inspect the table to determine the column names and data types, return type, and other information that it needs to be able to work with the table. This is dependent on the data that `db->getFieldData()` can return.

### Specifying the Return Type

By default, the Mapper will return all results as an array of objects. If you want to return an array of arrays, you can use the `returns()` method:

```php
$userArray = db()->map('users')
    ->returns('array')
    ->findAll();
```

### Returning Entity Classes

The Mapper class will look for an Entity class that matches the singular, PascalCase version of the table name and return all results as an array of those entities if it is found. For example, for a table named `uses`, it will look for an Entity named `User`. A table named `user_profiles` would look for an Entity named `UserProfile`.

> [!NOTE]
> The Entity class must be within an `Entities` folder in a namespace the autoloader can find.

## Using Your Own Model

If you prefer to use your own Model class, you can still use the `db()->map()` method to get an instance of your model if it follows some basic conventions. The model must be named the same as the table, but in singular, PascalCase format, with `Model` appended to the end. For example, a table named `users` would use a model named `UserModel`. A table named `user_profiles` would use a model named `UserProfileModel`.

The model must also be in a namespace that the autoloader can find. By default, this would be the `App\Models` namespace.

> [!NOTE]
> When using your own model, none of the other features of the Mapper class will be available.
