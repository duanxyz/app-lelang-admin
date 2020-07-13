import Vue from 'vue';
import Router from 'vue-router';

/**
 * Layzloading will create many files and slow on compiling, so best not to use lazyloading on devlopment.
 * The syntax is lazyloading, but we convert to proper require() with babel-plugin-syntax-dynamic-import
 * @see https://doc.laravue.dev/guide/advanced/lazy-loading.html
 */

Vue.use(Router);

/* Layout */
import Layout from '@/layout';

/* Router for modules */
import adminRoutes from './modules/admin';

/**
 * Sub-menu only appear when children.length>=1
 * @see https://doc.laravue.dev/guide/essentials/router-and-nav.html
 **/

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    roles: ['admin', 'editor']   Visible for these roles only
    permissions: ['view menu zip', 'manage user'] Visible for these permissions only
    title: 'title'               the name show in sub-menu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if true, the page will no be cached(default is false)
    breadcrumb: false            if false, the item will hidden in breadcrumb (default is true)
    affix: true                  if true, the tag will affix in the tags-view
  }
**/

export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index'),
      },
    ],
  },
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true,
  },
  {
    path: '/auth-redirect',
    component: () => import('@/views/login/AuthRedirect'),
    hidden: true,
  },
  {
    path: '/404',
    redirect: { name: 'Page404' },
    component: () => import('@/views/error-page/404'),
    hidden: true,
  },
  {
    path: '/401',
    component: () => import('@/views/error-page/401'),
    hidden: true,
  },
  {
    path: '',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: 'dashboard',
        component: () => import('@/views/dashboard/index'),
        name: 'Dashboard',
        meta: { title: 'dashboard', icon: 'dashboard', noCache: false },
      },
    ],
  },
];

export const asyncRoutes = [
  {
    path: '/members',
    component: Layout,
    redirect: '/members/member-table',
    name: 'Member',
    meta: {
      title: 'Member',
      icon: 'peoples',
      permissions: ['view menu table'],
    },
    children: [
      {
        path: 'member-table',
        component: () => import('@/views/members/List'),
        name: 'MemberTable',
        meta: {
          title: 'Table Member', icon: 'peoples',
        },
      },
      {
        path: 'deposit-table',
        component: () => import('@/views/members/deposits/List'),
        name: 'DepositTable',
        meta: {
          title: 'Table Deposit', icon: 'deposit',
        },
      },
      {
        path: 'withdraw-table',
        component: () => import('@/views/members/withdraw/List'),
        name: 'WithdrawTable',
        meta: {
          title: 'Table Withdraw', icon: 'withdraw',
        },
      },
      {
        path: 'member/view/:id(\\d+)',
        component: () => import('@/views/members/MemberDetail'),
        name: 'MemberDetail',
        meta: { title: 'MemberDetail' },
        hidden: true,
      },
    ],
  },
  {
    path: '/items',
    component: Layout,
    redirect: '/items/barang-table',
    name: 'Barang',
    meta: {
      title: 'Barang',
      icon: 'item',
      permissions: ['view menu table'],
    },
    children: [
      {
        path: 'barang-table',
        component: () => import('@/views/items/List'),
        name: 'BarangTable',
        meta: {
          title: 'Table Barang', icon: 'item',
        },
      },
    ],
  },
  {
    path: '/auction',
    component: Layout,
    redirect: '/auction/Lelang-table',
    name: 'Lelang',
    meta: {
      title: 'Lelang',
      icon: 'auction',
      permissions: ['view menu table'],
    },
    children: [
      {
        path: 'lelang-table',
        component: () => import('@/views/auction/List'),
        name: 'LelangTable',
        meta: {
          title: 'Hasil Lelang', icon: 'auction',
        },
      },
    ],
  },
  // {
  //   path: '/reporting',
  //   component: Layout,
  //   redirect: '/reporting/Laporan-table',
  //   name: 'Lelang',
  //   meta: {
  //     title: 'Laporan',
  //     icon: 'reporting',
  //     permissions: ['view menu table'],
  //   },
  //   children: [
  //     {
  //       path: 'reporting-table',
  //       component: () => import('@/views/reporting/List'),
  //       name: 'LaporanTable',
  //       meta: {
  //         title: 'Laporan', icon: 'reporting',
  //       },
  //     },
  //   ],
  // },
  adminRoutes,
  { path: '*', redirect: '/404', hidden: true },
];

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  base: process.env.MIX_LARAVUE_PATH,
  routes: constantRoutes,
});

const router = createRouter();

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher; // reset router
}

export default router;
