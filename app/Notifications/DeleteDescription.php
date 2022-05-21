<?php

namespace App\Notifications;

use App\Models\Lead;
use App\Models\Description;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeleteDescription extends Notification
{
    use Queueable;
    protected $description;
    protected $lead;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Lead $lead, Description $description)
    {
        $this->lead = $lead;
        $this->description = $description;
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
        ->subject(__('Deleted Description'))
        ->greeting(__('Hello :name',['name'=>$notifiable->name]))
        ->from('scopeleadsystem@gmail.com','Scope Lead Sysytem')
        ->line(__(":name has Deleted an Lead :lead description :desc",['name'=>Auth::user()->name,'lead'=>$this->Lead->name,'desc'=>$this->description->text]))
        ->action('Show Lead', route('admin.agent.index'))
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
