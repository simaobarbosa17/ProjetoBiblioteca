<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Autores;
use App\Models\Editoras;
use App\Models\Livros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LivroController extends Controller
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
        $autores = Autores::all();

        return view('admin.livro.create', compact('editoras', 'autores'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:livros,isbn',
            'nome' => 'required|string|max:255',
            'editora_id' => 'required|exists:editoras,id',
            'autor_ids' => 'required|array',
            'autor_ids.*' => 'exists:autores,id',
            'bibliografia' => 'nullable|string',
            'capa' => 'nullable|image|max:2048',
            'preco' => 'required|numeric|min:0',
        ]);


        $capaPath = null;
        if ($request->hasFile('capa')) {
            $filename = uniqid() . '.' . $request->file('capa')->getClientOriginalExtension();


            $request->file('capa')->move(storage_path('app/public/capas'), $filename);


            $capaPath = 'storage/capas/' . $filename;

        }

        $livro = Livros::create([
            'isbn' => $validated['isbn'],
            'nome' => $validated['nome'],
            'editora_id' => $validated['editora_id'],
            'bibliografia' => $validated['bibliografia'] ?? '',
            'capa' => $capaPath,
            'preco' => $validated['preco'],
        ]);


        $livro->autores()->sync($validated['autor_ids']);

        return redirect()->route('admin.dashboard')->with('success', 'Livro criado com sucesso!');
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
    public function edit($id)
    {
        $livro = Livros::with(['editora', 'autores'])->findOrFail($id);
        return view('admin.livro.edit', compact('livro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'isbn' => 'required|string',
            'nome' => 'required|string',
            'bibliografia' => 'nullable|string',
            'preco' => 'required|numeric',
            'editora_id' => 'required|exists:editoras,id',
            'autores' => 'required|array',
            'autores.*' => 'exists:autores,id',
            'capa' => 'nullable|image|max:2048',
        ]);

        $livro = Livros::findOrFail($id);

        $livro->isbn = $request->isbn;
        $livro->nome = $request->nome;
        $livro->bibliografia = $request->bibliografia;
        $livro->preco = $request->preco;
        $livro->editora_id = $request->editora_id;


        if ($request->hasFile('capa')) {

            if ($livro->capa && Storage::exists($livro->capa)) {
                Storage::delete($livro->capa);
            }
            $filename = uniqid() . '.' . $request->file('capa')->getClientOriginalExtension();


            $request->file('capa')->move(storage_path('app/public/capas'), $filename);


            $capaPath = 'storage/capas/' . $filename;

            $livro->capa = $capaPath;
        }

        $livro->save();


        $livro->autores()->sync($request->autores);

        return redirect()->route('admin.dashboard')->with('success', 'Livro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $livro = Livros::findOrFail($id);
        $livro->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Livro removido com sucesso.');
    }

    public function formImportarGoogle(Request $request)
    {
        $query = $request->input('q', 'Laravel');
        $page = max(1, (int) $request->input('page', 1));
        $maxResults = 10;
        $startIndex = ($page - 1) * $maxResults;

        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => $query,
            'startIndex' => $startIndex,
            'maxResults' => $maxResults,
        ]);

        $livros = [];
        $totalItems = 0;

        if ($response->successful()) {
            $data = $response->json();
            $livros = $data['items'] ?? [];
            $totalItems = $data['totalItems'] ?? 0;
        }

        $totalPages = min(5, ceil($totalItems / $maxResults));

        return view('admin.importarlivro', compact('livros', 'query', 'page', 'totalPages'));
    }


    public function salvarLivroGoogle(Request $request)
    {


        DB::beginTransaction();

        try {
            $isbn = $request->input('isbn');
            $nome = $request->input('nome');
            $capa = $request->input('capa');
            $bibliografia = $request->input('bibliografia');
            $autoresString = $request->input('autores');

            if (empty($nome)) {
                throw new \Exception('Nome do livro é obrigatório');
            }
            $nomePadrao = 'Editora Padrão';

            $editoras = Editoras::all();
            $editora = $editoras->first(function ($editora) use ($nomePadrao) {
                return $editora->nome === $nomePadrao;
            });

            if (!$editora) {
                $editora = Editoras::create([
                    'nome' => 'Editora Padrão',
                    'logótipo' => 'storage/app/public/logo/default.png',
                ]);
            }


            $livro = Livros::create([
                'isbn' => $isbn,
                'nome' => $nome,
                'bibliografia' => $bibliografia,
                'capa' => $capa,
                'preco' => 0.00,
                'editora_id' => $editora->id,
            ]);

            if (!empty($autoresString)) {
                $autoresNomes = explode(',', $autoresString);
                $autorIds = [];
                foreach ($autoresNomes as $nomeAutor) {
                    $nomeAutor = trim($nomeAutor);
                    if (empty($nomeAutor))
                        continue;

                    $autor = Autores::firstOrCreate(
                        ['nome' => $nomeAutor],
                        ['foto' => 'storage/app/public/autor/default.png']
                    );
                    $autorIds[] = $autor->id;
                }

                $livro->autores()->sync($autorIds);
            }

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Livro importado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erro ao importar livro: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Erro ao importar: ' . $e->getMessage());
        }
    }
}