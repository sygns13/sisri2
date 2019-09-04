<?php

namespace App\Exports;

/* use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView; */

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

/* class PlantillaPostulanteExport implements FromView
{

    public function view(): View
    {
        return view('postulantes.plantillaExcel', [
            'users' => User::all()
        ]);
    }
} */
class PlantillaPostulanteExport implements WithEvents
{

    use Exportable, RegistersEventListeners;

    
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Patrick');
            },
            
            // Array callable, refering to a static method.
            BeforeWriting::class => [self::class, 'beforeWriting'],
            
            // Using a class with an __invoke method.
            BeforeSheet::class => new BeforeSheetHandler()
        ];
    }
    
    public static function beforeWriting(BeforeWriting $event) 
    {
        //
    }
}