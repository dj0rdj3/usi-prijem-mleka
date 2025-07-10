<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { House, NotebookPen, Folders, LayoutGrid, SquareUserRound } from 'lucide-vue-next';
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
                    icon: House,
                },
            ];
        }
        else {
            mainNavItems = [
                {
                    title: 'Početna',
                    href: '/pocetna',
                    icon: House,
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
                icon: NotebookPen,
            },
            {
                title: 'Radni nalozi',
                href: '/radni-nalog',
                icon: Folders,
            },
            {
                title: 'Zaposleni',
                href: '/zaposleni',
                icon: SquareUserRound,
            },
        ];
        break;
    case 'vozac':
    case 'tehnolog':
        mainNavItems = [
            {
                title: 'Radni nalozi',
                href: '/radni-nalog',
                icon: Folders,
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
                        <Link :href="route('home')">
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
