<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryType;

use MoonShine\Enums\PageType;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<CategoryType>
 */
class CategoryTypeResource extends ModelResource
{
    protected string $model = CategoryType::class;

    protected string $title = 'CategoryTypes';

    protected ?PageType $redirectAfterSave = PageType::INDEX;


    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Тип категории', 'type')
            ]),
        ];
    }

    /**
     * @param CategoryType $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
