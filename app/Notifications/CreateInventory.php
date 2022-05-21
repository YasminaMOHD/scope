<?php

namespace App\Notifications;

use App\Models\Inventory;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CreateInventory extends Notification
{
    use Queueable;
    protected $inventory;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('New Inventory Created'))
                    ->greeting(__('Hello :name',['name'=>$notifiable->name]))
                    ->from('scopeleadsystem@gmail.com','Scope Lead Sysytem')
                    ->line(__(":name has created a new inventory :inventory",['name'=>Auth::user()->name,'inventory'=>$this->inventory->text]))
                    ->action('Show Lead', route('inventory.index'))
                    ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
