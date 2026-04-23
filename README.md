# PlayRoom Livewire Adapter

Laravel package that exposes PlayRoom as a Livewire 4 component.

## Requirements

- PHP 8.3+
- Laravel 13+
- Livewire 4+

## Installation

Require the package:

```bash
composer require playroom/livewire-adapter
```

Laravel package discovery will register `PlayRoom\\LivewirePlayRoom\\LivewirePlayRoomServiceProvider` automatically.

Add the package JavaScript entry to your application's `vite.config.js` inputs so Laravel Vite includes it in the manifest:

```js
laravel({
    input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'vendor/playroom/livewire-adapter/resources/js/playroom-init.js',
    ],
    refresh: true,
})
```

## Usage

Render the component in Blade:

```php
<livewire:play-room />
```

Or mount it directly with custom options:

```php
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

- The package loads the `vendor/playroom/livewire-adapter/resources/js/playroom-init.js` Vite entry from the consuming Laravel app.
- The consuming Laravel app must add that same path to the Vite `input` array, otherwise the asset will not exist in `public/build/manifest.json`.
- This adapter expects the underlying PlayRoom Alpine integration to be available in the host application.
- Locale and theme changes stay synchronized between the PlayRoom instance and Livewire.