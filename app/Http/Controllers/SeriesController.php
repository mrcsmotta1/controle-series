<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {

    }

    public function index(Request $request)
    {
        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')
            ->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {

        $coverPath = $request->file('cover')->store('series_cover', 'public');
        $request->coverPath = $coverPath;
        $serie = $this->repository->add($request);
        \App\Events\SeriesCreated::dispatch(
            $serie->nome,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason
        );

        return to_route('series.index')
            ->with("mensagem.sucesso", "Série '{$serie->nome}' adicionada com sucesso!");
    }

    public function destroy(Series $series)
    {
        $series->delete();
        if ($series->cover) {
            \App\Jobs\DeleteSeriesCover::dispatch($series->cover);
        }
        return to_route('series.index')
            ->with("mensagem.sucesso", "Série '{$series->nome}' removida com sucesso!");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->nome = $request->nome;
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' alterada com sucesso!");
    }
}
