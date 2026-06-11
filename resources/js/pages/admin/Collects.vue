<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { formatDate } from '@/lib/dateTimeFormatting';

// import { Link } from '@inertiajs/vue3';
// import { computed } from 'vue';
// import DashboardTile from '@/components/DashboardTile.vue';
// import { formatDate } from '@/lib/dateTimeFormatting';

type collect = {
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
    supporter_shares: number;
    company: {
        id: number;
        company_name: string;
        address: string;
        contact_address: string;
        contact_name: string;
        email: string;
        phone: string;
        slug: string;
        primary_color: string;
        secondary_color: string;
        logo_url: string;
        anonymous: boolean;
    };
    season: season;
}

type season = {
    id: number;
    year_of: number;
    status: string;
}

const props = defineProps<{
    collects: Array<collect>,
}>()

// SEASONS HANDLING
const seasons = ref<Array<season>>([]);

props.collects.forEach((c) => {
    if (!seasons.value.find((s) => s.id === c.season_id)) {
        seasons.value.push(c.season);
    }
})
seasons.value.sort((a,b) => b.year_of - a.year_of);

const activeSeasonPosition = ref(seasons.value.findIndex((s) => s.status === 'open'));
const activeSeason = computed(() => seasons.value[activeSeasonPosition.value]);
    
const nextSeason = () => {
    activeSeasonPosition.value = seasons.value.findIndex((s) => s.id === activeSeason.value.id) - 1;
}

const prevSeason = () => {
    activeSeasonPosition.value = seasons.value.findIndex((s) => s.id === activeSeason.value.id) + 1;
}

// COMPUTE RESULTS

const scoreEfficacite = (collect: collect) => {
    const rate = collect.donations/collect.appointments;

    if (rate >= 0.9) {
        return 40;
    } else if (rate >= 0.75) {
        return 32;
    } else if (rate >= 0.5) {
        return 24;
    } else if (rate >= 0.25) {
        return 16;
    } else if (rate >= 0.1) {
        return 8;
    } else if (rate >= 0.01) {
        return 2;
    } else {
        return 0;
    }
}

const scoreDonneurs = (collect: collect) => {
    const rate = collect.donations/collect.employees;

    if (rate >= 0.9) {
        return 30;
    } else if (rate >= 0.75) {
        return 24;
    } else if (rate >= 0.5) {
        return 18;
    } else if (rate >= 0.25) {
        return 12;
    } else if (rate >= 0.1) {
        return 6;
    } else if (rate >= 0.01) {
        return 2;
    } else {
        return 0;
    }
}

const scoreSupporters = (collect: collect) => {
    const rate = collect.supporter_shares/collect.supporter_results;

    if (rate >= 0.9) {
        return 12;
    } else if (rate >= 0.75) {
        return 1;
    } else if (rate >= 0.5) {
        return 8;
    } else if (rate >= 0.25) {
        return 6;
    } else if (rate >= 0.1) {
        return 4;
    } else if (rate >= 0.01) {
        return 2;
    } else {
        return 0;
    }
}

const score = (collect: collect) => {
    return scoreEfficacite(collect) + 5 + scoreDonneurs(collect) + scoreSupporters(collect);
}

const collectsActive = computed(() => props.collects.filter((c) => c.season_id === activeSeason.value?.id));

const collectsToComplete = computed(() => collectsActive.value.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) < Date.now();
}).toReversed());

const collectsFuture = computed(() => collectsActive.value.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) >= Date.now();
}).toReversed());

const collectsCompleted = computed(() => collectsActive.value.filter((c) => {
    return c.completed === 1;
}));
        
</script>

<template>
    <AdminLayout title="Collectes" desc="Liste des collectes">
        <section id="collects" class="relative min-h-[calc(100vh-76px)] font-medium text-md font-cooper py-16 px-25">
            <Link href="/admin/dashboard" class="relative bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit">← Tableau de bord</Link>
            <div class="flex justify-between">
                <div class="w-50">
                    <button v-if="activeSeasonPosition < seasons.length - 1" class="flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit" @click="prevSeason">← {{ seasons[activeSeasonPosition+1].year_of }}</button>
                </div>
                <h1 class="col-span-12 font-bold text-4xl">Collectes : saison {{ activeSeason?.year_of }}</h1>
                <div class="w-50 flex justify-end">
                    <button v-if="activeSeasonPosition > 0" class="flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit" @click="nextSeason">{{ seasons[activeSeasonPosition-1].year_of }} →</button>
                </div>
            </div>
            <Link href="/admin/collects/create" class="flex items-center px-3 h-11 rounded font-medium bg-brand-rose-400 hover:bg-brand-rose-500 active:bg-brand-rose-600 text-white w-fit mt-6">Nouvelle collecte</Link>
            <table class="table-auto border-collapse w-full my-6">
                <thead>
                    <tr class="bg-brand-sage-400 text-white text-lg border border-brand-sage-400">
                        <th class="font-semibold p-2 text-start">Entreprise</th>
                        <th class="font-semibold p-2 text-start">Date</th>
                        <th class="font-semibold p-2 text-start">Lieu</th>
                        <th class="font-semibold p-2 text-start">RDV</th>
                        <th class="font-semibold p-2 text-start">Score</th>
                    </tr>
                </thead>
                <tbody v-if="activeSeason.status === 'open'">
                    <tr class="border border-brand-neutral-100 font-semibold text-brand-sage-400"><td class="px-2 py-1">Prochaines collectes</td></tr>
                    <tr v-for="collect in collectsFuture" :key="collect.id">
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.company.company_name }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.location }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100">/</td>
                    </tr>
                    <tr v-if="collectsFuture.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>

                    <tr class="border border-brand-neutral-100 font-semibold text-brand-sage-400"><td class="px-2 py-1">Collectes à compléter</td></tr>
                    <tr v-for="collect in collectsToComplete" :key="collect.id">
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.company.company_name }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.location }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100">/</td>
                    </tr>
                    <tr v-if="collectsToComplete.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>

                    <tr class="border border-brand-neutral-100 font-semibold text-brand-sage-400"><td class="px-2 py-1">Collectes complétées</td></tr>
                    <tr v-for="collect in collectsCompleted" :key="collect.id">
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.company.company_name }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.location }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100">{{ score(collect) }}</td>
                    </tr>
                    <tr v-if="collectsCompleted.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>
                </tbody>
                
                <tbody v-else>
                    <tr class="border border-brand-neutral-100 font-semibold text-brand-sage-400"><td class="px-2 py-1">Saison terminée</td></tr>
                    <tr v-for="collect in collectsActive" :key="collect.id">
                        <td class="p-2 border border-brand-neutral-100">{{ collect.company.company_name }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ collect.location }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</td>
                        <td class="p-2 border border-brand-neutral-100">{{ score(collect) }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </AdminLayout>
</template>