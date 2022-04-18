// const Home = () =>
//     import( /*webpackChunkName: "Dashboard" */ '../components/Dashboard/Home');

const Icon = () =>
    import( /*webpackChunkName: "Icon" */ '../components/Icon');
// const Dashboard = () =>
//     import( /*webpackChunkName: "Icon" */ '../components/Dashboard/Dashboard');
// const Orders = () =>
//     import( /*webpackChunkName: "Orders" */ '../components/Dashboard/Orders');

const default_routes = [
    // {
    //     path: '/',
    //     name: 'home',
    //     component: Home,
    //     redirect: {
    //         name: 'Dashboard'
    //     },
    //     meta: {
    //         title: 'Admin'
    //     },
    //     children: [
    //         {
    //             path: 'dashboard',
    //             name: 'Dashboard',
    //             component: Dashboard,
    //             meta: {
    //                 title: "Dashboard"
    //             }
    //         },
    //         {
    //             path: 'orders',
    //             name: 'Orders',
    //             component: Orders,
    //             meta: {
    //                 title: "Orders"
    //             }
    //         }
    //     ]
    // },
    {
        path: '/icon',
        name: 'Icon',
        component: Icon,
        meta: {
            title: "Icon"
        }
    }
    // {
    //     path: '/dashboard',
    //     name: 'Dashboard',
    //     component: Dashboard,
    //     meta: {
    //         title: "Dashboard"
    //     }
    // }
];

export default default_routes;
