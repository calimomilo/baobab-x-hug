<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const conditions = [
    {
        title: 'Avoir entre 18 et 75 ans',
        desc: 'Le don est ouvert dès 18 ans, sans limite supérieure stricte pour les donneurs réguliers en bonne santé.'
    },
    {
        title: 'Peser au moins 50 kg',
        desc: 'Ce seuil garantit ta sécurité pendant et après le prélèvement.'
    },
    {
        title: 'Être en bonne santé le jour J',
        desc: 'Pas de rhume, fièvre, infection en cours ni fatigue inhabituelle. Un vaccin récent, un traitement médicamenteux ou une intervention dentaire peuvent reporter ton don.'
    },
    {
        title: 'Respecter le délai entre deux dons',
        desc: '8 semaines minimum entre deux dons. Jusquà 4 dons par an pour les hommes, 3 pour les femmes.'
    },
    {
        title: 'Quelques situations spécifiques à vérifier',
        desc: 'Voyage hors dEurope récent, tatouage de moins de 4 mois, grossesse, ou certains antécédents médicaux peuvent temporairement ou définitivement empêcher le don.'
    },
    {
        title: 'Pas sûr de pouvoir donner ?',
        desc: 'Faites le test via notre checker online.'
    }
]

</script>

<template>

    <AppLayout title="Blood League" desc="Découvrez l'impact et les conditions du don du sang.">
        <section id="hero" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-12 gap-4 font-medium lg:px-40 lg:flex-row lg:justify-center">
            <div class="flex flex-col px-8 py-12 gap-4 self-start my-auto lg:text-lg">
                <h2 class="w-9/10 text-2xl font-bold md:text-[50px] md:w-full">Pourquoi donner ?</h2>
                <h4 class="uppercase tracking-[8%] mb-4">Le don du sang : un geste simple, un impact réel.</h4>
                <p>Chaque don réalisé lors d'une collecte  contribue directement à l'approvisionnement du canton de Genève. En plus de ça, il fait progresser votre équipe dans le classement de la Blood League.</p>
            </div>
            <img src="/assets/mascottes/DrinkPinkFlower.svg" alt="Mascotte boit" class="scale-x-[-1] my-auto max-h-100 lg:h-100">
        </section>
        <section id="infos" class="relative min-h-[calc(100vh-76px)] flex flex-col px-8 py-12 gap-4 font-medium lg:px-40 lg:flex-row lg:justify-center">
            ???
        </section>
        <section id="infos" class="relative min-h-[calc(100vh-76px)] flex flex-col items-center bg-brand-teal-400 text-white px-8 py-12 gap-15 font-medium lg:px-40 lg:text-lg">
            <h2 class="text-2xl font-bold md:text-[50px]">Est-ce que je peux donner ?</h2>
            <div class="flex flex-col gap-4">
                <div v-for="condition, index in conditions" v-bind:key="index" class="pt-8 pb-4" :class="{'border-t-2': index>0}">
                    <h4 class="text-lg font-semibold pb-2 lg:text-2xl">{{ condition.title }}</h4>
                    <p>{{ condition.desc }}</p>
                </div>
            </div>
        </section>
        <section id="contact" class="relative flex flex-col px-8 py-10 gap-12 bg-brand-rose-400 font-medium items-center text-white lg:px-40 lg:text-lg">
            <h2 class="text-[38px]/[130%] font-semibold px-4 ">Votre entreprise n'est pas encore labellisée ?</h2>
            <p class="text-center font-medium uppercase tracking-[8%] mx-12">Rejoignez dès maintenant la Blood League et obtenez votre label en organisant vos premières collectes de sang. Ensemble, faisons la différence.</p>
            <Link href="/contact" class="lg:relative lg:right-90 lg:bottom-5">
                <img src="/assets/round_button_organize.svg" alt="Bouton noir rond avec le texte Organiser une collecte" class="w-40 h-40 -rotate-10 lg:w-50 lg:h-50 hover:scale-110 hover:rotate-20 transition duration-150 ease-in-out"> <!-- figure out how to make pink -->
            </Link>
            <img src="/assets/mascottes/WriteBlueStar.svg" alt="Mascotte écrit" class="hidden lg:block  absolute h-80 right-5 bottom-5">
        </section>
    </AppLayout>
</template>
