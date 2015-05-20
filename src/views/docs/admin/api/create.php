# API

Create your api endpoint

### Name Of Request

The human name of the API request.

### Route Type

The route type this api request will be sent with. Possible types are

```
Regular (GET)
Create (POST)
Update (PUT)
Delete (DELETE)
Any Method (ANY)
```

### Route Name

The route name is unique to this API endpoint. This might be used in other places throughout the application and should not change once the endpoint is created.

### Request Slug

This is the url endpoint. You can reach this endpoint at: <?= url('@livespan([name="slug"])') ?>

### Response Class

The response class the php fully qualified namespace classpath. This class is used when handling a request to this api endpoint.

### Response Method

The response method is the *public* method inside of the *Response Class*. This method is invoked when handling requests to this api endpoint.

### Response Parameters

A response parameter is passed to the *Response Method*. This can be input parameters, other variables, strings or numbers. You can pass multiple parameters by using a comma.

Here are a few example parameters. Assume that we are calling __<?= url('@livespan([name="slug"])') ?>?foo=baz__ which invokes the method below inside of class @livespan([name="response_class"])

__input__ - passes the entire query input to the method.

```
public function @livespan([name=response_method])($input)
{
	var_dump($input); // array('foo' => 'baz')
}
```

__input.foo__ - passes foo from the input query array

```
public function @livespan([name=response_method])($foo)
{
	print $foo; // 'baz'
}
```

Or if we had a url __<?= url("/some/:id") ?>__ then we can get the id this way

__params.id, input__ - passes the id
```
public function @livespan([name=response_method])($id, $input)
{
	print $id; 			// 1
	var_dump($input); 	// array('foo' => 'baz')
}
```

### Before

Calls a Laravel filter before running this api endpoint. This is a good place for permission checks. These filters are strings. You can supply multiple filters with a comma. You can even use [Devise permissions](/admin/permissions).

```
auth,isAdministrator
```
