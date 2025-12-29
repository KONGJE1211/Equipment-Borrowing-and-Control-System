<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {

        $imageMap = [
            'Beaker'       => 'beaker.jpg',
            'Magnet'       => 'magnet.jpg',
            'Flashlight'   => 'flashlight.jpg',
            'Microscope'   => 'microscope.jpg',
            'Earphone'     => 'earphone.jpg',
            'Bunsen Lamp'  => 'bunsen_lamp.jpg',
            'Pen'          => 'pen.jpg',
            'Weight Scale' => 'weight_scale.jpg',
        ];

        $name = $this->faker->randomElement(array_keys($imageMap));
        

        return [

            // 随机名称（从指定列表中随机挑选）
             'name' => $name,
            /*'name' => $this->faker->randomElement([
                'Beaker', 'Magnet', 'Flashlight', 'Microscope',
                'Earphone', 'Bunsen Lamp', 'Pen', 'Weight Scale'
            ]),*/

            // 固定信息
            'information' => 'This is product intro or detail.',

            // 整数价值 RM 10 - RM 1000（没有小数点）
            'value' => $this->faker->numberBetween(10, 1000),

            // 固定图片
            'image' => 'storage/equipment/' . $imageMap[$name],
            /*'image' => 'storage/equipment/' . $imageNames = [
                'beaker.png', 'magnet.png', 'flashlight.png', 'microscope.png',
                'earphone.jpg', 'bunsen_lamp.jpg', 'pen.jpg', 'weight_scale.jpg'
            ][$this->faker->numberBetween(0, 7)],*/
            //'image' => 'default.jpg',


            // 随机 status（你要求只要 available 或 maintenance）
            'status' => $this->faker->randomElement(['available', 'maintenance']),

            // 随机过期日期：2026 - 2030 年
            'expired_date' => $this->faker->dateTimeBetween('2026-06-01', '2031-12-31')
                                        ->format('Y-m-d'),
        ];
    }
}
