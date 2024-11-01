<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Device;
use App\Models\Presentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    public function getPresentations(Request $request)
    {
        $categoriesIds = explode(',', $request->query('categoriesId'));
        $companyId = (int)$request->query('companyId');
        $searchValue = $request->query('searchValue');
        $page = $request->query('page');
        $perPage = $request->query('perPage');

        $categoriesIds = array_filter($categoriesIds);

        $query = Presentation::query();

        if ($companyId > 0) {
            $query->where('company_id', $companyId);
        }

        if (!empty($categoriesIds)) {
            $query->whereHas('categories', function ($query) use ($categoriesIds) {
                $query->whereIn('category_id', $categoriesIds);
            });
        }

        if (!empty($searchValue)) {
            $query->where('title', 'like', '%' . $searchValue . '%');
        }

        if ($companyId && !empty($categoriesIds)) {
            $query->where(function ($query) use ($companyId, $categoriesIds) {
                $query->where('company_id', $companyId)
                    ->whereHas('categories', function ($query) use ($categoriesIds) {
                        $query->whereIn('category_id', $categoriesIds);
                    });
            });
        }

        $presentations = $query->with('categories');

        $paginator = $presentations->simplePaginate(
            perPage: $perPage,
            page: $page,
        );
        if ($paginator->isNotEmpty()) {
            collect($paginator->items())->each(function ($item) {
                $item['path'] = $item->full_file_path;
                $item['category_id'] = $item->categories->map(function ($category) {
                   return $category->id;
                });
                unset($item->categories);
                return $item;
            });
            return response()->json($paginator, 200);
        }
        return response()->json(['message' => 'Оборудования в этой категории пока нет.'], 404);
    }

    public function getPresentation($id): JsonResponse
    {
        $presentation = Presentation::query()
            ->find($id);
        if ($presentation) {
            $presentation['path'] = $presentation->full_file_path;
            return response()->json($presentation, 200);
        }
        return response()->json(['message' => 'Презентация не найдена'], 404);
    }

    public function getCategories(Request $request): JsonResponse
    {
        $companyId = $request->query('company_id');

        if ($companyId !== null) {
            $categories = Category::query()->whereHas('presentations', function ($query) use ($companyId) {
                return $query->where('company_id', $companyId);
            })->get();
        } else {
            $categories = Category::query()->whereHas('categoryType', function ($query) {
                return $query->where('type', 'presentations');
            })->get();
        }

        if ($categories->isEmpty()) {
            return response()->json(['message' => 'Категорий пока нет'], 404);
        }
        return response()->json($categories, 200);
    }

    public function getCompanies(): JsonResponse
    {
        $companies = Company::query()->has('presentations')->get();
        if ($companies->isNotEmpty()) {
            return response()->json($companies, 200);
        }
        return response()->json(['message' => 'Не указано компаний с презентациями']);
    }
}
