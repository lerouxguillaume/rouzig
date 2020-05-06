import Home from "./pages/Home";
import NotFound from "./pages/NotFound";
import Vue from 'vue'
import VueRouter from "vue-router";
import {TokenService} from "../services/storage.service";
import MenuPage from "./pages/MenuPage";
import ReviewWord from "./pages/ReviewWord";
import AddTranslation from "./pages/AddTranslation";
import Register from "./pages/Security/Register";
import Activate from "./pages/Security/Activate";
import ResetPassword from "./pages/Security/ResetPassword";
import NewPassword from "./pages/Security/NewPassword";

Vue.use(VueRouter);

const router =  new VueRouter({
    routes: [
        {
            path: '/',
            name: 'homepage',
            component: Home,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '/add-translation/:word?',
            name: 'AddTranslation',
            component: AddTranslation,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '/menu-page',
            name: 'MenuPage',
            component: MenuPage,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '/review-word/:id',
            name: 'ReviewWord',
            component: ReviewWord,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '/activate',
            name: 'Activate',
            component: Activate,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '/reset-password',
            name: 'ResetPassword',
            component: ResetPassword,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '/new-password',
            name: 'NewPassword',
            component: NewPassword,
            meta: {
                public: true,  // Allow access to even if not logged in
            }
        },
        {
            path: '*', name: 'not_found',
            component: NotFound
        },
    ]
});

router.beforeEach((to, from, next) => {
    const isPublic = to.matched.some(record => record.meta.public)
    const loggedIn = !!TokenService.getToken();

    if (!isPublic && !loggedIn) {
        return; //@FIXME : open login modal
    }

    next();
})


export default router;
