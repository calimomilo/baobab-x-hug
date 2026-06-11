<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

type season = {
    id: number;
    year_of: number;
    status: string;
}

const props = defineProps<{
    seasons: Array<season>
}>()

const minSeason = computed(() => Math.min(...props.seasons.map((s) => s.year_of)));
const maxSeason = computed(() => Math.max(...props.seasons.map((s) => s.year_of)));
const seasonsSelect = ref<Array<number>>([]);

for (let i = maxSeason.value+3; i > minSeason.value - 1; i--) {
    seasonsSelect.value.push(i);
}

const now = new Date(Date.now());
const currentYear = now.getFullYear();
</script>

<template>
    <AdminLayout title="Nouvelle entreprise" desc="Ajouter une nouvelle entreprise.">
        <section id="company-create" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-start bg-brand-sage-400 font-cooper font-medium text-lg py-16 lg:px-40">
            <div class="rounded-lg px-6 pt-15 pb-20 bg-white w-full">
                <h1 class="text-xl text-center pb-10 font-bold md:text-4xl">Ouvrir une nouvelle saison</h1>
                <Form :action="`/admin/seasons/open`" method="post" #default="{ errors, invalid, validate }" class="flex flex-col gap-4 mx-auto max-w-100">
                    <div>
                        <label for="season_year" class="block text-sm mb-1 text-neutral-700">Saison à ouvrir</label>
                        <select name="season_year" id="season_year" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('season_year')">
                            <option v-for="year, index in seasonsSelect" :key="index" :value="year" :selected="year === currentYear+1">{{ year }}</option>
                        </select>
                        <div v-if="invalid('season_year')" class="text-sm text-brand-error-600 mt-1">{{ errors['season_year'] }}</div>
                    </div>
                    <Button class="self-center flex items-center px-15 h-11 mt-4 rounded font-medium text-xl text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100">Ouvrir la saison</Button>
                </Form>
            </div>
        </section>
    </AdminLayout>
</template>