<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getDevices(Request $request)
    {
        $filter = (int)$request->query('filter');
        $page = (int)$request->query('page');
        $perPage = (int)$request->query('perPage');
        $search = $request->query('search');

        if ($filter === 0) {
            $devices = Device::query();
        } else {
            $devices = Device::query()->whereHas('categories', function ($query) use ($filter) {
               return $query->where('category_id', $filter);
            });
        }
        if ($search !== null) {
            if ($filter === 0) {
                $devices = Device::query()->where('title', 'like', '%' . $search . '%');
            } else {
                $devices = Device::query()->whereHas('categories', function ($query) use ($search, $filter) {
                    return $query->where('category_id', $filter);
                })->where('title', 'like', '%' . $search . '%');
            }
        }
        $paginator = $devices->simplePaginate(
            perPage: $perPage,
            page: $page,
        );
        if ($paginator->isNotEmpty()) {
            collect($paginator->items())->each(function ($item) {
               $item['thumb'] = $item->full_thumb_path;
               return $item;
            });
            return response()->json($paginator, 200);
        }
        return response()->json(['message' => 'Оборудования в этой категории пока нет.'], 404);
    }

    public function getCategories()
    {
        $categories = Category::query()->whereHas('categoryType', function ($query) {
           return $query->where('type', 'devices');
        })->get();

        if ($categories->isNotEmpty()) {
            return response()->json($categories, 200);
        }
        return response()->json(['message' => 'Категорий пока нет.'], 404);
    }

    public function getDevice($id)
    {
        $device = Device::query()
            ?->with('documents')
            ?->with('documents.category')
            ?->with('characteristic')
            ->find($id)
        ;

        if ($device) {
            if (isset($device->characteristic)) {
                $info = $device->characteristic['info'];
                $info = collect($info)->map(function ($value, $key) {
                    return [
                        "title" => $key,
                        "description" => $value,
                    ];
                })->values();

                $device['info'] = $info;
                unset($device->characteristic);
            }
            if (isset($device->gallery)) {
                $device['gallery'] = $device->full_gallery_path;
            }
            if (isset($device->thumb)) {
                $device['thumb'] = $device->full_thumb_path;
            }
            if (isset($device->documents)) {
                collect($device->documents)->map(function ($document) {
                    $document['path'] = $document->full_path;
                });
            }

            return response()->json($device, 200);
        }

        return response()->json(['message' => 'Оборудование не найдено.'], 404);
    }
}
