<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Company;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\CategoryTypeResource;
use App\MoonShine\Resources\CharacteristicResource;
use App\MoonShine\Resources\CompanyResource;
use App\MoonShine\Resources\DeviceResource;
use App\MoonShine\Resources\DocumentResource;
use App\MoonShine\Resources\EventResource;
use App\MoonShine\Resources\EventTypeResource;
use App\MoonShine\Resources\PresentationResource;
use App\MoonShine\Resources\RequisiteResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;
use MoonShine\Contracts\Resources\ResourceContract;
use MoonShine\Menu\MenuElement;
use MoonShine\Pages\Page;
use Closure;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    /**
     * @return list<ResourceContract>
     */
    protected function resources(): array
    {
        return [
            new CharacteristicResource(),
            new CategoryTypeResource(),
            new EventTypeResource()
        ];
    }

    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [];
    }

    /**
     * @return Closure|list<MenuElement>
     */
    protected function menu(): array
    {
        return [
            MenuGroup::make('Оборудование', [
                MenuItem::make('Оборудка', new DeviceResource()),
                MenuItem::make('Документы', new DocumentResource()),
            ], 'heroicons.outline.cpu-chip'),
            MenuItem::make('Презентации', new PresentationResource(), 'heroicons.outline.presentation-chart-bar'),
            MenuItem::make('Реквизиты', new RequisiteResource(), 'heroicons.outline.building-office-2'),
            MenuItem::make('Календарь', new EventResource(), 'heroicons.outline.calendar-days'),
            MenuGroup::make('Справочник', [
                MenuItem::make('Категории', new CategoryResource(), 'heroicons.outline.tag'),
                MenuItem::make('Компании', new CompanyResource(), 'heroicons.outline.home-modern'),
            ], 'heroicons.outline.light-bulb'),
        ];
    }

    /**
     * @return Closure|array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}
