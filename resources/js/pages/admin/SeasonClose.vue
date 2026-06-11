<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AwardIcon from '@/components/svg/AwardIcon.vue';
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
}

type seasonType = {
    id: number;
    year_of: number;
    status: string;
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

type winner = {
    climber: {
        company_id: number;
        value: number;
        label: string,
        short: string
    };
    pulse: {
        company_id: number;
        value: number;
        label: string,
        short: string
    };
    new_vein: {
        company_id: number;
        value: number;
        label: string,
        short: string
    };
    flood: {
        company_id: number;
        value: number;
        label: string,
        short: string
    };
}

type category = 'climber' | 'pulse' | 'new_vein' | 'flood';

const props = defineProps<{
    companies: Array<company>,
    season: seasonType,
    winners: winner
}>()

const collectsSorted = computed(() => props.season.collects.toSorted((a,b) => Date.parse(b.date_of) - Date.parse(a.date_of)));

const collectsToComplete = computed(() => collectsSorted.value.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) < Date.now();
}));

const collectsFuture = computed(() => collectsSorted.value.filter((c) => {
    return c.completed === 0 && Date.parse(c.date_of) >= Date.now();
}));

const categories: Array<category> = ['climber', 'pulse', 'flood', 'new_vein'];

</script>

<template>
    <AdminLayout title="Nouvelle entreprise" desc="Ajouter une nouvelle entreprise.">
        <section id="company-create" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-start bg-brand-sage-400 font-cooper font-medium text-lg py-16 lg:px-40">
            <div class="rounded-lg px-6 pt-15 pb-20 bg-white w-full">
                <Link href="/admin/dashboard" class="relative bottom-8 flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit">← Dashboard</Link>
                <h1 class="text-xl text-center pb-10 font-bold md:text-4xl">Clôre la saison {{ props.season.year_of }}</h1>
                <div v-if="collectsToComplete.length !== 0 || collectsFuture.length !== 0" class="text-center">
                    <h2 class="font-bold text-2xl text-brand-rose-400 -mt-2 mb-2">Il reste des collectes non complétées !</h2>
                    <p>Complétez-les avant de clôre cette saison.</p>
                </div>
                <div v-else>
                    <Form :action="`/admin/seasons/${props.season.id}/close`" method="put" #default="{ errors, invalid, validate }" class="flex flex-col gap-4 mx-auto max-w-100">
                        <div v-for="cat, index in categories" :key="index" class="relative">
                            <AwardIcon v-if="index % 2 === 0" :award="cat" class="absolute z-2 h-35 -left-26 -top-4 -rotate-12"></AwardIcon>
                            <AwardIcon v-else :award="cat" class="absolute z-2 h-35 -right-18 -top-4 rotate-8"></AwardIcon>
                            <label :for="cat" class="block text-sm mb-1 text-neutral-700">{{ props.winners[cat].short }} ({{ props.winners[cat].label }})</label>
                            <select hidden :name="cat" :id="cat" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent">
                                <option v-for="company in props.companies" :key="company.id" :value="company.id" :selected="company.id === props.winners[cat].company_id" @change="validate(cat)">{{ company.company_name }}</option>
                            </select>
                            <p class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent">{{ props.companies.find((c) => c.id === props.winners[cat].company_id)?.company_name ?? '--' }}</p>
                            <div v-if="invalid(cat)" class="text-sm text-brand-error-600 mt-1">{{ errors[cat] }}</div>
                        </div>
                        <div class="relative">
                            <AwardIcon award="golden_heart" class="absolute z-2 h-35 -left-26 -top-4 -rotate-12"></AwardIcon>
                            <label :for="'golden_heart'" class="block text-sm mb-1 text-neutral-700">The Golden Heart (Prix du jury)</label>
                            <select :name="'golden_heart'" :id="'golden_heart'" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent">
                                <option value="">Indiquez le prix du jury !</option>
                                <option v-for="company in props.companies" :key="company.id" :value="company.id" @change="validate('golden_heart')">{{ company.company_name }}</option>
                            </select>
                            <div v-if="invalid('golden_heart')" class="text-sm text-brand-error-600 mt-1">{{ errors['golden_heart'] }}</div>
                        </div>
                        <Button class="self-center flex items-center px-15 h-11 mt-4 rounded font-medium text-xl text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100">Clôre la saison</Button>
                    </Form>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>