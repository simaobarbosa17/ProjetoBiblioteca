<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autores;
use Illuminate\Support\Facades\Storage;
class AutorAdminController extends Controller
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
        $autores = Autores::all();
        return view('admin.autor.create', compact('autores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

       
        $fotoPath = 'storage/app/public/autor/default.png';

        if ($request->hasFile('foto')) {
            $filename = uniqid() . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move(storage_path('app/public/autor'), $filename);
            $fotoPath = 'storage/app/public/autor/' . $filename;
        }

        $autor = Autores::create([
            'nome' => $validated['nome'],
            'foto' => $fotoPath,
        ]);

        app('SiteLogger')('Autor', $autor->id, 'Autor Criado ');

        return redirect()->route('admin.autores')->with('success', 'Autor criado com sucesso!');
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
        $autor = Autores::findOrFail($id);
        return view('admin.autor.edit', compact('autor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $autor = Autores::findOrFail($id);

        $autor->nome = $request->nome;



        if ($request->hasFile('foto')) {

            if ($autor->foto && Storage::exists($autor->foto)) {
                Storage::delete($autor->foto);
            }
            $filename = uniqid() . '.' . $request->file('foto')->getClientOriginalExtension();


            $request->file('foto')->move(storage_path('app/public/autor'), $filename);


            $fotoPath = 'storage/app/public/autor/' . $filename;

            $autor->foto = $fotoPath;
        }
        $autor->save();

        app('SiteLogger')('Autor', $autor->id, 'Autor Alterado ');
        return redirect()->route('admin.autores')->with('success', 'Autor atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $autor = Autores::findOrFail($id);
        $autor->delete();
        app('SiteLogger')('Autor', $autor->id, 'Autor Apagado ');
        return redirect()->route('admin.autores')->with('success', 'Autor removido com sucesso.');
    }
}