<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import DashboardTile from '@/components/DashboardTile.vue';
import Tag from '@/components/Tag.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { formatDate } from '@/lib/dateTimeFormatting';

// import { Link } from '@inertiajs/vue3';
// import { computed } from 'vue';
// import DashboardTile from '@/components/DashboardTile.vue';
// import { formatDate } from '@/lib/dateTimeFormatting';

type collectType = {
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
    collect: collectType,
}>()

// COMPUTE RESULTS

const scoreEfficacite = computed(() => {
    const rate = props.collect.donations/props.collect.appointments;

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
});

const scoreDonneurs = computed(() => {
    const rate = props.collect.donations/props.collect.employees;

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
});

const scoreSupporters = computed(() => {
    const rate = props.collect.supporter_shares/props.collect.supporter_results;

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
});

const score = computed(() => {
    return scoreEfficacite.value + 5 + scoreDonneurs.value + scoreSupporters.value;
});
        
</script>

<template>
    <AdminLayout title="Collectes" desc="Liste des collectes">
        <section id="collects" class="relative min-h-[calc(100vh-76px)] font-medium text-md font-cooper py-16 px-25">
            <Link href="/admin/collects" class="relative bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit">← Toutes les collectes</Link>
            <div class="flex gap-8 items-center">
                <h1 class="col-span-12 font-bold text-4xl">Collecte : {{ props.collect.company.company_name }}, {{ formatDate(props.collect.date_of) }} (saison {{ props.collect.season.year_of }})</h1>
                <Tag v-if="props.collect.completed === 1" color="completed">Complétée</Tag>
                <Tag v-else-if="Date.parse(props.collect.date_of) < Date.now()" color="todo">À compléter</Tag>
                <Tag v-else color="soon">Prochainement</Tag>
            </div>

            <div class="grid grid-cols-12 auto-rows-min gap-6 my-6">
                <div class="flex gap-4 justify-end col-span-8 self-end">
                    <Link v-if="!props.collect.completed" :href="`/admin/collects/${props.collect.id}/edit`" class="flex items-center px-3 h-11 rounded font-medium bg-brand-neutral-50 hover:bg-brand-neutral-100 active:bg-brand-neutral-200 w-fit">Modifier</Link>
                    <Link v-if="!props.collect.completed && Date.parse(props.collect.date_of) < Date.now()" :href="`/admin/${props.collect.id}/collects/complete`" class="flex items-center px-3 h-11 rounded font-medium bg-brand-teal-300 hover:bg-brand-teal-400 active:bg-brand-teal-500 w-fit">Compléter</Link>
                    <Link v-if="props.collect.completed" :href="`/admin/${props.collect.id}/collects/incomplete`" class="flex items-center px-3 h-11 rounded font-medium bg-brand-teal-300 hover:bg-brand-teal-400 active:bg-brand-teal-500 w-fit">Compléter</Link>
                    <Link :href="`/admin/collects/${props.collect.id}`" method="delete" class="flex items-center px-3 h-11 rounded font-medium bg-brand-error-600 hover:bg-brand-error-700 active:bg-brand-error-800 text-white w-fit">Supprimer</Link>
                </div>
                <DashboardTile color="rose" class="col-span-4 row-span-2 items-end text-end pr-12">
                    <h2 class="font-bold text-2xl -mt-2 mb-2">Points</h2>
                    <table class="table-auto">
                        <tbody>
                            <tr>
                                <td class="text-end">Organisation :</td>
                                <td class="w-20">5 pts</td>
                            </tr>
                            <tr>
                                <td class="text-end pt-2">Dons :</td>
                                <td class="pt-2">{{ scoreDonneurs }} pts</td>
                            </tr>
                            <tr class="pb-2 text-base">(dons / employé.e.s)</tr>
                            <tr>
                                <td class="text-end pt-2">Efficacité :</td>
                                <td class="pt-2">{{ scoreEfficacite }} pts</td>
                            </tr>
                            <tr class="text-base"> (dons / rendez-vous)</tr>
                            <tr>
                                <td class="text-end pt-2">Support :</td>
                                <td class="pt-2">{{ scoreSupporters }} pts</td>
                            </tr>
                            <tr class="text-base"> (partages des supporters / supporters)</tr>
                            <tr class="font-semibold">
                                <td class="text-end pt-2">Total :</td>
                                <td class="pt-2">{{ score }} pts</td>
                            </tr>
                        </tbody>
                    </table>
                </DashboardTile>
                <DashboardTile color="sage" class="col-span-8 self-end items-start text-start pl-12">
                    <h2 class="font-bold text-2xl -mt-2 mb-2">Informations</h2>
                    <table class="table-auto">
                        <tbody>
                            <tr>
                                <td class="text-end pb-2 pr-6">Entreprise organisatrice :</td>
                                <td class="pb-2"><Link :href="`/admin/companies/${props.collect.company_id}`" class="underline hover:text-brand-sage-800 mt-2">{{ props.collect.company.company_name }}</Link> ({{ props.collect.company.address }})</td>
                            </tr>
                            <tr>
                                <td class="text-end pb-2 pr-6">Lieu :</td>
                                <td class="pb-2">{{ props.collect.location }}</td>
                            </tr>
                            <tr>
                                <td class="text-end pb-2 pr-6">Date et heures :</td>
                                <td class="pb-2">{{ formatDate(props.collect.date_of, props.collect.start_time, props.collect.end_time) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end pb-2 pr-6">Lien de prise de rdv :</td>
                                <td class="pb-2">{{ props.collect.appointment_link }}</td>
                            </tr>
                            <tr>
                                <td class="text-end pb-2 pr-6">Employé.e.s :</td>
                                <td class="pb-2">{{ props.collect.completed? props.collect.employees : '/' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </DashboardTile>
                <DashboardTile color="teal" class="col-span-12 items-start text-start pl-12">
                    <h2 class="font-bold text-2xl -mt-2 mb-2">KPIs</h2>
                    <div class="flex justify-around gap-4 w-full">
                        <div>
                            <p>{{ props.collect.donor_results }} résultats "Donneur"</p>
                            <p>{{ props.collect.supporter_results }} résultats "Supporter"</p>
                            <p class="border-t border-brand-teal-700 mt-2 pt-2">{{ props.collect.donor_results + props.collect.supporter_results }} checkers effectués</p>
                        </div>
                        <div>
                            <p>{{ props.collect.donor_shares }} kits "Donneur"</p>
                            <p>{{ props.collect.supporter_shares }} kits "Supporter"</p>
                            <p class="border-t border-brand-teal-700 mt-2 pt-2">{{ props.collect.donor_results + props.collect.supporter_results }} kits communication téléchargés</p>
                        </div>
                        <div>
                            <p>{{ props.collect.appointment_clicks }} Clics vers la prise de rendez-vous</p>
                            <p v-if="props.collect.completed">{{ props.collect.appointments }} rendez-vous pris</p>
                        </div>
                    </div>
                </DashboardTile>
            </div>
        </section>
    </AdminLayout>
</template>