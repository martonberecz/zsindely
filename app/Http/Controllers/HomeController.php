<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Http\Request;
use Mail;
use App\Mail\OrderMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function calc()
    {
        return view('calculator');
    }

    public function articleView(){
        return view('article');
    }

    public function articles(){
        return view('articles');
    }

    public function contact(){
        return view('contact');
    }

    public function emailContent($orderId, $mailTo){

        $order = Order::where('orderId', $orderId)->get();

        
      // Mail::to($mailTo)->send(new OrderMail($order));
    }

    public function sendOrder(Request $request){
        //dd($request);
        $orderId = $request->orderId;
        $email = $request->email;
        return $this->emailContent($orderId, $email);
        

    }
}
