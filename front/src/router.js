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
import i18n from "./i18n";
import NestedRouterView from "./components/NestedRouterView";

Vue.use(VueRouter);

const router =  new VueRouter({
    routes: [
        {
            path: '/:lang?/',
            component: NestedRouterView,
            children: [
                {
                    path: '/',
                    name: 'homepage',
                    component: Home,
                    meta: {
                        title: i18n.t('title.homepage.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.homepage.name'),
                                content: i18n.t('title.homepage.content')
                            },
                        ]
                    }
                },
                {
                    path: '/add-translation/:word?',
                    name: 'AddTranslation',
                    component: AddTranslation,
                    meta: {
                        title: i18n.t('title.add_translation.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.add_translation.name'),
                                content: i18n.t('title.add_translation.content')
                            },
                        ]
                    }
                },
                {
                    path: '/menu-page',
                    name: 'MenuPage',
                    component: MenuPage,
                    meta: {
                        title: i18n.t('title.menu.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.menu.name'),
                                content: i18n.t('title.menu.content')
                            },
                        ]
                    }
                },
                {
                    path: '/review-word/:id',
                    name: 'ReviewWord',
                    component: ReviewWord,
                    meta: {
                        title: i18n.t('title.review.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.review.name'),
                                content: i18n.t('title.review.content')
                            },
                        ]
                    }
                },
                {
                    path: '/register',
                    name: 'Register',
                    component: Register,
                    meta: {
                        title: i18n.t('title.register.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.register.name'),
                                content: i18n.t('title.register.content')
                            },
                        ]
                    }
                },
                {
                    path: '/activate',
                    name: 'Activate',
                    component: Activate,
                    meta: {
                        title: i18n.t('title.activate_account.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.activate_account.name'),
                                content: i18n.t('title.activate_account.content')
                            },
                        ]
                    }
                },
                {
                    path: '/reset-password',
                    name: 'ResetPassword',
                    component: ResetPassword,
                    meta: {
                        title: i18n.t('title.reset_password.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.reset_password.name'),
                                content: i18n.t('title.reset_password.content')
                            },
                        ]
                    }
                },
                {
                    path: '/new-password',
                    name: 'NewPassword',
                    component: NewPassword,
                    meta: {
                        title: i18n.t('title.new_password.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.new_password.name'),
                                content: i18n.t('title.new_password.content')
                            },
                        ]
                    }
                },
                {
                    path: '*', name: 'not_found',
                    component: NotFound,
                    meta: {
                        title: i18n.t('title.page_not_found.title'),
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: i18n.t('title.page_not_found.name'),
                                content: i18n.t('title.page_not_found.content')
                            },
                        ]
                    }
                },
            ]
        }
    ]
});

router.beforeEach((to, from, next) => {
    const isPublic = to.matched.some(record => record.meta.public)
    const loggedIn = !!TokenService.getToken();

    if (!isPublic && !loggedIn) {
        // return; //@TODO : open login modal
    }
    // eslint-disable-next-line no-prototype-builtins
    if (!to.params.hasOwnProperty('lang')) {
        console.log(i18n.locale)
        next({
            ...to,
            params: {
                ...to.params,
                lang: i18n.locale
            }
        })
    } else {
        next()
    }
})


export default router;
