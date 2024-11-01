<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function getEventsByMonth(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $events = Event::query()
            ->whereMonth('date', $month)
            // ->whereYear('date', $year)
            // ->with('type')
            ->get();

        if ($events->isNotEmpty()) {
            $transformedEvents = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => $event->date,
                    'type' => $event->type?->type,
                    'isActive' => $event->isActive,
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
                ];
            });

            return response()->json($transformedEvents, 200);
        }

        return response()->json(['message' => 'События не найдены'], 404);
    }

    public function getActiveEvents()
    {

        $events = Event::query()
            ->where('isActive', 1)
            ->with('type')
            ->get()
        ;

        if ($events->isNotEmpty()) {
            $transformedEvents = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => $event->date,
                    'type' => $event->type?->type,
                    'isActive' => $event->isActive,
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
                ];
            });

            return response()->json($transformedEvents, 200);
        } else {
            return response()->json(['message' => 'Активных событий нет'], 200);
        }
    }

}
