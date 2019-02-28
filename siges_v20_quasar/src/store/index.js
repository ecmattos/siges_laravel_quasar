import Vue from 'vue';
import Vuex from 'vuex';

import auth from './auth';
import materials from './materials';
import plans from './plans';
import customers from './customers';
import orders from './orders';
import providers from './providers';
import cart from './cart';
import users from './users';
import employees from './employees';

Vue.use(Vuex);

export default function () {
  const Store = new Vuex.Store({
    modules: {
      auth,
      materials,
      plans,
      customers,
      orders,
      providers,
      cart, 
      users,
      employees
    }
  });

  return Store;
}
