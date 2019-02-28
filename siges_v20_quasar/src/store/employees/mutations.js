export function MUT_EMPLOYEES_LIST (state, employees) {
    console.log("MUT_COSTUMERS: ", employees);
    state.employees = employees;
}

export function MUT_EMPLOYEES_TOTAL (state) {
    state.total = state.employees.length;;
}

export function MUT_EMPLOYEE_ADD (state, employee) {
    state.employees.push(employee);
}
