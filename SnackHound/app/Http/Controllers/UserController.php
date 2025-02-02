<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order_item;
use App\Models\Review;
use App\Models\Order;
use App\Models\Truck;
use App\Models\Truck_food_category;
use App\Models\Food_category;
use App\Models\Favorite;
use App\Models\Schedule;
use App\Models\View_order_item;
use Session;
use Mail;
use DB;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $redirect = $request->redirect;
        return view('login', ['form' => 'login', 'redirect' => $redirect]);
    }
    public function signup()
    {
        return view('login', ['form' => 'signup']);
    }

    public function loginPost(Request $request)
    {
        // check if all the data was filled
        if (!isset($request->email) || !isset($request->password)) return view("login", ['errorSignIn' => "inform email and password!", 'request' => $request, 'form' => 'login']);
        // retrieve the user
        $user = User::where("email", $request->email)->get();
        // is not exister returns
        if (count($user) == 0) return view("login", ['errorSignIn' => "email not registered!", 'request' => $request, 'form' => 'login']);
        $user = $user[0]; // take the user from the array to be easy to retrieve the columns
        // check password
        if (password_verify($request->password, $user->hash_password)) {
            // if user blocked returns
            if ($user->user_status == 1) return view("login", ['errorSignIn' => "User blocked!", 'request' => $request, 'form' => 'login']);
            // save the user info in the session
            Self::SaveSessionInfo($user);
            // redirect to a new page
            if (isset($request->redirect)) {
                return redirect()->route($request->redirect);
            } else {
                return redirect()->route('index');
            }
        } else {
            // if password not match returns
            return view("login", ['errorSignIn' => "password not match!", 'request' => $request, 'form' => 'login']);
        }
    }

    public function signupPost(Request $request)
    {
        if (!isset($request->userType)) return view("login", ['errorSignUp' => "inform user type!", 'request' => $request, 'form' => 'signup']);
        if (!isset($request->firstName)) return view("login", ['errorSignUp' => "inform first name!", 'request' => $request, 'form' => 'signup']);
        if (!isset($request->lastName)) return view("login", ['errorSignUp' => "inform last name!", 'request' => $request, 'form' => 'signup']);
        if (!isset($request->email)) return view("login", ['errorSignUp' => "inform email!", 'request' => $request, 'form' => 'signup']);
        if (!isset($request->password)) return view("login", ['errorSignUp' => "inform password!", 'request' => $request, 'form' => 'signup']);
        if (!isset($request->confirmPassword)) return view("login", ['errorSignUp' => "inform password confirmation!", 'request' => $request, 'form' => 'signup']);
        if (!isset($request->termsOfUse)) return view("login", ['errorSignUp' => "you must to accept the terms and conditions!", 'request' => $request, 'form' => 'signup']);
        // check email
        $user = User::where("email", $request->email)->get();
        if (count($user) > 0) return view("login", ['errorSignUp' => "email already in use!", 'request' => $request, 'form' => 'signup']);
        // check is only valid user type was selected
        if ($request->userType != 0 && $request->userType != 1) return view("login", ['errorSignIn' => "invalid user type!", 'request' => $request, 'form' => 'signup']);
        // check if passwords match
        if ($request->password != $request->confirmPassword) return view("login", ['errorSignUp' => "passwords don't match!", 'request' => $request, 'form' => 'signup']);

        $user = new User();
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->user_type = $request->userType;
        $user->user_status = 0;
        $user->hash_password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->save();

        // save the user info in the session
        Self::SaveSessionInfo($user);
        // redirect to a new page
        if (isset($request->redirect)) {
            return redirect()->route($request->redirect);
        } else {
            return redirect()->route('index');
        }
    }

    public function forgotPassword() {

        return view('forgot_password');
    }

    public function forgotPasswordPost(Request $request)
    {
        if (!isset($request->email)) return view('forgot_password', ['error' => 'Email must be informed!']);
        $user = User::where('email', $request->email)->get();
        if (count($user) === 0 || count($user) > 1) return view('forgot_password', ['error' => 'Invalid email!']);
        $user = $user[0];
        // send email with a token to reset the password
        $token = base64_encode(random_bytes(64));
        $token = strtr($token, '+/=', '-__');
        $user->remember_token = $token;
        $user->save();
        // send email
        $name = $user->first_name . ' ' . $user->last_name;
        $email = $user->email;
        $data = ['name' => $name, 'url_reset' => 'http://127.0.0.1:8000/reset_password/' . $token];

        Mail::send('mailResetPW', $data, function ($message) use ($name, $email) {
            $message->to($email, $name)->subject('Reset password requested');
            $message->from('snackhound.lux@gmail.com', 'Snack Hound');
        });

        // return view
        return view('sent_password');
    }

    public function resetPassword($token)
    {
        $user = User::where('remember_token', $token)->get();
        if (count($user) === 0 || count($user) > 1) return view('reset_password', ['token' => $token, 'error' => 'Invalid token!']);
        $user = $user[0];
        return view('reset_password', ['email' => $user->email, 'token' => $token]);
    }
    public function resetPasswordPost($token, Request $request)
    {
        if (!isset($request->password)) return view("reset_password", ['error' => "inform password!", 'email' => $request->email, 'token' => $token]);
        if (!isset($request->confirmPassword)) return view("reset_password", ['error' => "inform password confirmation!", 'email' => $request->email, 'token' => $token]);
        // check if passwords match
        if ($request->password != $request->confirmPassword) return view("reset_password", ['error' => "passwords don't match!", 'email' => $request->email, 'token' => $token]);

        $user = User::where('remember_token', $token)->get();
        if (count($user) === 0 || count($user) > 1) return view('reset_password', ['token' => $token, 'email' => $request->email, 'error' => 'Invalid token!']);
        $user = $user[0];
        $user->hash_password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->remember_token = '';
        $user->save();

        return redirect()->route('login');
    }

    public function signout()
    {
        Session::forget('id_user');
        Session::forget('email');
        Session::forget('first_name');
        Session::forget('last_name');
        Session::forget('user_type');
        return redirect()->route('index');
    }

    // Create a public function  to populate the user table
    public function orderHistory(){
        if(!Session::has('id_user')) return redirect()->route('index');
        $orders=Order::where('id_user', Session::get('id_user'))->get();
        foreach ($orders as $order) {
            $order->truckName=Truck::WHERE('id_truck', $order->id_truck)->GET()->first()->name;
            $order->orderSum=DB::select('SELECT SUM(price * quantity) AS total FROM order_item WHERE id_order = ?', [$order->id_order])[0]->total;
        }
        $name=Session::get('first_name');
        return  view('userDashboard', ['orders'=>$orders, 'name'=>$name]);
    }

    private function SaveSessionInfo($user)
    {
        Session::put('id_user', $user->id_user);
        Session::put('email', $user->email);
        Session::put('first_name', $user->first_name);
        Session::put('last_name', $user->last_name);
        Session::put('user_type', $user->user_type);
    }

    public function userFavorites(){
        if(!Session::has('id_user')) return redirect()->route('index');

        $favorites = Favorite::where('id_user', Session::get('id_user'))->get();
        foreach ($favorites as $favorite) {
            $favorite->truck = Truck::where('id_truck', $favorite->id_truck)->first();
            $truckReview = DB::select('SELECT avg(rate) as rate, count(id_review) as numReviews FROM review WHERE id_truck = ? ', [$favorite->id_truck]);
            if(isset($truckReview[0]->rate)) {
                $favorite->avgRate = $truckReview[0]->rate;
                $favorite->reviewsNbr = $truckReview[0]->numReviews;
            } else {
                $favorite->avgRate = 0;
                $favorite->reviewsNbr = 0;
            }
            $favorite->schedules = Schedule::WHERE('id_truck', $favorite->id_truck)->GET();
            $favorite->categories = Truck_food_category::where('id_truck', $favorite->id_truck)->GET();


            for($i = 0; $i < count($favorite->categories); $i++) {
                $favorite->categories[$i]->name = Food_category::where('id_food_category', $favorite->categories[$i]->id_food_category)->first()->name;
            }
        }

        return view('userFavorites', ['favorites' => $favorites]);
    }

    public function userReviews(){
        if(!Session::has('id_user')) return redirect()->route('index');

        $reviews = Review::where('id_user', Session::get('id_user'))->orderby('created_at', 'desc')->get();
        foreach ($reviews as $review) {
            $review->truck = Truck::where('id_truck', $review->id_truck)->first()->name;
        }

        return view('userReviews', ['reviews' => $reviews]);
    }
    // ! User SETINGS

    public function getUserSettings() {

        if(Session::has('id_user')){

            $user = User::find(Session::get('id_user'));

        } else {
            return redirect()->route('index');
        }

        return view('settingsUser', ['user' => $user]);
    }

    public function updateUserSettings(Request $request) {
        if(Session::has('id_user')){

            $user = User::find(Session::get('id_user'));

            $user->first_name = $request->user_first_name;
            $user->last_name = $request->user_last_name;
            $user->telephone = $request->user_phone;
            $user->hash_password = password_hash($request->user_pass, PASSWORD_DEFAULT);

            $user->save();

            return redirect()->route('index');

        } else {
            return redirect()->route('index');
        }
    }

    public function orderDetails($id) {
        if(Session::has('id_user')){

            $user = User::find(Session::get('id_user'));

            $order = Order::find($id);

            if($order->id_user === Session::get('id_user')) {

                $truck = Truck::find($order->id_truck);
                $orderItems = View_order_item::where('id_order', $order->id_order)->get();

                return view('viewOrderDetails', ['user' => $user, 'order' => $order, 'truck' => $truck, 'orderItems' => $orderItems]);

            }  else {
                return redirect()->route('index');
            }
        } else {
            return redirect()->route('index');
        }
    }
}
