<?php

namespace PlayRoom\LivewirePlayRoom;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use PlayRoom\LivewirePlayRoom\Concerns\ConfiguresPlayRoom;

class LivewirePlayRoom extends Component
{
    use ConfiguresPlayRoom;

    public function mount(
        string $playRoomLocale = 'en',
        string $playRoomTheme = 'light',
        array $playRoomOptions = [],
        string $playRoomWrapperClass = 'h-[42rem] overflow-hidden rounded-lg border',
        string $playRoomContainerClass = 'h-full w-full',
        bool $playRoomUseDefaultGames = true,
        array $playRoomDefaultGamesConfig = [],
        array $playRoomGameRegistrars = [],
    ): void {
        $this->initializePlayRoom(
            locale: $playRoomLocale,
            theme: $playRoomTheme,
            options: $playRoomOptions,
            wrapperClass: $playRoomWrapperClass,
            containerClass: $playRoomContainerClass,
            useDefaultGames: $playRoomUseDefaultGames,
            defaultGamesConfig: $playRoomDefaultGamesConfig,
            gameRegistrars: $playRoomGameRegistrars,
        );
    }

    public function render(): View
    {
        return view('livewire-play-room::play-room');
    }
}
