<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Track;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    public function run(): void
    {
        $tracks = [
            [
                'name'        => 'Frontend',
                'slug'        => 'frontend',
                'description' => 'Build beautiful, interactive user interfaces with modern web technologies.',
                'icon'        => '🎨',
                'color'       => '#6366F1',
                'branches'    => [
                    ['name' => 'HTML',       'slug' => 'html',       'icon' => '📄', 'order' => 1, 'description' => 'Structure and semantics of web pages.'],
                    ['name' => 'CSS',        'slug' => 'css',        'icon' => '🎨', 'order' => 2, 'description' => 'Style and layout of web pages.'],
                    ['name' => 'Tailwind',   'slug' => 'tailwind',   'icon' => '💨', 'order' => 3, 'description' => 'Utility-first CSS framework for rapid UI development.'],
                    ['name' => 'JavaScript', 'slug' => 'javascript', 'icon' => '⚡', 'order' => 4, 'description' => 'Add interactivity and logic to web pages.'],
                    ['name' => 'React',      'slug' => 'react',      'icon' => '⚛️',  'order' => 5, 'description' => 'Component-based UI library by Meta.'],
                    ['name' => 'Vue.js',     'slug' => 'vue',        'icon' => '💚', 'order' => 6, 'description' => 'Progressive JavaScript framework for UIs.'],
                ],
            ],
            [
                'name'        => 'Backend',
                'slug'        => 'backend',
                'description' => 'Build powerful server-side applications, APIs, and databases.',
                'icon'        => '⚙️',
                'color'       => '#22D3EE',
                'branches'    => [
                    ['name' => 'PHP',             'slug' => 'php',         'icon' => '🐘', 'order' => 1, 'description' => 'Server-side scripting language for the web.'],
                    ['name' => 'SQL',             'slug' => 'sql',         'icon' => '🗄️',  'order' => 2, 'description' => 'Database query language and design.'],
                    ['name' => 'Laravel',         'slug' => 'laravel',     'icon' => '🔴', 'order' => 3, 'description' => 'Elegant PHP web framework.'],
                    ['name' => 'API Development', 'slug' => 'api',         'icon' => '🔌', 'order' => 4, 'description' => 'Design and build RESTful and GraphQL APIs.'],
                ],
            ],
            [
                'name'        => 'Fullstack',
                'slug'        => 'fullstack',
                'description' => 'Master both frontend and backend to build complete web applications.',
                'icon'        => '🚀',
                'color'       => '#10B981',
                'branches'    => [
                    ['name' => 'HTML',            'slug' => 'html-fs',       'icon' => '📄', 'order' => 1, 'description' => 'Structure and semantics of web pages.'],
                    ['name' => 'CSS',             'slug' => 'css-fs',        'icon' => '🎨', 'order' => 2, 'description' => 'Style and layout of web pages.'],
                    ['name' => 'JavaScript',      'slug' => 'javascript-fs', 'icon' => '⚡', 'order' => 3, 'description' => 'Frontend and backend logic with JS.'],
                    ['name' => 'PHP',             'slug' => 'php-fs',        'icon' => '🐘', 'order' => 4, 'description' => 'Server-side scripting language.'],
                    ['name' => 'Laravel',         'slug' => 'laravel-fs',    'icon' => '🔴', 'order' => 5, 'description' => 'Build full applications with Laravel.'],
                    ['name' => 'API Development', 'slug' => 'api-fs',        'icon' => '🔌', 'order' => 6, 'description' => 'Connecting frontend with backend APIs.'],
                ],
            ],
        ];

        foreach ($tracks as $trackData) {
            $branches = $trackData['branches'];
            unset($trackData['branches']);

            $track = Track::create($trackData);

            foreach ($branches as $branchData) {
                $branchData['track_id'] = $track->id;
                Branch::create($branchData);
            }
        }
    }
}
