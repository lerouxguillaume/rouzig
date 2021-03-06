import ApiService from './api.service'
import { TokenService } from './storage.service'
import {User} from "../entities/User";

const clientId = process.env.VUE_APP_CLIENT_ID;
const clientSecret = process.env.VUE_APP_CLIENT_SECRET;
const tokenEndPoint = process.env.VUE_APP_API_TOKEN_ENDPOINT;
class AuthenticationError extends Error {
    constructor(errorCode, message) {
        super();
        this.name = this.constructor.name;
        this.message = message;
        this.errorCode = errorCode;
    }
}

const UserService = {
    /**
     * Login the user and store the access token to TokenService.
     *
     * @returns access_token
     * @throws AuthenticationError
     **/
    login: async function(email, password) {
        let loginData = new FormData();
        loginData.append("grant_type", 'password');
        loginData.append('username', email);
        loginData.append('password', password);

        const requestData = {
            method: 'post',
            url: tokenEndPoint,
            data: loginData,
            auth: {
                username: clientId,
                password: clientSecret
            }
        };

        try {
            const response = await ApiService.customRequest(requestData);
            TokenService.saveToken(response.data.access_token);
            TokenService.saveRefreshToken(response.data.refresh_token);
            ApiService.setHeader();

            ApiService.mount401Interceptor();

            await this.userInfo();

            return response.data.access_token
        } catch (error) {
            // eslint-disable-next-line no-console
            throw new AuthenticationError(error.response.status, error.response.data.detail)
        }
    },

    /**
     * Refresh the access token.
     **/
    refreshToken: async function() {
        const refreshToken = TokenService.getRefreshToken();
        let refreshTokenData = new FormData();
        refreshTokenData.append('grant_type', 'refresh_token');
        refreshTokenData.append('refresh_token', refreshToken);

        const requestData = {
            method: 'post',
            url: tokenEndPoint,
            data: refreshTokenData,
            auth: {
                username: clientId,
                password: clientSecret
            }
        };

        try {
            const response = await ApiService.customRequest(requestData);

            TokenService.saveToken(response.data.access_token);
            TokenService.saveRefreshToken(response.data.refresh_token);
            // Update the header in ApiService
            ApiService.setHeader();

            return response.data.access_token
        } catch (error) {
            throw new AuthenticationError(error.response.status, error.response.data.detail)
        }

    },

    userInfo: async function() {
        try {
            let params = {
                header: {
                    'accept' : 'application/hal+json'
                }
            }
            const response = await ApiService.get(process.env.VUE_APP_API_URL+'users/me', params);
            let user = new User();
            TokenService.saveUserInfo(user.load(response.data));

            return user;
        } catch (error) {
            // eslint-disable-next-line no-console
            throw new AuthenticationError(error.response.status, error.response.data.detail)
        }
    },

    /**
     * Logout the current user by removing the token from storage.
     *
     * Will also remove `Authorization Bearer <token>` header from future requests.
     **/
    logout() {
        // Remove the token and remove Authorization header from Api Service as well
        TokenService.removeToken();
        TokenService.removeRefreshToken();
        TokenService.removeUserInfo();
        ApiService.removeHeader();

        // NOTE: Again, we'll cover the 401 Interceptor a bit later.
        ApiService.unmount401Interceptor()
    }
};

export default UserService

export { UserService, AuthenticationError }