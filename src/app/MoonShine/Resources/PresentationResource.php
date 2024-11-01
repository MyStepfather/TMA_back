<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presentation;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use MoonShine\Components\Link;
use MoonShine\Enums\PageType;
use MoonShine\Fields\File;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Presentation>
 */
class PresentationResource extends ModelResource
{
    protected string $model = Presentation::class;

    protected string $title = 'Презентации';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected string $sortColumn = 'title';
    protected string $sortDirection = 'ASC';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'title')->sortable(),
                File::make('Файл презентации (pdf)', 'path')
                    ->removable()
                    ->dir('/presentations')
                    ->customName(fn(UploadedFile $file) => Str::random(10) . '.' . $file->extension())
                ,
                BelongsTo::make('Компания', 'company', 'name'),
                BelongsToMany::make('Категории', 'categories', 'title')
                    ->selectMode()
                    ->placeholder('Выберите категории')
                    ->inLine(
                        separator: ' ',
                        badge: true,
                        link: fn(Category $category, $value, $field) => Link::make(
                            (new CategoryResource())->detailPageUrl($category),
                            $value
                        )
                    )
                    ->valuesQuery(
                        fn(Builder $query) =>
                        $query->whereHas('categoryType', function ($query) {
                            return $query->where('type', 'presentations');
                        })
                    ),
            ]),
        ];
    }

    /**
     * @param Presentation $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
