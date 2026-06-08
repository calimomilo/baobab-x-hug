<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const conditions = [
    {
        title: 'Avoir entre 18 et 75 ans',
        desc: 'Le don est ouvert dès 18 ans. La limite est de 60 ans pour un premier don, et jusqu\'à 75 ans pour les donneurs réguliers en bonne santé.'
    },
    {
        title: 'Peser plus de 50 kg',
        desc: 'Ce seuil garantit que le volume prélevé reste sans danger pour vous et permet d\'éviter malaises et vertiges.'
    },
    {
        title: 'Être en bonne santé le jour du don',
        desc: 'Pas de rhume, fièvre, diarrhée ou symptôme de refroidissement. Votre organisme doit être disponible pour le don.'
    },
    {
        title: 'Ne pas avoir de plaie ouverte ou d\'opération récente',
        desc: 'Votre corps a besoin de toutes ses ressources pour cicatriser, et une plaie ouverte présente un risque infectieux.'
    },
    {
        title: 'Ne pas prendre certains médicaments',
        desc: 'Certains traitements passent dans le sang prélevé ou indiquent une condition médicale incompatible avec le don.'
    },
    {
        title: 'Ne pas avoir d\'antécédents de VIH, hépatite B, hépatite C ou syphilis',
        desc: 'Ces infections sont transmissibles par le sang et représentent un risque vital pour le receveur.'
    },
    {
        title: 'Ne pas avoir d\'antécédents de cancer',
        desc: 'Par mesure de précaution, les antécédents de cancer rendent le don définitivement impossible.'
    },
    {
        title: 'Ne pas être traité(e) pour une maladie chronique sévère',
        desc: 'Diabète insulinodépendant, maladies inflammatoires de l\'intestin ou auto-immunes nécessitent que votre organisme conserve toutes ses ressources.'
    },
    {
        title: 'Ne pas avoir reçu de transfusion ou greffe',
        desc: 'Face aux risques résiduels de transmission de pathogènes, ces antécédents rendent le don définitivement impossible.'
    },
    {
        title: 'Ne pas avoir consommé de drogues par voie intraveineuse',
        desc: 'L\'usage de seringues partagées présente un risque majeur de transmission virale, même des années après l\'arrêt.'
    },
    {
        title: 'Pas de tatouage ou piercing dans les 2 derniers mois',
        desc: 'Le délai de 2 mois permet de s\'assurer qu\'aucune infection contractée pendant le geste ne se transmette via le don.'
    },
    {
        title: 'Vie sexuelle sans exposition au risque ces derniers mois',
        desc: 'Pas de partenaires multiples sur 12 mois ni de nouveau(elle) partenaire sur 4 mois, le temps de détecter une éventuelle infection.'
    },
    {
        title: 'Ne pas être suivi(e) pour une anémie ou carence en fer',
        desc: 'Un don aggraverait votre carence en fer et pourrait provoquer fatigue intense, vertiges ou autres complications.'
    },
    {
        title: 'Pas de soins dentaires dans les 14 derniers jours',
        desc: 'Les soins dentaires peuvent provoquer le passage temporaire de bactéries dans le sang, le temps que les gencives cicatrisent.'
    },
    {
        title: 'Pas de gastroscopie ou coloscopie dans les 4 derniers mois',
        desc: 'Ces examens invasifs nécessitent un délai pour s\'assurer qu\'aucune infection ou complication n\'est survenue.'
    },
    {
        title: 'Avoir vérifié vos voyages sur le Travelcheck',
        desc: 'Certains pays imposent un délai d\'attente après le retour. Le <a href="https://www.hug.ch/travelcheck" target="_blank">Travelcheck des HUG</a> vérifie votre éligibilité en quelques clics.'
    },
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
