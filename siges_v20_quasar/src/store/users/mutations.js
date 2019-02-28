export function MUT_USERS_LIST (state, users) {
    console.log("MUT_USERS: ", users);
    state.users = users;
}

export function MUT_USERS_TOTAL (state) {
    state.total = state.users.length;;
}

export function MUT_USER_ADD (state, user) {
    state.users.push(user);
}