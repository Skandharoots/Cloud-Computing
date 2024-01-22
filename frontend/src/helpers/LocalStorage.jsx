class LocalStorage {
    
    static IsUserLogged() {
        LocalStorage.ActiveCheck();

        return localStorage.getItem('userUuid') != null || localStorage.getItem('userUuid') != undefined;
    }

    static GetActiveUser() {
        LocalStorage.ActiveCheck();

        return localStorage.getItem('userUuid');
    }

    static ActiveCheck() {
        let validUntil = new Date(parseInt(localStorage.getItem('authValidUntil'), 10));
        let now = Date.now();

        if (localStorage.getItem('authValidUntil') && validUntil - now < 0) {
            LocalStorage.LogoutUser();
            window.location.href = '/login'; return;
        }
    }

    static SetActiveUser(userUuid) {
        localStorage.setItem('userUuid', userUuid);
        localStorage.setItem('authValidUntil', Date.now() + (2 * 60 * 60 * 1000)); // 2 hours
    }

    static LogoutUser() {
        localStorage.removeItem("userUuid");
        localStorage.removeItem("authValidUntil");
    }

}

export default LocalStorage;