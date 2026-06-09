<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import DashboardTile from '@/components/DashboardTile.vue';
import { formatDate } from '@/lib/dateTimeFormatting';

type seasonType = { 
    id: number;
    year_of: number;
    status: string;
    wins: { 
        climber: {
            label: string,
            short: string,
            company_id: number;
            value: number;
        }, 
        flood: {
            label: string,
            short: string,
            company_id: number;
            value: number;
        }, 
        pulse: {
            label: string,
            short: string,
            company_id: number;
            value: number;
        }, 
        new_vein: {
            label: string,
            short: string,
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

const donationsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return carry + current.donations;
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

const appointmentsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
    return current.completed? carry + current.appointments : carry + current.appointment_clicks;
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

// FILTER LISTS
const collectsToComplete = computed(() => props.season.collects.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) < Date.now();
}));

const collectsFuture = computed(() => props.season.collects.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) >= Date.now();
}));

const companiesSorted = computed(() => props.companies.toSorted((a, b) => b.score.total - a.score.total));

const companiesClassic = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'classic'));

const companiesGold = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'gold'));

const companiesLegend = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'legend'));

        // <!-- TABLE ENTREPRISES -->
        // <table class="table-auto border-collapse col-span-6 self-start text-md font-normal">
        //     <thead class="bg-brand-teal-400 text-white text-lg border border-brand-teal-400">
        //         <tr>
        //             <th class="font-semibold p-2 text-start">Entreprise</th>
        //             <th class="font-semibold p-2 text-start">Points</th>
        //         </tr>
        //     </thead>
        //     <tbody>
        //         <tr class="border border-brand-neutral-100 font-medium"><p class="px-2 py-1">Division Legend</p></tr>
        //         <tr v-for="company in companiesLegend" :key="company.id">
        //             <td class="p-2 border border-brand-neutral-100">{{ company.company_name }}</td>
        //             <td class="p-2 border border-brand-neutral-100">{{ company.score.total }}</td>
        //         </tr>
        //         <tr v-if="companiesLegend.length === 0" class="border border-brand-neutral-100"><p class="p-2 italic  text-brand-neutral-500">Aucune entreprise</p></tr>

        //         <tr class="border border-brand-neutral-100 font-medium"><p class="px-2 py-1">Division Gold</p></tr>
        //         <tr v-for="company in companiesGold" :key="company.id">
        //             <td class="p-2 border border-brand-neutral-100">{{ company.company_name }}</td>
        //             <td class="p-2 border border-brand-neutral-100">{{ company.score.total }}</td>
        //         </tr>
        //         <tr v-if="companiesGold.length === 0" class="border border-brand-neutral-100"><p class="p-2 italic  text-brand-neutral-500">Aucune entreprise</p></tr>
                
        //         <tr class="border border-brand-neutral-100 font-medium"><p class="px-2 py-1">Division Classic</p></tr>
        //         <tr v-for="company in companiesClassic" :key="company.id">
        //             <td class="p-2 border border-brand-neutral-100">{{ company.company_name }}</td>
        //             <td class="p-2 border border-brand-neutral-100">{{ company.score.total }}</td>
        //         </tr>
        //         <tr v-if="companiesClassic.length === 0" class="border border-brand-neutral-100"><p class="p-2 italic  text-brand-neutral-500">Aucune entreprise</p></tr>
        //     </tbody>
        // </table>
        
</script>

