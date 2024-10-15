# Credo

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

Credo is a packages that acts as a wrapper of [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html) to a [Codeigniter 3](https://codeigniter.com/userguide3/) project. This package was created based on the official [integration for Codeigniter 3](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/cookbook/integrating-with-codeigniter.html) to the `Doctrine` package.

## Installation

Install `Credo` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/credo
```

## Basic Usage

### Prerequisites

Create a sample database table to be used (e.g., `users`):

``` sql
-- Import this script to a SQLite database

CREATE TABLE user (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name TEXT NOT NULL,
    age INTEGER NOT NULL,
    gender TEXT NOT NULL
);

INSERT INTO user (name, age, gender) VALUES ('Rougin', 20, 'male');
INSERT INTO user (name, age, gender) VALUES ('Royce', 18, 'male');
INSERT INTO user (name, age, gender) VALUES ('Mei', 19, 'female');
```

Then configure the `composer_autoload` option in `config.php`:

``` php
// application/config/config.php

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell CodeIgniter to look for a Composer
| package auto-loader script in application/vendor/autoload.php.
|
|   $config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|   $config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the CodeIgniter-specific
|   autoloading (application/config/autoload.php)
*/
$config['composer_autoload'] = __DIR__ . '/../../vendor/autoload.php';
```

> [!NOTE]
> Its value should be the path of the `vendor` directory.

Next is to create any model that conforms to the `Doctrine` documentation:

``` php
// application/models/User.php

/**
 * @Entity
 * @Table(name="user")
 */
class User extends CI_Model
{
    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $_id;

    // ...
}
```

``` php
// application/controllers/Welcome.php

$this->load->model('user');

$this->load->database();

$credo = new Rougin\Credo\Credo($this->db);

$repository = $credo->get_repository('User');

$user = $repository->findBy(array());
```

### Using `Rougin\Credo\Repository`

To enable this package on a `Codeigniter 3` project, extend `Rougin\Credo\Loader` to `MY_Loader` first:

``` php
// application/core/MY_Loader.php

class MY_Loader extends \Rougin\Credo\Loader
{
}
```

Use the suffix `_repository` for creating repositories (e.g., `User_repository`):

``` php
// application/repositories/User_repository.php

use Rougin\Credo\Repository;

class User_repository extends Repository
{
    public function find_by_something()
    {
        // ...
    }
}
```

Then load the specified repository using `$this->load->repository`:

``` php
// application/controllers/Welcome.php

$this->load->model('user');

// Loads the customized repository ---
$this->load->repository('user');
// -----------------------------------

$this->load->database();

$credo = new Rougin\Credo\Credo($this->db);

// The said repository can now be initialized ---
$repository = $credo->get_repository('User');
// ----------------------------------------------

$users = $repository->find_by_something();
```

> [!NOTE]
> For more information about repositories in Doctrine, please check its [documentation](http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/working-with-objects.html#custom-repositories).

### Using `Rougin\Credo\Model`

Using the `Model` class enables the specified model to perform CRUD operations without relying on a repository:

``` php
// application/models/User.php

/**
 * @Entity
 * @Table(name="user")
 */
class User extends \Rougin\Credo\Model
{
    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $_id;

    // ...
}
```

``` php
// application/controllers/Welcome.php

$this->load->model('user', '', TRUE);

$credo = new Rougin\Credo\Credo($this->db);

$this->user->credo($credo);

$users = $this->user->get();
```

The specified class contains CRUD operations based on the functionalities from the `Query Builder` class of `Codeigniter 3` and the `EntityManager` of `Doctrine ORM`.

> [!NOTE]
> This may be used for getting started to use the models directly without a repository. However, this will be against the principle of `Unit of Work` pattern by `Doctrine ORM` (e.g., `flush` is executed directly after updating an entity). With this, using the repository pattern (e.g., `User_repository`) is highly encouraged.

## Using Traits

`Credo` provides traits that are based from the libraries of `Codeigniter 3` such as `Form Validation` and `Pagination Class`. They are used to easily attach the specified functionalities of `Codeigniter 3` to a model.

### `PaginateTrait`

The `PaginateTrait` is used to easily create pagination links within the model:

``` php
// application/models/User.php

use Rougin\Credo\Traits\PaginateTrait;

class User extends \Rougin\Credo\Model
{
    use PaginateTrait;

    // ...
}
```

``` php
// application/controllers/Welcome.php

// Create a pagination links with 10 as the limit and
// 100 as the total number of items from the result.
$result = $this->user->paginate(10, 100);

$data = array('links' => $result[1]);

$offset = $result[0];

// The offset can now be used for filter results
// from the specified table (e.g., "users").
$items = $this->user->get(10, $offset);
```

The `$result[0]` returns the computed offset while `$result[1]` returns the generated pagination links:

``` php
// application/views/users/index.php

<?php echo $links; ?>
```

To configure the pagination library, the `$pagee` property must be defined in the `Model`:

``` php
// application/models/User.php

use Rougin\Credo\Traits\PaginateTrait;

class User extends \Rougin\Credo\Model
{
    use PaginateTrait;

    // ...

    /**
     * Additional configuration to Pagination Class.
     *
     * @link https://codeigniter.com/userguide3/libraries/pagination.html#customizing-the-pagination
     *
     * @var array<string, mixed>
     */
    protected $pagee = array(
        'page_query_string' => true,
        'use_page_numbers' => true,
        'query_string_segment' => 'p',
        'reuse_query_string' => true,
    );
}
```

> [!NOTE]
> Please see the documentation of [Pagination Class](https://codeigniter.com/userguide3/libraries/pagination.html#customizing-the-pagination) to get the list of its available configuration.

### `ValidateTrait`

This trait is used to simplify the specifying of validation rules to a model:

``` php
// application/models/User.php

use Rougin\Credo\Traits\ValidateTrait;

class User extends \Rougin\Credo\Model
{
    use ValidateTrait;

    // ...
}
```

When used, the `$rules` property of the model must be defined with validation rules that conforms to the `Form Validation` specification:

``` php
// application/models/User.php

use Rougin\Credo\Traits\ValidateTrait;

class User extends \Rougin\Credo\Model
{
    use ValidateTrait;

    // ...

    /**
     * List of validation rules.
     *
     * @link https://codeigniter.com/userguide3/libraries/form_validation.html#setting-rules-using-an-array
     *
     * @var array<string, string>[]
     */
    protected $rules = array(
        array('field' => 'name', 'label' => 'Name', 'rules' => 'required'),
        array('field' => 'email', 'label' => 'Email', 'rules' => 'required'),
    );
}
```

> [!NOTE]
> Kindly check [its documentation](https://codeigniter.com/userguide3/libraries/form_validation.html#setting-rules-using-an-array) for the available rules that can be used to the `$rules` property.

To do a form validation, the `validate` method must be called from the model:

``` php
// application/controllers/Welcome.php

/** @var array<string, mixed> */
$input = $this->input->post(null, true);

$valid = $this->user->validate($input);
```

If executed with a view, the validation errors can be automatically be returned to the view using the `form_error` helper:

``` php
// application/views/users/create.php

<?= form_open('users/create') ?>
  <div>
    <!-- ... -->

    <?= form_error('name') ?>
  </div>

  <div>
    <!-- ... -->

    <?= form_error('email') ?>
  </div>

  <!-- ... -->
<?= form_close() ?>
```

## Migrating to the `v0.5.0` release

The new release for `v0.5.0` will be having a [backward compatibility](https://en.wikipedia.org/wiki/Backward_compatibility) break (BC break). With this, some functionalities from the earlier versions might not be working after upgrading. This was done to increase the maintainability of the project while also adhering to the functionalities for both `Codeigniter 3` and `Doctrine ORM`. Please see the [UPGRADING][link-upgrading] page for the said breaking changes.

> [!TIP]
> If still using the `v0.4` release, kindly click its documentation below:
> https://github.com/rougin/credo/blob/v0.4.0/README.md

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Credits

- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/credo/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/credo?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/credo.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/credo.svg?style=flat-square

[link-build]: https://github.com/rougin/credo/actions
[link-changelog]: https://github.com/rougin/credo/blob/master/CHANGELOG.md
[link-contributors]: https://github.com/rougin/credo/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/credo
[link-downloads]: https://packagist.org/packages/rougin/credo
[link-license]: https://github.com/rougin/credo/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/credo
[link-upgrading]: https://github.com/rougin/credo/blob/master/UPGRADING.md