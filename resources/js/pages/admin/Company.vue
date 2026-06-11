<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import DashboardTile from '@/components/DashboardTile.vue';
import AwardIcon from '@/components/svg/AwardIcon.vue';
import LabelIcon from '@/components/svg/LabelIcon.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { formatDate } from '@/lib/dateTimeFormatting';

// import { Link } from '@inertiajs/vue3';
// import { computed } from 'vue';
// import DashboardTile from '@/components/DashboardTile.vue';
// import { formatDate } from '@/lib/dateTimeFormatting';

type collectType = {
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
            supporter_shares: number;
        }
    ];
    wins: [
        {
            id: number;
            year_of: number;
            status: string;
            pivot: {
                company_id: number;
                season_id: number;
                category: string;
                slug: string;
                label: string;
            }
        }
    ]
}

type seasonType = {
    id: number;
    year_of: number;
    status: string;
}

const props = defineProps<{
    company: collectType,
    seasons: Array<seasonType>
}>()

// COMPUTE RESULTS

const currentSeason = computed(() => {
    return props.seasons.find((s) => s.status === 'open');
})

const seasons = computed(() => props.seasons.toSorted((a, b) => b.year_of - a.year_of));

const awards = computed(() => {
    return props.company.wins.toSorted((a, b) => b.year_of - a.year_of);
})

const collectsFuture = computed(() => props.company.collects.filter((c) => c.season_id === currentSeason.value?.id && Date.parse(c.date_of) >= Date.now()));

const collectsToComplete = computed(() => props.company.collects.filter((c) => c.season_id === currentSeason.value?.id && !c.completed && Date.parse(c.date_of) < Date.now()));

const collectsCompleted = computed(() => props.company.collects.filter((c) => c.season_id === currentSeason.value?.id && c.completed));

        
</script>

