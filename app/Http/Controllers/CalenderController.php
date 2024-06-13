<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrudEvents;

class CalenderController extends Controller
{
    // Method to fetch events for FullCalendar
    public function index(Request $request)
    {
        if($request->ajax()) {  
            $data = CrudEvents::whereDate('event_start', '>=', $request->start)
                ->whereDate('event_end', '<=', $request->end)
                ->get(['id', 'event_name as title', 'event_start as start', 'event_end as end']);
            return response()->json($data);
        }
        return view('welcome');
    }
 
    // Method to handle create, edit, and delete events
    public function calendarEvents(Request $request)
    {
        switch ($request->type) {
           case 'create':
              $event = CrudEvents::create([
                  'event_name' => $request->event_name,
                  'event_start' => $request->event_start,
                  'event_end' => $request->event_end,
              ]);
              return response()->json($event);

           case 'edit':
              $event = CrudEvents::find($request->id);
              if ($event) {
                  $event->update([
                      'event_name' => $request->event_name,
                      'event_start' => $request->event_start,
                      'event_end' => $request->event_end,
                  ]);
                  return response()->json($event);
              }
              return response()->json(['error' => 'Event not found'], 404);

           case 'delete':
              $event = CrudEvents::find($request->id);
              if ($event) {
                  $event->delete();
                  return response()->json(['success' => true]);
              }
              return response()->json(['error' => 'Event not found'], 404);

           default:
              return response()->json(['error' => 'Invalid request'], 400);
        }
    }
}