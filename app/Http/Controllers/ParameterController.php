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

        $sortField = $request->get('sort_field', 'id');  // Поле для сортировки, по умолчанию 'id'
        $sortOrder = $request->get('sort_order', 'asc'); // Порядок сортировки, по умолчанию 'asc'

        $parameters = $query->orderBy($sortField, $sortOrder)->get();

        return view('parameters.index', compact('parameters', 'sortField', 'sortOrder'));
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


}
