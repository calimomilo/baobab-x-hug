<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

</script>

<template>
    <AppLayout title="Login" desc="Connexion au module d'administration.">
        <section id="login" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-center bg-brand-teal-200 font-medium py-16 lg:px-40" >
            <div class="rounded-lg px-20 pt-15 pb-10 mb-20 bg-white w-full max-w-200">
                <h1 class="text-xl text-center pb-10 font-bold md:text-4xl">Connexion</h1>
                <Form action="/auth/login" method="post" #default="{ errors, invalid, validate }" class="flex flex-col gap-4 mx-auto max-w-200">
                    <div>
                        <label for="login" class="block text-sm mb-1 text-neutral-700">Nom d'utilisateur</label>
                        <input type="text" name="username" id="username" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('username')">
                        <div v-if="invalid('username')" class="text-sm text-brand-error-600 mt-1">{{ errors['username'] }}</div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm mb-1 text-neutral-700">Mot de passe<span class="text-brand-error-600 font-bold">*</span></label>
                        <input id="password" type="password" name="password" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-rose-500 focus:border-transparent" @change="validate('password')">
                        <div v-if="invalid('password')" class="text-sm text-brand-error-600 mt-1">{{ errors['password'] }}</div>
                    </div>
                    <Button class="self-center flex items-center px-15 h-11 mt-4 rounded font-medium text-xl text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100">Connexion</Button>
                </Form>
            </div>
        </section>
    </AppLayout>
</template>