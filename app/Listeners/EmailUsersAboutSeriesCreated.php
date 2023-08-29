<?php

namespace App\Listeners;

use App\Events\SeriesCreated as SeriesCreatedEvent;
use App\Models\User;
use App\Mail\SeriesCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailUsersAboutSeriesCreated implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SeriesCreatedEvent $event): void
    {
        $userList = User::all();

        foreach ($userList as $index => $user) {
            $email = new SeriesCreated(
                $event->seriesNome,
                $event->seriesId,
                $event->seriesSeasonsQty,
                $event->seriesEpisodesPerSeason
            );
            $when = now()->addSeconds($index *5);
            Mail::to($user)->later($when, $email);
        }
    }
}
