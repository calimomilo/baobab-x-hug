<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Badge from '@/components/Badge.vue';
import { setItem, getItem } from '@/lib/sessionStorage.js';

const props = defineProps({
    appointment_link: {type: String},
    displayData: Object,
    step: {type: Number, default: null}
})

const uuid = localStorage.getItem('user_uuid');

if (!uuid) {
    localStorage.setItem('user_uuid', self.crypto.randomUUID());
}

const questions = [
    {
        title: 'Avez-vous déjà donné votre sang ?',
        explanation: 'Cette réponse détermine la limite d\'âge applicable : 18-60 ans pour un premier don, 18-75 ans pour les donneurs réguliers.',
        yes: true
    },
    {
        title: 'Avez-vous entre 18 et 75 ans ?',
        explanation: 'La limite d\'âge supérieure est étendue à 75 ans pour les donneurs réguliers en bonne santé, car leur historique médical est déjà connu du CTS.',
        yes: true
    },
    {
        title: 'Avez-vous entre 18 et 60 ans ?',
        explanation: 'Pour un premier don, la limite d\'âge est fixée à 60 ans afin d\'évaluer votre tolérance au prélèvement dans les meilleures conditions.',
        yes: true
    },
    {
        title: 'Faites-vous plus de 50 kg ?',
        explanation: 'Ce seuil de 50 kg garantit que le volume prélevé reste sans danger pour vous et permet d\'éviter les malaises et les vertiges.',
        yes: true
    },
    {
        title: 'Êtes-vous actuellement en bonne santé ? (pas de symptôme de refroidissement, pas de fièvre, ni rhume, ni diarrhée)',
        explanation: 'Une infection en cours pourrait être transmise au receveur et le don pourrait affaiblir votre organisme pendant la guérison.',
        yes: true
    },
    {
        title: 'Avez-vous actuellement une plaie ou avez-vous été opéré récemment ?',
        explanation: 'Votre organisme a besoin de toutes ses ressources pour cicatriser, et une plaie ouverte présente un risque infectieux.',
        yes: false
    },
    {
        title: 'Prenez-vous des médicaments, même tous les jours ?',
        explanation: 'Certains traitements peuvent passer dans le sang prélevé ou indiquer une condition médicale incompatible avec le don.',
        yes: false
    },
    {
        title: 'Avez-vous été testé(e) positif pour le VIH (sida), VHB (hépatite B), VHC (hépatite C) ou la syphilis ?',
        explanation: 'Ces infections sont transmissibles par le sang et représentent un risque vital pour le receveur, même avec un traitement.',
        yes: false
    },
    {
        title: 'Avez-vous eu un cancer au cours de votre vie ?',
        explanation: 'Par mesure de précaution, les antécédents de cancer rendent le don définitivement impossible afin de protéger les receveurs.',
        yes: false
    },
    {
        title: 'Êtes-vous traité(e) pour une maladie chronique telle que : diabète (traité par insuline), maladie inflammatoire de l\'intestin, maladie auto-immune... ?',
        explanation: 'Ces maladies nécessitent que votre organisme conserve toutes ses ressources, et certains traitements sont incompatibles avec le don.',
        yes: false
    },
    {
        title: 'Avez-vous déjà eu une transfusion de sang (globules rouges, plaquettes ou plasma) ou une greffe d\'organe ?',
        explanation: 'Par principe de précaution face aux risques résiduels de transmission de pathogènes, ces antécédents rendent le don définitivement impossible.',
        yes: false
    },
    {
        title: 'Avez-vous déjà pris des drogues et/ou substances dopantes par voie intraveineuse ?',
        explanation: 'L\'usage de seringues partagées présente un risque majeur de transmission d\'infections virales, même des années après l\'arrêt.',
        yes: false
    },
    {
        title: 'Avez-vous eu une séance de tatouage ou un piercing dans les 2 derniers mois (y compris perçage d\'oreilles, maquillage permanent et semi-permanent) ?',
        explanation: 'Le délai de 2 mois permet de s\'assurer qu\'aucune infection contractée pendant le geste ne se transmette via le don.',
        yes: false
    },
    {
        title: 'Avez-vous eu des relations sexuelles avec des partenaires multiples au cours des 12 derniers mois ou avec un(e) nouveau(elle) partenaire ces quatre derniers mois ?',
        explanation: 'Ce délai correspond à la fenêtre nécessaire pour détecter une éventuelle infection sexuellement transmissible non encore diagnostiquée.',
        yes: false
    },
    {
        title: 'Êtes-vous suivi(e) par votre médecin pour une anémie (baisse du taux d\'hémoglobine) ou un manque de fer ?',
        explanation: 'Un don aggraverait votre carence en fer et pourrait provoquer fatigue intense, vertiges ou autres complications.',
        yes: false
    },
    {
        title: 'Au cours des 14 derniers jours, avez-vous eu un traitement dentaire ou d\'hygiène dentaire ?',
        explanation: 'Les soins dentaires peuvent provoquer le passage temporaire de bactéries dans le sang, le temps que les gencives cicatrisent.',
        yes: false
    },
    {
        title: 'Avez-vous eu une gastroscopie ou coloscopie au cours des 4 derniers mois ?',
        explanation: 'Ces examens invasifs nécessitent un délai pour s\'assurer qu\'aucune infection ou complication n\'est survenue suite à l\'intervention.',
        yes: false
    },
    {
        title: 'Avez-vous vérifié sur le Travelcheck que vos voyages récents ou futurs vous autorisent à donner votre sang ?',
        explanation: 'Certains pays présentent des risques infectieux (paludisme, virus tropicaux) qui imposent un délai d\'attente après le retour. Le Travelcheck des HUG vérifie en quelques clics votre éligibilité selon vos destinations.',
        yes: true
    },
]

