<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Resources\ValidationResponseResource;
use Illuminate\Support\Facades\Config;
use PDO;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Vendor - Service",
 *      description="App Service documentation",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */
class NumberValidationApiController extends Controller
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

    // /**
    //  * Display the specified resource.
    //  */
    // /**
    //  * @OA\Get(
    //  *     path="/api/number-category-validation/{number}",
    //  *     @OA\Response(response="200", description="An example endpoint"),
    //  *      @OA\Parameter(
    //  *         name="number",
    //  *         in="path",
    //  *         description="Number",
    //  *         required=true,
    //  *      ),
    //  * )
    //  */
    public function checkNumberCategory(string $number)
    {
        //
        Log::debug("Request received");
        Log::debug($number);

        Log::debug("Calling procedure");
        // Checking number category. Calling procedure.
        $resp = DB::select('exec kafStart ?',array($number));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        Log::debug($resp[0]->FieldStatus);

        $message = "Error validating number";
        $respSummary = "";
        $respCode = 500;

        try{
            if($resp[0]->FieldStatus == 1){
                $message = "Number validated. Number is a mobilization number.";
                $respSummary = "MOBILIZATION";
                $respCode = 200;
            } else if ($resp[0]->FieldStatus == 0){
                $message = "Number validated. Number is a customer number.";
                $respSummary = "CUSTOMER";
                $respCode = 200;
            }
        } catch(Exception $e){
            Log::error("Error::: ". $e);

            $message = "Error validating number.";
            $respSummary = "ERROR";
        }

        return $respSummary;
        // Log::debug($resp);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/existing-number/{number}",
     *     @OA\Response(response="200", description="An example endpoint"),
     *     @OA\Parameter(
     *         name="number",
     *         in="path",
     *         description="Number",
     *         required=true,
     *      ),
     * )
     */
    public function checkNumberExist(string $number)
    {
        //
        Log::debug("Request received");
        Log::debug($number);

        Log::debug("Calling procedure");
        $client = config('customConfig.clientName');
        Log::debug("Client Name is ");
        Log::debug($client);

        Log::debug("Calling procedure 2");

        $resp = DB::select('exec kafStartCust ?',array($number));

        Log::debug("Response from procedure");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        Log::debug($resp[0]->Status);

        $message = "Error validating number";
        $respSummary = "";
        $respCode = 500;

        try{
            if($resp[0]->Status == 1){
                $message = "CUSTOMER";
                $respSummary = $client;
                $respCode = 200;
            } else if ($resp[0]->Status == 0){
                $message = $this->checkNumberCategory($number);
                $respSummary = $client;
                $respCode = 200;
                if($message=="CUSTOMER"){
                    $respCode = 500;
                    $message = "Customer not found.";
                    $respSummary = "";
                }
                
            }
        } catch(Exception $e){
            Log::error("Error::: ". $e);

            $message = "Error validating number.";
            $respSummary = "ERROR";
        }
        

        return new ValidationResponseResource($respSummary, $respCode, $message, $client);
        // Log::debug($resp);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/name-inquiry/{number}",
     *     @OA\Response(response="200", description="An example endpoint"),
     *     @OA\Parameter(
     *         name="number",
     *         in="path",
     *         description="Number",
     *         required=true,
     *      ),
     * )
     */
    public function nameInquiryAccountNumber(string $number)
    {
        //
        Log::debug("Request received");
        Log::debug($number);

        Log::debug("Calling procedure");
        // Checking if number exists. Calling procedure.

        Log::debug("Calling procedure 2");
        Log::debug($number);

        $client = config('customConfig.clientName');

        $resp = DB::table('BKAccounts')
                ->select('AccountName')
                // ->join('BKAccountProduct','BKAccounts.AccountID','=','BKAccountProduct.AccountID')
                ->where('Mobile', $number)
                ->get();

        Log::debug("Response from query");
        Log::debug($resp);
        // Log::debug(var_dump($resp[0]));
        // Log::debug($resp[0]->Status);

        $message = "Error validating number";
        $respSummary = "";
        $respCode = 500;

        try{
            if($resp->isNotEmpty()){
                $message = "Validation Successful";
                $respSummary = $resp[0]->AccountName;
                $respCode = 200;
            } else {
                $resp = DB::table('BKRelationshipManagers')
                        ->select('RMgrName')
                        // ->join('BKAccountProduct','BKAccounts.AccountID','=','BKAccountProduct.AccountID')
                        ->where('RMgrPhone', $number)
                        ->get();
                try{
                    if($resp->isNotEmpty()){
                        $message = "Validation Successful";
                        $respSummary = $resp[0]->RMgrName;
                        $respCode = 200;
                    } else {
                        $message = "Customer not found.";
                        $respSummary = false;
                    }
                } catch(Exception $e){
                    Log::error("Error::: ". $e);
        
                    $message = "Error validating mobilization number.";
                    $respSummary = "ERROR";
                }
            }
        } catch(Exception $e){
            Log::error("Error::: ". $e);

            $message = "Error validating number.";
            $respSummary = "ERROR";
        }
        

        return new ValidationResponseResource($respSummary, $respCode, $message, $client);
        // Log::debug($resp);
    }
}
