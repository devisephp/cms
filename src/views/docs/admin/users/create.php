# Creating Users

To give you an idea of how some of this form's data can be used, we've added some examples using the current form input data:

*Find Group By Id*
```php
// new instance of GroupsRepository
$GroupsRepository = new Devise\Users\Groups\GroupsRepository;

$groupId = @livespan([name="group_id"]);
$group = $GroupsRepository->findById($groupId);
```

For any user-related data retrieval, we will need an instance of the UsersRepository:

```php
$UsersRepository = new Devise\Users\UsersRepository;
```

*Find User By Email*
```php
$email = '@livespan([name="email"])';
$user = $UsersRepository->findByEmail($email);
```

*Find User By Name*
```php
$name = '@livespan([name="name"])';
$user = $UsersRepository->findByName($name);
```

*Find User By Username*
```php
$username = '@livespan([name="username"])';
$user = $UsersRepository->findByUsername($username);
```