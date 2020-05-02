import Home from "./pages/Home";
import NotFound from "./pages/NotFound";
import Vue from 'vue'
import VueRouter from "vue-router";
import {TokenService} from "../services/storage.service";
import Login from "./pages/Security/Login";
import MenuPage from "./pages/MenuPage";
import ReviewWord from "./pages/ReviewWord";
import AddTranslation from "./pages/AddTranslation";

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
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                public: true,  // Allow access to even if not logged in
                onlyWhenLoggedOut: true
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
    const onlyWhenLoggedOut = to.matched.some(record => record.meta.onlyWhenLoggedOut)
    const loggedIn = !!TokenService.getToken();

    if (!isPublic && !loggedIn) {
        return next({
            path:'/login',
            query: {redirect: to.fullPath}  // Store the full path to redirect the user to after login
        });
    }

    // Do not allow user to visit login page or register page if they are logged in
    if (loggedIn && onlyWhenLoggedOut) {
        return next('/')
    }

    next();
})


export default router;
