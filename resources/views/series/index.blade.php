<x-layout title="Séries" :mensagem-sucesso="$mensagemSucesso">
    <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Adicionar Série</a>

    <ul class="list-group">
        @foreach ($series as $serie)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('seasons.index', $serie->id) }}">{{ $serie->nome }}</a>
            <span class="d-flex">
                <a href="{{ route('series.edit', $serie->id) }}"
                    class="btn btn-primary btn-sm bi bi-pen glyphicon">&#x270f;</a>

                <form action="{{ route('series.destroy', $serie->id) }}" class="ms-2" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        &times;
                    </button>
                </form>
            </span>
        </li>
        @endforeach
    </ul>
</x-layout>