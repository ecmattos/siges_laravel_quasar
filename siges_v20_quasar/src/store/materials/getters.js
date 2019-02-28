export function getMaterials (state) {
    return state.materials;
}

export function getMaterialsSearch (state) {
    return state.search;
}

export const getMaterialsSearchById = (state) => (index) => {
    //console.log('index: ', index);
    let material_id = Number(index);
    //console.log('number_material_id: ', material_id);
    return state.search.find(material => material.id === material_id);
}

export function getMaterialsTotal (state) {
    return state.total;
}
