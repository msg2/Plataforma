import VueRouter from 'vue-router';


let routes = [
    {
        path: '/dashboard',
        component: require('./views/dashboard').default
    },
    {
        path: '/users',
        component: require('./views/users').default,
        meta : {requiresAdmin : true}
    },
    {
        path: '/clients',
        component: require('./views/clients').default,
        meta : {requiresAdmin : true}
    },
    {
        path: '/matriculas',
        component: require('./views/matriculas').default,
        meta : {requiresUser : true}
    },
    {
        path: '/qrcodes',
        component: require('./views/qrcodes').default,
        meta : {requiresUser : true}
    },
    {
        path: '/logs',
        component: require('./views/logs').default,
        meta : {requiresUser : true}
    },
    {
        path: '/home',
        component: require('./views/dashboard').default
    },
    {
        path: '/',
        component: require('./views/dashboard').default
    },
    {
        path: '/*',
        component: require('./views/notfound').default
    }

];


export default new VueRouter({
    base: '/',
    mode: 'history',
    routes,
    linkActiveClass: 'active',
});
