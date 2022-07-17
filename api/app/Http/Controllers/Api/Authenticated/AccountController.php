<?php

namespace App\Http\Controllers\Api\Authenticated;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authenticated\Account\CreateAccountRequest;
use App\Http\Requests\Api\Authenticated\Account\CreateSpendRequest;
use App\Http\Requests\Api\Authenticated\Account\UpdateAccountRequest;
use App\Models\Account;
use App\Services\CRUD\Account\CreateAccountService;
use App\Services\CRUD\Account\DesactivateAccountService;
use App\Services\CRUD\Account\UpdateAccountService;
use App\Services\CRUD\Spend\CreateSpendService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccountController extends Controller
{

  public function list(Request $request)
  {
    $user = $request->user('sanctum');
    $accounts = Account::query()
      ->whereHas('owner', function (Builder $query) use ($user) {
        return $query->where('id', $user->id);
      })
      ->orWhereHas('users', function (Builder $query) use ($user) {
        return $query->where('id', $user->id);
      })
      ->get();

    return response()->json($accounts);
  }

  public function read(Account $account)
  {
    return response()->json($account);
  }

  public function create(CreateAccountRequest $request)
  {
    $service = new CreateAccountService($request->validated(), $request->user("sanctum"));

    try {
      $account = $service->run();
      if ($account) return response()->json($account, 201);
    } catch (\Throwable $th) {
      report($th);
    }

    return response(null, 503);
  }

  public function update(UpdateAccountRequest $request, Account $account)
  {
    $service = new UpdateAccountService($account, $request->validated());
    try {
      if ($account = $service->run())
        return response()->json($account, 200);
    } catch (\Throwable $th) {
      report($th);
    }
    return response(null, 503);
  }

  public function desactivate(Account $account)
  {
    $service = new DesactivateAccountService($account);

    if (request()->user('sanctum')?->id !== $account->owner->id) {
      throw new HttpException(403);
    }
    try {
      if ($account = $service->run())
        return response()->json($account);
    } catch (\Throwable $th) {
      report($th);
    }

    return response(null, 503);
  }


  public function paymentMethods(Account $account)
  {

    if (
      request()->user('sanctum')?->id !== $account->owner->id
      &&
      !$account->users()->find(request()->user('sanctum')?->id)
    ) {
      throw new HttpException(403);
    }

    return response()->json($account->payment_methods);
  }

  public function createSpend(Account $account, CreateSpendRequest $request)
  {

    $service = new CreateSpendService($account, $request->validated());

    try {
      if ($spend = $service->run())
        return response()->json($spend, 201);
    } catch (\Throwable $th) {
      report($th);
    }

    return response(null, 503);
  }
}
