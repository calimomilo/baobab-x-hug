<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import DashboardTile from '@/components/DashboardTile.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

// import { Link } from '@inertiajs/vue3';
// import { computed } from 'vue';
// import DashboardTile from '@/components/DashboardTile.vue';
// import { formatDate } from '@/lib/dateTimeFormatting';

type contactForm = {
    id: number,
    company_name: string,
    address: string,
    contact_address: string,
    contact_name: string,
    email: string,
    phone: string,
    message: string
}

const props = defineProps<{
    contactForms: Array<contactForm>
}>()
</script>

<template>
    <AdminLayout title="Formulaires de contact" desc="Liste des formulaires de contact">
        <section id="contact-forms" class="relative min-h-[calc(100vh-76px)] font-medium text-md font-cooper py-16 px-25">
            <Link href="/admin/dashboard" class="relative bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium hover:bg-brand-neutral-50 active:bg-brand-neutral-100 w-fit">← Dashboard</Link>
            <h1 class="col-span-12 font-bold text-4xl mb-8">Formulaires de contact</h1>

            <div class="flex flex-col gap-8">
                <DashboardTile v-for="contact in props.contactForms" :key="contact.id" color="teal" class="text-start items-start relative">
                    <div class="flex gap-6">
                        <div class="flex flex-col items-start text-start gap-1 border-r-2 border-brand-teal-800 pr-6">
                            <h2 class="font-bold text-2xl -mt-2 mb-2">{{ contact.company_name }}, {{ contact.contact_name }}</h2>
                            <p>Entreprise : {{ contact.company_name }}</p>
                            <p>Adresse : {{ contact.address }}</p>
                            <h3 class="font-semibold mt-4 mb-1">Contact : {{ contact.contact_name }}</h3>
                            <p>Téléphone : <a :href="`tel:${contact.phone}`" class="underline hover:text-brand-neutral-800 mt-2">{{ contact.phone }}</a></p>
                            <p>E-mail : <a :href="`mailto:${contact.email}`" class="underline hover:text-brand-neutral-800 mt-2">{{ contact.email }}</a></p>
                            <p>Adresse de contact : {{ contact.contact_address ?? '/' }}</p>
                        </div>
                        <p v-if="!contact.message" class="italic text-base">Pas de message</p>
                        <p>{{ contact.message }}</p>
                    </div>
                    <Link :href="`/admin/contacts/${contact.id}`" method="delete" class="absolute bottom-6 right-6 flex items-center text-lg px-3 h-11 rounded font-medium bg-brand-error-600 hover:bg-brand-error-700 active:bg-brand-error-800 text-white w-fit">Supprimer</Link>
                </DashboardTile>
            </div>
        </section>
    </AdminLayout>
</template>