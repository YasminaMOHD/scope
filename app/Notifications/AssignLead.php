<?php

namespace App\Notifications;

use App\Models\Lead;
use App\Models\Agents;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AssignLead extends Notification
{
    use Queueable;
    protected $lead;
    protected $agent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Lead $lead, Agents $agent)
    {
        $this->lead = $lead;
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
        ->subject('Assign Lead')
        ->greeting(__('Hello :name',['name'=>$notifiable->name]))
        ->from('scopeleadsystem@gmail.com','Scope Lead Sysytem')
        ->line(__(":name has Assigned  lead :lead to :agent",['name'=>Auth::user()->name ,
        'lead'=>$this->lead->name,'agent'=>$this->agent->fullName]))
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
