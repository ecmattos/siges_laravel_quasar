export function getCustomers (state) {
    return state.customers;
}

export const getCustomerById = (state) => (index) => {
    //console.log('index: ', index);
    let customer_id = Number(index);
    //console.log('number_customer_id: ', customer_id);
    return state.customers.find(customer => customer.id === customer_id);
}

export function getCustomersTotal (state) {
    return state.total;
}