<?php

namespace Database\Seeders;

use App\Models\TaskPriority;
use Illuminate\Database\Seeder;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [
                'name' => 'Low',
                'color' => 'green',
                'description' => 'Low priority',
            ],
            [
                'name' => 'Medium',
                'color' => 'amber',
                'description' => 'Medium priority',
            ],
            [
                'name' => 'High',
                'color' => 'red',
                'description' => 'High priority',
            ],
        ];

        foreach ($priorities as $priority) {
            TaskPriority::updateOrCreate([
                'name' => $priority['name'],
                'color' => $priority['color'],
                'description' => $priority['description'],
            ], $priority);
        }
    }
}
