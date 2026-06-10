<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
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

const seasons = ref<Array<season>>([]);

props.collects.forEach((c) => {
    if (!seasons.value.find((s) => s.id === c.season_id)) {
        seasons.value.push(c.season);
    }
})
seasons.value.sort((a,b) => b.year_of - a.year_of);

const activeSeason = ref(seasons.value.find((s) => s.status === 'open'));

// COMPUTE RESULTS

// const collectsAmount = computed(() => props.collects.length ?? 0);

// const donationsAmount = computed(() => props.collects.reduce((carry, current) => {
//     return carry + current.donations;
// }, 0));

// const supporterResultsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
//     return carry + current.supporter_results;
// }, 0));

// const supporterSharesAmount = computed(() => props.season?.collects.reduce((carry, current) => {
//     return carry + current.supporter_shares;
// }, 0));

// const donorSharesAmount = computed(() => props.season?.collects.reduce((carry, current) => {
//     return carry + current.donor_shares;
// }, 0));

// const appointmentsAmount = computed(() => props.season?.collects.reduce((carry, current) => {
//     return current.completed? carry + current.appointments : carry + current.appointment_clicks;
// }, 0));
// const efficiencyMean = computed(() => {
//     if (companiesAmount.value === 0) {
//         return 0;
//     }

//     const sum = props.companies?.reduce((carry, amount) => {
//         return carry + amount.score.raw.taux_efficacite;
//     }, 0) ?? 0;

//     return Math.round(sum*100/companiesAmount.value)/100.0;
// });

// // FILTER LISTS
// const collectsToComplete = computed(() => props.season.collects.filter((c) => {
//     return c.completed === 0 && Date.parse(c.date_of) < Date.now();
// }));

// const collectsFuture = computed(() => props.season.collects.filter((c) => {
//     return c.completed === 0 && Date.parse(c.date_of) >= Date.now();
// }));

// const companiesSorted = computed(() => props.companies.toSorted((a, b) => b.score.total - a.score.total));

// const companiesClassic = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'classic'));

// const companiesGold = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'gold'));

// const companiesLegend = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'legend'));

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
    <AdminLayout title="Collectes" desc="Liste des collectes">
        <section id="collects" class="relative min-h-[calc(100vh-76px)] font-medium text-md font-cooper py-16 px-25">
            <Link href="/admin/dashboard" class="relative bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit">← Tableau de bord</Link>
            <h1 class="col-span-12 font-bold text-4xl">Collectes de la saison {{ activeSeason?.year_of }}</h1>

            <div v-for="season in seasons" :key="season.id">
                <h2 class="font-bold text-2xl my-2">Saison {{ season.year_of }}</h2>
                <table class="table-auto border-collapse w-full my-6">
                    <thead>
                        <tr class="bg-brand-sage-400 text-white text-lg border border-brand-sage-400">
                            <th class="font-semibold p-2 text-start">Entreprise</th>
                            <th class="font-semibold p-2 text-start">Date</th>
                            <th class="font-semibold p-2 text-start">Lieu</th>
                            <th class="font-semibold p-2 text-start">Rendez-vous pris</th>
                            <th class="font-semibold p-2 text-start">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="collect in collects.filter((c) => c.season_id === season.id)" :key="collect.id">
                            <td class="p-2 border border-brand-neutral-100">{{ collect.company.company_name }}</td>
                            <td class="p-2 border border-brand-neutral-100">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</td>
                            <td class="p-2 border border-brand-neutral-100">{{ collect.location }}</td>
                            <td class="p-2 border border-brand-neutral-100">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </AdminLayout>
    <section class="bg-white">
        {{ props.collects }}
    </section>
</template>