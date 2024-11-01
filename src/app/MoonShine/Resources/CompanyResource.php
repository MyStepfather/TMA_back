<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

use MoonShine\Enums\PageType;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Company>
 */
class CompanyResource extends ModelResource
{
    protected string $model = Company::class;

    protected string $title = 'Компани';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected string $sortColumn = 'name';
    protected string $sortDirection = 'ASC';

    protected bool $createInModal = true;
    protected bool $editInModal = true;
    protected bool $detailInModal = true;

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название компании (ООО/ИП)', 'name')->sortable(),
            ]),
        ];
    }

    /**
     * @param Company $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
