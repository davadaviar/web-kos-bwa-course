<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerInfoStoreRequest;
use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct
    (
        BoardingHouseRepositoryInterface $boardingHouseRepository,
        TransactionRepositoryInterface $transactionRepository
    )
    {
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function booking(Request $request, $slug)
    {
        $this->transactionRepository->storeTransactionDataToSession($request->all());

        return redirect()->route('booking.information', $slug);
    }

    public function bookingInformation($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.information', compact('transaction','boardingHouse', 'room'));

    }

    public function bookingInformationStore(CustomerInfoStoreRequest $request, $slug)
    {
        $data = $request->validated();

        $this->transactionRepository->storeTransactionDataToSession($data);

        dd($this->transactionRepository->getTransactionDataFromSession());
    }

    public function checkBooking()
    {
        return view('pages.booking');
    }
}
