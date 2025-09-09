<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;
use App\Http\Resources\VerifyCustomerResponseResource;
use App\Http\Resources\AccountsResponseResource;
use App\Http\Resources\ApprovedAccountsResponseResource;

class CoopsController extends Controller
{
    // COOPS
    /**
     * Display the specified resource.
     */
    /**
     * @OA\Post(
     *     path="/api/verify-customer",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to list accounts",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/VerifyCustomerRequest")
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
     public function verifyCustomer(Request $request)
    {
        //
        $username = $request->username;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $gender = $request->gender;
        $dob = $request->dob;
        $mobileNumber = $request->mobileNumber;

        // try {
        //     $dob = \Carbon\Carbon::parse($dob)->format('Y-m-d');
        // } catch (\Exception $e) {
        //     Log::error("Invalid date of birth format: " . $dob);
        //     return response()->json(['error' => 'Invalid date of birth format'], 400);
        // }
        

        Log::debug("Request received to verify customer");
        Log::debug($username);

        Log::debug("Calling procedure");

        $client = config('customConfig.clientName');

        // Calling procedure to get accounts
        $resp = DB::select('exec kafCOOPSSignup ?, ?, ?, ?, ?, ?, ?',array($username, $firstName, $lastName, $mobileNumber, $email, $gender, $dob));

        Log::debug("Response from procedure to list first 3 accounts");
        Log::debug($resp);
        // Log::debug(var_dump($resp));
        // Log::debug($resp[0]->AccountNumber);

        $respCode = 500;
        $respMessage = "Failed to verify customer";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    if(isset($resp[0]->Status) && $resp[0]->Status == 0){
                        Log::debug("Customer verification in progress");
                        Log::debug($resp);
                        Log::debug("Customer verified successfully");
                        $respCode = 200;
                        $respMessage = "Verified customer successfully";
                        $resp = $respMessage;
                    } else {
                        Log::debug("Customer verification response indicates failure");
                        Log::debug($resp);
                        $resp = null;
                        $respCode = 207;
                        $respMessage = "Unable to verify customer";
                    }
                } else {
                    Log::debug("Unable to verify customer");
                    $respCode = 207;
                    $respMessage = "Unable to verify customer";
                    $resp = null;
                }
            } else {
                Log::debug("Null response. Unable to verify customer");
                $respCode = 206;
                $respMessage = "Unable to verify customer";
                $resp = null;
            }
        } catch(Exception $e){
            Log::debug("An error occurred. Unable to verify customer");
            $respCode = 501;
            $respMessage = "Failed to verify customer";
            $resp = null;
        }
        

        return new VerifyCustomerResponseResource($resp, $respCode, $respMessage, $client);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/fetch-approved-accounts",
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
     public function fetchApprovedAccounts(Request $request)
    {
        //
        $id = $request->id;

        Log::debug("Request received to fetch approved accounts");
        Log::debug($id);

        Log::debug("Calling procedure");

        $client = config('customConfig.clientName');

        Log::debug("Client name is ".$client);

        // Calling procedure to get accounts
        $resp = DB::select('exec kafCOOPSApproved');

        Log::debug("Response from procedure to fetch approved accounts");
        Log::debug($resp);
        // Log::debug(var_dump($resp));
        // Log::debug($resp[0]->AccountNumber);

        $respCode = 500;
        $respMessage = "Failed to get accounts";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    Log::debug("Accounts fetched successfully");
                    Log::debug($resp);
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
        

        return new ApprovedAccountsResponseResource($resp, $respCode, $respMessage, $client);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Post(
     *     path="/api/activate-verified-customer",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to list accounts",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ActivateAccountRequest")
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
     public function activateVerifiedCustomer(Request $request)
    {
        //
        $username = $request->username;
        $mobileNumber = $request->mobileNumber;

        Log::debug("Request received to approve account");
        Log::debug($username);
        Log::debug($mobileNumber);

        Log::debug("Calling procedure");

        $client = config('customConfig.clientName');

        // Calling procedure to get accounts
        $resp = DB::select('exec kafCOOPSUpdateSynched ?, ?',array($username, $mobileNumber));

        Log::debug("Response from procedure to approve account");
        Log::debug($resp);
        // Log::debug(var_dump($resp));
        // Log::debug($resp[0]->AccountNumber);

        $respCode = 500;
        $respMessage = "Failed to approve account";

        try{
            if($resp != null){
                if(is_array($resp) && !empty($resp)){
                    Log::debug("Account approved successfully");
                    Log::debug($resp);
                    $respCode = 200;
                    $respMessage = "Data retrieved successfully";
                    Log::debug("Account approved successfully");
                } else {
                    Log::debug("Account approval failed");
                    $respCode = 207;
                    $respMessage = "No accounts found";
                    $resp = null;
                }
            } else {
                Log::debug("Null response. No accounts found");
                $respCode = 206;
                $respMessage = "Failed to activate account";
                $resp = null;
            }
        } catch(Exception $e){
            Log::debug("An error occurred. No accounts found");
            $respCode = 501;
            $respMessage = "Failed to activate account";
            $resp = null;
        }
        

        return new VerifyCustomerResponseResource($resp, $respCode, $respMessage, $client);
    }
}
