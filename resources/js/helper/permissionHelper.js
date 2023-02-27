
export const hasPermission = (permission) => {
    let user = JSON.parse(window.localStorage.getItem('auth')),
        allPermissions = user.permissions;
    return allPermissions.includes(permission);
}
export const isAuthUser = () => {
    return !!JSON.parse(window.localStorage.getItem('auth'));
}
