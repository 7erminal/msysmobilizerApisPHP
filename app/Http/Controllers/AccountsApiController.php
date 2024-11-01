<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Resources\AccountsResponseResource;
use App\Http\Resources\ValidationResponseResource;
use App\Http\Resources\AccountBalResponseResource;

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
    /**
     * @OA\Post(
     *     path="/api/list-accounts",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to list accounts",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/IdRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
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
        // Log::debug(var_dump($resp));
        // Log::debug($resp[0]->AccountNumber);

        $respCode = 500;
        $respMessage = "Failed to get accounts";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    $respCode = 200;
                    $respMessage = "Data retrieved successfully";
                } else {
                    $respCode = 207;
                    $respMessage = "No accounts found";
                    $resp = null;
                }
            } else {
                $respCode = 206;
                $respMessage = "No accounts found";
                $resp = null;
            }
        } catch(Exception $e){
            $respCode = 501;
            $respMessage = "Failed to get accounts";
            $resp = null;
        }
        

        return new AccountsResponseResource($resp, $respCode, $respMessage);
    }


    /**
     * Display the specified resource.
     */
    /**
     * @OA\Post(
     *     path="/api/list-cust-accounts",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to list accounts",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/NumberRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function listAccountsFirst3Cust(Request $request)
    {
        //
        $number = $request->number;

        Log::debug("Request received");
        Log::debug($number);

        Log::debug("Calling procedure");

        // Calling procedure to get accounts
        $resp = DB::select('exec kafCustAccounts ?',array($number));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp));
        // Log::debug($resp[0]->AccountNumber);

        $respCode = 500;
        $respMessage = "Failed to get accounts";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    $respCode = 200;
                    $respMessage = "Data retrieved successfully";
                } else {
                    $respCode = 207;
                    $respMessage = "No accounts found";
                    $resp = null;
                }
            } else {
                $respCode = 206;
                $respMessage = "No accounts found";
                $resp = null;
            }
        } catch(Exception $e){
            $respCode = 501;
            $respMessage = "Failed to get accounts";
            $resp = null;
        }
        

        return new AccountsResponseResource($resp, $respCode, $respMessage);
    }

    /**
     * Credit account.
     */
    /**
     * @OA\Post(
     *     path="/api/credit-account",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to credit account",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreditAccountRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
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

        $respCode = 500;
        $respMessage = "Failed to get accounts";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    if($resp[0]->Status==1){
                        $respCode = 200;
                        $respMessage = "Success";
                        $resp = "SUCCESS";
                    } else {
                        $respCode = 301;
                        $respMessage = "Failed";
                        $resp = "FAILED";
                    }
                } else {
                    $respCode = 207;
                    $respMessage = "Unable to credit account";
                    $resp = null;
                }
            } else {
                $respCode = 209;
                $respMessage = "Null response received. Unknown payment status.";
                $resp = null;
            }
        } catch(Exception $e){
            $respCode = 501;
            $respMessage = "An error occured while attempting to credit account";
            $resp = null;
        }

        return new ValidationResponseResource($resp, $respCode, $respMessage);
    }

    /**
     * Check account balance.
     */
    /**
     * @OA\Post(
     *     path="/api/account-balance",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to list accounts",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AccountRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
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

        $respCode = 500;
        $respMessage = "Failed to get account";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    $respCode = 200;
                    $respMessage = "Success";
                    $resp = $resp[0];
                } else {
                    $respCode = 207;
                    $respMessage = "Failed to get balance";
                    $resp = null;
                }
            } else {
                $respCode = 209;
                $respMessage = "Null response received. Unknown status.";
                $resp = null;
            }
        } catch(Exception $e){
            $respCode = 501;
            $respMessage = "An error occured while checking balance";
            $resp = null;
        }

        return new AccountBalResponseResource($resp, $respCode, $respMessage);
    }

    /**
     * Save field deposit.
     */
    /**
     * @OA\Post(
     *     path="/api/field-deposit",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to list accounts",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SaveFieldRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
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

        Log::debug("Response from add field deposit procedure:::");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]->Status);

        $respCode = 500;
        $respMessage = "Failed to get account";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    if($resp[0]->Status==1){
                        $respCode = 200;
                        $respMessage = "Deposit successful";
                        $resp = "SUCCESS";
                    } else {
                        $respCode = 206;
                        $respMessage = "Deposit failed. Please check details and try again.";
                        $resp = "FAILED";
                    }
                    
                } else {
                    $respCode = 207;
                    $respMessage = "Failed to deposit";
                    $resp = null;
                }
            } else {
                $respCode = 209;
                $respMessage = "Null response received. Unknown status.";
                $resp = null;
            }
        } catch(Exception $e){
            $respCode = 501;
            $respMessage = "An error occured while checking balance";
            $resp = null;
        }

        return new ValidationResponseResource($resp, $respCode, $respMessage);
    }
}
