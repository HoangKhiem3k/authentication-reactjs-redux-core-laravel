import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import useAxios from "../../utils/useAxios";
import { logoutAction } from "../../store/actions/authActions";
import { useNavigate } from "react-router-dom";
import { authServices } from "../../services/authService";

function Admin() {
  let api = useAxios();
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const currentUser = useSelector((state) => state.auth?.currentUser);
  let [userInformation, setUserInformation] = useState(null);
  useEffect(() => {
    getUserInformation();
  }, []);
  const logoutUser = () => {
    dispatch(logoutAction(currentUser, navigate));
  };
  const getUserInformation = async () => {
    let res = await authServices.getUserInfor(api);
    if (res.data.statusCode === 200) {
      setUserInformation(res.data.content);
    }
  };
  return (
    <div>
      <h1>This is the Admin page</h1>
      <h2>Welcome {userInformation?.userProfile.first_name}</h2>
      <button type="button" onClick={logoutUser}>
        Logout
      </button>
    </div>
  );
}

export default Admin;
