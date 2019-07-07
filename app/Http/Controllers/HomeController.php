<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Http\Request;
use Mail;
use App\Mail\OrderMail;
use PHPMailer\PHPMailer\PHPMailer;

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
        
        $mail = new PHPMailer();

        // Settings
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        
        $mail->Host       = "jflfjoha.loginssl.com"; // SMTP server example
        $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
        $mail->Username   = "info@zsindelyestetofedes.hu"; // SMTP account username example
        $mail->Password   = "Hoember2255";        // SMTP account password example
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        $mail->send();
        return view('home');
    }

    public function emailContent($orderId, $mailTo){

        $order = Order::where('orderId', $orderId)->get();

        
       Mail::to($mailTo)->send(new OrderMail($order));
    }

    public function sendOrder(Request $request){
        //dd($request);
        $orderId = $request->orderId;
        $email = $request->email;
        return $this->emailContent($orderId, $email);
        

    }
}
