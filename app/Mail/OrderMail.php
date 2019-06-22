<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\Kalkulacio;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $items=[];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $itemIds = [];
        $amount = [];        
        $this->order = $order;

        foreach ($order as $ord){
            array_push($itemIds,$ord['productId']);    
            $amount[$ord['productId']] = $ord['mennyiseg'];   
        } 
        //var_dump($itemIds);
        //dd();
        $items = Kalkulacio::whereIn('id', $itemIds)->get();

        foreach($items as $item){
            $anyagSum = $amount[$item['id']]*$item['egysegar'];
            $dijSum = $amount[$item['id']]*$item['dijegysegre'];
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
        }

        // var_dump($this->items);
        // dd();
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders.neworder');
    }
}
