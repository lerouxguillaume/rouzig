import Home from "./pages/Home";
import NotFound from "./pages/NotFound";
import Vue from 'vue'
import VueRouter from "vue-router";
import MenuPage from "./pages/MenuPage";
import ReviewWord from "./pages/ReviewWord";
import AddTranslation from "./pages/AddTranslation";
import Register from "./pages/Security/Register";
import Activate from "./pages/Security/Activate";
import ResetPassword from "./pages/Security/ResetPassword";
import NewPassword from "./pages/Security/NewPassword";
import i18n from "./i18n";
import {Trans} from "./plugin/Trans";
import NestedRouterView from "./components/NestedRouterView";

Vue.use(VueRouter);

const router =  new VueRouter({
    routes: [
        {
            path: '/:lang',
            component: NestedRouterView,
            children: [
                {
                    path: '',
                    name: 'homepage',
                    component: Home,
                    meta: {
                        title: 'title.homepage.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.homepage.name',
                                content: 'title.homepage.content'
                            },
                        ]
                    }
                },
                {
                    path: 'add-translation/:word?',
                    name: 'AddTranslation',
                    component: AddTranslation,
                    meta: {
                        title: 'title.add_translation.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.add_translation.name',
                                content: 'title.add_translation.content'
                            },
                        ]
                    }
                },
                {
                    path: 'menu-page',
                    name: 'MenuPage',
                    component: MenuPage,
                    meta: {
                        title: 'title.menu.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.menu.name',
                                content: 'title.menu.content'
                            },
                        ]
                    }
                },
                {
                    path: 'review-word/:id',
                    name: 'ReviewWord',
                    component: ReviewWord,
                    meta: {
                        title: 'title.review.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.review.name',
                                content: 'title.review.content'
                            },
                        ]
                    }
                },
                {
                    path: 'register',
                    name: 'Register',
                    component: Register,
                    meta: {
                        title: 'title.register.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.register.name',
                                content: 'title.register.content'
                            },
                        ]
                    }
                },
                {
                    path: 'activate',
                    name: 'Activate',
                    component: Activate,
                    meta: {
                        title: 'title.activate_account.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.activate_account.name',
                                content: 'title.activate_account.content'
                            },
                        ]
                    }
                },
                {
                    path: 'reset-password',
                    name: 'ResetPassword',
                    component: ResetPassword,
                    meta: {
                        title: 'title.reset_password.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.reset_password.name',
                                content: 'title.reset_password.content'
                            },
                        ]
                    }
                },
                {
                    path: 'new-password',
                    name: 'NewPassword',
                    component: NewPassword,
                    meta: {
                        title: 'title.new_password.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.new_password.name',
                                content: 'title.new_password.content'
                            },
                        ]
                    }
                },
                {
                    path: '*', name: 'not_found',
                    component: NotFound,
                    meta: {
                        title: 'title.page_not_found.title',
                        public: true,  // Allow access to even if not logged in
                        metaTags: [
                            {
                                name: 'title.page_not_found.name',
                                content: 'title.page_not_found.content'
                            },
                        ]
                    }
                },
            ]
        }
    ]
});

router.beforeEach((to, from, next) => {
    let lang = to.params.lang
    if (typeof lang === "undefined" || !Trans.isLangSupported(lang)) {
        lang = Trans.currentLanguage;
        to.params.lang = lang;
    } else {
        Trans.currentLanguage = lang;
    }

    // Load async message files here
    // This goes through the matched routes from last to first, finding the closest route with a title.
    // eg. if we have /sme/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

    // Find the nearest route element with meta tags.
    const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

    // If a route with a title was found, set the document (page) title to that value.
    if(nearestWithTitle) document.title = i18n.t(nearestWithTitle.meta.title);

    // Remove any stale meta tags from the document using the key attribute we set below.
    Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

    // Skip rendering meta tags if there are none.
    if(nearestWithMeta) {
        // Turn the meta tag definitions into actual elements in the head.
        nearestWithMeta.meta.metaTags.map(tagDef => {
            const tag = document.createElement('meta');
            Object.keys(tagDef).forEach(key => {
                tag.setAttribute(key, i18n.t(tagDef[key]));
            });

            // We use this to track which meta tags we create, so we don't interfere with other ones.
            tag.setAttribute('data-vue-router-controlled', '');

            return tag;
        })
            // Add the meta tags to the document head.
            .forEach(tag => document.head.appendChild(tag));

    }
    next();
});

export default router;
