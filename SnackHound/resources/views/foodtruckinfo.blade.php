@extends('layouts.customerSidebar')

@section('css')
<link rel="stylesheet" href="{{URL::asset('/css/foodtruckinfo.css')}}" />
{{-- Source for FONT : https://fonts.google.com --}}
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400&display=swap" rel="stylesheet">
{{-- Source for FONT : https://fonts.google.com --}}
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400&display=swap" rel="stylesheet">
{{-- Source for FONT : https://fonts.google.com --}}
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">

@endsection

@section('title', 'SnackHound - Food Truck Information')

@section('content')
<div class="background">
    <header>
        <!-- principal div header start here -->

        {{-- In the style of the div below i've put an effect which is  degrade --}}
        <div class="backgrounddiv" name="backgrounddiv" style="background-image:linear-gradient(to bottom, rgba(0, 0, 0, 0.52), rgba(0, 0, 20, 0.73)), url('/assets/IMGS/Food Trucks/BLURRED/{{$foodtruck->image}}');">

            <div name="truckinfo" class="truckinfo">
                <input type="hidden" id="idTruck" value="{{$foodtruck->id_truck}}"> {{-- In the value we are looking for the id truck in the databse --}}
                <h1>{{$foodtruck->name}}</h1> {{-- Here we are looking to take the name of the foodtruck from the databse and show it on the website --}}
                <div class="favstar">
                    <div class="reviewDiv">
                        <?php

                        // We are looking to take the rate of the foodtruck from the database and show it on the website
                        for ($i = 1; $i <= $avg_rate; $i++) { ?>
                        <img class="starlogo" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-filled.svg')}}" alt="">
                        <?php }
                        $blankStars = 5 - $avg_rate;
                        for ($i = 1; $i <= $blankStars; $i++) {
                            ?>
                        <img class="starlogo" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-blank.svg')}}" alt="">
                        <?php } ?>
                        {{-- we count how many reviews the foodtruck have and we display it on the info --}}
                        <p class="reviewNbr">{{COUNT($reviews)}}</p>
                    </div>
                    <?php if (Session::has('id_user')) {
                        // If the foodtruck is on favorite the heart will be colored in red and if not it will be transparent
                        if ($favorite) { ?>
                    <img class="heartlogo" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-heart-outline.svg')}}" alt="">
                    <?php } else { ?>
                    <img class="heartlogo" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-heart-blank.svg')}}" alt="">
                    <?php }
                    } ?>
                </div>

                <hr class="separator">

                <div class="truckcontact">
                    <div class="contactlist">
                        <div class="contactnumber" name="contactnumber">
                            <img name="phoneicon" class="phoneicon" src="{{URL::asset('assets/ICONS/icons8-cell-phone (1).svg')}}" alt="">
                            <p class="phoneInfo" name="phoneInfo">{{$foodtruck->telephone}}</p> {{-- We are looking to take the phone number of the foodtruck from the database and display it--}}
                        </div>
                        <div class="contactweb" name="contactweb">
                            <img name="webicon" class="webicon" src="{{URL::asset('assets/ICONS/icons8-internet (1).svg')}}" alt="">
                            <p class="webInfo" name="webInfo">{{$foodtruck->website}}</p> {{-- Here we are looking to take the official website of the foodtruck from the database and displax it--}}
                        </div>
                    </div>
                    <div class="truckposition" name="truckposition">
                        <img class="positionImg" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-marker.svg')}}" alt="">
                        <p class="positionInfo" name="positionInfo">Position</p>
                    </div>
                </div>

                <hr class="separator">

                <div class="hourinfo">
                    <table class="scheduleTable">
                        <?php

                        // We display the schedule fo the foodtruck
                        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        foreach ($schedules as $schedule) { ?>
                        <div class="row">
                            <p class="daySchedule"></p>
                        </div>

                        <tr>
                            <td class="daySchedule"><?= $weekdays[$schedule->weekday] ?>:</td>
                            <td class="daySchedule"><?= $schedule->start_time . ' - ' . $schedule->end_time ?></td>
                            <td class="daySchedule">City: {{$schedule->city}}</td>
                        </tr>

                        <?php
                        }

                        ?>
                    </table>
                </div>
                <br>
                <div name="scrollicon" class="scrollicon">
                    <img class="scrollImg" src="{{URL::asset('assets/IMGS/ScrollDown.svg')}}" alt="">
                </div>

            </div>

        </div>
        <!-- <img name="backgroundimg" class="backgroundimg" src="frittenwerk.png" alt=""> -->
        <!-- principal div HEADER end here -->

    </header>

    <main class='info-main'>
        <?php
        // We display all the item of the footruck
        foreach ($menus as $menu) { ?>
        @csrf
        <div class="itemCard">
            <img class="itemImg" src="{{URL::asset('assets/IMGS/Menu/'.$menu->id_truck.'/'.$menu->image)}}" alt="Avatar" style="width:100%"> {{--display the image of the item--}}
            <div class="container">
                <div class="iteminfo" name="iteminfo">
                    <h2 name="itemname" class="itemName">{{$menu->name}}</h2> {{--display the name of the item--}}
                    <h2 class="itemPrice">{{number_format($menu->price, 2)}}€</h2> {{--display the price of the item--}}
                </div>

                <hr class="itemseparator">

                {{--Button + and - of the card to add or remove item from the launch bag--}}
                <section class="itemform" name="itemform">
                    <div class="plusMinus" name="plusminus">
                        <input class="plusBtn" name="plusBtn" type="button" value="+">
                        <p class="itemNumber">1</p>
                        <input class="minusBtn" name="minusBtn" type="button" value="-">
                    </div>
                    <div class="addBtn" name="addBtn">
                        <input type="hidden" name="idMenu" value="{{$menu->id_menu}}">
                        <input name="addToBag" class="addToBag" type="button" value="Add" data-toggle="modal" data-target="#myModal">

                    </div>
                </section>

                {{-- MODAL --}}
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Your lunchbag</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            Added to your lunchbag.
                        </div>

                        </div>
                    </div>
                </div>






            </div>
        </div>
        <?php } ?>
    </main>
    {{-- REVIEW --}}
    <section class="mainReview">
        <div class="reviewBox">
            <div class="scrollBoxReview">
                <h1>REVIEWS</h1>
                <div class="reviewList">
                    <?php
                    // starting a foreach to display information in the review table
                    foreach ($reviews as $review) {
                        ?>
                    <div class="formReview">
                        <div class="userInfo">
                            <p class="userNameInBox">{{$review->userName}}</p> {{--display the User Name of the user that put the comment --}}
                            <p><?php
                                    for ($i = 1; $i <= $review->rate; $i++) { ?> {{--display the rate of the user from 1 to 5 stars--}}
                                <img class="ratingStar" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-filled.svg')}}" alt="">
                                <?php }
                                    $blankStars = 5 - $review->rate;
                                    for ($i = 1; $i <= $blankStars; $i++) {
                                        ?>
                                <img class="ratingStar" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-blank.svg')}}" alt="">
                                <?php } ?>
                            </p>
                            <p class="dateReview">({{$review->created_at}}) :</p> {{--display the date when the review has been sended--}}
                        </div>
                        <div class="userReview">
                            <p>{{$review->comment}}</p> {{--display the review of the user--}}
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>

            {{--User can leave a review only when they are Loged In . If they are not loged in so these part will be hidden--}}
            <?php if (Session::has('id_user')) { ?>
            <div class="review">
                <div class="leavReview">
                    <h1>Leave A Review</h1>
                    <div class="formbox">
                        <form id="formReview" class="reviewForm" action="" method="POST">
                            <h3>Comments:</h3>
                            <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                            <input type="hidden" name="rate" id="rate" value="0">
                            <div id="divStar">
                                <img class="rateStarLogo" id="star1" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-blank.svg')}}" alt="">
                                <img class="rateStarLogo" id="star2" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-blank.svg')}}" alt="">
                                <img class="rateStarLogo" id="star3" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-blank.svg')}}" alt="">
                                <img class="rateStarLogo" id="star4" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-blank.svg')}}" alt="">
                                <img class="rateStarLogo" id="star5" src="{{URL::asset('assets/ICONS/Food Truck Cards/icons8-star-blank.svg')}}" alt="">
                            </div>
                            <div class="subReview">
                                <input type="submit" id="insertReview" value="Post">
                                <span class="error" id="errorReview"></span>
                                <span class="success" id="successReview"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </section>

    {{-- END OF REVIEW --}}
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    $(function() {

        $('.addToBag').click(function() {
            setTimeout(function(){
                $('#myModal').click();
            }, 1000);

        })


    })
    function updateRate(nbr) {
        if (document.querySelector("#rate").value == nbr) nbr = 0;
        document.querySelector("#rate").value = nbr;
        for (let i = 1; i <= 5; i++) {
            if (i <= nbr) {
                document.querySelector("#star" + i).src = document.querySelector("#star" + i).src.replace("star-blank", "star-filled");
            } else {
                document.querySelector("#star" + i).src = document.querySelector("#star" + i).src.replace("star-filled", "star-blank");
            }
        }

    }

    window.addEventListener('DOMContentLoaded', (event) => {
        // comment/review
        const starlst = document.querySelectorAll(".rateStarLogo");
        for (let star of starlst) {
            star.addEventListener("click", (e) => {
                updateRate(e.target.id.substr(4, 1));
            })
        }
        let frmReview = document.querySelector("#formReview");
        if (frmReview != null) {
            frmReview.addEventListener("submit", (e) => {
                e.preventDefault();
                document.querySelector('#errorReview').innerHTML = "";
                if (document.querySelector('#comment').value == "") {
                    document.querySelector('#errorReview').innerHTML = "Leave a comment!";
                } else {
                    const paramReview = {
                        _token: document.querySelector('input[name="_token"]').value,
                        idTruck: document.querySelector("#idTruck").value,
                        rate: document.querySelector('#rate').value,
                        comment: document.querySelector('#comment').value
                    };
                    fetch("/addReview", {
                            method: "POST",
                            body: JSON.stringify(paramReview),
                            headers: {
                                "Content-Type": "application/json"
                            }
                        })
                        .then(response => {
                            document.querySelector('#comment').value = "";
                            updateRate(0);
                            document.querySelector('#successReview').innerHTML = "Review inserted!";
                        });
                }
            });
        }
        // favorite
        let btnFavorite = document.querySelector(".heartlogo");
        if (btnFavorite != null) {
            btnFavorite.addEventListener("click", (e) => {
                const paramFavorite = {
                    _token: document.querySelector('input[name="_token"]').value
                };
                const urlFavorite = "/foodtruck/favorite/" + document.querySelector("#idTruck").value;
                fetch(urlFavorite, {
                        method: "POST",
                        body: JSON.stringify(paramFavorite),
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => {
                        response.json().then(function(data) {
                            if (data.favorite) {
                                btnFavorite.src = btnFavorite.src.replace("icons8-heart-blank.svg", "icons8-heart-outline.svg");
                            } else {
                                btnFavorite.src = btnFavorite.src.replace("icons8-heart-outline.svg", "icons8-heart-blank.svg");
                            }
                        });
                    });
            });
        }

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
