export function MUT_CUSTOMERS_LIST (state, customers) {
    console.log("MUT_COSTUMERS: ", customers);
    state.customers = customers;
}

export function MUT_CUSTOMERS_TOTAL (state) {
    state.total = state.customers.length;;
}

export function MUT_CUSTOMER_ADD (state, customer) {
    state.customers.push(customer);
}