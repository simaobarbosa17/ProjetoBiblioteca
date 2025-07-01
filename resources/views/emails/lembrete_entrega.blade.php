<x-mail::message>
# Olá {{ $requisicao->user->name }}

Este é um lembrete de que a entrega do livro **{{ $requisicao->livro->nome }}** está agendada para **{{ \Carbon\Carbon::parse($requisicao->data_entrega)->format('d/m/Y') }}**.

<x-mail::button :url="route('verequesicao')">
Ver Todas Requisições
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
