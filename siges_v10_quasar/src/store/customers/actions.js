import axios from 'axios';
import { CONFIG } from '../../config';
  
export function actCustomersAll (context) {
    return axios.get(CONFIG.api_url + '/customers')
        .then((response) => {
            context.commit('MUT_CUSTOMERS_LIST', response.data.data || []);
            context.commit('MUT_CUSTOMERS_TOTAL');
        })
        .catch(errors => {
            console.log('errors: ', errors.response);
        });
        
}

export function actCustomerAdd (context, customer) {
    context.commit('MUT_CUSTOMER_ADD', customer);
}
