<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

type company = {
    id: number;
    company_name: string;
    address: string;
    contact_address: string;
    contact_name: string;
    email: string;
    phone: string;
    slug: string;
    primary_color: string;
    secondary_color: string;
    logo_url: string;
    anonymous: boolean;
}

const props = defineProps<{
    formData: company | null,
    slugs: Array<string>
}>()

console.log(props.formData);

const primary_color = ref(props.formData?.primary_color ?? '#000000');
const secondary_color = ref(props.formData?.secondary_color ?? '#FFFFFF');

const randomString = ref('');

const randString = (length = 16) => {
    const data = '23456789abcdefghjkmnpqrstuvwxyz';
    let str = '';

    do {
        str = '';

        for (let i = 0; i < length; i++) {
            str += data.split('')[Math.floor(Math.random()*data.length)];
        }
    } while (props.slugs.includes(str));

    return str;
}
const generateRandomString = () => {
    randomString.value = randString();
}

randomString.value = props.formData?.slug ?? randString();


</script>

<template>
    <AdminLayout title="Nouvelle entreprise" desc="Ajouter une nouvelle entreprise.">
        <section id="company-create" class="relative flex min-h-[calc(100vh-76px)] flex-col items-center justify-start bg-brand-sage-400 font-cooper font-medium py-16 lg:px-40" >
            <Link :href="props.formData? `/admin/companies/${props.formData.id}` : '/admin/companies'" class="relative self-start bottom-6 right-16 flex items-center px-3 h-11 rounded font-medium bg-brand-sage-300 hover:bg-brand-sage-200 active:bg-brand-sage-100 w-fit">← Retour</Link>
            <div class="rounded-lg px-6 pt-15 pb-10 bg-white w-full">
                <h1 v-if="props.formData" class="text-xl text-center pb-10 font-bold md:text-4xl">Modifier l'entreprise {{ props.formData.company_name }}</h1>
                <h1 v-else class="text-xl text-center pb-10 font-bold md:text-4xl">Ajouter une entreprise</h1>
                <Form :action="props.formData? `/admin/companies/${props.formData.id}` : '/admin/companies'" :method="props.formData? 'put' : 'post'" #default="{ errors, invalid, validate }" class="flex flex-col gap-4 mx-auto max-w-200">
                    <div>
                        <label for="company_name" class="block text-sm mb-1 text-neutral-700">Nom de l'entreprise <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="company_name" id="company_name" :value="props.formData?.company_name" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('company_name')">
                        <div v-if="invalid('company_name')" class="text-sm text-brand-error-600 mt-1">{{ errors['company_name'] }}</div>
                    </div>
                    <div>
                        <label for="address" class="block text-sm mb-1 text-neutral-700">Adresse <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="address" id="address" :value="props.formData?.address" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('address')">
                        <div v-if="invalid('address')" class="text-sm text-brand-error-600 mt-1">{{ errors['address'] }}</div>
                    </div>
                    <div>
                        <label for="contact_name" class="block text-sm mb-1 text-neutral-700">Personne de contact <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="text" name="contact_name" id="contact_name" :value="props.formData?.contact_name" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('contact_name')">
                        <div v-if="invalid('contact_name')" class="text-sm text-brand-error-600 mt-1">{{ errors['contact_name'] }}</div>
                    </div>
                    <div class="flex gap-4">
                        <div class="grow">
                            <label for="email" class="block text-sm mb-1 text-neutral-700">E-mail <span class="text-brand-error-600 font-bold">*</span></label>
                            <input type="text" name="email" id="email" :value="props.formData?.email" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('email')">
                            <div v-if="invalid('email')" class="text-sm text-brand-error-600 mt-1">{{ errors['email'] }}</div>
                        </div>
                        <div class="grow">
                            <label for="phone" class="block text-sm mb-1 text-neutral-700">Téléphone <span class="text-brand-error-600 font-bold">*</span></label>
                            <input type="text" name="phone" id="phone" :value="props.formData?.company_name" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('phone')">
                            <div v-if="invalid('phone')" class="text-sm text-brand-error-600 mt-1">{{ errors['phone'] }}</div>
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="contact_address" class="block text-sm mb-1 text-neutral-700">Adresse de contact</label>
                        <input type="text" name="contact_address" id="contact_address" :value="props.formData?.contact_address" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('contact_address')">
                        <div v-if="invalid('contact_address')" class="text-sm text-brand-error-600 mt-1">{{ errors['contact_address'] }}</div>
                    </div>
                    <div class="w-full">
                        <label for="slug" class="block text-sm mb-1 text-neutral-700">Slug unique <span class="text-brand-error-600 font-bold">*</span></label>
                        <div class="flex gap-4">
                            <input type="text" name="slug" id="slug" v-model="randomString" class="w-full px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('slug')">
                            <div class="aspect-square border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent text-xl font-bold px-3 flex items-center hover:cursor-pointer" @click="generateRandomString">⟲</div>
                        </div>
                        <div v-if="invalid('slug')" class="text-sm text-brand-error-600 mt-1">{{ errors['slug'] }}</div>
                    </div>
                    <div class="w-full">
                        <label for="logo_url" class="block text-sm mb-1 text-neutral-700">Logo <span class="text-brand-error-600 font-bold">*</span></label>
                        <input type="file" name="logo_url" id="logo_url" 
                        accept="image/jpeg,image/png,image/bmp,image/gif,image/webp" 
                        class="w-full px-3 py-2 border border-neutral-300 rounded file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-sage-100 file:text-brand-sage-700 focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('logo_url')">
                        <div v-if="invalid('logo_url')" class="text-sm text-brand-error-600 mt-1">{{ errors['logo_url'] }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label for="primary_color" class="block text-sm mb-1 text-neutral-700">Couleur principale <span class="text-brand-error-600 font-bold">*</span></label>
                            <div class="flex items-stretch gap-4">
                                <input type="color" name="pc" id="pc" v-model="primary_color" class="px-3 py-2 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('primary_color')">
                                <input type="text" name="primary_color" v-model="primary_color" id="primary_color" class="px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('primary_color')">
                            </div>
                            <div v-if="invalid('primary_color')" class="text-sm text-brand-error-600 mt-1">{{ errors['primary_color'] }}</div>
                        </div>
                        <div class="col-span-1">
                            <label for="secondary_color" class="block text-sm mb-1 text-neutral-700">Couleur secondaire <span class="text-brand-error-600 font-bold">*</span></label>
                            <div class="flex items-stretch gap-4">
                                <input type="color" name="sc" id="sc" v-model="secondary_color" class="px-3 py-2 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('secondary_color')">
                                <input type="text" name="secondary_color" v-model="secondary_color" id="secondary_color" class="px-3 py-2 border border-neutral-300 rounded focus:ring-2 focus:ring-brand-sage-400 focus:border-transparent" @change="validate('secondary_color')">
                            </div>
                            <div v-if="invalid('secondary_color')" class="text-sm text-brand-error-600 mt-1">{{ errors['secondary_color'] }}</div>
                        </div>
                        <div>
                            <div class="flex gap-2">
                                <input hidden type="text" name="anonymous" value="0">
                                <input type="checkbox" name="anonymous" id="anonymous" value="1" @change="validate('anonymous')">
                                <label for="secondary_color" class="block text-sm mb-1 text-neutral-700">Participation anonyme (Aucune donnée affichée sur le site de la Blood League)</label>
                            </div>
                            <div v-if="invalid('anonymous')" class="text-sm text-brand-error-600 mt-1">{{ errors['anonymous'] }}</div>
                        </div>
                    </div>
                    <Button class="self-center flex items-center px-15 h-11 mt-4 rounded font-medium text-xl text-white font-semibold bg-brand-rose-400 hover:bg-brand-rose-500/100 active:bg-brand-rose-600/100">Créer</Button>
                </Form>
            </div>
        </section>
    </AdminLayout>
</template>