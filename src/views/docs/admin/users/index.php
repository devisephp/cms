# Users

Users allows anyone to manage the application's users. In short, user management offers the ability to create/delete users, enable/disable active status and change any users role's and settings.

### Common UsersRepository Methods:

Here we've listed some useful user functions available in Devise. And for our example, we will act like we already have access to an instance of UsersRepository.

``` php
$UsersRepository = new Devise\Users\UsersRepository;
```

*Get Current User*
``` php
$currentUser = $UsersRepository->retrieveCurrentUser();
```

*Retrieve Current User Id*
``` php
$currentUserId = $UsersRepository->retrieveCurrentUserId();
```

*Get Users as Paginated List*
``` php
$users = $UsersRepository->users();
```

*Find User By Id*
``` php
$id = 1;
$user = $UsersRepository->findById($id);
```

*Find User By Email*
``` php
$email = 'some@foo.com';
$user = $UsersRepository->findByEmail($email);
```

*Find User By Name*
``` php
$name = 'foo man';
$user = $UsersRepository->findByName($name);
```

*Find User By Username*
``` php
$username = 'fooadmin';
$user = $UsersRepository->findByUsername($username);
```

*Find User By Custom Field*
``` php
$fieldname = 'team';
$value = 'fooTeam';
$user = $UsersRepository->findByFieldAndValue($fieldname, $value);
```