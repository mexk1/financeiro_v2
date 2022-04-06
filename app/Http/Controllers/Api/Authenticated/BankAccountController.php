<?php

namespace App\Http\Controllers\Api\Authenticated;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authenticated\BankAccount\CreateBankAccountRequest;
use App\Http\Requests\Api\Authenticated\BankAccount\UpdateBankAccountRequest;
use App\Models\Account;
use App\Models\BankAccount;
use App\Services\CRUD\BankAccount\CreateBankAccountService;
use App\Services\CRUD\BankAccount\DesactivateBankAccountService;
use App\Services\CRUD\BankAccount\UpdateBankAccountService;

class BankAccountController extends Controller
{
    //
    public function create( CreateBankAccountRequest $request, Account $account ){

        $service = new CreateBankAccountService( $request->validated(), $account );

        try {
            if( $bank_account = $service->run() )
                return response()->json( $bank_account, 201 );

        } catch (\Throwable $th) {
            report( $th );
        }

        return response( null, 503 );
    }

    public function update( UpdateBankAccountRequest $request, BankAccount $bank_account ){

        $service = new UpdateBankAccountService( $bank_account, $request->validated() );

        try {
            if( $bank_account = $service->run() )
                return response()->json( $bank_account );

        } catch (\Throwable $th) {
            report( $th );
        }

        return response( null, 503 );
    }

    public function desactivate( BankAccount $bank_account  ){
        $service = new DesactivateBankAccountService( $bank_account );
        try {
            if( $bank_account = $service->run() )
                return response()->json( $bank_account );
        } catch (\Throwable $th) {
            report( $th );
        }
        return response( null, 503 );
    }
}
