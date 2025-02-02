<?php 

namespace App\Interfaces;

interface TransactionRepositoryInterface 
{
    public function getTransactionDataFromSession();

    public function storeTransactionDataToSession($data);

    public function storeTransactionBooking($data);

    public function getTransactionBookingCode($code);

    public function getTransacationByCodeEmailPhone($code, $email, $phone);
    
}