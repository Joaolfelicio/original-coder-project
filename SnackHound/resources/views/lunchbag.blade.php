@extends('layouts.customerSidebar')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('/css/lunchbag.css') }}" />
<link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600|Roboto+Slab&display=swap" rel="stylesheet">
@endsection

@section('title', 'SnackHound - Lunch Bag')

@section('content')

<main class="background">
    <section class="frame">
        <!-- This header will only be visible on wider screens -->
        <!-- Black Security Heading for the form -->
        <div id="securityHeader">
            <div id="left-aligned">
                <div id="lockContainer">
                    <img id="lock" src="{{URL::asset('assets/ICONS/LUNCHBAG/lock.svg')}}" alt="icon of a padlock in white">
                </div>
                <div id="securityWords">
                    <h2 class="securityWords" id="securityTop">Secure Checkout</h2>
                    <h2 class="securityWords" id="securityBottom">Always Safe & Secure</h2>
                </div>
            </div>
        </div>
        <!-- This header will only be visible on mobile. -->
        <div id="mobileHeader">
            <h1 id="mobileTitle">Checkout</h1>
            <div id="right-aligned">
                <div id="blackLockContainer">
                    <img id="blackLock" src="{{URL::asset('assets/ICONS/LUNCHBAG/lock_black.svg')}}" alt="icon of a padlock in black">
                </div>
                <div id="blackSecurityWords">
                    <h2 class="blackSecurityWords" id="blackSecurityTop">Secure Checkout</h2>
                    <h2 class="blackSecurityWords" id="blackSecurityBottom">Always Safe & Secure</h2>
                </div>
            </div>
        </div>
        <!-- End header -->
        <form action="" method="post">
            <div id="left-content">
                <article id="lunchbagCost" class="panel">
                    @csrf
                    <h1 id="title">Lunchbag</h2>
                        <div id="lunchbagTotal">
                            <div class="rows" id="row1">
                                <p class="labels">Order Total :</p>
                                <p class="labelContent" id="orderTotal">{{number_format($total, 2)}}€</p>
                            </div>
                            <div class="rows" id="row2">
                                <p class="labels">Promo Code :</p>
                                <input class="labelContent" id="code" type="text" placeholder="code">
                            </div>
                            <hr>
                            <div class="rows" id="row3">
                                <p class="labels">Total :</p>
                                <h5 class="labelContent" id="totalAmt">{{number_format($total, 2)}}€</h5>
                            </div>
                        </div>
                </article>
                <!-- This arrticle is hidden on mobile -->
                <article id="lunchbagMailingList" class="panel">
                    <p id="joinMsg">Want to stay up to date? We’d be happy to update you as new trucks or specials become available!</p>
                    <div id="mailCheckboxWide">
                        <p id="checkWide">Sign up to for our mailing list:</p>
                        <input type="checkbox">
                    </div>
                </article>
            </div>
            <article id="lunchbagList" class="panel">
                <ul class="lunchBagitems">
                    <?php foreach ($itemList as $item) { ?>
                    <li>
                        <img class="imgs" src="{{URL::asset('assets/IMGS/Menu/'.$item->id_truck.'/'.$item->image)}}" alt="photo of classic poutine">
                        <div class="qtyCol">
                            <span class="plus">+</span>
                            <div class="qty">
                                {{$item->quantity}}
                            </div>
                            <span class="minus">-</span>
                        </div>
                        <p class="foodName">{{$item->name}}</p>
                        <h3>{{number_format($item->price, 2)}}€</h3>
                        <span class="ex">x</span>
                    </li>
                    <hr>
                    <?php } ?>
                </ul>
                <!-- This checkbox should be hidden on wider screens -->
                <div id="mailCheckbox">
                    <p id="check">Sign up to for our mailing list:</p>
                    <input id="mobileCheckbox" type="checkbox">
                </div>
                <!-- <div id="extraBtns">
                    <button id="apple" class="checkoutButton" type="submit"><img class="btnIcons" src="{{URL::asset('assets/ICONS/LUNCHBAG/apple.svg')}}" alt="the icon for Apple">Apple Pay</button>
                    <button id="paypal" class="checkoutButton" type="submit"><img class="btnIcons" src="{{URL::asset('assets/ICONS/LUNCHBAG/icons8-paypal.svg')}}" alt="the icon for PayPal">PayPal</button>
                </div> -->
                <button id="checkout" class="checkoutButton" type="submit">Checkout</button>
            </article>
        </form>
    </section>
</main>
@endsection

@section('js')
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        // plus button
        let btnList = document.querySelectorAll(".plusBtn");
        for (let btn of btnList) {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                let total = parseInt(e.target.parentElement.querySelector(".itemNumber").innerHTML, 10);
                if (isNaN(total)) total = 0;
                total += 1;
                e.target.parentElement.querySelector(".itemNumber").innerHTML = total;
            });
        }
        // minus button
        btnList = document.querySelectorAll(".minusBtn");
        for (let btn of btnList) {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                let total = parseInt(e.target.parentElement.querySelector(".itemNumber").innerHTML, 10);
                if (isNaN(total)) total = 0;
                total -= 1;
                if (total == 0) total = 1;
                e.target.parentElement.querySelector(".itemNumber").innerHTML = total;
            });
        }
        // add button
        btnList = document.querySelectorAll(".addToBag");
        for (let btn of btnList) {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                let total = parseInt(e.target.parentElement.parentElement.querySelector(".plusMinus").querySelector(".itemNumber").innerHTML, 10);
                if (isNaN(total)) total = 1;
                const lunchBag = {
                    _token: document.querySelector('input[name="_token"]').value,
                    idMenu: e.target.parentElement.querySelector('input[name="idMenu"]').value,
                    quantity: total
                };
                // ajax call
                fetch("/addlunchbag", {
                    method: "PUT",
                    body: JSON.stringify(lunchBag),
                    headers: {
                        "Content-Type": "application/json"
                    }
                });
                // .then(response => {
                //     console.log(response);
                //     response.json().then(function(data) {
                //         console.log(data);
                //     });
                // }).catch(error => console.log(error));
            });
        }
    });
</script>
@endsection
