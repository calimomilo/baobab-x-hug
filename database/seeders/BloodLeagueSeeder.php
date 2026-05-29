<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BloodLeagueSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('seeder BloodLeagueSeeder en cours...');

        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = replica');
        }

        DB::table('wins')->truncate();
        DB::table('collect_data')->truncate();
        DB::table('collects')->truncate();
        DB::table('seasons')->truncate();
        DB::table('companies')->truncate();
        DB::table('contact_forms')->truncate();
        DB::table('users')->truncate();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = DEFAULT');
        }

        $this->seedSeasons();
        $this->seedCompanies();
        $this->seedCollects();
        $this->seedCollectData();
        $this->seedWins();
        $this->seedContactForms();
        $this->seedUsers();

        $this->command->info('✅ Blood League seedé avec succès !');
    }

    private function seedSeasons(): void
    {
        $now = Carbon::now();
        DB::table('seasons')->insert([
            ['id' => 1, 'year_of' => 2024, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'year_of' => 2025, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'year_of' => 2026, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('  → 3 saisons créées');
    }

    private function seedCompanies(): void
    {
        $now = Carbon::now();
        $companies = [
            [
                'id' => 1,
                'company_name' => 'Rolex SA',
                'address' => 'Rue François-Dussaud 3-7, 1227 Acacias',
                'contact_address' => 'Rue François-Dussaud 3-7, 1227 Acacias',
                'contact_name' => 'Sophie Marchand',
                'email' => 'sophie.marchand@rolex.example.ch',
                'phone' => '+41 22 302 22 00',
                'slug' => 'rolex',
                'primary_color' => '#006039',
                'secondary_color' => '#A37E2C',
                'logo_url' => 'logos/rolex.svg',
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'company_name' => 'Banque Pictet & Cie SA',
                'address' => 'Route des Acacias 60, 1211 Genève',
                'contact_address' => 'Route des Acacias 60, 1211 Genève',
                'contact_name' => 'Marc Dubois',
                'email' => 'marc.dubois@pictet.example.ch',
                'phone' => '+41 58 323 23 23',
                'slug' => 'pictet',
                'primary_color' => '#003E5C',
                'secondary_color' => '#C8A464',
                'logo_url' => 'logos/pictet.svg',
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'company_name' => 'Richemont International SA',
                'address' => 'Route des Biches 10, 1752 Villars-sur-Glâne',
                'contact_address' => 'Route des Biches 10, 1752 Villars-sur-Glâne',
                'contact_name' => 'Claire Berthier',
                'email' => 'claire.berthier@richemont.example.ch',
                'phone' => '+41 22 721 35 00',
                'slug' => 'richemont',
                'primary_color' => '#1A1A1A',
                'secondary_color' => '#B8860B',
                'logo_url' => 'logos/richemont.svg',
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('companies')->insert($companies);
        $this->command->info('  → 3 entreprises créées (Rolex, Pictet, Richemont)');
    }

    // Liens fictifs pour les rdv (pour pouvoir comptabiliser le clic)
    private function seedCollects(): void
    {
        $now = Carbon::now();

        $raw = [
            // ========== SAISON 2024 ==========
            // Rolex 2024
            [1, 1, 1, '2024-03-12', '09:00:00', '17:00:00', 'Rolex Acacias — Salle de conférence A', 'https://rdv.hug.ch/rolex-2024-q1', 5200, 72, 58],
            [2, 1, 1, '2024-06-18', '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2024-q2', 5200, 88, 71],
            [3, 1, 1, '2024-11-05', '09:00:00', '17:00:00', 'Rolex Acacias — Hall principal', 'https://rdv.hug.ch/rolex-2024-q4', 5200, 95, 78],
            // Pictet 2024
            [4, 2, 1, '2024-02-20', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2024-q1', 3400, 54, 38],
            [5, 2, 1, '2024-05-14', '08:30:00', '16:30:00', 'Pictet Acacias — Auditoire', 'https://rdv.hug.ch/pictet-2024-q2', 3400, 58, 42],
            [6, 2, 1, '2024-09-10', '08:30:00', '16:30:00', 'Pictet Acacias — Salle plénière', 'https://rdv.hug.ch/pictet-2024-q3', 3400, 61, 44],
            [7, 2, 1, '2024-12-03', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2024-q4', 3400, 56, 40],
            // Richemont 2024
            [8, 3, 1, '2024-04-23', '09:00:00', '17:00:00', 'Richemont Bellevue — Centre de conférences', 'https://rdv.hug.ch/richemont-2024-q2', 2800, 42, 28],
            [9, 3, 1, '2024-10-15', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2024-q4', 2800, 38, 25],

            // ========== SAISON 2025 ==========
            // Rolex 2025
            [10, 1, 2, '2025-02-25', '09:00:00', '17:00:00', 'Rolex Acacias — Salle de conférence A', 'https://rdv.hug.ch/rolex-2025-q1', 5200, 95, 82],
            [11, 1, 2, '2025-05-20', '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2025-q2', 5200, 102, 89],
            [12, 1, 2, '2025-09-09', '09:00:00', '17:00:00', 'Rolex Acacias — Hall principal', 'https://rdv.hug.ch/rolex-2025-q3', 5200, 110, 95],
            [13, 1, 2, '2025-11-25', '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2025-q4', 5200, 98, 86],
            // Pictet 2025
            [14, 2, 2, '2025-02-18', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2025-q1', 3400, 62, 46],
            [15, 2, 2, '2025-05-13', '08:30:00', '16:30:00', 'Pictet Acacias — Auditoire', 'https://rdv.hug.ch/pictet-2025-q2', 3400, 65, 49],
            [16, 2, 2, '2025-09-16', '08:30:00', '16:30:00', 'Pictet Acacias — Salle plénière', 'https://rdv.hug.ch/pictet-2025-q3', 3400, 71, 54],
            [17, 2, 2, '2025-12-02', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2025-q4', 3400, 68, 51],
            // Richemont 2025 (progression → The Climber)
            [18, 3, 2, '2025-03-11', '09:00:00', '17:00:00', 'Richemont Bellevue — Centre de conférences', 'https://rdv.hug.ch/richemont-2025-q1', 2800, 58, 42],
            [19, 3, 2, '2025-07-08', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2025-q3', 2800, 72, 55],
            [20, 3, 2, '2025-11-18', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2025-q4', 2800, 78, 61],

            // ========== SAISON 2026 (en cours) ==========
            // Rolex 2026 — collecte 1 terminée
            [21, 1, 3, '2026-02-24', '09:00:00', '17:00:00', 'Rolex Acacias — Salle de conférence A', 'https://rdv.hug.ch/rolex-2026-q1', 5200, 108, 94],
            // Rolex 2026 — collecte LIVE (mi-journée)
            [22, 1, 3, Carbon::now()->format('Y-m-d'), '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2026-q2', 5200, 47, 12],
            // Pictet 2026
            [23, 2, 3, '2026-03-04', '08:30:00', '16:30:00', 'Pictet Acacias — Salle plénière', 'https://rdv.hug.ch/pictet-2026-q1', 3400, 72, 56],
            // Richemont 2026
            [24, 3, 3, '2026-04-08', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2026-q1', 2800, 84, 67],
        ];

        $collects = array_map(fn($r) => [
            'id' => $r[0],
            'company_id' => $r[1],
            'season_id' => $r[2],
            'date_of' => $r[3],
            'start_time' => $r[4],
            'end_time' => $r[5],
            'location' => $r[6],
            'appointment_link' => $r[7],
            'employees' => $r[8],
            'appointments' => $r[9],
            'donations' => $r[10],
            'created_at' => $now,
            'updated_at' => $now,
        ], $raw);

        DB::table('collects')->insert($collects);
        $this->command->info('  → 24 collectes créées');
    }


    private function seedCollectData(): void
    {
        $data = [];
        $now = Carbon::now();
        $token = fn() => bin2hex(random_bytes(16));

        // ========== Saison 2024 ==========
        $this->fillCollectData($data, 1,  78, 73, 24, 33, 26, $token, $now);
        $this->fillCollectData($data, 2,  95, 89, 32, 41, 31, $token, $now);
        $this->fillCollectData($data, 3, 102, 96, 38, 44, 35, $token, $now);
        $this->fillCollectData($data, 4,  60, 55, 14, 26, 18, $token, $now);
        $this->fillCollectData($data, 5,  64, 59, 16, 27, 20, $token, $now);
        $this->fillCollectData($data, 6,  68, 62, 18, 29, 22, $token, $now);
        $this->fillCollectData($data, 7,  62, 57, 14, 27, 19, $token, $now);
        $this->fillCollectData($data, 8,  47, 43,  8, 20, 13, $token, $now);
        $this->fillCollectData($data, 9,  43, 39, 10, 18, 12, $token, $now);

        // ========== Saison 2025 ==========
        $this->fillCollectData($data, 10, 105, 97,  44, 45, 36, $token, $now);
        $this->fillCollectData($data, 11, 112, 104, 50, 48, 40, $token, $now);
        $this->fillCollectData($data, 12, 121, 112, 56, 52, 43, $token, $now);
        $this->fillCollectData($data, 13, 108, 100, 46, 46, 38, $token, $now);
        $this->fillCollectData($data, 14, 69, 63, 22, 30, 24, $token, $now);
        $this->fillCollectData($data, 15, 72, 66, 24, 31, 25, $token, $now);
        $this->fillCollectData($data, 16, 79, 72, 28, 34, 28, $token, $now);
        $this->fillCollectData($data, 17, 75, 69, 26, 32, 26, $token, $now);
        $this->fillCollectData($data, 18, 64, 59, 18, 28, 22, $token, $now);
        $this->fillCollectData($data, 19, 80, 73, 28, 34, 28, $token, $now);
        $this->fillCollectData($data, 20, 86, 79, 32, 37, 30, $token, $now);

        // ========== Saison 2026 ==========
        $this->fillCollectData($data, 21, 119, 110, 60, 51, 42, $token, $now);
        // Collecte LIVE (état mi-journée pour démo)
        $this->fillCollectData($data, 22,  52,  47,  7, 22, 18, $token, $now);
        $this->fillCollectData($data, 23,  79,  73, 30, 34, 28, $token, $now);
        $this->fillCollectData($data, 24,  92,  85, 42, 39, 32, $token, $now);

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('collect_data')->insert($chunk);
        }

        $this->command->info('  → ' . count($data) . ' lignes collect_data créées');
    }

    /**
     * Helper pour remplir collect_data avec les 5 types d'événements.
     * Chaque ligne a un session_id unique (contrainte DB).
     */
    private function fillCollectData(
        array &$data,
        int $collectId,
        int $donorResult,
        int $appointmentClic,
        int $donorShare,
        int $supporterResult,
        int $supporterShare,
        callable $token,
        Carbon $now
    ): void {
        $events = [
            'donor_result' => $donorResult,
            'appointment_clic' => $appointmentClic,
            'donor_share' => $donorShare,
            'supporter_result' => $supporterResult,
            'supporter_share' => $supporterShare,
        ];

        foreach ($events as $type => $count) {
            for ($i = 0; $i < $count; $i++) {
                $data[] = [
                    'collect_id' => $collectId,
                    'session_id' => $token(),
                    'data_type' => $type,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
    }


    private function seedWins(): void
    {
        $now = Carbon::now();

        $wins = [
            // ===== Saison 2024 =====
            ['company_id' => 1,    'season_id' => 1, 'category' => 'The Flood',    'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 3,    'season_id' => 1, 'category' => 'The Climber',  'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 1,    'season_id' => 1, 'category' => 'The Pulse',    'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 3,    'season_id' => 1, 'category' => 'The New Vein', 'created_at' => $now, 'updated_at' => $now],

            // ===== Saison 2025 =====
            ['company_id' => 1,    'season_id' => 2, 'category' => 'The Flood',    'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 3,    'season_id' => 2, 'category' => 'The Climber',  'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 1,    'season_id' => 2, 'category' => 'The Pulse',    'created_at' => $now, 'updated_at' => $now],
            ['company_id' => null, 'season_id' => 2, 'category' => 'The New Vein', 'created_at' => $now, 'updated_at' => $now],

            // Golden Heart 2024 et 2025 → non seedés (à saisir par les admins HUG)
        ];

        DB::table('wins')->insert($wins);
        $this->command->info('  → 8 médailles créées (Golden Heart laissé aux admins HUG)');
    }

    private function seedContactForms(): void
    {
        $now = Carbon::now();

        $contacts = [
            ['company_name' => 'Atelier Horloger Carouge SA',          'address' => 'Rue Vautier 8, 1227 Carouge',              'contact_address' => 'Rue Vautier 8, 1227 Carouge',              'contact_name' => 'Élodie Vernier',     'email' => 'e.vernier@atelier-carouge.example.ch', 'phone' => '+41 22 343 12 45', 'created_at' => $now, 'updated_at' => $now],
            ['company_name' => 'Cabinet Lefèvre & Associés',           'address' => 'Rue du Rhône 100, 1204 Genève',            'contact_address' => 'Rue du Rhône 100, 1204 Genève',            'contact_name' => 'Thomas Lefèvre',     'email' => 't.lefevre@cabinet-lefevre.example.ch', 'phone' => '+41 22 818 33 22', 'created_at' => $now, 'updated_at' => $now],
            ['company_name' => 'GeneLab Biotech SA',                   'address' => 'Chemin du Pré-Fleuri 5, 1228 Plan-les-Ouates', 'contact_address' => 'Chemin du Pré-Fleuri 5, 1228 Plan-les-Ouates', 'contact_name' => 'Dr. Sarah Müller', 'email' => 's.muller@genelab.example.ch',          'phone' => '+41 22 884 56 78', 'created_at' => $now, 'updated_at' => $now],
            ['company_name' => 'Café Lattéria Genève',                 'address' => 'Place du Bourg-de-Four 12, 1204 Genève',   'contact_address' => 'Place du Bourg-de-Four 12, 1204 Genève',   'contact_name' => 'Marco Rossi',        'email' => 'marco@latteria-geneve.example.ch',     'phone' => '+41 22 311 09 87', 'created_at' => $now, 'updated_at' => $now],
            ['company_name' => 'Studio Architecture Plan-les-Ouates', 'address' => 'Route des Jeunes 41, 1227 Carouge',        'contact_address' => 'Route des Jeunes 41, 1227 Carouge',        'contact_name' => 'Anaïs Charpentier',  'email' => 'a.charpentier@studio-plo.example.ch',  'phone' => '+41 22 552 14 30', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('contact_forms')->insert($contacts);
        $this->command->info('  → 5 demandes de contact créées');
    }

    private function seedUsers(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'username' => 'root',
                'password' => bcrypt('blood-league-2026'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->command->info('  → 1 compte admin créé (root / blood-league-2026)');
    }
}
