import VueRouter from 'vue-router';


let routes = [
    {
        path: '/dashboard',
        component: require('./views/dashboard').default
    },
    {
        path: '/users',
        component: require('./views/users').default
    },
    {
        path: '/clients',
        component: require('./views/clients').default
    },
    {
        path: '/matriculas',
        component: require('./views/matriculas').default
    },
    {
        path: '/logs',
        component: require('./views/logs').default
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
    linkActiveClass: 'active'
});
