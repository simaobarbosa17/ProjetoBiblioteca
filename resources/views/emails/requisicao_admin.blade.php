<x-mail::message>
# Nova Requisição

O utilizador **{{ $requisicao->user->name }}** requisitou um livro.

### Detalhes do Livro:
- **Nome:** {{ $requisicao->livro->nome }}
- **Data da Requisição:** {{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}
- **Data de Entrega:** {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}

@if($requisicao->livro->capa)
    <img src="{{ Storage::url($requisicao->livro->capa) }}" alt="Capa do Livro" style="max-width: 100%; height: auto;">
@endif
<x-mail::button :url="route('admin.todasrequesicoes')">
Ver Todas Requisições
</x-mail::button>

</x-mail::message>
