<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';


const props = defineProps({
    title : {type: String, default: 'HUG Blood League'},
    desc : {type: String, default: 'Site de la HUG Blood League'}
})
</script>

<template>
    <Head :title="props.title">
        <meta name="description" :content="props.desc" />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <header class="z-10 sticky top-0 flex py-4 px-4 justify-between items-center bg-brand-neutral-100 lg:px-6" >
        <Link href="/" class="flex gap-3 items-center">
            <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 lg:h-12">
            <span class="hidden lg:inline">✕</span>
            <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 hidden lg:inline">
        </Link>
        <Link href="/auth/logout" method="post" class="flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-200 active:bg-brand-neutral-300">Déconnexion</Link>
    </header>
    <slot />
</template>