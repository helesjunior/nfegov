<?php
/**
 * Executa Job para buscar NFes por Unidades.
 *
 * @author Heles Resende S. Júnior <helesjunior@gmail.com>
 */
namespace App\Jobs;

use App\Http\Traits\NfeOrg;
use App\Models\Unidade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BuscarNfesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, NfeOrg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Executa Job para buscar NFes por Unidades.
     *
     * @category NFeGov
     * @package App\Jobs\BuscarNfesJob
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    public function handle()
    {
        $unidades = Unidade::all();
        foreach ($unidades as $unidade){
            $this->consultaSefazDistDFe($unidade);
        }
    }
}
