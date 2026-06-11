<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import DashboardTile from '@/components/DashboardTile.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
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
const collectsSorted = computed(() => props.season.collects.toSorted((a,b) => Date.parse(b.date_of) - Date.parse(a.date_of)));

const collectsToComplete = computed(() => collectsSorted.value.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) < Date.now();
}));

const collectsFuture = computed(() => collectsSorted.value.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) >= Date.now();
}));

const companiesSorted = computed(() => props.companies.toSorted((a, b) => b.score.total - a.score.total));
        
</script>

<template>
    <AdminLayout title="Dashboard" desc="Dashboard du module d'administration de la Blood League">
        <section id="dashboard" class="relative min-h-[calc(100vh-76px)] grid grid-cols-12 auto-rows-min gap-6 font-medium font-cooper py-16 px-40">
            <h1 class="col-span-12 font-bold text-4xl">Dashboard saison active : {{ props.season.year_of }}</h1>
            <div class="flex gap-4 justify-around col-span-12 items-center">
                <Link href="/admin/contacts" class="flex items-center px-3 h-11 rounded font-medium bg-brand-teal-400 hover:bg-teal-sage-500 active:bg-brand-teal-600 text-white w-fit">Formulaires de contact</Link>
                <Link href="/admin/collects/create" class="flex items-center px-3 h-11 rounded font-medium bg-brand-sage-400 hover:bg-brand-sage-500 active:bg-brand-sage-600 text-white w-fit">Nouvelle collecte</Link>
                <Link href="/admin/companies/create" class="flex items-center px-3 h-11 rounded font-medium bg-brand-rose-400 hover:bg-brand-rose-500 active:bg-brand-rose-600 text-white w-fit">Ajouter une entreprise</Link>
            </div>
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

            <div class="col-span-7">
                <!-- TABLE COLLECTE -->
                <div class="w-full flex justify-between px-2">
                    <h2 class="font-bold text-2xl my-2">Prochaines collectes</h2>
                    <Link href="/admin/collects" class="flex items-center px-4 mb-2 rounded font-medium text-brand-sage-400 hover:bg-brand-sage-100 active:bg-brand-sage-200">Voir tout →</Link>
                </div>
                <table class="table-auto border-collapse w-full text-md font-normal">
                    <thead class="bg-brand-sage-400 text-white text-lg border border-brand-sage-400">
                        <tr>
                            <th class="font-semibold p-2 text-start">Entreprise</th>
                            <th class="font-semibold p-2 text-start">Date</th>
                            <th class="font-semibold p-2 text-start">Rendez-vous</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border border-brand-neutral-100 font-medium"><td class="px-2 py-1">Prochaines collectes</td></tr>
                        <tr v-for="collect in collectsFuture" :key="collect.id">
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ props.companies.find((c) => c.id === collect.company_id)?.company_name }}</Link></td>
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of) }}</Link></td>
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointment_clicks }}</Link></td>
                        </tr>
                        <tr v-if="collectsFuture.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>
                        <tr class="border border-brand-neutral-100 font-medium"><td class="px-2 py-1">Collectes à compléter</td></tr>
                        <tr v-for="collect in collectsToComplete" :key="collect.id">
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ props.companies.find((c) => c.id === collect.company_id)?.company_name }}</Link></td>
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of) }}</Link></td>
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointment_clicks }}</Link></td>
                        </tr>
                        <tr v-if="collectsToComplete.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="col-span-5">
                <!-- TABLE VAINQUEURS -->
                <div class="w-full flex justify-between px-2">
                    <h2 class="font-bold text-2xl my-2">Vainqueurs provisoires</h2>
                    <Link href="/admin/companies" class="flex items-center px-4 mb-2 rounded font-medium text-brand-rose-400 hover:bg-brand-rose-50 active:bg-brand-rose-100">Voir tout →</Link>
                </div>
                <table class="table-auto border-collapse w-full text-md font-normal">
                    <thead class="bg-brand-rose-400 text-white text-lg border border-brand-rose-400">
                        <tr>
                            <th class="font-semibold p-2 text-start">Médaille</th>
                            <th class="font-semibold p-2 text-start">Entreprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category, index in props.season.wins" :key="index">
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${category.company_id}`">{{ category.short }}</Link></td>
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${category.company_id}`">{{ props.companies.find((c) => c.id === category.company_id)?.company_name }}</Link></td>
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
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ index+1 }}</Link></td>
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.company_name }}</Link></td>
                            <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.total }}</Link></td>
                        </tr>
                        <tr v-if="companiesSorted.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune entreprise</td></tr>
                        <tr v-if="companiesSorted.length > 5" class="italic  text-brand-neutral-500">
                            <td class="p-2 border border-brand-neutral-100">6</td>
                            <td class="p-2 border border-brand-neutral-100">...</td>
                            <td class="p-2 border border-brand-neutral-100"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </AdminLayout>
</template>
