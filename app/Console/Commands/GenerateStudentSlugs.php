<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;

class GenerateStudentSlugs extends Command
{
    protected $signature = 'students:generate-slugs';
    protected $description = 'Generate slugs for students that do not have one';

    public function handle(): void
    {
        $count = 0;
        Student::whereNull('slug')->orWhere('slug', '')->each(function (Student $student) use (&$count) {
            $student->slug = $student->generateSlug();
            $student->saveQuietly();
            $count++;
            $this->line("Generated slug for: {$student->identification_number} → {$student->slug}");
        });

        $this->info("Done! Generated slugs for {$count} students.");
    }
}
