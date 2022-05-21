<?php

namespace App\Notifications;

use App\Models\Description;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Lead;

class CreateDiscription extends Notification
{
    use Queueable;
    protected $disc;
    protected $lead;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Lead $lead,Description $disc)
    {
        $this->disc = $disc;
        $this->lead = $lead;
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
    {        return (new MailMessage)
                   ->subject(__('New Discription Created'))
                    ->greeting(__('Hello :name',['name'=>$notifiable->name]))
                    ->from('scopeleadsystem@gmail.com','Scope Lead Sysytem')
                    ->line(__(":name has created a new discription to lead :lead : :desc",['name'=>Auth::user()->name,
                    'lead'=>$this->lead->name,'desc'=>$this->disc->text]))
                    ->action('Show Lead', route('lead.index'))
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
