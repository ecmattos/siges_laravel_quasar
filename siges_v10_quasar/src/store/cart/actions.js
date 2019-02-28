export function actCartItemAdd (context, [ material_id, warehouse_id ]) {
    context.commit('MUT_CART_ITEM_ADD', { materialId: material_id, warehouseId: warehouse_id, qty: 1 });
}

export function actCartItemDel (context, [ material_id, warehouse_id ]) {
    context.commit('MUT_CART_ITEM_DEL', { materialId: material_id, warehouseId: warehouse_id, qty: 1 });
}