<template>
    <AdminLayout :title="props.company.company_name" desc="Détails de l'entreprise">
        <section id="collects" class="relative min-h-[calc(100vh-76px)] font-medium text-md font-cooper py-16 px-25">
            <Link href="/admin/companies" class="relative bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit">← Toutes les entreprises</Link>

            <div class="grid grid-cols-12 auto-rows-min gap-6 my-6">
                <h1 class="col-span-6 font-bold text-4xl">{{ props.company.company_name }}</h1>
                <div class="flex gap-4 justify-end col-span-2 self-start">
                    <Link :href="`/admin/collects/${props.company.id}/edit`" class="flex items-center px-3 h-11 rounded font-medium bg-brand-neutral-50 hover:bg-brand-neutral-100 active:bg-brand-neutral-200 w-fit">Modifier</Link>
                    <Link :href="`/admin/collects/${props.company.id}`" method="delete" class="flex items-center px-3 h-11 rounded font-medium bg-brand-error-600 hover:bg-brand-error-700 active:bg-brand-error-800 text-white w-fit">Supprimer</Link>
                </div>

                <div class="col-span-4 row-span-2 flex flex-col gap-6">
                    <DashboardTile class="bg-brand-neutral-50">
                        <img :src="props.company.logo_url" :alt="`Logo de ${props.company.company_name}`" class="max-w-40 max-h-30">
                    </DashboardTile>
                    <DashboardTile class="text-white" :style="`background-color: ${props.company.primary_color};`">
                        Couleur principale :<br>{{ props.company.primary_color }}
                    </DashboardTile>
                    <DashboardTile :style="`background-color: ${props.company.secondary_color};`">
                        Couleur secondaire :<br>{{ props.company.secondary_color }}
                    </DashboardTile>
                </div>

                <DashboardTile color="rose" class="col-span-8 self-end items-start text-start pl-12">
                    <h2 class="font-bold text-2xl -mt-2 mb-2">Informations</h2>
                    <p>Adresse : {{ props.company.address }}</p>
                    <p>Site co-brandé : <a :href="`https://blood-league.ch/${props.company.slug}`" target="_blank" class="underline text-brand-indigo-600 hover:text-brand-indigo-400 mt-2">{{ `blood-league.ch/${props.company.slug}` }}</a></p>
                    <p>Participation anonyme : {{ props.company.anonymous? 'Oui' : 'Non' }}</p>
                    <h3 class="font-semibold mt-4 mb-1">Contact : {{ props.company.contact_name }}</h3>
                    <p>Téléphone : <a :href="`tel:${props.company.phone}`" class="underline hover:text-brand-neutral-800 mt-2">{{ props.company.phone }}</a></p>
                    <p>E-mail : <a :href="`mailto:${props.company.email}`" class="underline hover:text-brand-neutral-800 mt-2">{{ props.company.email }}</a></p>
                    <p>Adresse de contact : {{ props.company.contact_address ?? '/' }}</p>
                </DashboardTile>

                <DashboardTile color="sage" class="relative col-span-12 items-start text-start pl-12">
                    <LabelIcon v-if="props.company.label.slug !== 'outsider'" :label="props.company.label.slug" class="absolute top-12 -left-12 rotate-24"></LabelIcon>
                    <h2 class="font-bold text-2xl -mt-2 mb-2">Blood League : saison {{ currentSeason?.year_of }}</h2>
                    <div class="flex justify-around w-full my-10">
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ props.company.score.raw.collects_count }}</p>
                            <p>Collecte{{ props.company.score.raw.collects_count === 1? '' : 's' }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ props.company.score.raw.donations }}</p>
                            <p>Don{{ props.company.score.raw.donations === 1? '' : 's' }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ props.company.score.raw.taux_participation }}%</p>
                            <p>Participation</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ props.company.score.raw.taux_efficacite }}%</p>
                            <p>Efficacité</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ props.company.score.raw.taux_supporters }}%</p>
                            <p>Support</p>
                        </div>
                    </div>
                    <div class="flex w-full justify-around">
                        <p class="capitalize">Division : {{ props.company.label.slug !== 'outsider' ? props.company.label.slug : '/' }}</p>
                        <p>Points : {{ props.company.score.frequence }} pts + {{ props.company.score.donneurs }} pts + {{ props.company.score.efficacite }} pts + {{ props.company.score.supporters }} pts = <span class="font-bold">{{ props.company.score.total }} pts</span></p>
                    </div>
                </DashboardTile>

                <DashboardTile color="teal" class="relative col-span-12 items-start text-start">
                    <h2 class="font-bold text-2xl -mt-2 mb-2">Palmarès</h2>
                    <p v-if="awards.length === 0" class="p-2 italic text-brand-teal-800">Aucune médaille remportée</p>
                    <div class="flex gap-6 w-full justify-between flex-wrap">
                        <div v-for="award,index in awards" :key="index" class="flex flex-col items-center text-center max-w-56">
                            <AwardIcon :award="award.pivot.slug"></AwardIcon>
                            <p>{{ award.pivot.label }} {{ award.year_of }}</p>
                        </div>
                    </div>
                </DashboardTile>

                <div class="col-span-12">
                    <h2 class="font-bold text-2xl -mt-2 mb-2">Collectes</h2>
                    <table class="table-auto border-collapse w-full my-6">
                        <thead>
                            <tr class="bg-brand-sage-400 text-white text-lg border border-brand-sage-400">
                                <th class="font-semibold p-2 text-start">Date</th>
                                <th class="font-semibold p-2 text-start">Lieu</th>
                                <th class="font-semibold p-2 text-start">RDV</th>
                                <th class="font-semibold p-2 text-start">Dons</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border border-brand-neutral-100 font-semibold text-brand-sage-400"><td class="px-2 py-1">Prochaines collectes</td></tr>
                            <tr v-for="collect in collectsFuture" :key="collect.id">
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.location }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100 w-20"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100 w-20"><Link :href="`/admin/collects/${collect.id}`">{{ collect.donations !== 0? collect.donations : '/' }}</Link></td>
                            </tr>
                            <tr v-if="collectsFuture.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>

                            <tr class="border border-brand-neutral-100 font-semibold text-brand-sage-400"><td class="px-2 py-1">Collectes à compléter</td></tr>
                            <tr v-for="collect in collectsToComplete" :key="collect.id">
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.location }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.donations !== 0? collect.donations : '/' }}</Link></td>
                            </tr>
                            <tr v-if="collectsToComplete.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>

                            <tr class="border border-brand-neutral-100 font-semibold text-brand-sage-400"><td class="px-2 py-1">Collectes complétées</td></tr>
                            <tr v-for="collect in collectsCompleted" :key="collect.id">
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.location }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100 w-20"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100 w-20"><Link :href="`/admin/collects/${collect.id}`">{{ collect.donations !== 0? collect.donations : '/' }}</Link></td>
                            </tr>
                            <tr v-if="collectsCompleted.length === 0" class="border border-brand-neutral-100"><td class="p-2 italic  text-brand-neutral-500">Aucune collecte</td></tr>
                        </tbody>
                    </table>

                    <table v-for="season in seasons.filter((s) => s.id !== currentSeason?.id)" :key="season.id" class="table-auto w-full my-6">
                        <tbody>
                            <tr class="border border-brand-neutral-100 font-semibold text-white bg-brand-sage-400"><td class="px-2 py-1">Saison {{ season.year_of }}</td><td></td><td></td><td></td></tr>
                            <tr v-for="collect in props.company.collects.filter((c) => c.season_id === season.id)" :key="collect.id">
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ formatDate(collect.date_of, collect.start_time, collect.end_time) }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100"><Link :href="`/admin/collects/${collect.id}`">{{ collect.location }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100 w-20"><Link :href="`/admin/collects/${collect.id}`">{{ collect.appointments !== 0? collect.appointments : collect.appointment_clicks }}</Link></td>
                                <td class="p-2 border border-brand-neutral-100 w-20"><Link :href="`/admin/collects/${collect.id}`">{{ collect.donations !== 0? collect.donations : '/' }}</Link></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>