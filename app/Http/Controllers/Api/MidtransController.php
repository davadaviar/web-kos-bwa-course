<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
