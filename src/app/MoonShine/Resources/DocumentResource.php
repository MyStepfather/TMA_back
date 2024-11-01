<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use MoonShine\Enums\PageType;
use MoonShine\Fields\File;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Traits\Resource\ResourceWithParent;

/**
 * @extends ModelResource<Document>
 */
class DocumentResource extends ModelResource
{
    use ResourceWithParent;

    protected string $model = Document::class;
    protected string $title = 'Документы';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected string $sortColumn = 'title';
    protected string $sortDirection = 'ASC';

    protected function getParentResourceClassName(): string
    {
        return DeviceResource::class;
    }

    protected function getParentRelationName(): string
    {
        return 'device';
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'title')->sortable(),
                File::make('Файл', 'path')
                    ->when(
                        $parentId = $this->getParentId(),
                        fn(File $file) => $file->dir('documents/' .$parentId)
                    )
                    ->allowedExtensions(['pdf', 'doc', 'txt'])
                    ->customName(fn(UploadedFile $file, Field $field) => Str::random(10) . '.' . $file->extension()),
                BelongsTo::make('Оборудование', 'device', 'title')
                    ->sortable()
                    ->placeholder('Выберите оборудование'),
                BelongsTo::make('Категория', 'category', 'title')
                    ->sortable()
                    ->placeholder('Выберите категорию документа')
                    ->valuesQuery(
                        fn(Builder $query) =>
                        $query->whereHas('categoryType', function ($query) {
                            return $query->where('type', 'documents');
                        })
                    ),
            ]),
        ];
    }

    /**
     * @param Document $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
