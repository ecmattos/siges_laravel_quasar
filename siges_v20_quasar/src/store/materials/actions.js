import axios from 'axios';
import { CONFIG } from '../../config';
  
export function actMaterialsAll (context) {
  return axios.get(CONFIG.api_url + '/materials')
    .then((response) => {
      //console.log("api_materials: ", response.data.data);
      context.commit('MUT_MATERIALS_LIST', response.data.data || []);
      context.commit('MUT_MATERIALS_TOTAL');
    })
    .catch(errors => {
      console.log('errors: ', errors.response);
    });
}

export function actMaterialAdd (context, material) {
  context.commit('MUT_MATERIAL_ADD', material);

  console.log('DATA:', material)
  axios.post(CONFIG.api_url + '/materials', material)
    .then((response) => {
      console.log(response)
      context.commit('MATERIAL_SAVE', material)
    })
    .catch((error) => {
      //console.log(error.response.data)
    })
}

export function actMaterialsSearchCode (context, search) {
  context.commit('MUT_MATERIALS_SEARCH', response.data.material || []);
}

export function actMaterialsSearchDescription (context, materials) {  
  console.log('actMaterials: ', materials);
  context.commit('MUT_MATERIALS_SEARCH', materials || []);
}

export function materialDestroy (context, id) {
  axios.get(CONFIG.api_url + '/materials/' + id + '/destroy')
    .then((response) => {
      //console.log(response.data.data)
      context.commit('MATERIAL_DESTROY', id)
      this.$router.push('/materials')
    })
}
