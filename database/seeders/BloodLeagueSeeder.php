<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            ['id' => 1, 'year_of' => 2024, 'status' => 'closed', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'year_of' => 2025, 'status' => 'closed', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'year_of' => 2026, 'status' => 'open', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('  → 3 saisons créées');
    }

    private function seedCompanies(): void
    {
        $now = Carbon::now();
        $companies = [
            [
                'id' => 1,
                'company_name' => 'Rolex',
                'address' => 'Rue François-Dussaud 3-7, 1227 Acacias',
                'contact_address' => 'Rue François-Dussaud 3-7, 1227 Acacias',
                'contact_name' => 'Sophie Marchand',
                'email' => 'sophie.marchand@rolex.example.ch',
                'phone' => '+41 22 302 22 00',
                'slug' => $this->randomSlug(),
                'primary_color' => '#006039',
                'secondary_color' => '#A37E2C',
                'logo_url' => $this->importLogo('rolex', 'Rolex.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'company_name' => 'Banque Pictet & Cie',
                'address' => 'Route des Acacias 60, 1211 Genève',
                'contact_address' => 'Route des Acacias 60, 1211 Genève',
                'contact_name' => 'Marc Dubois',
                'email' => 'marc.dubois@pictet.example.ch',
                'phone' => '+41 58 323 23 23',
                'slug' => $this->randomSlug(),
                'primary_color' => '#a90000',
                'secondary_color' => '#313131',
                'logo_url' => $this->importLogo('pictet', 'pictet-logo.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'company_name' => 'Richemont International',
                'address' => 'Route des Biches 10, 1752 Villars-sur-Glâne',
                'contact_address' => 'Route des Biches 10, 1752 Villars-sur-Glâne',
                'contact_name' => 'Claire Berthier',
                'email' => 'claire.berthier@richemont.example.ch',
                'phone' => '+41 22 721 35 00',
                'slug' => $this->randomSlug(),
                'primary_color' => '#04348c',
                'secondary_color' => '#059fff',
                'logo_url' => $this->importLogo('richemont', 'Logo_Richemont.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'company_name' => 'Givaudan',
                'address' => 'Chemin de la Parfumerie 5, 1214 Vernier',
                'contact_address' => 'Chemin de la Parfumerie 5, 1214 Vernier',
                'contact_name' => 'Julien Favre',
                'email' => 'julien.favre@givaudan.example.ch',
                'phone' => '+41 22 780 91 11',
                'slug' => $this->randomSlug(),
                'primary_color' => '#1a1818',
                'secondary_color' => '#a40a0a',
                'logo_url' => $this->importLogo('givaudan', 'Givaudan_logotype.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'company_name' => 'SGS',
                'address' => 'Place des Alpes 1, 1201 Genève',
                'contact_address' => 'Place des Alpes 1, 1201 Genève',
                'contact_name' => 'Nathalie Roux',
                'email' => 'nathalie.roux@sgs.example.ch',
                'phone' => '+41 22 739 91 11',
                'slug' => $this->randomSlug(),
                'primary_color' => '#FF6900',
                'secondary_color' => '#464646',
                'logo_url' => $this->importLogo('sgs', 'SGS_LOGO.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'company_name' => 'Patek Philippe',
                'address' => 'Chemin du Pont-du-Centenaire 141, 1228 Plan-les-Ouates',
                'contact_address' => 'Chemin du Pont-du-Centenaire 141, 1228 Plan-les-Ouates',
                'contact_name' => 'Camille Girard',
                'email' => 'camille.girard@patek.example.ch',
                'phone' => '+41 22 884 20 20',
                'slug' => $this->randomSlug(),
                'primary_color' => '#9C7C38',
                'secondary_color' => '#1A1A1A',
                'logo_url' => $this->importLogo('patek-philippe', 'Logo_Patek_Philippe.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'company_name' => 'Banque Lombard Odier & Cie',
                'address' => 'Rue de la Corraterie 1, 1204 Genève',
                'contact_address' => 'Rue de la Corraterie 1, 1204 Genève',
                'contact_name' => 'Philippe Mercier',
                'email' => 'philippe.mercier@lombardodier.example.ch',
                'phone' => '+41 22 709 21 11',
                'slug' => $this->randomSlug(),
                'primary_color' => '#121212',
                'secondary_color' => '#A6926A',
                'logo_url' => $this->importLogo('lombard-odier', 'Lombard_Odier_logo.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'company_name' => 'JT International (JTI)',
                'address' => 'Rue Kazem-Radjavi 8, 1202 Genève',
                'contact_address' => 'Rue Kazem-Radjavi 8, 1202 Genève',
                'contact_name' => 'Sandra Keller',
                'email' => 'sandra.keller@jti.example.ch',
                'phone' => '+41 22 703 07 77',
                'slug' => $this->randomSlug(),
                'primary_color' => '#00843D',
                'secondary_color' => '#000000',
                'logo_url' => $this->importLogo('jti', 'JTI_Logo.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'company_name' => 'Mediterranean Shipping Company (MSC)',
                'address' => 'Chemin Rieu 12-14, 1208 Genève',
                'contact_address' => 'Chemin Rieu 12-14, 1208 Genève',
                'contact_name' => 'Antoine Blanc',
                'email' => 'antoine.blanc@msc.example.ch',
                'phone' => '+41 22 703 88 88',
                'slug' => $this->randomSlug(),
                'primary_color' => '#002F6C',
                'secondary_color' => '#1f68fa',
                'logo_url' => $this->importLogo('msc', 'Mediterranean_Shipping_Company_logo.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'company_name' => 'Firmenich',
                'address' => 'Rue de la Bergère 7, 1242 Satigny',
                'contact_address' => 'Rue de la Bergère 7, 1242 Satigny',
                'contact_name' => 'Laure Fontaine',
                'email' => 'laure.fontaine@firmenich.example.ch',
                'phone' => '+41 22 780 22 11',
                'slug' => $this->randomSlug(),
                'primary_color' => '#0033A0',
                'secondary_color' => '#fff757',
                'logo_url' => $this->importLogo('firmenich', 'Firmenich_(Unternehmen)_logo.svg.png'),
                'anonymous' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('companies')->insert($companies);
        $this->command->info('  → 10 entreprises créées (Rolex, Pictet, Richemont, Givaudan, SGS, Patek Philippe, Lombard Odier, JTI, MSC, Firmenich)');
    }


    /**
     * Slugs déjà générés dans ce run, pour garantir l'unicité du lot.
     *
     * @var array<int, string>
     */
    private array $usedSlugs = [];

    /**
     * Génère un slug aléatoire imprévisible de 16 caractères (a-z minuscules + chiffres,
     * sans caractères ambigus 0/o/1/l), unique au sein du seeder.
     */
    private function randomSlug(int $length = 16): string
    {
        $alphabet = '23456789abcdefghjkmnpqrstuvwxyz';

        do {
            $slug = '';
            for ($i = 0; $i < $length; $i++) {
                $slug .= $alphabet[random_int(0, strlen($alphabet) - 1)];
            }
        } while (in_array($slug, $this->usedSlugs, true));

        $this->usedSlugs[] = $slug;

        return $slug;
    }

    private function importLogo(string $name, string $sourceFile): string
    {
        $source = database_path('seeders/logos/'.$sourceFile);
        $extension = pathinfo($sourceFile, PATHINFO_EXTENSION) ?: 'png';
        $target = 'logos/'.$name.'.'.$extension;

        if (File::exists($source)) {
            Storage::disk('public')->put($target, File::get($source));
        } else {
            $this->command->warn("Logo introuvable : {$sourceFile}");
        }

        return '/storage/'.$target;
    }

    // Liens fictifs pour les rdv (pour pouvoir comptabiliser le clic)
    private function seedCollects(): void
    {
        $now = Carbon::now();

        $raw = [
            // ========== SAISON 2024 ==========
            // Rolex 2024
            [1, 1, 1, '2024-03-12', '09:00:00', '17:00:00', 'Rolex Acacias — Salle de conférence A', 'https://rdv.hug.ch/rolex-2024-q1', 5200, 72, 58, 1],
            [2, 1, 1, '2024-06-18', '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2024-q2', 5200, 88, 71, 1],
            [3, 1, 1, '2024-11-05', '09:00:00', '17:00:00', 'Rolex Acacias — Hall principal', 'https://rdv.hug.ch/rolex-2024-q4', 5200, 95, 78, 1],
            // Pictet 2024
            [4, 2, 1, '2024-02-20', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2024-q1', 3400, 54, 38, 1],
            [5, 2, 1, '2024-05-14', '08:30:00', '16:30:00', 'Pictet Acacias — Auditoire', 'https://rdv.hug.ch/pictet-2024-q2', 3400, 58, 42, 1],
            [6, 2, 1, '2024-09-10', '08:30:00', '16:30:00', 'Pictet Acacias — Salle plénière', 'https://rdv.hug.ch/pictet-2024-q3', 3400, 61, 44, 1],
            [7, 2, 1, '2024-12-03', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2024-q4', 3400, 56, 40, 1],
            // Richemont 2024
            [8, 3, 1, '2024-04-23', '09:00:00', '17:00:00', 'Richemont Bellevue — Centre de conférences', 'https://rdv.hug.ch/richemont-2024-q2', 2800, 42, 28, 1],
            [9, 3, 1, '2024-10-15', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2024-q4', 2800, 38, 25, 1],

            // ========== SAISON 2025 ==========
            // Rolex 2025
            [10, 1, 2, '2025-02-25', '09:00:00', '17:00:00', 'Rolex Acacias — Salle de conférence A', 'https://rdv.hug.ch/rolex-2025-q1', 5200, 95, 82, 1],
            [11, 1, 2, '2025-05-20', '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2025-q2', 5200, 102, 89, 1],
            [12, 1, 2, '2025-09-09', '09:00:00', '17:00:00', 'Rolex Acacias — Hall principal', 'https://rdv.hug.ch/rolex-2025-q3', 5200, 110, 95, 1],
            [13, 1, 2, '2025-11-25', '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2025-q4', 5200, 98, 86, 1],
            // Pictet 2025
            [14, 2, 2, '2025-02-18', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2025-q1', 3400, 62, 46, 1],
            [15, 2, 2, '2025-05-13', '08:30:00', '16:30:00', 'Pictet Acacias — Auditoire', 'https://rdv.hug.ch/pictet-2025-q2', 3400, 65, 49, 1],
            [16, 2, 2, '2025-09-16', '08:30:00', '16:30:00', 'Pictet Acacias — Salle plénière', 'https://rdv.hug.ch/pictet-2025-q3', 3400, 71, 54, 1],
            [17, 2, 2, '2025-12-02', '08:30:00', '16:30:00', 'Pictet Acacias — Centre de formation', 'https://rdv.hug.ch/pictet-2025-q4', 3400, 68, 51, 1],
            // Richemont 2025 (progression → The Climber)
            [18, 3, 2, '2025-03-11', '09:00:00', '17:00:00', 'Richemont Bellevue — Centre de conférences', 'https://rdv.hug.ch/richemont-2025-q1', 2800, 58, 42, 1],
            [19, 3, 2, '2025-07-08', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2025-q3', 2800, 72, 55, 1],
            [20, 3, 2, '2025-11-18', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2025-q4', 2800, 78, 61, 1],

            // ========== SAISON 2026 (en cours) ==========
            [21, 1, 3, '2026-02-24', '09:00:00', '17:00:00', 'Rolex Acacias — Salle de conférence A', 'https://rdv.hug.ch/rolex-2026-q1', 5200, 108, 98, 1],
            // Rolex 2026 — collecte LIVE (mi-journée)
            [22, 1, 3, Carbon::now()->format('Y-m-d'), '09:00:00', '17:00:00', 'Rolex Plan-les-Ouates — Auditoire central', 'https://rdv.hug.ch/rolex-2026-q2', 5200, 47, 12, 0],
            // Pictet 2026 (GOLD : efficacité 77.8% → 32, supporters 70.6% → 8)
            [23, 2, 3, '2026-03-04', '08:30:00', '16:30:00', 'Pictet Acacias — Salle plénière', 'https://rdv.hug.ch/pictet-2026-q1', 3400, 72, 56, 1],
            // Richemont 2026 (CLASSIC : efficacité 65.5% → 24, supporters 35.9% → 6)
            [24, 3, 3, '2026-04-08', '09:00:00', '17:00:00', 'Richemont Bellevue — Hall A', 'https://rdv.hug.ch/richemont-2026-q1', 2800, 84, 55, 1],
            // Givaudan 2026 (LEGEND)
            [25, 4, 3, '2026-03-18', '09:00:00', '17:00:00', 'Givaudan Vernier — Centre de R&D', 'https://rdv.hug.ch/givaudan-2026-q1', 4800, 96, 89, 1],
            // SGS 2026 (GOLD)
            [26, 5, 3, '2026-03-25', '08:30:00', '16:30:00', 'SGS Genève — Siège Place des Alpes', 'https://rdv.hug.ch/sgs-2026-q1', 3000, 80, 64, 1],
            // Patek Philippe 2026 (LEGEND)
            [27, 6, 3, '2026-04-15', '09:00:00', '17:00:00', 'Patek Philippe Plan-les-Ouates — Manufacture', 'https://rdv.hug.ch/patek-2026-q1', 2500, 88, 80, 1],
            // Lombard Odier 2026 (GOLD)
            [28, 7, 3, '2026-04-22', '08:30:00', '16:30:00', 'Lombard Odier — Rue de la Corraterie', 'https://rdv.hug.ch/lombardodier-2026-q1', 2600, 60, 48, 1],
            // JTI 2026 (CLASSIC)
            [29, 8, 3, '2026-05-06', '09:00:00', '17:00:00', 'JTI Genève — World Headquarters', 'https://rdv.hug.ch/jti-2026-q1', 2400, 70, 42, 1],
            // MSC 2026 (GOLD)
            [30, 9, 3, '2026-05-13', '08:30:00', '16:30:00', 'MSC Genève — Chemin Rieu', 'https://rdv.hug.ch/msc-2026-q1', 4500, 90, 72, 1],
            // Firmenich 2026 (CLASSIC)
            [31, 10, 3, '2026-05-20', '09:00:00', '17:00:00', 'Firmenich Satigny — Site de production', 'https://rdv.hug.ch/firmenich-2026-q1', 3200, 78, 47, 1],

            // ========== SAISON 2025 — nouvelles entreprises ==========
            [32, 4, 2, '2025-04-16', '09:00:00', '17:00:00', 'Givaudan Vernier — Centre de R&D', 'https://rdv.hug.ch/givaudan-2025-q2', 4800, 92, 85, 1],
            [33, 5, 2, '2025-04-23', '08:30:00', '16:30:00', 'SGS Genève — Siège Place des Alpes', 'https://rdv.hug.ch/sgs-2025-q2', 3000, 76, 61, 1],
            [34, 6, 2, '2025-05-14', '09:00:00', '17:00:00', 'Patek Philippe Plan-les-Ouates — Manufacture', 'https://rdv.hug.ch/patek-2025-q2', 2500, 84, 77, 1],
            [35, 7, 2, '2025-05-21', '08:30:00', '16:30:00', 'Lombard Odier — Rue de la Corraterie', 'https://rdv.hug.ch/lombardodier-2025-q2', 2600, 58, 46, 1],
            [36, 8, 2, '2025-06-04', '09:00:00', '17:00:00', 'JTI Genève — World Headquarters', 'https://rdv.hug.ch/jti-2025-q2', 2400, 66, 40, 1],
            [37, 9, 2, '2025-06-11', '08:30:00', '16:30:00', 'MSC Genève — Chemin Rieu', 'https://rdv.hug.ch/msc-2025-q2', 4500, 86, 69, 1],
            [38, 10, 2, '2025-06-18', '09:00:00', '17:00:00', 'Firmenich Satigny — Site de production', 'https://rdv.hug.ch/firmenich-2025-q2', 3200, 74, 45, 1],

            [39, 1, 3, Carbon::now()->addDays(15)->format('Y-m-d'), '09:00:00', '17:00:00', 'Rolex Acacias — Salle de conférence A', 'https://rdv.hug.ch/rolex-2026-q3', 5200, 84, 0, 0],
            [40, 4, 3, Carbon::now()->addDays(22)->format('Y-m-d'), '09:00:00', '17:00:00', 'Givaudan Vernier — Centre de R&D', 'https://rdv.hug.ch/givaudan-2026-q2', 4800, 68, 0, 0],
            [41, 6, 3, Carbon::now()->addMonths(3)->format('Y-m-d'), '09:00:00', '17:00:00', 'Patek Philippe Plan-les-Ouates — Manufacture', 'https://rdv.hug.ch/patek-2026-q2', 2500, 72, 0, 0],
            [42, 5, 3, Carbon::now()->addMonths(4)->format('Y-m-d'), '08:30:00', '16:30:00', 'SGS Genève — Siège Place des Alpes', 'https://rdv.hug.ch/sgs-2026-q2', 3000, 58, 0, 0],
            [43, 9, 3, Carbon::now()->addMonths(4)->addDays(14)->format('Y-m-d'), '08:30:00', '16:30:00', 'MSC Genève — Chemin Rieu', 'https://rdv.hug.ch/msc-2026-q2', 4500, 80, 0, 0],
            [44, 2, 3, Carbon::now()->addMonths(5)->format('Y-m-d'), '08:30:00', '16:30:00', 'Pictet Acacias — Salle plénière', 'https://rdv.hug.ch/pictet-2026-q2', 3400, 54, 0, 0],
            [45, 10, 3, Carbon::now()->addMonths(6)->format('Y-m-d'), '09:00:00', '17:00:00', 'Firmenich Satigny — Site de production', 'https://rdv.hug.ch/firmenich-2026-q2', 3200, 49, 0, 0],

            // ========== SAISON 2026 — EN ATTENTE DE VALIDATION ADMIN ==========
            // Collectes déjà déroulées (date passée, RDV enregistrés) mais dont les DONS
            // doivent encore être saisis à la main puis validés par un admin.
            // → donations = 0 et completed = 0 (l'admin entre le nombre de dons puis valide).
            [46, 8, 3, '2026-05-27', '09:00:00', '17:00:00', 'JTI Genève — World Headquarters', 'https://rdv.hug.ch/jti-2026-q2', 2400, 58, 0, 0],
            [47, 7, 3, '2026-06-02', '08:30:00', '16:30:00', 'Lombard Odier — Rue de la Corraterie', 'https://rdv.hug.ch/lombardodier-2026-q2', 2600, 49, 0, 0],
        ];

        $collects = array_map(fn ($r) => [
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
            'completed' => $r[11],
        ], $raw);

        DB::table('collects')->insert($collects);
        $this->command->info('  → '.count($collects).' collectes créées (dont 7 RDV à venir non encore déroulés, et 2 déroulées en attente de saisie/validation des dons par l\'admin)');
    }

    private function seedCollectData(): void
    {
        $data = [];
        $now = Carbon::now();
        $token = fn () => bin2hex(random_bytes(16));

        // ========== Saison 2024 ==========
        $this->fillCollectData($data, 1, 78, 73, 24, 33, 26, $token, $now);
        $this->fillCollectData($data, 2, 95, 89, 32, 41, 31, $token, $now);
        $this->fillCollectData($data, 3, 102, 96, 38, 44, 35, $token, $now);
        $this->fillCollectData($data, 4, 60, 55, 14, 26, 18, $token, $now);
        $this->fillCollectData($data, 5, 64, 59, 16, 27, 20, $token, $now);
        $this->fillCollectData($data, 6, 68, 62, 18, 29, 22, $token, $now);
        $this->fillCollectData($data, 7, 62, 57, 14, 27, 19, $token, $now);
        $this->fillCollectData($data, 8, 47, 43, 8, 20, 13, $token, $now);
        $this->fillCollectData($data, 9, 43, 39, 10, 18, 12, $token, $now);

        // ========== Saison 2025 ==========
        $this->fillCollectData($data, 10, 105, 97, 44, 45, 36, $token, $now);
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
        // Rolex — LEGEND (41/45 = 91% → 12)
        $this->fillCollectData($data, 21, 119, 110, 60, 45, 41, $token, $now);
        // Collecte LIVE (état mi-journée pour démo)
        $this->fillCollectData($data, 22, 52, 47, 7, 22, 18, $token, $now);
        // Rolex — LEGEND : eff 90.7% → 40, supporters 91.1% → 12 ⇒ total 59
        // Pictet — GOLD : eff 77.8% → 32, supporters 91.2% → 12 ⇒ total 51
        $this->fillCollectData($data, 23, 79, 73, 30, 34, 31, $token, $now);
        // Richemont — CLASSIC : eff 65.5% → 24, supporters 56.4% → 8 ⇒ total 39
        $this->fillCollectData($data, 24, 92, 85, 42, 39, 22, $token, $now);
        // Givaudan — LEGEND : eff 92.7% → 40, supporters 84% → 10 ⇒ total 57
        $this->fillCollectData($data, 25, 98, 92, 50, 50, 42, $token, $now);
        // SGS — GOLD : eff 80% → 32, supporters 77.8% → 10 ⇒ total 49
        $this->fillCollectData($data, 26, 71, 78, 34, 36, 28, $token, $now);
        // Patek Philippe — LEGEND : eff 90.9% → 40, supporters 65.8% → 8 ⇒ total 55
        $this->fillCollectData($data, 27, 86, 86, 40, 38, 25, $token, $now);
        // Lombard Odier — GOLD : eff 80% → 32, supporters 40% → 6 ⇒ total 45
        $this->fillCollectData($data, 28, 53, 58, 26, 30, 12, $token, $now);
        // JTI — CLASSIC : eff 60% → 24, supporters 34.4% → 6 ⇒ total 37
        $this->fillCollectData($data, 29, 46, 68, 22, 32, 11, $token, $now);
        // MSC — GOLD : eff 80% → 32, supporters 65% → 8 ⇒ total 47
        $this->fillCollectData($data, 30, 79, 88, 38, 40, 26, $token, $now);
        // Firmenich — CLASSIC : eff 60.3% → 24, supporters 17.6% → 4 ⇒ total 35
        $this->fillCollectData($data, 31, 51, 76, 24, 34, 6, $token, $now);

        $this->fillCollectData($data, 32, 94, 90, 50, 48, 44, $token, $now); // Givaudan
        $this->fillCollectData($data, 33, 67, 74, 32, 34, 21, $token, $now); // SGS
        $this->fillCollectData($data, 34, 85, 82, 38, 36, 33, $token, $now); // Patek
        $this->fillCollectData($data, 35, 51, 56, 24, 28, 17, $token, $now); // Lombard Odier
        $this->fillCollectData($data, 36, 44, 64, 20, 30, 10, $token, $now); // JTI
        $this->fillCollectData($data, 37, 76, 84, 36, 38, 25, $token, $now); // MSC
        $this->fillCollectData($data, 38, 49, 72, 22, 32, 11, $token, $now); // Firmenich

        $this->fillCollectData($data, 39, 47, 38, 9, 14, 7, $token, $now); // Rolex (à venir)
        $this->fillCollectData($data, 40, 41, 30, 7, 11, 6, $token, $now); // Givaudan (à venir)
        $this->fillCollectData($data, 41, 55, 32, 7, 10, 5, $token, $now); // Patek (à venir)
        $this->fillCollectData($data, 42, 32, 26, 6, 9, 4, $token, $now); // SGS (à venir)
        $this->fillCollectData($data, 43, 40, 34, 8, 12, 6, $token, $now); // MSC (à venir)
        $this->fillCollectData($data, 44, 31, 24, 5, 8, 4, $token, $now); // Pictet (à venir)
        $this->fillCollectData($data, 45, 35, 22, 5, 7, 3, $token, $now); // Firmenich (à venir)
        $this->fillCollectData($data, 46, 49, 46, 8, 10, 6, $token, $now); // JTI (dons à valider)
        $this->fillCollectData($data, 47, 53, 40, 7, 9, 5, $token, $now); // Lombard Odier (dons à valider)

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('collect_data')->insert($chunk);
        }

        $this->command->info('  → '.count($data).' lignes collect_data créées');
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
