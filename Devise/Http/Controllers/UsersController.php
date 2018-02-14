<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Users\SaveUser;
use Devise\Http\Requests\Users\DeleteUser;
use Devise\Http\Requests\Users\UpdateUser;
use Devise\Http\Resources\Api\UserResource;
use Devise\Support\Framework;

use Illuminate\Routing\Controller;

class UsersController extends Controller
{
  /**
   * @var User
   */
  private $User;


  /**
   * UsersController constructor.
   * @param User $User
   */
  public function __construct(Framework $Framework)
  {
    $app = $Framework->container;
    $config = $Framework->config;
    $this->User = $app->make($config->get('auth.providers.users.model'));
  }

  public function all(ApiRequest $request)
  {
    $all = $this->User
      ->get();

    return UserResource::collection($all);
  }

  /**
   * @param SaveUser $request
   * @return UserResource
   */
  public function store(SaveUser $request)
  {
    $new = $this->User
      ->create([
        'name'     => $request->input('name'),
        'email'    => $request->input('email'),
        'password' => bcrypt($request->input('password')),
      ]);

    return new UserResource($new);
  }

  /**
   * @param UpdateUser $request
   * @param $id
   * @return UserResource
   */
  public function update(UpdateUser $request, $id)
  {
    $user = $this->User
      ->findOrFail($id);

    $data = $request->all();

    if (isset($data['password']))
    {
      $data['password'] = bcrypt($data['password']);
    }

    $user->update($data);

    return new UserResource($user);
  }

  /**
   * @param DeleteUser $request
   * @param $id
   */
  public function delete(DeleteUser $request, $id)
  {
    $user = $this->User
      ->findOrFail($id);

    $user->delete();
  }
}