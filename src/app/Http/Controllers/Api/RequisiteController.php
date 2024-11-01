<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Requisite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class RequisiteController extends Controller
{
    public Collection $companies;

    public function getRequisites(Request $request): JsonResponse
    {
        $filter = (int)$request->query('company_id');
        $perPage = (int)$request->query('per_page');
        $page = (int)$request->query('page');

        if ($filter === 0) {
            $requisitesQuery = Requisite::query();
        } else {
            $requisitesQuery = Requisite::query()->where('company_id', $filter);
        }

        $paginator = $requisitesQuery->simplePaginate(
            perPage: $perPage,
            page: $page
        );

        if ($paginator->isNotEmpty()) {
            collect($paginator->items())->map(function ($item) {
                $item['path'] = $item->full_file_path;
                $item['entities'] = collect($item['entities'])->map(function ($value, $key) {
                    return [
                        "title" => $key,
                        "value" => $value
                    ];
                })->values();
            });
            return response()->json($paginator, '200');
        }
        return response()->json(['message' => 'Реквизиты не найдены. Попросите администратора добавить их'], 404);
    }

    public function getCompanies(): JsonResponse
    {
        $this->companies = Company::query()->has('requisites')->get();
        if ($this->companies->isNotEmpty()) {
            return response()->json($this->companies, 200);
        }
        return response()->json(['message' => 'Не указано компаний с реквизитами']);
    }

}
