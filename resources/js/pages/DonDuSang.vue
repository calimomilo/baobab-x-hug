<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import CharacterLoop from '@/components/CharacterLoop.vue';
import BrandedMascot from '@/components/svg/BrandedMascot.vue';
import Tile from '@/components/Tile.vue';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({
    displayData: Object || null
});

const conditions = [
    {
        title: 'bla bla bla',
        desc: 'sdlkkkkkkkkkslv j ofiew jewojdc woeijd wcij  oeifjcwej weoijcewoijxc eijf   oiewfjcoewijc ewijc.'
    },
    {
        title: 'bla bla bla',
        desc: 'sdlkkkkkkkkkslv j ofiew jewojdc woeijd wcij  oeifjcwej weoijcewoijxc eijf   oiewfjcoewijc ewijc.'
    }
]

</script>

<template>

    <AppLayout title="Don du sang" desc="Découvrez l'impact et les conditions du don du sang." :display-data="props.displayData">
        <section id="hero" class="relative bg-brand-sage-400 text-white flex flex-col px-8 pt-12 pb-18 gap-4 font-medium overflow-hidden lg:px-40 lg:pt-[12vw] lg:pb-[16vw] lg:flex-row lg:justify-center">
            <div class="flex flex-col px-8 py-12 gap-4 self-start my-auto lg:text-lg">
                <h2 class="w-9/10 text-2xl font-bold md:text-[50px] md:w-full">Pourquoi donner ?</h2>
                <h4 class="uppercase tracking-[8%] mb-4">Le don du sang : un geste simple, un impact réel.</h4>
                <p>Le canton de Genève n'est pas autosuffisant en sang. Chaque collecte organisée en entreprise contribue directement à combler ce déficit et chaque don réalisé est précieux. En plus de ça, vous pouvez faire progresser votre équipe dans le classement de la Blood League.</p>
            </div>
            <BrandedMascot v-if="props.displayData" type="flag" :primary="props.displayData.primary_color" :secondary="props.displayData.secondary_color" class="scale-[1.8] mt-12 mb-18 lg:my-auto lg:ml-8"></BrandedMascot>
            <img v-else src="/assets/mascottes/DrinkPinkFlower.svg" alt="Mascotte boit" class="scale-x-[-1] my-auto max-h-100 lg:h-100">
        </section>
        <section id="infos" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-12 gap-10 font-medium items-center md:items-stretch lg:px-40 lg:text-lg lg:gap-20">
            <div class="flex flex-col gap-4">
                <h4 class="font-medium tracking-[8%] uppercase">L'impact pour les receveurs</h4>
                <h3 class="text-xl font-semibold md:text-2xl">Le sang ne se fabrique pas, il se donne.</h3>
                <div class="flex flex-col gap-6 py-10 justify-center md:flex-row">
                    <Tile color="rose" title="3 vies">Un seul don suffit à changer le cours de trois vies. Un petit geste, un impact concret.</Tile>
                    <Tile color="rose" title="60 poches">Les HUG ont besoin de 60 poches de sang chaque jour, toute l'année, sans interruption.</Tile>
                    <Tile color="rose" title="3%">Seulement 3% des Genevois donnent régulièrement, un chiffre que chaque collecte contribue à faire bouger.</Tile>
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-medium tracking-[8%] uppercase md:text-end">Le bénéfice pour le donneur</h4>
                <h3 class="text-xl font-semibold md:text-2xl md:text-end">Vous n'y perdez pas, vous y gagnez.</h3>
                <div class="flex flex-col gap-6 py-10 justify-center md:flex-row">
                    <Tile color="rose" title="1 heure">Un don de sang vous prend 1 heure de votre temps, pause collation comprise. Pas plus. Et probablement l'heure la plus utile de votre semaine.</Tile>
                    <Tile color="rose" title="A, B, AB ou O ?">Après votre premier don, le CTS vous communique votre groupe sanguin. Une information à garder toute la vie.</Tile>
                    <Tile color="rose" title="Blood League">
                        <p>Chaque don fait en entreprise vous permet de faire gagner des points à votre entreprise et de gravir les échelons de la Blood League.</p>
                        <Link href="/blood-league" class="block text-sm font-normal italic underline text-brand-indigo-600 hover:text-brand-indigo-400 mt-2">En savoir plus</Link>
                    </Tile>
                </div>
            </div>
        </section>
        <section id="conditions" class="relative min-h-[calc(100vh-76px)] flex flex-col items-center bg-brand-teal-400 text-white px-8 py-12 gap-15 font-medium lg:px-40 lg:text-lg">
            <h2 class="text-2xl font-bold md:text-[50px]">Est-ce que je peux donner ?</h2>
            <div class="flex flex-col gap-4">
                <div v-for="condition, index in conditions" v-bind:key="index" class="pt-8 pb-4" :class="{'border-t-2': index>0}">
                    <h4 class="text-lg font-semibold pb-2 lg:text-2xl">{{ condition.title }}</h4>
                    <p>{{ condition.desc }}</p>
                </div>
            </div>
        </section>
        <section v-if="props.displayData" id="checker" class="relative flex flex-col px-8 py-10 gap-12 bg-brand-rose-400 font-medium items-center text-white lg:px-40 lg:text-lg">
            <h2 class="text-[38px]/[130%] font-semibold px-4 ">Envie d'aider ?</h2>
            <p class="text-center font-medium uppercase tracking-[8%] mx-12">Avant de réserver, assurez-vous de pouvoir donner. Vérifiez votre éligibilité en 2 minutes grâce à notre checker et prenez rendez-vous.</p>
            <Link href="/checker" class="lg:relative lg:right-90 lg:bottom-5">
                <img src="/assets/round_button_verify.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 -rotate-10 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-20 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
            <img src="/assets/mascottes/WriteBlueStar.svg" alt="Mascotte écrit" class="hidden lg:block  absolute h-80 right-5 bottom-5">
        </section>
        <section v-else id="contact" class="relative flex flex-col px-8 py-10 gap-12 bg-brand-rose-400 font-medium items-center text-white lg:px-40 lg:text-lg">
            <h2 class="text-[38px]/[130%] font-semibold px-4 ">Votre entreprise n'est pas encore labellisée ?</h2>
            <p class="text-center font-medium uppercase tracking-[8%] mx-12">Rejoignez dès maintenant la Blood League et obtenez votre label en organisant vos premières collectes de sang. Ensemble, faisons la différence.</p>
            <Link href="/contact" class="lg:relative lg:right-90 lg:bottom-5">
                <img src="/assets/round_button_organize.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 -rotate-10 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-20 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
            <img src="/assets/mascottes/WriteBlueStar.svg" alt="Mascotte écrit" class="hidden lg:block  absolute h-80 right-5 bottom-5">
        </section>
        <CharacterLoop/>
    </AppLayout>
</template>
