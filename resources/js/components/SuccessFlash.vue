<!-- <script setup lang="ts">
import { usePage } from '@inertiajs/vue3';

const page = usePage();

</script>

<template>
    <div id="toast" v-if="page.flash.toast" class="min-w-100 px-8 py-6 text-sm font-medium fixed z-20 top-10 right-10 rounded shadow-lg" :class="{
        'bg-lime-200 text-lime-900': page.flash.toast.success,
        'bg-brand-error-300 text-brand-error-950': !page.flash.toast.success
    }">
        <p class="font-semibold text-md">{{ page.flash.toast.success? 'Succès' : 'Erreur' }}</p>
        {{ page.flash.toast.message }}
    </div>
</template> -->