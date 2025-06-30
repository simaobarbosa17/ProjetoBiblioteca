<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editoras;
use Illuminate\Support\Facades\Storage;

class EditoraAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $editoras = Editoras::all();
        return view('admin.editora.create', compact('editoras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'logotipo' => 'nullable|image|max:2048',
        ]);

        $logoPath = 'storage/app/public/logo/default.png';

        if ($request->hasFile('logotipo')) {
            $filename = uniqid() . '.' . $request->file('logotipo')->getClientOriginalExtension();
            $request->file('logotipo')->move(storage_path('app/public/logo'), $filename);
            $logoPath = 'storage/app/public/logo/' . $filename;
        }

        $editora = Editoras::create([
            'nome' => $validated['nome'],
            'logótipo' => $logoPath,
        ]);

        app('SiteLogger')('Editora', $editora->id, 'Editora Criada');

        return redirect()->route('admin.editoras')->with('success', 'Editora criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editora = Editoras::findOrFail($id);
        return view('admin.editora.edit', compact('editora'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'logotipo' => 'nullable|image|max:2048',
        ]);

        $editora = Editoras::findOrFail($id);

        $editora->nome = $request->nome;



        if ($request->hasFile('logotipo')) {

            if ($editora->logotipo && Storage::exists($editora->logotipo)) {
                Storage::delete($editora->logotipo);
            }
            $filename = uniqid() . '.' . $request->file('logotipo')->getClientOriginalExtension();


            $request->file('logotipo')->move(storage_path('app/public/logo'), $filename);


            $logoPath = 'storage/app/public/logo/' . $filename;

            $editora->logótipo = $logoPath;
        }

        $editora->save();
        app('SiteLogger')('Editora', $editora->id, 'Editora Alterada ');
        return redirect()->route('admin.editoras')->with('success', 'Editora atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $editora = Editoras::findOrFail($id);
        $editora->delete();
        app('SiteLogger')('Editora', $editora->id, 'Editora Apagada ');
        return redirect()->route('admin.editoras')->with('success', 'Editora removido com sucesso.');
    }
}
