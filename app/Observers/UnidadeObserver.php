<?php

namespace App\Observers;

use App\Models\Nsu;
use App\Models\Unidade;

class UnidadeObserver
{
    /**
     * Handle the Unidade "created" event.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return void
     */
    public function created(Unidade $unidade)
    {
        $nsu = Nsu::create([
                'unidade_id' => $unidade->id,
                'ultimo_nsu' => 0,
        ]);
    }

    /**
     * Handle the Unidade "updated" event.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return void
     */
    public function updated(Unidade $unidade)
    {
        //
    }

    /**
     * Handle the Unidade "deleted" event.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return void
     */
    public function deleted(Unidade $unidade)
    {
        //
    }

    /**
     * Handle the Unidade "restored" event.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return void
     */
    public function restored(Unidade $unidade)
    {
        //
    }

    /**
     * Handle the Unidade "force deleted" event.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return void
     */
    public function forceDeleted(Unidade $unidade)
    {
        //
    }
}
