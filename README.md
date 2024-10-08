# Credo

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

Credo is a packages that acts as a wrapper of [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html) to a [Codeigniter 3](https://codeigniter.com/userguide3/) project. This package was created based on the official [integration for Codeigniter 3](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/cookbook/integrating-with-codeigniter.html) to the `Doctrine` package.

## Installation

Install `Credo` through [Composer](https://getcomposer.org):

``` bash
$ composer require rougin/credo
```

## Basic Usage

Create any model that conforms to the `Doctrine` documentation:

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

Then use the suffix `_repository` for creating repositories (e.g., `User_repository`):

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

And lastly is to load the specified repository using `$this->load->repository`:

``` php
// application/controllers/Welcome.php

$this->load->model('user');

// Loads the customized repository ---
$this->load->repository('user');
// -----------------------------------

$this->load->database();

$credo = new Rougin\Credo\Credo($this->db);

$repository = $credo->get_repository('User');

$users = $repository->find_by_something();
```

> [!NOTE]
> For more information about repositories in Doctrine, please check its [documentation](http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/working-with-objects.html#custom-repositories).

### Using `Rougin\Credo\Model`

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