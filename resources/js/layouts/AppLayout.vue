<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Menu } from 'lucide-vue-next';
import MenuButton from '@/components/MenuButton.vue';
import {
    Sheet,
    SheetContent,
    SheetFooter,
    SheetTitle,
    SheetTrigger,
 } from '@/components/ui/sheet';

const props = defineProps({
    title : {type: String, default: 'HUG Blood League'},
    desc : {type: String, default: 'Site de la HUG Blood League'},
    displayData: Object || null
})

</script>

<template>
    <Head :title="props.title">
        <meta name="description" :content="props.desc" />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="relative flex min-h-screen flex-col font-cooper text-black">
        <header class="bg-brand-sage-300 text-brand-sage-950 flex py-4 px-4 justify-between items-center sticky top-0 z-10 lg:px-6">
            <Link v-if="props.displayData" :href="`/${props.displayData.slug}`" class="flex gap-3 items-center">
                <img :src="props.displayData.logo_url" :alt="`Logo de l'entreprise ${props.displayData.name}`" class="max-h-11 max-w-36 lg:max-h-12">
                <span>✕</span>
                <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 lg:h-12">
            </Link>
            <Link v-else href="/" class="flex gap-3 items-center">
                <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 lg:h-12">
                <span class="hidden lg:inline">✕</span>
                <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 hidden lg:inline">
            </Link>

            <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button class="h-11 w-11">
                                <Menu class="mx-auto h-6 w-6 fill-current" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] h-screen p-6">
                            <SheetTitle class="sr-only">NMenu de navigation</SheetTitle>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6" >
                                <nav class="-mx-3 space-y-1 font-cooper">
                                    <MenuButton :href="props.displayData? `/${props.displayData.slug}/leaderboard` : '/leaderboard'" display="mobile">Leaderboard</MenuButton>
                                    <MenuButton :href="props.displayData? `/${props.displayData.slug}/blood-league` : '/blood-league'" display="mobile">Blood League</MenuButton>
                                    <MenuButton :href="props.displayData? `/${props.displayData.slug}/don-du-sang` : '/don-du-sang'" display="mobile">Pourquoi donner ?</MenuButton>
                                    <MenuButton :href="props.displayData? `/${props.displayData.slug}/checker` : '/contact'" display="mobile" type="highlight-pink">{{ props.displayData? 'Vérifier mon éligibilité' : 'Organiser une collecte' }}</MenuButton>
                                </nav>
                            </div>
                            <SheetFooter class="flex justify-start p-0">
                                <img v-if="props.displayData" :src="props.displayData.logo_url" :alt="`Logo de l'entreprise ${props.displayData.name}`" class="h-11 self-start">
                                <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 self-start">
                                <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 self-start">
                            </SheetFooter>
                        </SheetContent>
                    </Sheet>
                </div>

            <div class="hidden lg:flex lg:gap-2">
                <MenuButton :href="props.displayData? `/${props.displayData.slug}/leaderboard` : '/leaderboard'" display="desktop">Leaderboard</MenuButton>
                <MenuButton :href="props.displayData? `/${props.displayData.slug}/blood-league` : '/blood-league'" display="desktop">Blood League</MenuButton>
                <MenuButton :href="props.displayData? `/${props.displayData.slug}/don-du-sang` : '/don-du-sang'" display="desktop">Pourquoi donner ?</MenuButton>
                <MenuButton :href="props.displayData? `/${props.displayData.slug}/checker` : '/contact'" display="desktop" type="highlight-pink">{{ props.displayData? 'Vérifier mon éligibilité' : 'Organiser une collecte' }}</MenuButton>
            </div>
        </header>
        <slot />
        <footer class="flex flex-col gap-y-10 gap-x-6 justify-between justify-items-start bg-brand-sage-300 text-brand-sage-950 py-20 px-10 text-sm font-medium md:text-md md:flex-row">
            <div class="flex flex-col gap-6 grow items-start">
                <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-15">
                <p>Hôpitaux Universitaires Genève<br>Rue Gabrielle-Perret-Gentil 4<br>1205 Genève</p>
                <p>Centre de transfusion sanguine (CTS)<br>Rue Gabrielle-Perret-Gentil 6<br>1205 Genève</p>
            </div>
            <div class="flex flex-col gap-1 grow items-start md:gap-2">
                <h4 class="font-semibold tracking-[8%] uppercase mb-2 md:mb-4">Médias</h4>
                <a href="https://www.hug.ch/newsletters">Newsletters</a>
                <a href="https://www.hug.ch/medias">Espace presse</a>
                <a href="https://panorama.hug.ch/">Rapport d'activité</a>
                <a href="https://www.hug.ch/blogs">Blogs</a>
            </div>
            <div class="flex flex-col gap-1 grow items-start md:gap-2">
                <h4 class="font-semibold tracking-[8%] uppercase mb-2 md:mb-4">Contenu</h4>
                <Link :href="props.displayData? `/${props.displayData.slug}/leaderboard` : '/leaderboard'">Leaderboard</Link>
                <Link :href="props.displayData? `/${props.displayData.slug}/blood-league` : '/blood-league'">Blood League</Link>
                <Link :href="props.displayData? `/${props.displayData.slug}/blood-league` : '/blood-league'">Blood League Label</Link>
                <Link :href="props.displayData? `/${props.displayData.slug}/blood-league#awards` : '/blood-league#awards'">Blood League Awards</Link>
                <Link :href="props.displayData? `/${props.displayData.slug}/don-du-sang` : '/don-du-sang'">Pourquoi donner ?</Link>
                <Link :href="props.displayData? `/${props.displayData.slug}/don-du-sang#conditions` : '/don-du-sang#conditions'">Conditions de don</Link>
            </div>
            <div class="flex flex-col gap-1 grow items-start md:gap-2">
                <h4 class="font-semibold tracking-[8%] uppercase mb-2 md:mb-4">S'engager</h4>
                <Link :href="props.displayData? `/${props.displayData.slug}/checker` : '/contact'" display="mobile" type="highlight-pink">{{ props.displayData? 'Vérifier mon éligibilité' : 'Organiser une collecte' }}</Link>
            </div>
        </footer>
    </div>
</template>