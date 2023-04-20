// import { checkAccessToken } from "../../helpers/checkEXPToken";
import { getDateTime } from "../../helpers/checkEXPToken";
import { authServices } from "../../services/authService";
import {
  LOGIN_ERROR,
  LOGIN_START,
  LOGIN_SUCCESS,
  LOGOUT_SUCCESS,
} from "../types/authType";

// login action
export const loginAction = (loginData, navigate) => {
  return async (dispatch) => {
    try {
      const res = await authServices.signin(loginData);
      //   console.log("🚀 ~ file: authActions.js:15 ~ return ~ res:", res.data);
      if (res.data.statusCode === 200) {
        const authInformation = {
          name: "Admin",
          email: "admin@gmail.com",
          access_token: res.data.access_token,
          access_token_exp: res.data.access_token_exp,
          refresh_token: res.data.refresh_token,
          refresh_token_exp: res.data.refresh_token_exp,
        };
        dispatch(loginSuccess(authInformation));
        return navigate("/admin");
      } else {
        alert(res.data.message);
        dispatch(loginFailed());
      }
    } catch (e) {
      dispatch(loginFailed());
    }
  };
};
export const loginStart = () => {
  return {
    type: LOGIN_START,
  };
};
export const loginSuccess = (payload) => {
  return {
    type: LOGIN_SUCCESS,
    payload,
  };
};
export const loginFailed = () => {
  return {
    type: LOGIN_ERROR,
  };
};
// logout
export const logoutAction = (currentUser, navigate) => {
  return async (dispatch) => {
    try {
      console.log("current user loggout: ", currentUser);
      if (currentUser.access_token_exp > getDateTime()) {
        await authServices.logout(
          currentUser.refresh_token,
          currentUser.access_token
        );
        await authServices.deleteRefreshToken(currentUser.refresh_token);
        localStorage.clear();
        dispatch(logoutSuccess());
        navigate("/login");
      } else {
        await authServices.deleteRefreshToken(currentUser.refresh_token);
        localStorage.clear();
        dispatch(logoutSuccess());
        navigate("/login");
      }
    } catch (e) {}
  };
};
export const logoutSuccess = () => {
  return {
    type: LOGOUT_SUCCESS,
  };
};
