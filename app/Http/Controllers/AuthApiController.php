<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Resources\ValidationResponseResource;
use App\Http\Resources\UserResponseResource;

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

        Log::debug("Calling procedure");
        // About to verify pin. Calling procedure.
        $resp = DB::select('exec kafPINVerify ?,?',array($number,$password));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        Log::debug($resp[0]->Status);

        $message = "Error verifying credentials";
        $respSummary = "";
        $respCode = 500;

        try{
            if($resp[0]->Status == 1){
                $message = "Successful Verification";
                $respSummary = true;
                $respCode = 200;
            } else if ($resp[0]->Status == 0){
                $message = "Sorry, credentials provided are incorrect.";
                $respSummary = false;
            }
        } catch(Exception $e){
            Log::error("Error::: ". $e);

            $message = "Error verifying credentials";
            $respSummary = "ERROR";
        }
        

        return new ValidationResponseResource($respSummary, $respCode, $message);
        // Log::debug($resp);
    }

    /**
     * Save field deposit.
     */
    /**
     * @OA\Post(
     *     path="/api/register-account",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\RequestBody(
     *         description="request parameters to register user",
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
        $altMobileNumber = $request->altMobileNumber;
        $type = $request->type;

        $proceed = true;

        Log::debug("Request received");
        Log::debug($firstName);
        Log::debug($gender);
        Log::debug($mobileNumber);
        Log::debug($altMobileNumber);
        Log::debug($type);

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
                if($type=='CUSTOMER'){
                    $resp = DB::select('exec kafNewAccountCust ?, ?, ?, ?',array($firstName, $lastName, $gender, $mobileNumber));
    
                    Log::debug($resp);
                    Log::debug(json_decode(json_encode($resp[0]), true));
                    $message = "Customer added successfully";
                    $respSummary = $resp[0]->AccountNumber;
                    Log::debug("Customer added successfully");
                    Log::debug($respSummary);
                    $respCode = 200;
                    $resp = $resp[0];
    
                } else if ($type=='FIELD') {
                    $resp = DB::select('exec kafNewAccountField ?, ?, ?, ?, ?',array($firstName, $lastName, $gender, $mobileNumber, $altMobileNumber));
                    
                    Log::debug($resp);
                    Log::debug(json_decode(json_encode($resp[0]), true));
                    $message = "Field Officer added successfully";
                    $respSummary = $resp[0]->AccountID;
                    Log::debug("Field Officer added successfully");
                    Log::debug($respSummary);
                    $respCode = 200;
                    $resp = $resp[0];
                } else {
                    $message = "Unknown customer type.";
                    $respSummary = "FAILED";
                    $respCode = 406;
                    $resp = null;
                }
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

        return new UserResponseResource($resp, $respCode, $message, $type);
    }
}
