<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Client\Request;

class SeriesController extends Controller
{

    public function __construct(private SeriesRepository $seriesRepository)
    {

    }

    public function index()
    {
        return Series::all();
    }

    public function store(SeriesFormRequest $request)
    {
        return response()->json($this->seriesRepository->add($request), 201);
    }

    public function show(int $series)
    {
        $seriesModel = Series::find($series);

        if (is_null($seriesModel)) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $seriesModel;
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(int $series)
    {
        Series::destroy($series);
        return response()->noContent();
    }

    public function storeSeason(Series $series)
    {
        return $series->seasons;
    }

    public function storeEpisodes(Series $series)
    {
       return $series->episodes;
    }
}
