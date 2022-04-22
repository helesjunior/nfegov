<?php

namespace App\Http\Controllers\Admin\Fetch;

use App\Http\Controllers\Controller;
use App\Models\Municipio;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Illuminate\Http\Request;
use function collect;

class FetchsController extends Controller
{
    use FetchOperation;

    public function fetchMunicipio(Request $request)
    {
        $form = collect($request->input('form'))->pluck('value', 'name');

        if (!$form['estado_id']) {
            return [];
        }

        return $this->fetch([
            'model' => Municipio::class,
            'query' => function($model) use ($form) {
                $search = request()->input('q') ?? false;
                if ($search) {
                    return $model->where('estado_id',$form['estado_id'])
                        ->where('nome','iLike','%' . $search . '%');
                }else{
                    return $model->where('estado_id',$form['estado_id']);
                }
            },
        ]);
    }


}
