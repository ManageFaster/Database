# Database encrypt v1.1.0

## Installation
```
Run command: composer require managefaster/database

Add provider: Managefaster\Database\DatabaseServiceProvider::class at root_folder/config/app.php
```

## Environment variables example

```
ENCRYPT_KEY=random_string
ENCRYPT_ATTRIBUTE="HEX(N'%s', '%s')"
DECRYPT_KEY="CONVERT(HEX(%s), '%s') USING UTF8)"
DECRYPT_ATTRIBUTE="HEX('%s', '%s')"
```

## Instruction

```
*** Model ***
To use database encryt model must extend EncryptModel EncryptModel

use Managefaster\Database\Abstract\EncryptModel;

class TestModel extends EncryptModel
{
    //
}

*** Model with laravel authentication ***
Replace Authenticatable with AuthEncryptModel

use Managefaster\Database\Abstract\AuthEncryptModel;

class User extends AuthEncryptModel
{
    //
}

*** Model with uuid ***
When models use uuid as a primary key need extend UuidEncryptModel class and get

use Managefaster\Database\Abstract\UuidEncryptModel;

class TestModel extends UuidEncryptModel
{
    //
}

*** Model with uuid and laravel authentication ***
When models use uuid as a primary key and has laravel authentication need extend AuthEncryptModel class and get

use Managefaster\Database\Abstract\AuthEncryptModel;

class User extends UuidAuthEncryptModel
{
    //
}
```

```
*** Set encrypt columns for model ***

protected array $encrypts = ['title'];
```

## Model (create, update)
```
Create and update method work like default laravel methods, and automaticaly encrypt values by specified columsn in model encrypts property

TestModel::create(['title' => $title]);
TestModel::find($id)->update(['title' => $title]);
```

## Query examples
```
TestModel::whereEncrypted([
        ['title', '!=', 'Test title 1701517522'],
        ['title', 'Test title 1701517493']
    ])
    ->orWhereEncrypted([
        ['title', '!=', 'Test title 1701517522'],
        ['title', 'Test title 1701517493']
    ])
    ->where('slug', 'test-title-1701335036')
    ->whereEncrypted('title', 'LIKE', '%' . 'test 2' . '%')
    ->whereEncrypted('title', 'Test title 1701335036')
    ->orWhereEncrypted('title', 'LIKE', '%' . '1701517493' . '%')
    ->orWhereEncrypted('title', 'Test title 1701517493')
    ->get();
```

## Get decrypted model data
```
All decryption mde automaticaly when try ged model atributes. To get decrypted atribute values need use Resource class all take direct atributes from model.

$model = TestModel::whereEncrypted([
        ['title', '!=', 'Test title 1701517522'],
        ['title', 'Test title 1701517493']
    ])-get();
    
*** With laravel resource ***
TestModelResource::collection($model);

*** Get direct attributes ***
$model->title;
```
