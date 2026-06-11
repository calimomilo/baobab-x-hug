<script setup lang="ts">
import { Link, useHttp } from '@inertiajs/vue3';

const props = defineProps({
    slug: String,
    collect: Object,
    type: {type: String, default: 'supporter'}
})

const user_uuid = localStorage.getItem('user_uuid');

const http = useHttp({
    'user_uuid': user_uuid,
    'collect': props.collect
});

const appointmentClick = () => {
    http.post(`/${props.slug}/appointment-click`);
    window.open(props.collect?.appointment_link, '_blank');
}

const donorShare = () => {
    http.post(`/${props.slug}/donor-share`);

    const a = document.createElement('a');
    a.setAttribute('href', `/download/kits/donor`);
    a.setAttribute('download', 'kit-communication-donneur.zip');
    a.click();
}

 const supporterShare = () => {
    http.post(`/${props.slug}/supporter-share`);
    
    const a = document.createElement('a');
    a.setAttribute('href', `/download/kits/supporter`);
    a.setAttribute('download', 'kit-communication-supporter.zip');
    a.click();
 }

</script>

<template>
    <Head :title="props.type === 'donor'? 'Donneur' : 'Supporter'">
        <meta name="description" :content="props.type === 'donor'? 'Vous êtes éligible ! Félicitations.' : 'Partagez sur les réseaux sociaux.'" />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <!-- Donneur -->
    <section v-if="props.type === 'donor'" id="donor" class="relative h-[100vh] bg-brand-sage-100 flex flex-col justify-center items-center px-8 py-10 gap-x-10 gap-y-8 lg:px-40 font-medium md:flex-row">
        <div class="absolute left-8 top-10 flex gap-2 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-8 lg:h-12">
            <span>✕</span>
            <img src="/assets/logos/logo_hug_h_quadri.png" alt="Logo HUG" class="h-8">
        </div>
        <img src="/assets/mascottes/KneelBlueFlower.svg" alt="Mascotte à genoux" class="h-60 md:h-[30vw] md:-ml-30">
        <div class="flex flex-col gap-8 items-center md:items-start">
            <h1 class=" text-center text-2xl font-bold md:text-4xl md:text-start">Vous êtes <span class="text-brand-rose-400">éligible</span> !</h1>
            <p class="text-center md:text-lg md:text-start">Prenez rendez-vous et faites remporter des points à votre équipe.</p>
            <div class="flex flex-col gap-x-8 gap-y-4 md:flex-row">
                <button @click="appointmentClick" class="text-white text-center font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100 h-11 rounded px-3 flex justify-center items-center">Prendre rendez-vous</button>
                <button @click="donorShare" class="font-semibold bg-brand-sage-200 hover:bg-brand-sage-300 active:bg-brand-sage-400 h-11 rounded px-3 flex justify-center items-center">Partager sur les réseaux</button>
            </div>
            <Link :href="`/${props.slug}`" class="text-sm md:text-md underline text-brand-indigo-700 hover:text-brand-indigo-500">Retourner à l'accueil</Link>
        </div>
    </section>

    <!-- Supporter -->
    <section v-else id="supporter" class="relative h-[100vh] bg-brand-sage-100 flex flex-col justify-center items-center px-8 py-10 gap-x-10 gap-y-8 lg:px-40 font-medium md:flex-row">
        <div class="absolute left-8 top-10 flex gap-2 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-8 lg:h-12">
            <span>✕</span>
            <img src="/assets/logos/logo_hug_h_quadri.png" alt="Logo HUG" class="h-8">
        </div>
        <img src="/assets/mascottes/ScreamBlueNona.svg" alt="Mascotte crie" class="h-60 md:h-[30vw] md:-ml-30">
        <div class="flex flex-col gap-8 items-center md:items-start">
            <h1 class=" text-center text-2xl font-bold md:text-4xl md:text-start">Devenez <span class="text-brand-rose-400">supporter</span> !</h1>
            <p class="text-center md:text-lg md:text-start">Vous n'êtes malheureusement pas éligible, mais vous pouvez partager sur les réseaux sociaux pour faire remporter des points à votre équipe.</p>
            <div class="flex flex-col gap-x-8 gap-y-4 md:flex-row">
                <button @click="supporterShare" class="text-white text-center font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100 h-11 rounded px-3 flex justify-center items-center">Partager sur les réseaux</button>
            </div>
            <Link :href="`/${props.slug}`" class="text-sm md:text-md underline text-brand-indigo-700 hover:text-brand-indigo-500">Retourner à l'accueil</Link>
        </div>
    </section>
</template>