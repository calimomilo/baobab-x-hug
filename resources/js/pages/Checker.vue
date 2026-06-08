<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Badge from '@/components/Badge.vue';

const props = defineProps({
    appointment_link: {type: String},
    displayData: Object,
    step: {type: Number, default: null}
})

const questions = [
    {
        title: 'Faites-vous plus que 50kg ?',
        explanation: 'Ce seuil de 50 kg garantit que le volume prélevé ne dépasse pas la limite de sécurité pour votre corps, évitant ainsi les malaises et les vertiges.',
        yes: false
    }
];

const answers = ref([null, true]);

const showPopup = ref(false);
</script>

<template>
    <Head title="Checker">
        <meta name="description" content="Vérifiez votre éligibilité pour le don de sang." />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <section v-if="props.step === null" id="intro" class="relative h-[100vh] bg-brand-sage-100 flex flex-col justify-center px-8 py-10 gap-x-8 gap-y-8 lg:px-40 font-medium lg:text-lg">
        <div class="absolute left-8 top-10 flex gap-2 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-8 self-start lg:h-12">
            <span>✕</span>
            <img src="/assets/logos/logo_hug_h_quadri.png" alt="Logo HUG" class="h-8 self-start">
        </div>
        <img src="/assets/mascottes/WriteBlueStar.svg" alt="Mascotte écrit" class="h-60">
        <h1 class=" text-center text-2xl font-bold">Puis-je donner mon sang ?</h1>
        <p class="text-sm text-center">Ce test rapide vous permet de vérifier que vous soyez actuellement en mesure de donner votrer sang.</p>
        <Link :href="`/${props.displayData?.slug}/checker/1`" class="text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100 h-11 rounded px-3 self-center flex items-center">Commencer le test</Link>
    </section>

    <section v-else :id="`question-${props.step}`" class="relative h-[100vh] bg-brand-rose-200 px-8 py-10 lg:px-40 font-medium lg:text-lg">
        <!-- LOGOS -->
        <div class="flex gap-2 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-8 self-start lg:h-12">
            <span>✕</span>
            <img src="/assets/logos/HUG_blanc.png" alt="Logo HUG" class="h-8 self-start">
        </div>
        
        <!-- STEP -->
        <p class="text-end my-6 text-brand-rose-500 md:hidden">{{ props.step }} / 16</p>

        <div class="h-[60vh] flex flex-col justify-center gap-x-8 gap-y-15">
            <h2 class="text-center text-2xl font-bold">{{ questions[props.step-1].title }}</h2>

            <!-- POPUP -->
            <div class="flex flex-col gap-8 items-center md:flex-row md:items-start">
                <div class="w-12 h-12 rounded-full p-2 bg-brand-rose-400 text-white text-center text-2xl font-bold z-10"
                    @mouseenter="showPopup = true" 
                    @mouseleave="showPopup = false" 
                    @click="showPopup = !showPopup">?
                </div>
                <div v-if="showPopup" class="flex flex-col items-start px-6 py-4 rounded-lg bg-white max-w-150 gap-3 font-medium">
                    <h3 class="text-lg font-semibold md:text-xl">Pourquoi cette question ?</h3>
                    <p class="leading-[130%]">{{ questions[props.step-1].explanation }}</p>
                </div>
            </div>

            <!-- OPTIONS -->
            <div class="flex flex-col gap-6">
                <div class="grow" @click="answers[props.step-1] = questions[props.step-1].yes">
                    <Badge :color="answers[props.step-1] === null ? 'checker-unselected' : answers[props.step-1] === questions[props.step-1].yes ? 'checker-selected' : 'checker-unselected'" class="justify-center">Oui</Badge>
                </div>
                <div class="grow" @click="answers[props.step-1] = !questions[props.step-1].yes">
                    <Badge :color="answers[props.step-1] === null ? 'checker-unselected' : answers[props.step-1] === questions[props.step-1].yes ? 'checker-unselected' : 'checker-selected'" class="justify-center">Non</Badge>
                </div>
            </div>
        </div>
    </section>
</template>