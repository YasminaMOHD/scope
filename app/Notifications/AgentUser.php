<?php

namespace App\Notifications;

use App\Models\Agents;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AgentUser extends Notification
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
        ->subject(__('Now You are have an account in scope lead system'))
        ->greeting(__('Hello :name',['name'=>$this->agent->fullName]))
        ->from('scopeleadsystem@gmail.com','Scope Lead Sysytem')
        ->line(__("Now You have an account in scope lead system in this email"))
        ->action('Go To Lead System', route('admin.index'));
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
