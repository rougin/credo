# Credo

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Integrates [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html) for the [Codeigniter](https://codeigniter.com) framework.

## Install

Install Credo via [Composer](https://getcomposer.org):

``` bash
$ composer require rougin/credo
```

## Usage

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

$user = $repository->find(4);
```

### Using `Rougin\Credo\EntityRepository`

Extend `Rougin\Credo\Loader` to `MY_Loader`:

``` php
// application/core/MY_Loader.php

class MY_Loader extends \Rougin\Credo\Loader {}
```

Kindly also use the suffix `_repository` for creating repositories. (e.g. `User_repository`)

``` php
// application/repositories/User_repository.php

use Rougin\Credo\EntityRepository;

class User_repository extends EntityRepository {

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

$this->load->repository('user');

$this->load->database();

$credo = new Rougin\Credo\Credo($this->db);

$repository = $credo->get_repository('User');

$users = $repository->find_by_something();
```

For more information about repositories in Doctrine, please check its [documentation](http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/working-with-objects.html#custom-repositories).

### Using `Rougin\Credo\CodeigniterModel`

``` php
// application/models/User.php

/**
 * @Entity
 * @Table(name="user")
 */
class User extends \Rougin\Credo\CodeigniterModel {

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

$users = $this->user->all();
```

## Change Log

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email rougingutib@gmail.com instead of using the issue tracker.

## Credits

- [Rougin Royce Gutib][link-author]
- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-version]: https://img.shields.io/packagist/v/rougin/credo.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/credo/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/credo.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/credo.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/credo.svg?style=flat-square

[link-author]: https://rougin.github.io
[link-changelog]: https://github.com/rougin/credo/blob/master/CHANGELOG.md
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/credo
[link-contributors]: https://github.com/rougin/credo/contributors
[link-downloads]: https://packagist.org/packages/rougin/credo
[link-license]: https://github.com/rougin/credo/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/credo
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/credo/code-structure
[link-travis]: https://travis-ci.org/rougin/credo