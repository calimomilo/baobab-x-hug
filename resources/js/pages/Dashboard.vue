<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import DashboardTile from '@/components/DashboardTile.vue';

/* { 
"id": 3, 
"year_of": 2026, 
"status": "open", 
"wins": { 
    "climber": { 
        "company_id": 10, 
        "value": 0 
    }, 
    "flood": { ... }, 
    "pulse": { ... }, 
    "new_vein": { ... } 
}, 
"collects": [ 
    { 
        "id": 21, 
        "company_id": 1, 
        "season_id": 3, 
        "date_of": "2026-02-24", 
        "start_time": "09:00:00", 
        "end_time": "17:00:00", 
        "location": "Rolex Acacias — Salle de conférence A", 
        "appointment_link": "https://rdv.hug.ch/rolex-2026-q1", 
        "employees": 5200, 
        "appointments": 108, 
        "donations": 98, 
        "completed": 1, 
    },
    
] */

type company = {
    id: number;
    company_name: string;
    logo_url: string;
    label: {
        name: string;
        slug: string;
    };
    score: { 
        efficacite: number;
        frequence: number;
        donneurs: number;
        supporters: number;
        total: number; 
        max: number;
        raw: { 
            collects_count: number;
            appointments: number;
            donations: number;
            supporters: number;
            supporter_shares: number;
            employees: number;
            taux_efficacite: number;
            taux_participation: number;
            taux_supporters: number;
        };
    };
};

const props = defineProps({
    season: Object,
    companies: Array<company>
})

// COMPUTE RESULTS

const companiesAmount = computed(() => props.companies?.length ?? 0);
const collectsAmount = computed(() => props.season?.collects.length ?? 0);

const donationsAmount = computed(() => props.companies?.reduce((carry, amount) => {
    return carry + amount.score.raw.donations;
}, 0));

const supportersAmount = computed(() => props.companies?.reduce((carry, amount) => {
    return carry + amount.score.raw.supporters;
}, 0));

const efficiencyMean = computed(() => {
    if (companiesAmount.value === 0) {
        return 0;
    }

    const sum = props.companies?.reduce((carry, amount) => {
        return carry + amount.score.raw.taux_efficacite;
    }, 0) ?? 0;

    return Math.round(sum*100/companiesAmount.value)/100.0;
});

</script>

<template>
    <header class="flex py-4 px-4 justify-between items-center bg-brand-neutral-100 lg:px-6" >
        <Link href="/" class="flex gap-3 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 lg:h-12">
            <span class="hidden lg:inline">✕</span>
            <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 hidden lg:inline">
        </Link>
        <Link href="/auth/logout" method="post">Déconnexion</Link>
    </header>
    <section id="login" class="relative min-h-[calc(100vh-76px)] grid grid-cols-12 gap-6 font-medium font-cooper py-16 px-40">
        <DashboardTile color="teal" size="12">
            <div class="flex justify-between w-full">
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-3xl font-bold">{{ donationsAmount }}</h3>
                    <p class="text-xl">Dons effectifs</p>
                </div>
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-3xl font-bold">{{ efficiencyMean }}%</h3>
                    <p class="text-xl">Efficacité</p>
                </div>
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-3xl font-bold">{{ collectsAmount }}</h3>
                    <p class="text-xl">Collectes</p>
                </div>
            </div>
        </DashboardTile>
        <DashboardTile color="rose" size="3">
            <h3 class="text-3xl font-bold">{{ companiesAmount }}</h3>
            <p class="text-xl">Entreprises</p>
        </DashboardTile>
        <DashboardTile color="rose" size="3">
            <h3 class="text-3xl font-bold">{{ supportersAmount }}</h3>
            <p class="text-xl">Supporters</p>
        </DashboardTile>
    </section>
    <p>{{ props.season }}</p>
    <p>{{ props.companies }}</p>
</template>