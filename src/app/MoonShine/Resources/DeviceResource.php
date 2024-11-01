<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Category;
use App\Models\Characteristic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use MoonShine\Components\Link;
use MoonShine\Decorations\Column;
use MoonShine\Enums\PageType;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Relationships\HasOne;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Device>
 */
class DeviceResource extends ModelResource
{
    protected string $model = Device::class;

    protected string $title = 'Оборудование';

    protected array $with = ['characteristic'];

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Column::make([
                Block::make([
                    ID::make()->sortable(),
                    Text::make('Название', 'title')->sortable(),
                    Image::make('Изображение', 'thumb')
                        ->disk('public')
                        ->dir('/images/devices/thumbnails')
                        ->removable()
                        ->customName(fn(UploadedFile $file, Field $field) =>  Str::random(10) . '.' . $file->extension()),
                    Image::make('Галерея', 'gallery')
                        ->multiple()
                        ->disk('public')
                        ->customName(fn(UploadedFile $file, Field $field) =>  Str::random(10) . '.' . $file->extension())
                        ->dir('/images/devices/gallery/')
                        ->removable(),
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
                                    return $query->where('type', 'devices');
                                })
                        ),
                    HasMany::make('Документы', 'documents', 'title')
                        ->nullable()
                        ->fields([
                            BelongsTo::make('','category', 'title')
                        ])
                ])
            ])->columnSpan(8),
            Column::make([
                Block::make([
                    Json::make('Характеристики')
                        ->hideOnIndex()
                        ->hideOnDetail()
                        ->hideOnForm()
                        ->hideOnUpdate()
                        ->keyValue('Параметр', 'Значение')
                        ->onApply(fn($data) => $data)
                        ->onAfterApply(function($data, $value) {
                            $result = collect($value)->mapWithKeys(fn($item) => [$item['key'] => $item['value']]);
                            $result = json_encode($result);
                            Characteristic::query()->create([
                                'device_id' => $data->id,
                                'info' => json_decode($result)
                            ]);
                        })
                        ->removable(),
                    HasOne::make('Характеристики', 'characteristic')
                        ->nullable()
                        ->hideOnIndex()
                        ->hideOnCreate()
                ])
            ])->columnSpan(4)
        ];
    }

    /**
     * @param Device $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
