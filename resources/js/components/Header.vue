<template>
    <div id="kt_app_header" class="app-header align-items-stretch">
        <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
            <div class="d-flex align-items-center justify-content-between flex-row-fluid" id="kt_app_header_wrapper">
                <div class="app-header-logo d-flex align-items-center">
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                            <i class="ki-outline ki-abstract-14 fs-2"></i>
                        </div>
                    </div>
                    <router-link  :to="{name: authUser?'home':'tours'}" class="me-5 me-lg-9">
                        <h1 class="text-dark">Tours System</h1>
                    </router-link>
                </div>

                <div class="d-flex align-items-stretch" id="kt_app_header_menu_wrapper">
                    <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_menu_wrapper'}">
                        <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-600 menu-state-primary menu-arrow-gray-400 fw-semibold fw-semibold fs-6 align-items-stretch my-5 my-lg-0 px-2 px-lg-0" id="#kt_app_header_menu" data-kt-menu="true">
                            <NavLink v-if="authUser" title="Dashboard" :route="{name: 'home'}" icon-class="ki-outline ki-abstract-28 fs-3" />
                            <NavLink v-if="!authUser && user" title="My Booking" :route="{name: 'my-booking-list'}" icon-class="ki-outline ki-abstract-28 fs-3" />

                            <div v-if="authUser" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" data-kt-menu-offset="12,0" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-outline ki-abstract-41 fs-3"></i>
                                    </span>
                                    <span class="menu-title">Operations</span>
                                    <span class="menu-arrow"></span>
                                </span>

                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
                                <NavSubMenu title="User Management" icon-class="ki-outline ki-people fs-2" >
                                    <NavLink title="Operators" :route="{name: 'admins-list'}" v-if="permissions.includes('view operators')"/>
                                    <NavLink title="Customers" :route="{name: 'users-list'}" v-if="permissions.includes('view customers')"/>
                                </NavSubMenu>

                                <NavSubMenu title="Tours Management" icon-class="ki-outline ki-element-6 fs-2">
                                    <NavLink title="Destinations" :route="{name: 'destination-list'}" v-if="permissions.includes('view destinations')" />
                                    <NavLink title="Tours" :route="{name: 'tours-list'}" v-if="permissions.includes('view tours')" />
                                    <NavLink title="Bookings" :route="{name: 'bookings-list'}" v-if="permissions.includes('view bookings')" />
                                </NavSubMenu>

                                <NavSubMenu title="Globals" icon-class="ki-outline ki-setting-2 fs-2" >
                                    <NavLink title="Roles & Permissions" :route="{name: 'roles-and-permissions'}" v-if="permissions.includes('view roles')"/>
                                   
                                </NavSubMenu>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-navbar flex-shrink-0">
                 
                    <div class="app-navbar-item me-3" id="kt_header_user_menu_toggle">
                        <div class="btn btn-icon btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-profile-circle fs-1"></i>
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="/assets/media/avatars/default-user.png" />
                                    </div>
                                   
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">
                                            {{ authUser? authUser.full_name : '' }}
                                            {{ user? user.user.full_name : '' }}
                                        </div>
                                        <p class="fw-semibold text-muted fs-7">{{ authUser ? authUser.email:'' }} {{ user? user.user.email : '' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="separator my-2"></div>

                            <div class="separator my-2"></div>

                            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                <span class="menu-link px-5">
                                    <span class="menu-title position-relative">
                                        Mode
                                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                            <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                            <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                        </span>
                                    </span>
                                </span>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                    <div class="menu-item px-3 my-0">
                                        <span class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-night-day fs-2"></i>
                                            </span>
                                            <span class="menu-title">Light</span>
                                        </span>
                                    </div>
                                    <div class="menu-item px-3 my-0">
                                        <span class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-moon fs-2"></i>
                                            </span>
                                            <span class="menu-title">Dark</span>
                                        </span>
                                    </div>
                                    <div class="menu-item px-3 my-0">
                                        <span class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-screen fs-2"></i>
                                            </span>
                                            <span class="menu-title">System</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="menu-item px-5">
                                <span class="menu-link px-5" @click.prevent="signOut">Sign Out</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';
import { toast } from "vue3-toastify";
import NavLink from'@/components/NavLink.vue'
import NavSubMenu from '@/components/NavSubMenu.vue'

import { useUserStore } from "@/stores/userStore";

const router = useRouter()
const { authUser, permissions, logout } = useAuthStore()

const { user,userLogout } = useUserStore();


const signOut = async () => {

    if (permissions.length) {
         let response = await logout()

    if (response.status == 200) {
        router.push({name: 'admin_login'})
    } else {
        let err = response.data
        toast.error(err.message)
    }

    } else {

    let response = await userLogout()
    localStorage.removeItem("userStore");
    if (response.status == 200) {
        router.push({name: 'login'})
    } else {
        router.push({name: 'login'})
        let err = response.data
        // toast.error(err.message)
    }

    }


}

</script>

<style scoped></style>