<template>
    <header class="flex py-4 px-4 justify-between items-center bg-brand-neutral-100 lg:px-6" >
        <Link href="/" class="flex gap-3 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 lg:h-12">
            <span class="hidden lg:inline">✕</span>
            <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 hidden lg:inline">
        </Link>
        <Link href="/auth/logout" method="post" class="flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-200 active:bg-brand-neutral-300">Déconnexion</Link>
    </header>
    <section id="login" class="relative min-h-[calc(100vh-76px)] grid grid-cols-12 auto-rows-min gap-6 font-medium font-cooper py-16 px-40">
        <h1 class="col-span-12 font-bold text-4xl">Dashboard saison active : {{ props.season.year_of }}</h1>
        <DashboardTile color="rose" size="12" class="py-20">
            <div class="flex justify-between w-full">
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-5xl font-bold">{{ collectsAmount }}</h3>
                    <p>Collectes</p>
                </div>
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-5xl font-bold">{{ donationsAmount }}</h3>
                    <p>Dons effectifs</p>
                </div>
                <div class="flex flex-col w-200 gap-1 justify-center items-center">
                    <h3 class="text-5xl font-bold">{{ efficiencyMean }}%</h3>
                    <p>Efficacité</p>
                </div>
            </div>
        </DashboardTile>
        <DashboardTile color="violet" size="3">
            <h3 class="text-3xl font-bold">{{ companiesAmount }}</h3>
            <p>Entreprises</p>
        </DashboardTile>
        <DashboardTile color="sage" size="3">
            <h3 class="text-3xl font-bold">{{ appointmentsAmount }}</h3>
            <p>Rendez-vous pris</p>
        </DashboardTile>
        <DashboardTile color="teal" size="3">
            <h3 class="text-3xl font-bold">{{ supporterResultsAmount }}</h3>
            <p>Supporters</p>
        </DashboardTile>
        <DashboardTile color="indigo" size="3">
            <h3 class="text-3xl font-bold">{{donorSharesAmount + supporterSharesAmount }}</h3>
            <p>Kits téléchargés</p>
        </DashboardTile>

         <div class="col-span-6">
            <!-- TABLE VAINQUEURS -->
            <h2 class="font-bold text-2xl my-2">Vainqueurs provisoires</h2>
            <table class="table-auto border-collapse w-full text-md font-normal">
                <thead class="bg-brand-rose-400 text-white text-lg border border-brand-rose-400">
                    <tr>
                        <th class="font-semibold p-2 text-start">Médaille</th>
                        <th class="font-semibold p-2 text-start">Entreprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category, index in props.season.wins" :key="index">
                        <td class="p-2 border border-brand-neutral-100">{{ category.short }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ props.companies.find((c) => c.id === category.company_id)?.company_name }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- TABLE CLASSEMENT -->
            <h2 class="font-bold text-2xl mt-8 mb-2">Classement Blood League</h2>
            <table class="table-auto border-collapse w-full text-md font-normal">
                <thead class="bg-brand-teal-400 text-white text-lg border border-brand-teal-400">
                    <tr>
                        <th class="font-semibold p-2 text-start w-10">Rang</th>
                        <th class="font-semibold p-2 text-start">Entreprise</th>
                        <th class="font-semibold p-2 text-start">Points</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="company, index in companiesSorted.slice(0, 5)" :key="company.id">
                        <td class="p-2 border border-brand-neutral-100">{{ index+1 }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ company.company_name }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ company.score.total }}</td>
                    </tr>
                    <tr v-if="companiesSorted.length === 0" class="border border-brand-neutral-100"><p class="p-2 italic  text-brand-neutral-500">Aucune entreprise</p></tr>
                    <tr v-if="companiesSorted.length > 5" class="italic  text-brand-neutral-500">
                        <td class="p-2 border border-brand-neutral-100">6</td>
                        <td class="p-2 border border-brand-neutral-100">...</td>
                        <td class="p-2 border border-brand-neutral-100"></td>
                    </tr>
                </tbody>
            </table>
         </div>
        
         <div class="col-span-6">
            <!-- TABLE COLLECTE -->
            <h2 class="font-bold text-2xl my-2">Prochaines collectes</h2>
            <table class="table-auto border-collapse w-full text-md font-normal">
                <thead class="bg-brand-sage-400 text-white text-lg border border-brand-sage-400">
                    <tr>
                        <th class="font-semibold p-2 text-start">Entreprise</th>
                        <th class="font-semibold p-2 text-start">Date</th>
                        <th class="font-semibold p-2 text-start">Rendez-vous</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border border-brand-neutral-100 font-medium"><p class="px-2 py-1">Prochaines collectes</p></tr>
                    <tr v-for="collect in collectsFuture" :key="collect.id">
                        <td class="p-2 border border-brand-neutral-100">{{ props.companies.find((c) => c.id === collect.company_id)?.company_name }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ formatDate(collect.date_of) }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ collect.appointment_clicks }}</td>
                    </tr>
                    <tr v-if="collectsFuture.length === 0" class="border border-brand-neutral-100"><p class="p-2 italic  text-brand-neutral-500">Aucune collecte</p></tr>
                    <tr class="border border-brand-neutral-100 font-medium"><p class="px-2 py-1">Collectes à compléter</p></tr>
                    <tr v-for="collect in collectsToComplete" :key="collect.id">
                        <td class="p-2 border border-brand-neutral-100">{{ props.companies.find((c) => c.id === collect.company_id)?.company_name }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ formatDate(collect.date_of) }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ collect.appointment_clicks }}</td>
                    </tr>
                    <tr v-if="collectsToComplete.length === 0" class="border border-brand-neutral-100"><p class="p-2 italic  text-brand-neutral-500">Aucune collecte</p></tr>
                </tbody>
            </table>
        </div>

    </section>
</template>
