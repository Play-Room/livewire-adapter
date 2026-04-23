<?php

namespace PlayRoom\LivewirePlayRoom\Concerns;

use Livewire\Attributes\On;

trait ConfiguresPlayRoom
{
    public string $playRoomLocale = 'en';

    public string $playRoomTheme = 'light';

    public string $playRoomWrapperClass = 'h-[42rem] overflow-hidden rounded-lg border';

    public string $playRoomContainerClass = 'h-full w-full';

    public bool $playRoomUseDefaultGames = true;

    /**
     * @var array<string, array<string, mixed>>
     */
    public array $playRoomDefaultGamesConfig = [];

    /**
     * @var list<string>
     */
    public array $playRoomGameRegistrars = [];

    /**
     * @var array{
     *     browserStartMode?: 'inline'|'modal',
     *     launcher?: array{
     *         mode?: 'inline'|'floating',
     *         position?: string,
     *         panelWidth?: string,
     *         panelHeight?: string,
     *         startOpen?: bool,
     *     },
     *     persistence?: array{enabled: bool, storageKey: string},
     *     draggableModal?: bool,
     *     resizableModal?: array{
     *         enabled: bool,
     *         size?: array{
     *             width?: array{min?: string, base?: string, max?: string},
     *             height?: array{min?: string, base?: string, max?: string},
     *         },
     *     },
     *     localeOptions?: list<array{value: string, label: string}>,
     *     localeMessages?: array<string, array<string, string>>,
     *     showLocaleSwitcher?: bool,
     *     showThemeSwitcher?: bool,
     *     themeColors?: array{primary: string, secondary?: string},
     * }
     */
    protected array $playRoomOptions = [
        'browserStartMode' => 'inline',
        'launcher' => [
            'mode' => 'inline',
        ],
        'persistence' => [
            'enabled' => false,
            'storageKey' => 'playroom:inline-widget',
        ],
        'draggableModal' => false,
        'resizableModal' => [
            'enabled' => true,
            'size' => [
                'width' => ['min' => '420px', 'base' => 'min(940px, 96vw)', 'max' => '98vw'],
                'height' => ['min' => '320px', 'base' => '80vh', 'max' => '96vh'],
            ],
        ],
        'localeOptions' => [
            ['value' => 'en', 'label' => 'English'],
            ['value' => 'sr', 'label' => 'Srpski'],
            ['value' => 'fr', 'label' => 'Francais'],
        ],
        'showLocaleSwitcher' => true,
        'showThemeSwitcher' => true,
        'themeColors' => [
            'primary' => '#0f766e',
            'secondary' => '#475569',
        ],
    ];

    /**
     * @param  array<string, mixed>  $options
     * @param  array<string, array<string, mixed>>  $defaultGamesConfig
     * @param  list<string>  $gameRegistrars
     */
    protected function initializePlayRoom(
        string $locale = 'en',
        string $theme = 'light',
        array $options = [],
        string $wrapperClass = 'h-[42rem] overflow-hidden rounded-lg border',
        string $containerClass = 'h-full w-full',
        bool $useDefaultGames = true,
        array $defaultGamesConfig = [],
        array $gameRegistrars = [],
    ): void {
        $this->locale($locale);
        $this->theme($theme);
        $this->options($options);
        $this->wrapperClass($wrapperClass);
        $this->containerClass($containerClass);
        $this->useDefaultGames($useDefaultGames);
        $this->defaultGamesConfig($defaultGamesConfig);

        foreach ($gameRegistrars as $registrar) {
            $this->registerGameRegistrar($registrar);
        }
    }

    #[On('playroom-locale-changed')]
    public function onLocaleChanged(mixed $payload = null): void
    {
        $locale = $this->extractValue($payload, ['locale', 'value']);

        if (! is_string($locale)) {
            return;
        }

        $locale = trim($locale);

        if ($locale === '') {
            return;
        }

        $this->playRoomLocale = $locale;
    }

    #[On('playroom-theme-changed')]
    public function onThemeChanged(mixed $payload = null): void
    {
        $theme = $this->extractValue($payload, ['theme', 'value']);

        if (! is_string($theme)) {
            return;
        }

        $theme = trim($theme);

        if (! in_array($theme, ['light', 'dark'], true)) {
            return;
        }

        $this->playRoomTheme = $theme;
    }

    public function syncPlayRoomLocale(string $locale): void
    {
        $this->onLocaleChanged(['locale' => $locale]);
    }

    public function syncPlayRoomTheme(string $theme): void
    {
        $this->onThemeChanged(['theme' => $theme]);
    }

