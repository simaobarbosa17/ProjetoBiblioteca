<x-mail::message>
# Nova Requisição

O utilizador **{{ $requisicao->user->name }}** requisitou um livro.

### Detalhes do Livro:
- **Nome:** {{ $requisicao->livro->nome }}
- **Data da Requisição:** {{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}
- **Data de Entrega:** {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}


<x-mail::button :url="route('admin.todasrequesicoes')">
Ver Todas Requisições
</x-mail::button>

</x-mail::message>
