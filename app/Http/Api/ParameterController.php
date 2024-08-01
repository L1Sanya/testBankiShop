<?php

namespace App\Http\Api;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParameterController
{

    public function index()
    {
        $parameters = Parameter::all();

        return response()->json($parameters);
    }

    public function getType2Parameters()
    {
        $parameters = Parameter::where('type', 2)->get()->map(function ($parameter) {
            return [
                'id' => $parameter->id,
                'title' => $parameter->title,
                'icon' => $parameter->icon ? [
                    'name' => basename($parameter->icon),
                    'path' => asset('storage/' . $parameter->icon),
                    'type' => 'icon'
                ] : null,
                'icon_gray' => $parameter->icon_gray ? [
                    'name' => basename($parameter->icon_gray),
                    'path' => asset('storage/' . $parameter->icon_gray),
                    'type' => 'icon_gray'
                ] : null,
            ];
        });

        return response()->json($parameters);
    }

    public function getType1Parameters()
    {
        $parameters = Parameter::where('type', 1)->get()->map(function ($parameter) {
            return [
                'id' => $parameter->id,
                'title' => $parameter->title,
                'icon' => $parameter->icon ? [
                    'name' => basename($parameter->icon),
                    'path' => asset('storage/' . $parameter->icon),
                    'type' => 'icon'
                ] : null,
                'icon_gray' => 'Недоступно', // Указываем, что поле недоступно
            ];
        });

        return response()->json($parameters);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|integer|in:1,2',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_gray' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $parameter = new Parameter;
        $parameter->title = $request->title;
        $parameter->type = $request->type;

        if ($request->hasFile('icon')) {
            $parameter->icon = $request->file('icon')->store('icons', 'public');
        }

        if ($request->hasFile('icon_gray')) {
            $parameter->icon_gray = $request->file('icon_gray')->store('icons', 'public');
        }

        $parameter->save();

        return response()->json($parameter, 201);
    }

    // Получить параметр по ID
    public function show($id)
    {
        $parameter = Parameter::findOrFail($id);

        return response()->json($parameter);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|integer|in:1,2',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_gray' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $parameter = Parameter::findOrFail($id);
        $parameter->title = $request->title;
        $parameter->type = $request->type;

        if ($request->hasFile('icon')) {
            if ($parameter->icon) {
                Storage::disk('public')->delete($parameter->icon);
            }
            $parameter->icon = $request->file('icon')->store('icons', 'public');
        }

        if ($request->hasFile('icon_gray')) {
            if ($parameter->icon_gray) {
                Storage::disk('public')->delete($parameter->icon_gray);
            }
            $parameter->icon_gray = $request->file('icon_gray')->store('icons', 'public');
        }

        $parameter->save();

        return response()->json($parameter);
    }

    public function destroy($id)
    {
        $parameter = Parameter::findOrFail($id);

        // Удалить файлы, если они существуют
        if ($parameter->icon) {
            Storage::disk('public')->delete($parameter->icon);
        }
        if ($parameter->icon_gray) {
            Storage::disk('public')->delete($parameter->icon_gray);
        }

        $parameter->delete();

        return response()->json(null, 204);
    }
}
