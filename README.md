# Myth:db

Myth:db is an exploration of a possible new database layer for CodeIgniter 4. It adds a reflective Data Mapper to make getting data as simple as possible. While it uses Models and Entities in the background, it can be used with almost zero setup or code generation.

## Examples

### Getting all results in a table

The basic usage is with the `map()` method, which takes the name of the table you want to work with. It then creates a generic model, assigns the table name, inspects the table to populate the model's properties, and returns the model. Since you have a model, you then have access to the model methods, such as `findAll()`, and the Query Builder methods, such as `where()`.

```php
$users = db()->map('users')->findAll();
```

By default, this would return an array of objects, one for each of the rows in the table. If you would like to change the return type, you can pass in the name of the class, `array`, or `object` with the `returns()` method.

```php
$users = db()->map('users')->returns('array')->findAll();
$users = db()->map('users')->returns(\App\Entities\User::class)->findAll();
```

### Custom Entities

You can create your own Entities and the mapper will automatically return results in that format. This is all based on conventions. By default, it would look for an entity named `User` in the `App\Entities` namespace. The name of the Entity is the singular, PascalCase version of the table name.

```php
// If App\Entities\User exists, all results will be returned as User objects
// otherwise, each record will be returned as an object.
$users = db()->map('users')->findAll();

// Would return each result as instance of App\Entities\ZodiacSign, if it exists.
$signs = db()->map('zodiac_signs')->findAll();
```

### Custom Models

You can also create your own Models and the mapper will automatically use that instead of the default Model. This is also based on conventions. It would look for a model named the PascalCase singular version of the table name, with `Model` appended to it.

```php
// Will look for App\Models\UserModel
$users = db()->map('users')->findAll();

// Will look for App\Models\ZodiacSignModel
$signs = db()->map('zodiac_signs')->findAll();
```

NOTE: Returns an iterable cursor for better memory?

TODO: Return findX results as a collection?
