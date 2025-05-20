<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Morfologia', 'OB', 'Glukoza', 'Cholesterol całkowity', 'HDL', 'LDL',
                'Triglicerydy', 'Kreatynina', 'TSH', 'FT3', 'FT4', 'Testosteron',
                'Estradiol', 'Kortyzol', 'Witamina D3', 'CRP', 'D-dimery',
                'Alt', 'Ast', 'GGTP', 'Bilirubina', 'Albumina', 'Sód', 'Potas',
                'Magnez', 'Żelazo', 'Wapń', 'Hemoglobina glikowana', 'Insulina',
                'Test tolerancji glukozy', 'Białko całkowite', 'Amylaza', 'Lipaza',
                'Antygen HBs', 'Przeciwciała anty-HCV', 'Badanie ogólne moczu',
                'Kał na krew utajoną', 'Posiew moczu', 'Wymaz z gardła',
                'Helicobacter pylori', 'Panel alergiczny', 'Test na boreliozę',
                'Test ciążowy beta-hCG', 'Markery nowotworowe PSA', 'CA-125', 'CEA',
                'Kalprotektyna', 'Prokalcytonina', 'Panel tarczycowy', 'Test ANA'
            ]),
        ];
    }
}
