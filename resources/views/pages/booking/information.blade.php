@extends('layouts.app')

@section('content')
    
    {{-- background --}}
    <div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]"></div>
    {{-- background --}}

    {{-- topnav --}}
    <div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
        <a href="{{ route('kos.rooms', $boardingHouse->slug) }}"
            class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
            <img src="{{ asset ('assets/images/icons/arrow-left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
        </a>
        <p class="font-semibold">Customer Information</p>
        <div class="dummy-btn w-12"></div>
    </div>
    {{-- topnav --}}

    {{-- header --}}
    <div id="Header" class="relative flex items-center justify-between gap-2 px-5 mt-[18px]">
        <div class="flex flex-col w-full rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white">
            <div class="flex gap-4">
                <div class="flex w-[120px] h-[132px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="{{ asset ('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover" alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <p class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[54px]">{{ $boardingHouse->name }}</p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset ('assets/images/icons/location.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $boardingHouse->city->name }}</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset ('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <p class="text-sm text-ngekos-grey">In {{ $boardingHouse->category->name }}</p>
                    </div>
                </div>
            </div>
            <hr class="border-[#F1F2F6]">
            <div class="flex gap-4">
                <div class="flex w-[120px] h-[156px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="{{ asset ('assets/images/thumbnails/room-1.png') }}" class="w-full h-full object-cover" alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <p class="font-semibold text-lg leading-[27px]">{{ $room->name }}</p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset ('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $room->capacity }} People</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset ('assets/images/icons/3dcube.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $room->square_feet }} sqft flat</p>
                    </div>
                    <hr class="border-[#F1F2F6]">
                    <p class="font-semibold text-lg text-ngekos-orange">IDR {{ number_format($room->price_per_month, 0, '.', '.') }}<span
                            class="text-sm text-ngekos-grey font-normal">/Month</span></p>
                </div>
            </div>
        </div>
    </div>
    {{-- header --}}

    {{-- form --}}
    <form 
        action="{{ route('booking.information.store', $boardingHouse->slug) }}" 
        class="relative flex flex-col gap-6 mt-5 pt-5 bg-[#F5F6F8]"
        method="POST"
    >

        @csrf
        <div class="flex flex-col gap-[6px] px-5">
            <h1 class="font-semibold text-lg">Your Informations</h1>
            <p class="text-sm text-ngekos-grey">Fill the fields below with your valid data</p>
        </div>
        <div id="InputContainer" class="flex flex-col gap-[18px]">
            <div class="flex flex-col w-full gap-2 px-5">
                <p class="font-semibold">Complete Name</p>
                <label
                    class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300 @error('name') border-red-500 @enderror">
                    <img src="{{ asset ('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name') }}"
                        class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                        placeholder="Write your name"
                    >
                </label>

                @error('name')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col w-full gap-2 px-5">
                <p class="font-semibold">Email Address</p>
                <label
                    class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300 @error('email') border-red-500 @enderror">
                    <img src="{{ asset ('assets/images/icons/sms.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                        placeholder="Write your email"
                    >
                </label>

                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col w-full gap-2 px-5">
                <p class="font-semibold">Phone No</p>
                <label
                    class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300 @error('phone') border-red-500 @enderror">
                    <img src="{{ asset ('assets/images/icons/call.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone"
                        value="{{ old('phone') }}"
                        class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                        placeholder="Write your phone"
                    >
                </label>
            </div>

            @error('phone')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <div class="flex items-center justify-between px-5">
                <p class="font-semibold">Duration in Month</p>
                <div class="relative flex items-center gap-[10px] w-fit">
                    <button type="button" id="Minus" class="w-12 h-12 flex-shrink-0">
                        <img src="{{ asset ('assets/images/icons/minus.svg') }}" alt="icon">
                    </button>
                    <input id="Duration" type="text" value="1" name="duration"
                        class="appearance-none outline-none !bg-transparent w-[42px] text-center font-semibold text-[22px] leading-[33px]"
                        inputmode="numeric" pattern="[0-9]*">
                    <button type="button" id="Plus" class="w-12 h-12 flex-shrink-0">
                        <img src="{{ asset ('assets/images/icons/plus.svg') }}" alt="icon">
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p class="font-semibold px-5">Moving Date</p>
                <div class="swiper w-full overflow-x-hidden">
                    <div class="swiper-wrapper select-dates">
                    </div>
                </div>
            </div>
        </div>
        <div id="BottomNav" class="relative flex w-full h-[132px] shrink-0 bg-white">
            <div class="fixed bottom-5 w-full max-w-[640px] px-5 z-10">
                <div class="flex items-center justify-between rounded-[40px] py-4 px-6 bg-ngekos-black">
                    <div class="flex flex-col gap-[2px]">
                        <p id="price" class="font-bold text-xl leading-[30px] text-white">
                            <!-- price dari js -->
                        </p>
                        <span class="text-sm text-white">Grand Total</span>
                    </div>
                    <button type="submit"
                        class="flex shrink-0 rounded-full py-[14px] px-5 bg-ngekos-orange font-bold text-white">Book
                        Now</button>
                </div>
            </div>
        </div>
    </form>
    {{-- form --}}
@endsection

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const assetBaseUrl = "{{ asset('') }}"
    </script>
    <script>
        const defaultPrice = {{ $room->price_per_month }};
    </script>
    <script src="{{ asset('assets/js/cust-info.js') }}"></script>
@endpush