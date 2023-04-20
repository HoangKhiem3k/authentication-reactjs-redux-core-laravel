//LoginPage -> dispatch(loginAction) -> call api login bằng axios thuần
//-> set thông tin login vào 1 object -> dispatch(loginSuccess(data)) để lưu thông tin vào global state
//-> tạo custom hook useAxios
// ko set token vào localStorage mà lưu vào global state (persist tự lưu vào localStorage) để hook useAxios lấy bằng useSelector
import axios from "axios";
import { getDateTime } from "../helpers/checkEXPToken";
import { useDispatch, useSelector } from "react-redux";
import { loginSuccess } from "../store/actions/authActions";
import { useNavigate } from "react-router-dom";
import { logoutAction } from "../store/actions/authActions";
const baseURL = "http://127.0.0.1:8000";
const useAxios = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const currentUser = useSelector((state) => state.auth?.currentUser);
  const axiosInstance = axios.create({
    baseURL,
    headers: { Authorization: `Bearer ${currentUser?.access_token}` },
  });

  axiosInstance.interceptors.request.use(
    async (req) => {
      console.log("current time:", getDateTime());
      console.log("access_token_exp", currentUser.access_token_exp);
      console.log("refresh_token_exp", currentUser.refresh_token_exp);

      if (currentUser.access_token_exp <= getDateTime()) {
        if (currentUser.refresh_token_exp > getDateTime()) {
          const response = await axios.post(`${baseURL}/api/refresh-token`, {
            refresh_token: currentUser.refresh_token,
          });
          const refreshUser = {
            ...currentUser,
            access_token: response.data.access_token,
            access_token_exp: response.data.access_token_exp,
          };
          dispatch(loginSuccess(refreshUser));
          console.log("current user after dispatch", currentUser);
          req.headers.Authorization = `Bearer ${response.data.access_token}`;
          return req;
        } else {
          dispatch(logoutAction(currentUser, navigate));
          return req;
        }
      } else {
        return req;
      }
    },
    (err) => {
      return Promise.reject(err);
    }
  );
  return axiosInstance;
};
export default useAxios;
