<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
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

type season = {
    id: number;
    year_of: number;
    status: string;
}

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
    company: company;
    season: season;
}

const props = defineProps<{
    companies: Array<company>,
    seasons: Array<season>,
    formData: collect | null
}>()

const currentSeason = computed(() => props.seasons.find((s) => s.status === 'open'));
const minSeason = computed(() => Math.min(...props.seasons.map((s) => s.year_of)));
const maxSeason = computed(() => Math.max(...props.seasons.map((s) => s.year_of)));
const seasonsSelect = ref<Array<number>>([]);

for (let i = maxSeason.value+5; i > minSeason.value; i--) {
    seasonsSelect.value.push(i);
}

const now = new Date(Date.now());
const currentDate = now.toISOString().split('T')[0];

console.log(seasonsSelect);
</script>

<template>
    <AdminLayout title="Nouvelle collecte" desc="Créer une nouvelle collecte.">
        <section id="collect-create" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-start bg-brand-sage-400 font-cooper font-medium py-16 lg:px-40" >
            <Link :href="props.formData? `/admin/collects/${props.formData.id}` : '/admin/collects'" class="relative self-start bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium bg-brand-sage-300 hover:bg-brand-sage-200 active:bg-brand-sage-100 w-fit">← Retour</Link>
            <div class="rounded-lg px-6 pt-15 pb-10 bg-white w-full">
                <h1 v-if="formData" class="text-xl text-center pb-10 font-bold md:text-4xl">Modifier la collecte</h1>
                <h1 v-else class="text-xl text-center pb-10 font-bold md:text-4xl">Nouvelle collecte</h1>
                <Form :action="props.formData? `/admin/collects/${props.formData.id}` : '/admin/collects'" :method="props.formData? 'put' : 'post'" #default="{ errors, invalid, validate }" class="flex flex-col gap-4 mx-auto max-w-200">
                    <div class="flex gap-4 w-full">
                        <div class="grow">
                            <label for="season_year" class="block text-sm mb-1 text-neutral-700">Saison <span class="text-brand-error-600 font-bold">*</span></label>
                            <select name="season_year" id="season_year" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent">
                                <option v-for="year, index in seasonsSelect" :key="index" :value="year" :selected="formData? formData.season.year_of === currentSeason?.year_of : year === currentSeason?.year_of">{{ year }}</option>
                            </select>
                            <div v-if="invalid('season_year')" class="text-sm text-brand-error-600 mt-1">{{ errors['season_year'] }}</div>
                        </div>
                        <div class="grow-2">
                            <label for="company_id" class="block text-sm mb-1 text-neutral-700">Entreprise <span class="text-brand-error-600 font-bold">*</span></label>
                            <select name="company_id" id="company_id" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent">
                                <option value="" :selected="!formData">Choisir une entreprise</option>
                                <option v-for="company in props.companies" :key="company.id" :value="company.id" :selected="formData?.company_id === company.id">{{ company.company_name }}</option>
                            </select>
                            <div v-if="invalid('company_id')" class="text-sm text-brand-error-600 mt-1">{{ errors['company_id'] }}</div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div class="flex gap-4">
                            <div>
                                <label for="date_of" class="block text-sm mb-1 text-neutral-700">Date <span class="text-brand-error-600 font-bold">*</span></label>
                                <input type="date" name="date_of" id="date_of" :value="formData? formData.date_of : currentDate" :min="formData? '' : currentDate" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('date_of')">
                                <div v-if="invalid('date_of')" class="text-sm text-brand-error-600 mt-1">{{ errors['date_of'] }}</div>
                            </div>
                            
                            <div>
                                <label for="start_time" class="block text-sm mb-1 text-neutral-700">Début <span class="text-brand-error-600 font-bold">*</span></label>
                                <input type="time" name="start_time" id="start_time" :value="formData? formData.start_time.substring(0, 5) : '09:00'" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('start_time')">
                                <div v-if="invalid('start_time')" class="text-sm text-brand-error-600 mt-1">{{ errors['start_time'] }}</div>
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm mb-1 text-neutral-700">Fin <span class="text-brand-error-600 font-bold">*</span></label>
                                <input type="time" name="end_time" id="end_time" :value="formData? formData.end_time.substring(0, 5) : '17:00'" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('end_time')">
                                <div v-if="invalid('end_time')" class="text-sm text-brand-error-600 mt-1">{{ errors['end_time'] }}</div>
                            </div>
                        </div>
                        <div>
                            <label for="employees" class="block text-sm mb-1 text-neutral-700">Employé.e.s <span class="text-brand-error-600 font-bold">*</span></label>
                            <input type="number" name="employees" id="employees" :value="formData? formData.employees : 0" min="0" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('employees')">
                            <div v-if="invalid('employees')" class="text-sm text-brand-error-600 mt-1">{{ errors['employees'] }}</div>
                        </div>
                    </div>
                    <div class="grow">
                        <label for="location" class="block text-sm mb-1 text-neutral-700" >Lieu <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="location" id="location" :defaultValue="formData?.location" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('location')">
                        <div v-if="invalid('location')" class="text-sm text-brand-error-600 mt-1">{{ errors['location'] }}</div>
                    </div>
                    <div class="grow">
                        <label for="appointment_link" class="block text-sm mb-1 text-neutral-700">Lien vers la prise de rendez-vous <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="appointment_link" id="appointment_link" :defaultValue="formData?.appointment_link" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('appointment_link')">
                        <div v-if="invalid('appointment_link')" class="text-sm text-brand-error-600 mt-1">{{ errors['appointment_link'] }}</div>
                    </div>
                    <Button class="self-center flex items-center px-15 h-11 mt-4 rounded font-medium text-xl text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100">{{ props.formData? 'Modifier' : 'Créer' }}</Button>
                </Form>
            </div>
        </section>
    </AdminLayout>
</template>