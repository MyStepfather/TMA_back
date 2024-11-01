<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

use MoonShine\Enums\PageType;
use MoonShine\Fields\Date;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\HasOne;
use MoonShine\Fields\Select;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Event>
 */
class EventResource extends ModelResource
{
    protected string $model = Event::class;

    protected string $title = 'События';

    protected ?PageType $redirectAfterSave = PageType::INDEX;


    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'title')->sortable(),
                Date::make('Дата', 'date')->sortable()->format('d.m'),
                BelongsTo::make('Тип события', 'type', 'title', new EventTypeResource())
                    ->nullable()
                    ->placeholder('Выберите тип если необходимо'),
                Switcher::make('Активно', 'isActive')->default(false)
            ]),
        ];
    }

    /**
     * @param Event $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
