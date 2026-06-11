<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

type company = {
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
    total: number;
    label: {
        name: string;
        slug: string;
    }
    score: {
        donations: number;
        supporters: number;
        efficiency: number;
    };
    currentCollects: number;
}

type seasonType = {
    id: number;
    year_of: number;
    status: string;
}

const props = defineProps<{
    companies: Array<company>,
    season: seasonType
}>()

const companiesSorted = computed(() => props.companies.toSorted((a, b) => b.total - a.total));

const companiesClassic = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'classic'));

const companiesGold = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'gold'));

const companiesLegend = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'legend'));

const companiesInactive = computed(() => companiesSorted.value.filter((c) => c.label.slug === 'outsider'));
        
</script>

<template>
    <AdminLayout title="Entreprises" desc="Liste des entreprises">
        <section id="companies" class="relative min-h-[calc(100vh-76px)] font-medium text-md font-cooper py-16 px-25">
            <Link href="/admin/dashboard" class="relative bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit">← Tableau de bord</Link>
            <h1 class="col-span-12 font-bold text-4xl">Entreprises : saison {{ season.year_of }}</h1>
            <Link href="/admin/companies/create" class="flex items-center px-3 h-11 rounded font-medium bg-brand-rose-400 hover:bg-brand-rose-500 active:bg-brand-rose-600 text-white w-fit mt-6">Ajouter une entreprise</Link>

            <!-- TABLE ENTREPRISES -->
            <table class="table-auto border-collapse w-full my-6">
                <thead class="bg-brand-teal-400 text-white text-lg border border-brand-teal-400">
                    <tr>
                        <th class="font-semibold p-2 text-start">Entreprise</th>
                        <th class="font-semibold p-2 text-start">Site co-brandé</th>
                        <th class="font-semibold p-2 text-start">Dons</th>
                        <th class="font-semibold p-2 text-start">Efficacité</th>
                        <th class="font-semibold p-2 text-start">Points</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border border-brand-violet-300 font-semibold bg-brand-violet-300 text-brand-violet-900"><td class="px-2 py-1">Division Legend</td><td></td><td></td><td></td><td></td></tr>
                    <tr v-for="company in companiesLegend" :key="company.id">
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.company_name }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><a :href="`https://blood-league.ch/${company.slug}`" target="_blank" class="underline text-brand-indigo-600 hover:text-brand-indigo-400 mt-2">{{ `blood-league.ch/${company.slug}` }}</a></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.donations }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.efficiency }}%</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.total }}</Link></td>
                    </tr>
                    <tr v-if="companiesLegend.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune entreprise</td></tr>

                    <tr class="border border-brand-warning-300 font-semibold bg-brand-warning-300 text-brand-warning-800"><td class="px-2 py-1">Division Gold</td><td></td><td></td><td></td><td></td></tr>
                    <tr v-for="company in companiesGold" :key="company.id">
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.company_name }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><a :href="`https://blood-league.ch/${company.slug}`" target="_blank" class="underline text-brand-indigo-600 hover:text-brand-indigo-400 mt-2">{{ `blood-league.ch/${company.slug}` }}</a></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.donations }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.efficiency }}%</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.total }}</Link></td>
                    </tr>
                    <tr v-if="companiesGold.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune entreprise</td></tr>
                    
                    <tr class="border border-brand-sage-300 font-semibold bg-brand-sage-300 text-brand-sage-900"><td class="px-2 py-1">Division Classic</td><td></td><td></td><td></td><td></td></tr>
                    <tr v-for="company in companiesClassic" :key="company.id">
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.company_name }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><a :href="`https://blood-league.ch/${company.slug}`" target="_blank" class="underline text-brand-indigo-600 hover:text-brand-indigo-400 mt-2">{{ `blood-league.ch/${company.slug}` }}</a></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.donations }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.efficiency }}%</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.total }}</Link></td>
                    </tr>
                    <tr v-if="companiesClassic.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune entreprise</td></tr>
                    <tr class="h-4"></tr>
                    <tr class="border border-brand-neutral-100 font-semibold bg-brand-neutral-100"><td class="px-2 py-1">N'ont pas encore participé</td><td></td><td></td><td></td><td></td></tr>
                    <tr v-for="company in companiesInactive" :key="company.id">
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.company_name }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><a :href="`https://blood-league.ch/${company.slug}`" target="_blank" class="underline text-brand-indigo-600 hover:text-brand-indigo-400 mt-2">{{ `blood-league.ch/${company.slug}` }}</a></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.donations }}</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.score.efficiency }}%</Link></td>
                        <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/companies/${company.id}`">{{ company.total }}</Link></td>
                    </tr>
                    <tr v-if="companiesInactive.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune entreprise</td></tr>
                </tbody>
            </table>

        </section>
    </AdminLayout>
</template>