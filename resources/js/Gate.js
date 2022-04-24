export default class Gate {
    constructor(user) {
        this.user = user;
    }

    getUserID() {
        return this.user.id;
    }

    getEmployeeID() {
        return this.user.employee_id;
    }

    isAdmin() {
        return this.user.role.name === "Admin";
    }

    // isUser() {
    //     return this.user.role.name === "User";
    // }

    // isAdminOrUser() {
    //     if (this.user.type === "user" || this.user.type === "admin") {
    //         return true;
    //     }
    // }
}
