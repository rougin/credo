# Credo

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Integrates [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html) for the [Codeigniter](https://codeigniter.com) framework.

## Installation

Install `Credo` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/credo
```

## Basic Usage

``` php
// application/models/User.php

/**
 * @Entity
 * @Table(name="user")
 */
class User extends CI_Model {

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

Extend `Rougin\Credo\Loader` to `MY_Loader`:

``` php
// application/core/MY_Loader.php

class MY_Loader extends \Rougin\Credo\Loader {}
```

Kindly also use the suffix `_repository` for creating repositories. (e.g. `User_repository`)

``` php
// application/repositories/User_repository.php

use Rougin\Credo\Repository;

class User_repository extends Repository {

    public function find_by_something()
    {
        // ...
    }

}
```

Then load the repository using `$this->load->repository($repositoryName)`.

``` php
// application/controllers/Welcome.php

$this->load->model('user');

// Loads the customized repository
$this->load->repository('user');

$this->load->database();

$credo = new Rougin\Credo\Credo($this->db);

$repository = $credo->get_repository('User');

$users = $repository->find_by_something();
```

For more information about repositories in Doctrine, please check its [documentation](http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/working-with-objects.html#custom-repositories).

### Using `Rougin\Credo\Model`

``` php
// application/models/User.php

/**
 * @Entity
 * @Table(name="user")
 */
class User extends \Rougin\Credo\Model {

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

$this->user->credo(new Rougin\Credo\Credo($this->db));

$users = $this->user->get();
```

## Migrating to the `v0.5.0` release

The new release for `v0.5.0` will be having a [backward compatibility](https://en.wikipedia.org/wiki/Backward_compatibility) break (BC break). So some functionalities on the earlier versions might not be working after updating. This was done to increase the maintainability of the project while also adhering to the functionalities for both Codeigniter and Doctrine ORM. To check the documentation for the last release (`v0.4.0`), kindly click [here](https://github.com/rougin/credo/blob/v0.4.0/README.md).

### Change the `CodeigniterModel` class to `Model` class

**Before**

``` php
class User extends \Rougin\Credo\CodeigniterModel {}
```

**After**

``` php
class User extends \Rougin\Credo\Model {}
```

### Change the `EntityRepository` class to `Repository` class

**Before**

``` php
class User extends \Rougin\Credo\EntityRepository {}
```

**After**

``` php
class User extends \Rougin\Credo\Repository {}
```

### Set `Credo` instance manually to `Model`

**Before**

``` php
$this->load->model('user');
```

**After**

``` php
$this->load->model('user');

$credo = new Rougin\Credo\Credo($this->db);

$this->user->credo($credo);
```

All Credo functionalities are now moved to `CredoTrait` which is can be added on existing models.

### Change the arguments for `PaginateTrait::paginate`

**Before**

``` php
// PaginateTrait::paginate($perPage, $config = array())
list($result, $links) = $this->user->paginate(5, $config);
```

**After**

``` php
$total = $this->db->count_all_results('users');

// PaginateTrait::paginate($perPage, $total, $config = array())
list($offset, $links) = $this->user->paginate(5, $total, $config);
```

The total count must be passed in the second parameter.

### Remove `Model::countAll`

**Before**

``` php
$total = $this->user->countAll();
```

**After**

``` php
$total = $this->db->count_all_results('users');
```

This is being used only in `PaginateTrait::paginate`.

### Change the method `ValidateTrait::validationErrors` to `ValidateTrait::errors`

**Before**

``` php
ValidateTrait::validationErrors()
```

**After**

``` php
ValidateTrait::errors()
```

### Change the property `ValidateTrait::validation_rules` to `ValidateTrait::rules`

**Before**

``` php
// application/models/User.php

protected $validation_rules = array();
```

**After**

``` php
// application/models/User.php

protected $rules = array();
```

### Change the method `Model::all` to `Model::get`

**Before**

``` php
$users = $this->user->all();
```

**After**

``` php
$users = $this->user->get();
```

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

[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/credo.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/credo.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/credo.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/credo/master.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/credo.svg?style=flat-square

[link-changelog]: https://github.com/rougin/credo/blob/master/CHANGELOG.md
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/credo
[link-contributors]: https://github.com/rougin/credo/contributors
[link-downloads]: https://packagist.org/packages/rougin/credo
[link-license]: https://github.com/rougin/credo/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/credo
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/credo/code-structure
[link-travis]: https://travis-ci.org/rougin/credo