import { UserService, AuthenticationError } from '../services/user.service'
import { TokenService } from '../services/storage.service'
import router from '../router'


const state =  {
    authenticating: false,
    userInfo: TokenService.getUserInfo(),
    userInfoError: '',
    userInfoErrorCode: 0,
    accessToken: TokenService.getToken(),
    authenticationErrorCode: 0,
    authenticationError: ''
};

const getters = {
    loggedIn: (state) => {
        return state.accessToken ? true : false
    },

    authenticationErrorCode: (state) => {
        return state.authenticationErrorCode
    },

    authenticationError: (state) => {
        return state.authenticationError
    },

    userInfo: (state) => {
        return state.userInfo;
    },

    userInfoErrorCode: (state) => {
        return state.userInfoErrorCode
    },

    userInfoError: (state) => {
        return state.userInfoError
    },

    authenticating: (state) => {
        return state.authenticating
    }
};

const actions = {
    async login({ commit }, {email, password}) {
        commit('loginRequest');

        try {
            const token = await UserService.login(email, password);
            commit('loginSuccess', token)

            // Redirect the user to the page he first tried to visit or to the home view
            router.push(router.history.current.query.redirect || '/');

            return true
        } catch (e) {
            if (e instanceof AuthenticationError) {
                commit('loginError', {errorCode: e.errorCode, errorMessage: e.message})
            }

            return false
        }
    },

    refreshToken({ commit, state }) {
        // If this is the first time the refreshToken has been called, make a request
        // otherwise return the same promise to the caller
        if(!state.refreshTokenPromise) {
            let p = UserService.refreshToken()
            commit('refreshTokenPromise', p)
            // Wait for the UserService.refreshToken() to resolve. On success set the token and clear promise
            // Clear the promise on error as well.
            p.then(
                response => {
                    commit('refreshTokenPromise', null)
                    commit('loginSuccess', response)
                },
                () => {
                    commit('refreshTokenPromise', null)
                }
            )
        }
        return state.refreshTokenPromise
    },

    async userInfo({ commit, state }) {
        if(state.accessToken) {
            commit('userInfoRequest')
            try {
                let userInfo = await UserService.userInfo();
                commit('userInfoSuccess', userInfo)

                return userInfo
            } catch (e) {
                if (e instanceof AuthenticationError) {
                    commit('userInfoError', {errorCode: e.errorCode, errorMessage: e.message})
                }

                return null
            }
        }
        return null;
    },

    logout({ commit }) {
        UserService.logout()
        commit('logoutSuccess')
        router.push('/login')
    }
};

const mutations = {
    userInfoRequest(state) {
        state.userInfo = null;
    },

    userInfoSuccess(state, userInfo) {
        state.userInfo = userInfo;
    },

    userInfoError(state, {errorCode, errorMessage}) {
        state.userInfoErrorCode = errorCode;
        state.userInfoError = errorMessage
    },

    loginRequest(state) {
        state.authenticating = true;
        state.authenticationError = '';
        state.authenticationErrorCode = 0
    },

    loginSuccess(state, accessToken) {
        state.accessToken = accessToken;
        state.authenticating = false;
    },

    loginError(state, {errorCode, errorMessage}) {
        state.authenticating = false;
        state.authenticationErrorCode = errorCode;
        state.authenticationError = errorMessage
    },

    logoutSuccess(state) {
        state.accessToken = ''
    },

    refreshTokenPromise(state, promise) {
        state.refreshTokenPromise = promise
    }
};

export const auth = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};