<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stp>
 */
class StpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        return [
            'tanggal' => $this->faker->date(),
            'user_id' => $this->faker->randomElement($users),
            'is_backdate' => $this->faker->boolean(),
            'unit_kerja' => $this->faker->randomElement(['8000', '8010', '8100', '8200', '8300']),
            'pp_id' => $this->faker->numberBetween(1, 7),
            'nama_pp' => $this->faker->word(),
            'melaksanakan' => $this->faker->sentence(),
            'mulai' => $this->faker->dateTimeBetween('-2 months', '-1 month')->format('Y-m-d'),
            'selesai' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'pegawai' => implode(',', $this->faker->randomElements($users, $this->faker->numberBetween(1, 5))),
            'penandatangan' => $this->faker->numberBetween(0, 4),
            'status' => $this->faker->numberBetween(0, 5),
            'no_st' => $this->faker->bothify('?????#####'),
            'tanggal_sertifikat' => $this->faker->date(),
            'is_esign' => $this->faker->boolean()
        ];
    }
}
