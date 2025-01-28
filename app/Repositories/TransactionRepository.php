<?php 

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Room;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getTransactionDataFromSession()
    {
        return session()->get('transaction');
    }

    public function storeTransactionDataToSession($data)
    {
        $transaction = session()->get('transaction', []);

        foreach ($data as $key => $value) {
            $transaction[$key] = $value;
        }

        session()->put('transaction', $transaction);

    }

    public function storeTransactionBooking($data)
    {
        $room = Room::find($data['room_id']);

        $data = $this->prepareTransactionData($data, $room);

        $transaction = Transaction::create($data);

        session()->forget('transaction');

        return $transaction;

    }

    private function prepareTransactionData($data, $room)
    {
        $data['code'] = $this->generateTransactionCode();
        $data['payment_status'] = 'Pending';
        $data['transaction_date'] = now();

        $total = $this->calculateTotalAmount($room->price_per_month, $data['duration']);
        $data['total_amount'] = $this->calculatePaymentAmount($total, $data['payment_method']);

        return $data;

    }

    private function generateTransactionCode()
    {
        return 'KOSLUR' . rand(100000, 999999);
    }

    private function calculateTotalAmount($pricePerMonth, $duration)
    {
        $subtotal = $pricePerMonth * $duration;
        $tax = $subtotal * 0.12;
        $insurance = $subtotal * 0.01;
        $grandTotal = $subtotal + $tax + $insurance;

        return $grandTotal;
    }

    private function calculatePaymentAmount($total, $paymentMethod)
    {
        return $paymentMethod === 'full_payment' ? $total : $total * 0.3;
    }

}