const mascottes = [
    { src: `/assets/mascottes/ClockBlueHexa.svg`, alt: `Mascotte en retard`},
    { src: `/assets/mascottes/DrinkPinkFlower.svg`, alt: `Mascotte boit`},
    { src: `/assets/mascottes/EgiptGreenTri.svg`, alt: `Mascotte dance`},
    { src: `/assets/mascottes/ScreamBlueNona.svg`, alt: `Moascotte crie`},
    { src: `/assets/mascottes/PeacePinkTri.svg`, alt: `Mascotte signe V`},
    { src: `/assets/mascottes/NinjaGreenFlam.svg`, alt: `Mascotte est ninja`},
    { src: `/assets/mascottes/KneelBlueFlower.svg`, alt: `Mascotte célèbre`},
    { src: `/assets/mascottes/VenusPinkStar.svg`, alt: `Mascotte est la Venus de botticelli`},
    { src: `/assets/mascottes/HiGreenTri.svg`, alt: `Mascotte salut`},
    { src: `/assets/mascottes/LoveBlueCerf.svg`, alt: `Mascotte aime`},
    { src: `/assets/mascottes/PlantPinkTri.svg`, alt: `Mascotte jardine`},
    { src: `/assets/mascottes/RunBlueFlam.svg`, alt: `Mascotte court`},
    { src: `/assets/mascottes/ShopGreenHexa.svg`, alt: `Mascotte fait du shopping`},
    { src: `/assets/mascottes/YeahPinkFlam.svg`, alt: `Mascotte supporte`},
    { src: `/assets/mascottes/WriteBlueStar.svg`, alt: `Mascotte écrit`},
    { src: `/assets/mascottes/PaintPinkHexa.svg`, alt: `Mascotte peint`},
    { src: `/assets/mascottes/LightGreenTri.svg`, alt: `Mascotte à une idée`},
]

type answer = boolean | null;

const answers : Array<answer> = [];

for (let i = 1; i <= 17; i++) {
    answers.push(getItem(`answer-${i}`));
} 

const checkYes = () => {
    if (props.step == 1) {
        setItem('answer-1', true);
        setItem('answer-2', null);
    } else if (props.step == 2) {
        setItem('answer-2', true);
    } else {
        setItem(`answer-${props.step}`, questions[props.step].yes);
    }

    if (props.step == 17) {
        const check = answers.reduce((carry, answer) => {
            return carry && answer;
        }, true);

        if (check) {
            router.visit(`/${props.displayData?.slug}/donor`);
        } else {
            router.visit(`/${props.displayData?.slug}/checker/${answers.indexOf(null) + 1}`);
        }
    } else if (getItem(`answer-${props.step}`)) {
        router.visit(`/${props.displayData?.slug}/checker/${+props.step + 1}`);
    } else {
        router.visit(`/${props.displayData?.slug}/supporter`);
    }
}

const checkNo = () => {
    if (props.step == 1) {
        setItem('answer-1', false);
        setItem('answer-2', null);
    } else if (props.step == 2) {
        setItem('answer-2', false);
    } else {
        setItem(`answer-${props.step}`, !questions[props.step].yes);
    }

    if (getItem(`answer-${props.step}`)) {
        router.visit(`/${props.displayData?.slug}/checker/${+props.step + 1}`);
    } else {
        router.visit(`/${props.displayData?.slug}/supporter`);
    }
}

// POP-UP

const showPopup = ref(false);

const showP = () => showPopup.value = true;
const hideP = () => showPopup.value = false;
const toggleP = () => showPopup.value = !showPopup.value;

// NAV

