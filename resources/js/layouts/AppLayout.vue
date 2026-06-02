<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import MenuButton from '@/components/MenuButton.vue';

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
    <div class="flex min-h-screen flex-col font-cooper">
        <header class="bg-brand-sage-300 flex p-3 justify-between items-center">
            <Link href="/" class="flex gap-3 items-center text-white">
                <img src="../../assets/BloodLeague_logo_blanc_filled.png" alt="Logo Blood League" class="h-10 lg:h-12">
                <span class="hidden lg:inline">✕</span>
                <img src="../../assets/LOG HUG_H_NEGATIF fond transparent.png" alt="Logo HUG" class="h-10 hidden lg:inline">
            </Link>
            <!-- <NavigationMenu>
                <NavigationMenuList>
                    <NavigationMenuItem>
                        <NavigationMenuLink as-child :class="navigationMenuTriggerStyle()">
                            <a href="/leaderboard">LeaderBoard</a>
                        </NavigationMenuLink>
                    </NavigationMenuItem>
                    <NavigationMenuItem>
                        <NavigationMenuTrigger>En savoir plus</NavigationMenuTrigger>
                        <NavigationMenuContent>
                            <a href="/blood-league" :class="navigationMenuTriggerStyle()" class="bg-transparent">Qu'est-ce que la Blood League ?</a>
                            <a href="/don-du-sang" :class="navigationMenuTriggerStyle()" class="bg-transparent">Pourquoi donner ?</a>
                        </NavigationMenuContent>
                    </NavigationMenuItem>
                </NavigationMenuList>
            </NavigationMenu> -->
            <div class="hidden lg:flex gap-2">
                <MenuButton href="/leaderboard" selected>Leaderboard</MenuButton>
                <MenuButton href="/blood-league">La Blood League</MenuButton>
                <MenuButton href="/don-du-sang">Pourquoi donner ?</MenuButton>
                <MenuButton href="/contact" type="highlight-pink">Organiser une collecte</MenuButton>
            </div>
        </header>
        <slot />
        <div>Footer</div>
    </div>
</template>