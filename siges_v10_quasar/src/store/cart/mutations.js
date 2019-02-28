export function MUT_CART_ITEM_ADD (state, data) {
    
    let found = state.cart.items.find(item => { 
        return item.materialId === data.materialId && item.warehouseId === data.warehouseId
    });

    if (found) {
        found.qty ++;
    } else {
        state.cart.items.push(data);
    }

    state.cart.itemsTotal = state.cart.items.length; 
}

export function MUT_CART_ITEM_DEL (state, data) {
    
    let found = state.cart.items.find(item => { 
        return item.materialId === data.materialId && item.warehouseId === data.warehouseId
    });

    if (found) {
        found.qty --;
    }

    state.cart.itemsTotal = state.cart.items.length; 
}
