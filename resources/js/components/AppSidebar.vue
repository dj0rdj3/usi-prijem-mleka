<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;
let mainNavItems: NavItem[] = [];

switch (user.tip) {
    case 'domacin':
        if (user.domacinstvo) {
            mainNavItems = [
                {
                    title: 'Moje domaćinstvo',
                    href: `/domacinstvo/${user.domacinstvo.id}`,
                    icon: BookOpen,
                },
            ];
        }
        else {
            mainNavItems = [
                {
                    title: 'Početna',
                    href: '/pocetna',
                    icon: BookOpen,
                },
            ];
        }
        break;
    case 'rukovodilac':
        mainNavItems = [
            {
                title: 'Dashboard',
                href: '/dashboard',
                icon: LayoutGrid,
            },
            {
                title: 'Izdavanje radnog naloga',
                href: '/radni-nalog/create',
                icon: BookOpen,
            },
        ];
        break;
}
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('pocetna')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
