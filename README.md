# PlayRoom Livewire Adapter

Laravel package that exposes PlayRoom as a Livewire 4 component.

## Requirements

- PHP 8.3+
- Laravel 13+
- Livewire 4+

## Installation

If you are installing directly from GitHub before the package is published, add the repository to your application's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Play-Room/livewire-adapter.git"
        }
    ]
}
```

Then require the package:

```bash
composer require playroom/livewire-adapter:^1.0
```

Laravel package discovery will register `PlayRoom\\LivewirePlayRoom\\LivewirePlayRoomServiceProvider` automatically.

## Usage

Render the component in Blade:

```blade
<livewire:play-room />
```

Or mount it directly with custom options:

```blade
@livewire(\PlayRoom\LivewirePlayRoom\LivewirePlayRoom::class, [
    'playRoomLocale' => 'en',
    'playRoomTheme' => 'light',
    'playRoomOptions' => [
        'browserStartMode' => 'inline',
        'launcher' => [
            'mode' => 'inline',
        ],
        'themeColors' => [
            'primary' => '#0f766e',
            'secondary' => '#475569',
        ],
    ],
    'playRoomUseDefaultGames' => true,
    'playRoomDefaultGamesConfig' => [],
    'playRoomGameRegistrars' => [],
])
```

## Supported Props

- `playRoomLocale`
- `playRoomTheme`
- `playRoomOptions`
- `playRoomWrapperClass`
- `playRoomContainerClass`
- `playRoomUseDefaultGames`
- `playRoomDefaultGamesConfig`
- `playRoomGameRegistrars`

## Notes

- The package loads the `packages/livewire-play-room/resources/js/playroom-init.js` Vite entry from the consuming Laravel app.
- This adapter expects the underlying PlayRoom Alpine integration to be available in the host application.
- Locale and theme changes stay synchronized between the PlayRoom instance and Livewire.