<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class coops extends Controller
{
    //
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

        Log::debug("Request received to verify customer");
        Log::debug($username);

        Log::debug("Calling procedure");

        $client = config('customConfig.clientName');

        // Calling procedure to get accounts
        $resp = DB::select('exec kafCOOPSSignup ?, ?, ?, ?, ?, ?, ?',array($username, $firstName, $lastName, $email, $gender, $dob, $mobileNumber));

        Log::debug("Response from procedure to list first 3 accounts");
        Log::debug($resp);
        // Log::debug(var_dump($resp));
        // Log::debug($resp[0]->AccountNumber);

        $respCode = 500;
        $respMessage = "Failed to verify customer";

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
     *     path="/api/approve-account",
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
     public function approveAccount(Request $request)
    {
        //
        $username = $request->username;
        $mobileNumber = $request->mobileNumber;

        Log::debug("Request received to approve account");
        Log::debug($id);

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
}
