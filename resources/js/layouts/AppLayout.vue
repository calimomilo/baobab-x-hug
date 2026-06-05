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
})

</script>

<template>
    <Head :title="props.title">
        <meta name="description" :content="props.desc" />
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col font-cooper text-black">
        <header class="bg-brand-sage-300 text-brand-sage-950 flex py-4 px-6 justify-between items-center sticky top-0 z-10">
        <!-- <header class="bg-white flex py-4 px-6 justify-between items-center sticky top-0 z-10"> -->
            <Link href="/" class="flex gap-3 items-center">
                <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 lg:h-12">
                <span class="hidden lg:inline">✕</span>
                <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 hidden lg:inline">
                <!-- <img src="/assets/logos/logo_hug_h_quadri.png" alt="Logo HUG" class="h-11 hidden lg:inline"> -->
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
                                    <MenuButton href="/leaderboard" display="mobile">Leaderboard</MenuButton>
                                    <MenuButton href="/blood-league" display="mobile">Blood League</MenuButton>
                                    <MenuButton href="/don-du-sang" display="mobile">Pourquoi donner ?</MenuButton>
                                    <MenuButton href="/contact" display="mobile" type="highlight-pink">Organiser une collecte</MenuButton>
                                </nav>
                            </div>
                            <SheetFooter class="flex justify-start p-0">
                                <img src="/assets/logos/BloodLeague_logo_noir_filled.png" alt="Logo Blood League" class="h-11 self-start">
                                <img src="/assets/logos/logo_hug_h_gris.png" alt="Logo HUG" class="h-11 self-start">
                            </SheetFooter>
                        </SheetContent>
                    </Sheet>
                </div>

            <div class="hidden lg:flex lg:gap-2">
                <MenuButton href="/leaderboard" display="desktop">Leaderboard</MenuButton>
                <MenuButton href="/blood-league" display="desktop">Blood League</MenuButton>
                <MenuButton href="/don-du-sang" display="desktop">Pourquoi donner ?</MenuButton>
                <MenuButton href="/contact" display="desktop" type="highlight-pink">Organiser une collecte</MenuButton>
            </div>
        </header>
        <slot />
        <div>Footer</div>
    </div>
</template>