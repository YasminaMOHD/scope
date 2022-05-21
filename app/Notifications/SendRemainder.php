<?php

namespace App\Notifications;

use App\Models\Lead;
use App\Models\User;
use App\Models\Description;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendRemainder extends Notification
{
    use Queueable;
    protected $desc;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Description $desc)
    {
        $this->desc = $desc;
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
                    ->subject(__('Remainder for :lead',['lead'=>$this->desc->lead->name]))
                    ->greeting(__('Hello :name',['name'=>$notifiable->name]))
                    ->from('scopeleadsystem@gmail.com','Scope Lead Sysytem')
                    ->line(__("Today you have Remender Description that : :text to lead :lead",['text'=>$this->desc->text,'lead'=>$this->desc->lead->name]))
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
