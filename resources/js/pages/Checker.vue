<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    appointment_link: {type: String},
    displayData: Object,
    step: {type: Number, default: null}
})
</script>

<template>
    <Head title="Checker">
        <meta name="description" content="Vérifiez votre éligibilité pour le don de sang." />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <section id="question" class="relative h-[100vh] flex flex-col px-8 py-15 gap-x-8 gap-y-8 lg:px-40 font-medium lg:text-lg">
        {{ props.appointment_link }} {{ props.step ?? 'null' }}
        <Link v-if="props.step && props.step > 0" :href="`/${props.displayData?.slug}/checker/${props.step - 1}`">Prev</Link>
        <Link :href="`/${props.displayData?.slug}/checker/${props.step + 1}`">Next</Link>
    </section>
</template>