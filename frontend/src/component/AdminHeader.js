import React from "react";
import { Link } from "react-router-dom";

export default function AdminHeader() {
  // get user login information from global state
  const userLoginInfo = true;
  const logoutUser = () => {};
  return (
    <div>
      <Link to="/">Login</Link>
      <span> | </span>
      {userLoginInfo ? (
        <p onClick={logoutUser}>Logout</p>
      ) : (
        <Link to="/login">Login</Link>
      )}
      {userLoginInfo && <p>Hello {userLoginInfo.name}</p>}
    </div>
  );
}
