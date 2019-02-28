import axios from 'axios';
import { CONFIG } from '../../config';
  
export function actUsersAll (context) {
    return axios.get(CONFIG.api_url + '/users')
        .then((response) => {
            context.commit('MUT_USERS_LIST', response.data.data || []);
            context.commit('MUT_USERS_TOTAL');
        })
        .catch(errors => {
            console.log('errors: ', errors.response);
        });
        
}

export function actUserAdd (context, user) {
    context.commit('MUT_USER_ADD', user);
}