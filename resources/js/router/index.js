import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import { useUserStore } from "@/stores/userStore";

// PARENT COMPONENTS
import Auth from "@/components/Auth.vue";
import Main from "@/components/Main.vue";

// DASHBOARD PAGE COMPONENTS
import Home from "@/pages/Home.vue";
import Users from "@/pages/Users.vue";
import Admins from "@/pages/Admins.vue";
import RolesAndPermissions from "@/pages/RolesAndPermissions.vue";
import Destination from "@/pages/admin/Destinations.vue";
import Tours from "@/pages/admin/Tours.vue";
import Bookings from "@/pages/admin/Bookings.vue";


// AUTH PAGE COMPONENTS
import Login from "@/pages/Login.vue";
import ForgotPassword from "@/pages/ForgotPassword.vue";
import ResetPassword from "@/pages/ResetPassword.vue";

import NotFound from "@/pages/NotFound.vue";

//USER ROUTES
import UserAuth from "@/components/user/UserAuth.vue";
import UserMain from "@/components/user/UserMain.vue";
import UserLogin from "@/pages/user/Login.vue";
import UserRegister from "@/pages/user/Register.vue";
import UserForgotPassword from "@/pages/user/ForgotPassword.vue";
import VerifyUserAccount from "@/pages/user/VerifyUserAccount.vue"
import UserSetPassword from "@/pages/user/ResetPassword.vue";

import TourPage from "../pages/tours/TourPage.vue";
import Tour_details from "../pages/tours/tour_details.vue";
import My_bookings from "../pages/tours/my_bookings.vue";



const checkGuest = (to, from) => {
    const { authUser } = useAuthStore();
    const { user } = useUserStore();
    if (authUser) {
        return {
            name: "home",
        };
    } else {
        return true;
    }
};

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/admin",
            component: Main,
            children: [
                {
                    path: "/admin",
                    name: "home",
                    component: Home,
                    meta: {
                        requiresAuth: true,
                        title: "Dashboard",
                    },
                },
                {
                    path: "/admin/user-management",
                    children: [
                        {
                            path: "customers",
                            name: "users-list",
                            component: Users,
                            meta: {
                                requiresAuth: true,
                                title: "Customers List",
                                permission: "view customers",
                            },
                        },
                        {
                            path: "operators",
                            name: "admins-list",
                            component: Admins,
                            meta: {
                                requiresAuth: true,
                                title: "Operators List",
                                permission: "view operators",
                            },
                        },
                    ],
                },
                {
                    path: "/admin/tour-management",
                    children: [
                        {
                            path: "destinations_list",
                            name: "destination-list",
                            component: Destination,
                            meta: {
                                requiresAuth: true,
                                title: "Destination List",
                                permission: "view customers",
                            },
                        },
                        {
                            path: "tours_list",
                            name: "tours-list",
                            component: Tours,
                            meta: {
                                requiresAuth: true,
                                title: "Tours List",
                                permission: "view operators",
                            },
                        },
                        {
                            path: "bookings_list",
                            name: "bookings-list",
                            component: Bookings,
                            meta: {
                                requiresAuth: true,
                                title: "Booking List",
                                permission: "view operators",
                            },
                        },
                    ],
                },
                {
                    path: "/admin/globals",
                    children: [
                        {
                            path: "roles-and-permissions",
                            name: "roles-and-permissions",
                            component: RolesAndPermissions,
                            meta: {
                                requiresAuth: true,
                                title: "Roles and Permissions",
                                permission: "view roles",
                            },
                        },
                       
                    ],
                },
            ],
        },
        {
            path: "/admin/home",
            component: Auth,
            children: [
                {
                    path: "admin_login",
                    name: "admin_login",
                    component: Login,
                    beforeEnter: checkGuest,
                },
                {
                    path: "admin_forgot-password",
                    name: "admin_forgot-password",
                    component: ForgotPassword,
                    beforeEnter: checkGuest,
                },
                {
                    path: "admin_reset-password",
                    name: "admin_reset-password",
                    component: ResetPassword,
                    beforeEnter: checkGuest,
                },
            ],
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: NotFound,
        },
        {
            // user auth routes
            path: "/user",
            component: UserAuth,
            children: [
                {
                    path: "login",
                    name: "login",
                    component: UserLogin,
                    beforeEnter: checkGuest,
                },
                {
                    path: "register",
                    name: "register",
                    component: UserRegister,
                    beforeEnter: checkGuest,
                },
                {
                    path: "forgot-password",
                    name: "forgot-password",
                    component: UserForgotPassword,
                    beforeEnter: checkGuest,
                },
                {
                    path: "reset-password",
                    name: "reset-password",
                    component: UserSetPassword,
                    beforeEnter: checkGuest,
                },
                {
                    path: 'verify-user',
                    name: 'verify-user',
                    component: VerifyUserAccount,
                    beforeEnter: checkGuest,
                }
            ],
        },
        //un-authorized user/customer routes
        {
            path: "/",
            component: UserMain,
            children: [
                {
                    path: "/",
                    name: "tours",
                    component: TourPage,
                },
                {
                    path: "/tours/:destination/:tour_id",
                    name: "tours_details",
                    component: Tour_details,  
                },
                {
                    path: "/my_bookings",
                    name: "my-booking-list",
                    component: My_bookings,
                    meta: {
                        requiresUserAuth: true,
                        title: "My Tour Bookings",
                       
                    },
                },
            ]
        }
    ],
});

router.beforeEach((to, from) => {

    const { authUser, permissions } = useAuthStore();
    const { user } = useUserStore();
    if (to.meta.requiresAuth && (!authUser)) {
        return {
            name: "login",
        };
    }
    if (to.meta.requiresUserAuth && (!user)) {
        return {
            name: "tours",
        };
    }
    if (to.meta.permission && !permissions.includes(to.meta.permission)) {

        return {
            name: "home",
        };
    }
});
export default router;
