<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import DashboardTile from '@/components/DashboardTile.vue';

type seasonType = { 
    id: number;
    year_of: number;
    status: string;
    wins: { 
        climber: { 
            company_id: number;
            value: number;
        }, 
        flood: { 
            company_id: number;
            value: number;
        }, 
        pulse: { 
            company_id: number;
            value: number;
        }, 
        new_vein: { 
            company_id: number;
            value: number;
        } 
    }, 
    collects: [ 
        { 
            id: number;
            company_id: number;
            season_id: number;
            date_of: string;
            start_time: string;
            end_time: string;
            location: string;
            appointment_link: string;
            employees: number;
            appointments: number;
            donations: number;
            completed: number;
            donor_results: number;
            supporter_results: number;
            appointment_clicks: number;
            donor_shares: number;
            supporter_shares: number
        },
    ]
}

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

const props = defineProps<{
    season: seasonType,
    companies: Array<company>
}>()

// COMPUTE RESULTS

const companiesAmount = computed(() => props.companies?.length ?? 0);
const collectsAmount = computed(() => props.season?.collects.length ?? 0);

const appointmentClicksAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.appointment_clicks;
}, 0));
const appointmentsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.appointments;
}, 0));
const donationsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.donations;
}, 0));

const donorResultsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.donor_results;
}, 0));

const supporterResultsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.supporter_results;
}, 0));

const supporterSharesAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.supporter_shares;
}, 0));

const donorSharesAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.donor_shares;
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
        <DashboardTile color="rose" size="12">
            <div class="flex justify-between w-full">
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-5xl font-bold">{{ collectsAmount }}</h3>
                    <p class="text-xl">Collectes</p>
                </div>
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-5xl font-bold">{{ donationsAmount }}</h3>
                    <p class="text-xl">Dons effectifs</p>
                </div>
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-5xl font-bold">{{ efficiencyMean }}%</h3>
                    <p class="text-xl">Efficacité</p>
                </div>
            </div>
        </DashboardTile>
        <DashboardTile color="violet" size="3">
            <h3 class="text-3xl font-bold">{{ companiesAmount }}</h3>
            <p class="text-xl">Entreprises</p>
        </DashboardTile>
        <DashboardTile color="sage" size="3">
            <h3 class="text-3xl font-bold">{{ donorResultsAmount }}</h3>
            <p class="text-xl">Donneurs</p>
        </DashboardTile>
        <DashboardTile color="teal" size="3">
            <h3 class="text-3xl font-bold">{{ supporterResultsAmount }}</h3>
            <p class="text-xl">Supporters</p>
        </DashboardTile>
        <DashboardTile color="indigo" size="3">
            <h3 class="text-3xl font-bold">{{ donorSharesAmount + supporterSharesAmount }}</h3>
            <p class="text-xl">Kits comm téléchargés</p>
        </DashboardTile>
    </section>
    <p>{{ props.season }}</p>
    <p>{{ props.companies }}</p>
</template>