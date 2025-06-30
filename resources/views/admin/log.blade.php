<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-base-content">
                🧾 {{ __('Logs') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         
            <div class="mb-6  p-4 rounded shadow">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="user" placeholder="Utilizador" value="{{ request('user') }}"
                           class=" focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <input type="text" name="module" placeholder="Módulo" value="{{ request('module') }}"
                           class=" focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <input type="date" name="date" value="{{ request('date') }}"
                           class=" focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 transition">
                        Filtrar
                    </button>
                </form>
            </div>

            
            <div class="shadow rounded overflow-x-auto">
                <table class="min-w-full table-auto text-sm">
                    <thead class=" uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2 text-left">Data</th>
                            <th class="px-4 py-2 text-left">Hora</th>
                            <th class="px-4 py-2 text-left">Utilizador</th>
                            <th class="px-4 py-2 text-left">Módulo</th>
                            <th class="px-4 py-2 text-left">ID Objeto</th>
                            <th class="px-4 py-2 text-left">Alteração</th>
                            <th class="px-4 py-2 text-left">IP</th>
                            <th class="px-4 py-2 text-left">Browser</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y ">
                        @forelse ($logs as $log)
                            <tr class="">
                                <td class="px-4 py-2">{{ $log->date }}</td>
                                <td class="px-4 py-2">{{ $log->time }}</td>
                                <td class="px-4 py-2">{{ $log->user?->name ?? 'Sistema' }}</td>
                                <td class="px-4 py-2">{{ $log->module }}</td>
                                <td class="px-4 py-2">{{ $log->object_id }}</td>
                                <td class="px-4 py-2 break-words max-w-xs">{{ $log->change }}</td>
                                <td class="px-4 py-2">{{ $log->ip_address }}</td>
                                <td class="px-4 py-2 break-all max-w-xs">{{ Str::limit($log->browser, 60) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center ">
                                    Nenhum log encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            
            <div class="mt-4">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>