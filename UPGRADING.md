The following are the breaking changes introduced in `v0.5`. As previously mentioned, this was done to improve its maintainability and to conform more on the methods from both the `Codeigniter 3` and `Doctrine ORM` projects:

## Change the `CodeigniterModel` class to `Model` class

**Before**

``` php
class User extends \Rougin\Credo\CodeigniterModel {}
```

**After**

``` php
class User extends \Rougin\Credo\Model {}
```

## Change the `EntityRepository` class to `Repository` class

**Before**

``` php
class User extends \Rougin\Credo\EntityRepository {}
```

**After**

``` php
class User extends \Rougin\Credo\Repository {}
```

## Set `Credo` instance manually to `Model`

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

## Change the arguments for `PaginateTrait::paginate`

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

## Remove `Model::countAll`

**Before**

``` php
$total = $this->user->countAll();
```

**After**

``` php
$total = $this->db->count_all_results('users');
```

This is being used only in `PaginateTrait::paginate`.

## Change the method `ValidateTrait::validationErrors` to `ValidateTrait::errors`

**Before**

``` php
ValidateTrait::validationErrors()
```

**After**

``` php
ValidateTrait::errors()
```

## Change the property `ValidateTrait::validation_rules` to `ValidateTrait::rules`

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

## Change the method `Model::all` to `Model::get`

**Before**

``` php
$users = $this->user->all();
```

**After**

``` php
$users = $this->user->get();
```