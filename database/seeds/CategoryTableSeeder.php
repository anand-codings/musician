<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Violin',
            'Viola',
            'Cello',
            'Double bass',
            'Guitar',
            'Electric guitar',
            'Bass guitar',
            'Piano',
            'Organ',
            'Harp',
            'Voice',
            'Flute',
            'Piccolo',
            'Saxophone',
            'Clarinet',
            'Oboe',
            'French horn',
            'Trumpet',
            'Trombone',
            'Drums',
            'Percussion',
            'Composition',
            'Conducting',
            'Fiddle',
            'Viola da Gamba',
            'Chalumeau',
            'Cornetto',
            'DJ',
            'Synthesizer',
            'Horn',
            'Sackbut',
            'Lute',
            'Soprano',
            'Mezzo-soprano',
            'Alto',
            'Contralto',
            'Countertenor',
            'Tenor',
            'Baritone',
            'Bass',
            'Guzheng',
            'Piano accompaniment',
            'Accordion'
        ];
        
        $ensembleCategories = [
            'String Duo', 'String Trio', 'String Quartet', 'Jazz Combo', 'Rock Band', 'Country Band'
        ];
        
        for ($i = 0; $i < count($categories); $i++) {
            App\Category::create([
                'title' => $categories[$i],
                'is_solo' => 1,
            ]);
        }
        for ($i = 0; $i < count($ensembleCategories); $i++) {
            App\Category::create([
                'title' => $ensembleCategories[$i],
                'is_ensemble' => 1
            ]);
        }
    }
}
