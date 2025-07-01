<x-mail::message>
# Confirmação da Requisição

Olá {{ $requisicao->user->name }},

A sua requisição de livro foi registrada com sucesso!

---

**📚 Livro:** {{ $requisicao->livro->nome }}  
**📅 Data da Requisição:** {{ \Carbon\Carbon::parse($requisicao->data_requisicao)->format('d/m/Y') }}  
**📦 Data de Entrega:** {{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}

---


<x-mail::button :url="route('requisicoes.show',$requisicao->user->id)">
Ver Minhas Requisições
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
