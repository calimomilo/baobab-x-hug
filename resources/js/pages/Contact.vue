<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

</script>

<template>
    <AppLayout title="Contact" desc="Contactez-nous pour organiser une collecte.">
        <section id="contact" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-start bg-brand-rose-400 font-medium py-16 lg:px-40" >
            <div class="rounded-lg px-6 pt-15 pb-10 bg-white w-full">
                <h1 class="text-xl text-center pb-10 font-bold md:text-4xl">Contactez-nous pour organiser une collecte</h1>
                <Form action="/contact" method="post" #default="{ errors, invalid, validate }" class="flex flex-col gap-4 mx-auto max-w-200">
                    <div>
                        <label for="company_name" class="block text-sm mb-1 text-neutral-700">Nom de l'entreprise <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="company_name" id="company_name" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('company_name')">
                        <div v-if="invalid('company_name')" class="text-sm text-brand-error-600 mt-1">{{ errors['company_name'] }}</div>
                    </div>
                    <div>
                        <label for="address" class="block text-sm mb-1 text-neutral-700">Adresse de l'entreprise <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="address" id="address" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('address')">
                        <div v-if="invalid('address')" class="text-sm text-brand-error-600 mt-1">{{ errors['address'] }}</div>
                    </div>
                    <div>
                        <label for="contact_name" class="block text-sm mb-1 text-neutral-700">Nom de la personne de contact <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="contact_name" id="contact_name" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('contact_name')">
                        <div v-if="invalid('contact_name')" class="text-sm text-brand-error-600 mt-1">{{ errors['contact_name'] }}</div>
                    </div>
                    <div>
                        <label for="contact_address" class="block text-sm mb-1 text-neutral-700">Adresse de contact (facultatif)</label>
                        <input type="text" name="contact_address" id="contact_address" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('contact_address')">
                        <div v-if="invalid('contact_address')" class="text-sm text-brand-error-600 mt-1">{{ errors['contact_address'] }}</div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-[calc(50%-2px)]">
                            <label for="email" class="block text-sm mb-1 text-neutral-700">Adresse e-mail <span class="text-brand-error-600 font-bold">*</span></label>
                            <input type="text" name="email" id="email" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('email')">
                            <div v-if="invalid('email')" class="text-sm text-brand-error-600 mt-1">{{ errors['email'] }}</div>
                        </div>
                        <div class="w-[calc(50%-2px)]">
                            <label for="phone" class="block text-sm mb-1 text-neutral-700">Numéro de téléphone <span class="text-brand-error-600 font-bold">*</span></label>
                            <input type="text" name="phone" id="phone" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('phone')">
                            <div v-if="invalid('phone')" class="text-sm text-brand-error-600 mt-1">{{ errors['phone'] }}</div>
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block text-sm mb-1 text-neutral-700">Message (facultatif)</label>
                        <textarea name="message" id="message" rows="4" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus focus:border-transparent:ring-brand-rose-500" @change="validate('message')"></textarea>
                        <div v-if="invalid('message')" class="text-sm text-brand-error-600 mt-1">{{ errors['message'] }}</div>
                    </div>
                    <Button class="self-center flex items-center px-15 h-11 mt-4 rounded font-medium text-xl text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100">Envoyer</Button>
                </Form>
            </div>
        </section>
    </AppLayout>
</template>