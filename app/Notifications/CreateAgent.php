<?php

namespace App\Notifications;

use App\Models\Agents;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CreateAgent extends Notification
{
    use Queueable;
    Protected $agent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Agents $agent)
    {
        $this->agent = $agent;
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
                    ->subject(__('New Agent Created'))
                    ->greeting(__('Hello :name',['name'=>$notifiable->name]))
                    ->from('scopeleadsystem@gmail.com','Scope Lead Sysytem')
                    ->line(__(":name has created a new Agent :agent .",['name'=>Auth::user()->name,'agent'=>$this->agent->fullName]))
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
