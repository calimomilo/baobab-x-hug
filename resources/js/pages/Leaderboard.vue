<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Badge from '@/components/Badge.vue';
import CompanyCard from '@/components/CompanyCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';

type company = {
    id: number,
    company_name: string,
    logo_url: string,
    label: {
        name: string,
        slug: string,
    },
    score: {
        donations: number,
        supporters: number,
        efficiency: number,
    }
}
const props = defineProps({
    companies: Array<company>,
    season: {type: Number, default: null}
})

// COMPUTE RESULTS

const companiesAmount = props.companies?.length ?? 1;
const donationsAmount = props.companies?.map((company) => company.score.donations).reduce((carry, amount) => {
    return carry + amount;
});
const supportersAmount = props.companies?.map((company) => company.score.supporters).reduce((carry, amount) => {
    return carry + amount;
});
const efficiencySum = props.companies?.map((company) => company.score.efficiency).reduce((carry, amount) => {
    return carry + amount;
}) ?? 0;
const efficiencyMean = Math.round(efficiencySum/companiesAmount);

// FILTER COMPANIES

const companies = ref(props.companies);
const activeFilter = ref('all');

const filter = (filter: string) => {
    activeFilter.value = filter;
    companies.value = filter === 'all'? props.companies : props.companies?.filter((company) => company.label.slug === filter);
    console.log(props.companies);
    console.log(activeFilter.value, companies.value);
}

</script>

<template>
    <AppLayout title="Accueil" desc="Découvrez les entreprises participant à la saison en cours.">
        <section id="results" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-20 gap-15 font-medium lg:px-24 lg:py-36 lg:text-xl">
            <div class="flex flex-col gap-y-4 gap-x-8 justify-center items-center md:flex-row">
                <img src="/assets/logos/BloodLeague_logo_noir.png" alt="" class="w-40">
                <h1 class="text-2xl font-bold md:text-[50px]">Résultats de la saison {{ props.season }}</h1>
            </div>
            <div class="flex flex-wrap gap-4 justify-center">
                <div class="flex gap-4 w-76 grow shrink-0 justify-end items-center">
                    <div class="flex flex-col items-start justify-between rounded-lg min-w-38 w-[calc(50%-2px)] aspect-square bg-brand-violet-200 p-4 md:max-w-80">
                        <img src="/assets/mascottes/ScreamBlueNona.svg" alt="" class="h-[calc(100%-60px)] mb-2">
                        <div>
                            <p class="text-lg font-semibold lg:text-xl">{{ companiesAmount }}</p>
                            <p>Entreprises</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start justify-between rounded-lg min-w-38 w-[calc(50%-2px)] aspect-square bg-brand-rose-100 p-4 md:max-w-80">
                        <img src="/assets/mascottes/KneelBlueFlower.svg" alt="" class="h-[calc(100%-60px)] mb-2">
                        <div>
                            <p class="text-lg font-semibold lg:text-xl">{{ donationsAmount }}</p>
                            <p>Dons</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 w-76 grow shrink-0 items-center">
                    <div class="flex flex-col items-start justify-between rounded-lg min-w-38 w-[calc(50%-2px)] aspect-square bg-brand-sage-200 p-4 md:max-w-80">
                        <img src="/assets/mascottes/YeahPinkFlam.svg" alt="" class="h-[calc(100%-60px)] mb-2">
                        <div>
                            <p class="text-lg font-semibold lg:text-xl">{{ supportersAmount }}</p>
                            <p>Supporters</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start justify-between rounded-lg min-w-38 w-[calc(50%-2px)] aspect-square bg-brand-teal-200 p-4 md:max-w-80">
                        <img src="/assets/mascottes/DrinkPinkFlower.svg" alt="" class="h-[calc(100%-60px)] mb-2 scale-x-[-1]">
                        <div>
                            <p class="text-lg font-semibold lg:text-xl">{{ efficiencyMean }}%</p>
                            <p>Efficacité</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="leaderboard" class="relative min-h-[calc(100vh-76px)] flex flex-col items-center bg-brand-teal-400 text-white px-8 py-15 gap-6 font-medium lg:px-36 md:text-lg">
            <h2 class="text-2xl font-bold md:text-[50px]">Leaderboard saison {{ props.season }}</h2>
            <p class="text-center">Les entreprises gravissent les divisions de la Blood League en fonction du nombre de dons réalisés par ses collaborateurs.trices sur une saison. Le label CTS récompense l'engagement, pas la taille.</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <button  @click="filter('all')">
                    <Badge :color="activeFilter === 'all'? 'rose-selected' : 'empty'" class="shrink-0">Tous les labels</Badge>
                </button>
                <button  @click="filter('classic')">
                    <Badge :color="activeFilter === 'classic'? 'rose-selected' : 'empty'" class="shrink-0">Blood League Label</Badge>
                </button>
                <button  @click="filter('gold')">
                    <Badge :color="activeFilter === 'gold'? 'rose-selected' : 'empty'" class="shrink-0">Blood League Label Gold</Badge>
                </button>
                <button  @click="filter('legend')">
                    <Badge :color="activeFilter === 'legend'? 'rose-selected' : 'empty'" class="shrink-0">Blood League Label Legend</Badge>
                </button>
            </div>
            <div class="flex flex-col gap-4 flex-row flex-wrap justify-center">
                <CompanyCard v-for="company, index in companies" :key="index" :company="company"/>
            </div>
        </section>
        <section id="contact" class="relative flex flex-col px-8 py-10 gap-12 bg-brand-rose-400 font-medium items-center text-white lg:px-40 lg:text-lg">
            <h2 class="text-[38px]/[130%] font-semibold px-4 ">Votre entreprise n'est pas encore labellisée ?</h2>
            <p class="text-center font-medium uppercase tracking-[8%] mx-12">Rejoignez dès maintenant la Blood League et obtenez votre label en organisant vos premières collectes de sang. Ensemble, faisons la différence.</p>
            <Link href="/contact" class="lg:relative lg:right-90 lg:bottom-5">
                <img src="/assets/round_button_organize.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 -rotate-10 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-20 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
            <img src="/assets/mascottes/WriteBlueStar.svg" alt="" class="hidden lg:block  absolute h-80 right-5 bottom-5">
        </section>
    </AppLayout>
</template>