const prev = () => {
    if (props.step != 0) {
        router.visit(`/${props.displayData?.slug}/checker/${+props.step - 1}`);
    }
};
const next = () => {
    if (answers[props.step-1] !== null) {
        router.visit(`/${props.displayData?.slug}/checker/${+props.step + 1}`);
    }
};
</script>

<template>
    <Head title="Checker">
        <meta name="description" content="Vérifiez votre éligibilité pour le don de sang." />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <!-- INTRO -->
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

    <section v-else :id="`question-${props.step}`" class="relative h-[100vh] bg-brand-rose-200 flex flex-col px-8 py-10 font-medium lg:text-lg lg:px-20">
        <!-- LOGOS -->
        <div class="flex gap-2 items-center lg:px-12">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-8 self-start lg:h-12">
            <span>✕</span>
            <img src="/assets/logos/HUG_blanc.png" alt="Logo HUG" class="h-8 self-start">
        </div>
        
        <!-- STEP -->
        <p class="text-end my-6 text-brand-rose-500 md:hidden lg:px-12">{{ props.step }} / 17</p>
        <div class="hidden md:flex flex-nowrap gap-2 w-full mt-10">
            <div v-for="mascotte, index in mascottes" :key="index" class="w-200 border-b-5 pb-1 px-2 self-end" :class="{
                'border-brand-rose-400' : answers[index] !== null,
                'border-white' : answers[index] === null
            }">
                <img v-if="index < props.step" :src="mascotte.src" :alt="mascotte.alt" class="inline w-full">
            </div>
        </div>

        <!-- QUESTIONS -->
        <div class="grow flex flex-col justify-center gap-y-10 md:flex-row md:justify-between md:mt-[10vh] lg:px-12 lg:text-xl">
            <div class="flex flex-col gap-10 md:w-3/5">
                <h2 v-if="props.step == 17" class="text-center text-2xl font-bold md:text-start md:text-4xl">Avez-vous vérifié sur le <a href="https://www.hug.ch/travelcheck" class="underline text-brand-indigo-600 hover:text-brand-indigo-400" target="_blank">Travelcheck</a> que vos voyages récents ou futurs vous autorisent à donner votre sang ?</h2>
                <h2 v-else class="text-center text-2xl font-bold md:text-start md:text-4xl">{{ 
                    props.step == 1? questions[0].title 
                    : props.step == 2 && answers[0]? questions[1].title
                    : props.step == 2 && !answers[0]? questions[2].title
                    :questions[props.step].title
                    }}</h2>
                    

                <!-- POPUP -->
                <div class="flex flex-col gap-8 items-center md:flex-row md:items-start">
                    <div class="w-12 h-12 rounded-full p-2 bg-brand-rose-400 text-white text-center text-2xl font-bold shrink-0"
                        @mouseenter="showP" 
                        @mouseleave="hideP" 
                        @click="toggleP">?
                    </div>
                    <div v-if="showPopup" class="flex flex-col items-start px-6 py-4 rounded-lg bg-white max-w-150 gap-3 font-medium md:mt-5">
                        <h3 class="text-lg font-semibold md:text-xl">Pourquoi cette question ?</h3>
                        <p class="leading-[130%]">{{ 
                            props.step == 1? questions[0].explanation 
                            : props.step == 2 && answers[0]? questions[1].explanation
                            : props.step == 2 && !answers[0]? questions[2].explanation
                            :questions[props.step].explanation
                        }}</p>
                    </div>
                </div>
            </div>

            <!-- OPTIONS -->
            <div class="flex flex-col gap-6 md:w-1/4 md:mt-[5vh] md:gap-10">
                <div class="grow md:grow-0" @click="checkYes()">
                    <Badge :color="answers[props.step-1] === null ? 'checker-unselected' : answers[props.step-1] === questions[props.step].yes ? 'checker-selected' : 'checker-unselected'" class="justify-center">Oui</Badge>
                </div>
                <div class="grow md:grow-0" @click="checkNo()">
                    <Badge :color="answers[props.step-1] === null ? 'checker-unselected' : answers[props.step-1] === questions[props.step].yes ? 'checker-unselected' : 'checker-selected'" class="justify-center">Non</Badge>
                </div>
            </div>
        </div>
        
        <!-- NAV -->
        <div class="mb-10 flex justify-between md:px-80">
            <div class="w-12 h-12 rounded-full p-2 text-white text-center text-4xl font-bold shrink-0 scale-x-[-1] hover:cursor-pointer"
                @click="prev">➤</div>
            <div class="w-12 h-12 rounded-full p-2 text-white text-center text-4xl font-bold shrink-0"
                :class="{
                    'hidden' : props.step == 17,
                    'disabled text-white/40' : answers[props.step-1] === null,
                    'hover:cursor-pointer' : answers[props.step-1] !== null
                }" @click="next">➤</div>
        </div>
    </section>
</template>