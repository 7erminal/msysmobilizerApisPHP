<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Resources\AccountsResponseResource;
use App\Http\Resources\ValidationResponseResource;
use App\Http\Resources\AccountBalResponseResource;
use App\Http\Resources\CustAccountsResponseResource;
use App\Http\Resources\ContactInfoResponseResource;
use App\Http\Functions\Functions;
use Illuminate\Support\Facades\Config;

class AccountsApiController extends Controller
{
    public function __construct(Functions $functions){
        // parent::__construct();
        $this->functions = $functions;
    }
  
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

        Log::debug("Request received to list first 3 accounts");
        Log::debug($id);

        Log::debug("Calling procedure");

        $client = config('customConfig.clientName');

        // Calling procedure to get accounts
        $resp = DB::select('exec kafStartField ?',array($id));

        Log::debug("Response from procedure to list first 3 accounts");
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
                    Log::debug("No accounts found");
                    $respCode = 207;
                    $respMessage = "No accounts found";
                    $resp = null;
                }
            } else {
                Log::debug("Null response. No accounts found");
                $respCode = 206;
                $respMessage = "No accounts found";
                $resp = null;
            }
        } catch(Exception $e){
            Log::debug("An error occurred. No accounts found");
            $respCode = 501;
            $respMessage = "Failed to get accounts";
            $resp = null;
        }
        

        return new AccountsResponseResource($resp, $respCode, $respMessage, $client);
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
        $client = config('customConfig.clientName');

        Log::debug("Request received to list first 3 cust accounts");
        Log::debug($number);

        Log::debug("Calling procedure to list first 3 cust accounts");

        // Calling procedure to get accounts
        $resp = DB::select('exec kafCustAccounts ?',array($number));

        Log::debug("Response from procedure to list first 3 cust accounts");
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
            Log::error("An error occurred. Unable to fetch accounts");
            $respCode = 501;
            $respMessage = "Failed to get accounts";
            $resp = null;
        }
        

        return new CustAccountsResponseResource($resp, $respCode, $respMessage, $client);
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
        $reference = $request->reference;

        Log::debug("Credit account Request received");
        Log::debug($request);
        Log::debug($accountNumber);
        Log::debug($amount);
        Log::debug($reference);

        $client = config('customConfig.clientName');

        Log::debug("Calling procedure to credit account:::");

        $respCode = 500;
        $respMessage = "Failed to get accounts";
        $resp = null;

        if(trim($amount)==""){
            $respMessage = "No amount entered";
        } else {
            // Calling procedure to credit account number
            $resp = DB::select('exec addCustUSSDCredit ?, ?, ?',array($accountNumber, $amount, $reference));

            Log::debug("Response from procedure to credit account");
            Log::debug($resp);
            // Log::debug(var_dump($resp[0]));
            // Log::debug($resp[0]->Status);

            try{
                if($resp != null){
                    if(is_array($resp) && !empty($resp)){
                        if($resp[0]->Status==1){
                            Log::debug("Credit account request was successful");
                            $respCode = 200;
                            $respMessage = "Success";
                            $resp = "SUCCESS";
                        } else {
                            Log::debug("Credit account request failed");
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
        }
        

        Log::debug("Sending credit account response back to gateway");
        Log::debug($resp);

        return new ValidationResponseResource($resp, $respCode, $respMessage, $client);
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

        Log::debug("Request received to check account balance");
        Log::debug($accountNumber);

        Log::debug("Calling procedure to check account balance");

        $client = config('customConfig.clientName');

        // Calling procedure to check account balance
        $resp = DB::select('exec getAccountBalance ?',array($accountNumber));

        Log::debug("Response from procedure to get account balance");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]->Status);

        $respCode = 500;
        $respMessage = "Failed to get account";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    Log::debug("Successful account balance check");
                    $respCode = 200;
                    $respMessage = "Success";
                    $resp = $resp[0];
                } else {
                    Log::error("Failed account balance check");
                    $respCode = 207;
                    $respMessage = "Failed to get balance";
                    $resp = null;
                }
            } else {
                Log::error("Null response. Account balance check failed");
                $respCode = 209;
                $respMessage = "Null response received. Unknown status.";
                $resp = null;
            }
        } catch(Exception $e){
            Log::error("An error occurred. Failed to get account balance");
            $respCode = 501;
            $respMessage = "An error occured while checking balance";
            $resp = null;
        }

        return new AccountBalResponseResource($resp, $respCode, $respMessage, $client);
    }

    /**
     * Get Contact Info.
     */
    /**
     * @OA\Post(
     *     path="/api/get-contact-info",
     *     @OA\Response(response="200", description="Success"),
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
    public function getContactInfo(Request $request)
    {
        //
        Log::debug("Request to get contact info received");

        Log::debug("Calling contact info procedure");
        $client = config('customConfig.clientName');

        // Calling procedure to check account balance
        $resp = DB::select('exec kafContactInfo');

        Log::debug("Response from get contact info procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]);

        $respCode = 500;
        $respMessage = "Failed to get info";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    $respCode = 200;
                    $respMessage = "Success";
                    $resp = $resp[0];
                } else {
                    $respCode = 207;
                    $respMessage = "Failed to get info";
                    $resp = null;
                }
            } else {
                $respCode = 209;
                $respMessage = "Null response received. Unknown status.";
                $resp = null;
            }
        } catch(Exception $e){
            $respCode = 501;
            $respMessage = "An error occured while getting contact info";
            $resp = null;
        }

        return new ContactInfoResponseResource($resp, $respCode, $respMessage, $client);
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

        $client = config('customConfig.clientName');

        Log::debug("Request received for field deposit");
        Log::debug($accountNumber);
        Log::debug($amount);
        Log::debug($mobileNumber);

        Log::debug("Calling procedure for field deposit");

        Log::debug("Validated number is ");

        $newNum = $this->functions->validateNumber($mobileNumber);

        Log::debug($newNum);

        $respCode = 500;
        $respMessage = "Failed to get account";
        $resp = null;

        if(trim($amount)==""){
            Log::error("No amount entered");
            $respMessage = "No amount entered";
        } else {
            Log::debug("Request sent:::");
            Log::debug("Account number:: ".$accountNumber."\nAmount:: ".$amount."\nNumber:: ".$newNum);
            // Calling procedure to credit account number
            $resp = DB::select('exec addMobUSSDTrans ?, ?, ?',array($accountNumber, $amount, $newNum));

            Log::debug("Response from add field deposit procedure:::");
            Log::debug($resp);
            // Log::debug(var_dump($resp[0]));
            // Log::debug($resp[0]->Status);

            try{
                if($resp != null){
                    if(is_array($resp) && !empty($resp)){
                        if($resp[0]->Status==1){
                            Log::error("Field deposit successful:::");
                            $respCode = 200;
                            $respMessage = "Deposit successful";
                            $resp = "SUCCESS";
                        } else {
                            Log::error("Field deposit failed:::");
                            $respCode = 206;
                            $respMessage = "Deposit failed. Please check details and try again.";
                            $resp = "FAILED";
                        }
                        
                    } else {
                        Log::error("Field deposit failed:::empty response");
                        $respCode = 207;
                        $respMessage = "Failed to deposit";
                        $resp = null;
                    }
                } else {
                    Log::error("Field deposit failed:::Null response");
                    $respCode = 209;
                    $respMessage = "Null response received. Unknown status.";
                    $resp = null;
                }
            } catch(Exception $e){
                Log::error("An error occurred. Field deposit failed:::");
                $respCode = 501;
                $respMessage = "An error occured while checking balance";
                $resp = null;
            }
        }

        return new ValidationResponseResource($resp, $respCode, $respMessage, $client);
    }
}
