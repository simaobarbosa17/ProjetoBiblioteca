<x-mail::message>
# Nova Review para Aprovação

Olá Admin,

O usuário **{{ $user->name }}** ({{ $user->email }}) enviou uma nova review para o livro **{{ $livro->nome }}**.

---

### Comentário:

{{ $review->descricao }}

---

<x-mail::button :url="route('admin.reviews')">
Ver Detalhes da Review
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>