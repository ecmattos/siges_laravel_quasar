export function getUsers (state) {
    return state.users;
}

export const getUserById = (state) => (index) => {
    //console.log('index: ', index);
    let user_id = Number(index);
    //console.log('number_user_id: ', user_id);
    return state.users.find(user => user.id === user_id);
}

export function getUsersTotal (state) {
    return state.total;
}
