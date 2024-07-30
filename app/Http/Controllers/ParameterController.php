<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        $query = Parameter::query();

        if ($request->has('search')) {
            $query->where('id', $request->search)
                ->orWhere('title', 'like', '%' . $request->search . '%');
        }

        $parameters = $query->where('type', 2)->get();

        return view('parameters.index', compact('parameters'));
    }

    public function uploadImages(Request $request, $id)
    {
        $parameter = Parameter::findOrFail($id);

        $request->validate([
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_gray' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $icon = $this->saveImage($request->file('icon'), 'icon');
            $parameter->icon = $icon;
        }

        if ($request->hasFile('icon_gray')) {
            $iconGray = $this->saveImage($request->file('icon_gray'), 'icon_gray');
            $parameter->icon_gray = $iconGray;
        }

        $parameter->save();

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    private function saveImage($image, $type)
    {
        $originalName = $image->getClientOriginalName();
        $name = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '-' . time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images', $name, 'public');

        return $path;
    }

    public function deleteImage($id, $type)
    {
        $parameter = Parameter::findOrFail($id);
        if ($type == 'icon' && $parameter->icon) {
            Storage::disk('public')->delete($parameter->icon);
            $parameter->icon = null;
        } elseif ($type == 'icon_gray' && $parameter->icon_gray) {
            Storage::disk('public')->delete($parameter->icon_gray);
            $parameter->icon_gray = null;
        }

        $parameter->save();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function apiGetParameters()
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
}
