import axios from 'axios';
import { CONFIG } from '../../config';
  
export function actEmployeesAll (context) {
    return axios.get(CONFIG.api_url + '/employees')
        .then((response) => {
            context.commit('MUT_EMPLOYEES_LIST', response.data.data || []);
            context.commit('MUT_EMPLOYEES_TOTAL');
        })
        .catch(errors => {
            console.log('errors: ', errors.response);
        });
        
}

export function actEmployeeAdd (context, employee) {
    context.commit('MUT_EMPLOYEE_ADD', employee);
}
