<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->parseRequest($request);

        $admins = User::query()
            ->where('role', 0);
        if (!empty($query['name'])) {
            $admins->where('name', 'LIKE', '%' . $query['name'] . '%');
        }
        if (!empty($query['email'])) {
            $admins->where('email', 'LIKE', '%' . $query['email'] . '%');
        }
        if (isset($query['active'])) {
            $admins->where('active', $query['active']);
        }
        $admins = $admins->paginate(10);


        $this->menu
            ->setMenuSection('admins');
        return view('admin/admins.index', compact('admins', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->menu
            ->setMenuSection('admins');
        return view('admin/admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $validate['role'] = 0;
        $validate['active'] = $request->has('active') && $request->active == 'on' ? 1 : 0;
        dd($validate, $request->all());
    }

    public function show(User $admin)
    {
        $this->menu
            ->setMenuSection('admins');
        return view('admin/admins.edit', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        $images = File::files(public_path('uploads'));
        $images = array_filter($images, function ($file) {
            return in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif']);
        });
        $this->menu
            ->setMenuSection('admins');
        return view('admin/admins.edit', compact('admin',  'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'avatar' => 'sometimes'
        ]);
        $validated['role'] = 0;
        if($request->has('active')) {
            $validated['active'] = $request->active == 'on' ? 1 : 0;
        }
        $admin->update($validated);

        return redirect()->route('admin/admins.edit', $admin->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('admin/admins.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    private function parseRequest(Request $request): array
    {
        $query = [];
        if ($request->has('name')) {
            $query['name'] = $request->name;
        }
        if ($request->has('email') && !empty($request->email)) {
            $query['email'] = $request->email;
        }
        if ($request->has('active') && isset($request->active)) {
            $query['active'] = $request->active;
        }
        return $query;
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $filename);
            $imageUrl = '/uploads/' . $filename;

            return response()->json(['imageUrl' => $imageUrl, 'filename' => $filename]);
        }

        return response()->json(['error' => 'Файл не завантажено'], 400);
    }
}
