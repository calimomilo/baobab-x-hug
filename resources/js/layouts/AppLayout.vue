<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    title : {type: String, default: 'HUG Blood League'},
    desc : {type: String, default: 'Site de la HUG Blood League'},
    active : {type: String, default: null}
})

</script>

<template>
    <Head :title="props.title">
        <meta name="description" :content="props.desc" />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col">
        <header class="bg-brand-sage-300 flex p-3 justify-between items-center">
            <div class="flex gap-3 items-center text-white">
                <img src="../../assets/BloodLeague_logo_blanc_filled.png" alt="Logo Blood League" class="h-10 lg:h-12">
                <span class="hidden lg:inline">✕</span>
                <img src="../../assets/LOG HUG_H_NEGATIF fond transparent.png" alt="Logo HUG" class="h-10 hidden lg:inline">
            </div>
        </header>
        <slot />
        <div>Footer</div>
    </div>
</template>