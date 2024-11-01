<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Requisite;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use MoonShine\Enums\PageType;
use MoonShine\Fields\Date;
use MoonShine\Fields\File;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Requisite>
 */
class RequisiteResource extends ModelResource
{
    protected string $model = Requisite::class;

    protected string $title = 'Реквизиты';

    protected string $sortDirection = 'ASC';

    protected ?PageType $redirectAfterSave = PageType::INDEX;


    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Названние', 'title')->sortable(),
                BelongsTo::make('Компания', 'company', 'name')
                    ->placeholder('Выберите компанию'),
                Date::make('Дата "от"', 'date'),
                File::make('Файл', 'path')
                    ->disk('public')
                    ->dir('/files/requisites/')
                    ->removable()
                    ->customName(fn(UploadedFile $file, Field $field) =>  Str::random(10) . '.' . $file->extension()),
                Json::make('entities')
                    ->nullable()
                    ->keyValue('Реквизит', 'Значение')
                    ->removable()
                    ->hideOnIndex()
            ]),
        ];
    }

    /**
     * @param Requisite $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