    /**
     * @return array<string, mixed>
     */
    public function playRoomOptions(): array
    {
        return array_merge($this->playRoomOptions, [
            'locale' => $this->playRoomLocale,
            'theme' => $this->playRoomTheme,
        ]);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function playRoomDefaultGamesConfig(): array
    {
        return $this->playRoomDefaultGamesConfig;
    }

    /**
     * @return list<string>
     */
    public function playRoomGameRegistrars(): array
    {
        return $this->playRoomGameRegistrars;
    }

    public function wrapperClass(string $wrapperClass): static
    {
        $this->playRoomWrapperClass = $wrapperClass;

        return $this;
    }

    public function containerClass(string $containerClass): static
    {
        $this->playRoomContainerClass = $containerClass;

        return $this;
    }

    public function inline(): static
    {
        $this->browserStartMode('inline');

        return $this->launcher(['mode' => 'inline']);
    }

    public function floating(): static
    {
        $this->browserStartMode('modal');

        return $this->launcher(['mode' => 'floating']);
    }

    public function isFloating(): bool
    {
        return ($this->playRoomOptions['launcher']['mode'] ?? null) === 'floating';
    }

    public function browserStartMode(string $mode): static
    {
        $this->playRoomOptions['browserStartMode'] = $mode;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $launcher
     */
    public function launcher(array $launcher): static
    {
        $this->playRoomOptions['launcher'] = array_replace_recursive(
            $this->playRoomOptions['launcher'] ?? [],
            $launcher,
        );

        return $this;
    }

    /**
     * @param  array{enabled: bool, storageKey: string}  $persistence
     */
    public function persistence(array $persistence): static
    {
        $this->playRoomOptions['persistence'] = array_replace_recursive(
            $this->playRoomOptions['persistence'] ?? [],
            $persistence,
        );

        return $this;
    }

    public function draggableModal(bool $draggable = true): static
    {
        $this->playRoomOptions['draggableModal'] = $draggable;

        return $this;
    }

    /**
     * @param  bool|array<string, mixed>  $config
     */
    public function resizableModal(bool|array $config = true): static
    {
        if (is_bool($config)) {
            $this->playRoomOptions['resizableModal'] = array_replace_recursive(
                $this->playRoomOptions['resizableModal'] ?? [],
                ['enabled' => $config],
            );
        } else {
            $this->playRoomOptions['resizableModal'] = array_replace_recursive(
                $this->playRoomOptions['resizableModal'] ?? [],
                $config,
            );
        }

        return $this;
    }

    public function locale(string $locale): static
    {
        $locale = trim($locale);
        $this->playRoomLocale = $locale !== '' ? $locale : 'en';

        return $this;
    }

    /**
     * @param  list<array{value: string, label: string}>  $options
     */
    public function localeOptions(array $options): static
    {
        $this->playRoomOptions['localeOptions'] = $options;

        return $this;
    }

    /**
     * @param  array<string, array<string, string>>  $messages
     */
    public function localeMessages(array $messages): static
    {
        $this->playRoomOptions['localeMessages'] = $messages;

        return $this;
    }

    public function showLocaleSwitcher(bool $show = true): static
    {
        $this->playRoomOptions['showLocaleSwitcher'] = $show;

        return $this;
    }

    public function theme(string $theme): static
    {
        $this->playRoomTheme = $theme === 'dark' ? 'dark' : 'light';

        return $this;
    }

    public function showThemeSwitcher(bool $show = true): static
    {
        $this->playRoomOptions['showThemeSwitcher'] = $show;

        return $this;
    }

    /**
     * @param  array{primary: string, secondary?: string}  $colors
     */
    public function themeColors(array $colors): static
    {
        $this->playRoomOptions['themeColors'] = array_replace(
            $this->playRoomOptions['themeColors'] ?? [],
            $colors,
        );

        return $this;
    }

    public function useDefaultGames(bool $use = true): static
    {
        $this->playRoomUseDefaultGames = $use;

        return $this;
    }

    /**
     * @param  array<string, array<string, mixed>>  $config
     */
    public function defaultGamesConfig(array $config): static
    {
        $this->playRoomDefaultGamesConfig = array_replace_recursive(
            $this->playRoomDefaultGamesConfig,
            $config,
        );

        return $this;
    }

    public function registerGameRegistrar(string $registrar): static
    {
        if (! in_array($registrar, $this->playRoomGameRegistrars, true)) {
            $this->playRoomGameRegistrars[] = $registrar;
        }

        return $this;
    }

    public function option(string $key, mixed $value): static
    {
        $this->playRoomOptions[$key] = $value;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function options(array $options): static
    {
        $this->playRoomOptions = array_replace_recursive($this->playRoomOptions, $options);

        return $this;
    }

    /**
     * @param  list<string>  $keys
     */
    private function extractValue(mixed $payload, array $keys): mixed
    {
        if (is_string($payload)) {
            return $payload;
        }

        if (! is_array($payload)) {
            return null;
        }

        foreach ($keys as $key) {
            if (array_key_exists($key, $payload)) {
                return $payload[$key];
            }
        }

        if (array_key_exists(0, $payload)) {
            return $payload[0];
        }

        return null;
    }
}
