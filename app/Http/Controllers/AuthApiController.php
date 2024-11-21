<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Resources\ValidationResponseResource;
use App\Http\Resources\UserResponseResource;
use Illuminate\Support\Facades\Config;

class AuthApiController extends Controller
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

    public function pinValidationFunc(string $number, string $password){
        $resp = DB::select('exec kafPINVerify ?,?',array($number,$password));

        Log::debug("Response from pin validation procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        Log::debug($resp[0]->Status);

        $message = "Error verifying credentials";
        $respSummary = "";
        $respCode = 500;

        $client = config('customConfig.clientName');

        try{
            if($resp[0]->Status == 1){
                Log::debug("Successful validation");
                $message = "Successful Verification";
                $respSummary = true;
                $respCode = 200;
            } else if ($resp[0]->Status == 0){
                Log::debug("Failed validation");
                $message = "Sorry, credentials provided are incorrect.";
                $respSummary = false;
            }
        } catch(Exception $e){
            Log::error("Error::: ". $e);

            $message = "Error verifying credentials";
            $respSummary = "ERROR";
        }

        return new ValidationResponseResource($respSummary, $respCode, $message, $client);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Post(
     *     path="/api/verify-pin",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to verify pin",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PinValidationRequest")
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
    public function validatePin(Request $request)
    {
        //
        $number = $request->number;
        $password = $request->password;

        Log::debug("Request received");
        Log::debug($number);
        Log::debug($password);

        $client = config('customConfig.clientName');

        $password = hash('sha256', $password);

        Log::debug("Calling pin validation procedure");
        // About to verify pin. Calling procedure.
        Log::debug("Old pin is ");
        
        $resp = $this->pinValidationFunc($number, $password);

        return new ValidationResponseResource($resp->result, $resp->statusCode, $resp->statusDesc, $client);
        // Log::debug($resp);
    }

    // /**
    //  * Display the specified resource.
    //  */
    // /**
    //  * @OA\Post(
    //  *     path="/api/reset-pin",
    //  *     @OA\Response(response="200", description="Success"),
    //  *     @OA\RequestBody(
    //  *         description="request parameters to reset pin",
    //  *         required=true,
    //  *          @OA\JsonContent(ref="#/components/schemas/PinValidationRequest")
    //  *      ),
    //  *      @OA\Response(
    //  *          response=201,
    //  *          description="Successful operation"
    //  *       ),
    //  *      @OA\Response(
    //  *          response=400,
    //  *          description="Bad Request"
    //  *      ),
    //  *      @OA\Response(
    //  *          response=401,
    //  *          description="Unauthenticated",
    //  *      ),
    //  *      @OA\Response(
    //  *          response=403,
    //  *          description="Forbidden"
    //  *      )
    //  * )
    //  */
    public function resetPin(Request $request)
    {
        //
        $number = $request->number;
        $password = $request->password;

        Log::debug("Request received");
        Log::debug($number);

        $defaultPin = '1234';

        $message = "Pin reset failed";
        $respSummary = "FAILED";
        $respCode = 500;

        $password = hash('sha256', $password);

        $resp = $this->pinValidationFunc($number, $password);

        if($resp->statusCode == 200){
            // Log::debug("Calling procedure");
            // About to verify pin. Calling procedure.
            $resp = DB::select('exec kafPINReset ?,?',array($number,$defaultPin));

            Log::debug("Response from pin reset procedure");
            Log::debug($resp);
            // Log::debug(var_dump($resp[0]));
            // Log::debug($resp[0]->Status);


            try{
                if($resp[0]->Status == 1){
                    Log::debug("Successful pin reset");
                    $message = "Successful pin reset";
                    $respSummary = true;
                    $respCode = 200;
                } else if ($resp[0]->Status == 0){
                    Log::debug("Failed pin reset");
                    $message = "Sorry, pin reset failed.";
                    $respSummary = false;
                }
            } catch(Exception $e){
                Log::error("Error::: ". $e);

                $message = "Error changing customer's pin.";
                $respSummary = "ERROR";
            }
        } else {
            $message = "Error validating pin.";
            $respSummary = "ERROR";
        }

        // $message = "Pin reset request received and is being processed";
        // $respSummary = "SUCCESS";
        // $respCode = 200;
        

        return new ValidationResponseResource($respSummary, $respCode, $message);
        // Log::debug($resp);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Post(
     *     path="/api/reset-pin",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to reset pin",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ChangePinRequest")
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
    public function changePin(Request $request)
    {
        //
        $number = $request->number;
        $oldPin = $request->oldPassword;
        $newPin = $request->newPassword;

        $newPin = hash('sha256', $newPin);
        $oldPin = hash('sha256', $oldPin);

        $client = config('customConfig.clientName');

        Log::debug("Request received");
        Log::debug($number);
        Log::debug("Old pin is ");
        Log::debug($oldPin);
        Log::debug("New pin is ");
        Log::debug($newPin);

        // $defaultPin = '1234';

        $message = "Failed to reset pin.";
        $respSummary = "FAILED";
        $respCode = 500;

        $resp = $this->pinValidationFunc($number, $oldPin);

        if($resp->statusCode == 200){
            Log::debug("Calling pin reset procedure");
            // About to verify pin. Calling procedure.
            $resp = DB::select('exec kafPINReset ?,?',array($number,$newPin));

            Log::debug("Response from procedure");
            Log::debug($resp);

            try{
                if($resp[0]->Status == 1){
                    Log::debug("Successful pin change");
                    $message = "Successful pin change";
                    $respSummary = true;
                    $respCode = 200;
                } else if ($resp[0]->Status == 0){
                    Log::debug("Failed pin change");
                    $message = "Sorry, pin change failed.";
                    $respSummary = false;
                }
            } catch(Exception $e){
                Log::error("Error::: ". $e);
    
                $message = "Error changing customer's pin.";
                $respSummary = "ERROR";
            }
            // Log::debug(var_dump($resp[0]));
            // Log::debug($resp[0]->Status);
        } else {
            $message = "Error validating pin.";
            $respSummary = "ERROR";
        }
        

        return new ValidationResponseResource($respSummary, $respCode, $message, $client);
        // Log::debug($resp);
    }

    /**
     * Save field deposit.
     */
    /**
     * @OA\Post(
     *     path="/api/register-customer",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to register customer",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
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
    public function registerAccount(Request $request)
    {
        //
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $gender = $request->gender;
        $mobileNumber = $request->mobileNumber;
        $type = "CUSTOMER";

        $proceed = true;

        $client = config('customConfig.clientName');

        Log::debug("Request received");
        Log::debug($firstName);
        Log::debug($gender);
        Log::debug($mobileNumber);

        if($gender=='f' || $gender=='F'){
            $gender = "FEMALE";
        } else if($gender=='m' || $gender=='M'){
            $gender = "MALE";
        } else {
            $proceed = false;
        }

        $message = "Failed to register.";
        $respSummary = "FAILED";
        $respCode = 301;
        $resp = null;

        if($proceed==false){
            $message = "Unknown gender.";
            $respSummary = "FAILED";
            $respCode = 407;
        } else {
            Log::debug("Calling procedure");

            try{
                $resp = DB::select('exec kafNewAccountCust ?, ?, ?, ?',array($firstName, $lastName, $gender, $mobileNumber));

                Log::debug($resp);
                Log::debug(json_decode(json_encode($resp[0]), true));
                $message = "Customer added successfully";
                $respSummary = $resp[0]->AccountNumber;
                Log::debug("Customer added successfully");
                Log::debug($respSummary);
                $respCode = 200;
                $resp = $resp[0];
    
            } catch(Exception $e){
                $message = "An error occurred while registering. Please try again.";
                $respSummary = "FAILED";
                $respCode = 412;
                $resp = null;
            }
            

            if($respSummary=='Already Exist'){
                $message = "User already exists.";
                $respSummary = "FAILED";
                $resp = null;
                $respCode = 402;
            } else if($respSummary==0){
                $message = "Account not registered. Please try again later.";
                $respSummary = "FAILED";
                $resp = null;
                $respCode = 405;
            }

            // Calling procedure to credit account number

            Log::debug("Response from procedure");
            // Log::debug(json_decode(json_encode($resp[0]), true));
            // Log::debug(var_dump($resp[0]));
            // Log::debug(var_dump($resp[0]));
            // Log::debug($resp[0]->Status);
        }

        return new UserResponseResource($resp, $respCode, $message, $type, $client);
    }

    /**
     * Save field deposit.
     */
    /**
     * @OA\Post(
     *     path="/api/create-field-account",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to create field agent account",
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateFieldAccountRequest")
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
    public function createFieldAccount(Request $request)
    {
        //
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $gender = $request->gender;
        $mobileNumber = $request->mobileNumber;
        $agentMobileNumber = $request->agentMobileNumber;
        $type = "FIELD AGENT ACCOUNT";

        $proceed = true;

        $client = config('customConfig.clientName');

        Log::debug("Request received");
        Log::debug($firstName);
        Log::debug($gender);
        Log::debug($mobileNumber);
        Log::debug($agentMobileNumber); 

        if($gender=='f' || $gender=='F'){
            $gender = "FEMALE";
        } else if($gender=='m' || $gender=='M'){
            $gender = "MALE";
        } else {
            $proceed = false;
        }

        $message = "Failed to register.";
        $respSummary = "FAILED";
        $respCode = 301;
        $resp = null;

        if($proceed==false){
            $message = "Unknown gender.";
            $respSummary = "FAILED";
            $respCode = 407;
        } else {
            Log::debug("Calling procedure");

            try{

                $resp = DB::select('exec kafNewAccountField ?, ?, ?, ?, ?',array($firstName, $lastName, $gender, $mobileNumber, $agentMobileNumber));
                
                Log::debug($resp);
                Log::debug(json_decode(json_encode($resp[0]), true));
                $message = "Field Officer added successfully";
                $respSummary = $resp[0]->AccountID;
                Log::debug("Field Officer added successfully");
                Log::debug($respSummary);
                $respCode = 200;
                $resp = $resp[0];

            } catch(Exception $e){
                $message = "An error occurred while registering. Please try again.";
                $respSummary = "FAILED";
                $respCode = 412;
                $resp = null;
            }
            

            if($respSummary=='Already Exist'){
                $message = "Account already exists.";
                $respSummary = "FAILED";
                $resp = null;
                $respCode = 402;
            } else if($respSummary==0){
                $message = "Account not registered. Please try again later.";
                $respSummary = "FAILED";
                $resp = null;
                $respCode = 405;
            }

            // Calling procedure to credit account number

            Log::debug("Response from procedure");
            // Log::debug(json_decode(json_encode($resp[0]), true));
            // Log::debug(var_dump($resp[0]));
            // Log::debug(var_dump($resp[0]));
            // Log::debug($resp[0]->Status);
        }

        return new UserResponseResource($resp, $respCode, $message, $type, $client);
    }
}
