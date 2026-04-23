<?php

namespace PlayRoom\LivewirePlayRoom;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewirePlayRoomServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'livewire-play-room');

        Livewire::addComponent(
            name: 'play-room',
            class: LivewirePlayRoom::class,
        );
    }
}