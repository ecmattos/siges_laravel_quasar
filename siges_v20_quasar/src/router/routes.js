
const routes = [
  {
    path: '/',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Login.vue') }
    ]
  },
  {
    path: '/login',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Login.vue') }
    ]
  },
  {
    path: '/register',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Register.vue') }
    ]
  },
  {
    path: '/userAdminRegister',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/UserAdminRegister.vue') }
    ]
  },
  {
    path: '/recovery',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Recovery.vue') }
    ]
  },
  {
    path: '/reset',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Reset.vue') }
    ]
  },
  {
    path: '/dashboard',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Dashboard.vue') }
    ]
  },
  {
    path: '/materials',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/materials/Search.vue') }
    ]
  },
  {
    path: '/materials/new',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/materials/New.vue') }
    ]
  },
  {
    path: '/materials/:id',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/materials/Show.vue') }
    ]
  },
  {
    path: '/plans',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/plans/List.vue') }
    ]
  },
  {
    path: '/signup',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/clients/SignUp.vue') }
    ]
  },
  {
    path: '/customers',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/customers/List.vue') }
    ]
  },
  {
    path: '/customers/new',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/customers/New.vue') }
    ]
  },
  {
    path: '/customers/:id',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/customers/Show.vue') }
    ]
  },
  {
    path: '/employees',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/employees/List.vue') }
    ]
  },
  {
    path: '/employees/new',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/employees/New.vue') }
    ]
  },
  {
    path: '/employees/:id',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/employees/Show.vue') }
    ]
  },
  {
    path: '/orders/new',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/orders/New.vue') }
    ]
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
