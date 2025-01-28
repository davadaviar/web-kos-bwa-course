<?php 

namespace App\Interfaces;

interface TransactionRepositoryInterface 
{
    public function getTransactionDataFromSession();

    public function storeTransactionDataToSession($data);

    public function storeTransactionBooking($data);
    
}