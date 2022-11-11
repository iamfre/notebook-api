<?php

namespace Database\Factories;

use App\Models\Notebook;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotebookFactory extends Factory
{
    protected $model = Notebook::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fio' => $this->faker->unique()->name(),
            'company' => $this->faker->company(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->email(),
            'birthday' => $this->faker->date(),
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
