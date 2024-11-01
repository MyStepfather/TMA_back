<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Device;
use Illuminate\Database\Eloquent\Model;
use App\Models\Characteristic;

use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\HasOne;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Characteristic>
 */
class CharacteristicResource extends ModelResource
{
    protected string $model = Characteristic::class;

    protected string $title = 'Характеристики';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                BelongsTo::make('Оборудование', 'device', 'title'),
                Json::make('Характеристики', 'info')
                    ->nullable()
                    ->keyValue('Название', 'Описание')
            ]),
        ];
    }

    /**
     * @param Characteristic $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
