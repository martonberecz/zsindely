<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\Kalkulacio;
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailerPHPMailerException;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $items=[];
    public $total=[];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
              
        $this->order = $order; 
        $this->total['anyagSum'] = 0;
        $this->total['dijSum'] = 0;

        $this->orderInitializer($order);    

        
    }

    public function orderInitializer($order){
        $itemIds = [];
        $amount = [];  
       

        foreach ($order as $ord){
            array_push($itemIds,$ord['productId']);    
            $amount[$ord['productId']] = $ord['mennyiseg'];   
        } 
        
        $items = Kalkulacio::whereIn('id', $itemIds)->get();
        foreach($items as $item){
            $anyagSum = $amount[$item['id']]*$item['egysegar'];
            $dijSum = $amount[$item['id']]*$item['dijegysegre'];
            if($item['id'] != 11 && $item['id'] != 12){
                array_push($this->items,[
                                        "id" => $item['id'],
                                        "amount" =>$amount[$item['id']],
                                        "title" => $item['title'],
                                        "egyseg" => $item['egyseg'],
                                        "egysegar"=> $item['egysegar'],
                                        "dijegysegre"=>$item['dijegysegre'],
                                        "anyagSum" => $anyagSum,
                                        "dijSum" => $dijSum
                                        ]);
            }else{
                array_push($this->items,[
                    "id" => $item['id'],
                    "amount" => $amount[$item['id']],
                    "title" => $item['title'],
                    "egyseg" => $item['egyseg'],
                    "egysegar"=> $item['egysegar'],
                    "dijegysegre"=>$item['dijegysegre'],
                    "anyagSum" => $anyagSum,
                    "dijSum" => $amount[$item['id']]
                    ]);
            }
            $this->total['anyagSum'] = $this->total['anyagSum'] + $anyagSum;
            $this->total['dijSum'] = $this->total['dijSum'] + $dijSum;
        }


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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails/orders/neworder');
    }
}
