<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::asset('css/sidebar.css') }}" />
    @yield('css')

</head>

<body>


<div class="sidebar">
    <div class='side-mobile-pic'></div>

    <div class="sidebar-logo">
        <a href="/"><img class='sidebar-logo-img' src="{{URL::asset('assets/ICONS/Logo_White.svg')}}" alt="Logo of SnackHound."></a>
    </div>


    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="https://img.icons8.com/android/24/000000/menu.png">
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

            <div> <a href='/truck' class='dropdown-item'> <img class='dropdown-icon' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/orders_black.svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/orders_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/orders_black.svg')}}'" alt="FIX THE ALT."> <span class="marginLeft">Orders</span> </a> </div>

            <div> <a href='/truck/menu' class='dropdown-item'> <img class='dropdown-icon' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/menu_black.svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/menu_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/menu_black.svg')}}'" alt="FIX THE ALT."> <span class="marginLeft">Menu</span> </a> </div>

            <div> <a href='/truck/schedule' class='dropdown-item'> <img class='dropdown-icon' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/schedule_black.svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/schedule_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/schedule_black.svg')}}'" alt="FIX THE ALT."> <span class="marginLeft"> Schedule </span> </a> </div>

            <div> <a href='/truck/settings' class='dropdown-item'> <img class='dropdown-icon' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/settings_black.svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/settings_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/settings_black.svg')}}'" alt="FIX THE ALT."> <span class="marginLeft">Truck Settings</span> </a> </div>

            <div class='dropdown-sign'> <a href="/signout" class='dropdown-item'> SIGN OUT </a> </div>

        </div>
    </div>

    <div class='sidebar-items'>

        <ul>
            <li><a href="/truck"> <img class='sidebar-items-img' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/icons8-mobile-shopping.svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/orders_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/icons8-mobile-shopping.svg')}}'"> Orders </a></li>
            <li><a href="/truck/menu"> <img class='sidebar-items-img' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/surface347926.svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/menu_new_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/surface347926.svg')}}'"> Menu </a></li>
            <li><a href="/truck/schedule"> <img class='sidebar-items-img' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/icons8-schedule.svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/schedule_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/Truck%20Owner/icons8-schedule.svg')}}'"> Schedule </a></li>
            <li><a href="/truck/settings"> <img class='sidebar-items-img' src="{{URL::asset('assets/ICONS/Sidebar%20Navigation/icons8-settings (1).svg')}}" onmousemove="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/settings_yellow.svg')}}'" onmouseout="src='{{URL::asset('assets/ICONS/Sidebar%20Navigation/icons8-settings (1).svg')}}'">Truck Settings </a></li>
        </ul>

    </div>
</div>
<div>
        <!-- Content -->
        @yield('content')

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    @yield('js')
</body>

@include('layouts.footer')

</html>
