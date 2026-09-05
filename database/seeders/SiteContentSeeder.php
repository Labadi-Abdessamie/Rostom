<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\SiteInfo;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        //! About page sections (hero, mission cards, team intro)
        $about = [
            ['type' => 'hero_title',         'title' => 'Building a marketplace that connects people, products, and possibilities.', 'sort_order' => 1],
            ['type' => 'hero_text',          'text'  => 'We started with one simple belief: small vendors deserve big reach. Today our platform powers thousands of sellers — from artisans to retailers — giving them the tools, visibility, and community to grow.', 'sort_order' => 1],
            ['type' => 'hero_caption_title', 'title' => 'Passion meets purpose.', 'sort_order' => 1],
            ['type' => 'hero_caption_text',  'text'  => 'Every feature we ship is designed to make commerce fairer.', 'sort_order' => 1],

            ['type' => 'mission_card', 'title' => 'Fair Commerce',  'text' => 'We believe sellers and buyers should both win. Our fees, policies, and tools are built for transparency.',                                  'icon' => 'fas fa-handshake', 'color' => 'purple', 'sort_order' => 1],
            ['type' => 'mission_card', 'title' => 'Sustainability','text' => 'We encourage local sourcing, reduced packaging waste, and responsible shipping practices.',                                                'icon' => 'fas fa-leaf',      'color' => 'green',  'sort_order' => 2],
            ['type' => 'mission_card', 'title' => 'People First',   'text' => 'Every team member is valued. We invest in growth, wellbeing, and inclusive culture.',                                                        'icon' => 'fas fa-users',     'color' => 'red',    'sort_order' => 3],

            ['type' => 'team_intro_title', 'title' => 'Meet the people behind the platform.', 'sort_order' => 1],
            ['type' => 'team_intro_text',  'text'  => 'From engineering to design, support to strategy — our team brings diverse perspectives to every challenge. Each member is committed to making commerce better for everyone.', 'sort_order' => 1],
        ];

        foreach ($about as $a) {
            AboutSection::updateOrCreate(
                ['type' => $a['type'], 'sort_order' => $a['sort_order']],
                array_merge($a, ['is_visible' => true])
            );
        }

        $stats = [
            ['key' => 'total_vendors',  'value' => '12K+', 'label' => 'Active Vendors',  'icon' => 'fas fa-store',    'sort_order' => 1],
            ['key' => 'total_products', 'value' => '5M+',  'label' => 'Products Listed', 'icon' => 'fas fa-box',      'sort_order' => 2],
            ['key' => 'total_members',  'value' => '850+', 'label' => 'Team Members',    'icon' => 'fas fa-users',    'sort_order' => 3],
            ['key' => 'total_wilayas',  'value' => '48',  'label' => 'Wilayas',        'icon' => 'fas fa-map',      'sort_order' => 4],
        ];

        foreach ($stats as $s) {
            SiteInfo::updateOrCreate(['key' => $s['key']], array_merge($s, ['is_visible' => true]));
        }

        // Remove legacy 'total_countries' row if it exists (replaced by total_wilayas)
        SiteInfo::where('key', 'total_countries')->delete();

        $team = [
            ['name' => 'Amira Benali',   'role' => 'CEO & Founder',     'department' => 'Leadership',  'bio' => 'Amira founded the platform with a vision to democratize e-commerce across the region. With 15+ years in tech leadership, she has scaled startups from seed to exit.', 'skills' => ['Business Strategy','Fundraising','Team Building'], 'sort_order' => 1],
            ['name' => 'Youssef Kader',  'role' => 'CTO',               'department' => 'Engineering','bio' => 'Youssef leads all engineering efforts, from platform infrastructure to mobile apps. A former senior engineer with deep distributed-systems experience.', 'skills' => ['Distributed Systems','Cloud Architecture','TypeScript','Go'], 'sort_order' => 2],
            ['name' => 'Lina Fares',     'role' => 'Head of Design',    'department' => 'Design',     'bio' => 'Lina shapes the visual and interaction language of every product. Her work has been featured in Awwwards and Smashing Magazine.', 'skills' => ['UX Research','Figma','Design Systems','Motion Design'], 'sort_order' => 3],
            ['name' => 'Tarek Maoui',    'role' => 'Operations Lead',   'department' => 'Operations', 'bio' => 'Tarek ensures logistics, vendor onboarding, and day-to-day operations run like clockwork. He introduced automation that cut fulfillment times by 40%.', 'skills' => ['Logistics','Process Automation','Supply Chain'], 'sort_order' => 4],
            ['name' => 'Sofia Rahmani',  'role' => 'Senior Engineer',   'department' => 'Engineering','bio' => 'Sofia architects backend services that power millions of daily transactions. A Laravel contributor and conference speaker.', 'skills' => ['Laravel','PostgreSQL','Redis','API Design'], 'sort_order' => 5],
            ['name' => 'Karim Belkacem', 'role' => 'Product Designer',  'department' => 'Design',     'bio' => 'Karim turns complex problems into elegant interfaces. He has designed for fintech, healthtech, and e-commerce platforms across three continents.', 'skills' => ['UI Design','Prototyping','HTML/CSS','Framer'], 'sort_order' => 6],
            ['name' => 'Nour Hadj',      'role' => 'Customer Success',  'department' => 'Support',    'bio' => 'Nour is the friendly voice behind our support team. She runs our weekly live Q&A sessions and resolves issues quickly.', 'skills' => ['Conflict Resolution','Communication','Zendesk','Community'], 'sort_order' => 7],
            ['name' => 'Ramy Cherif',    'role' => 'DevOps Engineer',   'department' => 'Engineering','bio' => 'Ramy keeps our systems reliable, scalable, and secure. He introduced CI/CD pipelines that reduced deployment time from hours to minutes.', 'skills' => ['Docker','Kubernetes','AWS','Terraform'], 'sort_order' => 8],
        ];

        foreach ($team as $t) {
            TeamMember::updateOrCreate(
                ['name' => $t['name']],
                array_merge($t, [
                    'email'    => strtolower(str_replace(' ', '.', $t['name'])) . '@company.com',
                    'twitter'  => 'https://twitter.com/' . strtolower(str_replace(' ', '', $t['name'])),
                    'linkedin' => 'https://linkedin.com/in/' . strtolower(str_replace(' ', '-', $t['name'])),
                    'status'   => true,
                ])
            );
        }
    }
}
