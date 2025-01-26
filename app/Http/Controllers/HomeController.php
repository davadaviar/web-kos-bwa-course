<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private CityRepositoryInterface $cityRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;

    public function __construct
    (
        CityRepositoryInterface $cityRepository,
        CategoryRepositoryInterface $categoryRepository,
        BoardingHouseRepositoryInterface $boardingHouseRepository
    )

    {
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $popularBoardingHouse = $this->boardingHouseRepository->getPopularBoardingHouses();
        $cities = $this->cityRepository->getAllCities();
        $allBoardingHouse = $this->boardingHouseRepository->getAllBoardingHouses();

        return view('pages.home', compact('categories', 'popularBoardingHouse', 'cities', 'allBoardingHouse'));
    }
}
