import Vue from "vue";
import Router from 'vue-router';
import App from "../layouts/App";

Vue.use(Router);

const router = new Router({
    mode: 'history', // to remove hash from URL
    routes: [
        { path: '/', name: 'Main', component: App },
    ]
});

export default router;
