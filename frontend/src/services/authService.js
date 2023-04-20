import axios from "axios";

const BACKEND_DOMAIN = "http://127.0.0.1:8000";
export const authServices = {
  signin: (data) => {
    return axios({
      url: `${BACKEND_DOMAIN}/api/login`,
      method: "POST",
      data,
    });
  },
  getUserInfor: (api) => {
    let res = api.get("api/profile");
    return res;
  },
  logout: (refresh_token, access_token) => {
    return axios({
      method: "POST",
      url: `${BACKEND_DOMAIN}/api/logout`,
      data: refresh_token,
      headers: {
        Authorization: `Bearer ${access_token}`,
      },
    });
  },
  deleteRefreshToken: (refresh_token) => {
    const refreshToken = {
      refresh_token: refresh_token,
    };
    return axios({
      method: "POST",
      url: `${BACKEND_DOMAIN}/api/delete-refresh-token`,
      data: refreshToken,
    });
  },
  refreshAccessToken: () => {
    const refreshToken = {
      refresh_token: localStorage.getItem("refresh_token"),
    };
    return axios({
      method: "POST",
      url: `${BACKEND_DOMAIN}/refresh-token`,
      data: refreshToken,
    });
  },
};
