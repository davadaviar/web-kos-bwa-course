<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class MidtransController extends Controller
{
    
    public function callback(Request $request)
    {

        Log::info('Midtrans Callback Received:', $request->all());

        $serverKey = config('midtrans.serverKey');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey );

        if($hashedKey !== $request->signature_key)
        {
            Log::error('Invalid Signature Key for Order: ' . $request->order_id);
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $transaction = Transaction::where('code', $orderId)->first();

        if(!$transaction)
        {
            Log::error("Transaction not found for order_id: " . $orderId);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));

        $message = 
            "Hello " . $transaction->name . "!" . PHP_EOL . PHP_EOL .
            "Your payment has been successfully processed with transaction code " . $transaction->code . "." . PHP_EOL . PHP_EOL .
            "Total payment: " . $transaction->total_amount . PHP_EOL . PHP_EOL .
            "Address: " . $transaction->boardingHouse->address . PHP_EOL . PHP_EOL .
            "Start date: " . date('d-m-Y', strtotime($transaction->start_date)) . PHP_EOL . PHP_EOL .
            "Thank you for using our service.";


        switch ($transactionStatus) {
            case 'capture':
                if($request->payment_type == 'bank_transfer')
                {
                    if($request->fraud_status == 'challenge')
                    {
                        $transaction->update(['payment_status' => 'pending']);
                    } 
                    
                    else 

                    {
                        $transaction->update(['payment_status' => 'success']);
                    }

                }
                break;

            case 'settlement':
                $transaction->update(['payment_status' => 'success']);

                try {

                    $twilio->messages->create(
                        "whatsapp:+" . $transaction->phone_number,
                        array(
                            "from" => env('TWILIO_PHONE_NUMBER'),
                            "body" => $message
                        )
                    );

                } catch (\Throwable $e) {
                    
                    logger("Twilio Error: " . $e->getMessage());
                    
                }

                break;

            case 'pending':
                $transaction->update(['payment_status' => 'pending']);
                break;

            case 'deny':
                $transaction->update(['payment_status' => 'failed']);
                break;

            case 'expire':
                $transaction->update(['payment_status' => 'expired']);
                break;
            
            case 'cancel':
                $transaction->update(['payment_status' => 'canceled']);
                break;
                
            default:
                $transaction->update(['payment_status' => 'unknown']);
                break;

        }

        
        Log::info("Transaction Updated: Order ID - {$orderId}, Status - {$transactionStatus}");
        return response()->json(['message' => 'Callback received successfully']);

    }

}
