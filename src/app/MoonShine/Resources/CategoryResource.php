<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

use MoonShine\Enums\PageType;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Category>
 */
class CategoryResource extends ModelResource
{
    protected string $model = Category::class;
    protected string $title = 'Категории';

    protected string $sortColumn = 'title';
    protected string $sortDirection = 'ASC';

    protected bool $createInModal = true;
    protected bool $editInModal = true;
    protected bool $detailInModal = true;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Наименование', 'title')->sortable(),
                BelongsTo::make('Раздел', 'categoryType', 'title', resource: new CategoryTypeResource())->sortable(),
            ]),
        ];
    }

    /**
     * @param Category $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
