<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Resources\AccountsResponseResource;

class AccountsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function listAccountsFirst3(Request $request)
    {
        //
        $id = $request->id;

        Log::debug("Request received");
        Log::debug($id);

        Log::debug("Calling procedure");

        // Calling procedure to get accounts
        $resp = DB::select('exec kafStartField ?',array($id));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]->Status);

        return new AccountsResponseResource($resp, 200, 'Data retrieved successfully');
    }

    /**
     * Credit account.
     */
    public function creditAccount(Request $request)
    {
        //
        $accountNumber = $request->accountNumber;
        $amount = $request->amount;

        Log::debug("Request received");
        Log::debug($accountNumber);
        Log::debug($amount);

        Log::debug("Calling procedure");

        // Calling procedure to credit account number
        $resp = DB::select('exec addCustUSSDCredit ?, ?',array($accountNumber, $amount));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]->Status);

        return new AccountsResponseResource($resp, 200, 'Data retrieved successfully');
    }

    /**
     * Check account balance.
     */
    public function checkAccountBalance(Request $request)
    {
        //
        $accountNumber = $request->accountNumber;

        Log::debug("Request received");
        Log::debug($accountNumber);

        Log::debug("Calling procedure");

        // Calling procedure to check account balance
        $resp = DB::select('exec getAccountBalance ?',array($accountNumber));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]->Status);

        return new AccountsResponseResource($resp, 200, 'Data retrieved successfully');
    }

    /**
     * Save field deposit.
     */
    public function saveFieldDeposit(Request $request)
    {
        //
        $accountNumber = $request->accountNumber;
        $amount = $request->amount;
        $mobileNumber = $request->mobileNumber;

        Log::debug("Request received");
        Log::debug($accountNumber);
        Log::debug($amount);
        Log::debug($mobileNumber);

        Log::debug("Calling procedure");

        // Calling procedure to credit account number
        $resp = DB::select('exec addMobUSSDTrans ?, ?, ?',array($accountNumber, $amount, $mobileNumber));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]->Status);

        return new AccountsResponseResource($resp, 200, 'Data retrieved successfully');
    }
}
