export function MUT_MATERIALS_SEARCH (state, materials) {
  state.search = materials;
}

export function MUT_MATERIALS_LIST (state, materials) {
  console.log("MUT_MATERIALS: ", materials);
  state.materials = materials;
}

export function MUT_MATERIALS_TOTAL (state) {
  state.total = state.materials.length;
}

export function MUT_MATERIAL_ADD (state, material) {
  state.materials.push(material);
}

export function MUT_MATERIAL_DESTROY (state, material) {
  state.materials.splice(material);
}