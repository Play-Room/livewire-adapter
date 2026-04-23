@php
    $playRoomAlpineId = 'playRoom_' . str_replace('-', '_', $this->getId());
@endphp

@once
    @vite('packages/livewire-play-room/resources/js/playroom-init.js')
@endonce

<div x-data="{{ $playRoomAlpineId }}" class="{{ $this->playRoomWrapperClass }}">
    <div wire:ignore x-ref="container" class="{{ $this->playRoomContainerClass }}"></div>
</div>

@script
<script>
    Alpine.data('{{ $playRoomAlpineId }}', () => ({
        room: null,

        init() {
            this.room = this.$playroom(@js($this->playRoomOptions()));

            @if ($this->playRoomUseDefaultGames)
            this.room.registerDefaultGames({ config: @js($this->playRoomDefaultGamesConfig()) });
            @endif

            @foreach ($this->playRoomGameRegistrars() as $registrar)
            if (typeof window[@js($registrar)] === 'function') {
                window[@js($registrar)](this.room);
            }
            @endforeach

            this.room.renderGamePicker(this.$refs.container);

            this.room.subscribeLocale(locale => $wire.syncPlayRoomLocale(locale));
            this.room.subscribeTheme(theme => $wire.syncPlayRoomTheme(theme));

            $wire.$watch('playRoomLocale', value => {
                if (this.room.getLocale() !== value) {
                    this.room.setLocale(value);
                }
            });

            $wire.$watch('playRoomTheme', value => {
                if (this.room.getTheme() !== value) {
                    this.room.setTheme(value);
                }
            });

            const observer = new MutationObserver(() => {
                const domTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';

                if (this.room.getTheme() !== domTheme) {
                    this.room.setTheme(domTheme);
                }
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class'],
            });
        },
    }));
</script>
@endscript