<?php

namespace Database\Factories;

use App\Models\MiniMail;
use Illuminate\Database\Eloquent\Factories\Factory;

class MiniMailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MiniMail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = ['Posted', 'Sent', 'Failed'];

        shuffle($statuses);

        $status = $statuses[0];

        return [
            'from' => $this->faker->email,
            'to' => $this->faker->email,
            'subject' => $this->faker->realText($this->faker->numberBetween(20,30)),
            'html_content' => $this->faker->text(200),
            'status' => $status,
            'sent_at' => $status === 'Sent' ?  $this->faker->dateTime() : null,
        ];
    }
}
