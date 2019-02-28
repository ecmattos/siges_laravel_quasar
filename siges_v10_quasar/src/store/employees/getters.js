export function getEmployees (state) {
    return state.employees;
}

export const getEmployeeById = (state) => (index) => {
    //console.log('index: ', index);
    let employee_id = Number(index);
    //console.log('number_employee_id: ', employee_id);
    return state.employees.find(employee => employee.id === employee_id);
}

export function getEmployeesTotal (state) {
    return state.total;
}
