# Credo

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Integrates [Doctrine](http://www.doctrine-project.org/projects/orm.html) to [CodeIgniter](https://codeigniter.com) with ease.

## Install

Via Composer

``` bash
$ composer require rougin/credo
```

## Usage

**application/models/User.php**

``` php
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

**application/controllers/Welcome.php**

``` php
$this->load->model('user');
$this->load->database();

$credo      = new Rougin\Credo\Credo($this->db);
$repository = $credo->get_repository('User');
$user       = $repository->find(4);
```

### Using `EntityRepository`

Extend `Rougin\Credo\Loader` to `MY_Loader`.

**application/core/MY_Loader.php**

``` php
class MY_Loader extends Rougin\Credo\Loader {}
```

Kindly also use the suffix `_repository` for creating repositories. (e.g. `User_repository`)

**application/repositories/User_repository.php**

``` php
class User_repository extends Rougin\Credo\EntityRepository {
    // Other stuff...

	public function find_by_something()
	{
		// ...
	}
}
```

You can now load a repository by using `$this->load->repository($repositoryName)`.

**application/controllers/Welcome.php**

``` php
$this->load->model('user');
$this->load->repository('user');
$this->load->database();

$credo      = new Rougin\Credo\Credo($this->db);
$repository = $credo->get_repository('User');
$users      = $repository->find_by_something();
```

For more information about repositories in Doctrine, you can find them [here](http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/working-with-objects.html#custom-repositories).

## Change Log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email rougingutib@gmail.com instead of using the issue tracker.

## Credits

- [Rougin Royce Gutib][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rougin/credo.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/credo/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/credo.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/credo.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/credo.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rougin/credo
[link-travis]: https://travis-ci.org/rougin/credo
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/credo/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/credo
[link-downloads]: https://packagist.org/packages/rougin/credo
[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors
